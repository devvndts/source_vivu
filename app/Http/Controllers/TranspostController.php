<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;

use App\Transpost\DeliveryAPI;

use Helper;
use CartHelper;

class TransPostController extends Controller
{
    use SupportTrait;

    private $transpost;

    /*
    |--------------------------------------------------------------------------
    | Lấy ds tỉnh thành theo loại phương thức vận chuyển
    |--------------------------------------------------------------------------
    */
    public function GetCity(Request $request)
    {
        $city = $response = array();
        $transpost_type = $request->type;
        $this->transpost = new DeliveryAPI();

        switch ($transpost_type) {
            case 'ViettelPost':
                $result = $this->transpost->getListProvinceViettelPost();
                if ($result['status']==200) {
                    $city = $result['data'];
                }

                $response = array(
                    'city' => $city,
                    'transpost_type' => $transpost_type
                );
                break;
            
            default:
                // code...
                break;
        }

        return view('desktop.templates.transpost.city')->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy ds quận huyện theo loại phương thức vận chuyển
    |--------------------------------------------------------------------------
    */
    public function GetDistrict(Request $request)
    {
        $district = $response = array();
        $id = $request->id;
        $transpost_type = $request->type;
        $this->transpost = new DeliveryAPI();

        switch ($transpost_type) {
            case 'ViettelPost':
                $result = $this->transpost->getListDistrictViettelPost($id);
                if ($result['status']==200) {
                    $district = $result['data'];
                }

                $response = array(
                    'district' => $district,
                    'transpost_type' => $transpost_type
                );
                break;
            
            default:
                // code...
                break;
        }

        return view('desktop.templates.transpost.district')->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy ds phường xã theo loại phương thức vận chuyển
    |--------------------------------------------------------------------------
    */
    public function GetWard(Request $request)
    {
        $ward = $response = array();
        $id = $request->id;
        $transpost_type = $request->type;
        $this->transpost = new DeliveryAPI();

        switch ($transpost_type) {
            case 'ViettelPost':
                $result = $this->transpost->getListWardViettelPost($id);
                if ($result['status']==200) {
                    $ward = $result['data'];
                }

                $response = array(
                    'ward' => $ward,
                    'transpost_type' => $transpost_type
                );
                break;
        }

        return view('desktop.templates.transpost.ward')->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy phí ship
    |--------------------------------------------------------------------------
    */
    public function ServiceShip(Request $request)
    {
        //### khai báo
        $config_delivery = config('delivery.transpost_method');
        $city = $district = $ward = $response = $data = array();
        $weight = $tonggia = 0;

        $transpost_type = $request->type;
        $city = $request->city;
        $district = $request->district;
        $ward = $request->ward;
        $insurance_price = $request->insurance_price;
        $this->transpost = new DeliveryAPI();

        //### lấy thông tin kho hàng
        $inventory = $this->transpost->getListInventoryViettelPost();
        //dd($inventory);
        $inventory = $inventory['data'][1];

        //### xử lý
        $tonggia = CartHelper::get_order_total();
        $infoShip = CartHelper::GetInfoShip();
        $weight = $infoShip['khoiluong'];

        switch ($transpost_type) {
            case 'ViettelPost':
                $data = array(
                    "SENDER_PROVINCE" => $inventory['provinceId'], //$config_delivery[$transpost_type]['SENDER_PROVINCE'],
                    "SENDER_DISTRICT" => $inventory['districtId'], //$config_delivery[$transpost_type]['SENDER_DISTRICT'],
                    "RECEIVER_PROVINCE" => $city,
                    "RECEIVER_DISTRICT" => $district,
                    "PRODUCT_TYPE" => "HH",
                    "PRODUCT_WEIGHT" => $weight,
                    "PRODUCT_PRICE" => $tonggia,
                    "MONEY_COLLECTION" => $tonggia,
                    "TYPE" => 1
                );
                //dd($data);
                $result = $this->transpost->getPriceAllViettelPost($data);
                break;
        }

        //dd($this->transpost);

        $response = array(
            'result' => $result,
            'transpost_type' => $transpost_type,
            'insurance_price' => $insurance_price
        );

        return view('desktop.templates.transpost.serviceprice')->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy thông tin giá
    |--------------------------------------------------------------------------
    */
    public function InfoPrice(Request $request)
    {
        //### Khởi tạo
        $config_delivery = config('delivery.transpost_method');
        $city = $district = $ward = $response = $data = $json = array();
        $weight = $tonggia = 0;

        $transpost_type = $request->type;
        $city = $request->city;
        $district = $request->district;
        $ward = $request->ward;
        $insurance_price = $request->insurance_price;
        $order_service = $request->order_service;

        $this->transpost = new DeliveryAPI();

        //### lấy thông tin kho hàng
        $inventory = $this->transpost->getListInventoryViettelPost();
        $inventory = $inventory['data'][1];

        //### xử lý
        $tonggia = CartHelper::get_order_total();
        $infoShip = CartHelper::GetInfoShip();
        $weight = $infoShip['khoiluong'];
        
        
        $data = array(
            "SENDER_PROVINCE" => $inventory['provinceId'],
            "SENDER_DISTRICT" => $inventory['districtId'],
            "RECEIVER_PROVINCE" => $city,
            "RECEIVER_DISTRICT" => $district,
            "PRODUCT_TYPE" => "HH",
            "PRODUCT_WEIGHT" => $weight,
            "PRODUCT_PRICE" => $tonggia,
            "MONEY_COLLECTION" => $tonggia,
            "TYPE" => 1
        );

        $result = $this->transpost->getPriceAllViettelPost($data);

        foreach ($result as $k => $v) {
            if ($v['MA_DV_CHINH']==$order_service) {
                $ship = $v['GIA_CUOC'];
            }
        }

        if ($result) {
            $json['phiship'] = $ship+$insurance_price;
            $json['phiship_text'] = Helper::Format_Money($ship+$insurance_price);
        }

        return json_encode($json);
    }
}
