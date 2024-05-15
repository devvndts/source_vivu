<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/*SEO Tool*/
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;// OR with multi
//use Artesaos\SEOTools\Facades\JsonLdMulti;// OR
//use Artesaos\SEOTools\Facades\SEOTools;
/*### END SEO Tool*/

use App\Models\OrderDetail;

use Helper;
use TableManipulation;

class ProductController extends Controller
{
    public $relations = ['HasProductOptions', 'HasProductOptionsAll', 'HasAllChild', 'HasProductOptionsSample'];

    public function ShowProducts($response, Request $request)
    {
        //### gọi model
        $model = $this->productRepo;//new Product('man');
        $lang = (isset($response->lang))?$response->lang:'vi';
        $field = (isset($response->field))?$response->field:'';
        $slug = (isset($response->slug))?$response->slug:'';
        $type = (isset($response->type))?$response->type:'';
        $category = (isset($response->category))?$response->category:'';
        $title_main = (isset($response->title))?$response->title:'';
        $model_question = 'product';

        $arr_categorylist = $arr_brandlist = array();
        $array_category_id = $request->category_query;
        $array_brand_id = $request->brand_query;

        //### lấy ds brand và category filter
        if ($array_brand_id) {
            $arr_brandlist = explode(',', $array_brand_id);
        }

        if ($array_category_id) {
            $arr_categorylist = explode(',', $array_category_id);
        }

        //### lấy ds thương hiệu
        $thuonghieus = $this->brandRepo->GetAllItems('product');

        //### lấy ds danh mục cấp 3
        $danhmuc3 = $this->categoryRepo->GetAllItems('product', ['level'=>2]);
        

        //### xử lý
        if ($field!='') {
            //### lấy dữ liệu
            $model_gallery = $this->galleryRepo;//new Gallery();
            $row_detail = $model->GetOneItem($field, $this->relations);

            //### lấy ds ids category
            if ($row_detail['id_category']!=0) {
                $id_cate  = $row_detail['id_category'];
                $arr_childCategory = $arr_parentCategory = array();
                $row_detail_cate = $this->categoryRepo->GetOneItem($id_cate, null);

                //lấy ds category con
                array_push($arr_childCategory, (int)$id_cate);
                $arr_childCategory = array_merge($arr_childCategory, $this->categoryRepo->GetChildCategory($type, $id_cate));
                $params['id_category'] = $arr_childCategory;

                //lấy ds category cha
                array_push($arr_parentCategory, $row_detail_cate['id_parent']);
                $arr_parentCategory = array_merge($arr_parentCategory, $this->categoryRepo->GetParentCategory($type, $row_detail_cate['id_parent']));
                $arr_parentCategory = array_reverse($arr_parentCategory);
            }


            //dd($row_detail['id_category']);
            $id_category = $row_detail['ids_level_3'];


            //### lấy ds bài viết theo ids_level
            if (TableManipulation::CheckFieldToTable('product', 'ids_level_1') && $row_detail['ids_level_1']!='') {
                $id_cate  = $row_detail['ids_level_1'];
                $params['ids_level_1'] = explode(',', $id_cate);
            }

            $params['id'] = $field;
            $params['hienthi'] = 1;

            $products = $model->GetAllItemsExceptId($type, $params, null, true);
            $hinhanhsp = $model_gallery->GetAllItems($type, ['id_photo'=>$row_detail['id'], 'kind'=>'man', 'val'=>$type, 'com'=>'product']);
            //### lấy post relate
            $postQuestion = $this->postRepo->GetAllItems('q_a', ['id_product'=>$row_detail['id']], null, false);
            $title = ($row_detail['title'.$lang]!='') ? $row_detail['title'.$lang] : $row_detail['ten'.$lang];
            $keywords = ($row_detail['keywords'.$lang]!='') ? $row_detail['keywords'.$lang] : $row_detail['ten'.$lang];
            $description = ($row_detail['description'.$lang]!='') ? $row_detail['description'.$lang] : $row_detail['ten'.$lang];
            $title_crumb = ($row_detail['ten'.$lang]) ? $row_detail['ten'.$lang] : $title_main;
            $photo = ($row_detail['photo']!='')?Helper::GetConfigBase().UPLOAD_PRODUCT.$row_detail['photo']:'';
            $img_json_bar = ($row_detail['photo']!='')?Helper::getImgSize($row_detail['photo'], UPLOAD_PRODUCT.$row_detail['photo']):'';
            $published_time = date('c', $row_detail['ngaytao']);
            $modified_time = date('c', $row_detail['ngaysua']);

            //### kiểm tra số lượng
            $is_soluong=true;
            if ((config('config_all.order.soluong') || config('lazada.active'))) {
                $is_soluong = ($row_detail['soluong']>0) ? true : false;
            }
            /* Lấy color */
            $mau='';
            $gallery_color = array();
            $configPath = sprintf('config_type.product.%s.mau', $type);
            $hasColor = config($configPath);
            if ($hasColor && $row_detail['id_mau']) {
                //$model_color = $this->colorRepo;//new Color();
                //$mau = $model_color->GetAllItemsFindInSet($type,'id',$row_detail['id_mau']);
                $ids_mau = $this->productOptRepo->GetAllItemsByParamsPluck('id_mau', ['type'=>$type, 'id_product'=>$row_detail['id'], 'xoatam'=>0, 'hienthi'=>1]);
                $mau = $this->colorRepo->GetAllItemByIds($ids_mau);

                //### Lấy ds gallery color
                if ($mau) {
                    foreach ($mau as $k => $v) {
                        $gallery_color[$v['id']] = $model_gallery->GetAllItems('product_color', ['id_photo'=>$row_detail['id'], 'id_color'=>$v['id']]);
                    }
                }
            }


            /* Lấy size */
            $size=[];
            $row_option_all=null;
            if ($row_detail['id_size']) {
                //$model_size = $this->sizeRepo;//new Size();
                //$size = $model_size->GetAllItemsFindInSet($type,'id',$row_detail['id_size']);
                $ids_size = $this->productOptRepo->GetAllItemsByParamsPluck('id_size', ['type'=>$type, 'id_product'=>$row_detail['id'], 'xoatam'=>0, 'hienthi'=>1]);
                $size = $this->sizeRepo->GetAllItemByIds($ids_size);
                $row_option_all = $this->productOptRepo->GetAllItems($type, ['id_product'=>$row_detail['id'], 'xoatam'=>0, 'phienbanmau'=>0]);
                // $size = [["id" => 16 ],["id" => 20 ] ];
                // $row_option_all = [["id_size" => 20, "giacu" => 20 ],["id_size" => 16, "giacu" => 16 ] ];
                if ($size) {
                    foreach ($size as $key => $value) {
                        foreach ($row_option_all as $value2) {
                            if ($value2["id_size"] == $value["id"]) {
                                $size[$key]["gia"] = $value2["gia"];
                                $size[$key]["giamoi"] = $value2["giamoi"];
                                $size[$key]["sale_giamoi"] = $value2["sale_giamoi"];
                            }
                        }
                    }
                }
            }


            /* Lấy thông tin phiên bản đầu tiên */
            $idmau = ($mau) ? $mau[0] : 0;
            $idsize = ($size) ? $size[0] : 0;
            $row_option_first = $this->productOptRepo->GetItem(['id_product'=>$row_detail['id'], 'id_size'=>$idsize, 'id_mau'=>$idmau]);
            $giamoi = ($row_option_first) ? $row_option_first['giamoi'] : $row_detail['giamoi'];
            $gia = ($row_option_first) ? $row_option_first['gia'] : $row_detail['gia'];
            $giakm = ($row_option_first) ? $row_option_first['giakm'] : $row_detail['giakm'];
            $is_version = ($row_option_first) ? true : false;
            if ($row_option_first) {
                if ((config('config_all.order.soluong') || config('lazada.active'))) {
                    $is_soluong = ($row_option_first['soluong']>0) ? true : false;
                }
            }
            //### Lấy thông tin category
            $row_category = $this->categoryRepo->GetOneItem($row_detail['id_category']);


            //### Thiết lập breadcum
            $arr_parentCategory = array();
            array_push($arr_parentCategory, $row_detail['id_category']);
            $arr_parentCategory = array_merge($arr_parentCategory, $this->categoryRepo->GetParentCategory($type, $row_detail['id_category']));
            $arr_parentCategory = array_reverse($arr_parentCategory);

            if (isset($title_crumb) && $title_crumb != '') {
                Helper::setBreadCrumbs($slug, $title_main);
            }
            if ($arr_parentCategory) {
                foreach ($arr_parentCategory as $k => $v) {
                    $row_breadcum = $this->categoryRepo->GetOneItem($v);
                    Helper::setBreadCrumbs($row_breadcum['tenkhongdauvi'] ?? '', $row_breadcum['ten'.$lang] ?? '');
                }
            }
            Helper::setBreadCrumbs($row_detail['tenkhongdauvi'] ?? '', $row_detail['ten'.$lang] ?? '');
            $breadcrumbs = Helper::getBreadCrumbs();


            //### lấy thông tin : hướng dẫn thanh toán và chính sách đổi trả
            $huongdanthanhtoan = $this->staticRepo->GetItem(['type'=>'huongdanthanhtoan']);
            $chinhsachdoitra = $this->staticRepo->GetItem(['type'=>'chinhsachdoitra']);


            //### lấy danh sách câu hỏi
            $question = $this->questionRepo->GetQuestions(['type'=>$type,'model'=>$model_question,'id_item'=>$row_detail['id'],'duyettin'=>1,'hienthi'=>1], null, true, false);


            //### Lấy thông tin đánh giá
            $info_rating = $this->GetRating($row_detail);
            $danhgia_list = $this->danhgiaRepo->GetAllItems('', ['id_product'=>$field,'hienthi'=>1], null, true, false);

            //### đếm số lượt mua hàng
            $order_detail = new OrderDetail();
            $count_luotmua = $order_detail->where('id_product', $field)->where('hienthi', 1)->count();

            //### Lấy ds tags của sản phẩm hiện tại
            $tags = array();
            if ($row_detail['id_tags']!='') {
                $tag_arr = explode(',', $row_detail['id_tags']);
                $tags = $this->tagRepo->Query()->whereIn('id', $tag_arr)->where('hienthi', 1)->get();
                if ($tags) {
                    $tags = $tags->toArray();
                }
            }
            $sl_options = (isset($row_detail['sl_options']) && $row_detail['sl_options'] != '') ? json_decode($row_detail['sl_options'], true) : null;

            // BEGIN get data for chuongtrinh.detail
            $data = [];
            $data['name'] = $row_detail["ten$lang"] ?? '';
            $data['description'] = $row_detail["noidung$lang"] ?? '';
            $data['overview'] = $row_detail["huongdan$lang"] ?? '';
            $data['reviews'] = $row_detail["thanhphan$lang"] ?? '';
            $data['sl_options'] = $row_detail["sl_options"] ?? [];
            $data['sl_options'] = json_decode($data['sl_options'], true);

            $postTypeList = config('config_type.product.'.$type.'.post_product');
            $paramsPost = [
                'id_product' => $row_detail['id'],
                'hienthi' => 1,
            ];
            foreach ($postTypeList as $key => $value) {
                $postType = $key;
                $getPost = $this->postRepo->GetAllItems($postType, $paramsPost);
                $data[$postType] = $getPost ?? null;
            }
            // END get data for chuongtrinh.detail
            //### trả dữ liệu -> blade view
            $response = array(
                "template" => 'chuongtrinh.detail',
                "data" => $data,
                "row_detail" => $row_detail,
                "row_option_all" => $row_option_all,
                "products" => $products,
                'sl_options'=> $sl_options,
                "hinhanhsp" => $hinhanhsp,
                "postQuestion" => $postQuestion,
                "title_crumb" => "Chi Tiết ".$title_main,
                "breadcrumbs" => $breadcrumbs,
                "mau" => $mau,
                "size" => $size,
                "pro_list" => $row_category,
                "huongdanthanhtoan" => $huongdanthanhtoan,
                "chinhsachdoitra" => $chinhsachdoitra,
                "gallery_color" => $gallery_color,
                'giamoi' =>$giamoi,
                'gia' =>$gia,
                'giakm' =>$giakm,
                'is_version' => $is_version,
                'is_soluong' => $is_soluong,
                "question" => $question,
                "type_question" => $type,
                "model_question" => $model_question,
                "id_item" => $row_detail['id'],
                "id_category" => $id_category,
                "info_rating" => $info_rating,
                "danhgia_list" => $danhgia_list,
                "count_luotmua" => $count_luotmua,
                "tags" => $tags
            );
            $view =  view('desktop.templates.chuongtrinh.detail')->with($response);
        } else {
            //### lấy dữ liệu
            $model_seo = $this->seopageRepo;//new SeoPage();
            $params['hienthi'] = 1;
            if ($slug == 'khuyen-mai') {
                $params['noibat'] = 1;
            }
            if ($slug == 'flashsale') {
                $params['banchay'] = 1;
            }
            if (isset($request->all()['order_by'])) {
                $params['order_by'] = $request->all()['order_by'];
            }
            $products = $model->GetAllItems($type, $params, null, true);
            $row_seo = (array)$model_seo->GetItem(['type'=>$type]);
            // if (is_null($row_seo)) {
            //     $row_seo = [];
            // }
            $title = $row_seo['title'.$lang] ?? '';
            $keywords = $row_seo['keywords'.$lang] ?? '';
            $description = $row_seo['description'.$lang] ?? '';
            $tenviRowSeo = $row_seo['ten'.$lang] ?? '';
            $photoRowSeo = $row_seo['photo'] ?? '';
            $title = $title ?? $tenviRowSeo;
            $keywords = $keywords ?? $tenviRowSeo;
            $description = $description ?? $tenviRowSeo;
            $title_crumb = $title_main;
            $photo = ($photoRowSeo)?Helper::GetConfigBase().UPLOAD_SEOPAGE.$photoRowSeo:'';
            $img_json_bar = ($photoRowSeo)?Helper::getImgSize($photoRowSeo, UPLOAD_SEOPAGE.$photoRowSeo):'';

            /* breadCrumbs */
            if (isset($title_crumb) && $title_crumb != '') {
                Helper::setBreadCrumbs($slug, $title_main);
            }
            $breadcrumbs = Helper::getBreadCrumbs();

            //### trả dữ liệu -> blade view
            $response = array(
                "type" => $type,
                "params" => $params,
                "products" => $products,
                "title_crumb" => $title_crumb,
                "breadcrumbs" => $breadcrumbs,
                "danhmuc3" => $danhmuc3,
                "thuonghieus" => $thuonghieus,
                "brandlist" => $arr_brandlist,
                "categorylist" => $arr_categorylist
            );
            $view = view('desktop.templates.product.products')->with($response);
        }

        /*### SEO TOOL */
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setTitle($title);
        SEOMeta::setKeywords($keywords);
        SEOMeta::setDescription($description);

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($request->url());
        if ($field) {
            OpenGraph::addProperty('type', 'article');
            SEOMeta::addMeta('article:published_time', $published_time, 'property');
            SEOMeta::addMeta('article:modified_time', $modified_time, 'property');
        } else {
            OpenGraph::addProperty('type', 'object');
        }
        if ($img_json_bar!='' && count($img_json_bar)>0) {
            OpenGraph::addImage($photo, ['height' => $img_json_bar['h'], 'width' => $img_json_bar['w'], 'type' => $img_json_bar['m'], 'alt' =>$title]);
        } else {
            OpenGraph::addImage($photo, ['alt' =>$title]);
        }

        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setImage($photo);

        return $view;
    }


