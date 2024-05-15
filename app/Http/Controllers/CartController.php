<?php
namespace App\Http\Controllers;

// require('Lib/Alepay.php');
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/*SEO Tool*/
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;// OR with multi
//use Artesaos\SEOTools\Facades\JsonLdMulti;// OR
//use Artesaos\SEOTools\Facades\SEOTools;
/*### END SEO Tool*/

//use App\Models\SeoPage;
//use App\Models\Setting;

use App\Models\Cart;
use App\Models\Places;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Address;

use App\Jobs\SendEmail;
use App\Mail\MailNotify;

use App\Http\Traits\SupportTrait;

use App\Payment\NganLuong;
use App\Payment\Alepay;
// use App\Payment\Alepay;

use Helper;
use CartHelper;
use Illuminate\Support\Facades\Redirect;
use Mail;
// require('Lib/Alepay.php');
class CartController extends Controller
{
    use SupportTrait;

    private $model;
    private $setting_opt;
    private $is_online;

    public function initialization(Request $request)
    {
        $this->model = new Cart();
        $this->setting_opt = $this->GetSettingOption('setting');
        Helper::SetConfigMail($this->setting_opt);

        $this->is_online = config('payment.payment_online');
    }


    public function OrderCheckCart(Request $request)
    {
        $this->initialization($request);

        //### request
        $model_order = new Order();

        //### xử lý
        $phonenumber = $request->phonenumber;
        $order = $model_order->with(['HasOrderDetailAll'])->where('dienthoai', $phonenumber)->where('hienthi', 1)->get();
        $background_category =  $this->photoRepo->GetItem(['type'=>'banner_check', 'act'=>'photo_static']);


        //### Phản hồi
        $response = array(
            'order' => ($order) ? $order->toArray() : null,
            'phonenumber' => ($phonenumber) ? $phonenumber : '',
            "background_category" => $background_category
        );

        return view('desktop.templates.cart.check')->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Hiển thị danh sách sản phẩm trong đơn hàng
    |--------------------------------------------------------------------------
    */
    public function ShowCart ($response, Request $request)
    {
        $this->initialization($request);
        $configAlepay = config('payment.alepay.sandbox');

        /* Khai báo */
        //$lang = (isset($response->lang))?$response->lang:'vi';
        $field = (isset($response->field))?$response->field:'';
        $slug = (isset($response->slug))?$response->slug:'';
        $type = (isset($response->type))?$response->type:'';
        $title_main = $title_crumb = (isset($response->title))?$response->title:'';

        /* breadCrumbs */
        $model_seo = $this->seopageRepo;//new SeoPage();
        $row_seo = $model_seo->GetItem(['type'=>$type]);
        $title = ($row_seo['title'.$this->lang]!='') ? $row_seo['title'.$this->lang] : $row_seo['ten'.$this->lang];
        $keywords = ($row_seo['keywords'.$this->lang]!='') ? $row_seo['keywords'.$this->lang] : $row_seo['ten'.$this->lang];
        $description = ($row_seo['description'.$this->lang]!='') ? $row_seo['description'.$this->lang] : $row_seo['ten'.$this->lang];
        $photo = ($row_seo['photo']!='')?Helper::GetConfigBase().UPLOAD_SEOPAGE.$row_seo['photo']:'';
        $img_json_bar = ($row_seo['photo']!='')?Helper::getImgSize($row_seo['photo'], UPLOAD_SEOPAGE.$row_seo['photo']):'';

        if (isset($title_crumb) && $title_crumb != '') {
            Helper::setBreadCrumbs($slug, $title_main);
        }
        $breadcrumbs = Helper::getBreadCrumbs();

        //### thiết lập biến khởi tạo
        $id_login = Helper::GetCookie('login_member_id');
        $token_member_cart = Helper::GetCookie('member_cart');

        //### Xử lý: lấy ds sản phẩm trong đơn hàng
        if ($id_login>0) {
            $this->model = $this->model->where('id_user', $id_login);
        } else {
            $this->model = $this->model->where('id_user', 0)->where('token_member_cart', $token_member_cart);
        }
        $row_cart = ($this->model) ? $this->model->get()->toArray() : null;

        //### Xử lý : lấy tỉnh thành quận huyện
        $city = new Places('list');
        $params = ["type" => null];
        $city = $city->GetAllItems($params);

        $district = new Places('cat');
        $district = array();//$district->GetAllItems();

        $wards = new Places('item');
        $wards = array();//$wards->GetAllItems();

        $address = new Address();
        $user_address = $address->GetAllItems(['id_user'=>$id_login]);


        //### lấy ds hình thức thanh toán
        $hinhthucthanhtoan = $this->postRepo->GetAllItems('hinh-thuc-thanh-toan', ['hienthi'=>1]);


        //## lấy ds voucher
        $vouchers = $this->couponRepo->Query()->where('hienthi', 1)->where('ngaybatdau', '<', time())->where('ngayketthuc', '>', time())->get();

        //### Phản hồi
        $response = array(
            "id_login" => $id_login,
            "token_member_cart" => $token_member_cart,
            "row_cart" => $row_cart,
            "title_crumb" => $title_crumb,
            "breadcrumbs" => $breadcrumbs,
            "city" => $city,
            "district" => $district,
            "wards" => $wards,
            "user_address" => $user_address,
            'hinhthucthanhtoan' => $hinhthucthanhtoan,
            'vouchers' => ($vouchers) ? $vouchers->toArray() : null
        );


        /*### SEO TOOL */
        SEOMeta::setCanonical(url()->current());
        SEOMeta::setTitle($title);
        SEOMeta::setKeywords($keywords);
        SEOMeta::setDescription($description);

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($request->url());
        if ($field) {
            OpenGraph::addProperty('type', 'article');
        } else {
            OpenGraph::addProperty('type', 'object');
        }
        if ($img_json_bar!='' && count($img_json_bar)>0) {
            OpenGraph::addImage($photo, ['height' => $img_json_bar['h'], 'width' => $img_json_bar['w'], 'type' => $img_json_bar['m'], 'alt' =>$title]);
        } else {
            OpenGraph::addImage($photo, ['alt' =>$title]);
        }

        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setImage($photo);

        return view('desktop.templates.cart.show')->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Tạo đơn hàng
    |--------------------------------------------------------------------------
    */
    public function OrderCart(Request $request)
    {
        $this->initialization($request);

        //### Khai báo model
        //$model_setting = $this->settingRepo;//new Setting();
        $model = new Cart();
        $model_orderdetail = new OrderDetail();
        $model_order = new Order();
        $arr_product = array();

        //### Khai báo dữ liệu
        $id_login = Helper::GetCookie('login_member_id');
        $token_member_cart = Helper::GetCookie('member_cart');
        $setting = app('setting');//$model_setting->GetItem(['type'=>'setting']);
        $settingOption = json_decode($setting['options'], true);
        $lang = session('locale');

        $data_post = $request->all();

        $madonhang = date('ymd').Str::upper(Str::random(6));
        $httt = (isset($data_post['payments']) && $data_post['payments'] > 0) ? $data_post['payments'] : 0;
        $yeucaukhac = (isset($data_post['yeucaukhac']) && $data_post['yeucaukhac'] != '') ? $data_post['yeucaukhac'] : '';
        $tamtinh = (isset($data_post['price-temp']) && $data_post['price-temp'] > 0) ? $data_post['price-temp'] : 0;
        $ship = (isset($data_post['price-ship']) && $data_post['price-ship'] > 0) ? $data_post['price-ship'] : 0;
        $total = (isset($data_post['price-total']) && $data_post['price-total'] > 0) ? $data_post['price-total'] : 0;
        $ngaydangky = time();
        $payment_method = (isset($data_post['option_payment']) && $data_post['option_payment'] != '') ? $data_post['option_payment'] : '';
        $method_delivery = (isset($data_post['method_delivery']) && $data_post['method_delivery'] != '') ? $data_post['method_delivery'] : '';
        $option_delivery = (isset($data_post['option_delivery']) && $data_post['option_delivery'] != '') ? $data_post['option_delivery'] : '';
        $phibaohiem = (isset($data_post['insurance-temp']) && $data_post['insurance-temp'] > 0) ? $data_post['insurance-temp'] : 0;


        //### get hình thức thanh toán
        $row_httt = $this->postRepo->GetItem(['type'=>'hinhthucthanhtoan', 'id'=>$httt]);
        $htttText = $row_httt['ten'.$this->lang] ?? '';
        $pay_status=0;


        //### Xử lý
        if ($id_login>0) {
            $this->model = $this->model->where('id_user', $id_login);
            $address = new Address();
            $id_address_delivery = $request->id_address_delivery;
            $user_address = $address->GetOneItem(['id'=>$id_address_delivery]);
            $hoten = $user_address['hoten'];
            $dienthoai = $user_address['dienthoai'];
            $email = $user_address['email'];
            $city = $user_address['id_city'];
            $district = $user_address['id_district'];
            $wards = $user_address['id_ward'];
            $diachi = $user_address['address'];
        } else {
            $this->model = $this->model->where('id_user', 0)->where('token_member_cart', $token_member_cart);
            $hoten = (isset($data_post['ten']) && $data_post['ten'] != '') ? $data_post['ten'] : '';
            $dienthoai = (isset($data_post['dienthoai']) && $data_post['dienthoai'] != '') ? $data_post['dienthoai'] : '';
            $email = (isset($data_post['email']) && $data_post['email'] != '') ? $data_post['email'] : '';

            if (!empty($data_post['nhanhangtaishop'])) {
                $diachi = $diachi_cuthe = $settingOption['diachi'];
                $city=$district=$wards=0;
            } else {
                if (config('delivery.active')==false) {
                    $city = (isset($data_post['city']) && $data_post['city'] > 0) ? $data_post['city'] : 0;
                    $district = (isset($data_post['district']) && $data_post['district'] > 0) ? $data_post['district'] : 0;
                    $wards = (isset($data_post['wards']) && $data_post['wards'] > 0) ? $data_post['wards'] : 0;
                    $diachi = $diachi_cuthe = $data_post['diachi'].', '.Helper::GetPlace("ward", $wards).', '.Helper::GetPlace("district", $district).', '.Helper::GetPlace("city", $city);
                } else {
                    $city = (isset($data_post['delivery-city']) && $data_post['delivery-city'] > 0) ? $data_post['delivery-city'] : 0;
                    $district = (isset($data_post['delivery-district']) && $data_post['delivery-district'] > 0) ? $data_post['delivery-district'] : 0;
                    $wards = (isset($data_post['delivery-ward']) && $data_post['delivery-ward'] > 0) ? $data_post['delivery-ward'] : 0;

                    $diachi = $diachi_cuthe = $data_post['diachi'].', '.Helper::GetPlace("ward", $wards, $method_delivery).', '.Helper::GetPlace("district", $district, $method_delivery).', '.Helper::GetPlace("city", $city, $method_delivery);
                }
            }

            //### session [info_cart]
            // code...
        }

        //### Kiểm tra voucher
        $voucher = (isset($data_post['voucher']) && $data_post['voucher'] !='') ? $data_post['voucher'] : '';
        $sotien_duocgiam = 0;
        if ($voucher!='' && $dienthoai!='') {
            $row_voucher = $this->couponRepo->GetItem(['ma'=>$voucher, 'hienthi'=>1]);
            $sotien_duocgiam = $this->GetVoucherPrice($row_voucher, $voucher, $dienthoai);
            $total -= $sotien_duocgiam;
        }


        $row_cart = ($this->model) ? $this->model->get()->toArray() : null;

        // if ($row_cart==null) {
        //     return redirect()->back();
        // }


        //### Test thanh toán
        // $row_order = $model_order->GetOneItem(1);
        // $this->CallPayment($row_order, $request);

        /* lưu đơn hàng */
        $data_donhang = array();
        $data_donhang['id_user'] = (int)$id_login;
        $data_donhang['madonhang'] = $madonhang;
        $data_donhang['hoten'] = $hoten;
        $data_donhang['dienthoai'] = $dienthoai;
        $data_donhang['diachi'] = $diachi;
        $data_donhang['nhanhangtaishop'] = (isset($data_post['nhanhangtaishop'])) ? 1 : 0;
        $data_donhang['giamgia'] = $sotien_duocgiam;//$coupn['total_money'];
        $data_donhang['email'] = $email;
        $data_donhang['httt'] = $httt;
        $data_donhang['phiship'] = $ship;
        $data_donhang['tamtinh'] = $tamtinh;
        $data_donhang['tonggia'] = $total;
        $data_donhang['yeucaukhac'] = $yeucaukhac;
        $data_donhang['ngaytao'] = $ngaydangky;
        $data_donhang['status_payments'] = $pay_status;
        $data_donhang['tinhtrang'] = 1;
        $data_donhang['city'] = $city;
        $data_donhang['district'] = $district;
        $data_donhang['wards'] = $wards;
        $data_donhang['bankcode'] = $data_post['bankCode'];
        $data_donhang['stt'] = 1;
        $data_donhang['hienthi'] = 1;
        $data_donhang['payment_method'] = $payment_method;
        $data_donhang['method_delivery'] = $method_delivery;
        $data_donhang['option_delivery'] = $option_delivery;
        $data_donhang['phibaohiem'] = $phibaohiem;
        
        //$data_donhang['json_coupon'] =json_encode($coupn,true);
        $data_donhang['channel'] = 0;

        if (isset($row_voucher)) {
            $data_donhang['id_voucher'] = $row_voucher['id'];
            $data_donhang['voucher_code'] = $row_voucher['ma'];
        }

        $row_order = $model_order->SaveProduct($data_donhang);

        if (isset($row_order->id)) {
            //### insert order detail
            $id_insert = $row_order->id;
            for ($i = 0; $i < count($row_cart); $i++) {
                $pid = $row_cart[$i]['id_product'];
                $q = $row_cart[$i]['soluong'];
                $size=$row_cart[$i]['size'];
                $mau=$row_cart[$i]['mau'];
                $proinfo = CartHelper::get_product_info($pid, $size, $mau);
                $gia = $proinfo['gia'];
                $giacu = $proinfo['giacu'];
                $masp = $proinfo['masp'];
                $giamoi = $proinfo['giamoi'];
                $color = CartHelper::get_mau_info($row_cart[$i]['mau'])['ten'.$lang] ?? '';
                $size = CartHelper::get_size_info($row_cart[$i]['size'])['ten'.$lang] ?? '';
                $code = $row_cart[$i]['code'];
                $table_name = $proinfo['table'];
                $id_option = $proinfo['id_option'];

                if ($q==0) {
                    continue;
                }

                $data_donhangchitiet = array();
                $data_donhangchitiet['id_product'] = $pid;
                $data_donhangchitiet['id_order'] = $id_insert;
                $data_donhangchitiet['photo'] = $proinfo['photo'];
                $data_donhangchitiet['ten'] = $proinfo['ten'.$lang];
                $data_donhangchitiet['code'] = $code;
                $data_donhangchitiet['mau'] = $color;
                $data_donhangchitiet['masp'] = $masp;
                $data_donhangchitiet['size'] = $size;
                $data_donhangchitiet['gia'] = $gia;
                $data_donhangchitiet['giacu'] = $giacu;
                $data_donhangchitiet['giamoi'] = $giamoi;
                $data_donhangchitiet['soluong'] = $q;
                $data_donhangchitiet['id_option'] = $id_option;
                $data_donhangchitiet['table_name'] = $table_name;
                $row_orderDetail = $model_orderdetail->SaveProduct($data_donhangchitiet);

                //### cập nhật số lượng sản phẩm website và sàn lazada
                if ((config('config_all.order.soluong') || config('lazada.active')) && $row_orderDetail) {
                    if ($table_name=='product_option') {
                        $row = $this->productOptRepo->GetOneItem($id_option);
                        // $data['soluong_website'] = $row['soluong_website'] - $q;
                        $data['soluong'] = $row['soluong'] - $q;
                        $result_product = $this->productOptRepo->SaveItem($data, $id_option);
                    } else {
                        $row = $this->productRepo->GetOneItem($pid);
                        // $data['soluong_website'] = $row['soluong_website'] - $q;
                        $data['soluong'] = $row['soluong'] - $q;
                        $result_product = $this->productRepo->SaveItem($data, $pid);
                    }
                    $arr_product[] = $result_product->toArray();
                }
            }

            ///### Đồng bộ cập nhật số lượng sản phẩm trên lazada
            if ($arr_product) {
                //$row_lazada = $this->lazada_api->updateQCProduct_Lazada($arr_product);
            }


            //### Cập nhật voucher
            if ($voucher!='' && $row_voucher) {
                $this->UpdateVoucher($row_voucher, $voucher);
            }


            //### xóa cart sau khi insert
            foreach ($row_cart as $v) {
                $model->DeleteOneItem($v['id']);
            }

            if ($row_order) {
                //### lấy thông tin đơn hàng vừa tạo
                $message_detailOrder = $model_order->GetOneItem($row_order->id);

                //### gửi mail thông báo tới người mua hàng
                if ($email != '' && (!$this->is_online || $payment_method=='COD')) {
                    $message = array();
                    $message['tieude'] = __('Thông tin đặt hàng')." ".$madonhang;
                    $message['madonhang'] = $madonhang;
                    $message['file']='';
                    $message['setting'] = $this->setting_opt;
                    $message['order'] = (isset($message_detailOrder)) ? $message_detailOrder : '';
                    //### gửi mail tới người đặt hàng
                    // Mail::to($email)->send(new MailNotify($message,null,'order'));
                    //### gửi mail tới quản trị viên
                    // Mail::to($this->setting_opt['email'])->send(new MailNotify($message,null,'order'));
                }
            }

            $message = array();
            $message['tieude'] = __('Thông tin đặt hàng')." ".$madonhang;
            $message['madonhang'] = $madonhang;
            $message['file']='';
            $message['setting'] = $this->setting_opt;
            $message['order'] = (isset($message_detailOrder)) ? $message_detailOrder : '';
            //### gửi mail tới người đặt hàng
            // Mail::to($email)->send(new MailNotify($message, null, 'order'));
            ### gửi mail tới quản trị viên
            // Mail::to($this->setting_opt['email'])->send(new MailNotify($message, null, 'order'));
            if ($payment_method == "alepay" && $row_order) {
                //### xử lý payment
                $this->CallPayment($row_order->toArray(), $request);
            }
            if ($payment_method == "momo" && $row_order) {
                //### xử lý payment
                $this->momoPayment($row_order->toArray(), $request);
            }
        }

        //### return data
        if (!$this->is_online || $payment_method=='COD' || $httt>0) {
            return redirect()->route('cart.inform', ['status'=>'success']);
        }
    }

    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)));
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }



    private function momoPayment($detail_order, $request)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = "10000";
        $orderId = time() ."";
        $redirectUrl = "http://localhost/naturalpharm/checkout";
        $ipnUrl = "http://localhost/naturalpharm/checkout";
        $extraData = "";


        // $partnerCode = $_POST["partnerCode"];
        // $accessKey = $_POST["accessKey"];
        // $serectkey = $_POST["secretKey"];
        // $orderId = $_POST["orderId"]; // Mã đơn hàng
        // $orderInfo = $_POST["orderInfo"];
        // $amount = $_POST["amount"];
        // $ipnUrl = $_POST["ipnUrl"];
        // $redirectUrl = $_POST["redirectUrl"];
        // $extraData = $_POST["extraData"];

        $requestId = time() . "";
        $requestType = "payWithATM";
        $extraData = "";
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array('partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature);
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json
        // Just a example, please check more in there
        return redirect()->to($jsonResult['payUrl'])->send();
        // header('Location: ' . $jsonResult['payUrl']);
    }

    private function CallPayment($detail_order, $request)
    {
        if ($detail_order) {
            $arrDetail = $detail_order["has_order_detail_all"] ?? [];
            $arrDetailSoLuong = array_column($arrDetail, 'soluong');
            //### Lấy config payment
            $config_nganluong = config('payment')['alepay'];
            $config_nganluong_active = $config_nganluong['active'];
            $config_nganluong = $config_nganluong[$config_nganluong['type']];

            if ($config_nganluong_active) {

                // $checkout = new NganLuong($config_nganluong['MERCHANT_ID'], $config_nganluong['MERCHANT_PASS'], $config_nganluong['RECEIVER'], $config_nganluong['URL_API']);
                
                // $total_amount = $detail_order['tonggia'];
                $payment_method = $request['option_payment'];
                // $bank_code = $request['bankcode'];
                // $order_code = $detail_order['madonhang'];

                // $array_items = array();

                // $payment_type ='';
                // $discount_amount = 0;
                // $order_description='';
                // $tax_amount = 0;
                // $fee_shipping = 0;
                // $return_url = route('nganluong.return');
                // $cancel_url = route('nganluong.cancel', [$detail_order['id']]);

                $buyer_fullname = $detail_order['hoten'];
                $buyer_email = $detail_order['email'];
                $buyer_mobile = $detail_order['dienthoai'];
                // $buyer_address = $detail_order['diachi'];

                //Alepay
                $alepay = new Alepay($config_nganluong);
                $data = array();

                // parse_str(file_get_contents('php://input'), $params); // Lấy thông tin dữ liệu bắn vào

                $data['cancelUrl'] = route('alepay.cancel', [$detail_order['id']]);
                $data['amount'] = intval(preg_replace('@\D+@', '', $detail_order['tonggia']));
                $data['orderCode'] = $detail_order['madonhang'];
                $data['currency'] = 'VND';
                $data['orderDescription'] = 'Thanh toan don hang ' . $detail_order['madonhang'];
                $data['totalItem'] = (intval(array_sum($arrDetailSoLuong)) > 0) ? intval(array_sum($arrDetailSoLuong)) : 1;
                $data['checkoutType'] = 4; // Thanh toán trả góp
                $data['buyerName'] = trim($detail_order['hoten']);
                $data['buyerEmail'] = trim($detail_order['email']);
                $data['buyerPhone'] = trim($detail_order['dienthoai']);
                $data['buyerAddress'] = trim($detail_order['diachi']);
                $data['buyerCity'] = 'Việt Nam';
                $data['buyerCountry'] = 'Việt Nam';
                //$data['month'] = 3;
                $data['paymentHours'] = 48; //48 tiếng :  Thời gian cho phép thanh toán (tính bằng giờ)
                
                // foreach ($data as $k => $v) {
                //     if (empty($v)) {
                //         $alepay->return_json("NOK", "Bắt buộc phải nhập/chọn tham số [ " . $k . " ]");
                //         die();
                //     }
                // }
                $data['allowDomestic'] = true;
                $data['installment'] = false;
                //$baseUrlV3 = 'https://alepay-v3-sandbox.nganluong.vn/api/v3/checkout/';

                if ($payment_method !='' && $buyer_email !="" && $buyer_mobile !="" && $buyer_fullname !="" && filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {
                    

                    $result = $alepay->sendOrderV3($data);

                    
                    // if ($payment_method =="VISA") {
                    //     $result = $checkout->VisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items, $bank_code);
                    // } elseif ($payment_method =="NL") {
                    //     $result = $checkout->NLCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                    // } elseif ($payment_method =="ATM_ONLINE" && $bank_code !='') {
                    //     $result = $checkout->BankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items) ;
                    // // dd($result);
                    // } elseif ($payment_method =="NH_OFFLINE") {
                    //     $result = $checkout->officeBankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                    // } elseif ($payment_method =="ATM_OFFLINE") {
                    //     $result = $checkout->BankOfflineCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                    // } elseif ($payment_method =="IB_ONLINE") {
                    //     $result = $checkout->IBCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                    // } elseif ($payment_method == "CREDIT_CARD_PREPAID") {
                    //     $result = $checkout->PrepaidVisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items, $bank_code);
                    // }
                    
                    if ($result->code != '') {
                        if ($result->code == '000') {
                            // $order = new Order();
                            // $dataUpdate['token'] = $result->signature;
                            // $dataUpdate['is_online'] = 1;


                            $order = Order::find($detail_order['id']);
 
                            $order->transactionCode = $result->transactionCode;
                            $order->token = $result->signature;
                            $order->is_online = 1;
                             
                            $order->save();

                            // $order->SaveProduct($dataUpdate, $detail_order['id']);
                            header("Location: $result->checkoutUrl");
                            // return redirect()->away($result->checkoutUrl);
                        } else {
                            // echo '<p style="text-align: center; margin-top: 15px;"><b>Response:</b> ' . json_encode($result, JSON_UNESCAPED_UNICODE) . '</p>';
                        }
                    } else {
                        echo '<p style="text-align: center; margin-top: 15px;"><b>Response:</b> ' . json_encode($result, JSON_UNESCAPED_UNICODE) . '</p>';
                    }
                } else {
                    //### Lỗi: chưa nhập đủ thông tin
                }
            }
        }
    }

    /*
    private function CallPayment($detail_order, $request)
    {
        if ($detail_order) {
            //### Lấy config payment
            $config_nganluong = config('payment')['nganluong'];
            $config_nganluong_active = $config_nganluong['active'];
            $config_nganluong = $config_nganluong[$config_nganluong['type']];

            if ($config_nganluong_active) {
                $checkout = new NganLuong($config_nganluong['MERCHANT_ID'], $config_nganluong['MERCHANT_PASS'], $config_nganluong['RECEIVER'], $config_nganluong['URL_API']);
                
                $total_amount = $detail_order['tonggia'];
                $payment_method = $request['option_payment'];
                $bank_code = $request['bankcode'];
                $order_code = $detail_order['madonhang'];

                $array_items = array();

                $payment_type ='';
                $discount_amount = 0;
                $order_description='';
                $tax_amount = 0;
                $fee_shipping = 0;
                $return_url = route('nganluong.return');
                $cancel_url = route('nganluong.cancel', [$detail_order['id']]);

                $buyer_fullname = $detail_order['hoten'];
                $buyer_email = $detail_order['email'];
                $buyer_mobile = $detail_order['dienthoai'];
                $buyer_address = $detail_order['diachi'];


                if ($payment_method !='' && $buyer_email !="" && $buyer_mobile !="" && $buyer_fullname !="" && filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {
                    if ($payment_method =="VISA") {
                        $result = $checkout->VisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items, $bank_code);
                    } elseif ($payment_method =="NL") {
                        $result = $checkout->NLCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                    } elseif ($payment_method =="ATM_ONLINE" && $bank_code !='') {
                        $result = $checkout->BankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items) ;
                    // dd($result);
                    } elseif ($payment_method =="NH_OFFLINE") {
                        $result = $checkout->officeBankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                    } elseif ($payment_method =="ATM_OFFLINE") {
                        $result = $checkout->BankOfflineCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                    } elseif ($payment_method =="IB_ONLINE") {
                        $result = $checkout->IBCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                    } elseif ($payment_method == "CREDIT_CARD_PREPAID") {
                        $result = $checkout->PrepaidVisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items, $bank_code);
                    }

                    if (isset($result->error_code) && $result->error_code =='00') {
                        //Cập nhât order với token $checkout->token để sử dụng check hoàn thành sau này
                        $order = new Order();
                        $data['token'] = $result->token;
                        $data['is_online'] = 1;
                        $order->SaveProduct($data, $detail_order['id']);

                        header("Location: $result->checkout_url");
                    } else {
                        //$result->error_message;
                    }
                } else {
                    //### Lỗi: chưa nhập đủ thông tin
                }
            }
        }
    }
     */



    /*private function CallPayment($detail_order){
        if($detail_order){
            //### Lấy config payment
            $config_nganluong = config('payment')['nganluong'];
            $config_nganluong_active = $config_nganluong['active'];
            $config_nganluong = $config_nganluong[$config_nganluong['type']];

            if($config_nganluong_active){

                //### khởi tạo dữ liệu
                $flag = true;
                $order_code = $detail_order['madonhang'];

                //Khai báo url trả về
                $return_url= route('nganluong.return'); //GET

                // Link nut hủy đơn hàng
                $cancel_url= route('home');
                $notify_url = route('nganluong.notify'); //GET

                //Giá của cả giỏ hàng
                $order_name = $detail_order['hoten'];
                $order_email = $detail_order['email'];
                $order_phone = $detail_order['dienthoai'];
                $order_price = (int)$detail_order['tonggia'];

                if(strlen($order_name) > 50 || strlen($order_email) > 50 || strlen($order_phone) > 20){$flag = false;}

                if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+-]/', $order_name)){$flag = false;}

                if($flag) {
                    //Thông tin giao dịch
                    $transaction_info="Thong tin giao dich";
                    $currency = "vnd";
                    $quantity = 1;
                    $tax = 0;
                    $discount = 0;
                    $fee_cal = 0;
                    $fee_shipping = 0;
                    $order_description = "Thong tin don hang: ".$order_code;
                    $buyer_info = $order_name."*|*".$txt_email."*|*".$order_phone;
                    $affiliate_code = "";
                    $receiver = $config_nganluong['RECEIVER'];

                    $checkout = new NganLuong();
                    $checkout->nganluong_url = $config_nganluong['NGANLUONG_URL'];
                    $checkout->merchant_site_code = $config_nganluong['MERCHANT_ID'];
                    $checkout->secure_pass = $config_nganluong['MERCHANT_PASS'];


                    //Tạo link thanh toán đến nganluong.vn
                    $url= $checkout->buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $price, $currency, $quantity, $tax, $discount , $fee_cal, $fee_shipping, $order_description, $buyer_info , $affiliate_code);


                    if ($order_code != "") {
                        //một số tham số lưu ý
                        //&cancel_url=http://yourdomain.com --> Link bấm nút hủy giao dịch
                        //&option_payment=bank_online --> Mặc định forcus vào phương thức Ngân Hàng
                        $url .='&cancel_url='. $cancel_url . '&notify_url='.$notify_url;
                        //$url .='&option_payment=bank_online';

                        echo '<meta http-equiv="refresh" content="0; url='.$url.'" >';
                        //&lang=en --> Ngôn ngữ hiển thị google translate
                    }
                }
            }
        }
    }*/



    private function GetVoucherPrice($row, $voucher, $dienthoai)
    {
        //$row = $this->couponRepo->GetItem(['ma'=>$voucher, 'hienthi'=>1]);
        $sotien_duocgiam = 0;

        if ($row) { // nếu voucher tồn tại
            $model_order = new Order();
            $user_ordered = $model_order->where('dienthoai', $dienthoai)->where('voucher_code', $voucher)->get();

            //###
            $solan_cothesudung = $row['solan'] - $row['solan_dadung'];
            $solan_duoc_dung = $row['dung_nhieulan'];
            $sotien_toithieu = $row['min_price'];
            $thongtin_voucher = $row['noidungvi'];

            //### lấy tổng số tiền của đơn hiện tại
            $id_login = Helper::GetCookie('login_member_id');
            $token_member_cart = Helper::GetCookie('member_cart');
            $tongtien = CartHelper::get_order_total($id_login, $token_member_cart);
            
          
            if (time()<$row['ngaybatdau'] || time()>$row['ngayketthuc']) { // nếu voucher không còn trong thời gian sử dụng
                //...
            } elseif ($solan_cothesudung<=0) { // nếu voucher ko còn lượt sử dụng
                //...
            } elseif ($solan_duoc_dung==0 && count($user_ordered)>0) { // đk: voucher chỉ dc dùng cho 1 lần đặt hàng và nếu đã có đơn đặt trước đó=> ko thể dùng voucher
                //...
            } elseif ($tongtien<$sotien_toithieu) { // nếu tổng tiền của đơn hiện tại < số tiền tối thiểu mà voucher quy định => false
                //...
            } else {
                //## lấy số tiền được giảm dựa trên loại giảm và mức giảm
                if ($row['loaigiam']==0) { // nếu loại giảm là theo số tiền
                    $sotien_duocgiam = $row['mucgiam'];
                } else { // nếu loại giảm là theo phần trăm
                    $sotien_duocgiam = (($row['mucgiam']*$tongtien)/100);
                }

                return $sotien_duocgiam;
            }
        }

        return $sotien_duocgiam;
    }


    private function UpdateVoucher($row, $voucher)
    {
        //$row = $this->couponRepo->GetItem(['ma'=>$voucher, 'hienthi'=>1]);
        $data['solan_dadung'] = $row['solan_dadung']+1;
        $this->couponRepo->SaveItem($data, $row['id']);
    }


    /*
    |--------------------------------------------------------------------------
    | Thông báo
    |--------------------------------------------------------------------------
    */
    public function OrderInform(Request $request)
    {
        $this->initialization($request);
        
        $status = $request->status;
        $text = '';

        switch ($status) {
            case 'success':
                $text = "Đơn hàng của bạn đã được tạo thành công, vui lòng kiểm tra email !";
                break;
            case 'error':
                $text = "Xảy ra lỗi !";
                break;

            default:
                // code...
                break;
        }
        return view('desktop.templates.cart.inform', ['text'=>$text]);
    }
}
