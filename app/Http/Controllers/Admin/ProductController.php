<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;

use Illuminate\Support\Str;

use App\Exports\ProductExport;
use App\Imports\ProductImport;
use App\Models\Category;
use Maatwebsite\Excel\Facades\Excel;

use Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Thumb;
use TableManipulation;

class ProductController extends Controller
{
    use SupportTrait;

    private $type;
    private $table;
    private $viewShow;
    private $viewEdit;
    private $config;
    private $config_tags;
    private $permissionShow;
    private $permissionAdd;
    private $permissionEdit;
    private $permissionDelete;
    private $permissionImport;
    private $permissionExport;
    private $page_error;
    private $folder_upload;
    private $viewImport = 'admin.imports.product.man.import';
    private $viewImportImages = 'admin.imports.product.man.importImages';
    private $routeShow = 'admin.product.show';
    private $routeEdit = 'admin.product.edit';
    private $folder = "product";
    private $folderPost = "post";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";


    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request)
    {
        //### set request value
        $this->category = $request->category;
        $this->type = $request->type;
        $this->config = config('config_type.product');
        $this->config_tags = config('config_type.tags');
        $this->page_error = redirect()->back();
        $this->folder_upload = config('config_upload.UPLOAD_PRODUCT');

        //### set repo relation
        $this->relations = $this->productRepo->GetRelationsRepo(); //['HasProductOptions', 'HasProductOptionsAll', 'HasAllChild'];
        $this->relationsOpt = $this->productOptRepo->GetRelationsRepo(); //['ProductParent', 'ColorOption', 'SizeOption'];
        $this->relationsCate = $this->categoryRepo->GetRelationsRepo(); //['CategoryParent'];
        $this->relationsPost = $this->postRepo->GetRelationsRepo(); //['HasAllChild'];

        $this->viewShow = 'admin.templates.product.man.product';
        $this->viewEdit = 'admin.templates.product.man.product_add';

        $this->permissionShow = 'product_man_'.$this->type;
        $this->permissionAdd = 'product_add_'.$this->type;
        $this->permissionEdit = 'product_edit_'.$this->type;
        $this->permissionDelete = 'product_delete_'.$this->type;
        $this->permissionImport = 'product_import_'.$this->type;
        $this->permissionExport = 'product_export_'.$this->type;
    }


    /*
    |--------------------------------------------------------------------------
    | Hiển thị danh sách dữ liệu tương ứng với category
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
        $params['id_list'] = $request->id_list ?? 0;
        $params['id_cat'] = $request->id_cat ?? 0;
        $params['id_item'] = $request->id_item ?? 0;
        $params['id_sub'] = $request->id_sub ?? 0;
        $params['keyword'] = $request->keyword ?? '';
        if ($request->id_category) {
            $params['id_category'] = $arr_childCategory;
        }
        if ($request->filter_category_value) {
            $params[$request->filter_category_field] = $request->filter_category_value;
        }

        //### Code xử lý...
        $itemShow = $this->productRepo->GetAllItems($type, $params, $this->relations, $this->pagination);
        $query_str = Helper::SetQuery($request->query);
        $arrCategory = DB::table('category')->select('id', 'level', 'tenkhongdauvi', 'tenkhongdauen', 'tenvi', 'tenen', 'ids_level_1', 'ids_level_2', 'ids_level_3', DB::raw('(CASE 
        WHEN CAST(ids_level_3 AS SIGNED) > 0 THEN CAST(ids_level_3 AS SIGNED)
        WHEN CAST(ids_level_2 AS SIGNED) > 0 THEN CAST(ids_level_2 AS SIGNED)
        ELSE CAST(ids_level_1 AS SIGNED)
            END) AS parent_id '))->whereRaw("type = '$type'")->get();

        //### Trả về giao diện
        $response = array(
            'arrCategory' => $arrCategory ?? null,
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
            'folder_upload'=>$this->folder,
            'config_tags'=>$this->config_tags,
        );
        return view($this->viewEdit)->with($response);
    }

    /*
    |--------------------------------------------------------------------------
    | Hiển thị trang chỉnh sửa 1 dòng dữ liệu
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


        //### Tạo bản nháp
        if (!$id) {
            $id = Helper::CreateDraft('product', $type);
            return redirect()->route($this->routeEdit, [$this->category,$type,$id]);
        }


        //### Code xử lý...
        $rowItem = (array) $this->productRepo->GetOneItem($id, $this->relations);
        $gallery = $this->galleryRepo->GetAllGallery($type, $id, 'product', ['val' => $type]);
        $taptin = $this->galleryRepo->GetAllGallery($type, $id, 'product', ['val' => 'taptin']);
        $numberOption = ($id && isset($rowItem['has_product_options']))?count($rowItem['has_product_options']):0;

        //### Code xử lý: lấy category
        $row_category = (array) $this->categoryRepo->GetOneItem($rowItem['id_category'] ?? 0, $this->relationsCate);
        $row_category_tenvi = $row_category['tenvi'] ?? '';
        $category = array(
            'id' => $rowItem['id'] ?? 0,
            'id_parent' => $rowItem['id_category'] ?? 0,
            'tenvi' => $row_category_tenvi,
            'tenvi_parent' => $row_category_tenvi
        );

        $danhmucparent = $this->categoryRepo->GetAll($type);

        //### lấy ds gallery_multy
        $gallery_multy = $this->galleryRepo->GetAllItemByIds(explode(',', $rowItem['gallery'] ?? 0));
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
            'taptin'=>$taptin,
            'folder_upload'=>$this->folder,
            'numberOption'=>$numberOption,
            'config_tags'=>$this->config_tags,
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
        
        //### Delete product con
        $rows_child = $this->productOptRepo->GetAllItems($type, ['id_product'=>$id], $this->relationsOpt, false);
        foreach ($rows_child as $k => $v) {
            $this->productOptRepo->DeleteOneItem($v['id'], $this->folder);
            $this->galleryRepo->DeleteGallery($v['id'], $category, $type, 'product', 'productOption');
        }

        //### Delete post relate
        $rows_post = $this->postRepo->GetAllItems('', ['id_product'=>$id], $this->relationsPost, false);
        foreach ($rows_post as $k => $v) {
            $this->postRepo->DeleteOneItem($v['id'], $this->folderPost);
            $this->galleryRepo->DeleteGallery($v['id'], $category, $v['type'], 'post', 'post');
        }

        //### Delete sale relate
        $rows_sale = $this->saleProductRepo->GetAllItems('', ['product_id'=>$id], null, false);
        foreach ($rows_sale as $k => $v) {
            $this->saleProductRepo->DeleteOneItem($v['id']);
        }

        //### Delete product cha
        $this->productRepo->DeleteOneItem($id, $this->folder);
        $this->galleryRepo->DeleteGallery($id, $category, $type, 'product', 'product');

        return redirect()->route($this->routeShow, [$category,$type]);
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

        //### Delete product con
        $arr_child = explode(",", $listid);
        foreach ($arr_child as $pro => $productParent) {
            $rows_child = $this->productOptRepo->GetAllItems($type, ['id_product'=>$productParent], $this->relationsOpt, false);
            foreach ($rows_child as $k => $v) {
                $this->productOptRepo->DeleteOneItem($v['id'], $this->folder);
                $this->galleryRepo->DeleteGallery($v['id'], $category, $type, 'product', 'product');
            }

            //### Delete post relate
            $rows_post = $this->postRepo->GetAllItems('q_a', ['id_product'=>$productParent], $this->relationsPost, false);
            foreach ($rows_post as $k => $v) {
                $this->postRepo->DeleteOneItem($v['id'], $this->folderPost);
                $this->galleryRepo->DeleteGallery($v['id'], $category, $v['type'], 'post', 'post');
            }

            //### Delete sale relate
            $rows_sale = $this->saleProductRepo->GetAllItems('', ['product_id'=>$productParent], null, false);
            foreach ($rows_sale as $k => $v) {
                $this->saleProductRepo->DeleteOneItem($v['id']);
            }
        }

        if ($listid!='') {
            $this->productRepo->DeleteMultiItem($listid, $this->folder);
            $this->galleryRepo->DeleteMultiGallery($listid, $category, $type, 'product', 'product');
        }

        return redirect()->route($this->routeShow, [$category,$type]);
    }

    public function saveProductGallery(Request $request)
    {
        $myfileIds = $request->myfile['id'] ?? [];
        $myfileNames = $request->myfile['name'] ?? [];
        $myfileDescs = $request->myfile['desc'] ?? [];
        $myfileFiles = $request->myfile['file'] ?? [];

        foreach ($myfileIds as $mfKey => $mfValue) {
            $myfileData = [];
            $myfileData['id_photo'] = $request->id ?? 0;
            $myfileData['tenvi'] = $myfileNames[$mfKey] ?? '';
            $myfileData['motavi'] = $myfileDescs[$mfKey] ?? '';
            $myfileData['type'] = $request->type ?? '';
            $myfileData['com'] = $request->model ?? '';
            $myfileData['kind'] = $request->level ?? '';
            $myfileData['val'] = 'taptin';
            $myfileData['stt'] = $mfKey + 1;
            $myfileData['hienthi'] = 1;
            $myfileData['ngaytao'] = time();

            if ($mfValue == 0) {
                // add record to gallery
                if (isset($myfileFiles[$mfKey])) {
                    $folder = Helper::GetFolder($this->folder);
                    // $newimage = $request->file("myfile")['file'][$mfKey];
                    $newimage = $myfileFiles[$mfKey];
                    if ($newimage) {
                        $myfileData['taptin'] = Helper::UploadImageToFolder($newimage, '', $folder);
                    }
                }
                $myfileRow = $this->galleryRepo->SaveItem($myfileData);
            } else {
                // edit record to gallery
                if (isset($myfileFiles[$mfKey])) {
                    $rowGallery = $this->galleryRepo->GetOneItem($mfValue);
                    $oldimage = $rowGallery['taptin'];
                    $folder = Helper::GetFolder($this->folder);
                    $newimage = $myfileFiles[$mfKey];
                    if ($newimage) {
                        $myfileData['taptin'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
                    }
                }
                $myfileRow = $this->galleryRepo->SaveItem($myfileData, $mfValue);
            }
        }
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
        //dd('ok');
        
        //### Thiết lập giá trị thuộc tính
        $idgoi = $request->idgoi;
        $tengoi = $request->tengoi;
        $textgoi = $request->textgoi;
        $sttgoi = $request->sttgoi;
        $category = $request->category;
        $id_parent = $request->id_parent;
        $type = $request->type;
        $id = $request->id;
        $hash = $request->hash;
        $hash_color = $request->hash_color;
        $savehere = ($request->has('savehere'))?true:false;
        $savedraft = ($request->has('savedraft'))?true:false;

        $data = $request->data;
        // $data1 = $request->data1;
        $dataOption = $request->dataOption;
        $dataSlOptions = $request->dataSlOptions;
        $dataColor = $request->dataColor;
        $deleteOptionItems = (isset($request->option_delete)) ? $request->option_delete : '';
        $width = ($request->width)?$request->width:null;
        $height = ($request->height)?$request->width:null;

        $row_sl_opt = $this->productRepo->GetOneItem($id);
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

        static::saveProductGallery($request);

        if ($dataColor) {
            $data['masp_color'] = json_encode($dataColor);
        }

        if ($data) {
            $data['type'] = $type;
            $data['tenkhongdauvi'] = (isset($data['slugvi']) && $data['slugvi']!='') ? $data['slugvi'] : ((isset($data['tenvi'])) ? Str::slug($data['tenvi'], '-') : '');
            $data['tenkhongdauen'] = (isset($data['slugen']) && $data['slugen']!='') ? $data['slugen'] : ((isset($data['tenen'])) ? Str::slug($data['tenen'], '-') : '');
            $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;

            $data['dai'] = (isset($data['dai']) && $data['dai'] != '') ? str_replace(",", "", $data['dai']) : 0;
            $data['rong'] = (isset($data['rong']) && $data['rong'] != '') ? str_replace(",", "", $data['rong']) : 0;
            $data['cao'] = (isset($data['cao']) && $data['cao'] != '') ? str_replace(",", "", $data['cao']) : 0;
            $data['khoiluong'] = (isset($data['khoiluong']) && $data['khoiluong'] != '') ? str_replace(",", "", $data['khoiluong']) : 0;

            $data['giacu'] = (isset($data['giacu']) && $data['giacu'] != '') ? str_replace(",", "", $data['giacu']) : 0;
            $data['gia'] = (isset($data['gia']) && $data['gia'] != '') ? str_replace(",", "", $data['gia']) : 0;
            $data['giamoi'] = (isset($data['giamoi']) && $data['giamoi'] != '') ? str_replace(",", "", $data['giamoi']) : 0;
            $data['giakm'] = (isset($data['giakm']) && $data['giakm'] != '') ? $data['giakm'] : 0;
            $data['id_size'] = $data['id_mau'] = "";
            if (isset($data['cta_link'])) {
                foreach ($data['cta_link'] as $k2 => $v2) {
                    $cta_link[$k2] = htmlspecialchars($v2);
                }
            }
            $data['cta_link'] = @serialize($cta_link);
            //### Lấy thông tin category parent
            $data['id_category'] = ($id_parent) ? $id_parent : 0;

            if ($id) {
                $data['ngaysua'] = time();
            } else {
                $data['ngaytao'] = $data['ngaysua'] = time();
            }
            
            $aTemp = [];
            if (isset($data['attribute'])) {
                foreach ($this->config[$type]['attribute'] as $keyConfig => $valueConfig) {
                    $attributeId = $valueConfig['id'];
                    $attributeParams = array_keys($valueConfig['params']);
                    $firstParams = $data['attribute'][$attributeId];
                    if ($attributeParams) {
                        foreach ($firstParams[$attributeParams[0]] as $key => $value) {
                            foreach ($attributeParams as $keyParam => $valueParam) {
                                $aTemp[$attributeId][$key][$valueParam] = $firstParams[$valueParam][$key];
                            }
                        }
                    }
                }
                $data['attribute'] = json_encode($aTemp);
            } else {
                $data['attribute'] = null;
            }
            //### kiểm tra lưu nháp ?
            $data['draft'] = 0;
            if ($savedraft) {
                $data['draft'] = 1;
                $data['hienthi'] = 0;
            }
            $data['hienthi'] = 1;

            //### lấy ids theo level
            $level_cate_max = $this->categoryRepo->Query()->max('level')+1;
            if ($level_cate_max) {
                for ($i=1; $i<=$level_cate_max; $i++) {
                    TableManipulation::AddFieldToTable('product', 'ids_level_'.$i, 'string');
                    $data['ids_level_'.$i] = (isset($request->ids_level[$i])) ? implode(',', $request->ids_level[$i]) : '';
                }
            }

            // ### cập nhật group color - size
            if (isset($this->config[$type]['size']) && $this->config[$type]['size'] == true) {
                if (isset($request->size_group) && ($request->size_group != '')) {
                    $data['id_size'] = implode(",", $request->size_group);
                } else {
                    $data['id_size'] = "";
                }
            }

            if (isset($this->config[$type]['mau']) && $this->config[$type]['mau'] == true) {
                if (isset($request->mau_group) && ($request->mau_group != '')) {
                    $data['id_mau'] = implode(",", $request->mau_group);
                } else {
                    $data['id_mau'] = "";
                }
            }

            if (isset($this->config[$type]['tags']) && $this->config[$type]['tags'] == true) {
                if (isset($request->tags_group) && ($request->tags_group != '')) {
                    $data['id_tags'] = implode(",", $request->tags_group);
                } else {
                    $data['id_tags'] = "";
                }
            }

            //### Lưu hình ảnh vào thư mục public/upload/product
            $getimage='';
            if ($request->hasFile('file')) {
                $row = $this->productRepo->GetOneItem($id, $this->relations);
                $oldimage = $row['photo'];
                $folder = Helper::GetFolder($this->folder);
                $newimage = $request->file('file');
                if ($newimage) {
                    $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
                }
            }

            if ($request->hasFile('file2')) {
                $row = $this->productRepo->GetOneItem($id, $this->relations);
                $oldimage = $row['photo2'];
                $folder = Helper::GetFolder($this->folder);
                $newimage = $request->file('file2');
                if ($newimage) {
                    $data['photo2'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
                }
            }

            if ($request->hasFile('file3')) {
                $row = $this->productRepo->GetOneItem($id, $this->relations);
                $oldimage = $row['photo3'];
                $folder = Helper::GetFolder($this->folder);
                $newimage = $request->file('file3');
                if ($newimage) {
                    $data['photo3'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
                }
            }


            //### Code xử lý : lưu thông tin sản phẩm chính
            $row = $this->productRepo->SaveItem($data, $id);
            if ($idgoi) {
                foreach ($idgoi as $kgoi => $vgoi) {
                    $dataGoi = [];
                    $id_idgoi = null;
                    // # $vgoi != null => update
                    // # else insert
                    $dataGoi['tenvi'] = $tengoi[$kgoi];
                    $dataGoi['motavi'] = $textgoi[$kgoi];
                    $dataGoi['stt'] = (int)$sttgoi[$kgoi];
                    
                    if ($vgoi) {
                        $dataGoi['ngaysua'] = time();
                        $id_idgoi = $vgoi;
                    } else {
                        $dataGoi['id_product'] = $id;
                        $dataGoi['type'] = 'q_a';
                        $dataGoi['ngaytao'] = time();
                        $dataGoi['hienthi'] = 1;
                    }
                    $this->postRepo->SaveItem($dataGoi, $id_idgoi);
                }
            }


            //### Code xử lý: lưu thông tin sản phẩm con. Nếu id_size và id_mau == '' ====> tạo 1 phiên bản mãu (thuộc phiên bản con) với thông tin của phiên bản cha , ngược lại nếu có cập nhật màu hoặc size thì ẩn phiên bản mẫu đi
            //if($data['id_size']=='' && $data['id_mau']==''){
            $row_opt = $this->productOptRepo->GetItem(['phienbanmau'=>1, 'id_product'=>$row->id]);
            $idOpt = ($row_opt) ? $row_opt['id'] : null;
            $dataOpt['tenvi'] = $row['tenvi'];
            $dataOpt['dai'] = $row['dai'];
            $dataOpt['rong'] = $row['rong'];
            $dataOpt['cao'] = $row['cao'];
            $dataOpt['khoiluong'] = $row['khoiluong'];
            $dataOpt['photo'] = $row['photo'];
            $dataOpt['giacu'] = $row['giacu'];
            $dataOpt['gia'] = $row['gia'];
            $dataOpt['giamoi'] = $row['giamoi'];
            $dataOpt['giakm'] = $row['giakm'];
            $dataOpt['hienthi'] = $row['hienthi'];
            $dataOpt['type'] = $type;
            $dataOpt['phienbanmau'] = 1; // Phiên bản mẫu
            $dataOpt['id_product'] = $row['id'];
            $dataOpt['masp'] = $row['masp'];
            $dataOpt['gallery'] = $row['gallery'];
            $this->productOptRepo->SaveItem($dataOpt, $idOpt);
            //}

            //### Code xử lý: watermark
            if ($width!=null) {
                Thumb::Crop($this->folder_upload, $row->photo, $width, $height, 1, $type);
            }


            //### Code xử lý: hash photo
            if (!$id && $id == null) {
                if ($hash!='' && isset($row->id)) {
                    $this->galleryRepo->UpdateHashGallery($row->id, $hash);
                }
                if ($hash_color) {
                    //### $hash_color = $request->hash_color;
                    foreach ($hash_color as $k => $v) {
                        if ($v!='' && isset($row->id)) {
                            $this->galleryRepo->UpdateHashGallery($row->id, $v);
                        }
                    }
                }
            }


            // ### cập nhật product_option
            if (isset($dataOption)) {
                foreach ($dataOption as $k => $v) {
                    $param = $v;
                    $idOption = $param['id'];
                    $param['id_product']=$row['id'];
                    $param['dai'] = (isset($param['dai']) && $param['dai'] != '') ? str_replace(",", "", $param['dai']) : 0;
                    $param['rong'] = (isset($param['rong']) && $param['rong'] != '') ? str_replace(",", "", $param['rong']) : 0;
                    $param['cao'] = (isset($param['cao']) && $param['cao'] != '') ? str_replace(",", "", $param['cao']) : 0;
                    $param['khoiluong'] = (isset($param['khoiluong']) && $param['khoiluong'] != '') ? str_replace(",", "", $param['khoiluong']) : 0;
                    
                    $param['giacu'] = (isset($param['giacu']) && $param['giacu'] != '' && $param['giacu']!=0) ? str_replace(",", "", $param['giacu']) : $row->giacu;
                    $param['gia'] = (isset($param['gia']) && $param['gia'] != '' && $param['gia']!=0) ? str_replace(",", "", $param['gia']) : $row->gia;
                    $param['giamoi'] = (isset($param['giamoi']) && $param['giamoi'] != '' && $param['giamoi']!=0) ? str_replace(",", "", $param['giamoi']) : $row->giamoi;
                    if (isset($param['giakm'])) {
                        $param['giakm'] = (isset($param['giakm']) && $param['giakm'] != '' && $param['giakm']!=0) ? $param['giakm'] : 0;
                    }
                    $param['xoatam'] = $param['xoatam'];
                    $param['hienthi'] = $data['hienthi'];
                    //change masp
                    $arrMasp = explode('-', $param['masp']);
                    $newMasp = $row['masp'].'-'.end($arrMasp);
                    $param['masp'] = $newMasp;
                    $param['type'] = $type;

                    $getimage='';
                    if ($request->hasFile('file-'.$k)) {
                        $row_option = $this->productOptRepo->GetOneItem($idOption, $this->relationsOpt);
                        $oldimage = $row_option['photo'];
                        $folder = Helper::GetFolder($this->folder);
                        $newimage = $request->file('file-'.$k);

                        if ($newimage) {
                            $param['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
                        }
                    }

                    $row_op = $this->productOptRepo->SaveItem($param, $idOption);

                    //### Code xử lý: watermark
                    if ($width!=null) {
                        Thumb::Crop($this->folder_upload, $row_op->photo, $width, $height, 1, $type);
                    }
                }
            }


            //### Code xóa những product option
            if ($deleteOptionItems!='') {
                $ids = explode(",", $deleteOptionItems);
                //dd($deleteOptionItems);
                foreach ($ids as $i => $item) {
                    $rowOption = $this->productOptRepo->GetOneItem($item, $this->relationsOpt);
                    $image_path = Helper::GetFolder($this->folder).$rowOption['photo'];
                    Helper::DeleteImage($image_path);
                }
                $this->productOptRepo->DeleteMultiItem($deleteOptionItems, $this->folder);
            }


            //### Hiển thị giao diện
            if ($savehere) {
                return redirect()->route($this->routeEdit, [$category,$type,$row->id]);
            } else {
                return redirect()->route($this->routeShow, [$category,$type]);
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Xuất excel tất cả đơn hàng
    |--------------------------------------------------------------------------
    */
    public function ExportProduct(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionExport)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $category = $request->category;
        $params = array();
        $params['listid'] = ($request->listid) ? $request->listid : '';
        $params['type'] = ($request->type) ? $request->type : '';
        //dd($params);

        return Excel::download(new ProductExport($params, $category), 'danhsach_sanpham_'.time().'.xlsx');
    }


    /*
    |--------------------------------------------------------------------------
    | Nhập excel sản phẩm
    |--------------------------------------------------------------------------
    */
    public function ImportProduct(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionImport)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        if ($request->hasFile('import_file')) {
            $import = Excel::import(new ProductImport($request), request()->file('import_file'));
            $request->session()->flash('alertSuccess', 'Nhập dữ liệu thành công !');
            return $this->page_error;
        } else {
            $request->session()->flash('alert', 'Hệ thống báo lỗi: bạn chưa chọn file !');
            return $this->page_error;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Giao diện nhập excel sản phẩm
    |--------------------------------------------------------------------------
    */
    public function ImportView(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionImport)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $other_title = "Import sản phẩm";
        $response = array(
            'other_title'=>$other_title ,
            'category'=>$this->category,
            'type'=>$this->type
        );
        return view($this->viewImport)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Giao diện nhập excel sản phẩm
    |--------------------------------------------------------------------------
    */
    public function ImportImages(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);
        
        //### check auth permission
        if (!$this->IsPermission($this->permissionImport)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $other_title = "Upload hình ảnh";
        $response = array(
            'other_title'=>$other_title ,
            'category'=>$this->category,
            'type'=>$this->type
        );
        return view($this->viewImportImages)->with($response);
    }
}
