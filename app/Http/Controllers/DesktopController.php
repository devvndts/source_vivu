<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Traits\SupportTrait;

use View;
use Helper;
use DB;
use Thumb;
use Session;
use CartHelper;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session as FacadesSession;

class DesktopController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, SupportTrait;

    public $config_all;
    public $config_base;
    public $lang;
    public $setting;
    public $settingOption;
    public $logo;
    public $favicon;
    public $footer;
    public $slug;
    public $field;
    public $category;
    public $type;
    public $full_respons;
    public $token_member_cart;
    public $id_login = 0;
    public $user_info;
    public $requick;

    public $arr_level = array();

    private $arr_com_category = array();
    private $arr_com_product = array();
    private $arr_com_post = array();
    private $arr_com_album = array();
    private $arr_com_tags = array();
    private $arr_com_staticpost = array();
    private $arr_com_contact = array();
    private $arr_com_brand = array();
    private $arr_type = array();

    private $config_category;
    private $config_product;
    private $config_post;
    private $config_album;
    private $config_tags;
    private $config_staticpost;
    private $config_contact;

    /*
    |--------------------------------------------------------------------------
    | Kiểm tra lang đầu vào
    |--------------------------------------------------------------------------
    */
    public function SetLang(Request $request)
    {
        switch ($request->lang) {
            case 'en':
                $this->lang = $request->lang;
                break;
            default:
                $this->lang = 'vi';
                break;
        }
        App::setLocale($this->lang);
        Session::put('lang', $this->lang);
        return redirect()->route('home');
    }


    /*
    |--------------------------------------------------------------------------
    | Kiểm tra slug đầu vào để thao tác blade tương ứng
    |--------------------------------------------------------------------------
    */
    public function CallSlug(Request $request)
    {
        if (!Auth::guard('admin')->check() && config('config_all.lockpage')==true && $request->getPathInfo()=='/'.$request->slug) {
            return view('welcome');
        }
        //### lấy mảng level từ url
        if ($request->slug) {
            $this->arr_level['level_1'] = $request->slug;
        }
        if ($request->level1) {
            $this->arr_level['level_2'] = $request->level1;
        }
        if ($request->level2) {
            $this->arr_level['level_3'] = $request->level2;
        }
        //### lấy slug url
        $this->slug = (count($this->arr_level)>0) ? $this->arr_level['level_'.count($this->arr_level)] : $request->slug;
        //dd($this->slug);

        /* Tối ưu link */
        $this->requick = $this->ArraySlug();

        /* Find data */
        if ($this->IsSlug()) {
            $this->full_response['lang'] = $this->lang;
            $this->full_response['slug']=$this->slug;
            foreach ($this->requick as $k => $v) {
                $url_tbl = (isset($v['table']) && $v['table'] != '') ? $v['table'] : '';
                $url_type = (isset($v['type']) && $v['type'] != '') ? $v['type'] : '';
                $url_com = (isset($v['com']) && $v['com'] != '') ? $v['com'] : '';
                $url_tbl_tag = (isset($v['table_tag']) && $v['table_tag'] != '') ? $v['table_tag'] : '';
                $url_title = $v['title'];
                if ($url_tbl!='' && $url_tbl!='photo' && $url_tbl!='contact' && $url_tbl!='category') {
                    $row = DB::table($url_tbl)->select('id')
                    ->where('tenkhongdauvi', $this->slug)
                    ->where('type', $url_type)
                    ->where('hienthi', 1)
                    ->first();
                    if ($row) {
                        $this->slug = $url_com;
                        $this->full_response['field'] = $row->id;
                        $this->full_response['type'] = $url_type;
                        $this->full_response['slug'] = $this->slug;
                        $this->full_response['lang'] = $this->lang;
                        $this->full_response['table_tag'] = $url_tbl_tag;
                        $this->full_response['title'] = $url_title;
                        break;
                    }
                } elseif ($url_tbl=='category' && $this->arr_level['level_1']!='tags') {
                    $row = DB::table($url_tbl)->select()
                    ->where('tenkhongdauvi', $this->slug)
                    ->where('hienthi', 1)
                    ->first();
                    if ($row) {
                        $this->slug = $url_com;
                        $this->full_response['field'] = $row->id;
                        $this->full_response['type'] = $row->type;
                        $this->full_response['slug'] = $this->slug;
                        $this->full_response['lang'] = $this->lang;
                        $this->full_response['table_tag'] = $url_tbl_tag;
                        $this->full_response['title'] = $url_title;
                        if (count($this->arr_level)>1) {
                            $this->full_response['arr_level'] = $this->arr_level;
                        } else {
                            $this->full_response['arr_level']['level_'.($row->level+1)] = $row->tenkhongdauvi;
                        }
                        break;
                    }
                }
            }
        }

        //dd($this->arr_com_brand);

        //### check slug
        if (in_array($this->slug, $this->arr_com_category)) {
            $this->full_response['title'] = "";
            //$this->full_response['title'] = (isset($this->full_response['title'])) ? $this->full_response['title'] : $this->config_post[$this->full_response['type']]['title_main'];
            return \App::call('App\Http\Controllers\CategoryController@ShowItems', ['response' => (object)$this->full_response]);
        } elseif (in_array($this->slug, $this->arr_com_product)) {
            $this->full_response['type'] = $this->arr_type[$this->slug];
            $this->full_response['title'] = (isset($this->full_response['title'])) ? get_string_for_locale($this->full_response['title']) : get_string_for_locale($this->config_product[$this->full_response['type']]['title_main']);
            return \App::call('App\Http\Controllers\ProductController@ShowProducts', ['response' => (object)$this->full_response]);
        } elseif (in_array($this->slug, $this->arr_com_brand)) {
            $this->full_response['type'] = $this->arr_type[$this->slug];
            $this->full_response['title'] = (isset($this->full_response['title'])) ? get_string_for_locale($this->full_response['title']) : get_string_for_locale($this->config_product[$this->full_response['type']]['title_main']);
            return \App::call('App\Http\Controllers\BrandController@ShowProducts', ['response' => (object)$this->full_response]);
        } elseif (in_array($this->slug, $this->arr_com_tags)) {
            $this->full_response['type'] = $this->arr_type[$this->slug];
            $this->full_response['title'] = (isset($this->full_response['title'])) ? get_string_for_locale($this->full_response['title']) : get_string_for_locale($this->config_tags[$this->full_response['type']]['title_main']);
            return \App::call('App\Http\Controllers\TagController@ShowProducts', ['response' => (object)$this->full_response]);
        } elseif (in_array($this->slug, $this->arr_com_post)) {
            //$this->full_response['title'] = $this->arr_type[$this->title];
            $this->full_response['type'] = $this->arr_type[$this->slug];
            $this->full_response['title'] = (isset($this->full_response['title'])) ? get_string_for_locale($this->full_response['title']) : get_string_for_locale($this->config_post[$this->full_response['type']]['title_main']);
            return \App::call('App\Http\Controllers\PostController@ShowPosts', ['response' => (object)$this->full_response]);
        } elseif (in_array($this->slug, $this->arr_com_album)) {
            $this->full_response['type'] = $this->arr_type[$this->slug];
            $this->full_response['title'] = (isset($this->full_response['title'])) ? get_string_for_locale($this->full_response['title']) : get_string_for_locale($this->config_album[$this->full_response['type']]['title_main']);
            return \App::call('App\Http\Controllers\AlbumController@ShowAlbums', ['response' => (object)$this->full_response]);
        } elseif (in_array($this->slug, $this->arr_com_staticpost)) {
            $this->full_response['type'] = $this->arr_type[$this->slug];
            $this->full_response['title'] = (isset($this->full_response['title'])) ? get_string_for_locale($this->full_response['title']) : get_string_for_locale($this->config_staticpost[$this->full_response['type']]['title_main']);
            return \App::call('App\Http\Controllers\StaticPostController@ShowStatic', ['response' => (object)$this->full_response]);
        } elseif (in_array($this->slug, $this->arr_com_contact)) {
            $this->full_response['type'] = $this->arr_type[$this->slug];
            $this->full_response['title'] = (isset($this->full_response['title'])) ? get_string_for_locale($this->full_response['title']) : get_string_for_locale($this->config_contact[$this->full_response['type']]['title_main']);
            return \App::call('App\Http\Controllers\ContactController@ShowContact', ['response' => (object)$this->full_response]);
        } else {
            if ($this->slug == 'gio-hang') {
                $this->full_response['title'] = __('Giỏ hàng');
                $this->full_response['type'] = 'giohang';
                return \App::call('App\Http\Controllers\CartController@ShowCart', ['response' => (object)$this->full_response]);
            } elseif ($this->slug == 'tim-kiem') {
                $this->full_response['title'] = __('Tìm kiếm');
                $this->full_response['type'] = 'chuong-trinh-dao-tao';
                return \App::call('App\Http\Controllers\SearchController@Search', ['response' => (object)$this->full_response]);
            } elseif ($this->slug == 'he-thong') {
                $this->full_response['title'] = __('Hệ thống đại lý');
                $this->full_response['type'] = 'he-thong';
                return \App::call('App\Http\Controllers\PostController@ShowPosts', ['response' => (object)$this->full_response]);
            } elseif ($this->slug == 'video') {
                $this->full_response['title'] = __('Video');
                $this->full_response['type'] = 'video';
                return \App::call('App\Http\Controllers\StaticPostController@ShowStatic', ['response' => (object)$this->full_response]);
            } elseif ($this->slug == 'cau-hoi') {
                $this->full_response['title'] = "Câu hỏi";
                $this->full_response['type'] = 'cauhoi';
                return \App::call('App\Http\Controllers\QuestionController@ShowQuestion', ['response' => (object)$this->full_response]);
            } elseif ($this->slug == 'doi-tac') {
                $this->full_response['title'] = "Đối tác";
                $this->full_response['type'] = 'doitac';
                return \App::call('App\Http\Controllers\DoitacController@ShowDoitac', ['response' => (object)$this->full_response]);
            } elseif ($this->slug == 'khuyen-mai') {
                $this->full_response['title'] = "Khuyến mãi";
                $this->full_response['type'] = 'product';
                return \App::call('App\Http\Controllers\ProductController@ShowProducts', ['response' => (object)$this->full_response]);
            } elseif ($this->slug == 'doi-tac-phan-phoi') {
                $this->full_response['title'] = "Đối tác phân phối";
                $this->full_response['type'] = 'text-partner';
                return \App::call('App\Http\Controllers\StaticPostController@ShowStatic', ['response' => (object)$this->full_response]);
            } elseif ($this->slug == 'chuyen-gia') {
                $this->full_response['title'] = "Chuyên gia";
                $this->full_response['type'] = 'chuyen-gia';
                return \App::call('App\Http\Controllers\StaticPostController@ShowStatic', ['response' => (object)$this->full_response]);
            } elseif ($this->slug == 'hoc-vien-va-doanh-nghiep') {
                $this->full_response['title'] = "Học viên - Doanh nghiệp";
                $this->full_response['type'] = 'hoc-vien-va-doanh-nghiep';
                return \App::call('App\Http\Controllers\StaticPostController@ShowStatic', ['response' => (object)$this->full_response]);
            } else {
                return redirect()->route('error.show', ['404']);
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | mảng table truy vấn slug
    |--------------------------------------------------------------------------
    */
    private function ArraySlug()
    {
        $arr_config = array();

        $this->config_category = config('category');
        $this->config_product = config('config_type.product');
        $this->config_post = config('config_type.post');
        $this->config_album = config('config_type.album');
        $this->config_tags = config('config_type.tags');
        $this->config_staticpost = config('config_type.staticpost');
        $this->config_contact = config('config_type.contact');


        //run config category
        if ($this->config_category) {
            foreach ($this->config_category as $k => $v) {
                if (isset($v['menu'])) {
                    $arr_tmp = array(
                        'title' => $v['title_main'],
                        'table' => 'category',
                        'com' => 'category',
                        'type' => $k,
                        'menu' => $v['menu'],
                        'sitemap' => (isset($v['sitemap'])) ? $v['sitemap'] : false,
                        'model' => 'category',
                        'relation' => $v['relation']
                    );
                    array_push($arr_config, $arr_tmp);
                    array_push($this->arr_com_category, 'category');
                }
            }
        }


        //run config product
        if ($this->config_product) {
            if (array_key_exists('shownews', $this->config_product)) {
                unset($this->config_product['shownews']);
            }
            foreach ($this->config_product as $k => $v) {
                if (isset($v['menu'])) {
                    $arr_tmp = array(
                        'title' => $v['title_main'],
                        'table' => 'product',
                        'com' => $v['com'],
                        'type' => $k,
                        'menu' => $v['menu'],
                        'sitemap' => (isset($v['sitemap'])) ? $v['sitemap'] : false,
                        'model' => 'product'
                    );
                    $this->arr_type[$v['com']] = $k;
                    array_push($arr_config, $arr_tmp);
                    array_push($this->arr_com_product, $v['com']);
                }

                if (isset($v['brand']) && isset($v['sitemap_brand'])) {
                    $arr_tmp = array(
                        'title' => $v['title_main'],
                        'table' => 'brand',
                        'com' => $v['com-brand'],
                        'type' => $k,
                        'menu' => $v['menu'],
                        'sitemap' => (isset($v['sitemap_brand'])) ? $v['sitemap_brand'] : false,
                        'model' => 'brand'
                    );
                    $this->arr_type[$v['com-brand']] = $k;
                    array_push($arr_config, $arr_tmp);
                    array_push($this->arr_com_brand, $v['com-brand']);
                }
            }
        }


        //run config product
        if ($this->config_post) {
            if (array_key_exists('shownews', $this->config_post)) {
                unset($this->config_post['shownews']);
            }

            foreach ($this->config_post as $k => $v) {
                if (isset($v['menu'])) {
                    $arr_tmp = array(
                        'title' => $v['title_main'],
                        'table' => 'post',
                        'com' => $v['com'],
                        'type' => $k,
                        'menu' => $v['menu'],
                        'sitemap' => (isset($v['sitemap'])) ? $v['sitemap'] : false,
                        'model' => 'post'
                    );

                    $this->arr_type[$v['com']] = $k;

                    array_push($arr_config, $arr_tmp);
                    array_push($this->arr_com_post, $v['com']);
                }
            }
        }


        //run config album
        if ($this->config_album) {
            if (array_key_exists('shownews', $this->config_album)) {
                unset($this->config_album['shownews']);
            }
            foreach ($this->config_album as $k => $v) {
                if (isset($v['menu'])) {
                    $arr_tmp = array(
                        'title' => $v['title_main'],
                        'table' => 'album',
                        'com' => $v['com'],
                        'type' => $k,
                        'menu' => $v['menu'],
                        'sitemap' => (isset($v['sitemap'])) ? $v['sitemap'] : false,
                        'model' => 'album'
                    );
                    $this->arr_type[$v['com']] = $k;
                    array_push($arr_config, $arr_tmp);
                    array_push($this->arr_com_album, $v['com']);
                }
            }
        }


        //run config tags
        if ($this->config_tags) {
            if (array_key_exists('shownews', $this->config_tags)) {
                unset($this->config_tags['shownews']);
            }
            foreach ($this->config_tags as $k => $v) {
                if (isset($v['menu'])) {
                    $arr_tmp = array(
                        'title' => $v['title_main'],
                        'table' => 'tags',
                        'com' => $v['com'],
                        'type' => $k,
                        'menu' => $v['menu'],
                        'sitemap' => (isset($v['sitemap'])) ? $v['sitemap'] : false,
                        'model' => 'tags',
                        'table_tag' => $v['table_tag']
                    );
                    $this->arr_type[$v['com']] = $k;
                    array_push($arr_config, $arr_tmp);
                    array_push($this->arr_com_tags, $v['com']);
                }
            }
        }


        //run config staticpost
        if ($this->config_staticpost) {
            foreach ($this->config_staticpost as $k => $v) {
                if (@$v['com']!='' && isset($v['menu'])) {
                    $arr_tmp = array(
                        'title' => $v['title_main'],
                        'table' => 'static',
                        'com' => $v['com'],
                        'type' => $k,
                        'menu' => $v['menu'],
                        'sitemap' => (isset($v['sitemap'])) ? $v['sitemap'] : false,
                        'model' => 'staticpost'
                    );
                    $this->arr_type[$v['com']] = $k;
                    array_push($arr_config, $arr_tmp);
                    array_push($this->arr_com_staticpost, $v['com']);
                }
            }
        }


        //run config contact
        if ($this->config_contact) {
            foreach ($this->config_contact as $k => $v) {
                if ($v['com']!='' && isset($v['menu'])) {
                    $arr_tmp = array(
                        'title' => $v['title_main'],
                        'table' => 'contact',
                        'com' => $v['com'],
                        'type' => $k,
                        'menu' => $v['menu'],
                        'sitemap' => (isset($v['sitemap'])) ? $v['sitemap'] : false,
                        'model' => 'contact'
                    );
                    $this->arr_type[$v['com']] = $k;
                    array_push($arr_config, $arr_tmp);
                    array_push($this->arr_com_contact, $v['com']);
                }
            }
        }
        
        return $arr_config;
    }



    /*
    |--------------------------------------------------------------------------
    | Không phải slug trong danh sách
    |--------------------------------------------------------------------------
    */
    private function IsSlug()
    {
        $arr_notslug = array('', 'tim-kiem', 'account', 'sitemap', 'sitemap.xml');
        if (!in_array($this->slug, $arr_notslug)) {
            return true;
        }
        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Tạo sitemap
    |--------------------------------------------------------------------------
    */
    public function SiteMapIndex(Request $request)
    {
        //### Khai báo
        $page = ($request->page) ? $request->page : null;
        $requick = $this->ArraySlug();

        //### Response
        if (!$page) {
            $arr_page = Helper::GetArraySitemap($requick, true);
            
            return response()->view('sitemap.index', [
                'time' => time(),
                'site' => $arr_page,
                'site_category' => $arr_page['category'],
            ])->header('Content-Type', 'text/xml');
        } elseif ($page!='') { //sitemap index

            $arr_page = Helper::GetArraySitemap($requick, false);

            //check
            if (!array_key_exists($page, $arr_page)) {
                return redirect()->route('error.show', ['404']);
            }

            //get data
            $arr_detail_sitemap = $arr_page[$page];

            $arr_detail_sitemap = Helper::CreateSitemapPage($arr_detail_sitemap, $page);
            //response
            return response()->view('sitemap.detail', [
                'time' => time(),
                'site' => $arr_detail_sitemap
            ])->header('Content-Type', 'text/xml');
        } else {
            return redirect()->route('error.show', ['404']);
        }
    }
}
