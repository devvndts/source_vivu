<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Http\Traits\SupportTrait;

use Session, Socialite;

class SocialLogin extends Controller
{
    use SupportTrait;

    /*
    |--------------------------------------------------------------------------
    | Gọi tới social muốn đăng nhập
    |--------------------------------------------------------------------------
    */
    public function CallSocial(Request $request)
    {
        $provider = $request->provider;
        return Socialite::driver($provider)->redirect();
    }


    /*
    |--------------------------------------------------------------------------
    | Tạo mới (cập nhật) tài khoản user
    |--------------------------------------------------------------------------
    */
    public function UpdateAccount(Request $request)
    {
        if(isset($request->error)){return redirect()->route('home');}

        try {
            $provider = $request->provider;
            $socialiteProfile = Socialite::driver($provider)->user();

            $user = User::where('email', $socialiteProfile->email)->first();
            //lấy thông tin username, email, avatar, social_id để lưu vào bảng users (có thể lấy thêm thông tin khác)
            $data = [
                'social_name' => $socialiteProfile->name,
                'email' => $socialiteProfile->email,
                'avatar_url' => optional($user)->avatar_url ? $user->avatar_url : $socialiteProfile->avatar,
                'social_id' => $socialiteProfile->id,
                'social_provider' => $provider,
            ];
            $user = User::updateOrCreate(['email' => $socialiteProfile->email], $data);
            Auth::login($user, true);

            $this->init($request);
            return redirect()->route('home');

        }catch (Exception $exception) {
            $exception->getMessage();
        }
    }
}