    private function GetRating($product)
    {
        $row = $this->danhgiaRepo->Query()->addSelect([
            'onestar'=> $this->danhgiaRepo->Query()->selectRaw('count(id)')->where('id_product', $product['id'])->where('star', 1),
            'twostar'=> $this->danhgiaRepo->Query()->selectRaw('count(id)')->where('id_product', $product['id'])->where('star', 2),
            'threestar'=> $this->danhgiaRepo->Query()->selectRaw('count(id)')->where('id_product', $product['id'])->where('star', 3),
            'fourstar'=> $this->danhgiaRepo->Query()->selectRaw('count(id)')->where('id_product', $product['id'])->where('star', 4),
            'fivestar'=> $this->danhgiaRepo->Query()->selectRaw('count(id)')->where('id_product', $product['id'])->where('star', 5),
            'allrating'=> $this->danhgiaRepo->Query()->selectRaw('count(id)')->where('id_product', $product['id']),
            'maxstar'=> $this->danhgiaRepo->Query()->selectRaw('sum(star)')->where('id_product', $product['id'])
        ])->first();

        return $row;
    }


    private function GetListRating($product)
    {
        $row = $this->danhgiaRepo->Query()->where('id_product', $product['id']);
        if ($row) {
            return $row->get()->toArray();
        }
        return null;
    }
}
