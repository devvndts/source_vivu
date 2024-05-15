<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Webhook;

use App\Exports\OrderExport;
use App\Exports\OrderFilterExport;
use App\Imports\OrderImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Transpost\DeliveryAPI;

use Helper, CartHelper;

class OrderController extends Controller
{
    use SupportTrait;
    private $type, $table, $viewShow, $viewEdit, $model, $config, $gallery, $permissionShow, $permissionAdd, $permissionEdit, $permissionDelete, $permissionExport, $permissionImport, $page_error, $other_title, $order_status, $orderDetail, $viewImport;
    private $routeShow = 'admin.order.show';
    private $routeEdit = 'admin.order.edit';
    private $routeCreate = 'admin.order.create';
    private $alert = "Hệ thống báo lỗi : Bạn không có quyền truy cập !";
    private $transpost;


    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        $this->category = $request->category;
        $this->model = new Order();
        $this->orderDetail = new OrderDetail();
        $this->webHook = new Webhook();
        $this->page_error = redirect()->back();
        $this->type = '';
        $this->folder = 'product';
        $this->order_status = config('config_all.order_status');

        $this->viewShow = 'admin.templates.order.man';
        $this->viewEdit = 'admin.templates.order.add';
        $this->viewCreate = 'admin.templates.order.create';
        $this->viewImport = 'admin.templates.order.import';

