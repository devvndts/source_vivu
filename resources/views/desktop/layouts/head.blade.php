<!-- Basehref -->
<base href="{{$config_base}}"/>

<!-- UTF-8 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Robots -->
<meta name="robots" content="index,follow" />

<!-- Favicon -->
<link href="{{ Thumb::Crop(UPLOAD_PHOTO,$favicon['photo'],130,0,2,null) }}" rel="shortcut icon" type="image/x-icon" />

<!-- Js annalytics -->
{!! $settingOption['annalytics'] !!}

<!-- Webmaster Tool -->
{!! ($settingOption['mastertool']) !!}

<!-- GEO -->
{{--
<meta name="geo.region" content="VN" />
<meta name="geo.placename" content="Hồ Chí Minh" />
<meta name="geo.position" content="10.823099;106.629664" />
<meta name="ICBM" content="10.823099, 106.629664" />--}}

<!-- Author - Copyright -->
<meta name='revisit-after' content='1 days' />
<meta name="author" content="{!!$setting['ten'.$lang]!!}" />
<meta name="copyright" content="{!!$setting['ten'.$lang]." - [".$settingOption['email']."]"!!}" />

{!! SEOMeta::generate() !!}
{!! OpenGraph::generate() !!}
{!! Twitter::generate() !!}

<!-- Chống đổi màu trên IOS -->
<meta name="format-detection" content="telephone=no">

<!-- Viewport -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

<!-- csrf -->
<meta name="csrf-token" content="{{ csrf_token() }}">

