<div class="cate-top">
    <div class="container">
        <div class="cate-info">
            <div class="cate-info__title">Danh mục sản phẩm</div>
            <div class="cate-info__content">
                {!! Helper::showCategoryMenuMulty('menu-verticle'); !!}  
                {{-- 

                <ul>
                                    <li><a href="">Danh mục<i class="far fa-chevron-right"></i></a>
                
                                        
                                    </li>
                                    <li class="hoverhori"><a href="">Danh mục x<i class="far fa-chevron-right"></i></a>
                                        <ul>
                                            <li><a href="">Danh mục</a></li>
                                            <li><a href="">Danh mục xx</a>
                                                <ul>
                                                    <li><a href="">Danh mục xxx</a></li>
                                                    <li><a href="">Danh mục</a></li>
                                                    <li><a href="">Danh mục</a></li>
                                                    <li><a href="">Danh mục</a></li>
                                                    <li><a href="">Danh mục</a></li>
                                                    <li><a href="">Danh mục</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="">Danh mục</a></li>
                                            <li><a href="">Danh mục</a></li>
                                            <li><a href="">Danh mục</a></li>
                                            <li><a href="">Danh mục</a></li>
                                        </ul>
                                    </li>
                                    <li class="hoverhori"><a href="">Danh mục xx<i class="far fa-chevron-right"></i></a>
                                        <ul>
                                            <li><a href="">Danh mục</a></li>
                                            <li><a href="">Danh mục xx -- xx</a>
                                                <ul>
                                                    <li><a href="">Danh mục xxx -- xx</a></li>
                                                    <li><a href="">Danh mục</a></li>
                                                    <li><a href="">Danh mục</a></li>
                                                    <li><a href="">Danh mục</a></li>
                                                    <li><a href="">Danh mục</a></li>
                                                    <li><a href="">Danh mục</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="">Danh mục</a></li>
                                            <li><a href="">Danh mục</a></li>
                                            <li><a href="">Danh mục</a></li>
                                            <li><a href="">Danh mục</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="">Danh mục<i class="far fa-chevron-right"></i></a></li>
                                    <li><a href="">Danh mục<i class="far fa-chevron-right"></i></a></li>
                                    <li><a href="">Danh mục<i class="far fa-chevron-right"></i></a></li>
                                    <li><a href="">Danh mục<i class="far fa-chevron-right"></i></a></li>
                                </ul> 
                 --}}
            </div>
        </div>
        <div class="cate-slider">
            <ul class="cate-slider__nav">
               <li><a href="gioi-thieu">Giới thiệu</a></li> 
               <li><a href="kenh-phan-phoi">Kênh phân phối</a></li> 
               <li><a href="tin-tuc">Tin tức</a></li> 
               <li><a href="lien-he">Liên hệ</a></li> 
            </ul>
            <div class="cate-slider__container">
                <div class="cate-slider-left">
                    <!-- Slider -->
                    @include('desktop.layouts.slider')   
                </div>
                <div class="cate-slider-right">
                    <a href="{{ $photo_static['banner_1']['link'] }}" class="cate-slider__banner">
                        <img src="{{ (isset($photo_static['banner_1']['photo']))?asset(UPLOAD_PHOTO.$photo_static['banner_1']['photo']):'' }}" onerror=src="{{asset('img/noimage.png')}}" alt="Logo">
                    </a>
                    <a href="{{ $photo_static['banner_2']['link'] }}" class="cate-slider__banner">
                        <img src="{{ (isset($photo_static['banner_2']['photo']))?asset(UPLOAD_PHOTO.$photo_static['banner_2']['photo']):'' }}" onerror=src="{{asset('img/noimage.png')}}" alt="Logo">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>