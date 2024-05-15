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


class TagController extends Controller
{
    public function ShowProducts($response, Request $request){
        //### gọi model
        $model_tag = $this->tagRepo;//new Tags();
        $lang = (isset($response->lang))?$response->lang:'vi';
        $field = (isset($response->field))?$response->field:'';
        $slug = (isset($response->slug))?$response->slug:'';
        $type = (isset($response->type))?$response->type:'';
        $table_tag = (isset($response->table_tag))?$response->table_tag:'';
        $category = (isset($response->category))?$response->category:'';
        $title_main = (isset($response->title))?$response->title:'';
        $arr_childCategory = $arr_parentCategory = $arr_categorylist = $arr_brandlist = array();

        $array_category_id = $request->category_query;
        $array_brand_id = $request->brand_query;

        //### lấy ds brand và category filter
        if($array_brand_id){
            $arr_brandlist = explode(',', $array_brand_id);
        }

        if($array_category_id){
            $arr_categorylist = explode(',', $array_category_id);
        }

        //### lấy dữ liệu
        if($field!='' && $table_tag!=''){
            //### check table tag to
            switch ($table_tag) {
                case 'product':
                    $model_table_tag = $this->productRepo;//new Product('man');
                    break;                
                case 'post':
                    $model_table_tag = $this->postRepo;//new Product('man');
                    break;
            }
           
            $row_detail = $model_tag->GetOneItem($field);
            $title = ($row_detail['title'.$lang]!='') ? $row_detail['title'.$lang] : $row_detail['ten'.$lang];
            $keywords = ($row_detail['keywords'.$lang]!='') ? $row_detail['keywords'.$lang] : $row_detail['ten'.$lang];
            $description = ($row_detail['description'.$lang]!='') ? $row_detail['description'.$lang] : $row_detail['ten'.$lang];
            $title_crumb = ($row_detail['ten'.$lang]) ? $row_detail['ten'.$lang] : $title_main;
            $photo = ($row_detail['photo']!='')?Helper::GetConfigBase().UPLOAD_TAGS.$row_detail['photo']:'';
            $img_json_bar = ($row_detail['photo']!='')?Helper::getImgSize($row_detail['photo'],UPLOAD_TAGS.$row_detail['photo']):'';

            /* breadCrumbs */
            $products = $model_table_tag->GetAllItemsFindInSetField($type,$field,'id_tags',null,true);

            //if(isset($title_crumb) && $title_crumb != '') Helper::setBreadCrumbs($slug,$title_main);
            Helper::setBreadCrumbs('tags/'.$row_detail['tenkhongdauvi'],$row_detail['ten'.$lang]);
            $breadcrumbs = Helper::getBreadCrumbs();


            //### lấy ds thương hiệu
            $thuonghieus = $this->brandRepo->GetAllItems('product');

            //### lấy ds danh mục cấp 3
            $danhmuc3 = $this->categoryRepo->GetAllItems('product',['level'=>2]);


            //### trả dữ liệu -> blade view
            $response = array(
                "products" => $products,
                "title" => $title,
                "keywords" => $keywords,
                "description" => $description,
                "title_crumb" => $title_crumb,
                "breadcrumbs" => $breadcrumbs,
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
            OpenGraph::addProperty('type', 'object');
            if($img_json_bar!='' && count($img_json_bar)>0){ 
                OpenGraph::addImage($photo, ['height' => $img_json_bar['h'], 'width' => $img_json_bar['w'], 'type' => $img_json_bar['m'], 'alt' =>$title]);
            }else{
                OpenGraph::addImage($photo, ['alt' =>$title]);
            }

            TwitterCard::setTitle($title);
            TwitterCard::setDescription($description);
            TwitterCard::setImage($photo); 

            return $view;
        }
    }
}
