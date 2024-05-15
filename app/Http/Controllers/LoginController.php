<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\SupportTrait;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\Account\SigninRequest;

use App\Jobs\SendEmail;
use App\Mail\MailNotify;

use App\Models\User;

use App\Esms\EsmsAPI;

use Validator;
use Helper;
use TableManipulation;
use Mail;
use File;
use App\Rules\OldPasswordRule;
class LoginController extends Controller
{
    use SupportTrait;

    private $model;
    private $setting_opt;
    private $esms;

    public function initialization(Request $request)
    {
        $this->init($request);
        // $this->model = new User();
        $this->model = $this->userRepo;
        $this->setting_opt = $this->GetSettingOption('setting');
        Helper::SetConfigMail($this->setting_opt);
        // $this->esms = new EsmsAPI();
    }

    public function Status(Request $request)
    {
        $this->initialization($request);

        if (isset($request->id)) {
            $id = $request->id;
            $model = (isset($request->model)) ? $request->model : '';
            $level = (isset($request->level)) ? $request->level : '';
            $loai = (isset($request->loai)) ? $request->loai : '';

            $model = Helper::Get_model($model, $level);
            //$row = $model->where('id', $id)->first()->toArray();
            $row = $model->GetOneItem($id);
            $data[$loai] = ($row[$loai]>0)?0:1;

            $model->SaveItem($data, $id);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Đăng ký
    |--------------------------------------------------------------------------
    */
    public function Signin(Request $request)
    {
        $this->initialization($request);

        if ($request->getMethod() == 'GET') {
            return view('desktop.templates.account.signin');
        }

        $alert = array();

        $pattern = [
            'username' => 'bail|required|min:6|unique:users',
            'password' => 'bail|required|min:8',
            'repassword' => 'bail|required|same:password',
            'name' => 'bail|required',
            'phonenumber' => 'bail|required',
            'email' => 'bail|required|email|unique:users',
            'ngaysinh' => 'bail|required|date_format:d/m/Y',
            'dieukhoan' =>'accepted'
        ];


        $messenger = [
            'required' => ':attribute không được để trống',
            'min' => ':attribute không được nhỏ hơn :min ký tự',
            'max' => ':attribute không được lớn hơn :max ký tự',
            'unique' => ':attribute đã tồn tại',
            'same' => ':attribute chưa chính xác',
            'ngaysinh' => ':attribute sai định dạng',
            'accepted' => ':attribute chưa xác nhận',
        ];


        $customName = [
            'username' => 'Tên tài khoản',
            'password' => 'Mật khẩu',
            'repassword' => 'Mật khẩu',
            'name' => 'Họ tên',
            'phonenumber' => 'Số điện thoại',
            'email' => 'Email',
            'ngaysinh' => 'Ngày sinh',
            'dieukhoan' =>'Điều khoản chính sách'
        ];

        $validator = Validator::make($request->all(), $pattern, $messenger, $customName);

        //### xử lý
        if ($validator->fails()) {
            return redirect()->route('account.signin')->withErrors($validator)->withInput();
        } else {
            $data_input = $request->input();
            if ($data_input['password']!='' && $data_input['password']==$data_input['repassword']) {
                $data_input['password'] = bcrypt($data_input['password']);
            }

            if ($data_input['ngaysinh']!='') {
                // $data_input['ngaysinh'] = Helper::ChangeDate($data_input['ngaysinh']);
                $data_input['ngaysinh'] = strtotime($data_input['ngaysinh']);
            }
            $this->model->SaveItem($data_input);
            //dd($data_input);

            //### gửi mail thông báo tới người mua hàng
            if ($data_input['email'] != '') {
                $message = array();
                $message['tieude'] = dangkythanhvien;
                $message['file']='';
                $message['setting'] = $this->setting_opt;
                Mail::to($data_input['email'])->send(new MailNotify($message, $data_input, 'signin'));
            }
        }

        return redirect()->route('account.inform', ['hasSignin']);
        //return redirect()->route('account.login');
    }



    /*
    |--------------------------------------------------------------------------
    | Đăng nhập
    |--------------------------------------------------------------------------
    */
    public function Login(Request $request)
    {
        $this->initialization($request);

        //### kiểm tra tk có đang đăng nhập
        if (Auth::guard()->check()) {
            return redirect()->route('account.inform', ['hasLogin']);
        }

        if ($request->getMethod() == 'GET') {
            return view('desktop.templates.account.login');
        }

        //### xử lý validation dữ liệu đầu vào
        $pattern = [
            'username' => 'bail|required',
            'password' => 'bail|required',
        ];


        $messenger = [
            'required' => ':attribute không được để trống',
        ];


        $customName = [
            'username' => 'Tên tài khoản',
            'password' => 'Mật khẩu',
        ];


        $validator = Validator::make($request->all(), $pattern, $messenger, $customName);

        if ($validator->fails()) {
            return redirect()->route('account.login')->withErrors($validator)->withInput();
        }


        //### đã đăng nhập
        if (!Auth::guard()->check()) {
            $credentials = array();
            $credentials['username'] = $username = (isset($request->username))?$request->username:'';
            $credentials['password'] = $password = (isset($request->password))?$request->password:'';
            $remember_token = (isset($request->remember_token))?true:false;

            //### kiểm tra tài khoản đã kích hoạt?
            $check_user = User::select('kichhoat')->where('username', $username)->first();
            if (isset($check_user) && $check_user->kichhoat==0) {
                return redirect()->route('account.inform', ['notActive']);
                /*$settingOptions = app('settingOptions');
                return redirect()->route('account.login')->withErrors(['iskichhoat'=>'Tài khoản của bạn bị tắt kích hoạt. Lý do bị tắt kích hoạt do bạn vi phạm các điều khoản bạn đã cam kết khi tham gia website hoặc vi phạm thuần phong mỹ tục. Vui lòng liên hệ admin theo số zalo '.$settingOptions['zalo'].' để được hỗ trợ'])->withInput();*/
            }

            //### kiểm tra thông tin đăng nhập
            if (Auth::guard()->attempt($credentials, $remember_token)) {
                $this->init($request);

                //### tạo folder cho tài khoản trong elfinder
                $path = public_path().'/elfinder/upload/elfinder/'.md5($check_user->id);
                File::makeDirectory($path, $mode = 0777, true, true);
                session(['id_elfinder' => md5($check_user->id)]);


                //### kiểm tra kích hoạt user
                $user = Auth::guard()->user();
                if ($user->kichhoat==0) {
                    Auth::guard()->logout();
                    return redirect()->route('account.inform', ['notActive']);
                } else {
                    return redirect()->route('home');
                }
                
            //return redirect()->route('account.inform', ['successLogin']);
            } else {
                return redirect()->route('account.login')->withErrors(['iskichhoat'=>'Thông tin đăng nhập không chính xác'])->withInput();
            }
        }

        return redirect()->route('home');
    }


    /*
    |--------------------------------------------------------------------------
    | Reset mật khẩu
    |--------------------------------------------------------------------------
    */
    public function Reset(Request $request)
    {
        $this->initialization($request);

        if ($request->getMethod() == 'GET') {
            return view('desktop.templates.account.reset');
        }

        $alert = array();

        $data_input = $request->input();
        //$username = $data_input['username'];
        $email = $data_input['email'];
        


        $check_user = $this->model->where('email', $email)->first();
        if (isset($check_user)) {
            $data_input['username'] = $check_user->username;
            $new_password = $data_input['password'] = Str::random(8);
            $update = User::find($check_user->id);
            $update->password = bcrypt($new_password);
            if ($update->save()) {
                $alert['icon']='success';
                $alert['text']=dathaydoimatkhau;

                //### gửi mail thông báo sau khi thay đổi mật khẩu
                if ($email != '') {
                    $message = array();
                    $message['tieude'] = thaydoimatkhaudangnhap;
                    $message['file']='';
                    $message['setting'] = $this->setting_opt;
                    Mail::to($email)->send(new MailNotify($message, $data_input, 'resetlogin'));
                }
                return redirect()->route('account.inform', ['successReset']);
            } else {
                return redirect()->route('account.inform', ['errorReset']);
            }
        } else {
            return redirect()->route('account.inform', ['notExist']);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Kích hoạt tài khoản
    |--------------------------------------------------------------------------
    */
    public function Active(Request $request)
    {
        $this->initialization($request);

        $email = $request->email;
        $check_email = $this->model->where($this->model->raw('md5(email)'), $email)->first();
        if (isset($check_email) && $check_email->kichhoat==0) {
            $update = User::find($check_email->id);
            $update->kichhoat = 1;
            $update->save();
            $message_inform = dakichhoattaikhoanthanhcong;
        } else {
            $message_inform = taikhoannaydaduockichhoat;
        }
        return view('desktop.templates.inform.success')->with('message_inform', $message_inform);
    }


    /*
    |--------------------------------------------------------------------------
    | Thông tin tài khoản
    |--------------------------------------------------------------------------
    */
    public function Information(Request $request)
    {
        $this->initialization($request);

        if (!Auth::guard()->check()) {
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
        } else {
            $pattern = [
                'username' => "bail|required|min:6|unique:users,username,$rowItem->id",
                'password' => ['bail', 'required', 'min:8', new OldPasswordRule],
                'new_password' => 'bail|required|min:8',
                'new_password_confirmation' => 'bail|required|same:new_password',
                'name' => 'bail|required',
                'phonenumber' => 'bail|required',
                'email' => "bail|required|email|unique:users,email,$rowItem->id",
                // 'ngaysinh' => 'bail|required|date_format:d/m/Y',
            ];
    
    
            $messenger = [
                'required' => ':attribute không được để trống',
                'min' => ':attribute không được nhỏ hơn :min ký tự',
                'max' => ':attribute không được lớn hơn :max ký tự',
                'unique' => ':attribute đã tồn tại',
                'same' => ':attribute chưa chính xác',
                'ngaysinh' => ':attribute sai định dạng',
            ];
    
    
            $customName = [
                'username' => 'Tên tài khoản',
                'password' => 'Mật khẩu cũ',
                'new_password' => 'Mật khẩu mới',
                'new_password_confirmation' => 'Nhập lại mật khẩu mới',
                'name' => 'Họ tên',
                'phonenumber' => 'Số điện thoại',
                'email' => 'Email',
                'ngaysinh' => 'Ngày sinh',
            ];
    
            $validator = Validator::make($request->all(), $pattern, $messenger, $customName);

            if ($validator->fails()) {
                return redirect()->route('account.information')->withErrors($validator)->withInput();
            } else {
                $data['name'] = $request->name;
                $data['diachi'] = $request->diachi;
                $data['ngaysinh'] = strtotime(str_replace("/", "-", $request->ngaysinh));
                // $data['gioitinh'] = $request->gioitinh;
                if (($request->password!=''
                    && Hash::check($request->password, $rowItem->password))
                    && $request->new_password !=''
                    && $request->new_password==$request->new_password_confirmation
                ) {
                    $data['password'] = bcrypt($request->new_password);
                }

                User::find($rowItem->id)->update($data);
                //Auth::guard()->logout();
                return redirect()->route('account.information');
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Quản lý đơn hàng
    |--------------------------------------------------------------------------
    */
    public function OrderManage(Request $request)
    {
        $this->initialization($request);

        dd('order manage');
    }


    /*
    |--------------------------------------------------------------------------
    | Quản lý thông báo login
    |--------------------------------------------------------------------------
    */
    public function Inform(Request $request)
    {
        $this->initialization($request);

        $option = $request->option;
        $icon = $text = $description = '';
        $class = '';
        $settingOptions = app('settingOptions');
            
        switch ($option) {
            case 'hasSignin': // Nếu tk đã đang đăng nhập
                $icon = 'hasSignin';
                $text = 'Thành công!';
                $class = 'classSuccess';
                $description = 'Đăng ký tài khoản thành công. Bạn có thể đăng nhập ngay bây giờ !';
                $bg = 'bgSuccess';
                break;

            case 'hasLogin': // Nếu tk đã đang đăng nhập
                $icon = 'hasLogin';
                $text = 'Cảnh báo!';
                $class = 'classWarning';
                $description = 'Tài khoản của bạn hiện tại đã đăng nhập !';
                $bg = 'bgWarning';
                break;

            case 'successLogin': // Nếu đăng nhập thành công
                $icon = 'successLogin';
                $text = 'Thành công!';
                $class = 'classSuccess';
                $description = 'Tài khoản hợp lệ, đăng nhập thành công!';
                $bg = 'bgSuccess';
                break;

            case 'errorLogin': // Nếu đăng nhập thành công
                $icon = 'errorLogin';
                $text = 'Xảy ra lỗi!';
                $class = 'classError';
                $description = 'Xảy ra lỗi trong quá trình đăng nhập. Vui lòng thực hiện lại!';
                $bg = 'bgError';
                break;

            case 'notLogin': // Nếu đăng nhập thành công
                $icon = 'errorLogin';
                $text = 'Xảy ra lỗi!';
                $class = 'classError';
                $description = "Hệ thống phát hiện tài khoản chưa đăng nhập. Vui lòng đăng nhập để tiếp tục";
                $bg = 'bgError';
                break;

            case 'notExist': // Nếu tài khoản ko tồn tại
                $icon = 'errorLogin';
                $text = 'Xảy ra lỗi!';
                $class = 'classError';
                $description = "Hệ thống phát hiện tài khoản email này không tồn tại !";
                $bg = 'bgError';
                break;

            case 'successReset': // Nếu tài khoản ko tồn tại
                $icon = 'successReset';
                $text = 'Thành công!';
                $class = 'classSuccess';
                $description = "Quá trình tạo mật khẩu mới thành công! Kiểm tra email để nhận mật khẩu mới";
                $bg = 'bgSuccess';
                break;

            case 'errorReset': // Nếu tài khoản ko tồn tại
                $icon = 'errorLogin';
                $text = 'Xảy ra lỗi!';
                $class = 'classError';
                $description = "Xảy ra lỗi trong quá trình cài lại mật khẩu!";
                $bg = 'bgError';
                break;

            case 'successEditpass': // Nếu tài khoản ko tồn tại
                $icon = 'successEditpass';
                $text = 'Thành công!';
                $class = 'classSuccess';
                $description = "Thay đổi mật khẩu thành công !";
                $bg = 'bgSuccess';
                break;

            case 'errorEditpass': // Nếu tài khoản ko tồn tại
                $icon = 'errorReset';
                $text = 'Xảy ra lỗi!';
                $class = 'classError';
                $description = "Xảy ra lỗi trong quá trình thay đổi mật khẩu!";
                $bg = 'bgError';
                break;

            case 'hasPostNews': // Nếu tài khoản ko tồn tại
                $icon = 'successEditpass';
                $text = 'Thành công!';
                $class = 'classSuccess';
                $description = "Quá trình đăng tin đã hoàn thành. Kiểm tra danh sách tin đăng để xem thông tin chi tiết";
                $bg = 'bgSuccess';
                break;

            case 'notExistPostnews': // Nếu tài khoản ko tồn tại
                $icon = 'errorReset';
                $text = 'Xảy ra lỗi!';
                $class = 'classError';
                $description = "Không tìm thấy trang tin đăng để chỉnh sửa. Vui lòng kiểm tra lại đường dẫn có hợp lệ ";
                $bg = 'bgError';
                break;

            case 'hasReport': // Nếu tài khoản ko tồn tại
                $icon = 'successEditpass';
                $text = 'Thành công!';
                $class = 'classSuccess';
                $description = "Hệ thống đã nhận được yêu cầu đóng góp của bạn. Quản trị viên sẽ xem xét đóng góp của bạn trong thời gian sớm nhất ! ";
                $bg = 'bgSuccess';
                break;

            case 'hasError': // Nếu tài khoản ko tồn tại
                $icon = 'errorReset';
                $text = 'Xảy ra lỗi!';
                $class = 'classError';
                $description = "Xảy ra lỗi trong quá trình gửi yêu cầu. Vui lòng thực hiện lại !";
                $bg = 'bgError';
                break;

            case 'successAddcoin': // Nếu tk đã đang đăng nhập
                $icon = 'successLogin';
                $text = 'Thành công!';
                $class = 'classSuccess';
                $description = 'Gửi yêu cầu nạp xu thành công . Theo dõi thông báo từ hệ thống để cập nhật thông tin !';
                $bg = 'bgSuccess';
                break;

            case 'successVIP': // Nếu tk đã đang đăng nhập
                $icon = 'successLogin';
                $text = 'Thành công!';
                $class = 'classSuccess';
                $description = 'Đăng ký gói tin xem theo tháng thành công !';
                $bg = 'bgSuccess';
                break;

            case 'notActive': // Nếu tk đã đang đăng nhập
                $icon = 'errorReset';
                $text = 'Hệ thống cảnh báo!';
                $class = 'classError';
                $description = 'Tài khoản của bạn bị tắt kích hoạt. Lý do bị tắt kích hoạt do bạn vi phạm các điều khoản bạn đã cam kết khi tham gia website hoặc vi phạm thuần phong mỹ tục. Vui lòng liên hệ admin theo số zalo '.$settingOptions['zalo'].' để được hỗ trợ';
                $bg = 'bgError';
                break;
        }


        $response = array(
            'icon' => $icon,
            'text' => $text,
            'description' => $description,
            'class' => $class,
            'bg' => $bg
        );

        return view('desktop.templates.account.inform', $response);
    }


    /*
    |--------------------------------------------------------------------------
    | Đăng xuất
    |--------------------------------------------------------------------------
    */
    public function Logout(Request $request)
    {
        $this->initialization($request);

        if (Auth::guard()->check()) {
            $data['social_id'] = '';
            User::find(Auth::guard()->user()->id)->update($data);

            Auth::guard()->logout();
        }
        Helper::SetCookieLogin('login_member_id', Auth::guard()->check());
        return redirect()->route('home');
    }


    /*
    |--------------------------------------------------------------------------
    | Quản lý tài khoản
    |--------------------------------------------------------------------------
    */
    public function Manage(Request $request)
    {
        $this->initialization($request);

        //### test send otp
        //$otp = rand(1,999999);
        //dd($this->esms->SendSMS('0962865246',$otp)); //0962865246


        //### kiểm tra đăng nhập
        if (Auth::guard()->check()) {
            //### hiển thị thông tin user
            $user = Auth::guard()->user();

            $response = array(
                'user' => ($user) ? $user->toArray() : null
            );

            //### kiểm tra method
            if ($request->getMethod() == 'GET') {
                //## lấy ds ngân hàng
                $response['nganhangs'] = $this->postRepo->GetAllItems('nganhang', ['hienthi'=>1]);
                $response['nganhang_active'] = $this->postRepo->GetOneItem($user->nganhang);

                return view('desktop.templates.account.manage', $response);
            } else {
                //### xử lý validation
                $alert = array();
                //$request->ngaysinh = Helper::ChangeDate($request->ngaysinh);

                $pattern = [
                    //'username' => 'bail|required|min:6|unique:users',
                    'name' => 'bail|required',
                    'phonenumber' => 'bail|required',
                    'email' => 'bail|required|email',
                    'ngaysinh' => 'bail|required|date_format:d/m/Y',
                    'nganhang' => 'bail|required|numeric',
                    'sotaikhoan' => 'bail|required|numeric',
                    'somomo' => 'bail|required',
                ];


                $messenger = [
                    'required' => ':attribute không được để trống',
                    'min' => ':attribute không được nhỏ hơn :min ký tự',
                    'max' => ':attribute không được lớn hơn :max ký tự',
                    'unique' => ':attribute đã tồn tại',
                    'same' => ':attribute chưa chính xác',
                    'ngaysinh' => ':attribute sai định dạng',
                    'nganhang' => ':attribute sai định dạng',
                    'sotaikhoan' => ':attribute sai định dạng',
                    'somomo' => ':attribute sai định dạng',
                ];


                $customName = [
                    //'username' => 'Tên tài khoản',
                    'name' => 'Họ tên',
                    'phonenumber' => 'Số điện thoại',
                    'email' => 'Email',
                    'ngaysinh' => 'Ngày sinh',
                    'nganhang' => 'Giá trị ngân hàng',
                    'sotaikhoan' => 'Số tài khoản',
                    'somomo' => 'Số tài khoản momo',
                ];

                $validator = Validator::make($request->all(), $pattern, $messenger, $customName);

                //### kiểm tra email
                if ($request->email != $user->email) {
                    //### Kiểm tra email nhập vào đã tồn tại hay chưa
                    $find_email_input = User::where('email', $request->email)->first();
                    if ($find_email_input) {
                        $error_email['email'] = 'Email '.$request->email.' này đã tồn tại. Vui lòng nhập lại email khác';
                        return redirect()->route('account.manage')->withErrors($error_email)->withInput();
                    }

                    //### Cập nhật thông tin user
                    $email_verify_time = time();
                    $update = User::find($user->id);
                    $update->email_new = $request->email;
                    $update->email_new_kichhoat = 0;
                    $update->email_verify_time = $email_verify_time;
                    $update->save();

                    //## gửi mail xác minh danh tính khi thay đổi mail mới
                    $message = array();
                    $message['tieude'] = 'Xác minh danh tính';
                    $message['file']='';
                    $message['setting'] = $this->setting_opt;
                    $data_input['email'] = $user->email;
                    $data_input['email_new'] = $request->email;
                    $data_input['email_verify_time'] = $email_verify_time;
                    Mail::to($user->email)->send(new MailNotify($message, $data_input, 'verification'));

                    $error_email['email'] = 'Email mới chưa được xác minh. Đăng nhập email cũ để xác minh cho hệ thống biết đó là bạn';
                    return redirect()->route('account.manage')->withErrors($error_email)->withInput();
                }

                //### Kiểm tra mã otp
                if ($request->otp!='' && $request->otp != $user->otp) {
                    $error_email['otp'] = 'Mã OTP không chính xác !';
                    return redirect()->route('account.manage')->withErrors($error_email)->withInput();
                }


                //## thất bại không thể vượt lưới validation
                if ($validator->fails()) {
                    return redirect()->route('account.manage')->withErrors($validator)->withInput();
                } else { //## thành công

                    //### cập nhật thông tin user sau thay đổi
                    if ($request->ngaysinh!='') {
                        $request->ngaysinh = Helper::ChangeDate($request->ngaysinh);
                    }

                    $update = User::find($user->id);
                    $update->name = $request->name;
                    $update->gioitinh = $request->gioitinh;
                    $update->ngaysinh = strtotime($request->ngaysinh);
                    $update->nganhang = $request->nganhang;
                    $update->sotaikhoan = $request->sotaikhoan;
                    $update->somomo = $request->somomo;
                    $update->otp = 0;
                    $update->timeup_otp = 0;

                    $getimage='';
                    if ($request->hasFile('file')) {
                        $oldimage = $user->photo;
                        //Lưu hình ảnh vào thư mục public/upload/post
                        $folder = Helper::GetFolder('user');
                        $newimage = $request->file('file');
                        if ($newimage) {
                            $update->photo = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
                        }
                    }

                    $update->save();


                    //###Tạo thông báo
                    $data_thongbao['tieude'] = 'Cập nhật tài khoản';
                    $data_thongbao['sub_tieude'] = 'Cập nhật tài khoản';
                    $data_thongbao['noidung'] = 'Bạn vừa cập nhật thông tin tài khoản của mình, hãy kiểm tra lại thông tin tài khoản đã chính xác hay chưa';
                    $data_thongbao['ngaytao'] = time();
                    $data_thongbao['id_user'] = $user->id;
                    $this->thongbaoRepo->SaveItem($data_thongbao);

                    return redirect()->route('account.manage');
                }
            }
        } else {
            return redirect()->route('account.login');
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Xác minh danh tính
    |--------------------------------------------------------------------------
    */
    public function Verification(Request $request)
    {
        $this->initialization($request);

        if (!Auth::guard()->check()) {
            return redirect()->route('account.inform', ['notLogin']);
        }

        $data = $request->data;
        $user = Auth::guard()->user();
        $data_verify = md5($user->email_new.'|'.$user->email_verify_time);

        if ($data === $data_verify) {
            $update = User::find($user->id);
            $update->email = $user->email_new;
            $update->email_new = '';
            $update->email_new_kichhoat = 1;
            $update->save();

            return redirect()->route('account.manage');
        } else {
            return redirect()->route('account.inform', ['notLogin']);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Thay đổi mật khẩu
    |--------------------------------------------------------------------------
    */
    public function EditPassword(Request $request)
    {
        $this->initialization($request);

        if (!Auth::guard()->check()) {
            return redirect()->route('account.inform', ['notLogin']);
        }

        if ($request->getMethod() == 'GET') {
            return view('desktop.templates.account.editpass');
        }

        $alert = array();

        $pattern = [
            'password' => 'bail|required|min:8',
            'newpassword' => 'bail|required|min:8',
            'renewpassword' => 'bail|required|same:newpassword',
        ];


        $messenger = [
            'required' => ':attribute không được để trống',
            'min' => ':attribute không được nhỏ hơn :min ký tự',
            'max' => ':attribute không được lớn hơn :max ký tự',
            'unique' => ':attribute đã tồn tại',
            'same' => ':attribute chưa chính xác',
        ];


        $customName = [
            'password' => 'Mật khẩu hiện tại',
            'repassword' => 'Mật khẩu mới',
            'repassword' => 'Mật khẩu',
        ];


        $validator = Validator::make($request->all(), $pattern, $messenger, $customName);

        //### xử lý
        if ($validator->fails()) {
            return redirect()->route('account.editpass')->withErrors($validator)->withInput();
        } else {
            $user = Auth::guard()->user();

            $data_input = $request->input();

            if (Hash::check($data_input['password'], $user->password) && $data_input['newpassword']==$data_input['renewpassword']) {
                $data['password'] = bcrypt($data_input['newpassword']);
                $this->model->SaveItem($data, $user->id);

                //###Tạo thông báo
                $data_thongbao['tieude'] = $data_thongbao['sub_tieude'] = 'Thay đổi mật khẩu';
                $data_thongbao['noidung'] = 'Bạn vừa thay đổi mật khẩu của mình. Hãy đăng nhập lại để kiểm tra mật khẩu mới đã chính xác hay chưa';
                $data_thongbao['ngaytao'] = time();
                $data_thongbao['id_user'] = $user->id;
                $this->thongbaoRepo->SaveItem($data_thongbao);

                return redirect()->route('account.inform', ['successEditpass']);
            }
            return redirect()->route('account.inform', ['errorEditpass']);
        }
    }


    public function NewLike(Request $request)
    {
        $this->initialization($request);

        //### kiểm tra đăng nhập
        if (Auth::guard()->check()) {
            //### hiển thị thông tin user
            $user = Auth::guard()->user();

            //### Lấy ds tin đăng của user
            $posts = $this->postRepo->GetAllItemsFindInSetField('tintuc', $user->id, 'saves', null);

            $response = array(
                'user' => ($user) ? $user->toArray() : null,
                'posts' => $posts
            );

            //### kiểm tra method
            if ($request->getMethod() == 'GET') {
                return view('desktop.templates.account.newlike', $response);
            }
        } else {
            return redirect()->route('account.login');
        }
    }



    /*
    |--------------------------------------------------------------------------
    | Thay đổi trạng thái thông báo
    |--------------------------------------------------------------------------
    */
    public function ChangeStatusInform(Request $request)
    {
        $user = Auth::guard()->user();

        //### trạng thái đầu vào
        $status = $request->status;
        $id = $request->id;


        //### kiểm tra id thông báo có phải của user
        $check = $this->thongbaoRepo->GetItem(['id'=>$id, 'id_user'=>$user->id]);


        if ($check) {
            $param = array();

            //### kiểm tra loại trạng thái ==>
            switch ($status) {
                case 'daxem':
                    $param['daxem'] = 1;
                    break;
                case 'chuaxem':
                    $param['daxem'] = 0;
                    break;
                case 'xoa':
                    $param['daxoa'] = 1;
                    break;
            }

            $this->thongbaoRepo->SaveItem($param, $id);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Đăng 1 tin mới
    |--------------------------------------------------------------------------
    */
    public function PostNews(Request $request)
    {
        $this->initialization($request);

        //### kiểm tra đăng nhập
        if (!Auth::guard()->check()) {
            return redirect()->route('account.login');
        }


        //### Hiển thị giao diện tin đăng
        $user = Auth::guard()->user();
        
        if ($request->getMethod() == 'GET') {
            //### Kiểm tra tin theo id đã tồn tại?
            $id = $request->id;
            $row_postnew = $this->postRepo->GetItem(['id'=>$id, 'id_user'=>$user->id]);
            if ($id && !$row_postnew) {
                return redirect()->route('account.inform', ['notExistPostnews']);
            }

            //### Lấy ds nguồn tin
            $nguontins = $this->postRepo->GetAllItems('nguontin', ['hienthi'=>1]);

            //### Lấy ds tags
            $tags = $this->tagRepo->GetAllItems('tintuc', ['hienthi'=>1]);

            //### Lấy ds phương án bình chọn
            $binhchons = $this->binhchonRepo->GetItem(['id_post'=>$id]);
            //dd($binhchons);

            $resonse = array(
                'nguontins' => $nguontins,
                'tags' => $tags,
                'row_postnew' => ($row_postnew) ? $row_postnew : null,
                'binhchons' => ($binhchons) ? $binhchons : null,
                'user' => $user
            );

            return view('desktop.templates.account.postnews')->with($resonse);
        }


        //### xử lý code thêm tin đăng
        $id = $request->id;
        $datapost = $request->datapost;
        $datatags = $request->datatags;
        $databinhchon = $request->databinhchon;
        $datapost['type'] = 'tintuc';
        $datapost['hienthi'] = 1;
        $datapost['draft'] = 0;
        $datapost['id_user'] = $user->id;
        $datapost['tenkhongdauvi'] = Str::slug($datapost['tenvi'], '-');

        if ($id) {
            $datapost['ngaysua'] = time();
        } else {
            $datapost['ngaytao'] = $datapost['ngaysua'] = time();
        }

        if ($datatags) {
            $datapost['id_tags'] = implode(',', $datatags);
        }

        if ($user->congtacvien==0 && $datapost['loaitin']==2) {
            $datapost['loaitin'] = 0;
        }

        if ($datapost['loaitin']!=1) {
            $datapost['luotxemgioihan'] = 0;
            $datapost['kieuxem'] = 0;
            $datapost['soxuphaitra'] = 0;
        } elseif ($datapost['loaitin']==1) {
            $datapost['kieuxem'] = $request->kieuxem;
        }


        //### kiểm tra dữ liệu đầu vào
        $check_input = false;
        $arr_check = array();
        if (!isset($datapost['ids_level_1']) || $datapost['ids_level_1']==0) {
            $check_input = true;
            $arr_check['ids_level_1']="Chưa chọn danh mục";
        }
        if (!isset($datapost['tenvi']) || $datapost['tenvi']=='') {
            $check_input = true;
            $arr_check['tenvi']="Tiêu đề bài viết không được để trống";
        }
        if (!isset($datapost['motavi']) || $datapost['motavi']=='') {
            $check_input = true;
            $arr_check['motavi']="Mô tả bài viết không được để trống";
        }
        if (!isset($datapost['noidungvi']) || $datapost['noidungvi']=='') {
            $check_input = true;
            $arr_check['noidungvi']="Nội dung bài viết không được để trống";
        }
        if (!isset($datapost['loaitin'])) {
            $check_input = true;
            $arr_check['loaitin']="Chưa chọn loại tin đăng";
        }
        if (!isset($datapost['id_tags'])) {
            $check_input = true;
            $arr_check['id_tags']="Chưa chọn tags từ khoá";
        }

        if ($check_input) {
            return redirect()->route('account.postnews')->withErrors($arr_check)->withInput();
        }


        $getimage='';
        if ($request->hasFile('file')) {
            $row = $this->postRepo->GetOneItem($id);
            $oldimage = $row['photo'];
            //Lưu hình ảnh vào thư mục public/upload/post
            $folder = Helper::GetFolder('post');
            $newimage = $request->file('file');
            if ($newimage) {
                $datapost['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
            }
        }


        $getimage='';
        if ($request->hasFile('poster')) {
            $row = $this->postRepo->GetOneItem($id);
            $oldimage = $row['poster'];
            //Lưu hình ảnh vào thư mục public/upload/post
            $folder = Helper::GetFolder('post');
            $newimage = $request->file('poster');
            if ($newimage) {
                $datapost['poster'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
            }
        }


        $getimage='';
        if ($request->hasFile('fileupload')) {
            $row = $this->postRepo->GetOneItem($id);
            $oldimage = $row['fileupload'];
            //Lưu hình ảnh vào thư mục public/upload/post
            $folder = Helper::GetFolder('file');
            $newimage = $request->file('fileupload');
            if ($newimage) {
                $datapost['fileupload'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
            }
        }
        $row = $this->postRepo->SaveItem($datapost, $id);


        //### tạo bình chọn cho bày viết
        if ($row && $databinhchon) {
            $id_binhchon = ($databinhchon['id']) ? $databinhchon['id'] : null;
            $data_binhchon['id_post'] = $row['id'];
            $data_binhchon['tieude'] = $databinhchon['tieude'];
            $row_binhchon = $this->binhchonRepo->SaveItem($data_binhchon, $id_binhchon);

            if ($row_binhchon) {
                $arr_options = $databinhchon['giatri'];
                
                if ($arr_options) {
                    foreach ($arr_options as $k=>$v) {
                        if ($v) {
                            $data_bcOption = array();
                            $data_bcOption['id_binhchon'] = $row_binhchon['id'];
                            $data_bcOption['id_user'] = $user->id;
                            $data_bcOption['value'] = $v;
                            $this->binhchonOptionsRepo->SaveItem($data_bcOption, null);
                        }
                    }
                }
            }
        }

        return redirect()->route('account.inform', ['hasPostNews']);
    }


    /*
    |--------------------------------------------------------------------------
    | Xem trước 1 tin
    |--------------------------------------------------------------------------
    */
    public function Preview(Request $request)
    {
        //### kiểm tra đăng nhập
        if (!Auth::guard()->check()) {
            return redirect()->route('account.login');
        }


        $row_detail = session('preview');

        //### Lấy ds tags của sản phẩm hiện tại
        $tags = array();
        if (isset($row_detail['id_tags']) && $row_detail['id_tags']!='') {
            $tag_arr = explode(',', $row_detail['id_tags']);
            $tags = $this->tagRepo->Query()->whereIn('id', $tag_arr)->where('hienthi', 1)->get();
            if ($tags) {
                $tags = $tags->toArray();
            }
        }


        //### Lấy thông tin ids_level_1
        if (isset($row_detail['ids_level_1'])) {
            $cate_lv1 = $this->categoryRepo->GetItem(['id'=>$row_detail['ids_level_1']]);
            $row_detail['belong_category']['tenvi'] = $cate_lv1['tenvi'];
        }

        //### Lấy thông tin ids_level_2
        if (isset($row_detail['ids_level_2'])) {
            $cate_lv2 = $this->categoryRepo->GetItem(['id'=>$row_detail['ids_level_2']]);
            $row_detail['belong_category_lv2']['tenvi'] = $cate_lv2['tenvi'];
        }

        //### Lấy thông tin nguồn
        $nguontin = '';
        if (isset($row_detail['nguon'])) {
            $nguontin = $this->postRepo->GetItem(['type'=>'nguontin', 'id'=>$row_detail['nguon']]);
        }
        

        Helper::setBreadCrumbs($row_detail['tenkhongdauvi'], $row_detail['tenvi']);
        $breadcrumbs = Helper::getBreadCrumbs();


        $response = array(
            "row_detail" => $row_detail,
            "title" => $row_detail['titlevi'],
            "keywords" => $row_detail['keywordsvi'],
            "description" => $row_detail['descriptionvi'],
            "breadcrumbs" => $breadcrumbs,
            "tags" => $tags,
            "nguontin" => $nguontin
        );

        return view('desktop.templates.post.post_detail', $response);
    }


    /*
    |--------------------------------------------------------------------------
    | Ds tin đăng
    |--------------------------------------------------------------------------
    */
    public function Listnews(Request $request)
    {
        $this->initialization($request);

        //### kiểm tra đăng nhập
        if (!Auth::guard()->check()) {
            return redirect()->route('account.login');
        }

        //### Hiển thị giao diện tin đăng
        $user = Auth::guard()->user();

        //### Lấy ds tin đăng của user
        $posts = $this->postRepo->GetAllItems('tintuc', ['id_user'=>$user->id]);

        $response = array(
            'user' => ($user) ? $user->toArray() : null,
            'posts' => $posts
        );

        return view('desktop.templates.account.listnews', $response);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa tin đăng
    |--------------------------------------------------------------------------
    */
    public function DeletePostnews(Request $request)
    {
        $this->initialization($request);

        //### kiểm tra đăng nhập
        if (Auth::guard()->check()) {
            $id = $request->id;
            $user = Auth::guard()->user();
            $row = $this->postRepo->GetItem(['id'=>$id,'id_user'=>$user->id]);
            
            if ($row) {
                $this->postRepo->DeleteOneItem($id);
            }
        }
    }



    /*
    |--------------------------------------------------------------------------
    | Quản lý nạp rút xu
    |--------------------------------------------------------------------------
    */
    public function ManageCoin(Request $request)
    {
        $this->initialization($request);

        //### kiểm tra đăng nhập
        if (!Auth::guard()->check()) {
            return redirect()->route('account.login');
        }

        //### Hiển thị giao diện tin đăng
        $user = Auth::guard()->user();

        //### Lấy thông tin momo
        $thanhtoanmomo = $this->staticRepo->GetItem(['type'=>'thanhtoanmomo']);
        $thanhtoannganhang = $this->staticRepo->GetItem(['type'=>'thanhtoannganhang']);

        $response = array(
            'user' => ($user) ? $user->toArray() : null,
            'thanhtoanmomo' => $thanhtoanmomo,
            'thanhtoannganhang' => $thanhtoannganhang
        );

        //### kiểm tra method
        if ($request->getMethod() == 'GET') {
            return view('desktop.templates.account.managecoin', $response);
        } else {
            //### xử lý validation
            $alert = array();

            $pattern = [
                'hinhthuc' => 'bail|required',
                'phuongthuc' => 'bail|required',
                'giatrixunap' => 'bail|required',
            ];


            $messenger = [
                'required' => ':attribute không được để trống',
                'numeric' => ':attribute phải là dạng số',
            ];


            $customName = [
                'hinhthuc' => 'Hình thức',
                'phuongthuc' => 'Phương thức thanh toán',
                'giatrixunap' => 'Giá trị nạp/rút',
            ];

            $validator = Validator::make($request->all(), $pattern, $messenger, $customName);

            //## thất bại không thể vượt lưới validation
            if ($validator->fails()) {
                return redirect()->route('account.managecoin')->withErrors($validator)->withInput();
            } else { //## thành công
                $settingOptions = app('settingOptions');
                $data['hinhthuc'] = $request->hinhthuc;
                $data['phuongthuc'] = $request->phuongthuc;
                $data['giatrixunap'] = $request->giatrixunap;
                $data['giatrinap'] = $request->giatrixunap*$settingOptions['giatrixu'];//str_replace(",","",$request->giatrinap);
                $data['magiaodich'] = $request->magiaodich;
                $data['id_user'] = $user->id;
                $data['hienthi'] = 1;
                $data['ngaytao'] = time();
                $data['type'] = 'naprutxu';
                $data['maxuly'] = ($data['hinhthuc']==0) ? 'N_'.Str::random(8) : 'R_'.Str::random(8);

                if ($request->hasFile('file') && $data['hinhthuc'] == 0) {
                    //Lưu hình ảnh vào thư mục public/upload/post
                    $oldimage = '';
                    $folder = Helper::GetFolder('file');
                    $newimage = $request->file('file');
                    if ($newimage) {
                        $data['photogiaodich'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
                    }
                }

                $row = $this->newsletterRepo->SaveItem($data);

                if ($row) {
                    //###Tạo thông báo
                    $text = ($data['hinhthuc']==0) ? 'Nạp xu' : 'Rút xu';
                    $data_thongbao['tieude'] = $text;
                    $data_thongbao['sub_tieude'] = $text;
                    $data_thongbao['noidung'] = 'Gửi yêu cầu '.$text.' thành công. Hệ thống sẽ xác nhận trong thời gian sớm nhất.';
                    $data_thongbao['ngaytao'] = time();
                    $data_thongbao['id_user'] = $user->id;
                    $this->thongbaoRepo->SaveItem($data_thongbao);
                }

                return redirect()->route('account.inform', ['successAddcoin']);
                //return redirect()->route('account.managecoin');
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Quản lý lịch sử nạp rút xu
    |--------------------------------------------------------------------------
    */
    public function HistoryCoin(Request $request)
    {
        $this->initialization($request);

        //### kiểm tra đăng nhập
        if (!Auth::guard()->check()) {
            return redirect()->route('account.login');
        }

        //### Hiển thị giao diện tin đăng
        $user = Auth::guard()->user();

        //### láy thông tin ds nạp xu
        $nap_wait = $this->newsletterRepo->GetAllItems('naprutxu', ['id_user'=>$user->id, 'hinhthuc'=>0, 'tinhtrang'=>0], null, false, false, 0, ['ngaytao'=>'desc']);
        $nap_sucess = $this->newsletterRepo->GetAllItems('naprutxu', ['id_user'=>$user->id, 'hinhthuc'=>0, 'tinhtrang'=>2], null, false, false, 0, ['ngaytao'=>'desc']);
        $nap_cancel = $this->newsletterRepo->GetAllItems('naprutxu', ['id_user'=>$user->id, 'hinhthuc'=>0, 'tinhtrang'=>3], null, false, false, 0, ['ngaytao'=>'desc']);

        //### láy thông tin ds rút xu
        $rut_wait = $this->newsletterRepo->GetAllItems('naprutxu', ['id_user'=>$user->id, 'hinhthuc'=>1, 'tinhtrang'=>0], null, false, false, 0, ['ngaytao'=>'desc']);
        $rut_sucess = $this->newsletterRepo->GetAllItems('naprutxu', ['id_user'=>$user->id, 'hinhthuc'=>1, 'tinhtrang'=>2], null, false, false, 0, ['ngaytao'=>'desc']);
        $rut_cancel = $this->newsletterRepo->GetAllItems('naprutxu', ['id_user'=>$user->id, 'hinhthuc'=>1, 'tinhtrang'=>3], null, false, false, 0, ['ngaytao'=>'desc']);

        //$history = $this->newsletterRepo->GetAllItems('naprutxu',['id_user'=>$user->id], null, false, false, 0, ['ngaytao'=>'desc']);

        $response = array(
            'user' => ($user) ? $user->toArray() : null,
            'nap_wait' => $nap_wait,
            'nap_sucess' => $nap_sucess,
            'nap_cancel' => $nap_cancel,
            'rut_wait' => $rut_wait,
            'rut_sucess' => $rut_sucess,
            'rut_cancel' => $rut_cancel
        );

        return view('desktop.templates.account.historycoin', $response);
    }



    /*
    |--------------------------------------------------------------------------
    | Báo cáo phản hồi cho admin
    |--------------------------------------------------------------------------
    */
    public function Report(Request $request)
    {
        $this->initialization($request);

        //### kiểm tra đăng nhập
        if (!Auth::guard()->check()) {
            return redirect()->route('account.login');
        }

        //### Hiển thị giao diện tin đăng
        $user = Auth::guard()->user();

        $response = array(
            'user' => ($user) ? $user->toArray() : null
        );

        if ($request->getMethod() == 'GET') {
            return view('desktop.templates.account.report', $response);
        } else {
            //### xử lý validation
            $alert = array();

            $pattern = [
                //'username' => 'bail|required|min:6|unique:users',
                'tieude' => 'bail|required',
            ];


            $messenger = [
                'required' => ':attribute không được để trống',
            ];


            $customName = [
                'tieude' => 'Tiêu đề',
            ];

            $validator = Validator::make($request->all(), $pattern, $messenger, $customName);

            //## thất bại không thể vượt lưới validation
            if ($validator->fails()) {
                return redirect()->route('account.report')->withErrors($validator)->withInput();
            } else {
                $data['tieude'] = $request->tieude;
                $data['ghichu'] = $request->ghichu;
                $data['ngaytao'] = $data['ngaysua'] = time();
                $data['id_user'] = $user->id;
                $data['type'] = 'report';

                $getimage='';
                if ($request->hasFile('file')) {
                    //Lưu hình ảnh vào thư mục public/upload/post
                    $oldimage = '';
                    $folder = Helper::GetFolder('file');
                    $newimage = $request->file('file');
                    if ($newimage) {
                        $data['photo'] = Helper::UploadImageToFolder($newimage, $oldimage, $folder);
                    }
                }

                $row = $this->contactRepo->SaveItem($data);

                if ($row) {
                    return redirect()->route('account.inform', ['hasReport']);
                } else {
                    return redirect()->route('account.inform', ['hasError']);
                }
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Gia hạn thời gian xem tin cho tài khoản
    |--------------------------------------------------------------------------
    */
    public function ExtendTime(Request $request)
    {
        $this->initialization($request);

        //### kiểm tra đăng nhập
        if (!Auth::guard()->check()) {
            return redirect()->route('account.login');
        }

        $user = Auth::guard()->user();
        $id_post = $request->id;


        //### Lấy thông tin bài đăng
        $row_post = $this->postRepo->GetOneItem($id_post);

        if ($user->tongxu < $row_post['soxuphaitra']) { //### nếu số xu không đủ ==> thông báo
            $json['result'] = false;
            $json['text'] = "Số xu trong tài khoản của bạn không đủ để gia hạn xem tin";
            $json['icon'] = 'warning';
        } else {
            $setting = app('setting');
            $settingOptions = app('settingOptions');

            //### Lấy thông tin đăng ký bài đăng
            $row_postwuser = $this->postwuserRepo->GetItem(['id_post'=>$row_post['id'], 'id_user'=>$user->id, 'loaitin'=>$row_post['loaitin']]);

            if ($row_postwuser) {
                $soxuphaitra = $row_post['soxuphaitra'];
                $soxudangco = $user->tongxu;

                //### gia hạn thời gian xem tin vầ cập nhật lại
                if ($row_post['kieuxem']==0) { //### nếu kiểu xem tin là : xem 1 lần
                    //### thiết lập thời gian xem khi đăng ký
                    $data_add['timeopen'] = time();

                    $hour_tmp = date('H', $data_add['timeopen']);
                    $minute_tmp = date('i', $data_add['timeopen']);
                    $second_tmp = date('s', $data_add['timeopen']);
                    $timeup_tmp = mktime(($hour_tmp + 24), ($minute_tmp + 0), ($second_tmp + 0), date('m', $data_add['timeopen']), date('d', $data_add['timeopen']), date('Y', $data_add['timeopen']));
                    $data_add['timeup'] = $timeup_tmp;
                } else { //### nếu kiểu xem tin là : xem vĩnh viễn
                    $data_add['timeopen'] = 0;
                    $data_add['timeup'] = 0;
                }

                $result = $this->postwuserRepo->SaveItem($data_add, $row_postwuser['id']);

                //### nếu cập nhật thành công ==> cập nhật lại tổng xu của người xem tin sau khi đã gia hạn
                if ($result) {
                    $update = User::find($user->id);
                    $update->tongxu = ($soxudangco - $soxuphaitra);
                    $update->save();

                    //### tính toán số xu nhận được ==> chia cho admin và người đăng tin
                    if ($row_post['id_user']!=0) { //## nếu bài đăng là của thành viên (không phải admin đăng)
                        $soxu_admin_nhan = ((int)$settingOptions['phantramhoahong']/100) * $soxuphaitra;
                        $soxu_user_dangtin_nhan = $soxuphaitra - $soxu_admin_nhan;

                        //## cập nhật số xu cho admin
                        $dataSetting['tongxu'] = $setting['tongxu'] + $soxu_admin_nhan;
                        $this->settingRepo->SaveItem($dataSetting, $setting['id']);

                        //## cập nhật số xu cho người đăng tin
                        $update = User::find($row_post['id_user']);
                        $update->tongxu += $soxu_user_dangtin_nhan;
                        $update->save();

                        //## Lưu lịch sử trả phí xem tin : cho admin
                        $dataHistory = array();
                        $dataHistory['id_post'] = $row_post['id'];
                        $dataHistory['id_user_nhan'] = 0; //### là admin
                        $dataHistory['id_user_tra'] = $user->id;
                        $dataHistory['soxu'] = $soxu_admin_nhan;
                        $dataHistory['giatrixu'] = (int)$settingOptions['giatrixu'];
                        $dataHistory['hienthi'] = 1;
                        $dataHistory['ngaytao'] = time();
                        $this->historypayRepo->SaveItem($dataHistory);

                        //## Lưu lịch sử trả phí xem tin : cho người đăng tin
                        $dataHistory = array();
                        $dataHistory['id_post'] = $row_post['id'];
                        $dataHistory['id_user_nhan'] = $row_post['id_user'];
                        $dataHistory['id_user_tra'] = $user->id;
                        $dataHistory['soxu'] = $soxu_user_dangtin_nhan;
                        $dataHistory['giatrixu'] = (int)$settingOptions['giatrixu'];
                        $dataHistory['hienthi'] = 1;
                        $dataHistory['ngaytao'] = time();
                        $this->historypayRepo->SaveItem($dataHistory);
                    } else {
                        $soxu_admin_nhan = $soxuphaitra;

                        //## cập nhật số xu cho admin
                        $dataSetting['tongxu'] = $setting['tongxu'] + $soxu_admin_nhan;
                        $this->settingRepo->SaveItem($dataSetting, $setting['id']);

                        //## Lưu lịch sử trả phí xem tin : cho admin
                        $dataHistory = array();
                        $dataHistory['id_post'] = $row_post['id'];
                        $dataHistory['id_user_nhan'] = 0; //### là admin
                        $dataHistory['id_user_tra'] = $user->id;
                        $dataHistory['soxu'] = $soxu_admin_nhan;
                        $dataHistory['giatrixu'] = (int)$settingOptions['giatrixu'];
                        $dataHistory['hienthi'] = 1;
                        $dataHistory['ngaytao'] = time();
                        $this->historypayRepo->SaveItem($dataHistory);
                    }

                    $json['result'] = true;
                    $json['text'] = "Gia hạn xem tin thành công !";
                    $json['icon'] = 'success';
                }
            }
        }

        return json_encode($json);
    }


    /*
    |--------------------------------------------------------------------------
    | Lịch sử biến động xu
    |--------------------------------------------------------------------------
    */
    public function HistoryPay(Request $request)
    {
        $this->initialization($request);

        //### kiểm tra đăng nhập
        if (!Auth::guard()->check()) {
            return redirect()->route('account.login');
        }

        //### Hiển thị giao diện tin đăng
        $user = Auth::guard()->user();

        //### láy thông tin ds nạp rút xu
        $coin_receip = $this->historypayRepo->GetItems(['id_user_nhan'=>$user->id], null, ['ngaytao'=>'desc']);
        $coin_pay = $this->historypayRepo->GetItems(['id_user_tra'=>$user->id], null, ['ngaytao'=>'desc']);

        $response = array(
            'user' => ($user) ? $user->toArray() : null,
            'coin_receip' => $coin_receip,
            'coin_pay' => $coin_pay
        );

        return view('desktop.templates.account.historypay', $response);
    }



    /*
    |--------------------------------------------------------------------------
    | Kích hoạt gói tin theo tháng
    |--------------------------------------------------------------------------
    */
    public function BuyPostMonth(Request $request)
    {
        $this->initialization($request);

        //### kiểm tra đăng nhập
        if (!Auth::guard()->check()) {
            return redirect()->route('account.login');
        }

        //### Hiển thị giao diện tin đăng
        $user = Auth::guard()->user();

        $response = array(
            'user' => ($user) ? $user->toArray() : null
        );

        if ($request->getMethod() == 'GET') {
            return view('desktop.templates.account.buypostmonth', $response);
        } else {
            //### cập nhật thời gian hiệu lực sử dụng cho người đăng ký gói tin
            $time_tmp = time();
            $timeup_tmp = strtotime("+1 month", $time_tmp);

            $update = User::find($user->id);
            $update->vip = 1;
            $update->timeopen = $time_tmp;
            $update->timeup = $timeup_tmp;
            $update->tongxu -= $this->setting_opt['goitheothang'];
            $update->save();

            //### lưu lịch sử đăng ký
            $dataHistory = array();
            $dataHistory['id_post'] = 0;
            $dataHistory['id_user_nhan'] = 0; //### là admin
            $dataHistory['id_user_tra'] = $user->id;
            $dataHistory['soxu'] = $this->setting_opt['goitheothang'];
            $dataHistory['giatrixu'] = (int)$this->setting_opt['giatrixu'];
            $dataHistory['hienthi'] = 1;
            $dataHistory['ngaytao'] = time();
            $dataHistory['typepage'] = 'goitinthang';
            $this->historypayRepo->SaveItem($dataHistory);

            if (isset($request->ajax)) {
                $json['result_ajax'] = true;
                return json_encode($json);
            } else {
                return redirect()->route('account.inform', ['successVIP']);
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Xem thông báo
    |--------------------------------------------------------------------------
    */
    public function Alert(Request $request)
    {
        $this->initialization($request);

        //### kiểm tra đăng nhập
        if (!Auth::guard()->check()) {
            return redirect()->route('account.login');
        }

        //### Hiển thị giao diện tin đăng
        $user = Auth::guard()->user();

        $response = array(
            'user' => ($user) ? $user->toArray() : null
        );

        return view('desktop.templates.account.alert', $response);
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa phương án bình chọn
    |--------------------------------------------------------------------------
    */
    public function DeleteBinhchonOption(Request $request)
    {
        $this->initialization($request);

        $json['result'] = false;
        $json['text'] = 'Xóa phương án thất bại !';
        $json['icon'] = 'error';

        //### kiểm tra đăng nhập
        if (!Auth::guard()->check()) {
            $json['result'] = false;
            $json['text'] = 'Tài khoản chưa đăng nhập !';
            $json['icon'] = 'warning';
        } else {
            $id = $request->id;
            $user = Auth::guard()->user();

            //### Lấy thông tin phương án chọn xóa
            $option = $this->binhchonOptionsRepo->GetItem(['id_user'=>$user->id,'id'=>$id]);

            if ($option) {
                $this->binhchonOptionsRepo->DeleteOneItem($id);
                $json['result'] = true;
                $json['text'] = 'Xóa phương án bình chọn thành công !';
                $json['icon'] = 'warning';
            }
        }

        return json_encode($json);
    }



    /*
    |--------------------------------------------------------------------------
    | Đăng ký cộng tác viên
    |--------------------------------------------------------------------------
    */
    public function RegisVIP(Request $request)
    {
        $this->initialization($request);

        //### kiểm tra đăng nhập
        if (!Auth::guard()->check()) {
            return redirect()->route('account.login');
        }

        //### Hiển thị giao diện tin đăng
        $user = Auth::guard()->user();

        //### lấy cấp category
        $max_category = $this->categoryRepo->Query()->max('level');

        //### lấy thông tin đăng ký cộng tác viên
        $dk_newsletter = $this->newsletterRepo->GetItem(['type'=>'dkcongtacvien', 'id_user'=>$user->id]);

        $response = array(
            'user' => ($user) ? $user->toArray() : null,
            'max_category' => $max_category,
            'has_dangky' => ($dk_newsletter) ? true : false,
            'dk_newsletter' => ($dk_newsletter) ? $dk_newsletter : null
        );

        if ($request->getMethod() == 'GET') {
            return view('desktop.templates.account.regisVIP', $response);
        } else {
            //### cập nhật thời gian hiệu lực sử dụng cho người đăng ký gói tin
            $settingOptions = app('settingOptions');
            $max_level = $request->max_level;
            $id = null;

            if ($dk_newsletter) {
                $id=$dk_newsletter['id'];
                $data['yeucauthaydoi'] = 1;
                $data['tinhtrang'] = 0;
            }

            $data['id_user'] = $user->id;

            for ($i=1;$i<=($max_level+1);$i++) {
                TableManipulation::AddFieldToTable('newsletter', 'ids_level_'.$i);
                $data['ids_level_'.$i] = $request['level_'.($i-1)];
            }
           
            $data['type'] = 'dkcongtacvien';
            $this->newsletterRepo->SaveItem($data, $id);

            return redirect()->route('account.regisVIP', ['regisVIP']);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Xóa file upload
    |--------------------------------------------------------------------------
    */
    public function DeleteFileupload(Request $request)
    {
        $this->initialization($request);

        $json['result'] = false;
        $json['text'] = 'Xóa hình thất bại !';
        $json['icon'] = 'error';

        //### kiểm tra đăng nhập
        if (!Auth::guard()->check()) {
            $json['result'] = false;
            $json['text'] = 'Tài khoản chưa đăng nhập !';
            $json['icon'] = 'warning';
        } else {
            $id = $request->id;
            $user = Auth::guard()->user();

            //### Lấy thông tin phương án chọn xóa
            $row_post = $this->postRepo->GetItem(['id_user'=>$user->id,'id'=>$id]);

            if ($row_post) {
                $folder_name = 'file';
                if ($folder_name!='') {
                    $path = Helper::GetFolder($folder_name).$row_post['fileupload'];
                    if (file_exists($path)) {
                        @unlink($path);
                    }
                }

                $data['fileupload'] = '';
                $this->postRepo->SaveItem($data, $id);

                $json['result'] = true;
                $json['text'] = 'Xóa hình thành công !';
                $json['icon'] = 'warning';
            }
        }

        return json_encode($json);
    }
}
