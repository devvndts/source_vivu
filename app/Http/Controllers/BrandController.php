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

use Helper;

class BrandController extends Controller
{   

    public $relations = ['HasProduct'];

    public function ShowProducts($response, Request $request){
        //### gọi model
        $model = $this->brandRepo;//new Product('man');
        $lang = (isset($response->lang))?$response->lang:'vi';
        $field = (isset($response->field))?$response->field:'';
        $slug = (isset($response->slug))?$response->slug:'';
        $type = (isset($response->type))?$response->type:'';
        $category = (isset($response->category))?$response->category:'';
        $title_main = (isset($response->title))?$response->title:'';
        $model_question = 'brand';

        $arr_categorylist = $arr_brandlist = array();

        $array_category_id = $request->category_query;
        $array_brand_id = $request->brand_query;

        //### lấy ds brand và category filter
        if($array_brand_id){
            $arr_brandlist = explode(',', $array_brand_id);
        }

        if($array_category_id){
            $arr_categorylist = explode(',', $array_category_id);
        }


        //### lấy ds thương hiệu
        $thuonghieus = $this->brandRepo->GetAllItems('product');

        //### lấy ds danh mục cấp 3
        $danhmuc3 = $this->categoryRepo->GetAllItems('product',['level'=>2]);

        //### xử lý
        if($field!=''){
            //### lấy dữ liệu            
            $row_detail = $model->GetOneItem($field,$this->relations);

            $params['id_brand'] = $field;
            $params['hienthi'] = 1;

            $products = $this->productRepo->GetAllItems($type,$params,null,true);
            
            $title = ($row_detail['title'.$lang]!='') ? $row_detail['title'.$lang] : $row_detail['ten'.$lang];
            $keywords = ($row_detail['keywords'.$lang]!='') ? $row_detail['keywords'.$lang] : $row_detail['ten'.$lang];
            $description = ($row_detail['description'.$lang]!='') ? $row_detail['description'.$lang] : $row_detail['ten'.$lang];
            $title_crumb = ($row_detail['ten'.$lang]) ? $row_detail['ten'.$lang] : $title_main;
            $photo = ($row_detail['photo']!='')?Helper::GetConfigBase().UPLOAD_PRODUCT.$row_detail['photo']:'';
            $img_json_bar = ($row_detail['photo']!='')?Helper::getImgSize($row_detail['photo'],UPLOAD_PRODUCT.$row_detail['photo']):'';
            $published_time = date('c',$row_detail['ngaytao']);
            $modified_time = date('c',$row_detail['ngaysua']);
            //dd($title);

            //### Thiết lập breadcum
            Helper::setBreadCrumbs($row_detail['tenkhongdauvi'],$row_detail['ten'.$lang]);
            $breadcrumbs = Helper::getBreadCrumbs();

            //### lấy danh sách câu hỏi
            $question = $this->questionRepo->GetQuestions(['type'=>$type,'model'=>$model_question,'id_item'=>$row_detail['id'],'duyettin'=>1,'hienthi'=>1], null, true, false);


            //### trả dữ liệu -> blade view
            $response = array(
                "row_detail" => $row_detail,
                "products" => $products,                
                "title_crumb" => "Thương hiệu ".$title,
                "breadcrumbs" => $breadcrumbs,                
                "question" => $question,
                "type_question" => $type,
                "model_question" => $model_question,
                "id_item" => $row_detail['id'],
                "danhmuc3" => $danhmuc3,
                "thuonghieus" => $thuonghieus,
                "brandlist" => $arr_brandlist,
                "categorylist" => $arr_categorylist
            );
            $view =  view('desktop.templates.product.products')->with($response);

            /*### SEO TOOL */
            SEOMeta::setCanonical(url()->current());
            SEOMeta::setTitle($title);
            SEOMeta::setKeywords($keywords);
            SEOMeta::setDescription($description);

            OpenGraph::setDescription($description);
            OpenGraph::setTitle($title);
            OpenGraph::setUrl($request->url());
            if($field){
                OpenGraph::addProperty('type', 'article');
                SEOMeta::addMeta('article:published_time', $published_time, 'property');
                SEOMeta::addMeta('article:modified_time', $modified_time, 'property');
            }else{
                OpenGraph::addProperty('type', 'object');
            }
            if($img_json_bar!='' && count($img_json_bar)>0){ 
                OpenGraph::addImage($photo, ['height' => $img_json_bar['h'], 'width' => $img_json_bar['w'], 'type' => $img_json_bar['m'], 'alt' =>$title]);
            }else{
                OpenGraph::addImage($photo, ['alt' =>$title]);
            }

            TwitterCard::setTitle($title);
            TwitterCard::setDescription($description);
            TwitterCard::setImage($photo);  
        }else{
             //### lấy dữ liệu
            $model_seo = $this->seopageRepo;//new SeoPage();
            $type = 'product';
            $params['hienthi'] = 1;
            $products = $this->productRepo->GetAllItems($type,$params,null,true);
            $row_seo = $model_seo->GetItem(['type'=>$type]);
            $title = ($row_seo['title'.$lang]!='') ? $row_seo['title'.$lang] : $row_seo['ten'.$lang];
            $keywords = ($row_seo['keywords'.$lang]!='') ? $row_seo['keywords'.$lang] : $row_seo['ten'.$lang];
            $description = ($row_seo['description'.$lang]!='') ? $row_seo['description'.$lang] : $row_seo['ten'.$lang];
            $title_crumb = $title_main;
            $photo = ($row_seo['photo']!='')?Helper::GetConfigBase().UPLOAD_SEOPAGE.$row_seo['photo']:'';
            $img_json_bar = ($row_seo['photo']!='')?Helper::getImgSize($row_seo['photo'],UPLOAD_SEOPAGE.$row_seo['photo']):'';

            /* breadCrumbs */
            if(isset($title_crumb) && $title_crumb != '') Helper::setBreadCrumbs($slug,$title_main);
            $breadcrumbs = Helper::getBreadCrumbs();

            //### trả dữ liệu -> blade view
            $response = array(
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

        return $view;
    }
}
