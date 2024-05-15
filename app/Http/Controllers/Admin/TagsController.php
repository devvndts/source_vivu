<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;
use Illuminate\Support\Str;

use Helper;

class TagsController extends Controller
{
    //
    use SupportTrait;

    private $type;
    private $table;
    private $config;
    private $permissionShow;
    private $permissionAdd;
    private $permissionEdit;
    private $permissionDelete;
    private $page_error;
    private $folder_upload;
    private $routeShow = 'admin.tags.show';
    private $routeEdit = 'admin.tags.edit';
    private $viewShow = 'admin.templates.tags.man.tags'; // admin/templates/color/man/color.blade.php
    private $viewEdit = 'admin.templates.tags.man.tags_add'; // admin/templates/color/man/color_add.blade.php
    private $folder = "tags";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request)
    {
        $this->category = $request->category;
        $this->type = $request->type;
        $this->config = config('config_type.tags');
        $this->folder_upload = config('config_upload.UPLOAD_TAGS');
        $this->page_error = redirect()->back();
        $this->permissionShow = 'tags_man_'.$this->type;
        $this->permissionAdd = 'tags_add_'.$this->type;
        $this->permissionEdit = 'tags_edit_'.$this->type;
        $this->permissionDelete = 'tags_delete_'.$this->type;
    }


    /*
    |--------------------------------------------------------------------------
    | Hiển thị danh sách dữ liệu : tags
    |--------------------------------------------------------------------------
    */
    public function Show(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionShow)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }


        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $params = array();
        $params['keyword'] = ($request->keyword) ? $request->keyword : '';

        //### Code xử lý...
        $itemShow = $this->tagRepo->GetAllItems($type, $params, $this->relations, $this->pagination);

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
    | Hiển thị trang thêm 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function add(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionShow)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }
        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'type'=> $type,
            'config'=>$this->config,
            'folder_upload'=>$this->folder
        );
        return view($this->viewEdit)->with($response);
    }

    /*
    |--------------------------------------------------------------------------
    | Hiển thị trang thêm - chỉnh sửa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Edit(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionShow)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }


        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $id = $request->id;

        //### Code xử lý...
        $rowItem = $this->tagRepo->GetOneItem($id, $this->relations);
        
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
    public function Save(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;

        //### check auth permission
        if ($id) {
            if (!$this->IsPermission($this->permissionEdit)) {
                $request->session()->flash('alert', $this->alert);
                return $this->page_error;
            }
        } else {
            if (!$this->IsPermission($this->permissionAdd)) {
                $request->session()->flash('alert', $this->alert);
                return $this->page_error;
            }
        }

        $data = $request->data;
        $data['type'] = $type;
        if (isset($data['slugvi'])) {
            $data['tenkhongdauvi'] = (isset($data['slugvi']) && $data['slugvi']!='') ? $data['slugvi'] : ((isset($data['tenvi'])) ? Str::slug($data['tenvi'], '-') : '');
        }
        if (isset($data['slugen'])) {
            $data['tenkhongdauen'] = (isset($data['slugen']) && $data['slugen']!='') ? $data['slugen'] : ((isset($data['tenen'])) ? Str::slug($data['tenen'], '-') : '');
        }

        $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;
        if ($id) {
            $data['ngaysua'] = time();
        } else {
            $data['ngaytao'] = $data['ngaysua'] = time();
        }


        $getimage='';
        if ($request->hasFile('file')) {
            $row = $this->tagRepo->GetOneItem($id, $this->relations);
            $oldimage = $row['photo'];
            $newimage = $request->file('file');
            $folder = Helper::GetFolder($this->folder);
            if ($newimage) {
                $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
            }
        }

        //### Code xử lý...
        $row = $this->tagRepo->SaveItem($data, $id);

        //### Hiển thị giao diện
        return redirect()->route($this->routeShow, [$category,$type]);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Delete(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionDelete)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;

        $row = $this->tagRepo->GetOneItem($id, $this->relations);
        if ($row['id']) {
            $this->tagRepo->DeleteOneItem($id, $this->folder);
            $image_path = $this->folder.$row['photo'];
            Helper::DeleteImage($image_path);
            return redirect()->route($this->routeShow, [$category,$type]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa nhiều dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function DeleteAll(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionDelete)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;
        $listid = $request->listid;

        if ($listid!='') {
            $ids = explode(",", $listid);
            foreach ($ids as $i => $item) {
                $row = $this->tagRepo->GetOneItem($item, $this->relations);
                $image_path = $this->folder.$row['photo'];
                Helper::DeleteImage($image_path);
            }
            $this->tagRepo->DeleteMultiItem($listid, $this->folder);
        }

        return redirect()->route($this->routeShow, [$category,$type]);
    }
}
