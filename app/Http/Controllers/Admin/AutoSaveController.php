<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use DB;

use Helper, Thumb;
use CartHelper;

class AutoSaveController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Ajax Auto save after 5 minutes
    |--------------------------------------------------------------------------
    */
    public function AutoSave(Request $request){
        $model = $request->model;

        switch ($model) {
            case 'post':                
                $this->SavePost($request);
                break;
            case 'product':             
                $this->SaveProduct($request);
                break;
            case 'album':
                $this->SaveAlbum($request);
                break;
            default:
                // code...
                break;
        }

    }

    public function SaveAlbum($request){
        $id = $request->id;
        $id_parent = $request->id_parent;
        $model = $request->model;
        
        $data = $request->data;
        $dataOption = $request->dataOption;
        $dataColor = $request->dataColor;
        $deleteOptionItems = (isset($request->option_delete)) ? $request->option_delete : '';
        $width = ($request->width)?$request->width:null;
        $height = ($request->height)?$request->width:null;
        $dataUser = $request->dataUser;
        $type = $request->type;

        $folder = 'album';
        $folder_upload = config('config_upload.UPLOAD_ALBUM');
        $relations = ['HasAllChild'];
        $relationsCate = ['CategoryParent'];

        if($data && $id){
            $data['tenvi'] = ($data['tenvi']=='') ? 'draft-'.time() : $data['tenvi'];
            $data['tenkhongdauvi'] = (isset($data['slugvi']) && $data['slugvi']!='') ? $data['slugvi'] : ((isset($data['tenvi'])) ? Str::slug($data['tenvi'], '-') : '');
            $data['tenkhongdauen'] = (isset($data['slugen']) && $data['slugen']!='') ? $data['slugen'] : ((isset($data['tenen'])) ? Str::slug($data['tenen'], '-') : '');
            $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;

            //### Lấy thông tin category parent
            $data['id_category'] = $id_parent;

            $width = ($request->width)?$request->width:null;
            $height = ($request->height)?$request->width:null;

            $getimage='';
            if($request->hasFile('file')){
                $row = $this->albumRepo->GetOneItem($id, $relations);
                $oldimage = $row['photo'];
                //Lưu hình ảnh vào thư mục public/upload/post
                $folder = Helper::GetFolder($folder);
                $newimage = $request->file('file');
                if($newimage){ $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); }
            }

            //### Code xử lý...
            $row = $this->albumRepo->SaveItem($data,$id);

            //### Code xử lý: watermark
            if($width!=null){
                Thumb::Crop($folder_upload,$row->photo,$width,$height,1,$type);
            }
        }
    }


    public function SavePost($request){
        $id = $request->id;
        $id_parent = $request->id_parent;
        $model = $request->model;
        
        $data = $request->data;
        $dataOption = $request->dataOption;
        $dataColor = $request->dataColor;
        $deleteOptionItems = (isset($request->option_delete)) ? $request->option_delete : '';
        $width = ($request->width)?$request->width:null;
        $height = ($request->height)?$request->width:null;
        $dataUser = $request->dataUser;
        $type = $request->type;

        $folder = 'post';
        $folder_upload = config('config_upload.UPLOAD_POST');
        $relations = ['HasAllChild'];
        $relationsCate = ['CategoryParent'];

        if($data && $id){
            $data['tenvi'] = ($data['tenvi']=='') ? 'draft-'.time() : $data['tenvi'];
            $data['tenkhongdauvi'] = (isset($data['slugvi']) && $data['slugvi']!='') ? $data['slugvi'] : ((isset($data['tenvi'])) ? Str::slug($data['tenvi'], '-') : '');
            $data['tenkhongdauen'] = (isset($data['slugen']) && $data['slugen']!='') ? $data['slugen'] : ((isset($data['tenen'])) ? Str::slug($data['tenen'], '-') : '');
            $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;

            if($dataUser){
                if($dataUser){
                    $row = $this->postRepo->GetOneItem($id, $relations);
                    $userrating = json_decode($row['userrating'],true);
                    
                    $oldimage = (isset($userrating['photo'])) ? $userrating['photo'] : '';

                    //Lưu hình ảnh vào thư mục public/upload/post
                    $folder = Helper::GetFolder($folder);
                    $newimage = (isset($dataUser['photo'])) ? $dataUser['photo'] : '';
                    if($newimage){ $dataUser['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); }
                    else{$dataUser['photo']=$oldimage;}
                }
                $data['userrating'] = json_encode($dataUser);
            }

            //### Lấy thông tin category parent
            $data['id_category'] = ($id_parent) ? $id_parent : 0;

            $width = ($request->width)?$request->width:null;
            $height = ($request->height)?$request->width:null;

            if(isset($request->tags_group) && ($request->tags_group != '')) $data['id_tags'] = implode(",", $request->tags_group);
            else $data['id_tags'] = "";

            $getimage='';
            if($request->hasFile('file')){
                $row = $this->postRepo->GetOneItem($id, $relations);
                $oldimage = $row['photo'];
                //Lưu hình ảnh vào thư mục public/upload/post
                $folder = Helper::GetFolder($folder);
                $newimage = $request->file('file');
                if($newimage){ $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); }
            }

            //### Code xử lý...
            $row = $this->postRepo->SaveItem($data,$id);

            //### Code xử lý: watermark
            if($width!=null){
                Thumb::Crop($folder_upload,$row->photo,$width,$height,1,$type);
            }
        }
    }


    public function SaveProduct($request){
        $id = $request->id;
        $id_parent = $request->id_parent;
        $model = $request->model;
        
        $data = $request->data;
        $dataOption = $request->dataOption;
        $dataColor = $request->dataColor;
        $deleteOptionItems = (isset($request->option_delete)) ? $request->option_delete : '';
        $width = ($request->width)?$request->width:null;
        $height = ($request->height)?$request->width:null;

        $folder = 'product';
        $folder_upload = config('config_upload.UPLOAD_PRODUCT');
        $relations = ['HasProductOptions', 'HasProductOptionsAll', 'HasAllChild'];
        $relationsOpt = ['ProductParent', 'ColorOption', 'SizeOption'];
        $relationsCate = ['CategoryParent'];
        $type = $request->type;

        if($dataColor){
            $data['masp_color'] = json_encode($dataColor);
        }


        if($data && $id){
            $data['tenvi'] = ($data['tenvi']=='') ? 'draft-'.time() : $data['tenvi'];
            $data['tenkhongdauvi'] = (isset($data['slugvi']) && $data['slugvi']!='') ? $data['slugvi'] : ((isset($data['tenvi'])) ? Str::slug($data['tenvi'], '-') : '');
            $data['tenkhongdauen'] = (isset($data['slugen']) && $data['slugen']!='') ? $data['slugen'] : ((isset($data['tenen'])) ? Str::slug($data['tenen'], '-') : '');
            $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;

            $data['dai'] = (isset($data['dai']) && $data['dai'] != '') ? str_replace(",","",$data['dai']) : 0;
            $data['rong'] = (isset($data['rong']) && $data['rong'] != '') ? str_replace(",","",$data['rong']) : 0;
            $data['cao'] = (isset($data['cao']) && $data['cao'] != '') ? str_replace(",","",$data['cao']) : 0;
            $data['khoiluong'] = (isset($data['khoiluong']) && $data['khoiluong'] != '') ? str_replace(",","",$data['khoiluong']) : 0;

            $data['giacu'] = (isset($data['giacu']) && $data['giacu'] != '') ? str_replace(",","",$data['giacu']) : 0;
            $data['gia'] = (isset($data['gia']) && $data['gia'] != '') ? str_replace(",","",$data['gia']) : 0;
            $data['giamoi'] = (isset($data['giamoi']) && $data['giamoi'] != '') ? str_replace(",","",$data['giamoi']) : 0;
            $data['giakm'] = (isset($data['giakm']) && $data['giakm'] != '') ? $data['giakm'] : 0;

            //### Lấy thông tin category parent
            $data['id_category'] = ($id_parent) ? $id_parent : 0;

            // ### cập nhật group color - size
            if(isset($request->size_group) && ($request->size_group != '')) $data['id_size'] = implode(",", $request->size_group);
            else $data['id_size'] = "";

            if(isset($request->mau_group) && ($request->mau_group != '')) $data['id_mau'] = implode(",", $request->mau_group);
            else $data['id_mau'] = "";

            if(isset($request->tags_group) && ($request->tags_group != '')) $data['id_tags'] = implode(",", $request->tags_group);
            else $data['id_tags'] = "";


            //### Lưu hình ảnh vào thư mục public/upload/product
            $getimage='';
            if($request->hasFile('file')){
                $row = $this->productRepo->GetOneItem($id, $relations);
                $oldimage = $row['photo'];
                $folder = Helper::GetFolder($folder);
                $newimage = $request->file('file');
                if($newimage){ $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); }
            }

            if($request->hasFile('file2')){
                $row = $this->productRepo->GetOneItem($id, $relations);
                $oldimage = $row['photo2'];
                $folder = Helper::GetFolder($folder);
                $newimage = $request->file('file2');
                if($newimage){ $data['photo2'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); }
            }
            
            //### Code xử lý...
            $row = $this->productRepo->SaveItem($data,$id);
              
            //### Code xử lý: watermark
            if($width!=null){
                Thumb::Crop($folder_upload,$row->photo,$width,$height,1,$type);
            }

            // ### cập nhật product_option
            if(isset($dataOption)){              
                foreach($dataOption as $k=>$v){
                    $param = $v;
                    $idOption = $param['id'];
                    $param['id_product']=$row['id'];
                    $param['dai'] = (isset($param['dai']) && $param['dai'] != '') ? str_replace(",","",$param['dai']) : 0;
                    $param['rong'] = (isset($param['rong']) && $param['rong'] != '') ? str_replace(",","",$param['rong']) : 0;
                    $param['cao'] = (isset($param['cao']) && $param['cao'] != '') ? str_replace(",","",$param['cao']) : 0;
                    $param['khoiluong'] = (isset($param['khoiluong']) && $param['khoiluong'] != '') ? str_replace(",","",$param['khoiluong']) : 0;
                    
                    $param['giacu'] = (isset($param['giacu']) && $param['giacu'] != '' && $param['giacu']!=0) ? str_replace(",","",$param['giacu']) : $row->giacu;
                    $param['gia'] = (isset($param['gia']) && $param['gia'] != '' && $param['gia']!=0) ? str_replace(",","",$param['gia']) : $row->gia;
                    $param['giamoi'] = (isset($param['giamoi']) && $param['giamoi'] != '' && $param['giamoi']!=0) ? str_replace(",","",$param['giamoi']) : $row->giamoi;
                    $param['giakm'] = (isset($param['giakm']) && $param['giakm'] != '' && $param['giakm']!=0) ? $param['giakm'] : $row->giakm;
                    $param['xoatam'] = $param['xoatam'];
                    $param['hienthi'] = $data['hienthi'];
                    $param['type'] = $type;

                    $getimage='';
                    if($request->hasFile('file-'.$k)){
                        $row_option = $this->productOptRepo->GetOneItem($idOption,$relationsOpt);
                        $oldimage = $row_option['photo'];
                        $folder = Helper::GetFolder($folder);
                        $newimage = $request->file('file-'.$k);

                        if($newimage){ $param['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); }
                    }

                    $row_op = $this->productOptRepo->SaveItem($param,$idOption);

                    //### Code xử lý: watermark
                    if($width!=null){
                        Thumb::Crop($folder_upload,$row_op->photo,$width,$height,1,$type);
                    }
                }
            }

            //### Code xóa những product option
            if($deleteOptionItems!=''){
                $ids = explode(",", $deleteOptionItems);
                foreach($ids as $i=>$item){
                    $rowOption = $this->productOptRepo->GetOneItem($item,$relationsOpt);
                    $image_path = Helper::GetFolder($folder).$rowOption['photo'];
                    Helper::DeleteImage($image_path);
                }
                $this->productOptRepo->DeleteMultiItem($deleteOptionItems,$folder);
            }
            //### Hiển thị giao diện
        }
    }
}
