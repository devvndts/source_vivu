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
use App\Models\Newsletter;
use Helper;
use CartHelper;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    use SupportTrait;

    public function store(Request $request)
    {
        $inputs = $request->all();
        

        $validator = Validator::make($inputs, [
            'recaptcha_action' => ['required', 'string'],
            'recaptcha_token'  => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $result = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('recapcha.secret_key_google'),
            'response' => $inputs['recaptcha_token'],
        ])->json();
        $active = config('config_all.recaptcha.active');
        if (!$active) {
            $result['test'] = true;
        }
        if ($result['test'] == true || (!empty($result) && $result['success']==true && $result['action'] === $inputs['recaptcha_action'])) {
            if ($result['test'] == true || (isset($result['score']) && $result['score'] >= 0.5)) {
                $newsletterRepo = $this->newsletterRepo;
                $requestAll = $request->all();
                $data = $requestAll[$requestAll["allpage_type"]] ?? null;
                $sl_option = array();
                foreach ($data as $column => $value) {
                    if (is_array($value)) {
                        foreach ($value as $k2 => $v2) {
                            $sl_option[$k2] = $v2;
                        }
                        $data[$column] = json_encode($sl_option);
                    } else {
                        $data[$column] = htmlspecialchars($value);
                    }
                }
                $data['ngaytao'] = time();
                // dd($data);
                // $result = DB::table('newsletter')->insert($data);

                if ($request->hasFile('file')) {
                    $oldimage = '';
                    $folder = Helper::GetFolder("file");
                    $newimage = $request->file('file');
                    $file = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
                    $data['taptin'] = $file;
                }

                if ($request->hasFile('file2')) {
                    $oldimage = '';
                    $folder = Helper::GetFolder("file");
                    $newimage = $request->file('file2');
                    $file = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
                    $data['taptin2'] = $file;
                }

                if ($newsletterRepo->SaveItem($data)) {
                    return redirect()->back()->with('success', __('Cảm ơn bạn, chúng tôi đã nhận được thông tin'));
                }
            } else {
                $validator->getMessageBag()->add('recaptcha', __('Xác minh recaptcha không thành công'));
                return redirect()->back()->with('errors', __('Xác minh recaptcha không thành công'))->withInput();
            }
        }
        $validator->errors()->add('recaptcha', __('Lỗi recaptcha'));
        return redirect()->back()->with('errors', __('Lỗi recaptcha'))->withInput();
    }

    public function Index(Request $request)
    {
        if (!Auth::guard('admin')->check() && config('config_all.lockpage')==true && $request->getPathInfo()!='/view') {
            return view('welcome');
        }
        //### xử lý dữ liệu : những dữ liệu chung cho tất cả các view blade
        // $lang = app('lang');
        if (session('locale')) {
            $lang = session('locale');
        } else {
            $lang= config('app.locale');
            Session::put('locale', $lang);
            Session::put('lang', $lang);
        }
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
        // $categoriesFirst = $model_category->GetAllItems('', ['type'=>'product','hienthi'=>1, 'level'=>0], null, false, false, 5);
        // $categoriesNoibat = $model_category->GetAllItems('', ['type'=>'product','noibat'=>1,'hienthi'=>1, 'level'=>0]);
        // foreach ($categories as $k => $v) {
        //     $cate1_items = $model_category->GetAllItems('',['type'=>'product','noibat'=>1,'hienthi'=>1, 'level'=>1,'level_1'=>$v["id"]]);
        //     $categories[$k]["cate1"] = $cate1_items;
        //     foreach ($categories[$k]["cate1"] as $key => $value) {
        //         $productByCategory = $model_product->GetAllItems('',['type'=>'product','noibat'=>1,'hienthi'=>1,'level_2'=>$value["id"]],$relations = null, $paginate=false, $showHienthi=false, $limit=6);
        //         $categories[$k]["cate1"][$key]["product"] = $productByCategory;
        //     }
        // }
        // dd($categories);
        // $khachhangs = $model_danhgia->GetAllItems('',['hienthi'=>1], ['HasProduct']);
        //dd($khachhangs);
        //$khachhangs = $model_post->GetAllItems('khachhangdanhgia',['hienthi'=>1]);
        // $about_us = $model_post->GetAllItems('aboutus', ['hienthi'=>1,'noibat'=>1]);
        // $howwork = $model_post->GetAllItems('howwork', ['hienthi'=>1]);
        // $info = $model_post->GetAllItems('info', ['hienthi'=>1]);
        // $service = $model_post->GetItem(['type'=>'service','hienthi'=>1,'noibat'=>1]);
        // $review = $model_post->GetAllItems('review', ['hienthi'=>1]);
        // $project = $model_post->GetAllItems('project', ['hienthi'=>1,'noibat'=>1]);
        // $tintuc = $model_post->GetAllItems('tintuc', ['hienthi'=>1,'noibat'=>1], null, false, false, 3);
        // $productsNew = $model_post->GetAllItems('dong-san-pham', ['hienthi'=>1]);
        // $brands = $model_brand->GetAllItems('product', ['hienthi'=>1], ['HasProduct']);
        // $slider_cretiria = $model_photo->GetAllItems('slide-cretiria', ['hienthi'=>1]);
        // $diachimuahang = $model_photo->GetAllItems('diachimuahang', ['hienthi'=>1]);
        // $coupon_noibat = $model_coupon->GetItem(['hienthi'=>1, 'noibat'=>1]);
        // $tag_search = $model_tag->GetAllItems('search', ['hienthi'=>1]);

        // $partner = $model_photo->GetAllItems('partner', ['hienthi'=>1]);
        //$mangxahoi_f = $model_photo->GetAllItems('mangxahoi_f', ['hienthi'=>1]);
        // $ketnoi = $model_photo->GetAllItems('ketnoi', ['hienthi'=>1]);

        $setting = app('setting');
        $logo = app('logo');

        $photo = ($logo['photo']!='')?Helper::GetConfigBase().UPLOAD_PHOTO.$logo['photo']:'';
        $img_json_bar = ($logo['photo']!='')?Helper::getImgSize($logo['photo'], UPLOAD_PHOTO.$logo['photo']):'';

        //### lấy ds câu hỏi
        // $question = $this->questionRepo->GetQuestions(['type'=>'product','duyettin'=>1,'hienthi'=>1], null, false, false, 2);

        // $count_question = $this->questionRepo->GetQuestions(['type'=>'product','duyettin'=>1,'hienthi'=>1], null, false, false, false);

        //đổ dữ liệu
        $response = array(
            "lang" => $lang,
            "template" => 'home',
            // "productsNew" => $productsNew,
            // "about_us" => $about_us,
            // "howwork" => $howwork,
            // "info" => $info,
            // "project" => $project,
            // "review" => $review,
            // "brands" => $brands,
            //"mangxahoi_f" => $mangxahoi_f,
            // "ketnoi" => $ketnoi,
            // "model_product" => $model_product,
            // "categoriesFirst" => $categoriesFirst,
            // "categoriesNoibat" => $categoriesNoibat,
            // "service" => $service,
            // "tintuc" => $tintuc,
            // "slider_cretiria" => $slider_cretiria,
            // "partner" => $partner,
            // "diachimuahang" => $diachimuahang,
            // "question" => $question,
            // "count_question" => $count_question,
            // "coupon_noibat" => $coupon_noibat,
            // "tag_search" => $tag_search
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
        if ($img_json_bar!='' && count($img_json_bar)>0) {
            OpenGraph::addImage($photo, ['height' => $img_json_bar['h'], 'width' => $img_json_bar['w'], 'type' => $img_json_bar['m'], 'alt' =>$setting['title'.$lang]]);
        } else {
            OpenGraph::addImage($photo, ['alt' =>$setting['title'.$lang]]);
        }

        TwitterCard::setTitle($setting['title'.$lang]);
        TwitterCard::setDescription($setting['description'.$lang]);
        TwitterCard::setImage($photo);

        
        return view('desktop.templates.home')->with($response);
    }
}
