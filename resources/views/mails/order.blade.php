@php
    ///Test Demo:
    /*$config_base = config('config_all.config_base');
    $config_author = config('config_all.author');
    $settingConfig = json_decode(app('setting')['options'],true);
    $setting = app('setting');

    $data = array(
        'noidung' => 'Đánh giá cải thiện dịch vụ giúp trải nghiệm mua sắm tốt hơn tại Fado.vn

                        </br>Xin chào Bình Vũ

                        </br>Cảm ơn quý khách đã lựa chọn Mikotech làm người bạn đồng hành trong hành trình mua sắm của mình

                        </br>Nhằm nâng cấp chất lượng dịch vụ tốt nhất, Mikotech không ngừng cải thiện hệ thống và lắng nghe ý kiến góp ý từ quý khách

                        </br>Mong quý khách dành ít phút để đánh giá trải nghiệm khi sử dụng dịch vụ của Fado Việt Nam

                        </br>Với mỗi lượt đánh giá, quý khách sẽ nhận được 5 Fado Coin vào tài khoản như một lời tri ân sâu sắc

                        </br>Trân trọng.

                        Đội ngũ Mikotech'
    );*/

    $url_main = Helper::GetConfigBase();
@endphp

<!DOCTYPE html>
<html>
<head>
    <!-- UTF-8 -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    @include('mails.css')
</head>

<body>
    <div class="mail-main-contain">
        <div class="mail-container">
            <div class="mail-header" style="border-top: 4px solid #26b99a;">
                <table class="mail-table-header">
                    <tr>
                        <td><span><img src="{{$url_main}}img/mail/hotline.png" alt="mail"></span> {{($settingConfig) ? $settingConfig['hotline'] : 'Đang cập nhật'}}</td>
                        <td><span><img src="{{$url_main}}img/mail/mail.png" alt="mail"></span> {{($settingConfig) ? $settingConfig['email'] : 'Đang cập nhật'}}</td>
                        <td><span><img src="{{$url_main}}img/mail/website.png" alt="mail"></span> {{($settingConfig) ? $settingConfig['website'] : 'Đang cập nhật'}}</td>
                    </tr>
                </table>
                <div class="mail-logo-mikotech">
                    <p><img src='{{ (isset($logo['photo']))?$url_main.UPLOAD_PHOTO.$logo['photo']:'' }}' width="100"/></p>
                        {{--<p><img src='{{ (isset($logo['photo']))?config('config_all.config_all_url').UPLOAD_PHOTO.$logo['photo']:'' }}' width="100"/></p>--}}
                </div>
            </div>
            <div class="mail-body">
                <div class="mail-content-inform" style="background: no-repeat url({{$url_main}}img/mail/logo-mikotech.png) center;background-size: contain;">
                    
                    @if(isset($data['order']))
                        <div class="mail-form-inform">
                            <!--THÔNG TIN ĐƠN HÀNG-->
                            <div class="mail-order-title">THÔNG TIN ĐƠN HÀNG {{ $data['order']['madonhang'] }} <span>(Ngày tạo {{ date('d-m-Y',$data['order']['ngaytao']) }})</span></div>
                            <table class="mail-table-orderinfor">
                                <thead>
                                    <tr>
                                        <td>Thông tin thanh toán</td>
                                        <td>Địa chỉ giao hàng</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><p>{{ $data['order']['hoten'] }}</p><a href="{{ $data['order']['email'] }}" target="_blank">{{ $data['order']['email'] }}</a><p>{{ $data['order']['dienthoai'] }}</p></td>
                                        <td><p>{{ $data['order']['diachi'] }}</p></td>
                                    </tr>
                                </tbody>
                            </table>

                            

                            <div class="mail-order-title">CHI TIẾT ĐƠN HÀNG</div>
                            <table class="mail-table-ordermain">
                                <thead>
                                    <tr>
                                        <td>Sản phẩm</td>
                                        <td>Đơn giá</td>
                                        <td>Số lượng</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $orderDetail = $data['order']['has_order_detail_all'];
                                    @endphp

                                    @if($orderDetail)
                                        @foreach($orderDetail as $k=>$v)
                                        <tr>
                                            <td>{{$v['ten']}}</td>
                                            <td>{{($v['giamoi']>0) ? Helper::Format_Money($v['giamoi']) : Helper::Format_Money($v['gia'])}}</td>
                                            <td>{{$v['soluong']}}</td>
                                        </tr>
                                        @endforeach
                                    @endif

                                    <tr>
                                        <td colspan="2"><strong>Tổng tiền</strong></td>
                                        <td style="text-align: right;"><span style="color:#26b99a;font-weight: bold;">{{Helper::Format_Money($data['order']['tonggia'])}}</span></td>
                                    </tr>                                    
                                    <tr>
                                        <td colspan="3"><strong>{{($data['order']['status_payments']==1) ? 'Đơn hàng đã thanh toán' : 'Đơn hàng chưa thanh toán'}}</strong></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            @if($settingConfig['website'])<p><strong>{{$settingConfig['website']}} cảm ơn quý khách,</strong></p>@endif
                        </div>
                    @endif
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
    </div>
</body>
</html>