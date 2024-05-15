<!DOCTYPE html>
<html lang="vi" >
<head>
    @include('desktop.layouts.head')
    @include('desktop.layouts.css')
    @stack('css_page')
</head>
<body class="{{ ($_SERVER["SERVER_NAME"]=="localhost") ? 'debug-screens' : '' }} relative">
    <div id="my-page" class="!bg-white">
        <div class="main_container overflow-x-hidden xl:overflow-x-visible @yield('element_detail')" id="container_full">
            <!-- Content Wrapper. Contains page content -->
            <div class="main_content @yield('center_detail')" id="hcontainer">
                <!-- Error -->
                @include('desktop.layouts.error')
                @yield('content')
            </div>
        </div>
        <!-- ./wrapper -->
        @include('desktop.layouts.js')
        @stack('js_page')
        @stack('strucdata')
    </div>
</body>
</html>
