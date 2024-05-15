<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Http\Traits\SupportTrait;
// use App\Transpost\DeliveryAPI;

use App\Models\Menu;
use App\Models\Product;

use Helper;
use DB;

class SaleController extends Controller
{
    use SupportTrait;
    private $config;
    private $permissionDelete;
    private $viewShow;
    private $folder_upload;
    private $folder = "user";
    private $routeShow = 'admin.sale.show';
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";


    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    |
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request)
    {
        $this->config = config('config_type.sale');
        $this->type = $request->type;
        $this->folder_upload = config('config_upload.UPLOAD_USER');

        $this->viewShow = 'admin.templates.sale';
        $this->page_error = redirect()->back();
        $this->permissionEdit = 'sale_capnhat_'.$this->type;
        $this->permissionDelete = 'sale_delete_'.$this->type;
    }


    // Hiển thị thông tin setting
    public function index(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;

        //dd(env('MAIL_PORT'));

        //### Code xử lý...
        $rowItem = $this->saleRepo->GetItem(['type'=>$type]);
        $ids = $this->saleProductRepo->GetAllItemsByParamsPluck('product_id', ["sale_id" => $rowItem["id"]]);
        $saleProducts = DB::table('sale_products')
            ->join('product', 'sale_products.product_id', '=', 'product.id')
            ->select('product.*', 'sale_products.id as sale_product_id', 'sale_products.giamoi as sale_product_giamoi', 'sale_products.giakm as sale_product_giakm')
            ->get();
        $products = Product::select("*")
            ->where('draft', 0)
            ->whereNotIn('id', $ids)
            ->get();
        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'products'=>$products,
            'saleProducts'=>$saleProducts,
            'rowItem'=>$rowItem,
            'type'=> $type,
            'config'=>$this->config,
            'folder_upload'=>$this->folder,
        );

        return view($this->viewShow)->with($response);
    }


    // Cập nhật thông tin setting
    public function save(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if (!$this->IsPermission($this->permissionEdit)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $idgoi = $request->idgoi;
        $giamoigoi = $request->giamoigoi;
        $giakmgoi = $request->giakmgoi;
        $idgoi2 = $request->idgoi2;
        $giamoigoi2 = $request->giamoigoi2;
        $giakmgoi2 = $request->giakmgoi2;
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;

        $data = $request->data;
        $data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;
        $data['type'] = $type;

        if ($data) {
            foreach ($data as $column => $value) {
                $data[$column] = $value;
            }
        }

        //### Code xử lý...
        $row = $this->saleRepo->SaveItem($data, $id);
        if ($idgoi) {
            foreach ($idgoi as $kgoi => $vgoi) {
                $dataGoi = [];
                $id_idgoi = null;

                $dataGoi['sale_giamoi'] = (isset($giamoigoi[$kgoi]) && $giamoigoi[$kgoi] != '') ? str_replace(",", "", $giamoigoi[$kgoi]) : 0;
                $dataGoi['sale_giakm'] = (isset($giakmgoi[$kgoi]) && $giakmgoi[$kgoi] != '') ? str_replace(",", "", $giakmgoi[$kgoi]) : 0;
                $id_idgoi = $vgoi;
                $this->productRepo->SaveItem($dataGoi, $id_idgoi);
            }
        }

        if ($idgoi2) {
            foreach ($idgoi2 as $kgoi => $vgoi) {
                $dataGoi = [];
                $id_idgoi = null;

                $dataGoi['sale_giamoi'] = (isset($giamoigoi2[$kgoi]) && $giamoigoi2[$kgoi] != '') ? str_replace(",", "", $giamoigoi2[$kgoi]) : 0;
                $dataGoi['sale_giakm'] = (isset($giakmgoi2[$kgoi]) && $giakmgoi2[$kgoi] != '') ? str_replace(",", "", $giakmgoi2[$kgoi]) : 0;
                $id_idgoi = $vgoi;
                $this->productOptRepo->SaveItem($dataGoi, $id_idgoi);
            }
        }


        //### Hiển thị giao diện
        return redirect()->route($this->routeShow, [$category, $type]);
    }

    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function deleteProduct(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);


        //### check auth permission
        if (!$this->IsPermission($this->permissionDelete)) {
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $type = $request->type;
        $id = $request->id;

        if ($id) {
            $this->saleProductRepo->DeleteOneItem($id);
            return redirect()->route($this->routeShow, [$category,$type]);
        }
    }
}
