<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;

use Helper, Thumb;

class DanhGiaController extends Controller
{
    //
    use SupportTrait;
    private $type, $table, $viewShow, $viewEdit, $config, $proParent, $modelSize, $modelColor, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error, $folder_upload;
    private $routeShow = 'admin.danhgia.show';
    private $routeEdit = 'admin.danhgia.edit';
    private $folder = "product";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        $this->category = $request->category;
        $this->type = $request->type;
        $this->viewShow = 'admin.templates.danhgia.man';
        $this->viewEdit = 'admin.templates.danhgia.add';

        //permission
        $this->page_error = redirect()->back();
        $this->permissionShow = 'danhgia_man_'.$this->type;
        $this->permissionAdd = 'danhgia_add_'.$this->type;
        $this->permissionEdit = 'danhgia_edit_'.$this->type;
        $this->permissionDelete = 'danhgia_delete_'.$this->type;

        $this->relations = $this->danhgiaRepo->GetRelationsRepo(); //['HasProduct'];
    }


    /*
    |--------------------------------------------------------------------------
    | Hiển thị danh sách dữ liệu tương ứng với category
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
        $type = '';

        $params = array();
        $idParent = 0;
        
        if($request->id_product){
            $params['id_product'] = $idParent = $request->id_product;
            // $params['duyettin'] = 1;
        }else{
            // $params['duyettin'] = 0;
        }
        $params['keyword'] = ($request->keyword) ? $request->keyword : '';        

        //### Code xử lý...
        $itemShow = $this->danhgiaRepo->GetAllItems($type,$params,$this->relationsOpt,$this->pagination);
        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'itemShow'=> $itemShow,
            'type'=> $type,
            'idParent'=>$idParent,
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
        //$category = $request->category;
        $id = $request->id;
        $type = $request->type;

        //### Code xử lý...
        $rowItem = $this->danhgiaRepo->GetOneItem($id);

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'type'=> $type,           
            'config'=>$this->config,
        );

        return view($this->viewEdit)->with($response);
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
        $idParent = ($request->id_product) ? $request->id_product : 0;

        $this->danhgiaRepo->DeleteOneItem($id);

        return redirect()->route($this->routeShow,[$category,$type,'id_product'=>$idParent]);
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
        $idParent = ($request->id_product) ? $request->id_product : 0;
        if($listid!=''){
            $this->danhgiaRepo->DeleteMultiItem($listid);
        }

        return redirect()->route($this->routeShow,[$category,$type,'id_product'=>$idParent]);
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
        $hash = $request->hash;
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
        $data['duyettin'] = (isset($data['duyettin'])) ? 1 : 0;

        if($id){
            $data['ngayduyet'] = time();
        }else{
            $data['ngaytao'] =  time();
        }

        //### Code xử lý...
        $row = $this->danhgiaRepo->SaveItem($data,$id);

        //### Hiển thị giao diện
        return redirect()->route($this->routeShow,[$category,'id_product'=>$row->id_product]);
        
    }
}
