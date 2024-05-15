<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Places;

use App\Repositories\Repo\ProductRepository;
use App\Repositories\Repo\ProductOptionRepository;

use Illuminate\Support\Collection;

use Maatwebsite\Excel\Concerns\ToCollection;
//use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Illuminate\Support\Str;
use Helper, CartHelper;

class OrderImport implements ToCollection, WithHeadingRow, WithChunkReading //ToModel,
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    public function __construct($request) {
        $this->format = $request->format;
        $this->order = new Order();
        $this->order_detail = new OrderDetail();
        $this->city = new Places('list');
        $this->district = new Places('cat');
        $this->ward = new Places('item');
        $this->product = new ProductRepository();
        $this->productOption = new ProductOptionRepository();
    }


    /*
    |--------------------------------------------------------------------------
    | Loại bỏ dòng tiêu đề của bảng
    |--------------------------------------------------------------------------
    */
    public function headingRow() : int
    {
        return 1;
    }

    public function collection(Collection $rows)
    {
        if($rows){
            switch ($this->format) {
                case 'lazada':
                    $this->AddOrderLazada($rows);
                    break;
                
                case 'shopee':
                    $this->AddOrderShopee($rows);
                    break;
            }
        }
    }


    //### call add order lazada
    private function AddOrderLazada($rows){
        //dd($rows);
        foreach($rows as $r=>$row){
            $madh           = $row['ordernumber'];
            $ngaytao        = strtotime($row['createtime']);
            $trangthai      = $row['status'];
            $mavandon       = $row['trackingcode'];
            $masp           = trim($row['sellersku']);
            $tensp          = $row['itemname'];
            $gia            = $row['paidprice'];
            $coupon         = (int)$row['sellerdiscounttotal'];
            $phiship        = (int)$row['shippingfee'];
            $httt_txt       = $row['paymethod'];
            $ghichu         = $row['buyerfaileddeliveryreason'];
            $dv_vanchuyen   = '';

            $hoten          = $row['billingname'];
            $sdt            = $row['billingphone'];
            $tinhthanh      = $row['shippingaddress3'];
            $quanhuyen      = $row['shippingaddress4'];
            $xaphuong       = $row['shippingaddress5'];
            $diachi         = $row['shippingaddress'];

            $quanhuyen=Str::replace('Huyện','',$quanhuyen);
            $quanhuyen=Str::replace('Quận','',$quanhuyen);
            $quanhuyen=Str::replace('Thành Phố','',$quanhuyen);
            $quanhuyen=Str::replace('Thị Xã','',$quanhuyen);
            $quanhuyen=Str::replace('Tx','',$quanhuyen);
            $quanhuyen=Str::replace('Tp','',$quanhuyen);


            $xaphuong=Str::replace('Phường','',$xaphuong);
            $xaphuong=Str::replace('Xã','',$xaphuong);
            $xaphuong=Str::replace('Thị Trấn','',$xaphuong);
            $xaphuong=Str::replace('TT','',$xaphuong);


            //### lấy id tỉnh quận xã
            $city = $this->city->where('id_delivery',0)->like('ten',$tinhthanh)->first();
            $city = ($city) ? $city->id : 0;

            $dist = $this->district->where('id_delivery',0)->like('ten',$quanhuyen)->first();
            $dist = ($dist) ? $dist->id : 0;

            $wards = $this->ward->where('id_delivery',0)->like('ten',$xaphuong)->first();
            $wards = ($wards) ? $wards->id : 0;

            //### XỬ LÝ
            if($madh!=''){ 
                $tamtinh=0;
                //### Kiểm tra đơn hàng shopee đã được tạo trước đó chưa ?
                $donhang = $this->order->GetItem(['madonhang_lazada'=>$madh]);

                //### Kiểm tra sản phẩm phiên bản có tồn tại thông qua mã sku phân loại
                $product = $this->productOption->GetItem(['masp'=>$masp]);

                //### Nếu tồn tại đơn hàng
                if($donhang){
                    //### Nếu tồn tại sản phẩm
                    if($product){
                        $mau=(int)$product['id_mau'];
                        $size=(int)$product['id_size'];
                        $table_name = 'product_option';
                        $code = md5($product['id'].$mau.$size);

                        //### Kiểm tra chi tiết đơn hàng đã tồn tại ?
                        $order_d = $this->order_detail->GetItem(['code'=>$code, 'id_order'=>$donhang['id']]);
                        $data_donhangchitiet = array();
                        $data_donhangchitiet['id_product'] = $product['id_product'];
                        $data_donhangchitiet['id_order'] = $donhang['id'];
                        $data_donhangchitiet['photo'] = $product['photo'];
                        $data_donhangchitiet['ten'] = $product['tenvi'];
                        $data_donhangchitiet['code'] = $code;
                        $data_donhangchitiet['mau'] = CartHelper::get_mau_info($mau)['tenvi'];
                        $data_donhangchitiet['size'] = CartHelper::get_size_info($size)['tenvi'];
                        $data_donhangchitiet['masp'] = $product['masp'];
                        $data_donhangchitiet['gia'] = $gia;

                        if(!$order_d){
                            $data_donhangchitiet['soluong'] = 1;
                            $tamtinh = $donhang['tamtinh'] + $gia;
                        }else{
                            if($trangthai!='canceled'){
                                
                            }
                            $tamtinh = $donhang['tamtinh'];
                        }
                        //$data_donhangchitiet['soluong'] = (!$order_d) ? 1 : (($trangthai=='canceled') ? $order_d['soluong'] : $order_d['soluong']+1); //$sl;
                        $data_donhangchitiet['id_option'] = $product['id'];
                        $data_donhangchitiet['table_name'] = $table_name;

                        if(!$order_d){ //### chưa tồn tại ===> thêm vào database
                            $row_insertOrderdetail = $this->order_detail->SaveProduct($data_donhangchitiet);

                            //### Cập nhật lại soluong_lazada của sản phẩm trên website
                            $data_update_product['soluong_lazada'] = $product['soluong_lazada'] - 1;
                            $this->productOption->SaveItem($data_update_product,$product['id']); 
                        }else{
                            $row_insertOrderdetail = $this->order_detail->SaveProduct($data_donhangchitiet,$order_d['id']);
                        }
                    }


                    //### tính phí
                    //$tamtinh = ($trangthai!='canceled') ? $donhang['tamtinh'] + $gia : $donhang['tamtinh'];
                    $chiphikhac=0;//$phicodinh+$phidv+$phitt;
                    $tonggia=$tamtinh-$coupon-$chiphikhac;


                    //### Kiểm tra trạng thái đơn hàng
                    if($trangthai=='canceled'){
                        $tinhtrang=5;
                        $status='Canceled';
                    }else if($trangthai=='delivered'){
                        $tinhtrang=4;
                        $status='Success';
                    }else if($trangthai=='shipped'){
                        $tinhtrang=3;
                        $status='Confirmed';
                    }else if($trangthai=='Chờ giao hàng'){
                        $tinhtrang=2;
                        $status='Confirmed';
                    }else if($trangthai=='Chờ xác nhận'){
                        $tinhtrang=1;
                        $status='New';
                    }else{
                        $tinhtrang=6;
                        $status='Aborted';
                    }


                    //### Kiểm tra hình thức thanh toán
                    if($httt_txt=='COD'){
                        $httt=1;
                    }else if($httt_txt=='Thẻ Tín dụng/Ghi nợ'){
                        $httt=3;
                    }else{
                        $httt=4;
                    }


                    //### Kiểm tra trạng thái thanh toán
                    if($tinhtrang==4){
                        $pay_status=1;
                    }else if($httt==1 && ($tinhtrang==2 || $tinhtrang==3 || $tinhtrang==1)){
                        $pay_status=0;
                    }else if(($httt==3 || $httt==4) && ($tinhtrang==4 ||$tinhtrang==3 ||$tinhtrang==2 ||$tinhtrang==1 )){
                        $pay_status=1;
                    }else{
                        $pay_status=2;
                    }


                    //### Cập nhật lại số lượng shoppe khi đổi trạng thái đơn hàng sang 'hủy'
                    if(($tinhtrang==5 || $tinhtrang==6) && $donhang['tinhtrang']!=5 && $donhang['tinhtrang']!=6){
                        $o_details = $donhang['has_order_detail_all'];
                        foreach($o_details as $od=>$o_detail){
                            $row_product = $this->productOption->GetItem(['id'=>$o_detail['id_option']]);
                            $data_update_product['soluong_lazada'] = $row_product['soluong_lazada'] + $o_detail['soluong'];
                            $this->productOption->SaveItem($data_update_product, $o_detail['id_option']);
                        }
                    }


                    //### Cập nhật thông tin đơn hàng
                    $data_donhang = array();
                    $data_donhang['tamtinh'] = $tamtinh;
                    $data_donhang['tonggia'] = $tonggia;
                    $data_donhang['chiphi_kenhbanhang'] = $chiphikhac;
                    $data_donhang['status_payments'] = $pay_status;
                    $data_donhang['httt'] = $httt;
                    $data_donhang['tinhtrang'] = $tinhtrang;
                    $data_donhang['json_shopee'] = json_encode($row,true);
                    $this->order->SaveProduct($data_donhang,$donhang['id']);

                }else{ //### Nếu ko tồn tại đơn hàng
                    if($trangthai!='canceled'){
                        //### tính phí
                        $tamtinh = $gia;
                        $chiphikhac=0;//$phicodinh+$phidv+$phitt;
                        $tonggia=$tamtinh-$coupon-$chiphikhac;

                        $madonhang = date('ymd').Str::upper(Str::random(6));

                        /*Kiểm tra trạng thái*/
                        if($trangthai=='canceled'){
                            $tinhtrang=5;
                        }else if($trangthai=='delivered'){
                            $tinhtrang=4;
                        }else if($trangthai=='shipped'){
                            $tinhtrang=3;
                        }else if($trangthai=='Chờ giao hàng'){
                            $tinhtrang=2;
                        }else if($trangthai=='Chờ xác nhận'){
                            $tinhtrang=1;
                        }else{
                            $tinhtrang=6;
                        }


                        /*Kiểm tra hình thức thanh toán*/
                        if($httt_txt=='COD'){
                            $httt=1;
                        }else if($httt_txt=='Thẻ Tín dụng/Ghi nợ'){
                            $tinhtrang=3;
                        }else{
                            $tinhtrang=4;
                        }


                        /*Kiểm tra trạng thái thanh toán*/
                        if($tinhtrang==4){
                            $pay_status=1;
                        }else if($httt==1 && ($tinhtrang==2 || $tinhtrang==3 || $tinhtrang==1)){
                            $pay_status=0;
                        }else if(($httt==3 || $httt==4) && ($tinhtrang==4 ||$tinhtrang==3 ||$tinhtrang==2 ||$tinhtrang==1 )){
                            $pay_status=1;
                        }else{
                            $pay_status=2;
                        }


                        $data_donhang = array();
                        $data_donhang['madonhang'] = $madonhang;
                        $data_donhang['madonhang_lazada'] = $madh;
                        $data_donhang['order_code_delivery'] = $mavandon;
                        //$data_donhang['supplier_delivery'] = $dv_vanchuyen;
                        $data_donhang['hoten'] = $hoten;
                        $data_donhang['dienthoai'] = $sdt;
                        $data_donhang['diachi'] = $diachi;
                        $data_donhang['city'] = $city;
                        $data_donhang['district'] = $dist;
                        $data_donhang['wards'] = $wards;
                        $data_donhang['giamgia'] = $coupon;
                        $data_donhang['httt'] = $httt;
                        $data_donhang['phiship'] = 0;
                        $data_donhang['tamtinh'] = $tamtinh;
                        $data_donhang['tonggia'] = $tonggia;
                        //$data_donhang['yeucaukhac'] = $yeucaukhac;
                        $data_donhang['ngaytao'] = $ngaytao;
                        $data_donhang['status_payments'] = $pay_status;
                        $data_donhang['tinhtrang'] = $tinhtrang;
                        $data_donhang['chiphi_kenhbanhang'] = $chiphikhac;
                        $data_donhang['stt'] = 1;
                        $data_donhang['hienthi'] = 1;
                        $data_donhang['channel'] = 3;
                        $data_donhang['json_shopee'] = json_encode($row,true);                        
                        $row_order = $this->order->SaveProduct($data_donhang);

                        //### tạo đơn hàng từ shopee thành công
                        if($row_order){
                            if($product){
                                $mau=(int)$product['id_mau'];
                                $size=(int)$product['id_size'];
                                $tenmau=CartHelper::get_mau_info($mau)['tenvi'];
                                $tensize=CartHelper::get_size_info($size)['tenvi'];
                                $table_name = 'product_option';

                                $code = md5($product['id'].$mau.$size);
                                $data_donhangchitiet = array();
                                $data_donhangchitiet['id_product'] = $product['id_product'];
                                $data_donhangchitiet['id_order'] = $row_order['id'];
                                $data_donhangchitiet['photo'] = $product['photo'];
                                $data_donhangchitiet['ten'] = $product['tenvi'];
                                $data_donhangchitiet['code'] = $code;
                                $data_donhangchitiet['mau'] = $tenmau;
                                $data_donhangchitiet['size'] = $tensize;
                                $data_donhangchitiet['masp'] = $product['masp'];                
                                $data_donhangchitiet['gia'] = $gia;
                                $data_donhangchitiet['soluong'] = 1;
                                $data_donhangchitiet['id_option'] = $product['id'];
                                $data_donhangchitiet['table_name'] = $table_name;
                                $row_insertOrderdetail = $this->order_detail->SaveProduct($data_donhangchitiet);

                                /*if(!$order_d){ //### chưa tồn tại ===> thêm vào database
                                    $row_insertOrderdetail = $this->order_detail->SaveProduct($data_donhangchitiet);
                                }else{
                                    $row_insertOrderdetail = $this->order_detail->SaveProduct($data_donhangchitiet,$order_d['id']);
                                }*/

                                //### Cập nhật lại soluong_shopee của sản phẩm trên website
                                if($row_insertOrderdetail){
                                    $data_update_product['soluong_lazada'] = $product['soluong_lazada'] - 1;
                                    $this->productOption->SaveItem($data_update_product,$product['id']); 
                                }

                                //### Cập nhật lại soluong_shopee của sản phẩm trên website
                                //$data_update_product['soluong_lazada'] = $product['soluong_lazada'] - $sl;
                                //$this->productOption->SaveItem($data_update_product,$product['id']);
                            }
                        }
                    }
                }
            }
        }
    }
  


    //### call add order shopee
    private function AddOrderShopee($rows){
       // dd($rows);
        foreach($rows as $r=>$row){
            //### lấy dữ liệu đơn hàng theo từng dòng
            $madh           = $row['ma_don_hang'];
            $makienhang     = $row['ma_kien_hang'];
            $ngaytao        = strtotime($row['ngay_dat_hang']);
            $trangthai      = $row['trang_thai_don_hang'];
            $ghichu         = $row['ly_do_huy'];
            $yeucaukhac     = $row['nhan_xet_tu_nguoi_mua'];
            $mavandon       = $row['ma_van_don'];
            $dv_vanchuyen   = $row['don_vi_van_chuyen'];
            $masp           = trim($row['sku_san_pham']);
            $tensp          = $row['ten_san_pham'];
            $masp_con       = trim($row['sku_phan_loai_hang']);
            $gia            = $row['gia_goc'];
            $km             = $row['nguoi_ban_tro_gia'];
            $km_shopee      = (int)$row['duoc_shopee_tro_gia'];
            $gia_saukm      = (int)$row['gia_uu_dai'];
            $sl             = (int)$row['so_luong'];
            $tonggia_sp     = $row['tong_gia_ban_san_pham'];
            $tamtinh        = $row['tong_gia_tri_don_hang_vnd'];
            $coupon         = (int)$row['ma_giam_gia_cua_shop'];
            $hoanxu         = $row['hoan_xu'];
            $coupon_shoppe  = (int)$row['ma_giam_gia_cua_shopee'];
            $combo_shopee   = (int)$row['giam_gia_tu_combo_shopee'];
            $combo          = (int)$row['giam_gia_tu_combo_cua_shop'];
            $giamgia_credit = (int)$row['so_tien_duoc_giam_khi_thanh_toan_bang_the_ghi_no'];
            $phiship        = $row['phi_van_chuyen_du_kien'];
            $tongtien       = $row['tong_so_tien_nguoi_mua_thanh_toan'];
            $httt_txt       = $row['phuong_thuc_thanh_toan'];
            $phicodinh      = $row['phi_co_dinh'];
            //$phigiaodich    = $row['phi_giao_dich'];
            $phidv          = $row['phi_dich_vu'];
            $phitt          = $row['phi_thanh_toan'];
            $tienkyquy      = $row['tien_ky_quy'];
            $hoten          = $row['ten_nguoi_nhan'];
            $sdt            = $row['so_dien_thoai'];
            $tinhthanh      = $row['tinhthanh_pho'];
            $quanhuyen      = $row['tp_quan_huyen'];
            $xaphuong       = $row['quan'];
            $diachi         = $row['dia_chi_nhan_hang'];
            $shopghichu     = $row['ghi_chu'];

            $quanhuyen=Str::replace('Huyện','',$quanhuyen);
            $quanhuyen=Str::replace('Quận','',$quanhuyen);
            $quanhuyen=Str::replace('Thành Phố','',$quanhuyen);
            $quanhuyen=Str::replace('Thị Xã','',$quanhuyen);
            $quanhuyen=Str::replace('Tx','',$quanhuyen);
            $quanhuyen=Str::replace('Tp','',$quanhuyen);


            $xaphuong=Str::replace('Phường','',$xaphuong);
            $xaphuong=Str::replace('Xã','',$xaphuong);
            $xaphuong=Str::replace('Thị Trấn','',$xaphuong);
            $xaphuong=Str::replace('TT','',$xaphuong);


            //### lấy id tỉnh quận xã
            $city = $this->city->where('id_delivery',0)->like('ten',$tinhthanh)->first();
            $city = ($city) ? $city->id : 0;

            $dist = $this->district->where('id_delivery',0)->like('ten',$quanhuyen)->first();
            $dist = ($dist) ? $dist->id : 0;

            $wards = $this->ward->where('id_delivery',0)->like('ten',$xaphuong)->first();
            $wards = ($wards) ? $wards->id : 0;

            //### tính phí
            $chiphikhac=$phicodinh+$phidv+$phitt;
            $tonggia=$tamtinh-$coupon-$chiphikhac;
            
            //### XỬ LÝ
            if($madh!=''){ 
                //### Kiểm tra đơn hàng shopee đã được tạo trước đó chưa ?
                $donhang = $this->order->GetItem(['madonhang_shopee'=>$madh]);

                //### Kiểm tra sản phẩm phiên bản có tồn tại thông qua mã sku phân loại
                $product = $this->productOption->GetItem(['masp'=>$masp_con]);


                //### Nếu tồn tại đơn hàng
                if($donhang){
                    //### Nếu tồn tại sản phẩm
                    if($product){
                        $mau=(int)$product['id_mau'];
                        $size=(int)$product['id_size'];
                        $table_name = 'product_option';
                        $code = md5($product['id'].$mau.$size);

                        //### Kiểm tra chi tiết đơn hàng đã tồn tại ?
                        $order_d = $this->order_detail->GetItem(['code'=>$code, 'id_order'=>$donhang['id']]);
                        if(!$order_d){ //### chưa tồn tại ===> thêm vào database
                            $data_donhangchitiet = array();
                            $data_donhangchitiet['id_product'] = $product['id_product'];
                            $data_donhangchitiet['id_order'] = $donhang['id'];
                            $data_donhangchitiet['photo'] = $product['photo'];
                            $data_donhangchitiet['ten'] = $product['tenvi'];
                            $data_donhangchitiet['code'] = $code;
                            $data_donhangchitiet['mau'] = CartHelper::get_mau_info($mau)['tenvi'];
                            $data_donhangchitiet['size'] = CartHelper::get_size_info($size)['tenvi'];
                            $data_donhangchitiet['masp'] = $product['masp'];
                            $data_donhangchitiet['gia'] = $gia_saukm;
                            $data_donhangchitiet['soluong'] = $sl;
                            $data_donhangchitiet['id_option'] = $product['id'];
                            $data_donhangchitiet['table_name'] = $table_name;
                            $row_insertOrderdetail = $this->order_detail->SaveProduct($data_donhangchitiet);

                            //### Cập nhật lại soluong_shopee của sản phẩm trên website
                            $data_update_product['soluong_shopee'] = $product['soluong_shopee'] - $sl;
                            $this->productOption->SaveItem($data_update_product,$product['id']);
                        }
                    }


                    //### Kiểm tra trạng thái đơn hàng
                    if($trangthai=='Đã hủy'){
                        $tinhtrang=5;
                        $status='Canceled';
                    }else if($trangthai=='Hoàn thành'){
                        $tinhtrang=4;
                        $status='Success';
                    }else if($trangthai=='Đang giao'){
                        $tinhtrang=3;
                        $status='Confirmed';
                    }else if($trangthai=='Chờ giao hàng'){
                        $tinhtrang=2;
                        $status='Confirmed';
                    }else if($trangthai=='Chờ xác nhận'){
                        $tinhtrang=1;
                        $status='New';
                    }else{
                        $tinhtrang=6;
                        $status='Aborted';
                    }


                    //### Kiểm tra hình thức thanh toán
                    if($httt_txt=='Thanh toán khi nhận hàng'){
                        $httt=1;
                    }else if($httt_txt=='Thẻ Tín dụng/Ghi nợ'){
                        $httt=3;
                    }else{
                        $httt=4;
                    }


                    //### Kiểm tra trạng thái thanh toán
                    if($tinhtrang==4){
                        $pay_status=1;
                    }else if($httt==1 && ($tinhtrang==2 || $tinhtrang==3 || $tinhtrang==1)){
                        $pay_status=0;
                    }else if(($httt==3 || $httt==4) && ($tinhtrang==4 ||$tinhtrang==3 ||$tinhtrang==2 ||$tinhtrang==1 )){
                        $pay_status=1;
                    }else{
                        $pay_status=2;
                    }


                    //### Cập nhật lại số lượng shoppe khi đổi trạng thái đơn hàng sang 'hủy'
                    if(($tinhtrang==5 || $tinhtrang==6) && $donhang['tinhtrang']!=5 && $donhang['tinhtrang']!=6){
                        $o_details = $donhang['has_order_detail_all'];
                        foreach($o_details as $od=>$o_detail){
                            $row_product = $this->productOption->GetItem(['id'=>$o_detail['id_option']]);
                            $data_update_product['soluong_shopee'] = $row_product['soluong_shopee'] + $o_detail['soluong'];
                            $this->productOption->SaveItem($data_update_product, $o_detail['id_option']);
                        }
                    }


                    //### Cập nhật thông tin đơn hàng
                    $data_donhang = array();
                    $data_donhang['tamtinh'] = $tamtinh;
                    $data_donhang['tonggia'] = $tonggia;
                    $data_donhang['chiphi_kenhbanhang'] = $chiphikhac;
                    $data_donhang['status_payments'] = $pay_status;
                    $data_donhang['httt'] = $httt;
                    $data_donhang['tinhtrang'] = $tinhtrang;
                    $data_donhang['json_shopee'] = json_encode($row,true);
                    $this->order->SaveProduct($data_donhang,$donhang['id']);

                }else{ //### Nếu ko tồn tại đơn hàng
                    if($trangthai!='Đã hủy'){
                        $madonhang = date('ymd').Str::upper(Str::random(6));

                        /*Kiểm tra trạng thái*/
                        if($trangthai=='Đã hủy'){
                            $tinhtrang=5;
                        }else if($trangthai=='Hoàn thành'){
                            $tinhtrang=4;
                        }else if($trangthai=='Đang giao'){
                            $tinhtrang=3;
                        }else if($trangthai=='Chờ giao hàng'){
                            $tinhtrang=2;
                        }else if($trangthai=='Chờ xác nhận'){
                            $tinhtrang=1;
                        }else{
                            $tinhtrang=6;
                        }


                        /*Kiểm tra hình thức thanh toán*/
                        if($httt_txt=='Thanh toán khi nhận hàng'){
                            $httt=1;
                        }else if($httt_txt=='Thẻ Tín dụng/Ghi nợ'){
                            $tinhtrang=3;
                        }else{
                            $tinhtrang=4;
                        }


                        /*Kiểm tra trạng thái thanh toán*/
                        if($tinhtrang==4){
                            $pay_status=1;
                        }else if($httt==1 && ($tinhtrang==2 || $tinhtrang==3 || $tinhtrang==1)){
                            $pay_status=0;
                        }else if(($httt==3 || $httt==4) && ($tinhtrang==4 ||$tinhtrang==3 ||$tinhtrang==2 ||$tinhtrang==1 )){
                            $pay_status=1;
                        }else{
                            $pay_status=2;
                        }  


                        $data_donhang = array();
                        $data_donhang['madonhang'] = $madonhang;
                        $data_donhang['madonhang_shopee'] = $madh;
                        $data_donhang['order_code_delivery'] = $mavandon;
                        $data_donhang['supplier_delivery'] = $dv_vanchuyen;
                        $data_donhang['hoten'] = $hoten;
                        $data_donhang['dienthoai'] = $sdt;
                        $data_donhang['diachi'] = $diachi;
                        $data_donhang['city'] = $city;
                        $data_donhang['district'] = $dist;
                        $data_donhang['wards'] = $wards;
                        $data_donhang['giamgia'] = $coupon;
                        $data_donhang['httt'] = $httt;
                        $data_donhang['phiship'] = 0;
                        $data_donhang['tamtinh'] = $tamtinh;
                        $data_donhang['tonggia'] = $tonggia;
                        $data_donhang['yeucaukhac'] = $yeucaukhac;
                        $data_donhang['ngaytao'] = $ngaytao;
                        $data_donhang['status_payments'] = $pay_status;
                        $data_donhang['tinhtrang'] = $tinhtrang;
                        $data_donhang['chiphi_kenhbanhang'] = $chiphikhac;
                        $data_donhang['stt'] = 1;
                        $data_donhang['hienthi'] = 1;
                        $data_donhang['channel'] = 2;
                        $data_donhang['json_shopee'] = json_encode($row,true);                        
                        $row_order = $this->order->SaveProduct($data_donhang);

                        //### tạo đơn hàng từ shopee thành công
                        if($row_order){
                            if($product){
                                $mau=(int)$product['id_mau'];
                                $size=(int)$product['id_size'];
                                $tenmau=CartHelper::get_mau_info($mau)['tenvi'];
                                $tensize=CartHelper::get_size_info($size)['tenvi'];
                                $table_name = 'product_option';

                                $code = md5($product['id'].$mau.$size);
                                $data_donhangchitiet = array();
                                $data_donhangchitiet['id_product'] = $product['id_product'];
                                $data_donhangchitiet['id_order'] = $row_order['id'];
                                $data_donhangchitiet['photo'] = $product['photo'];
                                $data_donhangchitiet['ten'] = $product['tenvi'];
                                $data_donhangchitiet['code'] = $code;
                                $data_donhangchitiet['mau'] = $tenmau;
                                $data_donhangchitiet['size'] = $tensize;
                                $data_donhangchitiet['masp'] = $product['masp'];                
                                $data_donhangchitiet['gia'] = $gia_saukm;
                                $data_donhangchitiet['soluong'] = $sl;
                                $data_donhangchitiet['id_option'] = $product['id'];
                                $data_donhangchitiet['table_name'] = $table_name;
                                $row_insertOrderdetail = $this->order_detail->SaveProduct($data_donhangchitiet);

                                //### Cập nhật lại soluong_shopee của sản phẩm trên website
                                $data_update_product['soluong_shopee'] = $product['soluong_shopee'] - $sl;
                                $this->productOption->SaveItem($data_update_product,$product['id']);
                            }
                        }
                    }
                }
            }
        }
    }


    public function chunkSize(): int
    {
        return 1000;
    }


    /*public function model(array $row)
    {
        return new Order([
            //
        ]);
    }*/
}
