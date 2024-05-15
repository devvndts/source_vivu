<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Webhook;
use Helper;
class WebhookController extends Controller
{
    public function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
    /**
     * get access token from header
     * */
    public function getBearerToken() {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
    //
    public function handle(Request $request)
    {
        // $model = $this->staticRepo;
        // $rowItem = $model->GetItem(['type'=>$type]);
        // echo '<pre style="color: red">'; print_r($rowItem); echo '</pre>';
        // $getAllRecord = $this->webhookRepo->GetItems();
        // echo '<pre style="color: red">'; print_r($getAllRecord); echo '</pre>';
        // ini_set("log_errors", 1);
        // ini_set("error_log", "log.txt");
        // error_log(file_get_contents("php://input"));
        $dataJson = json_decode(file_get_contents("php://input"),true);
        // $strJson = '{"DATA":{"ORDER_NUMBER":"1684063821201","ORDER_REFERENCE":"1684063821201","ORDER_STATUSDATE":"21/04/2022 06:21:31","ORDER_STATUS":400,"STATUS_NAME":"Nhận bảng kê đến","LOCALION_CURRENTLY":"HCM, TTKT3, Trung tâm khai thác 3 - Hồ Chí Minh, 02862938169, 729003, PHƯỜNG TRUNG MỸ TÂY","NOTE":"Nhan tai","MONEY_COLLECTION":36001,"MONEY_FEECOD":4630,"MONEY_TOTALFEE":28704,"MONEY_TOTAL":36001,"EXPECTED_DELIVERY":"Khoảng 3 ngày làm việc","PRODUCT_WEIGHT":240,"ORDER_SERVICE":"LCOD","ORDER_PAYMENT":4,"EXPECTED_DELIVERY_DATE":"24/04/2022 00:00:00","DETAIL":[{"CODE":"HGC","VALUE":4630}],"VOUCHER_VALUE":0,"MONEY_COLLECTION_ORIGIN":0,"EMPLOYEE_NAME":"Nguyễn Văn Vinh","EMPLOYEE_PHONE":"84372072030"},"TOKEN":"8805"}';
        // $dataJson = json_decode($strJson,true);
        $dataFromHook = $dataJson["DATA"];

        // $order_number = "1684063821201";
        // $order_statusdate = "21/04/2022 06:21:31";
        // $order_status = 400;
        $order_number = $dataFromHook["ORDER_NUMBER"];
        $order_statusdate = $dataFromHook["ORDER_STATUSDATE"];
        $order_status = $dataFromHook["ORDER_STATUS"];
        $findExistItem = Webhook::where('order_number', $order_number)
        ->where('order_statusdate', $order_statusdate)
        ->where('order_status', $order_status)->first();
        // var_dump($findExistItem);
        if (!$findExistItem) {
            $webhook = new Webhook;
            $webhook->order_number = $dataFromHook["ORDER_NUMBER"];
            $webhook->order_reference = $dataFromHook["ORDER_REFERENCE"];
            $webhook->order_statusdate = $dataFromHook["ORDER_STATUSDATE"];
            $webhook->order_status = $dataFromHook["ORDER_STATUS"];
            $webhook->note = $dataFromHook["NOTE"];
            $webhook->expected_delivery = $dataFromHook["EXPECTED_DELIVERY"];
            $webhook->status_name = $dataFromHook["STATUS_NAME"];
            $webhook->localion_currently = $dataFromHook["LOCALION_CURRENTLY"];
            $webhook->expected_delivery_date = $dataFromHook["EXPECTED_DELIVERY_DATE"];
            $webhook->save();
        } 
        // [19-May-2022 15:55:53 Asia/Ho_Chi_Minh] {"DATA":{"ORDER_NUMBER":"1684063821201","ORDER_REFERENCE":"1684063821201","ORDER_STATUSDATE":"21/04/2022 06:21:31","ORDER_STATUS":400,"STATUS_NAME":"Nhận bảng kê đến","LOCALION_CURRENTLY":"HCM, TTKT3, Trung tâm khai thác 3 - Hồ Chí Minh, 02862938169, 729003, PHƯỜNG TRUNG MỸ TÂY","NOTE":"Nhan tai","MONEY_COLLECTION":36001,"MONEY_FEECOD":4630,"MONEY_TOTALFEE":28704,"MONEY_TOTAL":36001,"EXPECTED_DELIVERY":"Khoảng 3 ngày làm việc","PRODUCT_WEIGHT":240,"ORDER_SERVICE":"LCOD","ORDER_PAYMENT":4,"EXPECTED_DELIVERY_DATE":"24/04/2022 00:00:00","DETAIL":[{"CODE":"HGC","VALUE":4630}],"VOUCHER_VALUE":0,"MONEY_COLLECTION_ORIGIN":0,"EMPLOYEE_NAME":"Nguyễn Văn Vinh","EMPLOYEE_PHONE":"84372072030"},"TOKEN":"8805"}
        // [19-May-2022 15:55:53 Asia/Ho_Chi_Minh] {"DATA":{"ORDER_NUMBER":"1684063821201","ORDER_REFERENCE":"1684063821201","ORDER_STATUSDATE":"24/04/2022 10:46:59","ORDER_STATUS":400,"STATUS_NAME":"Nhận bảng kê đến","LOCALION_CURRENTLY":"HNI, TTKT1, Trung tâm khai thác 1 - Hà Nội, 0869578091, 128013, PHƯỜNG MINH KHAI","NOTE":"Nhan tai","MONEY_COLLECTION":36001,"MONEY_FEECOD":4630,"MONEY_TOTALFEE":28704,"MONEY_TOTAL":36001,"EXPECTED_DELIVERY":"Khoảng 3 ngày làm việc","PRODUCT_WEIGHT":240,"ORDER_SERVICE":"LCOD","ORDER_PAYMENT":4,"EXPECTED_DELIVERY_DATE":"24/04/2022 00:00:00","DETAIL":[{"CODE":"HGC","VALUE":4630}],"VOUCHER_VALUE":0,"MONEY_COLLECTION_ORIGIN":0,"EMPLOYEE_NAME":"Hoàng Duy Dương","EMPLOYEE_PHONE":"84824918991"},"TOKEN":"8805"}
    }
}
