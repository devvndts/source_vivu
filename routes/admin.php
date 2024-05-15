<?php

use App\Http\Middleware\LanguageManagerAdmin;
use Illuminate\Support\Facades\Route;

Route::get(app('settingOptions')['linkadmin'].'/', 'DashboardController@Index')->name('admin.index');

/* *** ADMIN  *** */
/*
|--------------------------------------------------------------------------
| Route login admin
|--------------------------------------------------------------------------
*/
Route::match(['get', 'post'], '/'.app('settingOptions')['linkadmin'].'/login', 'LoginController@Login')->name('admin.login');
Route::match(['get'], '/'.app('settingOptions')['linkadmin'].'/logout', 'LoginController@Logout')->name('admin.logout');
Route::group(['name'=>'admin.','prefix'=>app('settingOptions')['linkadmin'], 'middleware'=>['auth:admin','AuthAdmin',LanguageManagerAdmin::class]], function () {
    /*
    |--------------------------------------------------------------------------
    | Route clear cache
    |--------------------------------------------------------------------------
    */
    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        //cache()->flush();
        return redirect()->route('admin.dashboard');
    })->name('admin.clearCache');

    Route::get('/clear-log', function () {
        file_put_contents(storage_path('logs/laravel.log'), '');
        return redirect()->route('admin.dashboard');
    })->name('admin.clearLog');


    Route::get('/install-vietnam-map', function () {
        Artisan::call('vietnam-map:download');
        return redirect()->route('admin.dashboard');
    })->name('admin.vietnamMap');


    /*
    |--------------------------------------------------------------------------
    | Route trang dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/', 'DashboardController@Index')->name('admin.index');
    Route::group(['name'=>'dashboard.', 'prefix'=>'dashboard'], function () {
        Route::get('/', 'DashboardController@Index')->name('admin.dashboard');
        Route::get('/expireToken', 'DashboardController@ExpireToken')->name('admin.expireToken');
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý delivery
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix'=>'transpost', 'name'=>'transpost.'], function () {
        Route::get('/get-places/{type}', 'TransPostController@GetPlaces')->name('admin.transpost.places');
    });


    /*
    |--------------------------------------------------------------------------
    | Route coupon
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'coupon.', 'prefix'=>'coupon'], function () {
        Route::get('/show/{category}/{type}/{query?}', 'CouponController@Show')->name('admin.coupon.show'); //load ds

        Route::get('/edit/{category}/{type}/{id?}', 'CouponController@Edit')->name('admin.coupon.edit'); // thêm mới hoặc cập nhật

        Route::get('/delete/{category}/{type}/{id}', 'CouponController@Delete')->name('admin.coupon.delete'); // xóa

        Route::get('/deleteall/{category}/{type}/{listid?}', 'CouponController@DeleteAll')->name('admin.coupon.deleteAll'); // xóa all

        Route::post('/save/{category}/{type}/{id?}', 'CouponController@Save')->name('admin.coupon.save'); // lưu
    });



    /*
    |--------------------------------------------------------------------------
    | Route coupon
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'lazada.', 'prefix'=>'lazada'], function () {
        Route::get('/show/{category}/{type}/{query?}', 'LazadaController@Show')->name('admin.lazada.show'); //load ds
        Route::post('/import/{category}/{type}/{query?}', 'LazadaController@Import')->name('admin.lazada.import'); // import file excel
        Route::get('/export/{category}/{type}/{query?}', 'LazadaController@Export')->name('admin.lazada.export'); // export file excel

        Route::get('/inventory/{category}/{type}/{query?}', 'LazadaController@Inventory')->name('admin.lazada.inventory'); // inventory - kho
        Route::post('/inventory-import/{category}/{type}/{query?}', 'LazadaController@InventoryImport')->name('admin.lazada.inventoryImport'); // import file excel
        Route::get('/inventory-export/{category}/{type}/{query?}', 'LazadaController@InventoryExport')->name('admin.lazada.inventoryExport'); // export file excel


        Route::get('/editinventory/{category}/{type}/{id}', 'LazadaController@EditInventory')->name('admin.lazada.EditInventory'); // inventory - view edit
        Route::post('/inventory/{category}/{type}/{query?}', 'LazadaController@Save')->name('admin.lazada.save'); // inventory - view edit
    });



    /*
    |--------------------------------------------------------------------------
    | Route menu
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'menu.', 'prefix'=>'menu'], function () {
        Route::get('/manage-menus/{id?}/{lang?}', 'MenuController@Index')->name('admin.menu.index');
        Route::post('/create-menu', 'MenuController@Create')->name('admin.menu.create');

        Route::post('/add-categories-to-menu', 'MenuController@AddCatToMenu')->name('admin.menu.addCate');
        Route::get('/add-post-to-menu', 'MenuController@AddPostToMenu')->name('admin.menu.addPost');
        Route::get('/add-product-to-menu', 'MenuController@AddProductToMenu')->name('admin.menu.addProduct');
        Route::get('/add-album-to-menu', 'MenuController@AddAlbumToMenu')->name('admin.menu.addAlbum');
        Route::get('/add-page-to-menu', 'MenuController@AddPageToMenu')->name('admin.menu.addPage');
        Route::get('/add-custom-link', 'MenuController@AddCustomLink')->name('admin.menu.addLink');

        Route::post('/update-menu', 'MenuController@UpdateMenu')->name('admin.menu.updateMenu');
        Route::post('/update-menuitem/{id}', 'MenuController@UpdateMenuItem')->name('admin.menu.updateMenuItem');
        Route::post('/delete-menuitem', 'MenuController@DeleteMenuItem')->name('admin.menu.deleteMenuItem');
        Route::get('/delete-menu/{id}', 'MenuController@Destroy')->name('admin.menu.destroy');
    });



    /*
    |--------------------------------------------------------------------------
    | Route gallery file upload
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'gallery.', 'prefix'=>'gallery'], function () {
        Route::get('/fileupload', 'FileUploadController@Index')->name('admin.gallery.fileupload');
        Route::post('/save', 'FileUploadController@Save')->name('admin.gallery.save');
        Route::get('/change', 'FileUploadController@Change')->name('admin.gallery.change');
    });

    /*
    |--------------------------------------------------------------------------
    | Route redirector
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'redirector.', 'prefix'=>'redirector'], function () {
        Route::get('/show', 'RedirectorController@Show')->name('admin.redirector.show');
        Route::get('/deleteall/{listid?}', 'RedirectorController@DeleteAll')->name('admin.redirector.deleteAll');
        Route::get('/add', 'RedirectorController@Add')->name('admin.redirector.add');
        Route::get('/edit/{id?}', 'RedirectorController@Edit')->name('admin.redirector.edit');
        Route::get('/delete/{id}', 'RedirectorController@Delete')->name('admin.redirector.delete');
        Route::post('/save', 'RedirectorController@Save')->name('admin.redirector.save');
    });

    /*
    |--------------------------------------------------------------------------
    | Route xử lý ajax admin
    |--------------------------------------------------------------------------
    */
    Route::post('/ajax-add-cart', 'AjaxController@AddCart')->name('admin.ajax.addCart');
    Route::post('/ajax-delete-gallery', 'AjaxController@AjaxDeleteGallery')->name('admin.ajax.ajaxDeleteGallery');
    Route::post('/ajax-category', 'AjaxController@Category')->name('admin.ajax.category');
    Route::post('/ajax-option-product', 'AjaxController@OptionProduct')->name('admin.ajax.optionProduct');
    Route::post('/ajax-category-order', 'AjaxController@CategoryOrder')->name('admin.ajax.category_order');
    Route::post('/ajax-category-places', 'AjaxController@CategoryPlaces')->name('admin.ajax.categoryPlaces');
    Route::post('/ajax-status', 'AjaxController@Status')->name('admin.ajax.status');
    Route::post('/ajax-stt', 'AjaxController@SttNumber')->name('admin.ajax.stt');
    Route::post('/ajax-upload', 'AjaxController@UploadImage')->name('admin.ajax.upload');
    Route::post('/ajax-filer', 'AjaxController@Filer')->name('admin.ajax.filer');
    Route::post('/ajax-slug', 'AjaxController@Slug')->name('admin.ajax.slug');
    Route::post('/ajax-check-info-product', 'AjaxController@CheckInfoPro')->name('admin.ajax.checkInfoPro');
    Route::post('/ajax-properties', 'AjaxController@Properties')->name('admin.ajax.properties');
    Route::post('/ajax-checkOption', 'AjaxController@CheckOption')->name('admin.ajax.checkOption');
    Route::post('/ajax-deleteOption', 'AjaxController@DeleteTMPOption')->name('admin.ajax.deleteOption');
    Route::post('/ajax-changeSoluong', 'AjaxController@ChangeSoluong')->name('admin.ajax.changeSoluong');
    Route::post('/ajax-changePrice', 'AjaxController@ChangePrice')->name('admin.ajax.changePrice');
    Route::post('/ajax-addColor', 'AjaxController@AddColor')->name('admin.ajax.addColor');
    Route::get('/ajax-loadColor', 'AjaxController@LoadColor')->name('admin.ajax.loadColor');
    Route::post('/ajax-addSize', 'AjaxController@AddSize')->name('admin.ajax.addSize');
    Route::post('/ajax-addSaleProduct', 'AjaxController@addSaleProduct')->name('admin.ajax.addSaleProduct');
    Route::get('/ajax-loadSize', 'AjaxController@LoadSize')->name('admin.ajax.loadSize');
    Route::get('/ajax-loadImages', 'AjaxController@LoadImages')->name('admin.ajax.loadImages');
    Route::get('/ajax-addGallery', 'AjaxController@AddGallery')->name('admin.ajax.addGallery');
    Route::get('/ajax-deleteGalleryMulty', 'AjaxController@DeleteGalleryMulty')->name('admin.ajax.deleteGalleryMulty');

    Route::get('/ajax-multy-category', 'AjaxController@MultyCategory')->name('admin.ajax.multyCategory');
    Route::get('/ajax-multy-select-category', 'AjaxController@LoadSelectCategory')->name('admin.ajax.loadSelectCategory');
    Route::get('/ajax-deletePost', 'AjaxController@DeletePost')->name('admin.ajax.deletePost');

    /*
    |--------------------------------------------------------------------------
    | Route xử lý ajax autosave
    |--------------------------------------------------------------------------
    */
    Route::post('/ajax-autosave', 'AutoSaveController@AutoSave')->name('admin.ajax.autosave');


    /*
    |--------------------------------------------------------------------------
    | Route trang member admin
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'member.', 'prefix'=>'member', 'middleware'=>'CheckModel:Member'], function () {
        Route::get('/editchange', 'MemberController@EditChangePassword')->name('admin.member.editchange'); // show trang thay đổi mật khẩu
        Route::post('/change', 'MemberController@ChangePass')->name('admin.member.change'); // cập nhật thay đổi mật khẩu

        //### Chỉ role:3 mới có quyền những quyền dưới đây
        Route::get('/show/{query?}', 'MemberController@Show')->name('admin.member.show'); // show trang ds tài khoản admin
        Route::get('/edit/{id?}', 'MemberController@Edit')->name('admin.member.edit'); // show trang thêm tài khoản admin
        Route::post('/save', 'MemberController@Save')->name('admin.member.save'); // lưu tài khoản admin mới
        Route::get('/delete/{id}', 'MemberController@Delete')->name('admin.member.delete'); // xóa (chỉ role:3 mới có quyền này)
        Route::get('/deleteall/{listid?}', 'MemberController@DeleteAll')->name('admin.member.deleteAll'); // xóa all

        Route::group(['name'=>'role.', 'prefix'=>'role'], function () {
            Route::get('/show/', 'RoleController@Show')->name('admin.role.show'); // show trang ds tài khoản admin
            Route::get('/edit/{id?}', 'RoleController@Edit')->name('admin.role.edit'); // show trang ds tài khoản admin
            Route::post('/save', 'RoleController@Save')->name('admin.role.save'); // lưu tài khoản admin mới
            Route::get('/delete/{id}', 'RoleController@Delete')->name('admin.role.delete'); // xóa (chỉ role:3 mới có quyền này)
            Route::get('/deleteall/{listid?}', 'RoleController@DeleteAll')->name('admin.role.deleteAll'); // xóa all
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu tại bảng setting
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'setting.', 'prefix'=>'setting', 'middleware'=>'CheckModel:Setting'], function () {
        Route::get('/{category}/{type}', 'SettingController@Index')->name('admin.setting.show');
        Route::post('/{category}/{type}', 'SettingController@Save')->name('admin.setting.save');
    });

    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu tại bảng setting
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'sale.', 'prefix'=>'sale', 'middleware'=>'CheckModel:Sale'], function () {
        Route::get('/{category}/{type}', 'SaleController@index')->name('admin.sale.show');
        Route::post('/{category}/{type}', 'SaleController@save')->name('admin.sale.save');
        Route::get('/delete-product/{category}/{type}/{id}', 'SaleController@deleteProduct')->name('admin.sale.delete-product'); // xóa
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu bảng category
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'category.', 'prefix'=>'category', 'middleware'=>'CheckModel:Category'], function () {
        Route::get('/show/{type}/{query?}', 'CategoryController@Show')->name('admin.category.show'); //load ds

        Route::get('/edit/{type}/{id?}', 'CategoryController@Edit')->name('admin.category.edit'); //edit

        Route::get('/delete/{type}/{id}', 'CategoryController@Delete')->name('admin.category.delete'); // xóa

        Route::get('/deleteall/{type}/{listid?}', 'CategoryController@DeleteAll')->name('admin.category.deleteAll'); // xóa all

        Route::post('/save/{type}/{id?}', 'CategoryController@Save')->name('admin.category.save'); // lưu
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu các bảng product (productlist - productcat - productitem - productsub - product)
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'product.', 'prefix'=>'product', 'middleware'=>'CheckModel:Product'], function () {
        Route::get('/show/{category}/{type}/{query?}', 'ProductController@Show')->name('admin.product.show'); //load ds

        Route::get('/add/{category}/{type}/{id?}', 'ProductController@add')->name('admin.product.add'); // thêm mới

        Route::get('/edit/{category}/{type}/{id?}', 'ProductController@Edit')->name('admin.product.edit'); // cập nhật

        Route::get('/delete/{category}/{type}/{id}', 'ProductController@Delete')->name('admin.product.delete'); // xóa

        Route::get('/deleteall/{category}/{type}/{listid?}', 'ProductController@DeleteAll')->name('admin.product.deleteAll'); // xóa all

        Route::post('/save/{category}/{type}/{id?}', 'ProductController@Save')->name('admin.product.save'); // lưu

        Route::get('/export-all/{category}/{type}/{query?}', 'ProductController@ExportProduct')->name('admin.product.exportAll'); // xuất excel sản phẩm

        Route::get('/import-view/{category}/{type}', 'ProductController@ImportView')->name('admin.product.importView'); // giao diện nhập excel sản phẩm

        Route::post('/import-all/{category}/{type}/{query?}', 'ProductController@ImportProduct')->name('admin.product.importAll'); // nhập excel sản phẩm

        Route::match(['get','post'], '/import-images/{category}/{type}', 'ProductController@ImportImages')->name('admin.product.importImages'); // giao diện nhập excel sản phẩm
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu các bảng product_option
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'productOption.', 'prefix'=>'productOption', 'middleware'=>'CheckModel:ProductOption'], function () {
        Route::get('/show/{category}/{type}/{query?}', 'ProductOptionController@Show')->name('admin.productOption.show'); //load ds

        Route::get('/edit/{category}/{type}/{id?}', 'ProductOptionController@Edit')->name('admin.productOption.edit'); // thêm mới hoặc cập nhật

        Route::get('/delete/{category}/{type}/{id}', 'ProductOptionController@Delete')->name('admin.productOption.delete'); // xóa

        Route::get('/deleteall/{category}/{type}/{listid?}', 'ProductOptionController@DeleteAll')->name('admin.productOption.deleteAll'); // xóa all

        Route::post('/save/{category}/{type}', 'ProductOptionController@Save')->name('admin.productOption.save'); // lưu
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu danhgia
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'danhgia.', 'prefix'=>'danhgia', 'middleware'=>'CheckModel:DanhGia'], function () {
        Route::get('/show/{category}/{query?}', 'DanhGiaController@Show')->name('admin.danhgia.show'); //load ds

        Route::get('/edit/{category}/{id?}', 'DanhGiaController@Edit')->name('admin.danhgia.edit'); // thêm mới hoặc cập nhật

        Route::get('/delete/{category}/{id}', 'DanhGiaController@Delete')->name('admin.danhgia.delete'); // xóa

        Route::get('/deleteall/{category}/{listid?}', 'DanhGiaController@DeleteAll')->name('admin.danhgia.deleteAll'); // xóa all

        Route::post('/save/{category}', 'DanhGiaController@Save')->name('admin.danhgia.save'); // lưu
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu các bảng post (postlist - postcat - postitem - postsub - post)
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'post.', 'prefix'=>'post', 'middleware'=>'CheckModel:Post'], function () {
        Route::get('show/{category}/{type}/{query?}', 'PostController@Show')->name('admin.post.show');

        Route::get('/add/{category}/{type}/{id?}', 'PostController@add')->name('admin.post.add'); // thêm mới

        Route::get('/edit/{category}/{type}/{id?}', 'PostController@Edit')->name('admin.post.edit'); // cập nhật

        Route::get('/delete/{category}/{type}/{id}', 'PostController@Delete')->name('admin.post.delete');

        Route::get('/deleteall/{category}/{type}/{listid?}', 'PostController@DeleteAll')->name('admin.post.deleteAll'); // xóa all

        Route::post('/save/{category}/{type}/{id?}', 'PostController@Save')->name('admin.post.save');
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu các bảng album (albumlist - album)
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'album.', 'prefix'=>'album', 'middleware'=>'CheckModel:Album'], function () {
        Route::get('show/{category}/{type}/{query?}', 'AlbumController@Show')->name('admin.album.show');

        Route::get('/edit/{category}/{type}/{id?}', 'AlbumController@Edit')->name('admin.album.edit');

        Route::get('/delete/{category}/{type}/{id}', 'AlbumController@Delete')->name('admin.album.delete');

        Route::get('/deleteall/{category}/{type}/{listid?}', 'AlbumController@DeleteAll')->name('admin.album.deleteAll'); // xóa all

        Route::post('/save/{category}/{type}/{id?}', 'AlbumController@Save')->name('admin.album.save');
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu bảng photo (phân loại: photo_static và man_photo)
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'photo.', 'prefix'=>'photo', 'middleware'=>'CheckModel:Photo'], function () {
        Route::get('/show/{category}/{type}/{query?}', 'PhotoController@Show')->name('admin.photo.show');

        Route::get('/add/{category}/{type}', 'PhotoController@Add')->name('admin.photo.add');

        Route::get('/edit/{category}/{type}/{id}', 'PhotoController@Edit')->name('admin.photo.edit');

        Route::get('/delete/{category}/{type}/{id}', 'PhotoController@Delete')->name('admin.photo.delete');

        Route::get('/deleteall/{category}/{type}/{listid?}', 'PhotoController@DeleteAll')->name('admin.photo.deleteAll'); // xóa all

        Route::post('/save/{category}/{type}', 'PhotoController@Save')->name('admin.photo.save');

        Route::post('/save_static/{category}/{type}', 'PhotoController@SaveStatic')->name('admin.photo.save_static');
    });

    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu bảng static
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'staticpost.', 'prefix'=>'staticpost', 'middleware'=>'CheckModel:StaticPost'], function () {
        Route::get('/show/{category}/{type}', 'StaticPostController@Show')->name('admin.staticpost.show');
        Route::post('/save/{category}/{type}', 'StaticPostController@Save')->name('admin.staticpost.save');
    });

    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu bảng seopage
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'seopage.', 'prefix'=>'seopage', 'middleware'=>'CheckModel:SeoPage'], function () {
        Route::get('/show/{category}/{type}', 'SeopageController@Show')->name('admin.seopage.show');
        Route::post('/save/{category}/{type}', 'SeopageController@Save')->name('admin.seopage.save');
    });

    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu bảng color
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'color.', 'prefix'=>'color', 'middleware'=>'CheckModel:Color'], function () {
        Route::get('show/{category}/{type}/{query?}', 'ColorController@Show')->name('admin.color.show');

        Route::get('/edit/{category}/{type}/{id?}', 'ColorController@Edit')->name('admin.color.edit');

        Route::get('/delete/{category}/{type}/{id}', 'ColorController@Delete')->name('admin.color.delete');

        Route::get('/deleteall/{category}/{type}/{listid?}', 'ColorController@DeleteAll')->name('admin.color.deleteAll'); // xóa all

        Route::post('/save/{category}/{type}/{id?}', 'ColorController@Save')->name('admin.color.save');

        //Route::get('/search/{category}/{type}/{keyword?}', 'ColorController@Search')->name('admin.color.search'); // tìm kiếm
    });

    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu bảng size
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'size.', 'prefix'=>'size', 'middleware'=>'CheckModel:Size'], function () {
        Route::get('show/{category}/{type}/{query?}', 'SizeController@Show')->name('admin.size.show');// hiển thị danh sách

        Route::get('/edit/{category}/{type}/{id?}', 'SizeController@Edit')->name('admin.size.edit'); // thêm mới hoặc chỉnh sửa

        Route::get('/delete/{category}/{type}/{id}', 'SizeController@Delete')->name('admin.size.delete'); // xóa 1 dòng

        Route::get('/deleteall/{category}/{type}/{listid?}', 'SizeController@DeleteAll')->name('admin.size.deleteAll'); // xóa all

        Route::post('/save/{category}/{type}/{id?}', 'SizeController@Save')->name('admin.size.save'); // Lưu mới - cập nhật

        //Route::get('/search/{category}/{type}/{keyword?}', 'SizeController@Search')->name('admin.size.search'); // tìm kiếm
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu bảng brand - nhãn hiệu
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'brand.', 'prefix'=>'brand', 'middleware'=>'CheckModel:Brand'], function () {
        Route::get('show/{category}/{type}/{query?}', 'BrandController@Show')->name('admin.brand.show');

        Route::get('/edit/{category}/{type}/{id?}', 'BrandController@Edit')->name('admin.brand.edit');

        Route::get('/delete/{category}/{type}/{id}', 'BrandController@Delete')->name('admin.brand.delete');

        Route::get('/deleteall/{category}/{type}/{listid?}', 'BrandController@DeleteAll')->name('admin.brand.deleteAll'); // xóa all

        Route::post('/save/{category}/{type}/{id?}', 'BrandController@Save')->name('admin.brand.save');
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu bảng tags
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'tags.', 'prefix'=>'tags', 'middleware'=>'CheckModel:Tags'], function () {
        Route::get('show/{category}/{type}/{query?}', 'TagsController@Show')->name('admin.tags.show');

        Route::get('/edit/{category}/{type}/{id?}', 'TagsController@Edit')->name('admin.tags.edit');

        Route::get('/add/{category}/{type}/{id?}', 'TagsController@add')->name('admin.tags.add'); // thêm mới

        Route::get('/delete/{category}/{type}/{id}', 'TagsController@Delete')->name('admin.tags.delete');

        Route::get('/deleteall/{category}/{type}/{listid?}', 'TagsController@DeleteAll')->name('admin.tags.deleteAll'); // xóa all

        Route::post('/save/{category}/{type}/{id?}', 'TagsController@Save')->name('admin.tags.save');
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu bảng newsletter
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'newsletter.', 'prefix'=>'newsletter', 'middleware'=>'CheckModel:Newsletter'], function () {
        Route::get('show/{category}/{type}/{query?}', 'NewsletterController@Show')->name('admin.newsletter.show');

        Route::get('/edit/{category}/{type}/{id?}', 'NewsletterController@Edit')->name('admin.newsletter.edit');

        Route::get('/delete/{category}/{type}/{id}', 'NewsletterController@Delete')->name('admin.newsletter.delete');

        Route::get('/deleteall/{category}/{type}/{listid?}', 'NewsletterController@DeleteAll')->name('admin.newsletter.deleteAll'); // xóa all

        Route::post('/save/{category}/{type}/{id?}', 'NewsletterController@Save')->name('admin.newsletter.save');

        Route::post('/send/{category}/{type}', 'NewsletterController@Send')->name('admin.newsletter.send');
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu các bảng contact
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'contact.', 'prefix'=>'contact', 'middleware'=>'CheckModel:Contact'], function () {
        Route::get('/show/{category}/{type}/{query?}', 'ContactController@Show')->name('admin.contact.show'); //load ds

        Route::get('/edit/{category}/{type}/{id?}', 'ContactController@Edit')->name('admin.contact.edit'); // thêm mới hoặc cập nhật

        Route::get('/delete/{category}/{type}/{id}', 'ContactController@Delete')->name('admin.contact.delete'); // xóa

        Route::get('/deleteall/{category}/{type}/{listid?}', 'ContactController@DeleteAll')->name('admin.contact.deleteAll'); // xóa all

        Route::post('/save/{category}/{type}/{id?}', 'ContactController@Save')->name('admin.contact.save'); // lưu
    });


    /*
    |--------------------------------------------------------------------------
    | Route xử lý dữ liệu bảng place
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'places.', 'prefix'=>'places', 'middleware'=>'CheckModel:Places'], function () {
        Route::get('show/{category}/{query?}', 'PlaceController@Show')->name('admin.places.show');

        Route::get('/edit/{category}/{id?}', 'PlaceController@Edit')->name('admin.places.edit');

        Route::get('/delete/{category}/{id}', 'PlaceController@Delete')->name('admin.places.delete');

        Route::get('/deleteall/{category}/{listid?}', 'PlaceController@DeleteAll')->name('admin.places.deleteAll'); // xóa all

        Route::post('/save/{category}/{id?}', 'PlaceController@Save')->name('admin.places.save');
    });


    /*
    |--------------------------------------------------------------------------
    | Route trang order
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'order.', 'prefix'=>'order', 'middleware'=>'CheckModel:Order'], function () {
        Route::get('/show/{category}/{query?}', 'OrderController@Show')->name('admin.order.show'); //load ds

        Route::get('/edit/{category}/{id?}', 'OrderController@Edit')->name('admin.order.edit'); // thêm mới hoặc cập nhật

        Route::get('/delete/{category}/{id}', 'OrderController@Delete')->name('admin.order.delete'); // xóa

        Route::get('/deleteall/{category}/{listid?}', 'OrderController@DeleteAll')->name('admin.order.deleteAll'); // xóa all

        Route::post('/save/{category}/{id?}', 'OrderController@Save')->name('admin.order.save'); // lưu

        Route::get('/create/{category}/{id?}', 'OrderController@Create')->name('admin.order.create'); // create

        Route::post('/savecreate/{category}/{id?}', 'OrderController@SaveCreate')->name('admin.order.savecreate'); // lưu create

        Route::get('/export-all/{category}/{query?}', 'OrderController@ExportAllItems')->name('admin.order.exportAll'); // xuất excel đơn hàng

        Route::get('/print/{category}/{id}', 'OrderController@Print')->name('admin.order.print'); // xóa all

        Route::get('/sendbill/{category}/{id}', 'OrderController@SendBill')->name('admin.order.sendbill'); // xóa all

        Route::get('/cancelbill/{category}/{id}', 'OrderController@CancelBill')->name('admin.order.cancelbill'); // hủy all
    });


    /*
    |--------------------------------------------------------------------------
    | Route trang order
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'question.', 'prefix'=>'question', 'middleware'=>'CheckModel:Question'], function () {
        Route::get('/show/{category}/{query?}', 'QuestionController@Show')->name('admin.question.show'); //load ds

        Route::get('/edit/{category}/{id?}', 'QuestionController@Edit')->name('admin.question.edit'); // thêm mới hoặc cập nhật

        Route::get('/delete/{category}/{id}', 'QuestionController@Delete')->name('admin.question.delete'); // xóa

        Route::get('/deleteall/{category}/{listid?}', 'QuestionController@DeleteAll')->name('admin.question.deleteAll'); // xóa all

        Route::post('/save/{category}/{id?}', 'QuestionController@Save')->name('admin.question.save'); // lưu
    });



    /*
    |--------------------------------------------------------------------------
    | Route lang: vi - en
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'lang.', 'prefix'=>'lang', 'middleware'=>'CheckModel:Lang'], function () {
        Route::get('/show', 'LangController@Show')->name('admin.lang.show');

        Route::get('/edit/{id?}', 'LangController@Edit')->name('admin.lang.edit');

        Route::get('/delete/{id}', 'LangController@Delete')->name('admin.lang.delete'); // xóa

        Route::get('/deleteall/{listid?}', 'LangController@DeleteAll')->name('admin.lang.deleteAll'); // xóa all

        Route::post('/save/{id?}', 'LangController@Save')->name('admin.lang.save'); // lưu

        Route::get('/export', 'LangController@Export')->name('admin.lang.export'); // xuất excel ngôn ngữ

        Route::get('/import-view', 'LangController@ImportView')->name('admin.lang.importView'); // giao diện nhập excel ngôn ngữ

        Route::post('/import', 'LangController@Import')->name('admin.lang.import'); // xuất excel ngôn ngữ
    });



    /*
    |--------------------------------------------------------------------------
    | Route page Error: 404, 403, ...
    |--------------------------------------------------------------------------
    */
    Route::group(['name'=>'error.', 'prefix'=>'error', 'middleware'=>'CheckModel:Error'], function () {
        Route::get('/show/{category}', 'ErrorController@Show')->name('admin.error.show');
    });
});
