<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    private $category, $type, $table, $viewShow, $viewEditChange, $model, $config, $routeError, $model_user;
    private $routeShow = 'admin.permission.show';
    private $routeEdit = 'admin.permission.edit';

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function __construct(Request $request){
        //check Auth role
        $this->model = new Permission();
        $this->viewEdit = 'admin.templates.permission.edit';
        $this->viewShow = 'admin.templates.permission.show';
        $this->routeError = redirect()->route('admin.error.show','403');
        $this->model_user = Auth::guard('admin')->user();
    }


    /*
    |--------------------------------------------------------------------------
    | Show ds quyền
    |--------------------------------------------------------------------------
    */
    public function Show(Request $request){
        //### Thiết lập giá trị thuộc tính
        $type = $request->type;

        //### Code xử lý...
        //$itemShow = $this->model_user->getAllPermissions();
        //$itemShow = $this->model->GetAllItems($type,$params);
        $itemShow = array();

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
        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $id = $request->id;

        //### Code xử lý...
        $rowItem = array();

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'type'=> $type,
            'config'=>$this->config,
            'other_title' => "Danh sách quyền",
        );
        return view($this->viewEdit)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Lưu mới - cập nhật 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Save(Request $request){
        //### Code xử lý...
        $data = $request->dataQuyen;
        $all_permissions = $this->GetAllPermissions();
        foreach($data as $k=>$v){
            if(!in_array($v,$all_permissions)){
                $this->model->create(['name' => $v]);
            }
        }

        //### Hiển thị giao diện
        return redirect()->route($this->routeEdit);
    }


    public function GetAllPermissions(){
        $all_permissions = $this->model->Get()->toArray();
        foreach($all_permissions as $k=>$v){
            $arr_permissions[$k] = $v['name'];
        }
        return $arr_permissions;
    }
}
