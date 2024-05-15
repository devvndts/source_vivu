@php
$currentSource = isset(Route::current()->controller->slug) ? Route::current()->controller->slug : null;
$mangxahoi = get_photos('mangxahoi', $lang, ["order_by" => ["stt" => "asc"]]);
$dichvuCategories = get_categories('dich-vu', $lang, ['order_by' => ['stt' => 'asc'], 'query' => ['level' => '0']]);
@endphp

<div class="container hidden nav-menu hc-nav hc-nav-1">
    <ul class="flex-start">
        <li data-nav-custom-content="">
            <div class="mx-auto menu-logo w-44"> <img src="{{ asset(UPLOAD_PHOTO.$photo_static['logo']['photo']) }}" class="mx-auto" alt="Logo"> </div>
        </li>
        <li data-nav-custom-content="">
            <div class="flex justify-center mx-auto mt-0 border border-black rounded-none header-search-top"> 
                <button type="button" onclick="onSearch2('.nav-open #keyword_m');" class="w-8 h-8 text-center bg-white"><img src="img/icon/search.png" alt="search" class="mx-auto"></button> 
                <input type="text" id="keyword_m" class="flex-1 w-auto h-8 min-w-0 text-base text-black border-none outline-none search-txt" placeholder="Tìm kiếm sản phẩm" > 
            </div>
        </li>
        <li>
            <a class="{{ Route::current()->getName() == 'home' ? 'current-active' : '' }}" href="{{ route('home') }}" >
                {{ __('Trang chủ') }}
            </a>
        </li>

        <li>
            <a class="{{ $currentSource == 'gioi-thieu' ? 'current-active' : '' }}" href="gioi-thieu" >
                {{ __('Về chúng tôi') }}
            </a>
        </li>

        <li>
            <a class="{{ $currentSource == 'chuong-trinh-dao-tao' ? 'current-active' : '' }}" href="chuong-trinh-dao-tao" >
                {{ __('Chương Trình Đào Tạo') }}
            </a>
            {!! Helper::showCategoryMenuMulty('nav_main','chuong-trinh-dao-tao',["mega"=>0]); !!}
        </li>

        <li>
            <a class="{{ $currentSource == 'dich-vu-dao-tao' ? 'current-active' : '' }}" href="dich-vu-dao-tao" >
                {{ __('Đào tạo đại học') }}
            </a>
            {!! Helper::showCategoryMenuMulty('nav_main','dich-vu-dao-tao',["mega"=>0]); !!}
        </li>

        <li>
            <a class="cursor-pointer {{ $currentSource == 'hoc-vien-va-doanh-nghiep' ? 'current-active' : '' }}" href="{{ url('hoc-vien-va-doanh-nghiep') }}" >
                {{ __('Học Viên & Doanh Nghiệp') }}
            </a>
        </li>

        <li>
            <a class="cursor-pointer {{ $currentSource == 'chuyen-gia' ? 'current-active' : '' }}" href="{{ url('chuyen-gia') }}" >
                {{ __('Chuyên gia') }}
            </a>
        </li>

        <li>
            <a class="{{ $currentSource == 'tin-tuc' ? 'current-active' : '' }}" href="tin-tuc" >
                {{ __('Tin tức') }}
            </a>
            {!! Helper::showCategoryMenuMulty('nav_main','tin-tuc',["mega"=>0]); !!}
        </li>

        <li class="!static fixed-social">
            <div class="fixed bottom-0 left-0 flex items-center justify-center w-full py-1 bg-black social-menu">  
                @foreach ($mangxahoi as $item)
                @php
                    $img = Thumb::Crop(UPLOAD_PHOTO,$item->photo,30,30,2);
                @endphp
                <span class="inline-flex items-center justify-center w-8"><img src="{{ $img }}" alt="{{ $item->{'ten'.$lang} }}" alt="{{ $item->{'ten'.$lang} }}"></span> 
                @endforeach
            </div>
        </li>
    </ul>
</div>