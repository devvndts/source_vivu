<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\SupportTrait;

use App\Models\Places;

use App\Transpost\DeliveryAPI;

use Helper, CartHelper;

class TransPostController extends Controller
{
    use SupportTrait;

    private $transpost;


    /*
    |--------------------------------------------------------------------------
    | Lấy ds tỉnh thành theo loại phương thức vận chuyển
    |--------------------------------------------------------------------------
    */
    public function GetPlaces(Request $request){
        $transpost_type = $request->type;
        $transpost_place = $request->place;

        $this->GetCity($transpost_type);        

        return redirect()->route('admin.dashboard');
    }



    /*
    |--------------------------------------------------------------------------
    | Lấy ds tỉnh thành theo loại phương thức vận chuyển
    |--------------------------------------------------------------------------
    */
    public function GetCity($transpost_type=''){
        $city = $response = array();
        $this->transpost = new DeliveryAPI();
        $model = new Places('list');

        switch ($transpost_type) {
            case 'ViettelPost':
                $result = $this->transpost->getListProvinceViettelPost();
                if($result['status']==200){
                    $city = $result['data'];

                    if($city){
                        foreach($city as $k=>$v){
                            //### khởi tạo
                            $id_city = $v['PROVINCE_ID'];
                            $code_city = $v['PROVINCE_CODE'];
                            $name_city = $v['PROVINCE_NAME'];

                            //### kiểm tra tồn tại
                            $city_item = $model->where('id_delivery', $id_city)->where('type', $transpost_type)->first();

                            //### nếu chưa tồn tại thì tạo mới
                            if(!$city_item){
                                //### lưu dữ liệu
                                $data['ten'] = $name_city;
                                $data['type'] = $transpost_type;
                                $data['id_delivery'] = $id_city;
                                $model->SaveProduct($data,null);
                            }
                        }
                    }
                }
            break;
        }

        //### lấy ds quận huyện
        $this->GetDistrict($transpost_type);
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy ds quận huyện theo loại phương thức vận chuyển
    |--------------------------------------------------------------------------
    */
    public function GetDistrict($transpost_type=''){
        $district = $response = array();
        $this->transpost = new DeliveryAPI();
        $city = new Places('list');

        switch ($transpost_type) {
            case 'ViettelPost':
                $cities = $city->GetAllItems(['type'=>$transpost_type]);
                
                $model = new Places('cat');
                if($cities){
                    foreach($cities as $k=>$v){
                        $result = $this->transpost->getListDistrictViettelPost($v['id_delivery']);

                        if($result['status']==200){
                            $districts = $result['data'];

                            if($districts){
                                foreach($districts as $i=>$item){
                                    //### khởi tạo
                                    $id_district = $item['DISTRICT_ID'];
                                    $code_district = $item['DISTRICT_VALUE'];
                                    $name_district = $item['DISTRICT_NAME'];
                                    $idparent_district = $item['PROVINCE_ID']; 

                                    //### kiểm tra tồn tại
                                    $district_item = $model->where('id_delivery', $id_district)->where('type', $transpost_type)->first();

                                    //### nếu chưa tồn tại thì tạo mới
                                    if(!$district_item){
                                        //### lưu dữ liệu
                                        $data['ten'] = $name_district;
                                        $data['type'] = $transpost_type;
                                        $data['id_delivery'] = $id_district;
                                        $data['id_city'] = $v['id_delivery'];
                                        $data['hienthi'] = 1;
                                        $model->SaveProduct($data,null);
                                    }
                                }
                            }
                        }
                    }
                }
            break;
        }

        $this->GetWard($transpost_type);
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy ds phường xã theo loại phương thức vận chuyển
    |--------------------------------------------------------------------------
    */
    public function GetWard($transpost_type=''){
        $ward = $response = array();
        $this->transpost = new DeliveryAPI();
        $district = new Places('cat');

        switch ($transpost_type) {
            case 'ViettelPost':
                $districts = $district->GetAllItems(['type'=>$transpost_type]);
                
                $model = new Places('item');

                if($districts){
                    foreach($districts as $k=>$v){
                        $result = $this->transpost->getListWardViettelPost($v['id_delivery']);

                        if($result['status']==200){
                            $ward = $result['data'];

                            if($ward){
                                foreach($ward as $i=>$item){
                                    //### khởi tạo
                                    $id_ward = $item['WARDS_ID'];
                                    $name_ward = $item['WARDS_NAME'];
                                    $idparent_ward = $item['DISTRICT_ID'];

                                    //### kiểm tra tồn tại
                                    $ward_item = $model->where('id_delivery', $id_ward)->where('type', $transpost_type)->first();

                                    //### nếu chưa tồn tại thì tạo mới
                                    if(!$ward_item){
                                        //### lưu dữ liệu
                                        $data['ten'] = $name_ward;
                                        $data['type'] = $transpost_type;
                                        $data['id_delivery'] = $id_ward;
                                        $data['id_district'] = $v['id_delivery'];
                                        $data['hienthi'] = 1;
                                        $model->SaveProduct($data,null);
                                    }
                                }
                            }
                        }
                    }
                }
            break;
        }
    }
}
