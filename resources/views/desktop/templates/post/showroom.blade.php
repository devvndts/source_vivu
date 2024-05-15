@extends('desktop.master')
@php
    $hethong = get_posts('he-thong', $lang);
@endphp
@section('content')
<div class="container max-w-screen-xl ">
    {{-- <x-shared.subtitle title="{{ $title_crumb }}" /> --}}
        <div class="flex flex-wrap justify-between">
            <div class="w-full lg:w-1/5">
                <x-sidebarmenu.index isOpen type="he-thong" class="my-8">

                </x-sidebarmenu.index>
            </div>
            <div class="w-full lg:w-3/4">
                <div class="flex flex-wrap items-start justify-between py-10 lg:flex-nowrap">
                    <x-tabnav.index class="w-full lg:w-1/3" tabId="tabs-tab">
                        @foreach ($hethong as $item)
                        @php
                            $activeClass = ($loop->index == 0) ? 'active' : '';
                            $iden = 'tabs-home'.$item->id;
                            $sl_options = Helper::JsonDecode($item->sl_options);
                            $name = $item->{"ten$lang"} ?? '';
                            $diachi = $sl_options["diachi"] ?? '';
                            $dienthoai = $sl_options["dienthoai"] ?? '';
                            // $toado_iframe = $sl_options["toado_iframe"];
                        @endphp
                            <x-tabnav.item class="{{ $activeClass }}" :tabId="$iden">
                                <p class="text-lg font-bold text-secondary">{{ $name }}</p>
                                @if ($diachi)
                                <p class="text-sm">- {{ $diachi }}</p>
                                @endif
                                @if ($dienthoai)
                                <p class="text-sm">- {{ $dienthoai }}</p>
                                @endif
                            </x-tabnav.item>
                        @endforeach
                    </x-tabnav.index>
                    <x-tabpane.index class="w-full lg:w-2/3" tabId="tabs-tab">
                        @foreach ($hethong as $item)
                        @php
                            $activeClass = ($loop->index == 0) ? 'show active' : '';
                            $iden = 'tabs-home'.$item->id;
                            $sl_options = Helper::JsonDecode($item->sl_options);
                            $toado_iframe = $sl_options["toado_iframe"];
                        @endphp
                        <x-tabpane.item class="{{ $activeClass }}" :tabId="$iden">
                            <div class="[&>iframe]:w-full">
                                {!! $toado_iframe !!}
                            </div>
                        </x-tabpane.item>
                        @endforeach
                    </x-tabpane.index>
                </div>
            </div>
        </div>
        
    
</div>
@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')

@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')
<script>
    $(document).ready(function () {
        $('#tabs-tabVertical .nav-link').click(function(){
            console.log('xxxx');
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#tabs-tabContentVertical").offset().top
            }, 1000);
        })
    });
</script>
@endpush

@push('strucdata')
    @include('desktop.layouts.strucdata')
@endpush