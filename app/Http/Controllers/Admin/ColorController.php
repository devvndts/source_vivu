<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;

use Helper;

class ColorController extends Controller
{
    //
    use SupportTrait;
    private $type, $table, $config, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error, $folder_upload;
    private $routeShow = 'admin.color.show';
    private $routeEdit = 'admin.color.edit';
    private $viewShow = 'admin.templates.color.man.color'; // admin/templates/color/man/color.blade.php
    private $viewEdit = 'admin.templates.color.man.color_add'; // admin/templates/color/man/color_add.blade.php
    private $folder = "color";
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
        $this->folder_upload = config('config_upload.UPLOAD_COLOR');
        $this->page_error = redirect()->back();
        $this->permissionShow = 'product_man_mau_'.$this->type;
        $this->permissionAdd = 'product_add_mau_'.$this->type;
        $this->permissionEdit = 'product_edit_mau_'.$this->type;
        $this->permissionDelete = 'product_delete_mau_'.$this->type;
    }

    /*
    |--------------------------------------------------------------------------
    | Hiển thị danh sách dữ liệu : color
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
        $itemShow = $this->colorRepo->GetAllItems($type,$params,$this->relations,$this->pagination);

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
        $rowItem = $this->colorRepo->GetOneItem($id,$this->relations);

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
        $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;
		if($id){
			$data['ngaysua'] = time();
		}else{
			$data['ngaytao'] = $data['ngaysua'] = time();
		}

        $getimage='';
        if($request->hasFile('file')){
            $row = $this->colorRepo->GetOneItem($id,$this->relations);
            $oldimage = $row['photo'];
            $newimage = $request->file('file');
            $folder = Helper::GetFolder($this->folder);
            if($newimage){ $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); }
        }

        //### Code xử lý...
        $row = $this->colorRepo->SaveItem($data,$id);

        //### Hiển thị giao diện
        return redirect()->route($this->routeShow,[$category,$type]);
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

        $row = $this->colorRepo->GetOneItem($id,$this->relations);
        if($row['id']){
            $this->colorRepo->DeleteOneItem($id,$this->folder);
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
                $row = $this->colorRepo->GetOneItem($item,$this->relations);
                $image_path = $this->folder.$row['photo'];
                Helper::DeleteImage($image_path);
            }
            $this->colorRepo->DeleteMultiItem($listid,$this->folder);
        }

        return redirect()->route($this->routeShow,[$category,$type]);
    }
}
