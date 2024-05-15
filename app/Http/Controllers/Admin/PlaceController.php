<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;

use App\Models\Places;

use Helper;

class PlaceController extends Controller
{
    //
    use SupportTrait;
    public $category;
	private $type, $table, $viewShow, $viewEdit, $model, $config, $gallery, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error, $other_title;
    private $routeShow = 'admin.places.show';
    private $routeEdit = 'admin.places.edit';
    private $folder = "post";
	private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";


    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function __construct(Request $request){
        $this->category = $request->category;
        $this->model = new Places($this->category);
		$this->page_error = redirect()->back();
        $this->type = '';

        switch($this->category){
            case 'list':
                $this->table = 'city';
                $this->viewShow = 'admin.templates.places.city.man';
                $this->viewEdit = 'admin.templates.places.city.add';
				$this->permissionShow = 'place_man_city';
                $this->permissionAdd = 'place_add_city';
                $this->permissionEdit = 'place_edit_city';
                $this->permissionDelete = 'place_delete_city';
                $this->other_title = "Tỉnh thành";
                break;
            case 'cat':
                $this->table = 'district';
                $this->viewShow = 'admin.templates.places.district.man';
                $this->viewEdit = 'admin.templates.places.district.add';
				$this->permissionShow = 'places_man_district';
                $this->permissionAdd = 'places_add_district';
                $this->permissionEdit = 'places_edit_district';
                $this->permissionDelete = 'places_delete_district';
                $this->other_title = "Quận huyện";
                break;
            case 'item':
                $this->table = 'ward';
                $this->viewShow = 'admin.templates.places.ward.man';
                $this->viewEdit = 'admin.templates.places.ward.add';
				$this->permissionShow = 'places_man_ward';
                $this->permissionAdd = 'places_add_ward';
                $this->permissionEdit = 'places_edit_ward';
                $this->permissionDelete = 'places_delete_ward';
                $this->other_title = "Phường xã";
                break;
            case 'man':
                $this->table = 'street';
                $this->viewShow = 'admin.templates.places.street.man';
                $this->viewEdit = 'admin.templates.places.street.add';
				$this->permissionShow = 'places_man_street';
                $this->permissionAdd = 'places_add_street';
                $this->permissionEdit = 'places_edit_street';
                $this->permissionDelete = 'places_delete_street';
                $this->other_title = "Đường";
                break;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Hiển thị danh sách dữ liệu tương ứng với category
    |--------------------------------------------------------------------------
    */
    public function Show(Request $request){
		//### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $params = array();

        if ($request->id_city) {
            $params['id_city'] = $request->id_city ?? 0;
        }
        if ($request->id_district) {
            $params['id_district'] = $request->id_district ?? 0;
        }
        if ($request->id_wards) {
            $params['id_wards'] = $request->id_wards ?? 0;
        }
        $params['keyword'] = ($request->keyword) ? $request->keyword : '';

        //### Code xử lý...
        $itemShow = $this->model->GetAllItems($params,true);

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'itemShow'=> $itemShow,
            'config'=>$this->config,
            'type'=>$this->type,
            'other_title'=>$this->other_title
        );
        return view($this->viewShow)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Hiển thị trang thêm - chỉnh sửa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Edit(Request $request){
		//### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $id = $request->id;

        //### Code xử lý...
        $rowItem = $this->model->GetOneItem($id);

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'folder_upload'=>$this->folder,
            'type'=>$this->type,
            'other_title'=>$this->other_title
        );
        return view($this->viewEdit)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Delete(Request $request){
		//### check auth permission
        if(!$this->IsPermission($this->permissionDelete)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

		//### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $id = $request->id;

        $this->model->DeleteOneItem($id);

        return redirect()->route($this->routeShow,[$category]);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa nhiều dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function DeleteAll(Request $request){
		//### check auth permission
        if(!$this->IsPermission($this->permissionDelete)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

		//### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $id = $request->id;
        $listid = $request->listid;

        if($listid!=''){
            $this->model->DeleteMultiItem($listid);
        }

        return redirect()->route($this->routeShow,[$category]);
    }


    /*
    |--------------------------------------------------------------------------
    | Lưu mới - cập nhật 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Save(Request $request){
        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
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
        $data['tenkhongdauvi'] = (isset($data['slugvi'])) ? $data['slugvi'] : '';
        $data['tenkhongdauen'] = (isset($data['slugen'])) ? $data['slugen'] : '';
        $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;
		if($id){
			$data['ngaysua'] = time();
		}else{
			$data['ngaytao'] = $data['ngaysua'] = time();
		}

        //### Code xử lý...
        $row = $this->model->SaveProduct($data,$id);


        //### Hiển thị giao diện
        if($savehere){
            return redirect()->route($this->routeEdit,[$category,$row->id]);
        }else{
            return redirect()->route($this->routeShow,[$category]);
        }
    }
}
