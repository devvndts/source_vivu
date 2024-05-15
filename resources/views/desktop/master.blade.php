<!DOCTYPE html>
<html lang="vi" class="scroll-smooth" >
<head>
    @include('desktop.layouts.head')
    @include('desktop.layouts.css')
    @stack('css_page')
</head>
<body class="{{ ($_SERVER["SERVER_NAME"]=="localhost") ? 'debug-screens' : '' }} relative">
    <div id="my-page" class="!bg-white">
        <div class="main_container overflow-x-hidden xl:overflow-x-visible @yield('element_detail')" id="container_full">
            <div id="fb-root"></div>
            <!-- Header -->
            @if(Route::is('home'))
                {{-- <div class="relative flex flex-col content-between w-full lg:h-screen"> --}}
                    @include('desktop.layouts.header')
                    {{-- @include('desktop.layouts.menu') --}}
                    {{-- @include('desktop.layouts.slider')    --}}
                {{-- </div> --}}
            @else
                @include('desktop.layouts.header')
                @php
                    $data = [
                        'breadcrumbs' => $breadcrumbs ?? null,
                        'background_category' => $background_category ?? '',
                        'title_crumb' => $title_crumb ?? '',
                        'type' => $type ?? '',
                    ];
                @endphp
                @if (!isset($template) || (isset($template) && $template != 'chuongtrinh.detail'))
                    <x-shared.hero :data=$data></x-shared.hero>
                    @if ($data['breadcrumbs'])
                        <div class="container max-w-sreen-xl ">
                            <div class=" my-4">
                                {!! $data['breadcrumbs'] !!}
                            </div>
                        </div>
                    @endif
                @endif
                {{-- @include('desktop.layouts.menu') --}}
            @endif
           {{-- @include('desktop.layouts.header')
            @include('desktop.layouts.menu') --}}
            @if(Route::is('home'))
            @include('desktop.layouts.slider')   
            @endif 
            {{-- @include('desktop.layouts.mmenu_head') --}}
            <!-- yield background -->
            @yield('background_category')
            <!-- Breadcum -->
            {{-- @include('desktop.layouts.breadcum') --}}
            <!-- Content Wrapper. Contains page content -->
            <div class="main_content z-20 relative @yield('center_detail')" id="hcontainer">
                {{-- <!-- Error --> --}}
                {{-- @include('desktop.layouts.error') --}}
                @yield('content')
            </div>

            <!-- Footer -->
            @include('desktop.layouts.footer')
            <!-- Modal -->
            @include('desktop.layouts.modal')
        </div>
        <!-- Loading when wait -->
        @include('desktop.layouts.loading')
        <!-- ./wrapper -->
        {{-- @include('desktop.layouts.ar-contactus') --}}
        @include('desktop.layouts.js')
        @stack('js_page')
        @stack('strucdata')
        @include('sweetalert::alert')
    </div>
    {{-- @include('desktop.layouts.mmenu') --}}
    @include('desktop.layouts.menutoggle')
</body>
</html>
