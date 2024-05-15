<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

use App\Repositories\Repo\AlbumRepository;

use App\Repositories\Repo\BrandRepository;

use App\Repositories\Repo\ColorRepository;

use App\Repositories\Repo\GalleryRepository;

use App\Repositories\Repo\PhotoRepository;

use App\Repositories\Repo\PostRepository;

use App\Repositories\Repo\ProductOptionRepository;

use App\Repositories\Repo\ProductRepository;

use App\Repositories\Repo\SizeRepository;

use App\Repositories\Repo\StaticPostRepository;

use App\Repositories\Repo\TagRepository;

use App\Repositories\Repo\NewsletterRepository;

use App\Repositories\Repo\ContactRepository;

//use App\Models\Product\Product;

//use App\Models\Post\Post;

//use App\Models\Photo;

//use App\Models\StaticPost;

//use App\Models\Color;

//use App\Models\Size;

//use App\Models\Brand;

//use App\Models\Tags;

//use App\Models\ProductOption;

//use App\Models\Album\Album;

use App\Models\Member;

use App\Models\Places;

//use App\Models\Newsletter;

//use App\Models\Contact;

use App\Models\Order;

use App\Models\Cart;

use Spatie\Permission\Models\Role;

use DB;
use Helper;
use Carbon\Carbon;

class CartHelper
{
    private static $albumRepo;
    private static $brandRepo;
    private static $colorRepo;
    private static $galleryRepo;
    private static $photoRepo;
    private static $postRepo;
    private static $productOptRepo;
    private static $productRepo;
    private static $sizeRepo;
    private static $staticRepo;
    private static $tagRepo;
    private static $newsletterRepo;
    private static $contactRepo;

    private static $category;

    private static $relations = [];

    private static function initialized($model, $category)
    {

        //### set repo

        switch ($model) {
            case 'album':
                self::$albumRepo = new AlbumRepository();

                //self::$albumRepo->setModel($category);

                break;

            case 'brand':
                self::$brandRepo = new BrandRepository();

                //self::$brandRepo->setModel($category);

                break;

            case 'color':
                self::$colorRepo = new ColorRepository();

                //self::$colorRepo->setModel($category);

                break;

            case 'size':
                self::$sizeRepo = new SizeRepository();

                //self::$sizeRepo->setModel($category);

                break;

            case 'gallery':
                self::$galleryRepo = new GalleryRepository();

                //self::$galleryRepo->setModel($category);

                break;

            case 'photo':
                self::$photoRepo = new PhotoRepository();

                //self::$photoRepo->setModel($category);

                break;

            case 'post':
                self::$postRepo = new PostRepository();

                //self::$postRepo->setModel($category);

                break;

            case 'productoption':
                self::$productOptRepo = new ProductOptionRepository();

                //self::$productOptRepo->setModel($category);

                break;

            case 'product':
                self::$productRepo = new ProductRepository();

                //self::$productRepo->setModel($category);

                break;

            case 'static':
                self::$staticRepo = new StaticPostRepository();

                //self::$staticRepo->setModel($category);

                break;

            case 'tags':
                self::$tagRepo = new TagRepository();

                //self::$tagRepo->setModel($category);

                break;

            case 'newsletter':
                self::$newsletterRepo = new NewsletterRepository();

                //self::$newsletterRepo->setModel($category);

                break;

            case 'contact':
                self::$contactRepo = new ContactRepository();

                //self::$contactRepo->setModel($category);

                break;

        }
    }

    /*

    |--------------------------------------------------------------------------

    | Đặt hàng

    |--------------------------------------------------------------------------

    */

    public static function addtocart($q = 1, $pid = 0, $mau = 0, $size = 0, $id_user = 0, $token_member_cart = '')
    {

        //### khai báo model

        $mode_cart = new Cart();

        //### xử lý

        if ($pid<1 or $q<1) {
            return;
        }

        $code = md5($pid.$mau.$size);

        if ($id_user>0) {
            $mode_cart = $mode_cart->where('id_user', $id_user);
        } else {
            $mode_cart = $mode_cart->where('id_user', 0)->where('token_member_cart', $token_member_cart);
        }

        $row_exist = $mode_cart->where('code', $code)->first();

        //### kiểm tra

        if ($row_exist) {
            $row_exist->toArray();

            $cartAdd['soluong'] = $row_exist['soluong']+$q;

            $mode_cart = new Cart();

            $mode_cart->SaveItem($cartAdd, $row_exist['id']);
        } else {
            $cartAdd['soluong'] = $q;

            $cartAdd['id_product'] = $pid;

            $cartAdd['mau'] = $mau;

            $cartAdd['size'] = $size;

            $cartAdd['code'] = $code;

            $cartAdd['token_member_cart'] = $token_member_cart;

            $cartAdd['id_user'] = $id_user;

            $mode_cart = new Cart();

            $mode_cart->SaveItem($cartAdd);
        }

        return $row_exist;
    }

