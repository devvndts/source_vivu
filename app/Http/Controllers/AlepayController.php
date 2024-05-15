<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jobs\SendEmail;
use App\Mail\MailNotify;

use App\Http\Traits\SupportTrait;

use App\Payment\Alepay;
//use App\Payment\nusoap;

use App\Models\Order;
use App\Models\OrderDetail;

use Helper;
use CartHelper;
use Mail;

class AlepayController extends Controller
{
    use SupportTrait;

    private $merchant_id;
    private $merchant_pass;
    private $secure_pass;
    private $merchant_url;
    private $merchant_receiver;
    private $status_payments;
    private $config_nganluong_active;
    private $config_nganluong;
    private $setting_opt;

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request)
    {
        //### Lấy config trạng thái thanh toán
        //$this->status_payments = config('config_all.payment_status');

        //### Lấy config payment
        // $this->config_nganluong = config('payment')['nganluong'];
        // $this->config_nganluong_active = $this->config_nganluong['active'];
        // $this->config_nganluong = $this->config_nganluong[$this->config_nganluong['type']];

        // $this->merchant_id = $this->config_nganluong['MERCHANT_ID'];
        // $this->merchant_pass = $this->secure_pass = $this->config_nganluong['MERCHANT_PASS'];
        // $this->merchant_url = $this->config_nganluong['URL_API'];
        // $this->merchant_receiver = $this->config_nganluong['RECEIVER'];

        // $this->setting_opt = $this->GetSettingOption('setting');
        // Helper::SetConfigMail($this->setting_opt);
    }


    /*
    |--------------------------------------------------------------------------
    | Link return_url từ ngân lượng -- GET
    |--------------------------------------------------------------------------
    */
    public function getOrder(Request $request)
    {
        $this->initialization($request);
        $config_nganluong = config('payment')['alepay'];
        $config_nganluong_active = $config_nganluong['active'];
        $config_nganluong = $config_nganluong[$config_nganluong['type']];
        $transactionCode = isset($request->transactionCode) ? $request->transactionCode : '';

        if (isset($transactionCode)) {
            //Khai báo đối tượng của lớp NL_Checkout
            $checkout = new Alepay($config_nganluong);
            $order = Order::where('transactionCode', $transactionCode)->first();
                    
            if ($order) {
                $data = array();

                $orderDetail = OrderDetail::where('id_order', $order->id)->get();
                if ($orderDetail->count() > 0) {
                    $orderQuantity = ($orderDetail->sum('soluong') > 0) ? $orderDetail->sum('soluong') : 1;
                }

                $data['cancelUrl'] = route('alepay.cancel', [$order->id]);
                $data['amount'] = $order->tonggia;
                $data['orderCode'] = $order->madonhang;
                $data['currency'] = 'VND';
                $data['orderDescription'] = 'Thanh toan don hang ' . $order->madonhang;
                $data['totalItem'] = $orderQuantity;
                $data['checkoutType'] = 4; // Thanh toán trả góp
                $data['buyerName'] = trim($order->hoten);
                $data['buyerEmail'] = trim($order->email);
                $data['buyerPhone'] = trim($order->dienthoai);
                $data['buyerAddress'] = trim($order->diachi);
                $data['buyerCity'] = 'Việt Nam';
                $data['buyerCountry'] = 'Việt Nam';
                //$data['month'] = 3;
                $data['paymentHours'] = 48; //48 tiếng :  Thời gian cho phép thanh toán (tính bằng giờ)
                        
                $data['allowDomestic'] = true;
                $data['installment'] = false;
            }
            $checkoutResult = $checkout->getTransactionInfoV3($data, $transactionCode);
            echo '<pre style="color: red">'.__FILE__.': '.__LINE__.'<br>';
            print_r($data);
            echo '</pre>';
            echo '<pre style="color: red">'.__FILE__.': '.__LINE__.'<br>';
            print_r($transactionCode);
            echo '</pre>';
            die('<p style="color: red">'.__FILE__.': '.__LINE__.'</p>');
        }
    }
    public function Return(Request $request)
    {
        $this->initialization($request);
        $config_nganluong = config('payment')['alepay'];
        $config_nganluong_active = $config_nganluong['active'];
        $config_nganluong = $config_nganluong[$config_nganluong['type']];

        $errorCode = isset($request->errorCode) ? $request->errorCode : '';
        $transactionCode = isset($request->transactionCode) ? $request->transactionCode : '';

        if (isset($transactionCode)) {
            //Khai báo đối tượng của lớp NL_Checkout
            $checkout = new Alepay($config_nganluong);
            // $order = Order::where('transactionCode', $transactionCode)->first();
            // if ($order) {
            //     $data = array();

            //     $orderDetail = OrderDetail::where('id_order', $order->id)->get();
            //     if ($orderDetail->count() > 0) {
            //         $orderQuantity = ($orderDetail->sum('soluong') > 0) ? $orderDetail->sum('soluong') : 1;
            //     }

            //     $data['cancelUrl'] = route('alepay.cancel', [$order->id]);
            //     $data['amount'] = $order->tonggia;
            //     $data['orderCode'] = $order->madonhang;
            //     $data['currency'] = 'VND';
            //     $data['orderDescription'] = 'Thanh toan don hang ' . $order->madonhang;
            //     $data['totalItem'] = $orderQuantity;
            //     $data['checkoutType'] = 4; // Thanh toán trả góp
            //     $data['buyerName'] = trim($order->hoten);
            //     $data['buyerEmail'] = trim($order->email);
            //     $data['buyerPhone'] = trim($order->dienthoai);
            //     $data['buyerAddress'] = trim($order->diachi);
            //     $data['buyerCity'] = 'Việt Nam';
            //     $data['buyerCountry'] = 'Việt Nam';
            //     //$data['month'] = 3;
            //     $data['paymentHours'] = 48; //48 tiếng :  Thời gian cho phép thanh toán (tính bằng giờ)
                
            //     $data['allowDomestic'] = true;
            //     $data['installment'] = false;
            // }
            // echo '<pre style="color: red">'.__FILE__.': '.__LINE__.'<br>';
            // print_r($data);
            // echo '</pre>';
            // echo '<pre style="color: red">'.__FILE__.': '.__LINE__.'<br>';
            // print_r($transactionCode);
            // echo '</pre>';
            // die('<p style="color: red">'.__FILE__.': '.__LINE__.'</p>');
            $result = $checkout->getTransactionInfoV3($transactionCode);
            // $result = json_decode($result, true);
            // +"code": "000"
            // +"message": "Thành công"
            // +"signature": "33a8caa5867c86b5954c7b67a5f6b2273711e79b5119da1c9a476715a8958b84"
            // +"transactionCode": "ALE00PNE9"
            // +"orderCode": "220730FP6ZBJ"
            // +"amount": "162000"
            // +"currency": "VND"
            // +"buyerEmail": "fdsafdasf@fdsfdas.fj"
            // +"buyerPhone": "0989878987"
            // +"cardNumber": "970456-XXXX-5656"
            // +"buyerName": "test"
            // +"status": "000"
            // +"reason": "Thành công"
            // +"description": "Thành công"
            // +"installment": false
            // +"is3D": false
            // +"month": 0
            // +"bankCode": "EXIMBANK"
            // +"bankName": "NH TMCP Xuất Nhập Khẩu Việt Nam"
            // +"method": "ATM_ON"
            // +"bankType": "DOMESTIC"
            // +"transactionTime": 1659145131629
            // +"successTime": 1659145146952
            // +"bankHotline": "18001199"
            // +"merchantFee": 0
            // +"payerFee": 1720
            // +"authenCode": null
            if ($result) {
                // dd($result);
                $nl_errorcode           = (string)$result->code;
                // $nl_transaction_status  = (string)$result->transaction_status;

                if ($nl_errorcode == '000') {
                    // if($nl_transaction_status == '000') {
                    $order = new Order();
                    $row_order = $order->GetItem(['madonhang'=>$request->orderCode]);
                        
                    //### cập nhật thông tin đơn hàng
                    $order = new Order();
                    $data_update['payment_status'] = 1;
                    $data_update['status_payments'] = 1;
                    $order->SaveProduct($data_update, $row_order['id']);

                    //### gửi mail khi xác nhận thanh toán online thành công
                    if ($row_order) {
                        $message = array();
                        $message['tieude'] = thongtindathang." ".$row_order['madonhang'];
                        $message['madonhang'] = $row_order['madonhang'];
                        $message['file']='';
                        $message['setting'] = $this->setting_opt;
                        $message['order'] = (isset($row_order)) ? $row_order : '';

                        //### gửi mail tới người đặt hàng
                        // Mail::to($row_order['email'])->send(new MailNotify($message,null,'order'));
                        //### gửi mail tới quản trị viên
                        // Mail::to($this->setting_opt['email'])->send(new MailNotify($message,null,'order'));
                    }

                    //### trả về trang thông báo thành công
                    return redirect()->route('cart.inform', ['status'=>'success']);
                // }
                } else {
                    return redirect()->route('cart.inform', ['status'=>'error']);
                }
            } else {
                return redirect()->route('cart.inform', ['status'=>'error']);
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Link notify_url từ ngân lượng -- GET
    |--------------------------------------------------------------------------
    */
    public function Notify(Request $request)
    {
        $this->initialization($request);
        //dd('get notify_url');
    }


    /*
    |--------------------------------------------------------------------------
    | update data dc gửi từ ngân lượng theo địa chỉ webservice cấu hình trên trang ngân lượng-- POST
    |--------------------------------------------------------------------------
    */
    public function Update(Request $request)
    {
        $this->initialization($request);
        // Gọi tới thư viện

        // Khai bao chung WebService
        $server = new nusoap();
        $server->configureWSDL('WS_WITH_SMS', 'NS');
        $server->wsdl->schemaTargetNamespace='NS';

        // Khai bao cac Function
        $server->register('UpdateOrder', array('transaction_info'=>'xsd:string','order_code'=>'xsd:string','payment_id'=>'xsd:int','payment_type'=>'xsd:int','secure_code'=>'xsd:string'), array('result'=>'xsd:int'), 'NS');
        //$server->register('RefundOrder',array('transaction_info'=>'xsd:string','order_code'=>'xsd:string','payment_id'=>'xsd:int','refund_payment_id'=>'xsd:int','payment_type'=>'xsd:int','secure_code'=>'xsd:string'),array('result'=>'xsd:int'),'NS');

        // Khoi tao Webservice
        $HTTP_RAW_POST_DATA = (isset($HTTP_RAW_POST_DATA)) ? $HTTP_RAW_POST_DATA :'';
        $server->service($HTTP_RAW_POST_DATA);
    }


    /*
    |--------------------------------------------------------------------------
    | cancel order
    |--------------------------------------------------------------------------
    */
    public function Cancel(Request $request)
    {
        $this->initialization($request);

        $orderId = $request->orderid;

        if ($orderId) {
            $order = new Order();
            $order_detail = new OrderDetail();

            $row_order = $order->GetItem(['id'=>$orderId]);

            //### delete order khi hủy thanh toán
            if ($row_order && $row_order['payment_status']==0 && $row_order['token']!='' && $row_order['is_online']==1) {
                $order->DeleteOneItem($row_order['id']);

                //### delete order_detail
                $row_order_detail = $order_detail->GetAllItems(['id_order'=>$orderId]);
                if ($row_order_detail) {
                    foreach ($row_order_detail as $k=>$v) {
                        //### Cập nhật số lượng sản phẩm khi xóa đơn hàng
                        if ($v['table_name']=='product_option') {
                            $id_product = $v['id_option'];
                            $row = $this->productOptRepo->GetOneItem($id_product);
                            $data['soluong_website'] = $row['soluong_website'] + $v['soluong'];
                            $result_product = $this->productOptRepo->SaveItem($data, $id_product);
                        } else {
                            $id_product = $v['id_product'];
                            $row = $this->productRepo->GetOneItem($id_product);
                            $data['soluong_website'] = $row['soluong_website'] + $v['soluong'];
                            $result_product = $this->productRepo->SaveItem($data, $id_product);
                        }
                        $arr_product[] = $result_product->toArray();

                        //### xóa
                        $order_detail->DeleteOneItem($v['id']);
                    }

                    ///### Đồng bộ cập nhật số lượng sản phẩm trên lazada
                    if ($arr_product) {
                        //$row_lazada = $this->lazada_api->updateQCProduct_Lazada($arr_product);
                    }
                }
                return redirect()->route('home');
            } else {
                return redirect()->route('error.show', ['404']);
            }
        }
    }


    public function UpdateOrder($transaction_info, $order_code, $payment_id, $payment_type, $secure_code)
    {
        $secure_pass = $this->secure_pass;
        
        //### test lưu log kiểm tra  gọi cập nhật order:
        //WriteLog("log_".date("Ymd",time()).".txt", $error." Kết quả: ".$transaction_info." ".$order_code." ".$payment_id." ".$payment_type );
        
        //### Kiểm tra chuỗi bảo mật
        $secure_code_new = md5($transaction_info.' '.$order_code.' '.$payment_id.' '.$payment_type.' '.$secure_pass);

        if ($secure_code_new != $secure_code) {
            return -1; // Sai mã bảo mật
        } else { // Thanh toán thành công
            //### Lấy thông tin đơn hàng
            $order = new Order();
            $row_order = $order->GetItem(['madonhang'=>$order_code]);

            // Trường hợp là thanh toán tạm giữ. Hãy đưa thông báo thành công và cập nhật hóa đơn phù hợp
            if ($payment_type == 2) {
                // Lập trình thông báo thành công và cập nhật hóa đơn
                $data_update['payment_type'] = 2;
            }
            // Trường hợp thanh toán ngay. Hãy đưa thông báo thành công và cập nhật hóa đơn phù hợp
            elseif ($payment_type == 1) {
                // Lập trình thông báo thành công và cập nhật hóa đơn
                $data_update['payment_type'] = 1;
            }

            //### cập nhật thông tin đơn hàng
            $order = new Order();
            $data_update['status_payments'] = 1;
            $data_update['payment_id'] = $payment_id;
            $order->SaveProduct($data_update, $row_order['id']);
        }
    }


    /*function RefundOrder($transaction_info, $order_code, $payment_id, $refund_payment_id, $refund_amount, $refund_type, $refund_description, $secure_code){
        $error = 'Chưa xác minh';

        $md5 = $transaction_info." ".$order_code." ".$payment_id." ".$refund_payment_id." ".$refund_amount." ".$refund_type." ".$refund_description." ".$secure_pass;

        if(md5($md5) == strtolower($secure_code)){
            $error = 'payment success';
        }else{
            $error = 'Tham số truyền bị thay đổi';
        }


        //log
        $params = array(
           'time'     => date('H:i(worry), d/m/Y', time()),
           'transaction_info'  => $transaction_info,
           'order_code'   => $order_code,
           'payment_id'   => $payment_id,
           'refund_payment_id'  => $refund_payment_id,
           'refund_amount'   => $refund_amount,
           'refund_type'   => $refund_type,
           'refund_description' => $refund_description,
           'secure_code'   => $secure_code,
           'error'     => $error
        );


        $content = json_encode($params);

        if(writeLog('refund_order.txt',$content)){
            $error = 'khongcooilidf';
        }else{
            $error = 'File log không tồn tại';
        }

        return array('error'=>$error);
    }*/
}
