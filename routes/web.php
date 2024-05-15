<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

//################################### Desktop ############################################
/*
|--------------------------------------------------------------------------
| Route xử lý URL elfinder : upload hình ảnh trong nội dung bài viết
|--------------------------------------------------------------------------
*/

Route::get('/elfinder', 'ElfinderController@Index')->middleware('auth:admin')->name('elfinder');
Route::post('webhook', 'WebhookController@handle');
/*
|--------------------------------------------------------------------------
| Web Routes : Desktop
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//################################### Desktop ############################################
Route::group(['name'=>'desktop.'], function () {
    /*
    |--------------------------------------------------------------------------
    | Route trang chủ
    |--------------------------------------------------------------------------
    */
    
    Route::post('/allpage', 'HomeController@store')->name('allpage');
    Route::get('/demo{type?}', 'DemoController@index')->name('demo');
    // Route::get('/view', 'HomeController@Index')->name('home');

    /*Route::get('/mail', function(){
        return view('mails.order');
    })->name('home');*/


    /*
    |--------------------------------------------------------------------------
    | Route xử lý lang - ngôn ngữ
    |--------------------------------------------------------------------------
    */
    Route::get('/lang/{lang}', 'DesktopController@SetLang')->name('lang');
    Route::get('/blockweb', function () {
        return view('desktop.blockweb');
    })->name('blockweb');
    

    /*
    |--------------------------------------------------------------------------
    | Route xử lý capcha
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix'=>'capcha', 'name'=>'capcha.'], function () {
        Route::get('/reset', 'CapchaController@Reset')->name('capcha.reset');
    });

    Route::group([
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function () {
        /*
        |--------------------------------------------------------------------------
        | Route xử lý URL slug
        |--------------------------------------------------------------------------
        */
        Route::get('/sitemap.xml/{page?}', 'DesktopController@SiteMapIndex');
        Route::get('/sitemap/{page?}', 'DesktopController@SiteMapIndex');

        Route::get('/', 'HomeController@Index')->name('home');
        Route::get('/khach-hang-danh-gia', 'DanhGiaController@Show');
        Route::get('/checkout{query?}', function () {
            return view('desktop.templates.cart.checkout');
        })->name('checkout');
    
        /*
        |--------------------------------------------------------------------------
        | Route xử lý payment
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix'=>'nganluong', 'name'=>'nganluong.'], function () {
            Route::get('/success{query?}', 'NganLuongController@Return')->name('nganluong.return');
            Route::get('/notify', 'NganLuongController@Notify')->name('nganluong.notify');
            Route::get('/cancel/{orderid}', 'NganLuongController@Cancel')->name('nganluong.cancel');
            Route::post('/update-order', 'NganLuongController@Update')->name('nganluong.update'); // ### link địa chỉ webservice của ngân lượng
        });
    
        /*
        |--------------------------------------------------------------------------
        | Route xử lý payment
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix'=>'alepay', 'name'=>'alepay.'], function () {
            Route::get('/success{query?}', 'AlepayController@Return')->name('alepay.return');
            Route::get('/notify', 'AlepayController@Notify')->name('alepay.notify');
            Route::get('/cancel/{orderid}', 'AlepayController@Cancel')->name('alepay.cancel');
            Route::post('/update-order', 'AlepayController@Update')->name('alepay.update'); // ### link địa chỉ webservice của ngân lượng
        });
        
        /*
        |--------------------------------------------------------------------------
        | Route xử lý lazada
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix'=>'lazada', 'name'=>'lazada.'], function () {
            Route::get('/callback{query?}', 'LazadaController@CallBack')->name('lazada.callback');
            Route::post('/webhook{query?}', 'LazadaController@WebHook')->name('lazada.webhook');
        });

        
    
    
        /*
        |--------------------------------------------------------------------------
        | Route send contact - newsletter
        |--------------------------------------------------------------------------
        */
        Route::post('/send-contact', 'SendEmailController@SendContact')->name('sendContact');
        Route::post('/send-newsletter', 'SendEmailController@SendNewsletter')->name('sendNewsletter');
    
    
        /*
        |--------------------------------------------------------------------------
        | Route page Error: 404, 403, ...
        |--------------------------------------------------------------------------
        */
        Route::group(['name'=>'error.'], function () {
            Route::get('/error/{category}', 'ErrorController@Show')->name('error.show');
        });
    
    
        /*
        |--------------------------------------------------------------------------
        | Route xử lý ajax desktop
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix'=>'ajax', 'name'=>'ajax.'], function () {
            Route::get('/pagination-ajax', 'AjaxController@PaginationAjax')->name('ajax.pagination');
            Route::get('/load-prolist', 'AjaxController@LoadProductList')->name('ajax.loadProlist');
            Route::get('/load-postlist', 'AjaxController@LoadPostList')->name('ajax.loadPostlist');
            Route::post('/ajax-product-detail', 'AjaxController@ProductDetailAjax')->name('ajax.product.detail');
            Route::post('/ajax-product-gallery', 'AjaxController@ProductGalleryAjax')->name('ajax.product.gallery');
            Route::post('/ajax-cart', 'AjaxController@CartAjax')->name('ajax.cart');
    
            Route::post('/ajax-district', 'AjaxController@DistrictAjax')->name('ajax.district');
            Route::post('/ajax-wards', 'AjaxController@WardsAjax')->name('ajax.wards');
            Route::get('/ajax-address', 'AjaxController@AddAdressAjax')->name('ajax.wards');
    
            Route::get('/ajax-js', 'AjaxController@LoadJsAjax')->name('ajax.js');
            Route::get('/ajax-check-cart', 'AjaxController@CheckCartAjax')->name('ajax.check.cart');
            Route::post('/ajax-get-size', 'AjaxController@GetSizes')->name('ajax.get.size');
    
            Route::post('/ajax-add-question', 'AjaxController@AddQuestion')->name('ajax.add.question');
            Route::get('/ajax-change-question', 'AjaxController@ChangeQuestion')->name('ajax.change.question');
            Route::post('/ajax-check-voucher', 'AjaxController@CheckVoucherAjax')->name('ajax.check.voucher');
    
            Route::post('/ajax-add-danhgia', 'AjaxController@AddDanhGia')->name('ajax.add.danhgia');
            Route::get('/ajax-change-danhgia', 'AjaxController@ChangeDanhGia')->name('ajax.change.danhgia');
    
            Route::get('/ajax-category-filter', 'AjaxController@FilterCategory')->name('ajax.category.filter');
    
            Route::get('/ajax-search-cuahang', 'AjaxController@SearchCuahang')->name('ajax.search.cuahang');
            Route::get('/ajax-load-cuahang', 'AjaxController@LoadCuahang')->name('ajax.load.cuahang');
        });
    
    
        /*
        |--------------------------------------------------------------------------
        | Route xử lý ajax desktop
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix'=>'transpost', 'name'=>'transpost.'], function () {
            Route::get('/get-city', 'TransPostController@GetCity')->name('transpost.city');
            Route::get('/get-district', 'TransPostController@GetDistrict')->name('transpost.district');
            Route::get('/get-ward', 'TransPostController@GetWard')->name('transpost.ward');
            Route::get('/get-service-price', 'TransPostController@ServiceShip')->name('transpost.serviceShip');
            Route::get('/get-info-price', 'TransPostController@InfoPrice')->name('transpost.infoPrice');
        });
    
    
        /*
        |--------------------------------------------------------------------------
        | Route xử lý ajax desktop
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix'=>'addon', 'name'=>'addon.'], function () {
            Route::post('/video-fotorama', 'AddonController@VideoFotorama')->name('addon.video.fotorama');
            Route::post('/video-select', 'AddonController@VideoSelect')->name('addon.video.select');
            Route::post('/fanpage-facebook', 'AddonController@FanpageFacebook')->name('addon.fanpage.facebook');
            Route::post('/messages-facebook', 'AddonController@MessagesFacebook')->name('addon.messages.facebook');
        });
    
    
        /*
        |--------------------------------------------------------------------------
        | Route xử lý address user
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix'=>'address', 'name'=>'address.'], function () {
            Route::get('/show/{id?}', 'AddressController@Show')->name('address.show');
            Route::get('/select-default', 'AddressController@SelectDefault')->name('address.selectDefault');
            Route::post('/add', 'AddressController@Add')->name('address.add');
            Route::post('/save-default', 'AddressController@SaveDefault')->name('address.saveDefault');
        });
    
    
        /*
        |--------------------------------------------------------------------------
        | Route xử lý giỏ hàng
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix'=>'cart', 'name'=>'cart.'], function () {
            Route::post('/order', 'CartController@OrderCart')->name('cart.order');
            Route::get('/inform/{status}', 'CartController@OrderInform')->name('cart.inform');
            Route::get('/kiem-tra-don-hang{query?}', 'CartController@OrderCheckCart')->name('cart.checkcart');
        });
    
    
        /*
        |--------------------------------------------------------------------------
        | Route xử lý đăng ký - đăng nhập : table users
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix'=>'account', 'name'=>'account.'], function () {
            //Route::post('/login', 'LoginController@Login')->name('account.login');
            //Route::post('/signin', 'LoginController@Signin')->name('account.signin');
            //Route::post('/reset-account', 'LoginController@Reset')->name('account.resetAccount');
        
            Route::match(['get', 'post'], '/login', 'LoginController@Login')->name('account.login');
            Route::match(['get', 'post'], '/reset-account', 'LoginController@Reset')->name('account.resetAccount');
            Route::match(['get', 'post'], '/signin', 'LoginController@Signin')->name('account.signin');
            Route::match(['get', 'post'], '/manage', 'LoginController@Manage')->name('account.manage');
            Route::match(['get', 'post'], '/editpass', 'LoginController@EditPassword')->name('account.editpass');
            Route::match(['get', 'post'], '/history-coin', 'LoginController@HistoryCoin')->name('account.historycoin');
            Route::match(['get', 'post'], '/manage-coin', 'LoginController@ManageCoin')->name('account.managecoin');
            Route::match(['get', 'post'], '/history-coin', 'LoginController@HistoryCoin')->name('account.historycoin');
            Route::match(['get', 'post'], '/post-news/{id?}', 'LoginController@PostNews')->name('account.postnews');
            Route::match(['get', 'post'], '/report', 'LoginController@Report')->name('account.report');
            Route::match(['get', 'post'], '/history-pay', 'LoginController@HistoryPay')->name('account.historypay');
            Route::match(['get', 'post'], '/buy-post-month', 'LoginController@BuyPostMonth')->name('account.buyPostMonth');
            Route::match(['get', 'post'], '/regis-VIP', 'LoginController@RegisVIP')->name('account.regisVIP');
            Route::get('/list-news', 'LoginController@Listnews')->name('account.listnews');
            Route::get('/delete-news', 'LoginController@DeletePostnews')->name('account.deletePostnews');
    
            Route::get('/newlike', 'LoginController@NewLike')->name('account.newlike');
            Route::get('/inform/{option}', 'LoginController@Inform')->name('account.inform');
        
            Route::get('/logout', 'LoginController@Logout')->name('account.logout');
            Route::get('/order-manage', 'LoginController@OrderManage')->name('account.ordermanage');
            Route::get('/active/{email?}', 'LoginController@Active')->name('account.active');
            Route::get('/verification/{data}', 'LoginController@Verification')->name('account.verification');
            Route::match(['get', 'post'], '/information', 'LoginController@Information')->name('account.information');
            Route::get('/social/{provider}', 'SocialLogin@CallSocial')->name('social.login');
            Route::get('/social/{provider}/callback{query?}', 'SocialLogin@UpdateAccount');
    
            Route::get('/change-status-inform', 'LoginController@ChangeStatusInform')->name('account.changeStatusInform');
            Route::get('/preview', 'LoginController@Preview')->name('account.preview');
            Route::get('/alert', 'LoginController@Alert')->name('account.alert');
            Route::get('/status', 'LoginController@Status')->name('account.status');
    
            Route::post('/extend-time', 'LoginController@ExtendTime')->name('account.extendTime');
            Route::get('/delete-binhchon-option', 'LoginController@DeleteBinhchonOption')->name('account.deleteBinhchonOption');
            Route::get('/delete-fileupload', 'LoginController@DeleteFileupload')->name('account.deleteFileupload');
        });
        /*
        |--------------------------------------------------------------------------
        | Route xử lý URL slug
        |--------------------------------------------------------------------------
        */
        //Route::get('/{slug}', 'DesktopController@CallSlug')->name('slug');
        Route::get('/{slug}{query?}', 'DesktopController@CallSlug');
        Route::get('/{slug}/{level1?}{query?}', 'DesktopController@CallSlug');
        Route::get('/{slug}/{level1?}/{level2?}{query?}', 'DesktopController@CallSlug');
        Route::get('/{slug}/{level1?}/{level2?}/{level3?}{query?}', 'DesktopController@CallSlug')->name('slug');
    });
});
