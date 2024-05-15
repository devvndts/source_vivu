{{-- <div class="back-to-top"><i class="far fa-arrow-to-top"></i></div> --}}
{{-- <div id="messages-facebook"></div> --}}
{{-- <div class="hotline-autofix">
    <a href="https://zalo.me/{{ preg_replace('/[^0-9]/', '', $settingOption["zalo"]); }}" class="box-autofix w-[63px] h-[63px] inline-flex justify-center items-center bg-primary rounded-full"><img class="w-1/2" src="img/icon_zalo.png" ></a>
</div>
<div class="bottom-[110px] hotline-autofix ">
    <a href="{{ $settingOption["fanpage"] }}" class="pl-0 bg-primary rounded-full box-autofix ">
        <div class="w-[63px] h-[63px] bg-primary rounded-full inline-flex justify-center items-center"><img src="img/facebook.png" class="!ml-0 brightness-0 invert" ></div>
    </a>
</div> --}}
<div id="navigation_toolbox" class="fixed z-[5000] right-5 bottom-[60px]">
    <ul class="caht m-0 flex flex-col">
        <li class="h my-2"><a href="{{ $settingOption["fanpage"] }}" target="_blank" class="   overflow-hidden ">
            <img src="{{ asset('public/pts/fbicon.png') }}" width="40" height="40"></a></li>
        <li class="c my-2"><a href="https://zalo.me/{{ preg_replace('/[^0-9]/', '', $settingOption["zalo"]); }}" target="_blank" class="   overflow-hidden ">
            <img src="{{ asset('public/pts/zlicon.png') }}" width="40" height="40"></a></li>
        <li class="f my-2"><a href="tel:+{{ preg_replace('/[^0-9]/', '', $settingOption["hotline"]); }}" class="   overflow-hidden ">
            <img src="{{ asset('public/pts/phone87-150x150.png') }}" width="40" height="40"></a></li>
    </ul>
</div>

<!--css thêm cho mỗi trang-->
@push('css_page')
@endpush
