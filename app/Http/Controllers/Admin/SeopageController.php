<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;

use App\Models\SeoPage;

use Helper;

class SeopageController extends Controller
{
    //
    use SupportTrait;
    private $type, $table, $viewShow, $viewEdit, $config, $folder, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error;
    private $routeShow = 'admin.seopage.show';
    private $routeEdit = 'admin.seopage.edit';
    private $folder_upload = "seopage";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        $this->config = config('config_type.seopage');
        $this->folder = Helper::GetFolder($this->folder_upload);
        $this->viewShow = 'admin.templates.seopage.man.seopage_add';
        $this->page_error = redirect()->back();

        //permission check option
        $this->permissionShow = 'seopage_show_'.$this->type;
        $this->permissionEdit = 'seopage_capnhat_'.$this->type;
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
        $type = $request->type;
        $category = $request->category;
        $array_product = array();

        //### Code xử lý...
        $params = array(
            'type'=>$request->type,
        );
        $rowItem = $this->seopageRepo->GetItem($params);
        if(!$rowItem){
            $params['hienthi']=1;
            $params['ngaytao'] = $data['ngaysua'] = time();
            $rowItem = $this->seopageRepo->SaveItem($params);
        }
        //$gallery = $this->gallery->GetAllItems($type,$rowItem['id'],'seopage');

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'type'=> $type,
            'category'=>$category,
            'config'=>$this->config,
            //'gallery'=>$gallery,
            'folder_upload'=>$this->folder_upload
        );
        return view($this->viewShow)->with($response);
    }

    /*
    |--------------------------------------------------------------------------
    | Lưu mới - cập nhật 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Save(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionEdit)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $category = $request->category;
        $id = $request->id;
        $data = $request->data;
        $params = array(
            'type'=>$type
        );

        $rowItem = $this->seopageRepo->GetItem($params);
        $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;
        $data['ngaysua'] = time();

        if($id)
        {
            if($request->hasFile('file'))
            {
                $oldimage = $rowItem['photo'];
                $newimage = $request->file('file');
                if($newimage){ $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder); }
            }

            //### Cập nhật
            $rowItem = $this->seopageRepo->SaveItem($data,$id);
        }

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'type'=> $type,
            'category'=>$category,
            'config'=>$this->config,
            'folder_upload'=>$this->folder_upload
        );
        return redirect()->route($this->routeShow,[$category,$type]);
    }
}
