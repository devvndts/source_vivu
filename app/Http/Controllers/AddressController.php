<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\Photo;
use App\Models\Color;
use App\Models\Size;
use App\Models\Brand;
use App\Models\Tags;
use App\Models\ProductOption;
use App\Models\Album;
use App\Models\Places;
use App\Models\Newsletter;
use App\Models\Contact;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Address;

use DB, Session;

use Helper, Thumb;
use CartHelper;


class AddressController extends DesktopController
{
    private $model;

    /*
    |--------------------------------------------------------------------------
    | show form thêm địa chỉ
    |--------------------------------------------------------------------------
    */
    public function Show(Request $request){
        $id = $request->id;
        $this->model = new Address();
        $row_address = $this->model->GetOneItem($id);

        //### xử lý
        $city = new Places('list');
        $city = $city->GetAllItems();

        $district = new Places('cat');
        $district = $district->GetAllItems(['id_city'=>$row_address['id_city']]);

        $ward = new Places('item');
        $ward = $ward->GetAllItems(['id_district'=>$row_address['id_district']]);


        //### Phản hồi
        $response = array(
            "city" => $city,
            "district" => $district,
            "ward" => $ward,
            "row_address" => $row_address
        );
        return view('desktop.templates.address.address_add')->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Chọn địa chỉ mặc định nhận hàng
    |--------------------------------------------------------------------------
    */
    public function SelectDefault(Request $request){
        //### thiết lập biến khởi tạo
        $id_login = Helper::GetCookie('login_member_id');
        $token_member_cart = Helper::GetCookie('member_cart');


        $address = new Address();
        $user_address = $address->GetAllItems(['id_user'=>$id_login]);

        //### Phản hồi
        $response = array(
            "user_address" => $user_address,
        );

        return view('desktop.templates.address.address_select')->with($response);
    }


    /*
    |--------------------------------------------------------------------------
    | Lưu địa chỉ mặc định
    |--------------------------------------------------------------------------
    */
    public function SaveDefault(Request $request){
        //### thiết lập biến khởi tạo
        $id_login = Helper::GetCookie('login_member_id');
        $token_member_cart = Helper::GetCookie('member_cart');
        $id = $request->id;
        $result['login']=false;
        if($id_login>0){
            //### Xử lý: chuyển tất cả địa chỉ hiện có của tài khoản hiện tại với is_default thành 0
            $address = new Address();
            $address->UpdateItemByParam(['id_user'=>$id_login],['is_default'=>0]);
            //### Xử lý: cập nhật lại đia chỉ với id truyền vào => is_default thành 1
            $address = new Address();
            $address->UpdateItemByParam(['id'=>$id],['is_default'=>1]);
            $result['login']=true;
        }

        //### Response
        return json_encode($result);
    }


    /*
    |--------------------------------------------------------------------------
    | Lưu dữ liệu
    |--------------------------------------------------------------------------
    */
    public function Add(Request $request){
        $this->model = new Address();

        //### thiết lập biến khởi tạo
        $id_login = Helper::GetCookie('login_member_id');
        $token_member_cart = Helper::GetCookie('member_cart');

        $id = $request->id;
        $data = $request->data;
        $data['id_user'] = $id_login;

        $this->model->SaveItem($data,$id);
        return redirect()->back();
    }
}