    /*

    |--------------------------------------------------------------------------

    | Đặt hàng

    |--------------------------------------------------------------------------

    */

    public static function removeOldcart($oldcode, $id_user = 0, $token_member_cart = '')
    {

        //### khai báo model

        $mode_cart = new Cart();

        //### xử lý

        if ($id_user > 0) {
            $mode_cart = $mode_cart->where('id_user', $id_user);
        } else {
            $mode_cart = $mode_cart->where('id_user', 0)->where('token_member_cart', $token_member_cart);
        }

        $row_exist = $mode_cart->where('code', $oldcode)->first();

        //### kiểm tra

        if ($row_exist) {
            $row_exist->toArray();

            $mode_cart = new Cart();

            $mode_cart->DeleteOneItem($row_exist['id']);
        }
    }

    /*

    |--------------------------------------------------------------------------

    | sản phẩm thuộc đơn hàng đã chọn

    |--------------------------------------------------------------------------

    */

    public static function count_cart($id_user = 0, $token_member_cart = '')
    {

        //### khai báo model

        $model_cart = new Cart();

        //### xử lý

        $row_count_soluong = 0;

        if ($id_user>0) {
            $model_cart = $model_cart->where('id_user', $id_user);
        } else {
            $model_cart = $model_cart->where('id_user', 0)->where('token_member_cart', $token_member_cart);
        }

        if ($model_cart->first()) {
            $row_count_soluong = $model_cart->sum('soluong');
        }

        return $row_count_soluong;
    }

    /*

    |--------------------------------------------------------------------------

    | Lấy

    |--------------------------------------------------------------------------

    */

    public static function Get_info_cart($id_user = 0, $token_member_cart = '')
    {

        //### khai báo model

        Helper::SetCookieLogin('login_member_id', Auth::guard()->check());

        $id_user = Helper::GetCookie('login_member_id');

        $token_member_cart = Helper::GetCookie('member_cart');

        if ($id_user>0) {
            $model_cart = new Cart();

            $model_cart->UpdateItemByParam(['token_member_cart'=>$token_member_cart], ['id_user'=>$id_user]);
        }

        //### xử lý

        $model_cart = new Cart();

        $row_count_soluong = 0;

        if ($id_user>0) {
            $model_cart = $model_cart->where('id_user', $id_user);
        } else {
            $model_cart = $model_cart->where('id_user', 0)->where('token_member_cart', $token_member_cart);
        }

        if ($model_cart) {
            return $model_cart->get()->toArray();
        }

        return null;
    }

    /*

    |--------------------------------------------------------------------------

    | số lượng sp đặt mua

    |--------------------------------------------------------------------------

    */

    public static function Get_all_cart($id_user = 0, $token_member_cart = '')
    {

        //### khai báo model

        Helper::SetCookieLogin('login_member_id', Auth::guard()->check());

        $id_user = Helper::GetCookie('login_member_id');

        $token_member_cart = Helper::GetCookie('member_cart');

        if ($id_user>0) {
            $model_cart = new Cart();

            $model_cart->UpdateItemByParam(['token_member_cart'=>$token_member_cart], ['id_user'=>$id_user]);
        }

        //### xử lý

        $model_cart = new Cart();

        $row_count_soluong = 0;

        if ($id_user>0) {
            $model_cart = $model_cart->where('id_user', $id_user);
        } else {
            $model_cart = $model_cart->where('id_user', 0)->where('token_member_cart', $token_member_cart);
        }

        if ($model_cart->first()) {
            $row_count_soluong = $model_cart->sum('soluong');
        }

        return $row_count_soluong;
    }

    /*

    |--------------------------------------------------------------------------

    | lấy tham số cho việc đẩy vận chuyển

    |--------------------------------------------------------------------------

    */

