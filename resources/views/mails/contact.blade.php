
@php
$mxh = get_photos('mangxahoi_f',$lang);
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
    <table align="center" bgcolor="#dcf0f8" border="0" cellpadding="0" cellspacing="0" style="margin:0;padding:0;background-color:#f2f2f2;width:100%!important;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px" width="100%">
        <tbody>
            <tr>
                <td align="center" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" style="margin-top:15px" width="600">
                        <tbody>
                            <tr>
                                <td align="center" id="m_-6357629121201466163headerImage" valign="bottom">
                                    <table cellpadding="0" cellspacing="0" style="border-bottom:3px solid #107ab7;padding-bottom:10px;background-color:#fff" width="100%">
                                        <tbody>
                                            <tr>
                                                <td bgcolor="#FFFFFF" style="padding:0" valign="top" width="100%">
                                                    <div style="color:#fff;background-color:f2f2f2;font-size:11px">&nbsp;</div>
                                                    <table style="width:100%;">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <a href="{{ config('config_all.config_all_url') }}" style="border:medium none;text-decoration:none;color:#007ed3;margin:0px 0px 0px 20px" target="_blank"><img src='{{ (isset($logo['photo']))?config('config_all.config_all_url')."/".UPLOAD_PHOTO.$logo['photo']:'' }}' width="100"/></a>
                                                                </td>
                                                                <td style="padding:15px 20px 0 0;text-align:right">
                                                                    <div style="text-align: right;">
                                                                        @foreach($mxh as $k=>$v)
                                                                        <a style="display: inline-block; margin-left: 10px" href="{{$v->link}}"><img width="13" src="{{ (isset($v->photo))?config('config_all.config_all_url')."/".UPLOAD_PHOTO.$v->photo:'' }}" alt="Social"></a>
                                                                        @endforeach
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr style="background:#fff">
                                <td align="left" height="auto" style="padding:15px" width="600">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h1 style="font-size:17px;font-weight:bold;color:#444;padding:0 0 5px 0;margin:0">{{ __('Kính chào Quý khách') }}</h1>
                                                    <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal">{{ __('Thông tin liên hệ của quý khách đã được tiếp nhận') }}. {{$settingConfig['website']}} {{ __('sẽ phản hồi trong thời gian sớm nhất') }}.</p>
                                                    <h3 style="font-size:13px;font-weight:bold;color:#107ab7;text-transform:uppercase;margin:20px 0 0 0;padding: 0 0 5px;border-bottom:1px solid #ddd">{{ __('Thông tin liên hệ') }} <span style="font-size:12px;color:#777;text-transform:none;font-weight:normal">({{ __('Ngày') }} {{date('d',$data['ngaytao'])}} {{ (__('tháng')) }} {{date('m',$data['ngaytao'])}} {{ __('năm') }} {{date('Y H:i:s',$data['ngaytao'])}})</span></h3>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px">
                                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="padding:3px 0px;border-top:0;border-left:0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal" valign="top">
                                                                    <span style="text-transform:capitalize">{{$data['tenvi']}}</span><br>
                                                                    <a href="mailto:{{$data['email']}}" target="_blank">{{$data['email']}}</a><br>
                                                                    <a href="tel:{{$data['dienthoai']}}" target="_blank">{{$data['dienthoai']}}</a><br>
                                                                </td>
                                                            </tr>
                                                            
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p style="margin:4px 0;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal"><i>{!!$data['noidung']!!}</i></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;
                                                    <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;border:1px #107ab7 dashed;padding:10px;list-style-type:none">{{ __('Bạn cần được hỗ trợ ngay? Chỉ cần gửi mail về') }} <a href="mailto:{{$settingConfig['email']}}" style="color:#107ab7;text-decoration:none" target="_blank"> <strong>{{$settingConfig['email']}}</strong> </a>, {{ __('hoặc gọi về hotline') }} <strong style="color:#107ab7">{{$settingConfig['hotline']}}</strong> {{$settingConfig['website']}} {{ __('luôn sẵn sàng hỗ trợ bạn bất kì lúc nào') }}.</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;
                                                    <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;margin:0;padding:0;line-height:18px;color:#444;font-weight:bold">{{ _('Một lần nữa') }} {{$settingConfig['website']}} {{ __('cảm ơn quý khách') }}.</p>
                                                    <p style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#444;line-height:18px;font-weight:normal;text-align:right"><strong><a href="{{ config('config_all.config_all_url') }}" style="color:#107ab7;text-decoration:none;font-size:14px" target="_blank">{{$settingConfig['website']}}</a> </strong></p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center">
                    <table width="600">
                        <tbody>
                            <tr>
                                <td>
                                    <p align="left" style="font-family:Arial,Helvetica,sans-serif;font-size:11px;line-height:18px;color:#4b8da5;padding:10px 0;margin:0px;font-weight:normal">{{ __('Quý khách nhận được email này vì đã liên hệ tại') }} {{$settingConfig['website']}}.<br>
                                        {{ __('Để chắc chắn luôn nhận được email thông báo, phản hồi từ') }} {{$settingConfig['website']}}, {{ __('quý khách vui lòng thêm địa chỉ') }} <strong><a href="mailto:{{$settingConfig['email']}}" target="_blank">{{$settingConfig['email']}}</a></strong> {{ __('vào số địa chỉ') }} (Address Book, Contacts) {{ __('của hộp email') }}.<br>
                                        <b>{{ __('Địa chỉ') }}:</b> {{$settingConfig['diachi']}}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>