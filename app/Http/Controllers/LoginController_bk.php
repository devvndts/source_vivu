<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\SupportTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


use App\Jobs\SendEmail;
use App\Mail\MailNotify;

use App\Models\User;

use Validator, Helper;
use Mail;

class LoginController extends Controller
{
    use SupportTrait;

    private $model;
    private $setting_opt;

    public function __construct(Request $request){
        $this->init($request);
        $this->model = new User();
        $this->setting_opt = $this->GetSettingOption('setting');
        Helper::SetConfigMail($this->setting_opt);
    }

    /*
    |--------------------------------------------------------------------------
    | Đăng ký
    |--------------------------------------------------------------------------
    */
    public function Signin(Request $request)
    {
        $alert = array();

        //### kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'username' => 'bail|required|min:6|unique:users',
            'password' => 'bail|required|min:8',
            'repassword' => 'bail|required|same:password',
            'name' => 'bail|required',
            'phonenumber' => 'bail|required',
            'email' => 'bail|required|email|unique:users',
        ]);


        //### xử lý
        if ($validator->fails()) {
            $alert_text = '<h4>'.thongbao.'</h4>';
            $arr_error = $validator->messages()->toArray();
            if($arr_error){
                foreach($arr_error as $k=>$v){
                    if($k=='username'){
                        $alert_text .= "<p>-".tendangnhapcokytu."</p>";
                    }
                    if($k=='password'){
                        $alert_text .= "<p>-".matkhaucokytu."</p>";
                    }
                    if($k=='repassword'){
                        $alert_text .= "<p>-".matkhaukhongtrungkhop."</p>";
                    }
                    if($k=='name'){
                        $alert_text .= "<p>-".chuanhaphoten."</p>";
                    }
                    if($k=='phonenumber'){
                        $alert_text .= "<p>-".chuanhapsodienthoai."</p>";
                    }
                    if($k=='email'){
                        $alert_text .= "<p>-".emaildatontaihoachuanhap."</p>";
                    }
                }
            }
            //$alert_text .= '</div>';

            $alert['icon']='error';
            $alert['text']=$alert_text;

        }else{
            $data_input = $request->input();
            if($data_input['password']!='' && $data_input['password']==$data_input['repassword']){
                $data_input['password'] = bcrypt($data_input['password']);
            }
            $this->model->create($data_input);

            $alert['icon']='success';
            $alert['text']=dangkythanhcong;

            //### gửi mail thông báo tới người mua hàng
            if($data_input['email'] != ''){
                $message = array();
                $message['tieude'] = "Đăng ký thành viên";
                $message['file']='';
                $message['setting'] = $this->setting_opt;
                Mail::to($data_input['email'])->send(new MailNotify($message,$data_input,'signin'));
            }
        }

        return json_encode($alert);
    }


    /*
    |--------------------------------------------------------------------------
    | Đăng nhập
    |--------------------------------------------------------------------------
    */
    public function Login(Request $request)
    {
        $alert = array();

        if ($request->getMethod() == 'GET') {
            if (Auth::guard()->check()) {
                return redirect()->route('home');
            }
            return view('desktop.templates.account.login');
        }

        //### đã đăng nhập
        if(Auth::guard()->check()){
            $alert['icon']='warning';
            $alert['text']=taikhoannaydadangnhap;
        }else{ //### chưa đăng nhập
            $credentials = array();
            $credentials['username'] = $username = (isset($request->username))?$request->username:'';
            $credentials['password'] = $password = (isset($request->password))?$request->password:'';
            $remember_token = (isset($request->remember_token))?true:false;

            //### kiểm tra tài khoản đã kích hoạt?
            $check_user = User::select('kichhoat')->where('username',$username)->first();
            if(isset($check_user) && $check_user->kichhoat==0){
                $alert['icon']='error';
                $alert['text']=taikhoanchuaduockichhoat;
                return json_encode($alert);
            }

            //### kiểm tra thông tin đăng nhập
            if (Auth::guard()->attempt($credentials,$remember_token)) {
                $this->init($request);
                $alert['icon']='success';
                $alert['text']=dangnhapthanhcong;
            } else {
                $alert['icon']='error';
                $alert['text']=saithongtindangnhap;
            }
        }
        return json_encode($alert);
    }


    /*
    |--------------------------------------------------------------------------
    | Reset mật khẩu
    |--------------------------------------------------------------------------
    */
    public function Reset(Request $request)
    {
        $alert = array();

        $data_input = $request->input();
        $username = $data_input['username'];
        $email = $data_input['email'];

        $check_user = $this->model->where('username',$username)->where('email',$email)->first();
        if(isset($check_user)){
            $new_password = $data_input['password'] = Str::random(8);
            $update = User::find($check_user->id);
            $update->password = bcrypt($new_password);
            if($update->save()){
                $alert['icon']='success';
                $alert['text']=dathaydoimatkhau;

                //### gửi mail thông báo sau khi thay đổi mật khẩu
                if($email != ''){
                    $message = array();
                    $message['tieude'] = thaydoimatkhaudangnhap;
                    $message['file']='';
                    $message['setting'] = $this->setting_opt;
                    Mail::to($email)->send(new MailNotify($message,$data_input,'resetlogin'));
                }
            }else{
                $alert['icon']='error';
                $alert['text']=coloixayra;
            }
        }else{
            $alert['icon']='error';
            $alert['text']=taikhoannaykhongtontai;
        }
        return json_encode($alert);
    }


    /*
    |--------------------------------------------------------------------------
    | Kích hoạt tài khoản
    |--------------------------------------------------------------------------
    */
    public function Active(Request $request){
        $email = $request->email;
        $check_email = $this->model->where($this->model->raw('md5(email)'),$email)->first();
        if(isset($check_email) && $check_email->kichhoat==0){
            $update = User::find($check_email->id);
            $update->kichhoat = 1;
            $update->save();
            $message_inform = dakichhoattaikhoanthanhcong;
        }else{
            $message_inform = taikhoannaydaduockichhoat;
        }
        return view('desktop.templates.inform.success')->with('message_inform',$message_inform);
    }


    /*
    |--------------------------------------------------------------------------
    | Thông tin tài khoản
    |--------------------------------------------------------------------------
    */
    public function Information(Request $request){
        if(!Auth::guard()->check()){
            return redirect()->route('home');
        }

        $rowItem = Auth::guard()->user();
        $title_crumb = taikhoan;
        if ($request->getMethod() == 'GET') {
            $response = array(
                "rowItem" => $rowItem,
                "title_crumb" => $title_crumb
            );
            return view('desktop.templates.account.information')->with($response);
        }else{
            $data['name'] = $request->name;
            $data['diachi'] = $request->diachi;
            $data['ngaysinh'] = strtotime(str_replace("/","-",$request->ngaysinh));
            $data['gioitinh'] = $request->gioitinh;
            if(($request->password!='' && Hash::check($request->password,$rowItem->password)) && $request->new_password !='' && $request->new_password==$request->new_password_confirm){
                $data['password'] = bcrypt($request->new_password);
            }

            $this->model->find($rowItem->id)->update($data);
            //Auth::guard()->logout();
            return redirect()->route('home');
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Quản lý đơn hàng
    |--------------------------------------------------------------------------
    */
    public function OrderManage(Request $request){
        dd('order manage');
    }


    /*
    |--------------------------------------------------------------------------
    | Đăng xuất
    |--------------------------------------------------------------------------
    */
    public function Logout(Request $request){
        if(Auth::guard()->check()){
            $data['social_id'] = '';
            $this->model->find(Auth::guard()->user()->id)->update($data);

            Auth::guard()->logout();
        }
        Helper::SetCookieLogin('login_member_id', Auth::guard()->check());
        return redirect()->route('home');
    }
}
