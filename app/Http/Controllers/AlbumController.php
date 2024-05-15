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

use App\Http\Traits\SupportTrait;

use Helper;

class AlbumController extends Controller
{
    public function ShowAlbums($response, Request $request){
        //### gọi model
        $model = $this->albumRepo;//new Album('man');
        $lang = (isset($response->lang))?$response->lang:'vi';
        $field = (isset($response->field))?$response->field:'';
        $slug = (isset($response->slug))?$response->slug:'';
        $type = (isset($response->type))?$response->type:'';
        $category = (isset($response->category))?$response->category:'';
        $title_main = (isset($response->title))?$response->title:'';

        //### xử lý
        if($field!=''){
            //### lấy dữ liệu
            $model_gallery = $this->galleryRepo;//new Gallery();
            $row_detail = $model->GetOneItem($field);
            $albums = $model->GetAllItemsExceptId($type,['id'=>$field, 'id_category'=>$row_detail['id_category']],null, true);
            $hinhanhsp = $model_gallery->GetAllGallery($type,$field,'album');
            
            $title = ($row_detail['title'.$lang]!='') ? $row_detail['title'.$lang] : $row_detail['ten'.$lang];
            $keywords = ($row_detail['keywords'.$lang]!='') ? $row_detail['keywords'.$lang] : $row_detail['ten'.$lang];
            $description = ($row_detail['description'.$lang]!='') ? $row_detail['description'.$lang] : $row_detail['ten'.$lang];
            $title_crumb = ($row_detail['ten'.$lang]) ? $row_detail['ten'.$lang] : $title_main;
            $photo = ($row_detail['photo']!='')?Helper::GetConfigBase().UPLOAD_ALBUM.$row_detail['photo']:'';
            $img_json_bar = ($row_detail['photo']!='')?Helper::getImgSize($row_detail['photo'],UPLOAD_ALBUM.$row_detail['photo']):'';
            $published_time = date('c',$row_detail['ngaytao']);
            $modified_time = date('c',$row_detail['ngaysua']);

            //### Thiết lập breadcum
            $arr_parentCategory = array();
            array_push($arr_parentCategory, $row_detail['id_category']);
            $arr_parentCategory = array_merge($arr_parentCategory, $this->categoryRepo->GetParentCategory($type,$row_detail['id_category']));
            $arr_parentCategory = array_reverse($arr_parentCategory);

            if(isset($title_crumb) && $title_crumb != '') Helper::setBreadCrumbs($slug,$title_main);
            if($arr_parentCategory){      
                foreach($arr_parentCategory as $k=>$v){
                    $row_breadcum = $this->categoryRepo->GetOneItem($v);
                    Helper::setBreadCrumbs($row_breadcum['tenkhongdauvi'],$row_breadcum['ten'.$lang]);
                }
            } 
            Helper::setBreadCrumbs($row_detail['tenkhongdauvi'],$row_detail['ten'.$lang]);
            $breadcrumbs = Helper::getBreadCrumbs();

            //### trả dữ liệu -> blade view
            $response = array(
                "row_detail" => $row_detail,
                "albums" => $albums,
                "hinhanhsp" => $hinhanhsp,
                "title" => $title,
                "keywords" => $keywords,
                "description" => $description,
                "title_crumb" => $title_crumb,
                "other_title_crumb" => "Danh mục khác",
                "breadcrumbs" => $breadcrumbs
            );
            $view = view('desktop.templates.album.album_detail')->with($response);
        }else{
            //### lấy dữ liệu
            $model_seo = $this->seopageRepo;//new SeoPage();
            $albums = $model->GetAllItems($type,null,null,true);
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
                "albums" => $albums,                    
                "title_crumb" => $title_crumb,
                "breadcrumbs" => $breadcrumbs
            );
            $view = view('desktop.templates.album.albums')->with($response);
        }

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

        return $view;
    }
}
