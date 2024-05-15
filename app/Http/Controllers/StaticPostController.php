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

class StaticPostController extends Controller
{

    public function ShowStatic($response, Request $request)
    {
        //### gọi model
        $model = $this->staticRepo;//new StaticPost();
        $model_gallery = $this->galleryRepo;

        $lang = (isset($response->lang))?$response->lang:'vi';
        $type = (isset($response->type))?$response->type:'';
        $template = $response->template ?? 'static';
        $title_main = (isset($response->title))?$response->title:'';
        $slug = (isset($response->slug))?$response->slug:'';
        $model_question = 'static';
        
        //### xử lý
        $row_detail = $model->GetItem(['type'=>$type]);
        $title = $row_detail['title'.$lang] ?? ($row_detail['ten'.$lang] ?? '');
        $keywords = $row_detail['keywords'.$lang] ?? ($row_detail['ten'.$lang] ?? '');
        $description = $row_detail['description'.$lang] ?? ($row_detail['ten'.$lang] ?? '');
        $title_crumb = $row_detail['ten'.$lang] ?? $title_main;
        $photo = @$row_detail['photo'] ? Helper::GetConfigBase().UPLOAD_STATICPOST.$row_detail['photo'] : '';
        $img_json_bar = @$row_detail['photo'] ? Helper::getImgSize($row_detail['photo'], UPLOAD_STATICPOST.$row_detail['photo']) : '';
        $hinhanhsp = $model_gallery->GetAllGallery('kenh-phan-phoi', @$row_detail['id'], 'staticpost');
        /* breadCrumbs */
        if (isset($title_crumb) && $title_crumb != '') {
            Helper::setBreadCrumbs($slug, $title_main);
        }
        $breadcrumbs = Helper::getBreadCrumbs();

        //### lấy danh sách câu hỏi
        $question = $this->questionRepo->GetQuestions(['type'=>$type,'model'=>$model_question,'duyettin'=>1,'hienthi'=>1], null, true, false);

        //### trả dữ liệu -> blade view
        $response = array(
            "row_detail" => $row_detail,
            "title_crumb" => $title_crumb,
            "breadcrumbs" => $breadcrumbs,
            "question" => $question,
            "hinhanhsp" => $hinhanhsp,
            "type" => $type,
            "type_question" => $type,
            "model_question" => $model_question
        );

        if ($type=='hoc-vien-va-doanh-nghiep') {
            $response['hocVienReviewList'] = $this->photoRepo->GetAll('video', ['hienthi' => 1]);
        }

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

        //### view
        if ($type=='video') {
            $view = view('desktop.templates.static.video')->with($response);
        } elseif ($type=='chuyen-gia') {
            $view = view('desktop.templates.static.chuyengia')->with($response);
        } elseif ($type=='hoc-vien-va-doanh-nghiep') {
            $view = view('desktop.templates.static.hocviendoanhnghiep')->with($response);
        } else {
            $view = view('desktop.templates.static.static')->with($response);
        }

        return $view;
    }
}
