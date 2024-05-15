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
use TableManipulation;

class PostController extends Controller
{
    public function ShowPosts($response, Request $request)
    {
        //### gọi model
        $model = $this->postRepo;//new Post('man');

        $lang = (isset($response->lang))?$response->lang:'vi';
        $field = (isset($response->field))?$response->field:'';
        $slug = (isset($response->slug))?$response->slug:'';
        $type = (isset($response->type))?$response->type:'';
        $category = (isset($response->category))?$response->category:'';
        $title_main = (isset($response->title))?$response->title:'';
        $model_question = 'post';

        //### xử lý
        if ($field!='') {
            //### lấy dữ liệu
            $model_gallery = $this->galleryRepo;//new Gallery();
            $row_detail = $model->GetOneItem($field);
            //### lấy ds ids category
            if ($row_detail['id_category']!=0) {
                $id_cate  = $row_detail['id_category'];
                $arr_childCategory = $arr_parentCategory = array();
                $row_detail_cate = $this->categoryRepo->GetOneItem($id_cate, null);

                //lấy ds category con
                array_push($arr_childCategory, (int)$id_cate);
                $arr_childCategory = array_merge($arr_childCategory, $this->categoryRepo->GetChildCategory($type, $id_cate));
                $params['id_category'] = $arr_childCategory;

                //lấy ds category cha
                array_push($arr_parentCategory, $row_detail_cate['id_parent']);
                $arr_parentCategory = array_merge($arr_parentCategory, $this->categoryRepo->GetParentCategory($type, $row_detail_cate['id_parent']));
                $arr_parentCategory = array_reverse($arr_parentCategory);
            }


            //### lấy ds bài viết theo ids_level
            if (TableManipulation::CheckFieldToTable('post', 'ids_level_1') && $row_detail['ids_level_1']!='') {
                $id_cate  = $row_detail['ids_level_1'];
                $params['ids_level_1'] = explode(',', $id_cate);
            }

            if ($type!='chinhsach') {
                $params['id'] = $field;
            }
            $params['hienthi'] = 1;
            //dd($params);

            $posts = $model->GetAllItemsExceptId($type, $params, null, true, true);
            $hinhanhsp = $model_gallery->GetAllItems($type, ['id_photo'=>$row_detail['id'], 'kind'=>'man', 'val'=>$type, 'com'=>'post']);
            //dd($posts);

            $title = ($row_detail['title'.$lang]!='') ? $row_detail['title'.$lang] : $row_detail['ten'.$lang];
            $keywords = ($row_detail['keywords'.$lang]!='') ? $row_detail['keywords'.$lang] : $row_detail['ten'.$lang];
            $description = ($row_detail['description'.$lang]!='') ? $row_detail['description'.$lang] : $row_detail['ten'.$lang];
            $title_crumb = ($row_detail['ten'.$lang]) ? $row_detail['ten'.$lang] : $title_main;
            $photo = ($row_detail['photo']!='')?Helper::GetConfigBase().UPLOAD_POST.$row_detail['photo']:'';
            $img_json_bar = ($row_detail['photo']!='')?Helper::getImgSize($row_detail['photo'], UPLOAD_POST.$row_detail['photo']):'';
            $published_time = date('c', $row_detail['ngaytao']);
            $modified_time = date('c', $row_detail['ngaysua']);

            //### Thiết lập breadcum
            $arr_parentCategory = array();
            array_push($arr_parentCategory, $row_detail['id_category']);
            $arr_parentCategory = array_merge($arr_parentCategory, $this->categoryRepo->GetParentCategory($type, $row_detail['id_category']));
            $arr_parentCategory = array_reverse($arr_parentCategory);

            if (isset($title_crumb) && $title_crumb != '') {
                Helper::setBreadCrumbs($slug, $title_main);
            }
            if ($arr_parentCategory) {
                foreach ($arr_parentCategory as $k=>$v) {
                    $row_breadcum = $this->categoryRepo->GetOneItem($v);
                    if ($row_breadcum) {
                        Helper::setBreadCrumbs($row_breadcum['tenkhongdauvi'], $row_breadcum['ten'.$lang]);
                    }
                }
            }
            Helper::setBreadCrumbs($row_detail['tenkhongdauvi'], $row_detail['ten'.$lang]);
            $breadcrumbs = Helper::getBreadCrumbs();

            //### lấy danh sách câu hỏi
            $question = $this->questionRepo->GetQuestions(['type'=>$type,'model'=>$model_question,'id_item'=>$row_detail['id'],'duyettin'=>1,'hienthi'=>1], null, true, false);

            $background_category = '';
            $row_detail_parent = $this->categoryRepo->GetOneItem($row_detail['ids_level_1']);
            $background_category = $row_detail_parent ? $row_detail_parent['photo'] : '';
            //### trả dữ liệu -> blade view
            $response = array(
                "background_category" => $background_category,
                "row_detail" => $row_detail,
                "posts" => $posts,
                "hinhanhsp" => $hinhanhsp,
                "title" => $title,
                "keywords" => $keywords,
                "description" => $description,
                "title_crumb" => $title_crumb,
                "breadcrumbs" => $breadcrumbs,
                "question" => $question,
                "type_question" => $type,
                "type" => $type,
                "model_question" => $model_question,
                "id_item" => $row_detail['id']
            );

            //### view
            // if($type=='chinhsach'){
            //     $chinhsach = $model->GetAllItems('chinhsach',$params,null,true,true);
            //     $response['chinhsach'] = $chinhsach;
            //     $response['e_active'] = 'chinhsach';

            //     $view = view('desktop.templates.post.chinhsach_detail')->with($response);
            // }else
            if ($type=='video') {
                $view = view('desktop.templates.post.video_detail')->with($response);
            } elseif ($type=='he-thong') {
                $view = view('desktop.templates.post.showroom')->with($response);
            } else {
                $view = view('desktop.templates.post.post_detail')->with($response);
            }
        } else {
            //### lấy dữ liệu
            $model_seo = $this->seopageRepo;//new SeoPage();
            //["toSql"=>true]
            $posts = $model->GetAllItems($type, null, null, true, true);
            if ($type=='chinhsach') {
                return redirect()->route('slug', [$posts[0]['tenkhongdauvi']]);
            }

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

            ## Mã bảo hành START
            $rowBaoHanh = null;
            if (isset($request->ma) && $request->ma) {
                $maBaoHanh = $request->ma;
                $paramsBaoHanh['tenvi'] = $maBaoHanh;
                $rowBaoHanh = $model->GetItem($paramsBaoHanh);
            }
            ## Mã bảo hành END


            //### danh mục
            $danhmucparent = $this->categoryRepo->GetAllItems($type);
            
            //### trả dữ liệu -> blade view
            $response = array(
                "rowBaoHanh" => $rowBaoHanh,
                "type" => $type,
                "posts" => $posts,
                "title" => $title,
                "keywords" => $keywords,
                "description" => $description,
                "title_crumb" => $title_crumb,
                "breadcrumbs" => $breadcrumbs,
                "danhmucparent" => ($danhmucparent) ? $danhmucparent : null
            );
            //### view
            if ($type=='khachhangdanhgia') {
                $view = view('desktop.templates.post.feedbacks')->with($response);
            } elseif ($type=='video') {
                $view = view('desktop.templates.post.video')->with($response);
            } elseif ($type=='he-thong') {
                $view = view('desktop.templates.post.showroom')->with($response);
            } else {
                $view = view('desktop.templates.post.posts')->with($response);
            }
        }

        /*### SEO TOOL */
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setTitle($title);
        SEOMeta::setKeywords($keywords);
        SEOMeta::setDescription($description);

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($request->url());
        if ($field) {
            OpenGraph::addProperty('type', 'article');
            SEOMeta::addMeta('article:published_time', $published_time, 'property');
            SEOMeta::addMeta('article:modified_time', $modified_time, 'property');
        } else {
            OpenGraph::addProperty('type', 'object');
        }
        if ($img_json_bar!='' && count($img_json_bar)>0) {
            OpenGraph::addImage($photo, ['height' => $img_json_bar['h'], 'width' => $img_json_bar['w'], 'type' => $img_json_bar['m'], 'alt' =>$title]);
        } else {
            OpenGraph::addImage($photo, ['alt' =>$title]);
        }

        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setImage($photo);

        return $view;
    }
}
