<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use App\Http\Traits\SupportTrait;

use Helper;

class CouponController extends Controller
{
     //
    use SupportTrait;
    private $type, $table, $config, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error, $folder_upload;
    private $routeShow = 'admin.coupon.show';
    private $routeEdit = 'admin.coupon.edit';
    private $viewShow = 'admin.templates.coupon.show'; // admin/templates/color/man/color.blade.php
    private $viewEdit = 'admin.templates.coupon.add'; // admin/templates/color/man/color_add.blade.php
    private $folder = "";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        $this->category = $request->category;
        $this->type = $request->type;
        $this->page_error = redirect()->back();
        $this->permissionShow = 'coupon_man_'.$this->type;
        $this->permissionAdd = 'coupon_add_'.$this->type;
        $this->permissionEdit = 'coupon_edit_'.$this->type;
        $this->permissionDelete = 'coupon_delete_'.$this->type;
    }


    /*
    |--------------------------------------------------------------------------
    | Hiển thị dữ liệu
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
        $itemShow = $this->couponRepo->GetAllItems($type,$params,$this->relations,$this->pagination);

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
        $rowItem = $this->couponRepo->GetOneItem($id,$this->relations);
        $ma = Str::upper(Str::random(5));

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'type'=> $type,
            'ma' => $ma
        );
        return view($this->viewEdit)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Lưu dữ liệu
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

        if($data){
            foreach($data as $column => $value){
                $data[$column] = htmlspecialchars($value);
            }
            $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;
            $data['type'] = $type;
        }

        $data['mucgiam'] = (isset($data['mucgiam']) && $data['mucgiam'] != '') ? str_replace(",","",$data['mucgiam']) : 0;
        $data['max_discount'] = (isset($data['max_discount']) && $data['max_discount'] != '') ? str_replace(",","",$data['max_discount']) : 0;
        $data['solan'] = (isset($data['solan']) && $data['solan'] != '') ? str_replace(",","",$data['solan']) : 0;
        $data['min_price'] = (isset($data['min_price']) && $data['min_price'] != '') ? str_replace(",","",$data['min_price']) : 0;
        $data['ngaybatdau'] = strtotime($data['ngaybatdau']);
        $data['ngayketthuc'] = strtotime($data['ngayketthuc'])+86399;

        if($id){
            $data['ngaysua'] = time();
        }else{
            $data['ngaytao'] = $data['ngaysua'] = time();
        }

        //### Code xử lý...
        $row = $this->couponRepo->SaveItem($data,$id);

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

        if($id){
            $this->couponRepo->DeleteOneItem($id,$this->folder);
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
            $this->couponRepo->DeleteMultiItem($listid,$this->folder);
        }

        return redirect()->route($this->routeShow,[$category,$type]);
    }
}