        $this->permissionShow = 'order_man';
        $this->permissionAdd = 'order_create';
        $this->permissionEdit = 'order_edit';
        $this->permissionDelete = 'order_delete';
        $this->permissionExport = 'order_export';
        $this->permissionImport = 'import_export';
        $this->other_title = "Quản lý đơn hàng";
    }

    /*public function UpdateTime(){
        $all = Order::get();
        foreach($all as $k=>$v){
            $this->model->SaveProduct(['created_at'=>date('Y-m-d h:i:s', $v->ngaytao)],$v->id);
        }
    }*/


    /*
    |--------------------------------------------------------------------------
    | Hiển thị danh sách dữ liệu tương ứng với category
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
        $params = array();
        $params['keyword'] = ($request->keyword) ? $request->keyword : '';
        $params['tinhtrang'] = ($request->tinhtrang) ? $request->tinhtrang : '';
        $params['channel'] = ($request->channel) ? $request->channel : '';
        $params['city'] = ($request->city) ? $request->city : '';
        $params['district'] = ($request->district) ? $request->district : '';
        $params['wards'] = ($request->wards) ? $request->wards : '';
        $params['httt'] = ($request->httt) ? $request->httt : '';
        $params['ngaydat'] = ($request->ngaydat) ? $request->ngaydat : '';
        $params['khoanggia'] = ($request->khoanggia) ? $request->khoanggia : '';

        //### Code xử lý...
        $itemShow = $this->model->GetAllItems($params);
        $itemCountOrder = $this->model->GetItemsCount($request->query);

        $query_str = Helper::SetQuery($request->query);

        if((int)@$itemCountOrder['giamin']>0) $minTotal = $itemCountOrder['giamin'];
        else $minTotal = 0;

        if((int)@$itemCountOrder['giamax']>0) $maxTotal = $itemCountOrder['giamax'];
        else $maxTotal = 0;


        $giatu = $giaden = 0;
        if($request->khoanggia){
            $khoanggia = $request->khoanggia;
            $khoanggia = explode(";",$khoanggia);
            $giatu = trim($khoanggia[0]);
            $giaden = trim($khoanggia[1]);
        }

        //chart
        $chart = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 250])
        ->labels(['('.@$itemCountOrder['allMoidat'].') ' . __('Mới đặt'), '('.@$itemCountOrder['allDaxacnhan'].') ' . __('Đã xác nhận'), '('.@$itemCountOrder['allDanggiao'].') ' . __('Đang giao'), '('.@$itemCountOrder['allDangchuyenhoan'].') ' . __('Đang chuyển hoàn'), '('.@$itemCountOrder['allDachuyenhoan'].') ' . __('Đã chuyển hoàn'), '('.@$itemCountOrder['allDagiao'].') ' . __('Đã giao'), '('.@$itemCountOrder['allDahuy'].') ' . __('Đã hủy')])
        ->datasets([
            [
                'backgroundColor' => ['#007bff', '#17a2b8', '#ffc107', '#dc3545', '#28a745', '#26b99a', '#6c757d'],
                //'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                'data' => [@$itemCountOrder['allMoidat'], @$itemCountOrder['allDaxacnhan'], @$itemCountOrder['allDanggiao'], @$itemCountOrder['allDangchuyenhoan'], @$itemCountOrder['allDachuyenhoan'], @$itemCountOrder['allDagiao'], @$itemCountOrder['allDahuy']]
            ]
        ])
        ->options([]);


        //### lấy ds hình thức thanh toán
        $hinhthucthanhtoan = $this->postRepo->GetAllItems('hinh-thuc-thanh-toan',['hienthi'=>1]);


        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'itemShow'=> $itemShow,
            'config'=>$this->config,
            'type'=>$this->type,
            'other_title'=>$this->other_title,
            'order_status'=>$this->order_status,
            'itemCountOrder'=>$itemCountOrder,
            'query_str'=>$query_str,
            'minTotal'=>$minTotal,
            'maxTotal'=>$maxTotal,
            'giatu'=>$giatu,
            'giaden'=>$giaden,
            'request'=>$request,
            'chart' => $chart,
            'hinhthucthanhtoan' => $hinhthucthanhtoan
        );
        return view($this->viewShow)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Hiển thị trang thêm - chỉnh sửa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Edit(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $id = $request->id;
        //### Code xử lý...
        $rowItem = $this->model->GetOneItem($id);
        $ordersDetail = $this->orderDetail->GetAllItemsByIdParent($id);
        // $ordersTransport = $this->webHook->GetAllItemsByIdParent($id);
        //### lấy ds hình thức thanh toán
        $hinhthucthanhtoan = $this->postRepo->GetItem(['id'=>$rowItem['httt']]);

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'rowItem'=> $rowItem,
            'folder_upload'=>$this->folder,
            'type'=>$this->type,
            'other_title'=>$this->other_title,
            'order_status'=>$this->order_status,
            'ordersDetail'=>$ordersDetail,
            'ordersTransport'=>null,
            'hinhthucthanhtoan' => $hinhthucthanhtoan
        );
        return view($this->viewEdit)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Delete(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionDelete)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $id = $request->id;
        $arr_product = array();

        //### Cập nhật số lượng sản phẩm khi xóa đơn hàng
        if($id && (config('config_all.order.soluong') || config('lazada.active'))){
            $row_order = $this->model->GetOneItem($id);
            if($row_order['tinhtrang']!='5' && $row_order['tinhtrang']!='7'){
                $row_details = $this->orderDetail->GetAllItems(['id_order'=>$id]);
                foreach($row_details as $k=>$v){
                    if($v['table_name']=='product_option'){
                        $id_product = $v['id_option'];
                        $row = $this->productOptRepo->GetOneItem($id_product);
                        $data['soluong_website'] = $row['soluong_website'] + $v['soluong'];
                        $result_product = $this->productOptRepo->SaveItem($data,$id_product);
                    }else{
                        $id_product = $v['id_product'];
                        $row = $this->productRepo->GetOneItem($id_product);
                        $data['soluong_website'] = $row['soluong_website'] + $v['soluong'];
                        $result_product = $this->productRepo->SaveItem($data,$id_product);
                    }
                    $arr_product[] = $result_product->toArray();
                }
            }
        }

        ///### Đồng bộ cập nhật số lượng sản phẩm trên lazada
        if($arr_product){
            //$row_lazada = $this->lazada_api->updateQCProduct_Lazada($arr_product);
        }

        $this->model->DeleteTMPOneItem($id);

        return redirect()->route($this->routeShow,[$category]);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa nhiều dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function DeleteAll(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionDelete)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $id = $request->id;
        $listid = $request->listid;
        $arr_product = array();

        if($listid!=''){

            //### Cập nhật số lượng sản phẩm khi xóa đơn hàng
            $ids = explode(',',$listid);
            if($ids && (config('config_all.order.soluong') || config('lazada.active'))){
                foreach($ids as $i=>$id){
                    $row_order = $this->model->GetOneItem($id);
                    if($row_order['tinhtrang']!='5' && $row_order['tinhtrang']!='7'){
                        $row_details = $this->orderDetail->GetAllItems(['id_order'=>$id]);
                        foreach($row_details as $k=>$v){
                            if($v['table_name']=='product_option'){
                                $id_product = $v['id_option'];
                                $row = $this->productOptRepo->GetOneItem($id_product);
                                $data['soluong_website'] = $row['soluong_website'] + $v['soluong'];
                                $result_product = $this->productOptRepo->SaveItem($data,$id_product);
                            }else{
                                $id_product = $v['id_product'];
                                $row = $this->productRepo->GetOneItem($id_product);
                                $data['soluong_website'] = $row['soluong_website'] + $v['soluong'];
                                $result_product = $this->productRepo->SaveItem($data,$id_product);
                            }
                            $arr_product[] = $result_product->toArray();
                        }
                    }
                }
                ///### Đồng bộ cập nhật số lượng sản phẩm trên lazada
                if($arr_product){
                    //$row_lazada = $this->lazada_api->updateQCProduct_Lazada($arr_product);
                }              
            }

            $this->model->DeleteTMPMultiItem($listid);
        }

        return redirect()->route($this->routeShow,[$category]);
    }


    /*
    |--------------------------------------------------------------------------
    | Lưu mới - cập nhật 1 dòng dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Save(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $id = $request->id;
        $savehere = ($request->has('savehere'))?true:false;

        //### check auth permission
        if($id){
            if(!$this->IsPermission($this->permissionEdit)){
                $request->session()->flash('alert', $this->alert);
                return $this->page_error;
            }
        }else{
            if(!$this->IsPermission($this->permissionAdd)){
                $request->session()->flash('alert', $this->alert);
                return $this->page_error;
            }
        }

        $data = $request->data;
        //$data['hienthi'] = (isset($data['hienthi'])) ? 1 : 0;
        if(!$id){
            $data['ngaytao'] = time();
        }
        $data['phiship'] = (isset($data['phiship']) && $data['phiship'] != '') ? str_replace(",","",$data['phiship']) : 0;


        //### xử lý cập nhật số lượng sản phẩm khi cập nhật trạng thái đơn hàng là 'hủy(5)' - 'đã chuyển hoàn(7)'
        if($id){
            $this->UpdateProductCount($id,$data);
        }


        //### Code xử lý...
        $row = $this->model->SaveProduct($data,$id);


        //### Hiển thị giao diện
        if($savehere){
            return redirect()->route($this->routeEdit,[$category,$row->id]);
        }else{
            return redirect()->route($this->routeShow,[$category]);
        }
    }


    private function UpdateProductCount($id,$data=''){
        $row_order = $this->model->GetOneItem($id);
        if($row_order['tinhtrang']!='5' && $row_order['tinhtrang']!='7' && ($data['tinhtrang']=='5' || $data['tinhtrang']=='7')){

            $row_details = $this->orderDetail->GetAllItems(['id_order'=>$id]);
            foreach($row_details as $k=>$v){
                if($v['table_name']=='product_option'){
                    $id_product = $v['id_option'];
                    $row = $this->productOptRepo->GetOneItem($id_product);
                    $data['soluong_website'] = $row['soluong_website'] + $v['soluong'];
                    $this->productOptRepo->SaveItem($data,$id_product);
                }else{
                    $id_product = $v['id_product'];
                    $row = $this->productRepo->GetOneItem($id_product);
                    $data['soluong_website'] = $row['soluong_website'] + $v['soluong'];
                    $this->productRepo->SaveItem($data,$id_product);
                }
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Tạo đơn
    |--------------------------------------------------------------------------
    */
    public function Create(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionAdd)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $arr_childCategory = array();

        //### Code xử lý: lấy category     
        $type = 'product';   
        $row_category = ($request->id_category) ? $this->categoryRepo->GetOneItem($request->id_category,$this->relationsCate) : null; 
        $category = array(
            'id' => ($row_category) ? $row_category['id'] : 0,
            'id_parent' => ($row_category) ? $row_category['id'] : 0,
            'tenvi' => ($row_category) ? $row_category['tenvi'] : '',
            'tenvi_parent' => ($row_category) ? $row_category['tenvi'] : ''
        );
        $danhmucparent = $this->categoryRepo->GetAll($type);
        if($request->id_category){
            array_push($arr_childCategory, (int)$request->id_category);
            $arr_childCategory = array_merge($arr_childCategory, $this->categoryRepo->GetChildCategory($type,$request->id_category));
        }

        //### lấy ds hình thức thanh toán
        $hinhthucthanhtoan = $this->postRepo->GetAllItems('hinh-thuc-thanh-toan',['hienthi'=>1]);

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'type'=>$this->type,
            'other_title'=>'Tạo đơn hàng',
            'order_status'=>$this->order_status,
            'category' => $category,
            'danhmucparent' => $danhmucparent,
            'hinhthucthanhtoan' => $hinhthucthanhtoan
        );
        return view($this->viewCreate)->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Lưu Tạo đơn
    |--------------------------------------------------------------------------
    */
    public function SaveCreate(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionAdd)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Thiết lập giá trị thuộc tính
        $category = $request->category;
        $id = $request->id;
        $data = $request->data;

        //### Code xử lý...
        $data['city'] = $data['id_city'];
        $data['district'] = $data['id_district'];
        $data['wards'] = $data['id_wards'];
        $data['diachi'] = $data['diachi'].', '.Helper::GetPlace("ward", $data['id_wards']).', '.Helper::GetPlace("district", $data['id_district']).', '.Helper::GetPlace("city", $data['id_city']);
        $data['phiship'] = $ship = (isset($data['phiship']) && $data['phiship'] != '') ? str_replace(",","",$data['phiship']) : 0;
        $data['giamgia'] = $giamgia = (isset($data['giamgia']) && $data['giamgia'] != '') ? str_replace(",","",$data['giamgia']) : 0;
        $data['ngaytao'] = time();
        $data['hienthi'] = 1;
        $data['tinhtrang'] = 1;
        $data['tonggia'] = $data['tamtinh'] + $data['phiship'] - $data['giamgia'];
        $data['stt'] = 1;

        unset($data['id_list']);
        unset($data['id_cat']);
        unset($data['id_item']);
        unset($data['id_sub']);
        unset($data['id_city']);
        unset($data['id_district']);
        unset($data['id_wards']);


        $row = $this->model->SaveProduct($data,$id);
        if($row){
            $id_insert = $row->id;
            foreach ($request->product as $key => $value) {
                $idp[$key]=(int)$value;
                $giaban[$key]=(int)$request->giaban[$key];
                $arr_size[$key]=(int)$request->size[$key];
                $arr_color[$key]=(int)$request->mau[$key];
                $arr_sl[$key]=(int)$request->quantity[$key];
                $arr_code[$key]=$request->code[$key];

                $id = $idp[$key];
                $quantity = $arr_sl[$key];
                $size=$arr_size[$key];
                $color=$arr_color[$key];
                $code = $arr_code[$key];

                $proinfo=CartHelper::get_product_info($id,$size,$color);
                $gia = $proinfo['gia'];
                $giamoi = $proinfo['giamoi'];
                $giacu = $proinfo['giacu'];
                $masp = $proinfo['masp'];

                //set cotheban_tmp theo table
                $pro_table = $proinfo['table'];
                $pro_cotheban = $proinfo['cotheban_tmp'] - $quantity;
                $pro_id = $proinfo['id'];
                $pro_idoption = (isset($proinfo['id_option']))?$proinfo['id_option']:0;
                //### END set cotheban_tmp theo table

                $data_donhangchitiet = array();
                $data_donhangchitiet['id_product'] = $id;
                $data_donhangchitiet['id_order'] = $id_insert;
                $data_donhangchitiet['photo'] = $proinfo['photo'];
                $data_donhangchitiet['ten'] = $proinfo['tenvi'];
                $data_donhangchitiet['code'] = $code;
                $data_donhangchitiet['mau'] = CartHelper::get_mau_info($color)['tenvi'];
                $data_donhangchitiet['masp'] = $masp;
                $data_donhangchitiet['size'] = CartHelper::get_size_info($size)['tenvi'];
                $data_donhangchitiet['gia'] = $gia;
                $data_donhangchitiet['giacu'] = $giacu;
                $data_donhangchitiet['giamoi'] = $giamoi;
                $data_donhangchitiet['soluong'] = $quantity;
                $this->orderDetail->SaveProduct($data_donhangchitiet);
            }
        }

        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'type'=>$this->type,
            'other_title'=>'Tạo đơn hàng',
            'order_status'=>$this->order_status,
        );

        //### Hiển thị giao diện
        return redirect()->route($this->routeShow,[$category]);
    }


    /*
    |--------------------------------------------------------------------------
    | Xuất excel tất cả đơn hàng
    |--------------------------------------------------------------------------
    */
    public function ExportAllItems(Request $request)
    {
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### check auth permission
        if(!$this->IsPermission($this->permissionExport)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $loaifilexuat = ($request->loaifilexuat)?$request->loaifilexuat:0;

        $params = array();
        $params['listid'] = ($request->listid) ? $request->listid : '';
        $params['tinhtrang'] = ($request->tinhtrang) ? $request->tinhtrang : '';
        $params['httt'] = ($request->httt) ? $request->httt : '';
        $params['channel'] = ($request->channel) ? $request->channel : '';
        $params['ngaydat'] = ($request->ngaydat) ? $request->ngaydat : '';
        $params['khoanggia'] = ($request->khoanggia) ? $request->khoanggia : '';
        $params['city'] = ($request->city) ? $request->city : '';
        $params['district'] = ($request->district) ? $request->district : '';
        $params['wards'] = ($request->wards) ? $request->wards : '';
        $params['keyword'] = ($request->keyword) ? $request->keyword : '';
        $year = date('Y',time());

        if($loaifilexuat==0){
            return Excel::download(new OrderExport($params,$year), 'danhsach_donhang_'.time().'.xlsx');
        }else{
            return Excel::download(new OrderFilterExport($params), 'danhsach_donhang_'.time().'.xlsx');
        }
    }


    /*
    |--------------------------------------------------------------------------
    | In đơn hàng
    |--------------------------------------------------------------------------
    */
    public function Print(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);
        
        //### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $id = $request->id;
        $result = $this->model->GetOneItem($id);
        $result_ctdonhang = $this->orderDetail->GetAllItemsByIdParent($id);

        //### Trả về giao diện
        $settingOption = $this->GetSettingOption();
        $logo = app('logo');


        //### Trả về giao diện
        $response = array(
            'request'=>$request,
            'result' => $result,
            'result_ctdonhang' => $result_ctdonhang,
            'settingOption' => $settingOption,
            'logo' => url('/').'/'.config('config_upload.UPLOAD_PHOTO').$logo['photo']
        );

        //### Hiển thị giao diện
        return view('admin.templates.order.print')->with($response);
    }



    /*
    |--------------------------------------------------------------------------
    | In đơn hàng
    |--------------------------------------------------------------------------
    */
    public function SendBill(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);        
        $this->transpost = new DeliveryAPI();


        //### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }


        //### xử lý đơn hàng
        $category = $request->category;
        $id = $request->id;
        $result = $this->model->GetOneItem($id);
        $result_ctdonhang = $result['has_order_detail_all'];
        $transport_type = $result['method_delivery'];

        if($result && !$result['is_vandon']){
            switch ($transport_type) {
                case 'ViettelPost':
                    //### lấy thông tin data post
                    $data = $this->getDataViettelPost($result);
                    $result_vandon = $this->transpost->createOrderViettelPost($data);
                    //dd($data);
                    if($result_vandon && $result_vandon['status']==200){
                        $this->updateViettelPostOrder($id,$transport_type,$result_vandon['data']);
                    }
                break;
            }
        }

        return redirect()->route($this->routeShow,[$category]);
    }


    /*
    |--------------------------------------------------------------------------
    | Hủy đơn hàng
    |--------------------------------------------------------------------------
    */
    public function CancelBill(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);
        $this->transpost = new DeliveryAPI();


        //### check auth permission
        if(!$this->IsPermission($this->permissionShow)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        $category = $request->category;
        $id = $request->id;


        //### xử lý hủy vận hàng
        $result = $this->model->GetOneItem($id);
        $transport_type = $result['method_delivery'];

        if($result['is_vandon']==1){
            switch ($transport_type){
                case 'ViettelPost':
                    //### hủy vận đơn
                    $data['TYPE'] = 4;
                    $data['ORDER_NUMBER'] = $result['mavandon'];
                    $data['NOTE'] = 'Hủy đơn hàng';
                    $result_vandon = $this->transpost->updateOrderViettelPost($data);

                    //### cập nhật đơn hàng (trạng thái vận đơn của đơn hàng)
                    if($result_vandon['status']==200){
                        $data_update['cancel_vandon'] = 1; //## đã hủy vận đơn thành công
                        $this->model->SaveProduct($data_update,$id);
                    }
                    
                break;
            }
        }

        return redirect()->route($this->routeShow,[$category]);
    }



    private function updateViettelPostOrder($id,$transport_type,$result_vandon){
        switch ($transport_type) {
            case 'ViettelPost':
                //### xử lý cập nhật mã vận đơn
                $data['is_vandon'] = 1; 
                $data['mavandon'] = $result_vandon['ORDER_NUMBER'];
            break;
        }

        $this->model->SaveProduct($data,$id);
    }



    private function getDataViettelPost($result){
        if($result && !$result['is_vandon']){
            //### lấy thông tin kho hàng
            $inventory = $this->transpost->getListInventoryViettelPost();
            $inventory = $inventory['data'][0];
            $setting = app('setting');
            $settingOption = json_decode($setting['options'], true);
            $config_delivery = config('delivery.transpost_method');
            $info_transport = $config_delivery[$result['method_delivery']];


            $product_name = $product_description = '';
            $quantity = $weight = $length = $width = $height = 0;
            $total_price = $result['tonggia'];
            $chitiet_donhang = $result['has_order_detail_all'];
            $list_item = array();
            //dd($result);
            foreach($chitiet_donhang as $k=>$v){
                /*if($k==0){
                    $product_name = $product_description = $v['ten'];
                }*/
                $table_name = ($v['table_name']=='product_option') ? $v['table_name'] : 'product';
                $id = ($v['id_option']>0) ? $v['id_option'] : $v['id_product'];
                $proinfo = CartHelper::get_product_info_order($table_name,$id);
                $weight += $proinfo['khoiluong'];
                $length += $proinfo['rong'];
                $width += $proinfo['dai'];
                $height += $proinfo['cao'];
                $quantity += $v['soluong'];

                $product_item = array();
                $product_item['PRODUCT_NAME'] = $proinfo['tenvi'];
                $product_item['PRODUCT_PRICE'] = (int)(($proinfo['giamoi']>0) ? $proinfo['giamoi'] : $proinfo['gia']);
                $product_item['PRODUCT_WEIGHT'] = $proinfo['khoiluong'];
                $product_item['PRODUCT_QUANTITY'] = $v['soluong'];

                array_push($list_item, $product_item);
            }
            $orderPayment = 3;//### thu hộ tiền hàng
            if ($result['payment_status'] == 1 || $result['status_payments'] == 1) {
                $orderPayment = 1;//### Uncollect money
            }
            $data = array(
                "ORDER_NUMBER" => $result['madonhang'],
                "GROUPADDRESS_ID" => $inventory['groupaddressId'],
                "CUS_ID" => $inventory['cusId'],
                "DELIVERY_DATE" => date('d/m/Y h:m:s', $result['ngaytao']),
                "SENDER_FULLNAME" => $setting['tenvi'],
                "SENDER_ADDRESS" => $settingOption['diachi'],
                "SENDER_PHONE" => $settingOption['dienthoai'],
                "SENDER_EMAIL" => $settingOption['email'],
                "SENDER_WARD" => $inventory['wardsId'],
                "SENDER_DISTRICT" => $inventory['districtId'],
                "SENDER_PROVINCE" => $inventory['provinceId'],
                "SENDER_LATITUDE" => 0,
                "SENDER_LONGITUDE" => 0,
                "RECEIVER_FULLNAME" => $result['hoten'],
                "RECEIVER_ADDRESS" => $result['diachi'],
                "RECEIVER_PHONE" => $result['dienthoai'],
                "RECEIVER_EMAIL" => $result['email'],
                "RECEIVER_WARD" => $result['wards'],
                "RECEIVER_DISTRICT" => $result['district'],
                "RECEIVER_PROVINCE" => $result['city'],
                "RECEIVER_LATITUDE" => 0,
                "RECEIVER_LONGITUDE" => 0,
                "PRODUCT_NAME" => 'Hàng Hóa',
                "PRODUCT_DESCRIPTION" => '',
                "PRODUCT_QUANTITY" => 1,
                "PRODUCT_PRICE" => (int)$total_price,
                "PRODUCT_WEIGHT" => $weight,
                "PRODUCT_LENGTH" => $length,
                "PRODUCT_WIDTH" => $width,
                "PRODUCT_HEIGHT" => $height,
                "PRODUCT_TYPE" => "HH",
                "ORDER_PAYMENT" => $orderPayment, //### thu hộ tiền hàng
                "ORDER_SERVICE" => $result['option_delivery'],
                "ORDER_SERVICE_ADD" => "",
                "ORDER_VOUCHER" => "",
                "ORDER_NOTE" => "cho xem hàng, không cho thử",
                "MONEY_COLLECTION" => (int)($result['tonggia'] - $result['phiship']),
                "MONEY_TOTALFEE" => 0,
                "MONEY_FEECOD" => 0,
                "MONEY_FEEVAS" => 0,
                "MONEY_FEEINSURANCE" => (int)$result['phibaohiem'],
                "MONEY_FEE" => 0,
                "MONEY_FEEOTHER" => 0,
                "MONEY_TOTALVAT" => 0,
                "MONEY_TOTAL" => 0,
                "LIST_ITEM" => $list_item
            );

            return $data;
        }

        return null;
    }


    /*
    |--------------------------------------------------------------------------
    | Import excel đơn hàng
    |--------------------------------------------------------------------------
    */
    public function ImportBillGet(Request $request){
        //### khởi tạo giá trị cho model
        $this->initialization($request);

        //### gọi get
        if($request->getMethod() == 'GET'){ 
            return view($this->viewImport);
        }

        //### gọi post
        //### check auth permission
        if(!$this->IsPermission($this->permissionImport)){
            $request->session()->flash('alert', $this->alert);
            return $this->page_error;
        }

        //### Xử lý code
        if($request->hasFile('file')){
            $import = Excel::import(new OrderImport($request), request()->file('file'));
            $request->session()->flash('alertSuccess', 'Đồng bộ dữ liệu thành công !');
        }else{
            $request->session()->flash('alert', 'Hệ thống báo lỗi: bạn chưa chọn file !');
        }

        return redirect()->route('admin.order.import', ['man']);
    }

    /*public function ImportBillPost(Request $request){
        
    }*/
}
