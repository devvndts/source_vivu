<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

//use App\Repositories\Repo\PhotoRepository;
//use App\Repositories\Repo\SettingRepository;

//use App\Models\Photo;
//use App\Models\Setting;

use Helper;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    private $data, $user, $type, $logo, $response;
    private $tieude, $file, $settingConfig, $setting;
    private $config_base, $config_author, $isHost;
    private $model_photo, $model_setting;
    public $view, $fromEmail;

    /*protected $settingRepo, $photoRepo;
    protected $relations = [];
    protected $pagination = true;*/

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$user=null,$type='admin')
    {       
        //### Define upload const
        Helper::DefineFolderUpload();

        //## lấy hình photo đại diện cty
        $this->logo = app('logo');

        //## lấy thông tin cty
        $this->setting = app('setting');

        //## khai báo model
        $this->settingConfig = $settingOption = json_decode($this->setting['options'],true);
        $this->isHost = config('config_all.ishost');

        //## xử lý dữ liệu
        $data['tieude'] = "[".$settingOption['website']."] - ".$data['tieude'];
        $data['fromEmail'] = ($this->isHost) ? $settingOption['email_host'] : $settingOption['email'];
        //$data['fromEmailHost'] = $settingOption['email_host'];

        $this->data = $data;
        $this->user = $user;
        $this->type = $type;
        $this->tieude = "Thông báo !";
        $this->config_base = config('config_all.config_base');
        $this->config_author = config('config_all.author');
        

        //## response dữ liệu
        $this->response = array(
            'config_base' => $this->config_base,
            'config_author' => $this->config_author,
            'data' => $this->data,
            'user' => $this->user,
            'logo' => $this->logo,
            'settingConfig' => $this->settingConfig,
            'setting' => $this->setting
        );
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $this->tieude = ($this->data['tieude']!='')?$this->data['tieude']:$this->tieude;
        $this->file = (isset($this->data['file']))?$this->data['file']:'';

        switch ($this->type) {
            case 'admin':
                $this->view = 'mails.admin';
                $this->fromEmail = $this->data['fromEmail'];
                break;
            case 'contact':
                $this->view = 'mails.contact';
                $this->fromEmail = $this->data['fromEmail'];
                break;
            case 'newsletter':
                $this->view = 'mails.newsletter';
                $this->fromEmail = $this->data['fromEmail'];
                break;
            case 'order':
                $this->view = 'mails.order';
                $this->fromEmail = $this->data['fromEmail'];
                break;
            case 'signin':
                $this->view = 'mails.sigin';
                $this->fromEmail = $this->data['fromEmail'];
                break;
            case 'resetlogin':
                $this->view = 'mails.resetlogin';
                $this->fromEmail = $this->data['fromEmail'];
                break;
            case 'nhacungcapSendmail':
                $this->view = 'mails.nhacungcap';
                $this->fromEmail = $this->data['emailfrom'];
                break;
            case 'duyettin':
                $this->view = 'mails.duyettin';
                $this->fromEmail = $this->data['fromEmail'];
                break;
        }

        $email = $this->from($this->fromEmail)
           ->view($this->view)
           ->subject($this->tieude)
           ->with($this->response);
        if ($this->file){
            $email->attach($this->file);
        }
        return $email;
    }
}
