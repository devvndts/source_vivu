<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Traits\SupportTrait;

use App\Models\Admins;
use App\Models\Member;

use Helper;
use DB;

class MemberController extends Controller
{
    use SupportTrait;

    private $type, $table, $viewShow, $viewEditChange, $model, $config, $routeError, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error, $folder_upload;
    private $folder = "user";
    private $routeShow = 'admin.member.show';
    private $routeEdit = 'admin.member.editchange';
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";


    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        $this->category = $request->category;
        //check Auth role
        $this->model = new Member();
        $this->viewEdit = 'admin.templates.member.edit';
        $this->viewEditChange = 'admin.templates.member.editchange';
        $this->viewShow = 'admin.templates.member.show';
        $this->routeError = redirect()->route('admin.error.show','403');
        $this->config = config('config_all');
        $this->page_error = redirect()->route('admin.dashboard');
        $this->folder_upload = config('config_upload.UPLOAD_USER'); 
        //$this->page_error = redirect()->back();

        $this->permissionShow = 'member_man';
        $this->permissionAdd = 'member_add';
        $this->permissionEdit = 'member_edit';
        $this->permissionDelete = 'member_delete';
    }

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    /*public function __construct(Request $request){
        //check Auth role
        $this->model = new Member();
        $this->viewEdit = 'admin.templates.member.edit';
        $this->viewEditChange = 'admin.templates.member.editchange';
        $this->viewShow = 'admin.templates.member.show';
        $this->routeError = redirect()->route('admin.error.show','403');
        $this->config = config('config_all');
        $this->page_error = redirect()->route('admin.dashboard');
        //$this->page_error = redirect()->back();

        $this->permissionShow = 'member_man';
        $this->permissionAdd = 'member_add';
        $this->permissionEdit = 'member_edit';
        $this->permissionDelete = 'member_delete';
    }*/


    /*
    |--------------------------------------------------------------------------
    | Show ds tài khoản admin
    |--------------------------------------------------------------------------
    */
    public function Show(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionShow) || config('config_all.permission')==false){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $params = array();
        $params['keyword'] = ($request->keyword) ? $request->keyword : '';
        $params['id_parent'] = Auth::guard('admin')->user()->id;

        //### Code xử lý...
        $itemShow = $this->model->GetAllItems($type,$params);

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
        if(!$this->IsPermission($this->permissionShow) || config('config_all.permission')==false){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $id = $request->id;

        //### Code xử lý...
        $rowItem = $this->model->GetOneItem($id);

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
    | Lưu mới - cập nhật 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Save(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### Thiết lập giá trị thuộc tính
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


        //### Code xử lý...
        if(Auth::guard('admin')->check()){
            //set info for user admin
            $data_input = $request->data;
            $data_input['hienthi'] = (isset($data_input['hienthi'])) ? 1 : 0;
            $data_input['id_nhomquyen'] = $data_input['id_nhomquyen'];
            $data_input['role'] = 1;
            $data_input['lastlogin'] = 0;
            $data_input['id_parent'] = $id_parent = Auth::guard('admin')->user()->id;

            if($data_input['password']!='' && $data_input['password']==$data_input['confirm_password']){
                $data_input['password'] = bcrypt($data_input['password']);
            }else{
                $data_input['password'] = Auth::guard('admin')->user()->password;
            }
            // kiểm tra username đã tồn tại?
            if($id && !$this->checkUsername($id,$data_input['username'])){
                $request->session()->flash('alert', $this->alert);
                return redirect()->route($this->routeShow);
            }
            $row = $this->model->SaveItem($data_input,$id);

            //### Cập nhật list_idchild cho tài khoản cha hiện tại sau khi thêm tài khoản con
            $list_idchild = Auth::guard('admin')->user()->list_idchild;
            $list_idchild = explode(",", $list_idchild);
            if($list_idchild && $list_idchild[0]==''){
                unset($list_idchild[0]);
            }
            if(!in_array($row['id'],$list_idchild)){
                array_push($list_idchild,$row['id']);
                $data_parent['list_idchild'] = implode(",",$list_idchild);
                $this->model->SaveItem($data_parent,$id_parent);
            }

            //### Thiết lập quyền cho tài khoản admin
            DB::table('model_has_roles')->where('model_id',$row['id'])->delete();
            if(!Auth::guard('admin')->user()->find($row['id'])->hasRole($row['id_nhomquyen'])){
                Auth::guard('admin')->user()->find($row['id'])->assignRole($row['id_nhomquyen']);
            }
        }else{
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }
        //### Hiển thị giao diện
        return redirect()->route($this->routeShow);
    }


    public function checkUsername($id,$username){
        $itemOthers = $this->model->GetItemOther($id);
        foreach($itemOthers as $k=>$v){
            if($v['username']==$username){
                return false;
                break;
            }
        }
        return true;
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

        $id = $request->id;

        //### Cập nhật list_idchild cho tài khoản cha hiện tại sau khi thêm tài khoản con
        $list_idchild = Auth::guard('admin')->user()->list_idchild;
        $list_idchild = $list_idchild_tmp = explode(",", $list_idchild);

        if (($key = array_search($id, $list_idchild)) !== false) {
            unset($list_idchild[$key]);
            $data_parent['list_idchild'] =implode(",",$list_idchild);
            $this->model->SaveItem($data_parent,Auth::guard('admin')->user()->id);
        }

        if(Auth::guard('admin')->check() && in_array($id,$list_idchild_tmp)){
            if(Auth::guard('admin')->user()->id!=$id){
                $user_admin = Admins::find($id);
                $this->DeleteAdmin($user_admin);
                return redirect()->route($this->routeShow);
            }
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }else{
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
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

        $id = $request->id;
        $listid = $request->listid;

        //### Cập nhật list_idchild cho tài khoản cha hiện tại sau khi thêm tài khoản con
        $list_idchild = Auth::guard('admin')->user()->list_idchild;
        $list_idchild = $list_idchild_tmp = explode(",", $list_idchild);
        $arr_ids = explode(',',$listid);

        foreach($arr_ids as $k=>$v){
            if (($key = array_search($v, $list_idchild)) !== false) {
                unset($list_idchild[$key]);
                $data_parent['list_idchild'] =implode(",",$list_idchild);
                $this->model->SaveItem($data_parent,Auth::guard('admin')->user()->id);
            }
            if(Auth::guard('admin')->check() && in_array($v,$list_idchild_tmp)){
                if(Auth::guard('admin')->user()->id!=$v){
                    $user_admin = Admins::find($v);
                    $this->DeleteAdmin($user_admin);
                }
            }
        }

        if(Auth::guard('admin')->check()){
            if($listid!=''){
                $this->model->DeleteMultiItem($listid);
            }
            return redirect()->route($this->routeShow);
        }else{
            return $this->page_error;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa đệ quy tài khoản và role : xóa tk cha thì xóa luôn tk con và các role tương ứng
    |--------------------------------------------------------------------------
    */
    public function DeleteAdmin($user_admin){
        if(isset($user_admin->list_idchild) && $user_admin->list_idchild!=''){
            //xóa tài khoản cha
            if(isset($user_admin->id)){
                DB::table('model_has_roles')->where('model_id',$user_admin->id)->delete();
                Admins::where('id',$user_admin->id)->delete();
            }

            //xóa tài khoản con
            $ids = explode(',',$user_admin->list_idchild);
            foreach($ids as $k=>$v){
                $user_admin = Admins::find($v);
                $this->DeleteAdmin($user_admin);
            }
        }else{
            //xóa tài khoản cha nếu ko có tk con
            if(isset($user_admin->id)){
                DB::table('model_has_roles')->where('model_id',$user_admin->id)->delete();
                Admins::where('id',$user_admin->id)->delete();
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Giao diện thay đổi mật khẩu
    |--------------------------------------------------------------------------
    */
    public function EditChangePassword(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### Thiết lập giá trị thuộc tính

        //### Code xử lý...
        $rowItem = Auth::guard('admin')->user()->toArray();

        //### Trả về giao diện
        $response = array(
            'other_title' => "Thay đổi mật khẩu",
            'request' => $request,
            'folder_upload'=>$this->folder,
            'type' => null,
            'rowItem'=> $rowItem,
            'folder_upload'=>$this->folder,
        );

    	return view($this->viewEditChange)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Thay đổi mật khẩu
    |--------------------------------------------------------------------------
    */
    public function ChangePass(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //$2y$10$ItFHveZHh78kFi0zFjhdfeLjNrLipMVPgA/b0lTJHp9jPJO1yRWZy:admin123 == password define
        //$2y$10$qZOqQJojHbLtxFrgnZiVfe1p1VfrOZsm/h2SHIfun1PErw6EdOIX.:MK123123 == password define
        $input = $request->only(['old_password', 'new_password', 'renew_password']);

        if(Auth::guard('admin')->check()){
            $id = Auth::guard('admin')->user()->id;
            $password = Auth::guard('admin')->user()->password;
            if(Hash::check($input['old_password'], $password) && $input['new_password']==$input['renew_password']){
                $admin = Admins::find($id);
                $admin->password = bcrypt($input['new_password']);
                $admin->save();
                return redirect()->route('admin.login');
            }else{
                $response = array(
                    'info_check'=>false,
                    'info_loading'=>'Thay đổi mật khẩu thất bại !',
                );
            }
            return view($this->viewEditChange)->with($response);
        }
    }
}
