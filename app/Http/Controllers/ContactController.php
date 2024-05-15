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
use App\Models\Order;
use App\Models\OrderDetail;
use App\Payment\Alepay;
use Helper;

class ContactController extends Controller
{
    use SupportTrait;

    /*
    |--------------------------------------------------------------------------
    | Hiển thị giao diện đăng ký mail liên hệ
    |--------------------------------------------------------------------------
    */
    public function ShowContact($response, Request $request){
        //### gọi model
        $model = $this->staticRepo;//new StaticPost();
        $lang = (isset($response->lang))?$response->lang:'vi';
        $type = (isset($response->type))?$response->type:'';
        $title_main = (isset($response->title))?$response->title:'';
        $slug = (isset($response->slug))?$response->slug:'';
        
        //### xử lý
        $row_detail = $model->GetItem(['type'=>$type]);
        $row_detail = $row_detail ?? [];
        $title = $row_detail['title'.$lang] ?? ($row_detail['ten'.$lang] ?? '');
        $keywords = $row_detail['keywords'.$lang] ?? ($row_detail['ten'.$lang] ?? '');
        $description = $row_detail['description'.$lang] ?? ($row_detail['ten'.$lang] ?? '');
        $title_crumb = $row_detail['ten'.$lang] ?? $title_main;
        $photo = ($row_detail['photo']!='')?Helper::GetConfigBase().UPLOAD_STATICPOST.$row_detail['photo']:'';
        $img_json_bar = ($row_detail['photo']!='')?Helper::getImgSize($row_detail['photo'],UPLOAD_STATICPOST.$row_detail['photo']):'';

        /* breadCrumbs */
        if(isset($title_crumb) && $title_crumb != '') Helper::setBreadCrumbs($slug,$title_main);
        $breadcrumbs = Helper::getBreadCrumbs();

        //### trả dữ liệu -> blade view
        $response = array(
            "row_detail" => $row_detail,
            "title" => $title,
            "type" => $type,
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
        if($img_json_bar!='' && count($img_json_bar)>0){ 
            OpenGraph::addImage($photo, ['height' => $img_json_bar['h'], 'width' => $img_json_bar['w'], 'type' => $img_json_bar['m'], 'alt' =>$title]);
        }else{
            OpenGraph::addImage($photo, ['alt' =>$title]);
        }

        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setImage($photo);   

        return view('desktop.templates.contact.contact_mail')->with($response);
    }
}
