<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*SEO Tool*/
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;// OR with multi
//use Artesaos\SEOTools\Facades\JsonLdMulti;// OR
//use Artesaos\SEOTools\Facades\SEOTools;
/*### END SEO Tool*/



use App\Http\Traits\SupportTrait;

use Helper, CartHelper;

class HomeController extends Controller
{
    use SupportTrait;

    public function Index(Request $request){

        if(!Auth::guard('admin')->check() && config('config_all.lockpage')==true && $request->getPathInfo()!='/view'){
            return view('welcome');
        }
        

        //### xử lý dữ liệu : những dữ liệu chung cho tất cả các view blade
        $lang = app('lang');

        //gọi đối tượng truy vấn
        $model_product = $this->productRepo;
        $model_post = $this->postRepo;
        $model_staticpost = $this->staticRepo;
        $model_photo = $this->photoRepo;
        $model_brand = $this->brandRepo;
        $model_category = $this->categoryRepo;
        $model_coupon = $this->couponRepo;
        $model_tag = $this->tagRepo;
        $model_danhgia = $this->danhgiaRepo;

        //xử lý        
        $khachhangs = $model_danhgia->GetAllItems('',['hienthi'=>1], ['HasProduct']);
        //dd($khachhangs);
        //$khachhangs = $model_post->GetAllItems('khachhangdanhgia',['hienthi'=>1]);
        $products = $model_product->GetAllItems('product',['hienthi'=>1,'noibat'=>1], ['BelongToBrand'], false, false, 8);
        $gioithieu = $model_staticpost->GetItem(['type'=>'thongdiep']);
        $brands = $model_brand->GetAllItems('product', ['hienthi'=>1, 'noibat'=>1], ['HasProduct']);
        $slider = $model_photo->GetAllItems('slide', ['hienthi'=>1]);
        $slidemobile = $model_photo->GetAllItems('slidemobile', ['hienthi'=>1]);
        $nhacungcap = $model_photo->GetAllItems('nhacungcap', ['hienthi'=>1]);  
        $coupon_noibat = $model_coupon->GetItem(['hienthi'=>1, 'noibat'=>1]);   
        $tag_search = $model_tag->GetAllItems('search',['hienthi'=>1]);  

        $quangcaos = $model_photo->GetAllItems('quangcao', ['hienthi'=>1]);
        //$mangxahoi_f = $model_photo->GetAllItems('mangxahoi_f', ['hienthi'=>1]);
        $ketnoi = $model_photo->GetAllItems('ketnoi', ['hienthi'=>1]);

        $setting = app('setting');
        $logo = app('logo');

        $photo = ($logo['photo']!='')?Helper::GetConfigBase().UPLOAD_PHOTO.$logo['photo']:'';
        $img_json_bar = ($logo['photo']!='')?Helper::getImgSize($logo['photo'],UPLOAD_PHOTO.$logo['photo']):'';

        //### lấy ds câu hỏi
        $question = $this->questionRepo->GetQuestions(['type'=>'product','duyettin'=>1,'hienthi'=>1], null, false, false, 2);
        
        $count_question = $this->questionRepo->GetQuestions(['type'=>'product','duyettin'=>1,'hienthi'=>1], null, false, false, false);

        //đổ dữ liệu
        $response = array(
            "products" => $products,
            "gioithieu" => $gioithieu,
            "brands" => $brands,
            //"mangxahoi_f" => $mangxahoi_f,
            "ketnoi" => $ketnoi,
            "khachhangs" => $khachhangs,
            "nhacungcap" => $nhacungcap,
            "slider" => $slider,
            "quangcaos" => $quangcaos,
            "slidemobile" => $slidemobile,
            "question" => $question,
            "count_question" => $count_question,
            "coupon_noibat" => $coupon_noibat,
            "tag_search" => $tag_search
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

        
        return view('desktop.templates.home')->with($response);
    }
}
