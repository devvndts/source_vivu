@php
    ///Test Demo:
    /*$config_base = config('config_all.config_base');
    $config_author = config('config_all.author');
    $settingConfig = json_decode(app('setting')['options'],true);
    $setting = app('setting');

    $data = array(
        'tindang' => array(
            'trangthai' => 1,
            'trangthai_info' => 'Tin ko có giá trị',
            'masp' => 'TD09893',
            'tenvi' => 'Chuyên thiết kế website mọi lĩnh vực ngành nghề',
            'ngaytao' => 1624422237,
            'ngaysua' => 1624422237
        ),
    );*/
@endphp

<!DOCTYPE html>
<html>
<head>
    <!-- UTF-8 -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <!-- fonts -->
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }} ">
    @include('mails.css')
</head>
<body>
    <div class="mail-container">
        <div class="mail-header" style="border-top: 4px solid #26b99a;">           
            <table class="mail-table-header">
                <tr>
                    <td><span><img src="{{config('config_all.config_all_url')}}img/mail/hotline.png" alt="mail"></span> {{($settingConfig) ? $settingConfig['hotline'] : 'Đang cập nhật'}}</td>
                    <td><span><img src="{{config('config_all.config_all_url')}}img/mail/mail.png" alt="mail"></span> {{($settingConfig) ? $settingConfig['email'] : 'Đang cập nhật'}}</td>
                    <td><span><img src="{{config('config_all.config_all_url')}}img/mail/website.png" alt="mail"></span> {{($settingConfig) ? $settingConfig['website'] : 'Đang cập nhật'}}</td>
                </tr>
            </table>
            <div class="mail-logo-mikotech">
                <p><img src='{{ (isset($logo['photo']))?config('config_all.config_all_url').UPLOAD_PHOTO.$logo['photo']:'' }}' width="100"/></p>
                    {{--<p><img src='{{ (isset($logo['photo']))?config('config_all.config_all_url').UPLOAD_PHOTO.$logo['photo']:'' }}' width="100"/></p>--}}
            </div>
        </div>
        <div class="mail-body">
            <div class="mail-content-inform" style="background: no-repeat url({{config('config_all.config_all_url')}}img/mail/logo-mikotech.png) center;background-size: contain;">
                @if($data['tindang']['trangthai']==1)
                    <p class="mail-title">{{($setting) ? $setting['tenvi'] : 'Chúng tôi'}} xin thông báo!<br>Tin đăng của quý khách đã được duyệt thành công</p>
                @else
                    <p class="mail-title">{{($setting) ? $setting['tenvi'] : 'Chúng tôi'}} xin thông báo!<br>Tin đăng của quý khách không đạt yêu cầu để xét duyệt</p>    
                    <div class="content-inform">
                        Lý do: {!! $data['tindang']['trangthai_info'] !!}                               
                    </div>
                @endif

                <table class="mail-table-tindang">
                    <tr>
                        <td colspan="2"><b>Thông tin bài đăng</b></td>                        
                    </tr>
                    <tr>
                        <td><b>Mã tin đăng:</b></td>
                        <td>{{$data['tindang']['masp']}}</td>
                    </tr>
                    <tr>
                        <td><b>Tiêu đề:</b></td>
                        <td>{{$data['tindang']['tenvi']}}</td>
                    </tr>
                    <tr>
                        <td><b>Ngày tạo:</b></td>
                        <td>{{date('d-m-Y',$data['tindang']['ngaytao'])}}</td>
                    </tr>
                    <tr>
                        <td><b>Ngày duyệt tin:</b></td>
                        <td>{{date('d-m-Y',$data['tindang']['ngaysua'])}}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="mail-text-stick"><b>Ghi chú:</b> mọi thắc mắc xin liên hệ tới hotline <b style="color:red">{{($settingConfig) ? $settingConfig['hotline'] : 'Đang cập nhật'}}</b></div>
        <div class="mail-footer" style="background: #26b99acc;line-height: 1.8;border-bottom: 5px solid #26b99a;">
            <p>{{$setting['tenvi']}}</p>
            <p>Địa chỉ: {{$settingConfig['diachi']}}</p>
            <p>
                <span>Hotline: {{$settingConfig['hotline']}} - </span>
                <span>Website: {{$settingConfig['website']}}</span>
            </p>
            Bản quyền © {{date('Y',time())}} thuộc <a href="https://mikotech.vn/" target="_blank">https://mikotech.vn</a>
        </div>
    </div>
</body>
</html>