@php
$currentSource = isset(Route::current()->controller->slug) ? Route::current()->controller->slug : null;
@endphp

<nav id="menu" class="">
    <ul class="">
        <li>
            <a class=" {{ Route::current()->getName() == 'home' ? 'current-active' : '' }}" href="" >
                {{ __('Trang chủ') }}
            </a>
        </li>

        <li>
            <a class=" {{ $currentSource == 'gioi-thieu' ? 'current-active' : '' }}" href="gioi-thieu" >
                {{ __('Giới thiệu') }}
            </a>
        </li>
        <li>
            <a class=" {{ $currentSource == 'san-pham' ? 'current-active' : '' }}" href="san-pham" >
                {{ __('Sản phẩm') }}
            </a>
            {!! Helper::showCategoryMenuMulty('nav_main','product',["mega"=>0]); !!}
        </li>
        <li>
            <a class=" {{ $currentSource == 'dich-vu' ? 'current-active' : '' }}" href="dich-vu" >
                {{ __('Dịch vụ') }}
            </a>
        </li>
        <li>
            <a class=" {{ $currentSource == 'tin-tuc' ? 'current-active' : '' }}" href="tin-tuc" >
                {{ __('Tin tức') }}
            </a>
        </li>
        <li>
            <a class=" {{ $currentSource == 'lien-he' ? 'current-active' : '' }}" href="lien-he" >
                {{ __('Liên hệ') }}
            </a>
        </li>
    </ul>
</nav>