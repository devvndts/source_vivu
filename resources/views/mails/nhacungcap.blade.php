@php
    ///Test Demo:
    /*$config_base = config('config_all.config_base');
    $config_author = config('config_all.author');
    $settingConfig = json_decode(app('setting')['options'],true);
    $setting = app('setting');

    $data = array(
        'name' => 'Vũ an bình',
        'emailfrom' => 'anbinh@gmail.com',
        'phone' => '0587287978',     
        'noidung' => 'Đánh giá cải thiện dịch vụ giúp trải nghiệm mua sắm tốt hơn tại Fado.vn

                    </br>Xin chào Bình Vũ

                    </br>Cảm ơn quý khách đã lựa chọn Mikotech làm người bạn đồng hành trong hành trình mua sắm của mình

                    </br>Nhằm nâng cấp chất lượng dịch vụ tốt nhất, Mikotech không ngừng cải thiện hệ thống và lắng nghe ý kiến góp ý từ quý khách

                    </br>Mong quý khách dành ít phút để đánh giá trải nghiệm khi sử dụng dịch vụ của Fado Việt Nam

                    </br>Với mỗi lượt đánh giá, quý khách sẽ nhận được 5 Fado Coin vào tài khoản như một lời tri ân sâu sắc

                    </br>Trân trọng.

                    Đội ngũ Mikotech' 
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
                <div>{!! $data['noidung'] !!}</div>
                <table class="mail-table-tindang">
                    <tr>
                        <td colspan="2"><b>Thông tin liên hệ</b></td>                        
                    </tr>
                    <tr>
                        <td><b>Họ tên:</b></td>
                        <td>{!! $data['name'] !!}</td>
                    </tr>
                    <tr>
                        <td><b>Email:</b></td>
                        <td>{!! $data['emailfrom'] !!}</td>
                    </tr>
                    <tr>
                        <td><b>Số điện thoại:</b></td>
                        <td>{!! $data['phone'] !!}</td>
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