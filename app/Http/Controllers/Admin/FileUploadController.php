<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;
use Illuminate\Support\Str;

use Helper, Thumb;

class FileUploadController extends Controller
{

    use SupportTrait;

    private $type, $table, $viewShow, $viewEdit, $config, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error, $folder_upload;
    private $routeShow = 'admin.fileupload.show';
    private $routeEdit = 'admin.fileupload.edit';
    private $folder = "gallery";
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
        $this->folder_upload = config('config_upload.UPLOAD_GALLERY');   

        $this->relations = ['HasAllChild'];
        $this->relationsCate = $this->categoryRepo->GetRelationsRepo(); //['CategoryParent'];

        $this->viewShow = 'admin.templates.gallery.gallery';
        //$this->viewEdit = 'admin.templates.album.man.album_add';
        
        /*$this->permissionShow = 'album_man_'.$this->type;
        $this->permissionAdd = 'album_add_'.$this->type;
        $this->permissionEdit = 'album_edit_'.$this->type;
        $this->permissionDelete = 'album_delete_'.$this->type;*/
    }


    public function Index(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### Code xử lý
        $galleries = $this->galleryRepo->GetAllGallery('gallery',0,'gallery');

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'type' => '',
            'other_title' => "Thư viện hình ảnh - video",
            'galleries' => $galleries
        );
        return view($this->viewShow)->with($response);
    }


    public function Save(Request $request){
        //### request
        $model = $request->model;
        $type = $request->type;
        $hash = $request->hash;
        $model = $request->model;
        $folder = $request->gallery_folder;
        $files = $request->file('files');
        $id = $params = null;


        if($folder){
            $params = array(
                'folder' => $folder
            );

            $data['folder'] = $folder;
        }

        //### xử lý
        if($files){
            $data['type'] = $type;
            $data['com'] = $model;
            $data['type'] = $data['val'] = $type;
            $data['hash'] = $hash;
            $data['hienthi'] = 1;
            $data['ngaytao'] = time();

            $oldimage = '';
            $folder = Helper::GetFolder($this->folder);

            foreach($files as $k=>$v){
                $newimage = $v;
                if($newimage){ 
                    $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); 
                }
                $this->galleryRepo->SaveItem($data,$id);
            }
        }

        //### get data
        $galleries = $this->galleryRepo->GetAllGallery('gallery',0,'gallery',$params);

        //### Trả về giao diện
        $response = array(
            'galleries' => $galleries
        );

        //### response
        return view('admin.layouts.show_gallery')->with($response);
    }


    public function Change(Request $request){
        //### request
        $folder = $request->folder;

        $params = null;

        if($folder){
            $params = array(
                'folder' => $folder
            );
        }        

        //### get data
        $galleries = $this->galleryRepo->GetAllGallery('gallery',0,'gallery',$params);

        //### Trả về giao diện
        $response = array(
            'galleries' => $galleries
        );

        //### response
        return view('admin.layouts.show_gallery')->with($response);
    }
}
