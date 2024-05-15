@php
    $mangxahoi = get_photos('mangxahoi', $lang, ["order_by" => ["stt" => "asc"]]);
@endphp
{{-- <div class="bg-primary">
    <div class="container max-w-[1390px] min-h-[40px] flex lg:justify-center items-center justify-between">
        <div class="flex-1 text-sm font-medium text-[#404040] hidden xl:flex items-center gap-5">
            <span class="flex items-center gap-2">
                <img src="./public/pts/phone.png" alt="phone">
                {{ $settingOption['hotline'] }}
            </span>
            <hr class="h-6 block w-[1px] bg-[#404040] opacity-[0.5]">
            <span class="flex items-center gap-2">
                <img src="./public/pts/email.png" alt="email">
                {{ $settingOption['email'] }}
            </span>
        </div>
        <div class="lg:flex-1 flex-auto w-full lg:w-auto text-xs font-bold text-white text-center md:text-left xl:text-center">
            {{ $settingOption['diachi'] }}
        </div>
        <div class="flex-1 flex gap-5 justify-end items-center">
            <x-shared.social2 :data=$mangxahoi class="xl:flex hidden" />
            <hr class="h-6 hidden xl:block w-[1px] bg-[#404040] opacity-[0.5]">
            @include('desktop.layouts.search')
        </div>
    </div>
</div> --}}
<div id="header" class="relative bg-white [.fixed-top&]:fixed top-0 z-30 w-full shadow-md" style="--shadow: 0px 8px 26px rgba(0, 0, 0, 0.11);">
    <div class="container max-w-[1220px]  px-[10px] flex items-center gap-[57px] justify-between min-h-[65px] py-[5px] [.fixed-top_&]:min-h-[60px]">
        <a href="{{ url('') }}" class="">
            <x-shared.image src="{{ UPLOAD_PHOTO . $photo_static['logo']['photo'] }}" alt="Logo" class="max-h-[65px]" />
        </a>
        @include('desktop.layouts.menu')
    </div>
</div>
{{-- <div id="header" class="relative z-30 bg-white shadow-2xl">
    <div class="container max-w-screen-xl">
        <div class="flex items-center justify-between">
            <a href="{{ url('') }}" class="">
                <x-shared.image src="{{ UPLOAD_PHOTO . $photo_static['logo']['photo'] }}" alt="Logo" class="[.fixed-top_&]:w-[50px] w-[100px]" />
            </a>
            
        </div>
    </div>
</div> --}}
{{-- <div id="header" class="[.home\_content_&]:absolute [.my-fixed&]:fixed relative top-0 left-0 z-20 hidden w-full lg:block pt-11 bg-[url(../pts/Group77.png)] [.home\_content_&]:bg-none [.home\_content_&]:pb-0 pb-11">
    <div class="container max-w-screen-2xl">
        <div class="h-20 border border-white rounded-[100px] [.my-fixed_&]:bg-white bg-white/40  backdrop-opacity-95">
            @include('desktop.layouts.menu')
        </div>
    </div>
</div>
<div class="left-0 z-20 block w-full py-2 bg-black lg:hidden [.home\_content_&]:fixed-top bg-opacity-40 backdrop-opacity-95 ">
    <div class="container">
        <div class="flex items-center justify-between">
            <div class="w-[100px]">
                <a id="hamburger" href="#menu" class="h-[25px] w-[25px]  relative inline-flex xl:hidden items-center ml-5 justify-center before:bg-white after:bg-white uppercase" title="Menu"><span class="bg-white"></span></a>
            </div>
            <a href="{{ url('') }}" class="relative inline-flex items-center justify-center z-10 w-14 h-14  rounded-md bg-white shadow-[0px_20px_36px_rgba(0,0,0,0.2)]">
                <x-shared.image src="{{ UPLOAD_PHOTO . $photo_static['logo']['photo'] }}" alt="Logo" class="max-w-[50px]" />
            </a>
            <x-shared.language />
        </div>
    </div>
</div> --}}
<!--css thêm cho mỗi trang-->
@push('css_page')
@endpush


@push('js_page')
    <script>
        $(document).ready(function() {
            // $( '.js-current-lang' ).text(LANG);
            // $( '.js-lang-button' ).each(function( index ) {
            //     if ($( this ).data('lang') == LANG) {
            //         $( this ).removeClass('hidden')
            //     }
            // });
            
            // $( '.js-lang-open-button' ).click(function( e ) {
            //     if ($( '.js-lang-button-box' ).hasClass('hidden')) {
            //         $( '.js-lang-button-box' ).removeClass('hidden')
            //     } else {
            //         $( '.js-lang-button-box' ).addClass('hidden')
            //     }
                
            // });
            // $(document).mouseup(function(e) 
            // {
            //     var container = $('.js-lang-open-button');
            //     // if the target of the click isn't the container nor a descendant of the container
            //     if (!container.is(e.target) && container.has(e.target).length === 0) 
            //     {
            //         $( '.js-lang-button-box' ).addClass('hidden')
            //     }
            // });
        })
    </script>
@endpush
