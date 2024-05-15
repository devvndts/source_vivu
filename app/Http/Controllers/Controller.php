<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Http\Traits\SupportTrait;

use App\Repositories\Repo\AlbumRepository;
use App\Repositories\Repo\PostRepository;
use App\Repositories\Repo\ProductRepository;
use App\Repositories\Repo\UserRepository;
use App\Repositories\Repo\ProductOptionRepository;
use App\Repositories\Repo\CategoryRepository;

use App\Repositories\Repo\BrandRepository;
use App\Repositories\Repo\ColorRepository;
use App\Repositories\Repo\GalleryRepository;
use App\Repositories\Repo\PhotoRepository;
use App\Repositories\Repo\SizeRepository;

use App\Repositories\Repo\StaticPostRepository;
use App\Repositories\Repo\TagRepository;
use App\Repositories\Repo\NewsletterRepository;
use App\Repositories\Repo\ContactRepository;
use App\Repositories\Repo\SeoPageRepository;

use App\Repositories\Repo\SettingRepository;
use App\Repositories\Repo\SaleRepository;
use App\Repositories\Repo\SaleProductRepository;
use App\Repositories\Repo\QuestionRepository;
use App\Repositories\Repo\CouponRepository;
use App\Repositories\Repo\InventoryRepository;
use App\Repositories\Repo\DanhgiaRepository;

use App\Lazada\LazadaPlatformAPI;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use SupportTrait;

    //### khai báo biến repo
    public $albumRepo;
    public $brandRepo;
    public $colorRepo;
    public $galleryRepo;
    public $photoRepo;
    public $postRepo;
    public $productOptRepo;
    public $productRepo;
    public $sizeRepo;
    public $staticRepo;
    public $tagRepo;
    public $categoryRepo;
    public $newsletterRepo;
    public $contactRepo;
    public $seopageRepo;
    public $settingRepo;
    public $questionRepo;
    public $couponRepo;
    public $lazada_api;
    public $inventoryRepo;
    public $danhgiaRepo;

    //### khai báo biến category kiểm tra model
    public $category;

    //### khai báo biến category kiểm tra repo và relation liên quan model
    private $category_repo;
    public $relations = [];
    public $relationsOpt = [];
    public $relationsCate = [];
    public $pagination = true;

    public function __construct(Request $request, AlbumRepository $albumRepo, PostRepository $postRepo, ProductRepository $productRepo, UserRepository $userRepo, ProductOptionRepository $productOptRepo, CategoryRepository $categoryRepo, BrandRepository $brandRepo, ColorRepository $colorRepo, GalleryRepository $galleryRepo, PhotoRepository $photoRepo, SizeRepository $sizeRepo, StaticPostRepository $staticRepo, TagRepository $tagRepo, NewsletterRepository $newsletterRepo, ContactRepository $contactRepo, SeoPageRepository $seopageRepo, SettingRepository $settingRepo, SaleRepository $saleRepo, SaleProductRepository $saleProductRepo, QuestionRepository $questionRepo, CouponRepository $couponRepo, InventoryRepository $inventoryRepo, DanhgiaRepository $danhgiaRepo)
    {
        //LazadaPlatformAPI $lazada_api,

        //### Khởi tạo dữ liệu chung: folder app/Traits/...
        $this->init($request);
        $this->lang = LaravelLocalization::getCurrentLocale();

        //### thiết lập category repo
        $this->category_repo = $request->category;
        $this->request_main = $request->request;

        //### lấy giá trị repo
        $this->albumRepo = $albumRepo;
        $this->postRepo = $postRepo;
        $this->productRepo = $productRepo;
        $this->userRepo = $userRepo;
        $this->productOptRepo = $productOptRepo;
        $this->categoryRepo = $categoryRepo;

        $this->brandRepo = $brandRepo;
        $this->colorRepo = $colorRepo;
        $this->galleryRepo = $galleryRepo;
        $this->photoRepo = $photoRepo;
        $this->sizeRepo = $sizeRepo;

        $this->staticRepo = $staticRepo;
        $this->tagRepo = $tagRepo;
        $this->newsletterRepo = $newsletterRepo;
        $this->contactRepo = $contactRepo;
        $this->seopageRepo = $seopageRepo;
        $this->settingRepo = $settingRepo;
        $this->saleRepo = $saleRepo;
        $this->saleProductRepo = $saleProductRepo;

        $this->questionRepo = $questionRepo;
        $this->couponRepo = $couponRepo;

        //$this->lazada_api = $lazada_api;
        $this->inventoryRepo = $inventoryRepo;
        $this->danhgiaRepo = $danhgiaRepo;

        //### check lock page
        if (config('config_all.lockpage')==true && ($request->getPathInfo()!='/view' || $request->getPathInfo()=='/gio-hang')) {
            //dd(view('welcome'));
            //return redirect()->route('error.show', ['lock']);
            return view('welcome');
        }


        //### check prefix
        $prefix_tmp = $request->route()->getPrefix();
        $prefix_tmp = explode('/', $prefix_tmp);
        if ($prefix_tmp[0]=='admin' && $prefix_tmp[1]!='inform') {
            $this->lazada_api = new LazadaPlatformAPI();
        }
    }
}
