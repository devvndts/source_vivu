<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admins;
use App\Models\UserLimit;
use Helper;
use Session;

class LoginController extends Controller
{
    private $login_failed = false;
    private $isCheck = true;
    private $model;
    private $config;
    private $error='';

    /*
    |--------------------------------------------------------------------------
    | Khởi tạo dữ liệu
    |--------------------------------------------------------------------------
    */
    public function __construct(Request $request)
    {
        $this->config = config('config_all');
        session(['isCheckLogin' => true]);
    }

    /*
    |--------------------------------------------------------------------------
    | Đăng nhập
    |--------------------------------------------------------------------------
    */
    public function Login(Request $request)
    {
        if ($request->getMethod() == 'GET') {
            if (Auth::guard('admin')->check() && $this->isCheck) {

                $this->HandleLogin(true);
                if ($this->isCheck) {
                    return redirect()->route('admin.dashboard');
                }
            }
            return view('admin.templates.auth.login');
        }

        $username = $request->username ?? '';
        $password = $request->password ?? '';
        $credentials = array();
        $credentials['username'] = $username;
        $credentials['password'] = $password;
        $remember_token = true;//(isset($request->remember_token))?true:false;
        if (Auth::guard('admin')->attempt($credentials, $remember_token)) {
            //### tự động logout tất cả các thiết bị đã từng đăng nhập trước đó.
            //Auth::guard('admin')->logoutOtherDevices($password);

            //### Cập nhật lại thời gian đăng nhập hiện tại
            $this->UpdateLastLogin();
            $this->HandleLogin(true);

            //### run a route
            if ($this->isCheck) {
                return redirect()->route('admin.dashboard');
            } else {
                return back()->with('error', $this->error);
            }
        } else {
            $this->HandleLogin(false);
            return back()->with('error', $this->error);
            //return redirect()->back()->withErrors($error_login, $this->error);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Đăng xuất
    |--------------------------------------------------------------------------
    */
    public function Logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            //$password = Auth::guard('admin')->user()->password;
            Auth::guard('admin')->logout();
            //Auth::guard('admin')->logoutOtherDevices($password);
            return view('admin.templates.auth.login');
        } else {
            return redirect()->route('admin.dashboard');
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Cập nhật thời gian đăng nhập cuối
    |--------------------------------------------------------------------------
    */
    public function UpdateLastLogin()
    {
        $id = Auth::guard('admin')->user()->id;
        $admin = Admins::find($id);
        $admin->lastlogin = time();
        $admin->save();
    }

    /*
    |--------------------------------------------------------------------------
    | Xử lý khi đăng nhập thất bại
    |--------------------------------------------------------------------------
    */
    public function HandleLogin($isSuccess = false)
    {
        $ip = Helper::getRealIPAddress();
        $this->model = new UserLimit();
        $row = $this->model->GetItem(['login_ip'=>$ip]);
        if ($row) {
            $id_login = $row['id'];
            $time_now = time();
            if ($row['locked_time'] > 0) {
                $locked_time = $row['locked_time'];
                $delay_time = $this->config['login']['delay'];
                $interval = $time_now  - $locked_time;

                if ($interval <= $delay_time*60) {
                    $time_remain = $delay_time*60 - $interval;
                    $this->error = "Xin lỗi..! Vui lòng thử lại sau ". round($time_remain/60)." phút..!";
                    $this->isCheck = false;
                    session(['isCheckLogin'=> false]);
                } else {
                    $params_update = array(
                        'login_attempts' => 0,
                        'attempt_time' => $time_now,
                        'locked_time' => 0
                    );
                    $this->model->SaveProduct($params_update, $id_login);
                }
            }
        }

        if ($this->isCheck) {
            if (!$isSuccess) {
                if ($row) {
                    $id_login = $row['id'];
                    $attempt = $row['login_attempts'];
                    $noofattmpt = $this->config['login']['attempt'];
                    if ($attempt<$noofattmpt) {
                        $attempt = $attempt +1;

                        /* Cập nhật số lần đăng nhập sai */
                        $params_update = array(
                            'login_attempts' => $attempt
                        );
                        $this->model->SaveProduct($params_update, $id_login);
                        
                        /* Thông báo */
                        $no_ofattmpt = $noofattmpt + 1;
                        $remain_attempt = $no_ofattmpt - $attempt;
                        $this->error = 'Sai thông tin. Còn '.$remain_attempt.' lần thử';
                    } else {
                        if ($row['locked_time']==0) {
                            $attempt = $attempt + 1;
                            $timenow = time();

                            /* Cập nhật số lần đăng nhập sai */
                            $params_update = array(
                                'login_attempts' => $attempt,
                                'locked_time' => $timenow
                            );
                            $this->model->SaveProduct($params_update, $id_login);
                        } else {
                            $attempt = $attempt + 1;

                            /* Cập nhật số lần đăng nhập sai */
                            $params_update = array(
                                'login_attempts' => $attempt
                            );
                            $this->model->SaveProduct($params_update, $id_login);
                        }
                        $delay_time = $this->config['login']['delay'];
                        $this->error = "Bạn đã hết lần thử. Vui lòng thử lại sau ".$delay_time." phút";
                    }
                } else {
                    $timenow = time();
                    $params_insert = array(
                        'login_ip' => $ip,
                        'login_attempts' => 1,
                        'attempt_time' => $timenow,
                        'locked_time' => 0,
                    );
                    $this->model->SaveProduct($params_insert);
                    $remain_attempt = $this->config['login']['attempt'];
                    $this->error = 'Sai thông tin. Còn '.$remain_attempt.' lần thử';
                }
            } else {
                /* Reset số lần đăng nhập và thời gian đăng nhập */
                if ($row) {
                    $id_login = $row['id'];
                    $params_update = array(
                        'login_attempts' => 0,
                        'locked_time' => 0
                    );
                    $this->model->SaveProduct($params_update, $id_login);
                }
            }
        }
    }
}
