@php
	$slider = get_photos('slide', $lang, ["order_by" => ["stt" => "asc"]])->toArray();
    $locationTravel = get_categories('dia-diem-du-lich', $lang, ["query" => ["level" => "0", "noibat" => "1"]])->toArray();
    // dd($locationTravel);
    // die;
@endphp
<div class="mt-12 pb-[30px]" id="youSearching">
    <div class="max-w-[1220px] px-[10px] mx-auto ">
        <div class="flex items-center justify-center relative">
            <h3 class="text-[32px] before:content-[''] before:absolute before:h-[2px] before:w-[100px] before:left-[50%] before:translate-x-[-50%] before:bg-primary before:bottom-[-20px] font-semibold text-[#333333]">Bạn Đang Tìm Kiếm Về?</h3>
        </div>
        <div class="relative">
        <div class="swiper slider-swiper mt-14">
			<div class="swiper-wrapper">
				@foreach ($locationTravel as $item)
					@php
						$name = $item->{"ten$lang"};
						$desc = $item->{"mota$lang"};
						$photoUrl = $item->photo;
						$photo = Thumb::Crop(UPLOAD_CATEGORY, $photoUrl ?? '', 379*2, 252*2, 1);
                        $url = $item->$sluglang ?? '';
					@endphp
					<div class="swiper-slide rounded-[10px] overflow-hidden">
						<a class="relative " target="_blank" href="{{ $url }}">
							<x-shared.image src="{{ $photo }}" alt="{{ $name }}" class="w-full " style="max-height: 700px;" />
							<div class="absolute bg-black bg-opacity-40 top-0 right-0 bottom-0 left-0 z-20 flex items-center">
								<div class="container">
									<div class="text-xl text-center md:text-xs xl:text-xl text-white uppercase">{{ $name }}</div>
								</div>
							</div>
						</a>
					</div>
				@endforeach
			</div>
		</div>
        <div class="absolute left-0 top-[50%] translate-y-[-50%] w-full z-20 flex justify-between gap-3 ">
            <div class="swiper-main-button-prev shadow-[0_0_10px_0px_#000] bg-white w-[59px] h-[59px] rounded-full relative right-[30px] border border-white text-[#22B5BB] flex justify-center items-center transition-all duration-300 ease-in-out hover:border-primary hover:text-primary">
                <span class="material-icons">
                west
                </span>
            </div>
            <div class="swiper-main-button-next shadow-[0_0_10px_0px_#000] bg-white w-[59px] h-[59px] rounded-full relative left-[30px]  border border-white transition-all duration-300 ease-in-out hover:border-primary hover:text-primary text-[#22B5BB] flex justify-center items-center"><span class="material-icons">
                east
                </span></div>
        </div>
        <div class="absolute !bottom-[-32px] !w-auto !left-[50%] translate-x-[-50%] z-20 swiper-main-pagination"></div>
    </div>
    </div>
</div>
@push('js_page')
<script>
	$(document).ready(function(){
		var swiper_main = new Swiper(".slider-swiper", {
			loop: true,
			autoplay: JS_AUTOPLAY && {
				delay: 5000,
			},
			// If we need pagination
			pagination: {
				el: '.swiper-main-pagination',
				clickable: true
			},
            spaceBetween: 30,
            slidesPerView: 3,


			// Navigation arrows
			navigation: {
				nextEl: '.swiper-main-button-next',
				prevEl: '.swiper-main-button-prev',
			},
		});
	});
</script>
@endpush