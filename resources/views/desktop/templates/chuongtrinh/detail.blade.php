@extends('desktop.master')
@php
    $chuongtrinhDetailGallery = get_photos('slide', $lang, ['order_by' => ['stt' => 'asc']]);
    $text_general = get_static('text-general', $lang);
@endphp
@section('content')
    <div class="mt-14">
        <div class="container max-w-[1390px]">
            <h1 class="text-2xl xl:text-5xl font-title text-[#404040] font-bold uppercase" id="ten_chuong_trinh">{{ $data['name'] }}</h1>
        </div>
    </div>
    @if (isset($hinhanhsp))
        <div class="swiper swiper-chuongtrinhdetail mt-8">
            <div class="swiper-wrapper">
                @foreach ($hinhanhsp as $item)
                    @php
                        $name = $item["ten$lang"] ?? '';
                        $photoUrl = $item["photo"] ?? '';
                        $photo = Thumb::Crop(UPLOAD_PRODUCT, $photoUrl ?? '', 1440, 580, 2);
                    @endphp
                    <div class="swiper-slide">
                        <div class="relative aspect-w-5 rounded-[0px_231px_0px_0px] aspect-h-2 bg-no-repeat bg-cover" style="background-image: url({{ $photo }})">
                            {{-- <x-shared.image src="{{ $photo }}" alt="{{ $name }}" class="w-full " /> --}}
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="absolute left-0 bottom-6 w-full z-20 flex justify-center gap-3 ">
                <div
                    class="swiper-button-prev-chuongtrinhdetail w-[33px] h-[33px] rounded-full border border-white text-white flex justify-center items-center transition-all duration-300 ease-in-out hover:border-primary hover:text-primary">
                    <span class="material-icons">
                        chevron_left
                    </span>
                </div>
                <div
                    class="swiper-button-next-chuongtrinhdetail w-[33px] h-[33px] rounded-full border border-white transition-all duration-300 ease-in-out hover:border-primary hover:text-primary text-white flex justify-center items-center">
                    <span class="material-icons">
                        chevron_right
                    </span>
                </div>
            </div>
        </div>
    @endif

    @include('desktop.templates.chuongtrinh.child.content')
    @include('desktop.templates.chuongtrinh.child.doituonghocvien')
    @include('desktop.templates.chuongtrinh.child.quyenloi')
    <div class="relative overflow-hidden">
        <img src="public/pts/dichvudaotao.png" alt="dichvudaotao" class="absolute top-0 left-0 z-10 ">
        <img src="public/pts/chuongtrinh.png" alt="chuongtrinh" class="absolute top-[480px] right-0 z-10 ">
        <div class="absolute w-[563px] h-[563px] left-1/2 -translate-x-1/2  bottom-0 bg-orange-500 bg-opacity-10 filter blur-3xl"></div>
        @include('desktop.templates.chuongtrinh.child.camket')
        @include('desktop.templates.chuongtrinh.child.lotrinhthamgia')
    </div>
    @include('desktop.templates.chuongtrinh.child.lotrinhdaotao')
    @include('desktop.templates.chuongtrinh.child.ketqua')
    @include('desktop.templates.chuongtrinh.child.sanpham')
@endsection

@push('js_page')
    <script>
        $(document).ready(function() {
            const getTenChuongTrinh = document.getElementById('ten_chuong_trinh').textContent;
            const setTenChuongTrinh = document.getElementById('dangkytuvan[chude]').value = getTenChuongTrinh;
            const swiper_chuongtrinhdetail = new Swiper('.swiper-chuongtrinhdetail', {
                // Optional parameters
                loop: true,

                // Navigation arrows
                navigation: {
                    nextEl: '.swiper-button-next-chuongtrinhdetail',
                    prevEl: '.swiper-button-prev-chuongtrinhdetail',
                },
            });
        });
    </script>
@endpush
