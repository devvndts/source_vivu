<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Http\Traits\SupportTrait;

use Helper;
use DB;

class RoleController extends Controller
{
    use SupportTrait;
    private $type, $table, $viewShow, $model, $config, $routeError, $model_user, $model_permission, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error;
    private $routeShow = 'admin.role.show';
    private $routeEdit = 'admin.role.edit';
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";


    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        //check Auth role
        $this->category = $request->category;
        $this->model = new Role();
        $this->model_permission = new Permission();
        $this->viewEdit = 'admin.templates.role.edit';
        $this->viewShow = 'admin.templates.role.show';
        $this->routeError = redirect()->route('admin.error.show','403');
        $this->model_user = Auth::guard('admin')->user();
        $this->page_error = redirect()->back();

        $this->permissionShow = 'permission_man';
        $this->permissionAdd = 'permission_create';
        $this->permissionEdit = 'permission_edit';
        $this->permissionDelete = 'permission_delete';
    }

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    /*public function __construct(Request $request){
        //check Auth role
        $this->category = $request->category;
        $this->model = new Role();
        $this->model_permission = new Permission();
        $this->viewEdit = 'admin.templates.role.edit';
        $this->viewShow = 'admin.templates.role.show';
        $this->routeError = redirect()->route('admin.error.show','403');
        $this->model_user = Auth::guard('admin')->user();
        $this->page_error = redirect()->back();

        $this->permissionShow = 'permission_man';
        $this->permissionAdd = 'permission_create';
        $this->permissionEdit = 'permission_edit';
        $this->permissionDelete = 'permission_delete';
    }*/


    /*
    |--------------------------------------------------------------------------
    | Show ds quyền
    |--------------------------------------------------------------------------
    */
    public function Show(Request $request){
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $type = $request->type;

        //### Code xử lý...
        $itemShow = $this->model->where('id_admin',$this->model_user->id)->get()->toArray();

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
        $rowItem = $this->model->find($id);
        $permissions = array();
        if($rowItem){
            $rowItem=$rowItem->toArray();
            $permissions = $this->GetPermissionsByRole($rowItem['id']);
            $permissions = ($permissions)?$permissions->toArray():$permissions;
        }

        //get quyền hiện có (nếu ko phải tài khoản super admin)
        $id_nhomquyen = $this->model_user->id_nhomquyen;
        $permissions_parent = $this->GetPermissionsByRole($id_nhomquyen);
        if($permissions_parent)
            $permissions_parent->toArray();

        //### Trả về giao diện
        $other_title = ($id==null)?"Thêm nhóm quyền":"Cập nhật nhóm quyền";
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'permissions' => $permissions,
            'permissions_parent' => $permissions_parent,
            'type'=> $type,
            'config'=>$this->config,
            'other_title' => $other_title,
        );
        return view($this->viewEdit)->with($response);
    }

    /*
    |--------------------------------------------------------------------------
    | Lưu mới - cập nhật 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Save(Request $request){
        $this->initialization($request);

        //### Thiết lập giá trị thuộc tính
        $id = $request->id;
        $data_input = $request->data;
        $data['name'] = Helper::changeTitle($data_input['name']);
        $data['role_name'] = $data_input['name'];
        $data['stt'] = $data_input['stt'];
        $data['hienthi'] = (isset($data_input['hienthi'])) ? 1 : 0;
        $data['id_admin'] = $this->model_user->id;

        $dataQuyen = $request->dataQuyen;
        $dataPermission = $request->dataPermission;
        $id_nhomquyen = Auth()->guard('admin')->user()->id_nhomquyen;

        //set role_parent and list_rolechild
        $data['role_parent'] = $id_nhomquyen;

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

        //### Code xử lý: thêm permission
        $all_permissions = $this->GetAllPermissions();
        foreach($dataPermission as $k=>$v){
            if(!in_array($v,$all_permissions)){
                $this->model_permission->create(['name' => $v]);
            }
        }

        //### Code xử lý: thiết lập permission of role
        if($id){
            DB::table('role_has_permissions')->where('role_id',$id)->delete();
        }
        $role = $this->model->updateOrCreate(['id'=>$id],$data);
        $role->givePermissionTo($dataQuyen);
        $this->model->updateOrCreate(['id'=>$role['id']],['name'=>$role['id']]);

        //### Cập nhật list_rolechild cho bảng role với tài khoản hiện tại
        $row_role = Role::select('list_rolechild')->where('id',$id_nhomquyen)->first();
        if($row_role){
            $list_rolechild = explode(",", $row_role->list_rolechild);
            if($list_rolechild && $list_rolechild[0]==''){unset($list_rolechild[0]);}

            if(!in_array($role['id'],$list_rolechild)){
                array_push($list_rolechild,$role['id']);
                $update_role = Role::find($id_nhomquyen);
                $update_role->list_rolechild =  implode(",",$list_rolechild);
                $update_role->save();
            }
        }

        //### Hiển thị giao diện
        return redirect()->route($this->routeShow);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Delete(Request $request){
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionDelete)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

    	$type = $request->type;
    	$id = $request->id;

        if($id){
            //### kiểm tra id có trong phạm vi đc xóa?
            $id_nhomquyen = Auth()->guard('admin')->user()->id_nhomquyen;
            $row_role = Role::select('list_rolechild')->where('id',$id_nhomquyen)->first();

            if($row_role){
                $list_rolechild = explode(",", $row_role->list_rolechild);
                if(!in_array($id,$list_rolechild)){
                    $request->session()->flash('alert', $this->alert);
                    return $this->page_error;
                }
            }

            //delete role child by role_parent and id
            $this->DeleteRoleAdmin($id);

            //cập nhật lại list_rolechild cho role hiện tại
            $list_rolechild = Role::where('role_parent',$id_nhomquyen)->pluck('id');
            if($list_rolechild){
                $list_rolechild = $list_rolechild->toArray();

                $update_role = Role::find($id_nhomquyen);
                if($update_role){
                    $update_role->list_rolechild =  implode(",", $list_rolechild);
                    $update_role->save();
                }
            }

        }

    	return redirect()->route($this->routeShow);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa nhiều dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function DeleteAll(Request $request){
        $this->initialization($request);
        
        //### check auth permission
        if(!$this->IsPermission($this->permissionDelete)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $type = $request->type;
        $id = $request->id;
        $listid = $request->listid;

        if($listid!=''){
            //### kiểm tra id có trong phạm vi đc xóa?
            $id_nhomquyen = Auth()->guard('admin')->user()->id_nhomquyen;
            $row_role = Role::select('list_rolechild')->where('id',$id_nhomquyen)->first();
            if($row_role){ $list_rolechild = explode(",", $row_role->list_rolechild); }

            $arr_ids = explode(",", $listid);
            foreach($arr_ids as $i=>$id){
                if($id){
                    if($row_role && !in_array($id,$list_rolechild)){
                        $request->session()->flash('alert', $this->alert);
                        return $this->page_error;
                    }

                    //delete role child by role_parent and id
                    $this->DeleteRoleAdmin($id);
                }
            }

            //cập nhật lại list_rolechild cho role hiện tại
            $list_rolechild = Role::where('role_parent',$id_nhomquyen)->pluck('id');
            if($list_rolechild){
                $list_rolechild = $list_rolechild->toArray();

                $update_role = Role::find($id_nhomquyen);
                if($update_role){
                    $update_role->list_rolechild =  implode(",", $list_rolechild);
                    $update_role->save();
                }
            }
        }

        return redirect()->route($this->routeShow);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa đệ quy 1 role : xóa role của tk con tương ứng
    |--------------------------------------------------------------------------
    */
    public function DeleteRoleAdmin($id){
        $list_rolechild = Role::where('role_parent',$id)->get();
        if($list_rolechild){
            foreach($list_rolechild as $k=>$v){
                $this->DeleteRoleAdmin($v->id);
            }
        }
        Role::find($id)->delete();
    }


    /*
    |--------------------------------------------------------------------------
    | lấy ds tất cả permission
    |--------------------------------------------------------------------------
    */
    public function GetAllPermissions(){
        $all_permissions = $this->model_permission->Get()->toArray();
        foreach($all_permissions as $k=>$v){
            $arr_permissions[$k] = $v['name'];
        }
        return $arr_permissions;
    }

    /*
    |--------------------------------------------------------------------------
    | lấy ds permission theo role_id
    |--------------------------------------------------------------------------
    */
    public function GetPermissionsByRole($role_id){
        $permissions = DB::table('role_has_permissions')->where('role_id',$role_id)->get();
        if($permissions){
            $permissions=$permissions->toArray();
            foreach($permissions as $k=>$v){
                $arr_permissions[$k] = $v->permission_id;
            }
        }

        if(isset($arr_permissions)){
            $arr_permissions = DB::table('permissions')->select('name')->whereIn('id', $arr_permissions)->get();

            foreach($arr_permissions as $k=>$v){
                $arr_permissions[$k] = $v->name;
            }
            return $arr_permissions;
        }
        return null;
    }
}
