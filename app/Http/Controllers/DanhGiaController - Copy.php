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

class DanhGiaController extends Controller
{

    use SupportTrait;

    public function Show(Request $request){        
        //### xử lý dữ liệu : những dữ liệu chung cho tất cả các view blade
        $lang = app('lang');
        $setting = app('setting');
        $logo = app('logo');
        $photo = ($logo['photo']!='')?Helper::GetConfigBase().UPLOAD_PHOTO.$logo['photo']:'';
        $img_json_bar = ($logo['photo']!='')?Helper::getImgSize($logo['photo'],UPLOAD_PHOTO.$logo['photo']):'';

        $danhgias = $this->danhgiaRepo->GetAllItems('',['hienthi'=>1], ['HasProduct']);
        //đổ dữ liệu
        $response = array(
            "danhgias" => $danhgias
        );

        /*### SEO TOOL */
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setTitle($setting['title'.$lang]);
        SEOMeta::setKeywords($setting['keywords'.$lang]);
        SEOMeta::setDescription($setting['description'.$lang]);
        
        OpenGraph::setDescription($setting['description'.$lang]);
        OpenGraph::setTitle($setting['title'.$lang]);
        OpenGraph::setUrl($request->url());
        OpenGraph::addProperty('type', 'object');
        if($img_json_bar!='' && count($img_json_bar)>0){ 
            OpenGraph::addImage($photo, ['height' => $img_json_bar['h'], 'width' => $img_json_bar['w'], 'type' => $img_json_bar['m'], 'alt' =>$setting['title'.$lang]]);
        }else{
            OpenGraph::addImage($photo, ['alt' =>$setting['title'.$lang]]);
        }

        TwitterCard::setTitle($setting['title'.$lang]);
        TwitterCard::setDescription($setting['description'.$lang]);
        TwitterCard::setImage($photo);

        
        return view('desktop.templates.danhgia.man')->with($response);
    }
}
