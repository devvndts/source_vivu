<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;

use Helper;

class StaticPostController extends Controller
{
    use SupportTrait;
    private $type, $table, $viewShow, $viewEdit, $config, $folder, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error;
    private $routeShow = 'admin.staticpost.show';
    private $routeEdit = 'admin.staticpost.edit';
    private $folder_upload = "staticpost";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";


    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        $this->config = config('config_type.staticpost');
        $this->folder = Helper::GetFolder($this->folder_upload);
        $this->viewShow = 'admin.templates.staticpost.man.staticpost_add';
        $this->page_error = redirect()->back();

        //permission check option
        $this->permissionShow = 'staticpost_show_'.$request->type;
        $this->permissionEdit = 'staticpost_capnhat_'.$request->type;
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
        $rowItem = $this->staticRepo->GetItem($params);
        if(!$rowItem){
            $params['hienthi']=1;
            $params['ngaytao'] = $data['ngaysua'] = time();
            $rowItem = $this->staticRepo->SaveItem($params);
        }
        $gallery = $this->galleryRepo->GetAllGallery($type,$rowItem['id'],'staticpost');
        $sl_options = (isset($rowItem['sl_options']) && $rowItem['sl_options'] != '') ? json_decode($rowItem['sl_options'], true) : null;
        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'sl_options'=> $sl_options,
            'rowItem'=> $rowItem,
            'type'=> $type,
            'category'=>$category,
            'config'=>$this->config,
            'gallery'=>$gallery,
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
        $dataSlOptions = $request->dataSlOptions;
        $params = array(
            'type'=>$type
        );

        $rowItem = $this->staticRepo->GetItem($params);
        $sl_option = json_decode($rowItem['sl_options'] ?? null, true);
        $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;
        $data['ngaytao'] = time();

        if ($id) {
            if ($request->hasFile('file')) {
                $oldimage = $rowItem['photo'];
                $newimage = $request->file('file');
                if ($newimage) {
                    $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder);
                }
            }
            if ($request->hasFile('file2')) {
                $oldimage = $rowItem['photo2'];
                $newimage = $request->file('file2');
                if ($newimage) {
                    $data['photo2'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder);
                }
            }

            if ($request->hasFile('file3')) {
                $oldimage = $rowItem['photo3'];
                $newimage = $request->file('file3');
                if ($newimage) {
                    $data['photo3'] = Helper::UploadImageToFolder($newimage, $oldimage, $this->folder);
                }
            }
            
            if ($dataSlOptions) {
                // santinised data
                foreach ($dataSlOptions as $k2 => $v2) {
                    $sl_option[$k2] = $v2;
                }
                // delete key not exists in post data
                $arrDiff = array_diff_key($sl_option, $dataSlOptions);
                foreach ($arrDiff as $k2 => $v2) {
                    unset($sl_option[$k2]);
                }
                $data['sl_options'] = json_encode($sl_option);
            }

            //### Cập nhật
            $rowItem = $this->staticRepo->SaveItem($data, $id);
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
