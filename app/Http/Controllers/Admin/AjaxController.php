<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Places;
use App\Models\Order;

use Illuminate\Support\Str;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use DB;

use Helper;
use Thumb;
use CartHelper;

class AjaxController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Ajax multy category
    |--------------------------------------------------------------------------
    */
    public function LoadSelectCategory(Request $request)
    {
        $id = $request->id;
        $level = $request->level;
        $list_ids = $request->list_ids;
        $type = $request->type;
        $categories = array();
        $table = $request->table;
        $model = $this->categoryRepo;

        switch ($table) {
            case 'product':
                $model = $this->productRepo;
                break;

            case 'post':
                $model = $this->postRepo;
                break;
        }

        //### Lấy thông tin category theo id
        $category_data = array();
        if ($id) {
            $category_data = $model->GetItem(['id'=>$id]);
        }

        //### Lấy ds category cấp cha theo level
        if ($level>0) {
            if ($list_ids) {
                $level_child = $level-1;
                $ids = explode(",", $list_ids);
                $arr_tmp_ids = array();

                foreach ($ids as $k=>$v) {
                    $categories_byId = $this->categoryRepo->Query()->where('level', $level_child)->whereRaw('FIND_IN_SET('.$v.',ids_level_'.$level_child.')')->pluck('id');

                    if ($categories_byId) {
                        $arr_tmp_ids = array_merge($categories_byId->toArray(), $arr_tmp_ids);
                    }
                }

                if ($arr_tmp_ids) {
                    $ids_string_tmp = implode(',', $arr_tmp_ids);
                    $categories = $this->categoryRepo->GetAllItemByIds(explode(',', $ids_string_tmp));
                }
            } else {
                $level_child = $level - 1;
                $categories = ($id) ? $this->categoryRepo->GetAllItemsExceptId($type, ['level'=>$level_child]) : $this->categoryRepo->GetAllItems($type, ['level'=>$level_child]);
                //dd($id);
            }

            $response = array(
                'level' => $level,
                'categories' => $categories,
                'category_data' => $category_data
            );

            return view('admin.layouts.multy_category')->with($response);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax multy category
    |--------------------------------------------------------------------------
    */
    public function MultyCategory(Request $request)
    {
        $id_category = $request->id_category;
        $category_select = $this->categoryRepo->Getitem(['id'=>$id_category]);
        $category_list_same = $this->categoryRepo->GetAllItemsExceptId($category_select['type'], ['level'=>$category_select['level'], 'id'=>$id_category]);

        $response = array(
            'category_list_same' => $category_list_same
        );
        return view('admin.ajax.loadmultycategory')->with($response);
    }

    public function AjaxDeleteGallery(Request $request)
    {
        $id = $request->id;
        $folder_name = $request->folder_upload;
        $model = Helper::Get_model('gallery');
        $row = $model->GetItem(['id' => $id]);

        if ($row) {
            $model->DeleteOneItem($id, $folder_name);
        }

        return response()
            ->json(['status' => true]);
    }

    /*
    |--------------------------------------------------------------------------
    | Ajax delete list gallery
    |--------------------------------------------------------------------------
    */
    public function DeleteGalleryMulty(Request $request)
    {
        //### lấy dữ liệu
        $model = $request->model;
        $id = $request->id;
        $type = $request->type;
        $id_gallery = $request->id_gallery;

        $model = Helper::Get_model($model);

        if ($id_gallery) {
            $row_model = $model->GetItem(['id'=>$id]);
            $gallery_ids = $row_model['gallery'];
            $gallery_ids = ($gallery_ids) ? explode(",", $gallery_ids) : array();

            //### xóa những id hình đã tồn tại
            if (($key = array_search($id_gallery, $gallery_ids)) !== false) {
                unset($gallery_ids[$key]);
            }

            $gallery_result = implode(",", $gallery_ids);

            //### cập nhật ids gallery
            $model->SaveItem(['gallery'=>$gallery_result], $id);
            return json_encode(['status'=>'success']);
        }

        return json_encode(['status'=>'error']);
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax add list gallery
    |--------------------------------------------------------------------------
    */
    public function AddGallery(Request $request)
    {
        //### lấy dữ liệu
        $model = $request->model;
        $id = $request->id;
        $type = $request->type;
        $ids = ($request->ids) ? explode(',', $request->ids) : '';

        $model = Helper::Get_model($model);

        //### xử lý dữ liệu
        if ($ids!='') {
            $row_model = $model->GetItem(['id'=>$id]);
            $gallery_ids = $row_model['gallery'];
            $gallery_ids = ($gallery_ids) ? explode(",", $gallery_ids) : array();

            //### xóa những id hình đã tồn tại
            for ($i=0;$i<count($ids);$i++) {
                if (in_array($ids[$i], $gallery_ids)) {
                    unset($ids[$i]);
                }
            }

            $gallery_ids = array_merge($gallery_ids, $ids);

            $gallery_result = implode(",", $gallery_ids);

            //### cập nhật ids gallery
            $model->SaveItem(['gallery'=>$gallery_result], $id);

            if ($gallery_result) {
                $gallery = $this->galleryRepo->GetAllItemByIds($gallery_ids);

                $response = array(
                    'gallery_multy' => $gallery,
                );

                return view('admin.ajax.loadmultyimage')->with($response);
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax load ds hình ảnh
    |--------------------------------------------------------------------------
    */
    public function LoadImages(Request $request)
    {
        //### xử lý
        $galleries = $this->galleryRepo->GetAll('gallery');

        //###response
        $response = array(
            'galleries' => $galleries
        );

        return view('admin.ajax.loadimage')->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax load lại ds size sau khi thêm trực tiếp
    |--------------------------------------------------------------------------
    */
    public function LoadSize(Request $request)
    {
        $id = $request->id;
        $type = $request->type;

        return Helper::get_size($id, 'product', $type);
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax thêm size - color trực tiếp
    |--------------------------------------------------------------------------
    */
    public function AddSize(Request $request)
    {
        $sizes = $request->size;
        $size_type = $request->size_type;

        if ($sizes) {
            foreach ($sizes as $k => $v) {
                if ($v) {
                    $data = array(
                        'hienthi' => 1,
                        'tenvi' => $v,
                        'type' => $size_type,
                        'ngaytao' => time(),
                        'ngaysua' => time(),
                    );
                    //### Code xử lý...
                    $this->sizeRepo->SaveItem($data);
                }
            }
            return json_encode(['status'=>'success']);
        }
        return json_encode(['status'=>'error']);
    }

	/*
    |--------------------------------------------------------------------------
    | Ajax thêm size - color trực tiếp
    |--------------------------------------------------------------------------
    */
    public function addSaleProduct(Request $request)
    {
        $saleId = $request->id;
        $listid = explode(',', $request->listid);

        if ($listid) {
            foreach ($listid as $k => $v) {
                if ($v) {
                    $data = array(
                        'sale_id' => $saleId,
                        'product_id' => $v,
                    );
                    //### Code xử lý...
                    $this->saleProductRepo->SaveItem($data);
                }
            }
            return json_encode(['status'=>'success']);
        }
        return json_encode(['status'=>'error']);
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax load lại ds Color sau khi thêm trực tiếp
    |--------------------------------------------------------------------------
    */
    public function LoadColor(Request $request)
    {
        $id = $request->id;
        $type = $request->type;

        return Helper::get_color($id, 'product', $type);
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax thêm Color - color trực tiếp
    |--------------------------------------------------------------------------
    */
    public function AddColor(Request $request)
    {
        $data = $request->color;

        if ($request->hasFile('color_photo')) {
            $oldimage = '';
            $newimage = $request->file('color_photo');
            $folder = Helper::GetFolder('color');
            if ($newimage) {
                $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
            }
        }
        $data['hienthi']=1;
        $data['ngaytao']=$data['ngaysua']=time();

        //### Code xử lý...
        if ($this->colorRepo->SaveItem($data)) {
            return json_encode(['status'=>'success']);
        }
        return json_encode(['status'=>'error']);
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax thay đổi giá trực tiếp
    |--------------------------------------------------------------------------
    */
    public function ChangePrice(Request $request)
    {
        //### request
        $id = $request->id;
        $table = $request->table;
        $typePrice = $request->typePrice;
        $gia = $request->gia;

        if ($table=='productOption') {
            $model = $this->productOptRepo;
        }

        if ($model) {
            $data[$typePrice] = (isset($gia) && $gia != '') ? str_replace(",", "", $gia) : 0;
            if ($model->SaveItem($data, $id)) {
                return json_encode(['result'=>'success']);
            } else {
                return json_encode(['result'=>'error']);
            }
        }
        return json_encode(['result'=>'error']);
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax thay đổi số lượng
    |--------------------------------------------------------------------------
    */
    public function ChangeSoluong(Request $request)
    {
        //### request
        $id = $request->id;
        $table = $request->table;
        $soluong_type = $request->soluong_type;
        $soluong_now = $request->soluong_now;
        $soluong_input = $request->soluong_input;

        //### kiểm tra
        if ($soluong_type==0) {
            $soluong_now += $soluong_input;
        } else {
            if ($soluong_now>=$soluong_input) {
                $soluong_now -= $soluong_input;
            }
        }

        $data['soluong'] = $soluong_now;

        //### xử lý
        if ($table=='productOption') {
            $row = $this->productOptRepo->SaveItem($data, $id);
        } else {
            $row = $this->productRepo->SaveItem($data, $id);
        }

        $result['success'] = 1;
        $result['soluong_now'] = $row['soluong'];
        return json_encode($result);
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax thay đổi danh mục cấp
    |--------------------------------------------------------------------------
    */
    public function Category(Request $request)
    {
        if (isset($request->id)) {
            $model = (isset($request->model)) ? $request->model : '';
            $level = (isset($request->level)) ? $request->level : '';
            $table = (isset($request->table)) ? $request->table : '';
            $id = $request->id;
            $type = (isset($request->type)) ? $request->type : '';
            $row = null;

            switch ($level) {
                case 'list':
                    $id_temp = "id_list";
                    $level_child = "cat";
                    break;

                case 'cat':
                    $id_temp = "id_cat";
                    $level_child = "item";
                    break;

                case 'item':
                    $id_temp = "id_item";
                    $level_child = "sub";
                    break;

                default:
                    echo 'error ajax';
                    exit();
                    break;
            }

            if ($id) {
                $model = Helper::Get_model($model, $level_child);
                $rows = $model->where('type', $type)->where($id_temp, $id)->orderBy('stt', 'asc')->get()->toArray();
            }

            $str = '<option value="0">Chọn danh mục</option>';
            if ($rows) {
                foreach ($rows as $v) {
                    $str .= '<option value='.$v["id"].'>'.$v["tenvi"].'</option>';
                }
            }
            echo $str;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax thay đổi danh mục cấp
    |--------------------------------------------------------------------------
    */
    public function CategoryOrder(Request $request)
    {
        if (isset($request->id_category)) {
            $id_category = $request->id_category;
            $row = null;
            $model_product = $this->productRepo;
            $type = 'product';

            if ($id_category) {
                $arr_childCategory = $params = array();
                if ($request->id_category) {
                    array_push($arr_childCategory, (int)$request->id_category);
                    $arr_childCategory = array_merge($arr_childCategory, $this->categoryRepo->GetChildCategory($type, $request->id_category));
                }
                if ($request->id_category) {
                    $params['id_category'] = $arr_childCategory;
                }

                $products = $model_product->GetAllItems($type, $params);
            }

            $result['product'] = '<option value="0">Chọn sản phẩm</option>';
            if ($products) {
                foreach ($products as $v) {
                    $result['product'] .= '<option value='.$v["id"].'>'.$v["tenvi"].'</option>';
                }
            }

            echo json_encode($result);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax thay đổi danh mục cấp
    |--------------------------------------------------------------------------
    */
    public function CategoryPlaces(Request $request)
    {
        if (isset($request->id)) {
            $model = (isset($request->model)) ? $request->model : '';
            $level = (isset($request->level)) ? $request->level : '';
            $table = (isset($request->table)) ? $request->table : '';
            $title = (isset($request->title)) ? $request->title : 'Chọn...';
            $id = $request->id;
            $type = (isset($request->type)) ? $request->type : '';
            $row = null;

            switch ($level) {
                case 'list':
                    $id_temp = "id_city" ;
                    $level_child = "cat";
                    break;

                case 'cat':
                    $id_temp = "id_district";
                    $level_child = "item";
                    break;

                case 'item':
                    $id_temp = "id_wards";
                    $level_child = "sub";
                    break;

                default:
                    echo 'error ajax';
                    exit();
                    break;
            }

            if ($id) {
                $model = Helper::Get_model($model, $level_child);
                if ($type) {
                    $rows = $model->where('type', $type)->where($id_temp, $id)->orderBy('stt', 'asc')->get()->toArray();
                } else {
                    $rows = $model->where($id_temp, $id)->orderBy('stt', 'asc')->get()->toArray();
                }
            }

            $str = '<option value="0">'.$title.'</option>';
            if ($rows) {
                foreach ($rows as $v) {
                    $str .= '<option value='.$v["id"].'>'.$v["ten"].'</option>';
                }
            }
            echo $str;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax lấy ds sản phẩm đơn lẻ (nếu ko có phiên bản) hoặc ds sản phẩm con (nếu sp có phiên bản) load khi tạo đơn hàng trong admin
    |--------------------------------------------------------------------------
    */
    public function OptionProduct(Request $request)
    {
        if (isset($request->id)) {
            $model = (isset($request->model)) ? $request->model : '';
            $level = (isset($request->level)) ? $request->level : '';
            $table = (isset($request->table)) ? $request->table : '';
            $id = $request->id;
            $type = (isset($request->type)) ? $request->type : '';
            $row = null;

            if ($id) {
                $model = $this->productOptRepo; //table: product_option
                $params = array(
                    'id_product' => $id,
                );
                $product = $model->GetAllItems($type, $params);
            }


            $result['product']='<div class="row">';
            if ($product) {
                $result['product'] .= '<div class="form-group col-md-6 col-sm-6">';
                $result['product'] .= '<label class="d-block" for="id_option">Danh sách phiên bản</label>';
                $result['product'] .= '<select name="id_option" id="id_option" class="form-control select3 id_option">';
                $result['product'] .= '<option value="0-0">Chọn phiên bản</option>';

                if ($product) {
                    foreach ($product as $v) {
                        $result['product'] .= '<option value="'.$v["id_size"].'-'.$v["id_mau"].'">'.$v["tenvi"].'</option>';
                    }
                }
                $result['product'] .= '</select>';
                $result['product'] .= '<div class="id_option_error text-danger"></div>';
                $result['product'] .= '</div>';
            }
            $result['product'] .= '<div class="form-group col-md-6 col-sm-6">';
            $result['product'] .= '<label class="d-block">Nhập số lượng</label>';
            $result['product'] .= '<div class="input-group">';
            $result['product'] .= '<div class="input-group-append">';
            $result['product'] .= '<div class="input-group-text minimus"><strong>-</strong></div>';
            $result['product'] .= '</div>';
            $result['product'] .= '<input name="soluong" id="soluong" value="1" class="form-control" readonly/>';
            $result['product'] .= '<div class="input-group-append">';
            $result['product'] .= '<div class="input-group-text plus"><strong>+</strong></div>';
            $result['product'] .= '</div>';
            $result['product'] .= '</div>';
            $result['product'] .= '</div>';
            $result['product'] .= '</div>';

            echo json_encode($result);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax thêm đơn hàng
    |--------------------------------------------------------------------------
    */
    public function AddCart(Request $request)
    {
        $model = new Order();
        $data = $request->data;

        $checkCanBuy = 1;
        $data['html_text']='';
        $count_exist=0;

        $phiship = (isset($data['phiship']) && $data['phiship'] != '') ? str_replace(",", "", $data['phiship']) : 0;
        $giamgia = (isset($data['giamgia']) && $data['giamgia'] != '') ? str_replace(",", "", $data['giamgia']) : 0;
        $action = (isset($request->action) && $request->action != '') ? $request->action : 0;

        $id_new = (isset($request->id_product) && $request->id_product > 0) ? htmlspecialchars($request->id_product) : 0;
        $option_new = (isset($request->id_option) && $request->id_option > 0) ? htmlspecialchars($request->id_option) : '';
        $quantity_new = (isset($request->soluong) && $request->soluong > 0) ? htmlspecialchars($request->soluong) : 1;
        if ($option_new!='') {
            $sm=explode('-', $option_new);
            $size_new=$sm[0];
            $mau_new=$sm[1];
        } else {
            $size_new=0;
            $mau_new=0;
        }

        $tamtinh=0;
        $tonggia=0;

        if ($request->product) {
            foreach ($request->product as $key => $value) {
                $idp[$key]=(int)$value;
                $giaban[$key]=(int)$request->giaban[$key];
                $arr_size[$key]=(int)$request->size[$key];
                $arr_color[$key]=(int)$request->mau[$key];
                $arr_sl[$key]=(int)$request->quantity[$key];
                $arr_code[$key]=htmlspecialchars($request->code[$key]);
                $id = $idp[$key];
                $quantity = $arr_sl[$key];
                $size=$arr_size[$key];
                $mau=$arr_color[$key];
                $code = $arr_code[$key];

                if ($id_new==$idp[$key] && $size_new==$arr_size[$key] && $mau_new==$arr_color[$key] && $action=='add_cart') {
                    $count_exist++;
                    $quantity+=$quantity_new;
                }

                $proinfo=CartHelper::get_product_info($id, $size, $mau);
                $pro_price = $proinfo['gia'];
                $pro_price_new = $proinfo['giamoi'];
                $pro_price_qty = $pro_price*$quantity;
                $pro_price_new_qty = $pro_price_new*$quantity;
                $tamtinh+= ($proinfo['giamoi']>0) ? $pro_price_new_qty : $pro_price_qty;

                //get sl có thể bán
                $cotheban_tmp = $proinfo['cotheban_tmp'];
                if ($cotheban_tmp<0 || $cotheban_tmp<$quantity) {
                    $checkCanBuy = 0;
                    //break;
                }

                $data['html_text'].='<div class="procart procart_item procart-'.$code.' procart-'.$id.'-'.$size.'-'.$mau.' d-flex align-items-start justify-content-between">';
                $data['html_text'].='<div class="pic-procart">';
                $data['html_text'].='<a class="text-decoration-none" href="" target="_blank" title="'.$proinfo['tenvi'].'"><img src="'.config('config_upload.UPLOAD_PRODUCT').$proinfo['photo'].'" onerror=src="'.asset("img/noimage.png").'" alt="'.$proinfo['tenvi'].'"></a>';
                $data['html_text'].='</div>';
                $data['html_text'].='<div class="info-procart">';
                $data['html_text'].='<h3 class="name-procart"><a class="text-decoration-none" href="" target="_blank" title="'.$proinfo['tenvi'].'">'.$proinfo['tenvi'].'</a></h3>';
                $data['html_text'].='<div class="properties-procart">';
                if ($mau) {
                    $maudetail=CartHelper::get_mau_info($mau);
                    if ($maudetail) {
                        $data['html_text'].='<p>Màu: <strong>'.$maudetail['tenvi'].'</strong></p>';
                    }
                }
                if ($size) {
                    $sizedetail=CartHelper::get_size_info($size);
                    if ($sizedetail) {
                        $data['html_text'].='<p>Size: <strong>'.$sizedetail['tenvi'].'</strong></p>';
                    }
                }
                $data['html_text'].='</div>';
                $data['html_text'].='<a class="del-procart text-decoration-none" data-code="'.$code.'">';
                $data['html_text'].='<i class="fas fa-trash-alt"></i>';
                $data['html_text'].='<span>Xóa</span>';
                $data['html_text'].='</a>';
                $data['html_text'].='</div>';

                $data['html_text'].='<div class="quantity-procart">';
                $data['html_text'].='<div class="price-procart price-procart-rp">';
                if ($proinfo['giamoi']) {
                    $data['html_text'].='<p class="price-new-cart load-price-new-'.$code.'">';
                    $data['html_text'].=Helper::format_money($pro_price_new_qty);
                    $data['html_text'].='</p>';
                    $data['html_text'].='<p class="price-old-cart load-price-'.$code.'">';
                    $data['html_text'].=Helper::format_money($pro_price_qty);
                    $data['html_text'].='</p>';
                } else {
                    $data['html_text'].='<p class="price-new-cart load-price-'.$code.'">';
                    $data['html_text'].=Helper::format_money($pro_price_qty);
                    $data['html_text'].='</p>';
                }
                $data['html_text'].='</div>';
                $data['html_text'].='<div class="quantity-counter-procart quantity-counter-procart-'.$code.' d-flex align-items-stretch justify-content-between">';
                $data['html_text'].='<span class="counter-procart-minus counter-procart" data-id="'.$proinfo['id'].'-'.$size.'-'.$mau.'">-</span>';
                $data['html_text'].='<input type="number" name="quantity['.$proinfo['id'].'-'.$size.'-'.$mau.']" class="quantity-procat'.$proinfo['id'].'-'.$size.'-'.$mau.'" min="1" value="'.$quantity.'" data-pid="'.$id.'" data-code="'.$code.'" readonly/>';
                $data['html_text'].='<span class="counter-procart-plus counter-procart" data-id="'.$proinfo['id'].'-'.$size.'-'.$mau.'">+</span>';
                $data['html_text'].='</div>';

                $data['html_text'].='<div class="pic-procart pic-procart-rp">';
                $data['html_text'].='<a class="text-decoration-none" href="" target="_blank" title="'.$proinfo['tenvi'].'"><img src="'.config('config_upload.UPLOAD_PRODUCT').$proinfo['photo'].'" onerror=src="'.asset("img/noimage.png").'" alt="'.$proinfo['tenvi'].'"></a>';
                $data['html_text'].='</div>';
                $data['html_text'].='</div>';
                $data['html_text'].='<div class="price-procart">';
                if ($proinfo['giamoi']) {
                    $data['html_text'].='<p class="price-new-cart load-price-new-'.$code.'">';
                    $data['html_text'].=Helper::format_money($pro_price_new_qty);
                    $data['html_text'].='</p>';
                    $data['html_text'].='<p class="price-old-cart load-price-'.$code.'">';
                    $data['html_text'].=Helper::format_money($pro_price_qty);
                    $data['html_text'].='</p>';
                } else {
                    $data['html_text'].='<p class="price-new-cart load-price-'.$code.'">';
                    $data['html_text'].=Helper::format_money($pro_price_qty);
                    $data['html_text'].='</p>';
                }
                $data['html_text'].='</div>';
                $data['html_text'].='<input type="hidden" name="product['.$proinfo['id'].'-'.$size.'-'.$mau.']" value="'.$proinfo['id'].'"/>';
                $data['html_text'].='<input type="hidden" name="size['.$proinfo['id'].'-'.$size.'-'.$mau.']" value="'.$size.'"/>';
                $data['html_text'].='<input type="hidden" name="mau['.$proinfo['id'].'-'.$size.'-'.$mau.']" value="'.$mau.'"/>';
                $data['html_text'].='<input type="hidden" name="code['.$proinfo['id'].'-'.$size.'-'.$mau.']" value="'.$code.'"/>';
                $data['html_text'].='</div>';
            }
        }

        if ($count_exist==0 && $id_new>0 && $action=='add_cart') {
            $id = $id_new;
            $option = $option_new;
            $quantity = $quantity_new;
            if ($option!='') {
                $sm=explode('-', $option);
                $size=$sm[0];
                $mau=$sm[1];
            } else {
                $size=0;
                $mau=0;
            }

            $code = md5($id.$mau.$size);
            $proinfo=CartHelper::get_product_info($id, $size, $mau);

            $pro_price = $proinfo['gia'];
            $pro_price_new = $proinfo['giamoi'];
            $pro_price_qty = $pro_price*$quantity;
            $pro_price_new_qty = $pro_price_new*$quantity;
            $tamtinh+= ($proinfo['giamoi']>0) ? $pro_price_new_qty : $pro_price_qty;        //$tamtinh+=$pro_price_qty;

            //get sl có thể bán
            $cotheban_tmp = $proinfo['cotheban_tmp'];
            if ($cotheban_tmp<=0 || $cotheban_tmp<$quantity) {
                $checkCanBuy = 0;
                //break;
            }


            $data['html_text'].='<div class="procart procart_item procart-'.$code.' procart-'.$id.'-'.$size.'-'.$mau.' d-flex align-items-start justify-content-between">';
            $data['html_text'].='<div class="pic-procart">';
            $data['html_text'].='<a class="text-decoration-none" href="" target="_blank" title="'.$proinfo['tenvi'].'"><img src="'.config('config_upload.UPLOAD_PRODUCT').$proinfo['photo'].'" onerror=src="'.asset("img/noimage.png").'" alt="'.$proinfo['tenvi'].'"></a>';
            $data['html_text'].='</div>';
            $data['html_text'].='<div class="info-procart">';
            $data['html_text'].='<h3 class="name-procart"><a class="text-decoration-none" href="" target="_blank" title="'.$proinfo['tenvi'].'">'.$proinfo['tenvi'].'</a></h3>';
            $data['html_text'].='<div class="properties-procart">';
            if ($mau) {
                $maudetail=CartHelper::get_mau_info($mau);
                $data['html_text'].='<p>Màu: <strong>'.$maudetail['tenvi'].'</strong></p>';
            }
            if ($size) {
                $sizedetail=CartHelper::get_size_info($size);
                $data['html_text'].='<p>Size: <strong>'.$sizedetail['tenvi'].'</strong></p>';
            }
            $data['html_text'].='</div>';
            $data['html_text'].='<a class="del-procart text-decoration-none" data-code="'.$code.'">';
            $data['html_text'].='<i class="fas fa-trash-alt"></i>';
            $data['html_text'].='<span>Xóa</span>';
            $data['html_text'].='</a>';
            $data['html_text'].='</div>';

            $data['html_text'].='<div class="quantity-procart">';
            $data['html_text'].='<div class="price-procart price-procart-rp">';
            if ($proinfo['giamoi']) {
                $data['html_text'].='<p class="price-new-cart load-price-new-'.$code.'">';
                $data['html_text'].=Helper::format_money($pro_price_new_qty);
                $data['html_text'].='</p>';
                $data['html_text'].='<p class="price-old-cart load-price-'.$code.'">';
                $data['html_text'].=Helper::format_money($pro_price_qty);
                $data['html_text'].='</p>';
            } else {
                $data['html_text'].='<p class="price-new-cart load-price-'.$code.'">';
                $data['html_text'].=Helper::format_money($pro_price_qty);
                $data['html_text'].='</p>';
            }
            $data['html_text'].='</div>';
            $data['html_text'].='<div class="quantity-counter-procart quantity-counter-procart-'.$code.' d-flex align-items-stretch justify-content-between">';
            $data['html_text'].='<span class="counter-procart-minus counter-procart" data-id="'.$proinfo['id'].'-'.$size.'-'.$mau.'">-</span>';
            $data['html_text'].='<input type="number" name="quantity['.$proinfo['id'].'-'.$size.'-'.$mau.']" class="quantity-procat'.$proinfo['id'].'-'.$size.'-'.$mau.'" min="1" value="'.$quantity.'" data-pid="'.$id.'" data-code="'.$code.'" readonly />';
            $data['html_text'].='<span class="counter-procart-plus counter-procart" data-id="'.$proinfo['id'].'-'.$size.'-'.$mau.'">+</span>';

            $data['html_text'].='</div>';

            $data['html_text'].='<div class="pic-procart pic-procart-rp">';
            $data['html_text'].='<a class="text-decoration-none" href="" target="_blank" title="'.$proinfo['tenvi'].'"><img onerror=src="'.asset("img/noimage.png").'" src="'.config('config_upload.UPLOAD_PRODUCT').$proinfo['photo'].'" alt="'.$proinfo['tenvi'].'"></a>';
            $data['html_text'].='</div>';
            $data['html_text'].='</div>';
            $data['html_text'].='<div class="price-procart">';
            if ($proinfo['giamoi']) {
                $data['html_text'].='<p class="price-new-cart load-price-new-'.$code.'">';
                $data['html_text'].=Helper::format_money($pro_price_new_qty);
                $data['html_text'].='</p>';
                $data['html_text'].='<p class="price-old-cart load-price-'.$code.'">';
                $data['html_text'].=Helper::format_money($pro_price_qty);
                $data['html_text'].='</p>';
            } else {
                $data['html_text'].='<p class="price-new-cart load-price-'.$code.'">';
                $data['html_text'].=Helper::format_money($pro_price_qty);
                $data['html_text'].='</p>';
            }
            $data['html_text'].='</div>';
            $data['html_text'].='<input type="hidden" name="product['.$proinfo['id'].'-'.$size.'-'.$mau.']" value="'.$proinfo['id'].'"/>';
            $data['html_text'].='<input type="hidden" name="size['.$proinfo['id'].'-'.$size.'-'.$mau.']" value="'.$size.'"/>';
            $data['html_text'].='<input type="hidden" name="mau['.$proinfo['id'].'-'.$size.'-'.$mau.']" value="'.$mau.'"/>';
            $data['html_text'].='<input type="hidden" name="code['.$proinfo['id'].'-'.$size.'-'.$mau.']" value="'.$code.'"/>';
            $data['html_text'].='</div>';
        }


        if ($giamgia>($tamtinh+$phiship)) {
            $giamgia=$tamtinh+$phiship;
        }
        $tonggia=$tamtinh+$phiship-$giamgia;


        $data['checkCanBuy']=$checkCanBuy;
        $data['cotheban_tmp']=$cotheban_tmp;
        $data['id']=$id.'-'.$size.'-'.$mau;
        $data['tamtinh']=$tamtinh;
        $data['tamtinh_text']=Helper::format_money($tamtinh);

        $data['tonggia']=$tonggia;
        $data['tonggia_text']=Helper::format_money($tonggia);

        $data['phiship']=$phiship;
        $data['phiship_text']=Helper::format_money($phiship);

        $data['giamgia_ipput']=number_format($giamgia, 0, ',', ',');
        $data['giamgia']=$giamgia;
        $data['giamgia_text']=Helper::format_money($giamgia);//$func->dump($data, true);
        //$func->dump($data);die();
        echo json_encode($data);
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax cập nhật kiểu trạng thái (VD: hiển thị, mới, hot, nổi bật,...)
    |--------------------------------------------------------------------------
    */
    public function Status(Request $request)
    {
        if (isset($request->id)) {
            $id = $request->id;
            $model = (isset($request->model)) ? $request->model : '';
            $level = (isset($request->level)) ? $request->level : '';
            $loai = (isset($request->loai)) ? $request->loai : '';

            $model = Helper::Get_model($model, $level);
            //$row = $model->where('id', $id)->first()->toArray();
            $row = $model->GetOneItem($id);
            $data[$loai] = ($row[$loai]>0) ? 0 : 1;
            
            $model->SaveItem($data, $id);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax cập nhật số thứ tự của 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function SttNumber(Request $request)
    {
        if (isset($request->id)) {
            $id = $request->id;
            $model = (isset($request->model)) ? $request->model : '';
            $level = (isset($request->level)) ? $request->level : '';
            $value = (isset($request->value)) ? $request->value : 0;

            $model = Helper::Get_model($model, $level);
            $data['stt'] = $value;
            $model->SaveItem($data, $id);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax upload hình ảnh kèm theo
    |--------------------------------------------------------------------------
    */
    public function UploadImage(Request $request)
    {
        $data_inform = array('success' => true, 'msg' => 'Upload thành công');

        $id = (int)$request->id;
        $model = $request->model;
        $level = $request->level;
        $type = $val = $request->type;
        $hash = $request->hash;
        $id_color = $request->id_color;
        
        $folder = Helper::GetFolder($model);
        $time = (isset($request->time) && $request->time==0) ? false : true;
        $id_group = $request->id_group;

        $getimage='';
        if ($request->hasFile('files')) {
            $file = $request->file('files');
        } elseif (isset($id_group) && $request->hasFile('files-'.$id_group)) {
            $file = $request->file('files-'.$id_group);
        }


        if ($file) {
            $gallery = $this->galleryRepo;

            $oldimage = '';
            $newimage_arr = $file;

            if ($newimage_arr) {
                foreach ($newimage_arr as $k => $v) {
                    $data_file = array();
                    if (!$id && $id==null) {
                        $data_file['hash'] = $hash;
                        $data_file['id_photo'] = 0;
                    } elseif ($id>0) {
                        $data_file['id_photo'] = $data_file['id_photo_old'] = $id;
                    }

                    if ($id_color>0) {
                        $data_file['id_color'] = $id_color;
                    }

                    $data_file['photo'] = Helper::UploadImageToFolder($newimage_arr[$k], $oldimage, $folder, $time);
                    $data_file['tenvi'] = "";
                    $data_file['com'] = $model;
                    $data_file['type'] = $type;
                    $data_file['kind'] = $level;
                    $data_file['val'] = $type;
                    $data_file['hienthi'] = 1;
                    $data_file['ngaytao'] = time();
                    $data_file['stt'] = $gallery->CountItems($type)+1;
                    $gallery->SaveItem($data_file);
                }
            }
        }

        echo json_encode($data_inform);
    }


    /*
    |--------------------------------------------------------------------------
    | Ajax thêm sửa xóa hình ảnh kèm theo
    |--------------------------------------------------------------------------
    */
    public function Filer(Request $request)
    {
        $row_gallery = $this->galleryRepo;

        $id = ($request->id) ? $request->id : 0;
        $idmuc = ($request->idmuc) ? $request->idmuc : 0;
        $folder = ($request->folder) ? $request->folder : '';
        $info = ($request->info) ? $request->info : '';
        $value = ($request->value) ? $request->value : '';
        $listid = ($request->listid) ? $request->listid : '';
        $com = ($request->com) ? $request->com : '';
        $kind = ($request->kind) ? $request->kind : '';
        $type = ($request->type) ? $request->type : '';
        $colfiler = ($request->colfiler) ? $request->colfiler : '';
        $cmd = ($request->cmd) ? $request->cmd : '';
        $hash = ($request->hash) ? $request->hash : '';
        $gallery = null;
        $time = (isset($request->time) && $request->time==0) ? false : true;
        $id_color = $request->id_color;

        if ($cmd == 'refresh' && ($idmuc > 0 || $hash != '')) {
            if ($idmuc>0) {
                $params = array(
                    'id_photo'=>$idmuc,
                    'com'=>$com,
                    'type'=>$type,
                    'kind'=>$kind,
                    'val'=>$type,
                    'id_color' => ($id_color) ? $id_color : 0
                );

                $gallery = $row_gallery->GetAllItems($type, $params, $this->relations);
            } elseif ($hash != '') {
                $params = array(
                    'hash'=>$hash,
                    'com'=>$com,
                    'type'=>$type,
                    'kind'=>$kind,
                    'val'=>$type,
                    'id_color' => ($id_color) ? $id_color : 0
                );
                $gallery = $row_gallery->GetAllItems($type, $params, $this->relations);
            }

            if ($gallery) {
                foreach ($gallery as $k => $v) {
                    Helper::galleryFiler($v['stt'], $v['id'], $v['photo'], $v['tenvi'], $com, $colfiler, $hash);
                }
            }
        } elseif ($cmd == 'info' && $id > 0 && ($idmuc > 0 || $hash != '')) {
            $data = array();

            if ($info == 'stt') {
                $data['stt'] = $value;
            }

            if ($info == 'tieude') {
                $data['tenvi'] = $value;
            }

            $result = $row_gallery->SaveItem($data, $id);

            if ($idmuc) {
                $params = array(
                    'id_photo'=>$idmuc,
                    'com'=>$com,
                    'type'=>$type,
                    'kind'=>$kind,
                    'val'=>$type,
                    'id_color' => ($id_color) ? $id_color : 0
                );
                $gallery = $row_gallery->GetAllItems($type, $params, $this->relations);
            } elseif ($hash != '') {
                $params = array(
                    'hash'=>$hash,
                    'com'=>$com,
                    'type'=>$type,
                    'kind'=>$kind,
                    'val'=>$type,
                    'id_color' => ($id_color) ? $id_color : 0
                );
                $gallery = $row_gallery->GetAllItems($type, $params, $this->relations);
            }

            if ($gallery) {
                foreach ($gallery as $k => $v) {
                    Helper::galleryFiler($v['stt'], $v['id'], $v['photo'], $v['tenvi'], $com, $colfiler);
                }
            }
        } elseif (($cmd == 'updateNumb' && $idmuc > 0 && $listid) || ($hash != '')) {
            if ($idmuc>0) {
                $params = array(
                    'id_photo'=>$idmuc,
                    'com'=>$com,
                    'type'=>$type,
                    'kind'=>$kind,
                    'val'=>$type,
                    'id_color' => ($id_color) ? $id_color : 0
                );
                $row = $row_gallery->GetAllItems($type, $params, $this->relations);
            } elseif ($hash != '') {
                $params = array(
                    'hash'=>$hash,
                    'com'=>$com,
                    'type'=>$type,
                    'kind'=>$kind,
                    'val'=>$type,
                    'id_color' => ($id_color) ? $id_color : 0
                );
                $row = $row_gallery->GetAllItems($type, $params, $this->relations);
            }

            if ($listid) {
                for ($i = 0; $i < count($listid); $i++) {
                    $data = array();
                    $arrId[] = $listid[$i];
                    $arrNumb[] = $row[$i]['stt'];
                    $data['stt'] = $row[$i]['stt'];
                    $row_gallery->SaveItem($data, $listid[$i]);
                }

                $data = array('id' => $arrId, 'numb' => $arrNumb);
                echo json_encode($data);
            }
        } elseif ($cmd == 'delete' && $id > 0) {
            $row = $row_gallery->GetOneItem($id, $this->relations);
            $path = Helper::GetFolder($folder).$row['photo'];
            if (file_exists($path)) {
                @unlink($path);
            }
            $row_gallery->DeleteOneItem($id, $folder);
        } elseif ($cmd == 'delete-all' && $listid != '') {
            $row = $row_gallery->GetItemByListId($listid);

            for ($i = 0; $i < count($row); $i++) {
                $path = Helper::GetFolder($folder).$row[$i]['photo'];
                if (file_exists($path)) {
                    @unlink($path);
                }
            }
            $row_gallery->DeleteMultiItem($listid, $folder);
        }
    }

    public function Slug(Request $request) 
    {
        if (isset($request->id)) {
            $flag = 1;
            $slug = (isset($request->slug)) ? $request->slug : '';
            $idOption = $request->idOption;
            $id = ($idOption>0) ? $idOption : $request->id;
            //$id = $request->id;
            $copy = (isset($request->copy)) ? $request->copy : '';
        //$where = ($id && !$copy) ? " id <> $id AND " : "";
            $table = array(
            /*"productlist",
            "productcat",
            "productitem",
            "productsub",*/
            "product_option",
            "product",
            "brand",

            /*"postlist",
            "postcat",
            "postitem",
            "postsub",*/
            "post",
            //"tags"
            );

            if (isset($table) && count($table) > 0) {
                foreach ($table as $v) {
                    $check = DB::table($v)
                    ->where('id', '<>', $id)
                    ->where(function ($query) use ($slug) {
                        $query->where('tenkhongdauvi', '=', $slug);
                        $query->orWhere('tenkhongdauen', '=', $slug);
                    })->first();


                    if ($check) {
                        $flag = 0;
                        break;
                    }
                }
            }

            echo $flag;
        } else {
            echo 0;
        }
        // echo $check;
    }

    public function CheckInfoPro(Request $request)
    {
        if (isset($request->id)) {
            $flag = 1;
            $element = (isset($request->element)) ? $request->element : '';
            $infoInput = (isset($request->infoInput)) ? $request->infoInput : '';
            $id = $request->id;
            $copy = (isset($request->copy)) ? $request->copy : '';
            $option = $request->option;

            if (isset($request->id_option) && $request->id_option != '') {
                $option='true';
            }

            if ($option=='false') {
                //$element="masp";
                $id_option=0;
            } else {
                //$element="masp";
                $id_option=(isset($request->id_option) && $request->id_option!='')?$request->id_option:0;
                $id=0;
            }

            $table = array(
            //"product_option",
            "product",
            );

            if (isset($table) && count($table) > 0) {
                foreach ($table as $v) {
                    $check = DB::table($v);
                    //$check = $check->where('id','<>', $id);
                    if ($v=='product_option') {
                        $check = $check->where('id', '<>', $id_option);
                    } else {
                        $check = $check->where('id', '<>', $id);
                    }
                    $check = $check->where($element, $infoInput);
                    //Helper::showSQL($check);
                    $check = $check->first();
                    if ($check) {
                        $flag = 0;
                        break;
                    }
                }
            }

            echo $flag;
        } else {
            echo 0;
        }
    }

    public function Properties(Request $request)
    {
        /* get data */
        $id_product = $request->id_product;
        $mau_group = $request->mau_group;
        $size_group = $request->size_group;
        $pro_name = $request->proname;
        $type = $request->type;
        $config = config('config_type.product');

        /* set data */
        if (isset($id_product)) {        	//&& $id_product>0
            $model_product = $this->productRepo;
            $model_option = $this->productOptRepo;
            $model_color = $this->colorRepo;
            $model_size = $this->sizeRepo;

            $row_product = $model_product->GetOneItem($id_product, $this->relations);
            $productOption_all = $model_option->GetAllItems($type, ['id_product'=>$id_product, 'hienthi'=>1, 'phienbanmau'=>0], $this->relations);
            $productOption_allXoatam = $model_option->GetAllItems($type, ['id_product'=>$id_product,'xoatam'=>0,'hienthi'=>1, 'phienbanmau'=>0], $this->relations);
            $array_option = $all_option = Helper::GetArrayIdsOption($productOption_all);
            $parent_name = (isset($row_product['tenvi'])) ? $row_product['tenvi'] : $pro_name;
            $parent_masp = (isset($row_product['masp'])) ? $row_product['masp'] : ''.time();
            //### get photo of version


            $options_tmp = $options = array();
            if (isset($mau_group) && isset($size_group)) {
                //tạo mảng product con
                foreach ($mau_group as $m=>$mau) {
                    $row_color = $model_color->GetOneItem($mau, $this->relations);
                    foreach ($size_group as $s=>$size) {
                        $row_size = $model_size->GetOneItem($size, $this->relations);
                        $row_pro_option = $model_option->GetItem(["id_mau"=>$mau,"id_size"=>$size, "id_product"=>$id_product]);

                        if ($row_pro_option) {
                            $options_tmp[$m][$s]=$row_pro_option;
                            unset($array_option[$options_tmp[$m][$s]['id']]);
                        } else {
                            $options_tmp[$m][$s]['id'] = null;
                            $options_tmp[$m][$s]['id_mau'] = $mau;
                            $options_tmp[$m][$s]['id_size'] = $size;
                            $options_tmp[$m][$s]['tenkhongdauvi'] = Helper::changeTitle($parent_name.' '.$row_color['tenvi'].' '.$row_size['tenvi']);
                            $options_tmp[$m][$s]['tenkhongdauen'] = Helper::changeTitle($parent_name.' '.$row_color['tenen'].' '.$row_size['tenen']);
                            $options_tmp[$m][$s]['tenvi'] = trim($parent_name.' '.$row_color['tenvi'].' '.$row_size['tenvi']);
                            $options_tmp[$m][$s]['tenen'] = trim($parent_name.' '.$row_color['tenen'].' '.$row_size['tenen']);

                            $options_tmp[$m][$s]['photo'] = '';
                            $options_tmp[$m][$s]['masp_brand'] = '';
                            $options_tmp[$m][$s]['masp'] = '';
                            $options_tmp[$m][$s]['dai'] = '';
                            $options_tmp[$m][$s]['rong'] = '';
                            $options_tmp[$m][$s]['cao'] = '';
                            $options_tmp[$m][$s]['khoiluong'] = '';
                            $options_tmp[$m][$s]['giacu'] = '';
                            $options_tmp[$m][$s]['gia'] = '';
                            $options_tmp[$m][$s]['giamoi'] = '';
                            $options_tmp[$m][$s]['giakm'] = '';
                            $options_tmp[$m][$s]['xoatam'] = 0;
                            $options_tmp[$m][$s]['soluong'] = 0;
                        }
                        array_push($options, $options_tmp[$m][$s]);
                    }
                }
            } elseif (isset($mau_group)) {
                //tạo mảng product con
                foreach ($mau_group as $m=>$mau) {
                    $row_color = $model_color->GetOneItem($mau, $this->relations);
                    $row_pro_option = $model_option->GetItem(["id_mau"=>$mau,"id_size"=>0, "id_product"=>$id_product]);

                    if ($row_pro_option) {
                        $options_tmp[$m]=$row_pro_option;
                        unset($array_option[$options_tmp[$m]['id']]);
                    } else {
                        $options_tmp[$m]['id'] = null;
                        $options_tmp[$m]['id_mau'] = $mau;
                        $options_tmp[$m]['id_size'] = 0;
                        $options_tmp[$m]['tenkhongdauvi'] = Helper::changeTitle($parent_name.' '.$row_color['tenvi']);
                        $options_tmp[$m]['tenkhongdauen'] = Helper::changeTitle($parent_name.' '.$row_color['tenen']);
                        $options_tmp[$m]['tenvi'] = trim($parent_name.' '.$row_color['tenvi']);
                        $options_tmp[$m]['tenen'] = trim($parent_name.' '.$row_color['tenen']);

                        $options_tmp[$m]['photo'] = '';
                        $options_tmp[$m]['masp_brand'] = '';
                        $options_tmp[$m]['masp'] = '';
                        $options_tmp[$m]['dai'] = '';
                        $options_tmp[$m]['rong'] = '';
                        $options_tmp[$m]['cao'] = '';
                        $options_tmp[$m]['khoiluong'] = '';
                        $options_tmp[$m]['giacu'] = '';
                        $options_tmp[$m]['gia'] = '';
                        $options_tmp[$m]['giamoi'] = '';
                        $options_tmp[$m]['giakm'] = '';
                        $options_tmp[$m]['xoatam'] = 0;
                        $options_tmp[$m]['soluong'] = 0;
                    }
                    array_push($options, $options_tmp[$m]);
                }
            } elseif (isset($size_group)) {
                //tạo mảng product con
                foreach ($size_group as $s=>$size) {
                    $row_size = $model_size->GetOneItem($size, $this->relations);
                    $row_pro_option = $model_option->GetItem(["id_mau"=>0,"id_size"=>$size, "id_product"=>$id_product]);

                    if ($row_pro_option) {
                        $options_tmp[$s]=$row_pro_option;
                        unset($array_option[$options_tmp[$s]['id']]);
                    } else {
                        $options_tmp[$s]['id'] = null;
                        $options_tmp[$s]['id_mau'] = 0;
                        $options_tmp[$s]['id_size'] = $size;
                        $options_tmp[$s]['tenkhongdauvi'] = Helper::changeTitle($parent_name.' '.$row_size['tenvi']);
                        $options_tmp[$s]['tenkhongdauen'] = Helper::changeTitle($parent_name.' '.$row_size['tenen']);
                        $options_tmp[$s]['tenvi'] = trim($parent_name.' '.$row_size['tenvi']);
                        $options_tmp[$s]['tenen'] = trim($parent_name.' '.$row_size['tenen']);

                        $options_tmp[$s]['photo'] = '';
                        $options_tmp[$s]['masp_brand'] = '';
                        $options_tmp[$s]['masp'] = '';
                        $options_tmp[$s]['dai'] = '';
                        $options_tmp[$s]['rong'] = '';
                        $options_tmp[$s]['cao'] = '';
                        $options_tmp[$s]['khoiluong'] = '';
                        $options_tmp[$s]['giacu'] = '';
                        $options_tmp[$s]['gia'] = '';
                        $options_tmp[$s]['giamoi'] = '';
                        $options_tmp[$s]['giakm'] = '';
                        $options_tmp[$s]['soluong'] = 0;
                        $options_tmp[$s]['xoatam'] = 0;
                    }
                    array_push($options, $options_tmp[$s]);
                }
            }
            $array_option = implode(",", $array_option);
            $folder_upload="folder";

            //### group option by value color
            $result = array();
            foreach ($options as $opt) {
                $result[$opt['id_mau']][] = $opt;
            }

            $options_group = $result;


            $response = array(
                'options_group' => $options_group,
                'array_option' => $array_option,
                'productOption_allXoatam' => $productOption_allXoatam,
                'all_option' => $all_option,
                'row_product' => $row_product,
                'parent_masp' => $parent_masp,
                'config' => $config,
                'type' => $type,
                'galleryRepo' => $this->galleryRepo
            );

            return view('admin.layouts.photo_upload')->with($response);
        }
    }


    public function DeleteTMPOption(Request $request)
    {
        $id = $request->id;
        $this->productOptRepo->SaveItem(['xoatam'=>1], $id);
    }

    public function DeletePost(Request $request)
    {
        $id = $request->id;
        $this->postRepo->DeleteOneItem($id);
    }


    public function CheckOption(Request $request)
    {
        $id = $request->id;
        $id_product = $request->id_product;
        $id_mau = ($request->id_mau) ? $request->id_mau : 0;
        $id_size = ($request->id_size) ? $request->id_size : 0;
        $type = $request->type;

        $params = array(
            'id_product'=>$id_product,
            'id_mau'=>$id_mau,
            'id_size'=>$id_size,
            'type'=>$type
        );

        $result = array();
        $model_proOption = $this->productOptRepo;
        $proOption = $model_proOption->GetItem($params);

        $result['check'] = 0;

        if ($proOption) {
            $result['id'] = $proOption['id'];
            if ($proOption['xoatam']==0 && $id!=$proOption['id']) {
                $result['check'] = 1;
            }
            //$result['check'] = ($proOption['xoatam']==0) ? 1 : 0;
            $result['detail'] = $proOption;
        }

        echo json_encode($result);
    }
}
