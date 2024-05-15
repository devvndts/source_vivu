<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\SupportTrait;
use Illuminate\Support\Str;

use Helper, Thumb, TableManipulation;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    use SupportTrait;

    private $type, $table, $viewShow, $viewEdit, $config, $config_tags, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $permissionImport, $permissionExport, $page_error, $folder_upload;
    private $routeShow = 'admin.category.show';
    private $routeEdit = 'admin.category.edit';
    private $folder = "category";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        //### set request value
        $this->category = $request->category;
        $this->type = $request->type;
        $this->config = config('category');
        $this->page_error = redirect()->back();
        $this->folder_upload = config('config_upload.UPLOAD_PRODUCT');

        //### set repo relation
        $this->relations = ['CategoryParent'];


        $this->viewShow = 'admin.templates.category.man.man';
        $this->viewEdit = 'admin.templates.category.man.add';
        $this->permissionShow = 'category_man_'.$this->type;
        $this->permissionAdd = 'category_add_'.$this->type;
        $this->permissionEdit = 'category_edit_'.$this->type;
        $this->permissionDelete = 'category_delete_'.$this->type;
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
        $level = '';
        $type = $request->type;        
        $params = array();

        if(isset($request->level)){
            $params['level'] = $level = $request->level;
        }
        $params['keyword'] = ($request->keyword) ? $request->keyword : '';
        $params['selectRaw'] = "(CASE WHEN CAST(ids_level_3 AS SIGNED) > 0 THEN CAST(ids_level_3 AS SIGNED) WHEN CAST(ids_level_2 AS SIGNED) > 0 THEN CAST(ids_level_2 AS SIGNED) ELSE CAST(ids_level_1 AS SIGNED) END) AS parent_id ";
        //### Code xử lý...
        $itemShow = $this->categoryRepo->GetAllItems($type, $params, $this->relations, false);
        $query_str = Helper::SetQuery($request->query);
        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'itemShow'=> $itemShow,
            'type'=> $type,
            'config'=>$this->config,
            'query_str'=>$query_str,
            'level' => $level
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
        $rowItem = $this->categoryRepo->GetOneItem($id,$this->relations);
        $gallery = $this->galleryRepo->GetAllGallery($type,$id,'category');
        $danhmucparent = $this->categoryRepo->GetAll($type);


        //### danh mục cùng cấp (level)
        $id_category = (!empty($rowItem['id_parent'])) ? $rowItem['id_parent']:0;
        $category_select = $this->categoryRepo->Getitem(['id'=>$id_category]);
        if($category_select){
            $category_list_same = $this->categoryRepo->GetAllItemsExceptId($category_select['type'],['level'=>$category_select['level'], 'id'=>$id_category]);

        }

        $category = array(
            'id' => (!empty($rowItem['id'])) ? $rowItem['id']:0,
            'id_parent' => (!empty($rowItem['id_parent'])) ? $rowItem['id_parent']:0,
            'tenvi' => (!empty($rowItem['tenvi'])) ? $rowItem['tenvi']:'',
            'tenvi_parent' => (!empty($rowItem['category_parent']['tenvi'])) ? $rowItem['category_parent']['tenvi']:''
        );

        //### lấy thông tin prefix
        $prefix = Helper::GetPrefixAdmin($request);
        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'category'=> $category,
            'type'=> $type,
            'config'=>$this->config,
            'gallery'=>$gallery,
            'folder_upload'=>$this->folder,
            'config_tags'=>$this->config_tags,
            'danhmucparent' => $danhmucparent,
            'category_list_same' => (!empty($category_list_same)) ? $category_list_same:0,
            'ids_parent' => (!empty($rowItem['ids_parent'])) ? $rowItem['ids_parent']:0,
            'prefix' => $prefix
        );
        return view($this->viewEdit)->with($response);
    }

    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng
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

        if($id){
            $this->DoDelete($type,$id);
            $this->categoryRepo->DeleteOneItem($id,$this->folder);
        }

        return redirect()->route($this->routeShow,[$type]);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa nhiều dòng
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
            $ids = explode(",", $listid);
            foreach($ids as $i=>$item){
                $this->DoDelete($type,$item);
            }
            $this->categoryRepo->DeleteMultiItem($listid,$this->folder);
        }

        return redirect()->route($this->routeShow,[$type]);
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
        $multy_category = $request->multy_category;
        //$ids_multy_category = $request->ids_multy_category;

        $data = $request->data;
        $width = ($request->width)?$request->width:null;
        $height = ($request->height)?$request->width:null;


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

        if($multy_category){
            $data['ids_parent'] = implode(',', $multy_category);
        }


        if($data){
            $data['type'] = $type;
            $data['tenkhongdauvi'] = (isset($data['slugvi']) && $data['slugvi']!='') ? $data['slugvi'] : ((isset($data['tenvi'])) ? Str::slug($data['tenvi'], '-') : '');
            $data['tenkhongdauen'] = (isset($data['slugen']) && $data['slugen']!='') ? $data['slugen'] : ((isset($data['tenen'])) ? Str::slug($data['tenen'], '-') : '');

            $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;

            if($id){
                $data['ngaysua'] = time();
            }else{
                $data['ngaytao'] = $data['ngaysua'] = time();
            }

            //### lấy ids theo level
            $level_cate_max = $this->categoryRepo->Query()->max('level')+1;
            if($level_cate_max){
                for($i=1;$i<=$level_cate_max;$i++){
                    TableManipulation::AddFieldToTable('category','ids_level_'.$i,'string');
                    $data['ids_level_'.$i] = (isset($request->ids_level[$i])) ? implode(',', $request->ids_level[$i]) : '';
                }
            }

            //### Lấy thông tin category parent
            /*$row_parent = $this->categoryRepo->GetOneItem($id_parent, $this->relations);
            $data['level'] = ($row_parent) ? $row_parent['level']+1 : 0;
            $data['id_parent'] = ($id_parent) ? $id_parent : 0;*/

            //### Lưu hình ảnh vào thư mục public/upload/product            
            $getimage='';            
            if($request->hasFile('file')){ 
                $row = $this->categoryRepo->GetOneItem($id, $this->relations);               
                $oldimage = @$row['photo'];
                $folder = Helper::GetFolder($this->folder);
                $newimage = $request->file('file');
                if($newimage){ $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); }
            }


            if($request->hasFile('background')){ 
                $row = $this->categoryRepo->GetOneItem($id, $this->relations);               
                $oldimage = @$row['background'];
                $folder = Helper::GetFolder($this->folder);
                $newimage = $request->file('background');
                if($newimage){ $data['background'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); }
            }
            
            //### Code xử lý...
            $row = $this->categoryRepo->SaveItem($data,$id);

            //### Code xử lý: cập nhật thông tin level của các cấp category con
            $this->UpdateLevelChild($row,$type);


            //### Code xử lý: watermark
            if($width!=null){
                Thumb::Crop($this->folder_upload,$row->photo,$width,$height,1,$type);
            }

            //### Code xử lý: hash photo
            if(!$id){
                $this->galleryRepo->UpdateHashGallery($row->id,$hash);
            }

            //### Hiển thị giao diện
            if($savehere){                
                return redirect()->route($this->routeEdit,[$type,$row->id]);
            }else{
                return redirect()->route($this->routeShow,[$type]);
            }
        }
    }

    public function UpdateLevelChild($row,$type){
        $id = $row->id;
        $id_parent = $row->id_parent;
        $level_parent = $row->level;

        $params = array('id_parent'=>$id);
        $items = $this->categoryRepo->GetAllItems($type,$params,$this->relations);
        foreach($items as $k=>$v){
            $data['level'] = $level_parent+1;
            $row = $this->categoryRepo->SaveItem($data,$v['id']);
            $this->UpdateLevelChild($row,$type);
        }
    }


    public function UpdateCategoryChild($type,$id){
        $rows_child = $this->categoryRepo->GetAllItems($type,['id_parent'=>$id], null,false);
        foreach($rows_child as $k=>$v){
            //### update id_parent cho category child
            $data_child = array();
            $data_child['level'] = $v['level']-1;
            $this->categoryRepo->SaveItem($data_child,$v['id']);

            //### đệ quy update level cho category child của child hiện tại
            $this->UpdateCategoryChild($type,$v['id']);
            
        }
    }


    public function DoDelete($type,$id){
        //### lấy category hiện tại
        $row_category = $this->categoryRepo->GetOneItem($id);
        $id_parent = $row_category['id_parent'];
        

        //### lấy ds category con và update thông tin
        $rows_child = $this->categoryRepo->GetAllItems($type,['id_parent'=>$id], null,false);        
        foreach($rows_child as $k=>$v){
            //### update id_parent cho category child
            $data_child = array();
            $data_child['id_parent'] = $id_parent;
            $data_child['level'] = $v['level']-1;
            $this->categoryRepo->SaveItem($data_child,$v['id']);

            //### đệ quy update level cho category child của child hiện tại
            $this->UpdateCategoryChild($type,$v['id']);
            
        }

        //### Lấy ds sản phẩm thuộc category đang xóa và update lại id_category về 0 cho sp đó
        $ids_product = $this->productRepo->GetAllItemsByParamsPluck('id',['id_category'=>$id, 'type' => $type]);  
        if($ids_product){
            $this->productRepo->SaveMultiItem(['id_category'=>0],$ids_product);
        }
    }
}
