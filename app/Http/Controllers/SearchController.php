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

class SearchController extends Controller
{
    public function Search($response, Request $request)
    {
        //### lấy dữ liệu
        $model = $this->productRepo;//new Product('man');
        $model_seo = $this->seopageRepo;//new SeoPage();
        
        $lang = (isset($response->lang))?$response->lang:'vi';
        $field = (isset($response->field))?$response->field:'';
        $slug = (isset($response->slug))?$response->slug:'';
        $type = (isset($response->type))?$response->type:'';
        $category = (isset($response->category))?$response->category:'';
        $title_main = (isset($response->title))?$response->title:'';

        $keyword = $request->keyword;
        $params = array(
            'keyword'=> $keyword,
            'hienthi'=> 1,
            // 'toSql'=> 1,
        );
        $products = $model->GetAllItems($type, $params, null, true);
        // $model_post = $this->postRepo;//new Post();
        // $posts = $model->GetAllItems($type, $params, null, true);
        $row_seo = $model_seo->GetItem(['type'=>$type]);
        $title = (@$row_seo['title'.$lang]!='') ? $row_seo['title'.$lang] : @$row_seo['ten'.$lang];
        $keywords = (@$row_seo['keywords'.$lang]!='') ? $row_seo['keywords'.$lang] : @$row_seo['ten'.$lang];
        $description = (@$row_seo['description'.$lang]!='') ? $row_seo['description'.$lang] : @$row_seo['ten'.$lang];
        $title_crumb = $title_main;
        $photo = (@$row_seo['photo']!='')? Helper::GetConfigBase().UPLOAD_SEOPAGE.$row_seo['photo']:'';
        $img_json_bar = (@$row_seo['photo']!='')?Helper::getImgSize($row_seo['photo'], UPLOAD_SEOPAGE.$row_seo['photo']):'';

        /* breadCrumbs */
        if (isset($title_crumb) && $title_crumb != '') {
            Helper::setBreadCrumbs($slug, $title_main);
        }
        $breadcrumbs = Helper::getBreadCrumbs();

        //### trả dữ liệu -> blade view
        $response = array(
            "type" => $type,
            "products" => $products,
            "title" => $title,
            "keyword" => $keyword,
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

        return view('desktop.templates.product.products')->with($response);
    }
}