    public static function GetInfoShip()
    {
        $result = array();

        $weight = 0;

        $carts = self::Get_info_cart();

        if ($carts) {
            foreach ($carts as $k => $v) {
                $product = self::get_product_info($v['id_product'], $v['size'], $v['mau']);

                if ($product) {
                    $weight += $product['khoiluong'];
                }
            }
        }

        $result['khoiluong'] = $weight;

        return $result;
    }

    /*

    |--------------------------------------------------------------------------

    | lấy thông tin sản phẩm

    |--------------------------------------------------------------------------

    */

    public static function get_product_info_order($table, $id)
    {
        if ($table=='product_option') {
            self::initialized('productoption', 'man');

            $model_productOption = self::$productOptRepo;

            return $model_productOption->GetOneItem($id);
        } else {
            self::initialized('product', 'man');

            $model_product = self::$productRepo;

            return $model_product->GetOneItem($id);
        }
    }

    /*

    |--------------------------------------------------------------------------

    | tính phí bảo hiểm

    |--------------------------------------------------------------------------

    */

    public static function get_insurance_price($id_user = 0, $token_member_cart = '')
    {
        return (self::get_order_total($id_user, $token_member_cart)/100);
    }

    /*

    |--------------------------------------------------------------------------

    | Tổng giá thành tiền đơn hàng

    |--------------------------------------------------------------------------

    */

    public static function get_order_total($id_user = 0, $token_member_cart = '')
    {
        $sale = get_sales('sale', 'vi')->toArray();
        //### khai báo model
        Helper::SetCookieLogin('login_member_id', Auth::guard()->check());
        $id_user = Helper::GetCookie('login_member_id');
        $token_member_cart = Helper::GetCookie('member_cart');
        $mode_cart = new Cart();

        //### xử lý
        $sum = 0;
        if ($id_user>0) {
            $mode_cart = $mode_cart->where('id_user', $id_user);
        } else {
            $mode_cart = $mode_cart->where('id_user', 0)->where('token_member_cart', $token_member_cart);
        }

        $row_exist = $mode_cart->get();
        if ($row_exist) {
            $row_exist->toArray();
            for ($i = 0; $i < count($row_exist); $i++) {
                $pid = $row_exist[$i]['id_product'];
                $q = $row_exist[$i]['soluong'];
                $size=$row_exist[$i]['size'];
                $mau=$row_exist[$i]['mau'];
                $proinfo = self::get_product_info($pid, $size, $mau);

                $ajaxGiamoi = $proinfo['giamoi'];
                $ajaxGia = $proinfo['gia'];
        
                if (isset($sale[0]) && $sale[0]->hienthi && $sale[0]->sale_date > Carbon::now()) {
                    $ajaxGiamoi = $proinfo['sale_giamoi'];
                    // $ajaxGia = $proinfo['sale_gia'];
                }

                if ($ajaxGiamoi) {
                    $price = $ajaxGiamoi;
                } else {
                    $price = $ajaxGia;
                }
                $sum += ($price * $q);
            }
        }

        return $sum;
    }

    /*

    |--------------------------------------------------------------------------

    | Xóa sp từ đơn hàng

    |--------------------------------------------------------------------------

    */

    public static function remove_product($code = '', $id_user = 0, $token_member_cart = '')
    {

        //### khai báo model

        $mode_cart = new Cart();

        //### xử lý

        if ($id_user>0) {
            $mode_cart = $mode_cart->where('id_user', $id_user);
        } else {
            $mode_cart = $mode_cart->where('id_user', 0)->where('token_member_cart', $token_member_cart);
        }

        $row_exist = $mode_cart->where('code', $code)->get();

        if ($row_exist) {
            $row_exist->toArray();

            foreach ($row_exist as $key => $value) {
                $mode_cart = new Cart();

                $mode_cart->DeleteOneItem($value['id']);
            }
        }
    }

    /*

    |--------------------------------------------------------------------------

    | Get product info

    |--------------------------------------------------------------------------

    */

