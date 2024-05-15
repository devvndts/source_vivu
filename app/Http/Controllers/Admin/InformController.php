<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Helper;

class InformController extends Controller
{
    //
    private $config, $url, $apiKey, $apiSecret, $config_lazada, $lazadaUrl_callback, $lazadaUrlAuth, $active_lazada;


    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function initialization(Request $request){
        $this->config_lazada = config('lazada');
        $this->active_lazada = $this->config_lazada['active'];

        $this->lazadaUrl = $this->config_lazada['url'];
        $this->lazadaUrlAuth = $this->config_lazada['url_auth'];
        $this->lazadaUrl_callback = $this->config_lazada['url_callback'];
        $this->apiKey = $this->config_lazada['apiKey'];
        $this->apiSecret = $this->config_lazada['apiSecret']; 
    }


    public function ExpireToken(Request $request){
        $this->initialization($request);
        $setting = app('setting');

        $url = "https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri=".$this->lazadaUrl_callback."&client_id=".$this->apiKey;

        if($setting['authorCode_lazada']=='' || ($setting['expiryDateToken_lazada']>0 && time()>$setting['expiryDateToken_lazada']) ){ //### nếu chưa có code author ==> chạy link đăng nhập để lấy code author
            $response = array(
                'url' => $url,
                'other_title' => "Thông báo lỗi"
            );

            return view('admin.templates.inform.expiretoken')->with($response);

        }else{ //### nếu đã có code author ==> có thể thực hiện phương thức lấy access token
            return redirect()->route('admin.dashboard');
        }
    }
}
