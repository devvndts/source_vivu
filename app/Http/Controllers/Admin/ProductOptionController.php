<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;
use Illuminate\Support\Str;

use App\Lazada\LazadaPlatformAPI;

use Helper, Thumb;

class ProductOptionController extends Controller
{
    //
    use SupportTrait;
    private $type, $table, $viewShow, $viewEdit, $config, $proParent, $modelSize, $modelColor, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error, $folder_upload;
    private $routeShow = 'admin.productOption.show';
    private $routeEdit = 'admin.productOption.edit';
    private $folder = "product";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
    	$this->category = $request->category;
    	$this->type = $request->type;       
        $this->config = config('config_type.product');
        $this->viewShow = 'admin.templates.productOption.man.productOption';
        $this->viewEdit = 'admin.templates.productOption.man.productOption_add';
        $this->folder_upload = config('config_upload.UPLOAD_PRODUCT');

        //permission
        $this->page_error = redirect()->back();
        $this->permissionShow = 'product_man_'.$this->type;
        $this->permissionAdd = 'product_add_'.$this->type;
        $this->permissionEdit = 'product_edit_'.$this->type;
        $this->permissionDelete = 'product_delete_'.$this->type;

        $this->relations = $this->productRepo->GetRelationsRepo(); //['HasProductOptions', 'HasProductOptionsAll', 'HasAllChild'];
        $this->relationsOpt = $this->productOptRepo->GetRelationsRepo(); //['ProductParent', 'ColorOption', 'SizeOption'];
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
        $params['id_product'] = $idParent = ($request->id_product) ? $request->id_product : 0;
        $params['keyword'] = ($request->keyword) ? $request->keyword : '';
        $params['xoatam'] = 0;
        $params['phienbanmau'] = 0;

        //### Code xử lý...
        $itemShow = $this->productOptRepo->GetAllItems($type,$params,$this->relationsOpt,$this->pagination);


        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'itemShow'=> $itemShow,
            'type'=> $type,
            'idParent'=>$idParent,
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
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
    	//$category = $request->category;
    	$id = $request->id;
        $type = $request->type;

        //### Code xử lý...
        $rowItem = $this->productOptRepo->GetOneItem($id);
        $gallery = $this->galleryRepo->GetAllGallery($type,$id,'productOption');

        //### Get Colors by id_product
        $idParent = ($request->id_product) ? $request->id_product : (($rowItem['id_product']) ? $rowItem['id_product'] :0);
        $rowParent = $this->productRepo->GetOneItem($idParent, $this->relations);
        $arr_colors = $this->GetColor(explode(",", $rowParent['id_mau']));
        $arr_sizes = $this->GetSize(explode(",", $rowParent['id_size']));

        //### lấy ds gallery_multy
        if (isset($rowItem) && $rowItem['gallery'] != '') {
            $gallery_multy = $this->galleryRepo->GetAllItemByIds(explode(',',$rowItem['gallery']));
        }

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'type'=> $type,
            'idParent'=>$idParent,
            'arr_colors'=>$arr_colors,
            'arr_sizes'=>$arr_sizes,
            'config'=>$this->config,
            'gallery'=>$gallery,
            'folder_upload'=>$this->folder,
            'gallery_multy' => $gallery_multy ?? 0,
        );

    	return view($this->viewEdit)->with($response);
    }

    /*
    |--------------------------------------------------------------------------
    | Get color info
    |--------------------------------------------------------------------------
    */
    public function GetColor($arr_colors){
        //### khởi tạo giá trị cho model
        //$this->initialization($request);

        //$arr_colors: mảng id color đầu vào
        return $this->colorRepo->GetAllItemByIds($arr_colors);
    }

    /*
    |--------------------------------------------------------------------------
    | Get size info
    |--------------------------------------------------------------------------
    */
    public function GetSize($arr_sizes){
        //### khởi tạo giá trị cho model
        //$this->initialization($request);

        //$arr_sizes: mảng id size đầu vào
        return $this->sizeRepo->GetAllItemByIds($arr_sizes);
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
        $idParent = ($request->id_product) ? $request->id_product : 0;

        $this->productOptRepo->DeleteTMPOneItem($id);
        $this->galleryRepo->DeleteGallery($id,$category,$type,'product','productOption');

    	return redirect()->route($this->routeShow,[$category,$type,'id_product'=>$idParent]);
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
        $idParent = ($request->id_product) ? $request->id_product : 0;
        if($listid!=''){
            $this->productOptRepo->DeleteTMPMultiItem($listid);
            //$this->galleryRepo->DeleteMultiGallery($listid,$category,$type,'product','productOption');
        }

        return redirect()->route($this->routeShow,[$category,$type,'id_product'=>$idParent]);
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

        $width = $request->width;
        $height = $request->height;

        if($data){
            $data['type'] = $type;
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
            $data['xoatam']=0;
            if($id){
                $data['ngaysua'] = time();
    		}else{
    			$data['ngaytao'] = $data['ngaysua'] = time();
    		}

            //### Lưu hình ảnh vào thư mục public/upload/product
            $getimage='';
            if($request->hasFile('file')){
                $row = $this->productOptRepo->GetOneItem($id);
                $oldimage = $row['photo'];
                $folder = Helper::GetFolder("product");
                $newimage = $request->file('file');
                if($newimage){ $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder); }
            }

            //### Code xử lý...
            $row = $this->productOptRepo->SaveItem($data,$id);

            //### Code xử lý: watermark
    		if($width!=null){
    			Thumb::Crop($this->folder_upload,$row->photo,$width,$height,1,$type);
    		}

            if (!$id && $hash !='') {
                $this->gallery->where('hash', $hash)->update(['id_photo'=>$row->id,'hash'=>'']);
            }


            //### cập nhật số lượng sản phẩm lazada
            if($row && config('lazada')['excute']){
                $arr_product[] = $row->toArray();
                $lazada_api = new LazadaPlatformAPI();
                $lazada_api->updateQCProduct_Lazada($arr_product);
            }

            //### Hiển thị giao diện
            if($savehere){
                return redirect()->route($this->routeEdit,[$category,$type,$row->id]);
            }else{
                return redirect()->route($this->routeShow,[$category,$type,'id_product'=>$row->id_product]);
            }
        }
    }
}
