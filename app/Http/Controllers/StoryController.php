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

class StoryController extends Controller
{
    use SupportTrait;

    public function Show(Request $request)
    {
        //### xử lý dữ liệu : những dữ liệu chung cho tất cả các view blade
        
        // $lang = app('lang');
        // $setting = app('setting');
        // $logo = app('logo');
        // $photo = ($logo['photo']!='')?Helper::GetConfigBase().UPLOAD_PHOTO.$logo['photo']:'';
        // $img_json_bar = ($logo['photo']!='')?Helper::getImgSize($logo['photo'],UPLOAD_PHOTO.$logo['photo']):'';

        // $danhgias = $this->danhgiaRepo->GetAllItems('',['hienthi'=>1], ['HasProduct']);

        $model_post = $this->postRepo;

        $nhaSangLap = get_static('nha-sang-lap');
        $taiSaoLaNatural = get_static('tai-sao-la-natural');
        $slide2Cauchuyen = get_photos('slide2-cauchuyen');
        $bannerCauchuyen = get_photos('banner-cauchuyen');
        $chungNhanCongBo = get_photos('chungnhancongbo');
        $giaTriCotLoi = get_posts('gia-tri-cot-loi');
        $chungNhanChuyenGia = get_posts('chungnhanchuyengia');
        $baoChi = get_posts('baochi');
        $productsNew = $model_post->GetAllItems('dong-san-pham', ['hienthi'=>1]);
        if ($bannerCauchuyen) {
            $bannerCauchuyen = $bannerCauchuyen->toArray();
        }
        //đổ dữ liệu
        $response = array(
            // "danhgias" => $danhgias
            'bannerCauchuyen' => $bannerCauchuyen,
            'slide2Cauchuyen' => $slide2Cauchuyen,
            'chungNhanCongBo' => $chungNhanCongBo,
            'nhaSangLap' => $nhaSangLap,
            'taiSaoLaNatural' => $taiSaoLaNatural,
            'giaTriCotLoi' => $giaTriCotLoi,
            'chungNhanChuyenGia' => $chungNhanChuyenGia,
            'baoChi' => $baoChi,
            'productsNew' => $productsNew,
        );

        /*### SEO TOOL */
        // SEOMeta::setCanonical(url()->current());
        // SEOMeta::setTitle($setting['title'.$lang]);
        // SEOMeta::setKeywords($setting['keywords'.$lang]);
        // SEOMeta::setDescription($setting['description'.$lang]);
        
        // OpenGraph::setDescription($setting['description'.$lang]);
        // OpenGraph::setTitle($setting['title'.$lang]);
        // OpenGraph::setUrl($request->url());
        // OpenGraph::addProperty('type', 'object');
        // if($img_json_bar!='' && count($img_json_bar)>0){
        //     OpenGraph::addImage($photo, ['height' => $img_json_bar['h'], 'width' => $img_json_bar['w'], 'type' => $img_json_bar['m'], 'alt' =>$setting['title'.$lang]]);
        // }else{
        //     OpenGraph::addImage($photo, ['alt' =>$setting['title'.$lang]]);
        // }

        // TwitterCard::setTitle($setting['title'.$lang]);
        // TwitterCard::setDescription($setting['description'.$lang]);
        // TwitterCard::setImage($photo);

        
        return view('desktop.templates.story.man')->with($response);
    }
}
