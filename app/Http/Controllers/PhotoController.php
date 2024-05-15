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

class PhotoController extends Controller
{
    public function index($response, Request $request)
    {
        //### lấy dữ liệu
        $model_seo = $this->seopageRepo;
        $lang = (isset($response->lang))?$response->lang:'vi';
        $slug = (isset($response->slug))?$response->slug:'';
        $type = (isset($response->type))?$response->type:'';
        $title_main = (isset($response->title))?$response->title:'';

        $data = get_photos($type, $lang);
        $row_seo = $model_seo->GetItem(['type'=>$type]);
        $title = (@$row_seo['title'.$lang]!='') ? $row_seo['title'.$lang] : @$row_seo['ten'.$lang];
        $keywords = (@$row_seo['keywords'.$lang]!='') ? $row_seo['keywords'.$lang] : @$row_seo['ten'.$lang];
        $description = (@$row_seo['description'.$lang]!='') ? $row_seo['description'.$lang] : @$row_seo['ten'.$lang];
        $title_crumb = $title_main;
        $photo = (@$row_seo['photo']!='')?Helper::GetConfigBase().UPLOAD_SEOPAGE.$row_seo['photo']:'';
        $img_json_bar = (@$row_seo['photo']!='')?Helper::getImgSize($row_seo['photo'], UPLOAD_SEOPAGE.$row_seo['photo']):'';

        /* breadCrumbs */
        if (isset($title_crumb) && $title_crumb != '') {
            Helper::setBreadCrumbs($slug, $title_main);
        }
        $breadcrumbs = Helper::getBreadCrumbs();

        //### trả dữ liệu -> blade view
        $response = array(
            "data" => $data,
            "title" => $title,
            "keywords" => $keywords,
            "description" => $description,
            "title_crumb" => $title_crumb,
            "breadcrumbs" => $breadcrumbs
        );
        /*### SEO TOOL */
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setTitle($title);
        SEOMeta::setKeywords($keywords);
        SEOMeta::setDescription($description);

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($request->url());
        OpenGraph::addProperty('type', 'object');
        if ($img_json_bar!='' && count($img_json_bar)>0) {
            OpenGraph::addImage($photo, ['height' => $img_json_bar['h'], 'width' => $img_json_bar['w'], 'type' => $img_json_bar['m'], 'alt' =>$title]);
        } else {
            OpenGraph::addImage($photo, ['alt' =>$title]);
        }

        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setImage($photo);

        return view('desktop.templates.photo.man')->with($response);
    }
}
