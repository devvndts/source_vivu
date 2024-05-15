<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;
use Illuminate\Support\Str;

use Helper;
use Thumb;
use TableManipulation;

class PostController extends Controller
{
    use SupportTrait;

    private $type;
    private $table;
    private $viewShow;
    private $viewEdit;
    private $config;
    private $permissionShow;
    private $permissionAdd;
    private $permissionEdit;
    private $permissionDelete;
    private $page_error;
    private $folder_upload;
    private $config_tags;
    private $routeShow = 'admin.post.show';
    private $routeEdit = 'admin.post.edit';
    private $folder = "post";
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
        $this->config = config('config_type.post');
        $this->config_tags = config('config_type.tags');
        $this->page_error = redirect()->back();
        $this->folder_upload = config('config_upload.UPLOAD_POST');

        $this->relations = $this->postRepo->GetRelationsRepo(); //['HasAllChild'];
        $this->relationsCate = $this->categoryRepo->GetRelationsRepo(); //['CategoryParent'];

        $this->viewShow = 'admin.templates.post.man.post';
        $this->viewEdit = 'admin.templates.post.man.post_add';
        $this->permissionShow = 'post_man_'.$this->type;
        $this->permissionAdd = 'post_add_'.$this->type;
        $this->permissionEdit = 'post_edit_'.$this->type;
        $this->permissionDelete = 'post_delete_'.$this->type;
    }


    /*
    |--------------------------------------------------------------------------
    | Hiển thị danh sách dữ liệu tương ứng với category
    |--------------------------------------------------------------------------
    */
    public function Show(Request $request)
    {
        
        $idParent = 0;
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
        $arr_childCategory = array();

        //### Code xử lý: lấy category
        $row_category = ($request->id_category) ? $this->categoryRepo->GetOneItem($request->id_category, $this->relationsCate) : null;
        $category = array(
            'id' => ($row_category) ? $row_category['id'] : 0,
            'id_parent' => ($row_category) ? $row_category['id'] : 0,
            'tenvi' => ($row_category) ? $row_category['tenvi'] : '',
            'tenvi_parent' => ($row_category) ? $row_category['tenvi'] : ''
        );

        $danhmucparent = $this->categoryRepo->GetAll($type);
        if ($request->id_category) {
            array_push($arr_childCategory, (int)$request->id_category);
            $arr_childCategory = array_merge($arr_childCategory, $this->categoryRepo->GetChildCategory($type, $request->id_category));
        }

        //### Code xử lý:
        $params['id_list'] = ($request->id_list) ? $request->id_list : 0;
        $params['id_cat'] = ($request->id_cat) ? $request->id_cat : 0;
        $params['id_item'] = ($request->id_item) ? $request->id_item : 0;
        $params['id_sub'] = ($request->id_sub) ? $request->id_sub : 0;
        if ($request->keyword) {
            $params['keyword'] = $request->keyword;
        }
        if ($request->id_category) {
            $params['id_category'] = $arr_childCategory;
        }
        if ($request->id_product) {
            $params['id_product'] = $idParent = $request->id_product;
        }

        //### Code xử lý...
        $itemShow = $this->postRepo->GetAllItems($type, $params, $this->relations, $this->pagination);
        $query_str = Helper::SetQuery($request->query);
        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'itemShow'=> $itemShow,
            'idParent'=> $idParent,
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
        $idParent = $request->id_product ?? 0;
        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'type'=> $type,
            'config'=>$this->config,
            'folder_upload'=>$this->folder,
            'config_tags'=>$this->config_tags,
            'idParent'=> $idParent,
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
        $idParent = ($request->id_product) ? $request->id_product : 0;
        //### Tạo bản nháp
        if (!$id) {
            $id = Helper::CreateDraft('post', $type);
            return redirect()->route($this->routeEdit, [$this->category,$type,$id,'id_product'=>$idParent]);
        }

        //### Code xử lý...
        $rowItem = $this->postRepo->GetOneItem($id, $this->relations);
        $gallery = $this->galleryRepo->GetAllGallery($type, $id, 'post');

        //### Code xử lý: lấy category
        $row_category = $this->categoryRepo->GetOneItem($rowItem['id_category'], $this->relationsCate);
        $category = array(
            'id' => $rowItem['id'] ?? 0,
            'id_parent' => $rowItem['id_category'] ?? 0,
            'tenvi' => $row_category['tenvi'] ?? '',
            'tenvi_parent' => $row_category['tenvi'] ?? ''
        );

        $danhmucparent = $this->categoryRepo->GetAll($type);

        //### lấy ds gallery_multy
        $gallery_multy = $this->galleryRepo->GetAllItemByIds(explode(',', $rowItem['gallery']));
        $sl_options = (isset($rowItem['sl_options']) && $rowItem['sl_options'] != '') ? json_decode($rowItem['sl_options'], true) : null;
        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'sl_options'=> $sl_options,
            'category' => $category,
            'type'=> $type,
            'config'=>$this->config,
            'gallery'=>$gallery,
            'folder_upload'=>$this->folder,
            'config_tags'=>$this->config_tags,
            'danhmucparent' => $danhmucparent,
            'gallery_multy' => $gallery_multy,
            'idParent' => $idParent
        );
        return view($this->viewEdit)->with($response);
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
        $idParent = ($request->id_product) ? $request->id_product : 0;

        $this->postRepo->DeleteOneItem($id, $this->folder);
        $this->galleryRepo->DeleteGallery($id, $category, $type, 'post', 'post');

        return redirect()->route($this->routeShow, [$category,$type,'id_product'=>$idParent]);
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
        $idParent = ($request->id_product) ? $request->id_product : 0;
        
        if ($listid!='') {
            $this->postRepo->DeleteMultiItem($listid, $this->folder);
            $this->galleryRepo->DeleteMultiGallery($listid, $category, $type, 'post', 'post');
        }

        return redirect()->route($this->routeShow, [$category,$type,'id_product'=>$idParent]);
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
        $id_parent = $request->id_parent;
        $id_product = $request->id_product;
        $type = $request->type;
        $id = $request->id;
        $hash = $request->hash;
        $savehere = ($request->has('savehere'))?true:false;
        $savedraft = ($request->has('savedraft'))?true:false;

        $row_sl_opt = $this->postRepo->GetOneItem($id);
        $sl_option = json_decode($row_sl_opt['sl_options'] ?? null, true);

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
        $dataSlOptions = $request->dataSlOptions;
        $dataUser = $request->dataUser;
        $data['type'] = $type;
        if (@$this->config[$type]['slug']) {
            $data['tenkhongdauvi'] = (isset($data['slugvi']) && $data['slugvi']!='') ? $data['slugvi'] : ((isset($data['tenvi'])) ? Str::slug($data['tenvi'], '-') : '');
            $data['tenkhongdauen'] = (isset($data['slugen']) && $data['slugen']!='') ? $data['slugen'] : ((isset($data['tenen'])) ? Str::slug($data['tenen'], '-') : '');
        } else {
            $data['tenkhongdauvi'] = (isset($data['slugvi']) && $data['slugvi']!='') ? $data['slugvi'] : '';
            $data['tenkhongdauen'] = (isset($data['slugen']) && $data['slugen']!='') ? $data['slugen'] : '';
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

        $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;
        $data['draft'] = 0;

        //### kiểm tra lưu nháp ?
        if ($savedraft) {
            $data['draft'] = 1;
            $data['hienthi'] = 0;
        }
        

        if ($dataUser) {
            if ($dataUser) {
                $row = $this->postRepo->GetOneItem($id, $this->relations);
                $userrating = json_decode($row['userrating'], true);
                
                $oldimage = (isset($userrating['photo'])) ? $userrating['photo'] : '';

                //Lưu hình ảnh vào thư mục public/upload/post
                $folder = Helper::GetFolder($this->folder);
                $newimage = (isset($dataUser['photo'])) ? $dataUser['photo'] : '';
                if ($newimage) {
                    $dataUser['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
                } else {
                    $dataUser['photo']=$oldimage;
                }
            }
            $data['userrating'] = json_encode($dataUser);
        }
        
        //### Lấy thông tin category parent
        $data['id_category'] = ($id_parent) ? $id_parent : 0;
        $data['id_product'] = ($id_product) ? $id_product : 0;
        
        if ($id) {
            $data['ngaysua'] = time();
        } else {
            $data['ngaytao'] = $data['ngaysua'] = time();
        }

        //### lấy ids theo level
        $level_cate_max = $this->categoryRepo->Query()->max('level')+1;
        if ($level_cate_max) {
            for ($i=1; $i<=$level_cate_max; $i++) {
                TableManipulation::AddFieldToTable('post', 'ids_level_'.$i, 'string');
                $data['ids_level_'.$i] = (isset($request->ids_level[$i])) ? implode(',', $request->ids_level[$i]) : '';
            }
        }

        $width = ($request->width)?$request->width:null;
        $height = ($request->height)?$request->width:null;

        if (isset($this->config[$type]['tags']) && $this->config[$type]['tags'] == true) {
            if (isset($request->tags_group) && ($request->tags_group != '')) {
                $data['id_tags'] = implode(",", $request->tags_group);
            } else {
                $data['id_tags'] = "";
            }
        }

        $getimage='';
        if ($request->hasFile('file')) {
            $row = $this->postRepo->GetOneItem($id, $this->relations);
            $oldimage = $row['photo'] ?? '';

            //Lưu hình ảnh vào thư mục public/upload/post
            $folder = Helper::GetFolder($this->folder);
            $newimage = $request->file('file');
            if ($newimage) {
                $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
            }
        }

        if ($request->hasFile('file2')) {
            $row = $this->postRepo->GetOneItem($id, $this->relations);
            $oldimage = $row['photo2'];

            //Lưu hình ảnh vào thư mục public/upload/post
            $folder = Helper::GetFolder($this->folder);
            $newimage = $request->file('file2');
            if ($newimage) {
                $data['photo2'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
            }
        }

        if ($request->hasFile('file3')) {
            $row = $this->postRepo->GetOneItem($id, $this->relations);
            $oldimage = $row['photo3'];

            //Lưu hình ảnh vào thư mục public/upload/post
            $folder = Helper::GetFolder($this->folder);
            $newimage = $request->file('file3');
            if ($newimage) {
                $data['photo3'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
            }
        }

        if ($request->hasFile('icon')) {
            $row = $this->postRepo->GetOneItem($id, $this->relations);
            $oldimage = $row['icon'];

            //Lưu hình ảnh vào thư mục public/upload/post
            $folder = Helper::GetFolder($this->folder);
            $newimage = $request->file('icon');
            if ($newimage) {
                $data['icon'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
            }
        }

        //### Code xử lý...
        $row = $this->postRepo->SaveItem($data, $id);
        //### Code xử lý: watermark
        if ($width!=null) {
            Thumb::Crop($this->folder_upload, $row->photo, $width, $height, 1, $type);
        }

        //### Code xử lý: hash photo
        if (!$id) {
            $this->galleryRepo->UpdateHashGallery($row->id, $hash);
        }
        
        //### Hiển thị giao diện
        if ($savehere) {
            return redirect()->route($this->routeEdit, [$category,$type,$row->id]);
        } else {
            return redirect()->route($this->routeShow, [$category,$type,'id_product'=>$row->id_product]);
        }
    }
}
