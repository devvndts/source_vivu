<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Http\Request;

//use App\Models\Setting;
//use App\Models\Photo;
//use App\Models\StaticPost;

use App\Repositories\Repo\PhotoRepository;
use App\Repositories\Repo\SettingRepository;
use App\Repositories\Repo\StaticPostRepository;
use App\Repositories\Repo\PostRepository;
use App\Repositories\Repo\CategoryRepository;
use App\Repositories\Repo\TagRepository;

use Session;
use CartHelper;

class ManualServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /* bind lang */
        $this->app->bind('lang', function () {
            if (session('locale')) {
                return session('locale');
            } else {
                Session::put('locale', config('app.locale'));
                Session::put('lang', config('app.locale'));
                return session('locale');
            }
        });
        /* bind sluglang */
        $this->app->bind('sluglang', function () {
            return 'tenkhongdauvi';
        });
        /* bind setting */
        $this->app->bind('setting', function () {
            $model_setting = new SettingRepository();
            return $model_setting->GetItem(['type'=>'setting']);
        });
        /* bind setting options*/
        $this->app->bind('settingOptions', function () {
            $model_setting = new SettingRepository();
            $model_setting = $model_setting->GetItem(['type'=>'setting']);
            return json_decode($model_setting['options'], true);
        });
        /* bind logo */
        $this->app->bind('logo', function () {
            $model_photo = new PhotoRepository();
            return $model_photo->GetItem(['type'=>'logo','act'=>'photo_static']);
        });
        /* bind noimage */
        $this->app->bind('noimage', function () {
            return asset('img/noimage.png');
        });
        /* bind bocongthuong */
        $this->app->bind('bocongthuong', function () {
            $model_photo = new PhotoRepository();
            return $model_photo->GetItem(['type'=>'bocongthuong','act'=>'photo_static']);
        });
        /* bind photo_static */
        $this->app->bind('photo_static', function () {
            $model_photo = new PhotoRepository();
            return $model_photo->GetPhotoStatic(['act'=>'photo_static']);
        });
        /* bind favicon */
        $this->app->bind('favicon', function () {
            $model_photo = new PhotoRepository();
            return $model_photo->GetItem(['type'=>'favicon','act'=>'photo_static']);
        });
        /* bind bocongthuong */
        $this->app->bind('ketnoi', function () {
            $model_photo = new PhotoRepository();
            return $model_photo->GetAllItems('ketnoi', ['hienthi'=>1]);
        });
        /* bind bocongthuong */
        $this->app->bind('mangxahoi', function () {
            $model_photo = new PhotoRepository();
            return $model_photo->GetAllItems('mangxahoi', ['hienthi'=>1]);
        });
        /* bind bocongthuong */
        $this->app->bind('mangxahoi_f', function () {
            $model_photo = new PhotoRepository();
            return $model_photo->GetAllItems('mangxahoi_f', ['hienthi'=>1]);
        });
        /* bind footer */
        $this->app->bind('footer', function () {
            $model_staticpost = new StaticPostRepository();
            return $model_staticpost->GetItem(['type'=>'footer']);
        });
        /* bind chinhsachs
        $this->app->bind('chinhsachs', function () {
            $model_post = new PostRepository();
            return $model_post->GetAllItems('chinhsach',['hienthi'=>1]);
        }); */
        /* bind chinhsachs */
        $this->app->bind('chinhsachfooters', function () {
            $model_post = new PostRepository();
            return $model_post->GetAllItems('chinhsachfooter', ['hienthi'=>1]);
        });
        /* bind chinhsachs */
        $this->app->bind('danhmuc_cap3', function () {
            $model_category = new CategoryRepository();
            return $model_category->GetAllItems('product', ['hienthi'=>1, 'level'=>2]);
        });
        /* bind chinhsachs */
        $this->app->bind('danhmuc_cap2', function () {
            $model_category = new CategoryRepository();
            return $model_category->GetAllItems('product', ['hienthi'=>1, 'level'=>1]);
        });
        /* bind chinhsachs */
        $this->app->bind('danhmuc_cap1', function () {
            $model_category = new CategoryRepository();
            return $model_category->GetAllItems('product', ['hienthi'=>1, 'level'=>0]);
        });
        /* bind chinhsachs */
        $this->app->bind('tagproduct', function () {
            $model_tag = new TagRepository();
            return $model_tag->GetAllItems('product', ['hienthi'=>1]);
        });
        /* bind footer */
        $this->app->bind('share_all_cart', function () {
            return CartHelper::Get_all_cart();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return ['lang', 'setting', 'logo', 'favicon', 'footer', 'share_all_cart'];
    }
}
