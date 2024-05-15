<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Exports\LazadaSycnExport;
use App\Imports\LazadaSycnImport;

use App\Exports\LazadaInventoryExport;
use App\Imports\LazadaInventoryImport;

use Maatwebsite\Excel\Facades\Excel;

use App\Http\Traits\SupportTrait;

use Helper;

class LazadaController extends Controller
{
    //
    use SupportTrait;
    private $type, $table, $config, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $page_error, $permissionExport, $permissionImport;
    private $routeShow = 'admin.lazada.show';
    private $routeEdit = 'admin.lazada.edit';
    private $viewShow = 'admin.templates.lazada.man'; // admin/templates/color/man/color.blade.php
    private $viewEdit = 'admin.templates.lazada.edit'; // admin/templates/color/man/color_add.blade.php
    private $viewShowInventory = 'admin.templates.lazada.inventory'; // admin/templates/color/man/color.blade.php
    private $folder = "file";
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        $this->category = $request->category;
        $this->type = $request->type;
        $this->config = config('config_type.contact');
        $this->page_error = redirect()->route('admin.dashboard');
        $this->permissionShow = 'lazada_man_'.$this->type;
        $this->permissionAdd = 'lazada_add_'.$this->type;
        $this->permissionEdit = 'lazada_edit_'.$this->type;
        $this->permissionDelete = 'lazada_delete_'.$this->type;
        $this->permissionImport = 'lazada_import_'.$this->type;
        $this->permissionExport = 'lazada_export_'.$this->type; 
    }


    /*
    |--------------------------------------------------------------------------
    | Hiển thị danh sách dữ liệu : tags
    |--------------------------------------------------------------------------
    */
    public function Show(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);


        //### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }


        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $params = array();
        $params['keyword'] = ($request->keyword) ? $request->keyword : '';


        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'type'=> $type,
            'config'=>$this->config
        );
        return view($this->viewShow)->with($response);
    }



    /*
    |--------------------------------------------------------------------------
    | Hiển thị lịch sử nhập kho
    |--------------------------------------------------------------------------
    */
    public function inventory(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $params = array();
        if($request->keyword){$params['maphieu'] = $request->keyword; }

        $items_inventory = $this->inventoryRepo->GetAllItems($type, $params, null, true);
        $other_title = ($type=='nhapkho') ? 'Quản lý nhập kho' : 'Quản lý xuất kho';

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'type'=> $type,
            'config'=>$this->config,
            'items_inventory' => $items_inventory,
            'other_title' => $other_title
        );
        return view($this->viewShowInventory)->with($response);
    }



    /*
    |--------------------------------------------------------------------------
    | Hiển thị lịch sử nhập kho
    |--------------------------------------------------------------------------
    */
    public function EditInventory(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $type = $request->type;
        $id = $request->id;
        $params = array();
        $row_inventory = $this->inventoryRepo->GetOneItem($id, ['HasInventoryDetail']);
        
        $row_inventoryDetail = $row_inventory['has_inventory_detail'];

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'type'=> $type,
            'items' => $row_inventoryDetail
        );
        return view($this->viewEdit)->with($response);
    }



    /*
    |--------------------------------------------------------------------------
    | Hiển thị lịch sử nhập kho
    |--------------------------------------------------------------------------
    */
    public function Save(Request $request){

    }


    /*
    |--------------------------------------------------------------------------
    | Nhập file excel đồng bộ
    |--------------------------------------------------------------------------
    */
    public function Import(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionImport)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $type = $request->type;

        $result = $this->lazada_api->getListProduct_Lazada();
        if($result['code']==0){
            $data_lazada = $result['data']['products'];

            foreach($data_lazada as $k=>$v){
                $skus = $v['skus'];

                foreach($skus as $op=>$option){                    
                    $rowPro = $this->productOptRepo->GetItem(['masp'=>$option['SellerSku']]);
                    

                    if($rowPro){
                        $data['item_id_lazada'] = $v['item_id'];
                        $data['sku_id_lazada'] = $option['SkuId'];
                        $data['soluong'] = $option['quantity'];
                        $this->productOptRepo->SaveItem($data,$rowPro['id']);
                    }/*else{
                        $rowPro = $this->product->GetItem(['masp'=>$option['SellerSku']]);
                        if($rowPro){
                            $data['item_id_lazada'] = $v['item_id'];
                            $data['sku_id_lazada'] = $option['SkuId'];
                            $data['soluong'] = $option['quantity'];
                            $this->product->SaveItem($data,$rowPro['id']);
                        }
                    }*/
                }
            }
        }
        

        /*if($request->hasFile('file')){
            $import = Excel::import(new LazadaSycnImport($request), request()->file('file'));
            $request->session()->flash('alertSuccess', 'Đồng bộ dữ liệu thành công !');            
        }else{
            $request->session()->flash('alert', 'Hệ thống báo lỗi: bạn chưa chọn file !');            
        }*/
        $request->session()->flash('alertSuccess', 'Đồng bộ dữ liệu thành công !');   
        return redirect()->route('admin.lazada.show', ['man', $type]);
        
    }


    /*
    |--------------------------------------------------------------------------
    | Xuất file mẫu đồng bộ
    |--------------------------------------------------------------------------
    */
    public function Export(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionExport)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $category = $request->category;
        $params = array();
        $params['listid'] = ($request->listid) ? $request->listid : '';
        $params['type'] = ($request->type) ? $request->type : '';
        //dd($params);

        return Excel::download(new LazadaSycnExport($params,$category), 'file_dongbo_lazada_'.time().'.xlsx');

        
    }


    /*
    |--------------------------------------------------------------------------
    | Nhập file excel đồng bộ
    |--------------------------------------------------------------------------
    */
    public function InventoryImport(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionImport)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $type = $request->type;

        if($request->hasFile('file')){
            $import = Excel::import(new LazadaInventoryImport($request), request()->file('file'));
            $request->session()->flash('alertSuccess', 'Cập nhật số lượng sản phẩm thành công !');
        }else{
            $request->session()->flash('alert', 'Hệ thống báo lỗi: bạn chưa chọn file !');
        }

        return redirect()->route('admin.lazada.inventory', ['man', $type]);
        
    }


    /*
    |--------------------------------------------------------------------------
    | Xuất file mẫu đồng bộ
    |--------------------------------------------------------------------------
    */
    public function InventoryExport(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionExport)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $category = $request->category;
        $params = array();
        $params['listid'] = ($request->listid) ? $request->listid : '';
        $params['type'] = ($request->type) ? $request->type : '';
        //dd($params);

        return Excel::download(new LazadaInventoryExport($params,$category), 'file_inventory_lazada_'.time().'.xlsx');
    }
    
}
