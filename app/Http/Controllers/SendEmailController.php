<?php

namespace App\Http\Controllers;

//use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

use App\Http\Traits\SupportTrait;

//use App\Models\Newsletter;
//use App\Models\Contact;
use App\Jobs\SendEmail;
use App\Mail\MailNotify;

use Helper;
use Mail;

class SendEmailController extends Controller
{
    use SupportTrait;

    private $setting_opt;

    public function initialization(Request $request)
    {
        $this->setting_opt = $this->GetSettingOption('setting');
        Helper::SetConfigMail($this->setting_opt);
    }

    /*
    |--------------------------------------------------------------------------
    | Gửi mail liên hệ (contact)
    |--------------------------------------------------------------------------
    */
    public function SendContact(Request $request)
    {
        $this->initialization($request);
        $inputs = $request->all();

        $validator = Validator::make($inputs, [
            'recaptcha_action' => ['required', 'string'],
            'recaptcha_token'  => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $result = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('recapcha.secret_key_google'),
            'response' => $inputs['recaptcha_token'],
        ])->json();

        $active = config('config_all.recaptcha.active');
        if (!$active) {
            $result['test'] = true;
        }

        if ($result['test'] == true || (!empty($result) && $result['success']==true && $result['action'] === $inputs['recaptcha_action'])) {
            if ($result['test'] == true || (isset($result['score']) && $result['score'] >= 0.5)) {
                // DO: send mail contact and save contact here
                $model_contact = $this->contactRepo;//new Contact();

                $email = $this->setting_opt['email'];
                $data['tenvi'] = $data_save['ten'] = $request->ten;
                $data['dienthoai'] = $request->dienthoai;
                $data['diachi'] = $request->diachi;
                $data['email'] = $request->email;
                $data['tieude'] = sprintf('[%s] ', __('Mail liên hệ')).$request->tieude;
                $data['noidung'] = $request->noidung;
                $data['type'] = $request->type;
                //$data['hienthi'] = 1;
                $data['ngaytao'] = time();
                if ($data) {
                    $data_send = $data;
                    $data_send['setting'] = $this->setting_opt;
                }

                if ($request->hasFile('file')) {
                    $oldimage = '';
                    $folder = Helper::GetFolder("file");
                    $newimage = $request->file('file');
                    $file = Helper::UploadImageToFolder($newimage, $oldimage, $folder);

                    $data['taptin'] = $file;
                    $data_send['file'] = public_path('upload/file/'.$file);
                }
                Mail::to($email)->send(new MailNotify($data_send, null, 'contact'));
                if ($model_contact->SaveItem($data)) {
                    return redirect()->back()->with(['message' => camonabanchungtoidanhanduocthongtin]);
                }
            } else {
                $validator->getMessageBag()->add('recaptcha', xacminhrecapchakhongthanhcong);
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        $validator->getMessageBag()->add('recaptcha', loirecapcha);
        return redirect()->back()->withErrors($validator)->withInput();
    }


    /*
    |--------------------------------------------------------------------------
    | Gửi mail newsletter
    |--------------------------------------------------------------------------
    */
    public function SendNewsletter(Request $request)
    {
        $this->initialization($request);

        $inputs = $request->all();
        $is_recaptcha = (int)$inputs['isrecaptcha'];

        if ($is_recaptcha) {
            $validator = Validator::make($inputs, [
                'recaptcha_action' => ['required', 'string'],
                'recaptcha_token'  => ['required', 'string'],
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $result = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('recapcha.secret_key_google'),
                'response' => $inputs['recaptcha_token'],
            ])->json();

            if (!empty($result) && $result['success']==true && $result['action'] === $inputs['recaptcha_action']) {
                if ($result['score'] >= 0.5) {
                    // DO: send mail contact and save contact here
                    $model_newsletter = $this->newsletterRepo;//new Newsletter();

                    $email = $this->setting_opt['email'];
                    $data['tenvi'] = $data_save['ten'] = ($request->ten)?$request->ten:'';
                    $data['dienthoai'] = ($request->dienthoai)?$request->dienthoai:'';
                    $data['diachi'] = ($request->diachi)?$request->diachi:'';
                    $data['email'] = ($request->email)?$request->email:'';
                    $data['chude'] = ($request->tieude)?$request->tieude:'';
                    $data['noidung'] = ($request->noidung)?$request->noidung:'';
                    $data['type'] = ($request->type)?$request->type:'';
                    $data['tinhtrang'] = 1;
                    $data['ngaytao'] = time();
                    if ($data) {
                        $data_send = $data;
                        $data_send['tieude'] = ($request->tieude)?'['.maildangky.'] '.$request->tieude:thongbao;
                        $data_send['setting'] = $this->setting_opt;
                    }

                    if ($request->hasFile('file')) {
                        //$data['taptin'] = $data['ngaytao'].'_'.$request->file('file')->getClientOriginalName();
                        $data['taptin'] = $file = Helper::UploadImageToFolder($request->file('file'), '', Helper::GetFolder("file"));
                        $data_send['file'] = public_path('upload/file/'.$file);
                    }
                    Mail::to($email)->send(new MailNotify($data_send, null, 'newsletter'));
                    if ($model_newsletter->SaveItem($data)) {
                        return redirect()->back()->with(['message' => camonabanchungtoidanhanduocthongtin]);
                    }
                } else {
                    $validator->getMessageBag()->add('recaptcha', xacminhrecapchakhongthanhcong);
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }
            $validator->getMessageBag()->add('recaptcha', loirecapcha);
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            if (!$this->existEmail($request->email)) {
                // DO: send mail contact and save contact here
                $model_newsletter = $this->newsletterRepo;//new Newsletter();

                $email = $this->setting_opt['email'];
                $data['tenvi'] = $data_save['ten'] = ($request->ten)?$request->ten:'';
                $data['dienthoai'] = ($request->dienthoai)?$request->dienthoai:'';
                $data['diachi'] = ($request->diachi)?$request->diachi:'';
                $data['email'] = ($request->email)?$request->email:'';
                $data['chude'] = ($request->tieude)?$request->tieude:'';
                $data['noidung'] = ($request->noidung)?$request->noidung:'';
                $data['type'] = ($request->type)?$request->type:'';
                $data['tinhtrang'] = 1;
                $data['ngaytao'] = time();
                if ($data) {
                    $data_send = $data;
                    $data_send['tieude'] = ($request->tieude)?'['.maildangky.'] '.$request->tieude:thongbao;
                    $data_send['setting'] = $this->setting_opt;
                }

                if ($request->hasFile('file')) {
                    $data['taptin'] = $file = Helper::UploadImageToFolder($request->file('file'), '', Helper::GetFolder("file"));
                    $data_send['file'] = public_path('upload/file/'.$file);
                }
                if ($model_newsletter->SaveItem($data)) {
                    return redirect()->back()->with(['message' => camonabanchungtoidanhanduocthongtin]);
                }
            } else {
                return redirect()->back()->with(['message' => 'Email đã đăng ký!']);
            }
        }
    }

    private function existEmail($email)
    {
        $row = $this->newsletterRepo->GetItem(['email'=>$email]);
        if ($row) {
            return true;
        }
        return false;
    }
}
