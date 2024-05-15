<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;
use Illuminate\Support\Str;

use Helper, Thumb;

class AlbumController extends Controller
{
    use SupportTrait;

    private $type, $table, $viewShow, $viewEdit, $config, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error, $folder_upload;
    private $routeShow = 'admin.album.show';
    private $routeEdit = 'admin.album.edit';
    private $folder = "album";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";


    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        $this->category = $request->category;
        $this->type = $request->type;
        $this->config = config('config_type.album');
        $this->folder_upload = config('config_upload.UPLOAD_ALBUM');
        $this->page_error = redirect()->back();

        $this->relations = $this->albumRepo->GetRelationsRepo(); //['HasAllChild'];
        $this->relationsCate = $this->categoryRepo->GetRelationsRepo(); //['CategoryParent'];

        $this->viewShow = 'admin.templates.album.man.album';
        $this->viewEdit = 'admin.templates.album.man.album_add';
        
        $this->permissionShow = 'album_man_'.$this->type;
        $this->permissionAdd = 'album_add_'.$this->type;
        $this->permissionEdit = 'album_edit_'.$this->type;
        $this->permissionDelete = 'album_delete_'.$this->type;
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
        $params = array();
        $arr_childCategory = array();

        //### Code xử lý: lấy category        
        $row_category = ($request->id_category) ? $this->categoryRepo->GetOneItem($request->id_category,$this->relationsCate) : null; 
        $category = array(
            'id' => ($row_category) ? $row_category['id'] : 0,
            'id_parent' => ($row_category) ? $row_category['id'] : 0,
            'tenvi' => ($row_category) ? $row_category['tenvi'] : '',
            'tenvi_parent' => ($row_category) ? $row_category['tenvi'] : ''
        );

        $danhmucparent = $this->categoryRepo->GetAll($type);
        if($request->id_category){
            array_push($arr_childCategory, (int)$request->id_category);
            $arr_childCategory = array_merge($arr_childCategory, $this->categoryRepo->GetChildCategory($type,$request->id_category));
        }

        //### Code xử lý...
        $params['id_list'] = ($request->id_list) ? $request->id_list : 0;
        $params['keyword'] = ($request->keyword) ? $request->keyword : '';
        if($request->id_category){$params['id_category'] = $arr_childCategory;}

        //### Code xử lý...
        $itemShow = $this->albumRepo->GetAllItems($type,$params,$this->relations,$this->pagination);
        $query_str = Helper::SetQuery($request->query);
        //dd($itemShow);

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'itemShow'=> $itemShow,
            'type'=> $type,
            'config'=>$this->config,
            'query_str'=>$query_str,
            'category' => $category,
            'danhmucparent' => $danhmucparent
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
        $rowItem = $this->albumRepo->GetOneItem($id,$this->relations);
        $gallery = $this->galleryRepo->GetAllGallery($type,$id,'album');

        //### Code xử lý: lấy category        
        $row_category = $this->categoryRepo->GetOneItem($rowItem['id_category'],$this->relationsCate);
        $category = array(
            'id' => $rowItem['id'],
            'id_parent' => $rowItem['id_category'],
            'tenvi' => $row_category['tenvi'],
            'tenvi_parent' => $row_category['tenvi']
        );

        $danhmucparent = $this->categoryRepo->GetAll($type);

        //### lấy ds gallery_multy
        $gallery_multy = $this->galleryRepo->GetAllItemByIds(explode(',',$rowItem['gallery']));

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'category' => $category,
            'type'=> $type,
            'config'=>$this->config,
            'gallery'=>$gallery,
            'folder_upload'=>$this->folder,
            'danhmucparent' => $danhmucparent,
            'gallery_multy' => $gallery_multy,
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

        $this->albumRepo->DeleteOneItem($id, $this->folder);
        $this->galleryRepo->DeleteGallery($id,$category,$type,'album','album');

        return redirect()->route($this->routeShow,[$category,$type]);
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
            $this->albumRepo->DeleteMultiItem($listid, $this->folder);
            $this->galleryRepo->DeleteMultiGallery($listid,$category,$type,'album','album');
        }

        return redirect()->route($this->routeShow,[$category,$type]);
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
        $id_parent = $request->id_parent;
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
        $data['type'] = $type;
        $data['tenkhongdauvi'] = (isset($data['slugvi']) && $data['slugvi']!='') ? $data['slugvi'] : ((isset($data['tenvi'])) ? Str::slug($data['tenvi'], '-') : '');
        $data['tenkhongdauen'] = (isset($data['slugen']) && $data['slugen']!='') ? $data['slugen'] : ((isset($data['tenen'])) ? Str::slug($data['tenen'], '-') : '');
        $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;

        //### Lấy thông tin category parent
        $data['id_category'] = $id_parent;
        
		if($id){
			$data['ngaysua'] = time();
		}else{
			$data['ngaytao'] = $data['ngaysua'] = time();
		}

        $width = ($request->width)?$request->width:null;
        $height = ($request->height)?$request->width:null;

        $getimage='';
        if($request->hasFile('file')){
            $row = $this->albumRepo->GetOneItem($id, $this->relations);
            $oldimage = $row['photo'];
            //Lưu hình ảnh vào thư mục public/upload/post
            $folder = Helper::GetFolder($this->folder);
            $newimage = $request->file('file');
            if($newimage){ $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); }
        }

        //### Code xử lý...
        $row = $this->albumRepo->SaveItem($data,$id);

        //### Code xử lý: watermark
		if($width!=null){
			Thumb::Crop($this->folder_upload,$row->photo,$width,$height,1,$type);
		}

        //### Code xử lý: hash photo
        if(!$id){
            $this->galleryRepo->UpdateHashGallery($row->id,$hash);
            //$this->gallery->where('hash', $hash)->update(['id_photo'=>$row->id,'hash'=>'']);
        }
        //### Hiển thị giao diện
        if($savehere){
            return redirect()->route($this->routeEdit,[$category,$type,$row->id]);
        }else{
            return redirect()->route($this->routeShow,[$category,$type]);
        }
    }
}
