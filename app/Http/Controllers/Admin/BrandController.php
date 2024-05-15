<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;
use Illuminate\Support\Str;

use Helper;

class BrandController extends Controller
{
    //
    use SupportTrait;
    private $type, $table, $config, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error, $folder_upload;
    private $routeShow = 'admin.brand.show';
    private $routeEdit = 'admin.brand.edit';
    private $viewShow = 'admin.templates.brand.man.brand'; // admin/templates/color/man/color.blade.php
    private $viewEdit = 'admin.templates.brand.man.brand_add'; // admin/templates/color/man/color_add.blade.php
    private $folder = "brand";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        $this->category = $request->category;
        $this->type = $request->type;
        $this->config = config('config_type.product');
        $this->folder_upload = config('config_upload.UPLOAD_BRAND');
        $this->page_error = redirect()->back();
        $this->permissionShow = 'product_man_brand_'.$this->type;
        $this->permissionAdd = 'product_add_brand_'.$this->type;
        $this->permissionEdit = 'product_edit_brand_'.$this->type;
        $this->permissionDelete = 'product_delete_brand_'.$this->type;
    }

    /*
    |--------------------------------------------------------------------------
    | Hiển thị danh sách dữ liệu : brand
    |--------------------------------------------------------------------------
    */
    public function Show(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);


        //### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }


        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $params = array();
        $params['keyword'] = ($request->keyword) ? $request->keyword : '';


        //### Code xử lý...
        $itemShow = $this->brandRepo->GetAllItems($type,$params,$this->relations,$this->pagination);

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'itemShow'=> $itemShow,
            'type'=> $type,
            'config'=>$this->config
        );
        return view($this->viewShow)->with($response);
    }

    /*
    |--------------------------------------------------------------------------
    | Hiển thị trang thêm - chỉnh sửa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Edit(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);


        //### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }


        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $id = $request->id;

        //### Code xử lý...
        $rowItem = $this->brandRepo->GetOneItem($id,$this->relations);

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'type'=> $type,
            'config'=>$this->config,
            'folder_upload'=>$this->folder
        );
        return view($this->viewEdit)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Lưu mới - cập nhật 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Save(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);


        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;
        $savehere = ($request->has('savehere'))?true:false;

        //### check auth permission
        if($id){
            if(!$this->IsPermission($this->permissionEdit)){
                $request->session()->flash('alert', $this->alert);
                return $this->page_error;
            }
        }else{
            if(!$this->IsPermission($this->permissionAdd)){
                $request->session()->flash('alert', $this->alert);
                return $this->page_error;
            }
        }

        $data = $request->data;
        $data['type'] = $type;
        $data['tenkhongdauvi'] = (isset($data['slugvi']) && $data['slugvi']!='') ? $data['slugvi'] : ((isset($data['tenvi'])) ? Str::slug($data['tenvi'], '-') : '');
        $data['tenkhongdauen'] = (isset($data['slugen']) && $data['slugen']!='') ? $data['slugen'] : ((isset($data['tenen'])) ? Str::slug($data['tenen'], '-') : '');

        $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;
		if($id){
			$data['ngaysua'] = time();
		}else{
			$data['ngaytao'] = $data['ngaysua'] = time();
		}

        $getimage='';
        if($request->hasFile('file')){
            $row = $this->brandRepo->GetOneItem($id,$this->relations);
            $oldimage = @$row['photo'];
            $newimage = $request->file('file');
            $folder = Helper::GetFolder($this->folder);
            if($newimage){ $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); }
        }

        if($request->hasFile('file2')){
            $row = $this->brandRepo->GetOneItem($id,$this->relations);
            $oldimage = $row['photo2'];
            $newimage = $request->file('file2');
            $folder = Helper::GetFolder($this->folder);
            if($newimage){ $data['photo2'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); }
        }

        //### Code xử lý...
        $row = $this->brandRepo->SaveItem($data,$id);

        //### Hiển thị giao diện
        if($savehere){
            return redirect()->route($this->routeEdit,[$category,$type,$row->id]);
        }else{
            return redirect()->route($this->routeShow,[$category,$type]);
        }
        
    }

    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Delete(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);


        //### check auth permission
        if(!$this->IsPermission($this->permissionDelete)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;

        $row = $this->brandRepo->GetOneItem($id,$this->relations);
        if($row['id']){
            $this->brandRepo->DeleteOneItem($id,$this->folder);
            $image_path = $this->folder.$row['photo'];
            Helper::DeleteImage($image_path);
            return redirect()->route($this->routeShow,[$category,$type]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa nhiều dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function DeleteAll(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);


        //### check auth permission
        if(!$this->IsPermission($this->permissionDelete)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;
        $listid = $request->listid;

        if($listid!=''){
            $ids = explode(",", $listid);
            foreach($ids as $i=>$item){
                $row = $this->brandRepo->GetOneItem($item,$this->relations);
                $image_path = $this->folder.$row['photo'];
                Helper::DeleteImage($image_path);
            }
            $this->brandRepo->DeleteMultiItem($listid,$this->folder);
        }

        return redirect()->route($this->routeShow,[$category,$type]);
    }
}
