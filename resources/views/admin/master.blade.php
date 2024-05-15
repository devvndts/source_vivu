<!DOCTYPE html>
<html>

<head>
    @include('admin.layouts.meta')
    @include('admin.layouts.css')
    @stack('css')
</head>
@php
    // $uri = $request->path();
    // dd($request->path());
    // dd(config('config_all.login'));
    // session([config('config_all.login.admin') => [
    //     'isAbc' => true
    // ]]);
    // dd(session(config('config_all.login.admin'))['isAbc']);
    // $request->session()->flush();
@endphp
<body class="hold-transition sidebar-mini layout-fixed" id="mikotech">
    <div class="wrapper">
        <!-- Error -->
        @include('admin.layouts.error')
        <!-- Navbar -->
        @include('admin.layouts.navbar')

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Logo -->
            @include('admin.layouts.logo')
            <!-- Sidebar -->
            @include('admin.layouts.menu')
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('admin.layouts.breadcum')
            <section class="content">
                <div class="container-fluid">@yield('content')</div><!-- /.container-fluid -->
            </section>
        </div>
        @include('admin.layouts.footer')
    </div>
    <!-- ./wrapper -->

    @include('admin.layouts.js')
    @yield('js_page')
    @stack('js')

</body>

</html>