    public static function get_product_info($pid = 0, $size = 0, $mau = 0)
    {
        self::initialized('product', 'man');

        self::initialized('productoption', 'man');

        $model_product = self::$productRepo;

        $model_productOption = self::$productOptRepo;

        //$model_product = new Product('man');

        //$model_productOption = new ProductOption();

        if ($pid) {
            $row = $model_product->GetOneItem($pid, self::$relations);

            $row1 = $model_productOption->GetItem(['type'=>@$row['type'],'id_product'=>$pid,'id_size'=>$size,'id_mau'=>$mau]);

            $row['table'] = 'product';

            $row['id_option'] = 0;

            if ($row1 && $row1['phienbanmau'] == 0) {
                if ($row1['id']>0) {
                    $row['id_option']=$row1['id'];
                }

                /*if($row1['idNhanh']>0){

                    $row['idNhanh']=$row1['idNhanh'];

                }*/

                if ($row1['tenvi']!='') {
                    $row['tenvi']=$row1['tenvi'];
                }

                if ($row1['gia']>0) {
                    $row['gia']=$row1['gia'];
                }

                if ($row1['giacu']>0) {
                    $row['giacu']=$row1['giacu'];
                }

                if ($row1['giamoi']>0) {
                    $row['giamoi']=$row1['giamoi'];
                }

                if ($row1['giakm']>0) {
                    $row['giakm']=$row1['giakm'];
                }

                if ($row1['sale_giamoi']>0) {
                    $row['sale_giamoi']=$row1['sale_giamoi'];
                }

                if ($row1['sale_giakm']>0) {
                    $row['sale_giakm']=$row1['sale_giakm'];
                }

                if ($row1['photo']!='') {
                    $row['photo']=$row1['photo'];
                }

                if ($row1['masp']!='') {
                    $row['masp']=$row1['masp'];
                }

                if ($row1['khoiluong']>0) {
                    $row['khoiluong']=$row1['khoiluong'];
                }

                $row['soluong']=$row1['soluong'];
                $row['soluong_website']=$row1['soluong_website'];
                $row['soluong_lazada']=$row1['soluong_lazada'];
                $row['soluong_shopee']=$row1['soluong_shopee'];

                /*if($row1['json_imei']!=null){

                    $row['json_imei']=$row1['json_imei'];

                }

                if($row1['json_imei_tmp']!=null){

                    $row['json_imei_tmp']=$row1['json_imei_tmp'];

                }

                if($row1['cotheban_tmp']>0){

                    $row['cotheban_tmp']=$row1['cotheban_tmp'];

                }*/

                $row['cotheban_tmp'] = 0;

                $row['table'] = 'product_option';
            }
        }

        return $row;
    }

    /*

    |--------------------------------------------------------------------------

    | Get mau - color info

    |--------------------------------------------------------------------------

    */

    public static function get_mau_info($id)
    {
        self::initialized('color', 'man');

        $model = self::$colorRepo;

        //$model = new Color();

        $row = $model->GetOneItem($id, self::$relations);

        if ($row) {
            return $row;
        }

        return null;
    }

    /*

    |--------------------------------------------------------------------------

    | Get mau - color info params

    |--------------------------------------------------------------------------

    */

    public static function get_mau_info_by_params($params)
    {

        //$model = new Color();

        self::initialized('color', 'man');

        $model = self::$colorRepo;

        $row = $model->Getitem($params);

        if ($row) {
            return $row;
        }

        return null;
    }

    /*

    |--------------------------------------------------------------------------

    | Get mau - color info

    |--------------------------------------------------------------------------

    */

    public static function get_size_info($id)
    {

        //$model = new Size();

        self::initialized('size', 'man');

        $model = self::$sizeRepo;

        $row = $model->GetOneItem($id, self::$relations);

        if ($row) {
            return $row;
        }

        return null;
    }

    /*

    |--------------------------------------------------------------------------

    | Get size info params

    |--------------------------------------------------------------------------

    */

    public static function get_size_info_by_params($params)
    {

        //$model = new Size();

        self::initialized('size', 'man');

        $model = self::$sizeRepo;

        $row = $model->Getitem($params);

        if ($row) {
            return $row;
        }

        return null;
    }

    /*

    |--------------------------------------------------------------------------

    | Xóa cart sau khi insert

    |--------------------------------------------------------------------------

    */

    public static function remove_cart($code = '', $id_user = 0, $token_member_cart = '')
    {

        //### khai báo model

        $model_cart = new Cart();

        //### xử lý

        if ($id_user>0) {
            $model_cart = $mode_cart->where('id_user', $id_user);
        } else {
            $model_cart = $mode_cart->where('id_user', 0)->where('token_member_cart', $token_member_cart);
        }

        $row_exist = $mode_cart->where('code', $code)->get()->pluck('id');

        //### xóa

        if ($row_exist) {
            $row_exist->toArray();

            $model_cart = new Cart();

            $model_cart->DeleteMultiItem($row_exist);
        }
    }
}
