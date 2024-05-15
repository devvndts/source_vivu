<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Helper;

class CheckModel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $model)
    {
        /*
        |--------------------------------------------------------------------------
        | Danh sách giao diện trang lỗi
        |--------------------------------------------------------------------------
        */
        $page_404 = redirect()->route('admin.error.show', '404');


        /*
        |--------------------------------------------------------------------------
        | model ko tồn tại => lỗi
        |--------------------------------------------------------------------------
        */
        $array_model = ['Product', 'Post', 'Album', 'Setting', 'Photo', 'StaticPost', 'Color', 'Size', 'Error', 'ProductOption', 'Member', 'Brand', 'Tags', 'Places', 'Newsletter', 'Contact', 'Order', 'SeoPage', 'Lang', 'Category', 'Question', 'DanhGia', 'Sale'];
        if (!in_array($model, $array_model)) {
            return $page_404;
        }


        /*
        |--------------------------------------------------------------------------
        | code xử lý kiểm tra đầu vào trang admin
        |--------------------------------------------------------------------------
        */
        $type = $request->type;
        $category = $request->category;

        switch ($model) {
            case 'Sale':
                $array_type = Helper::GetArrayType(config('config_type.sale'));
                $array_category = ['man'];
                break;
            case 'Setting':
                $array_type = Helper::GetArrayType(config('config_type.setting'));
                $array_category = ['man'];
                break;
            case 'Product':
                $array_type = Helper::GetArrayType(config('config_type.product'));
                $array_category = ['man'];
                break;
            case 'ProductOption':
                $array_type = Helper::GetArrayType(config('config_type.product'));
                $array_category = ['man'];
                break;
            case 'Post':
                $array_type = Helper::GetArrayType(config('config_type.post'));
                $array_category = ['man'];
                break;
            case 'Album':
                $array_type = Helper::GetArrayType(config('config_type.album'));
                $array_category = ['man'];
                break;
            case 'Color':
                $array_type = Helper::GetArrayType(config('config_type.product'));
                $array_category = ['man'];
                break;
            case 'Size':
                $array_type = Helper::GetArrayType(config('config_type.product'));
                $array_category = ['man'];
                break;
            case 'Brand':
                $array_type = Helper::GetArrayType(config('config_type.product'));
                $array_category = ['man'];
                break;
            case 'Tags':
                $array_type = Helper::GetArrayType(config('config_type.tags'));
                $array_category = ['man'];
                break;
            case 'Newsletter':
                $array_type = Helper::GetArrayType(config('config_type.newsletter'));
                $array_category = ['man'];
                break;
            case 'Contact':
                $array_type = Helper::GetArrayType(config('config_type.contact'));
                $array_category = ['man'];
                break;
            case 'Photo':
                $array_category = ['photo_static', 'man_photo'];
                if ($category=='photo_static') {
                    $array_type = Helper::GetArrayType(config('config_type.photo'));
                } elseif ($category=='man_photo') {
                    $array_type = Helper::GetArrayType(config('config_type.photo'));
                } else {
                    $array_type=array();
                }
                break;
            case 'StaticPost':
                $array_type = Helper::GetArrayType(config('config_type.staticpost'));
                $array_category = ['man'];
                break;
            case 'SeoPage':
                $array_type = Helper::GetArrayType(config('config_type.seopage'));
                $array_category = ['man'];
                break;
            case 'Places':
                $type='place';
                $array_type=['place'];
                $array_category = ['list', 'cat', 'item', 'man'];
                break;
            case 'Order':
                $type='order';
                $array_type=['order'];
                $array_category = ['man'];
                break;
            case 'Question':
                $type='';
                $array_type=[''];
                $array_category = ['man'];
                break;
            case 'DanhGia':
                $type='';
                $array_type=[''];
                $array_category = ['man'];
                break;
            case 'Error':
                $type='error';
                $array_type=['error'];
                $array_category=['403','404'];
                break;
            case 'Member':
            case 'Lang':
                $type='';
                $array_type=[''];
                $array_category=[''];
                break;
            case 'Category':
                $type='';
                $array_type=[''];
                $array_category=[''];
                break;
            default:
                return $page_404;
        }

        if ((in_array($type, $array_type) && in_array($category, $array_category))) {
            return $next($request);
        }

        return $page_404; //return abort(404);
    }
}
