@php
@endphp
<div class="product-category py-7">
    @foreach ($categoriesNoibat as $key => $item)
        @php
            $class = ($key + 1) % 2 == 0 ? 'even' : '';
            $name = $item['ten' . $lang];
            $url = $item[$sluglang];
            $desc = $item['mota' . $lang];
            $products = $model_product->GetAllItems('product', ['hienthi' => 1, 'noibat' => 1, 'level_1' => $item['id']]);
			$img = sprintf('<img class="w-full" src="%s" alt="%s" onerror="src=\'%s\'">', Thumb::Crop(UPLOAD_CATEGORY,$item['background'],1266,260,1,$item['type']), $name, asset('img/noimage.png'));
        @endphp

        @if (!empty($products))
            <div class="product-category-feature mb-7">
                <div class="container">
                    <figure>
						<a href="{{ $url }}">
						{!! $img !!}
						</a>
                    </figure>
                </div>
            </div>
            <div
                class="product-category-main product-category-main--{{ $class }} pb-7 max-w-[1366px] mx-auto flex 
		flex-wrap md:flex-nowrap
	">
                <div class="product-category-main__info mb-[25px] md:mb-0 w-full md:w-[43%] flex flex-col">
                    <div
                        class="product-category-main__info__content pl-[1em] pr-[1em] md:pr-0 md:pl-[15%] md:max-w-[345px]">
                        <h5 class="mt-8 mb-5 text-xl font-bold uppercase md:mt-24">{{ $name }}</h5>
                        <p class="mb-5 text-sm font-light line-clamp-3">{{ $desc }}</p>
                        <x-button title="{{ __('site.readmore') }}" href="{{ $url }}">
                            <x-slot name="icon"></x-slot>
                        </x-button>
                    </div>
                    <div
                        class="slider-product-pagination relative border-b border-[#845536] border-opacity-20 flex items-end justify-between w-full md:ml-[15%] md:max-w-[345px] mt-4 ml-[1em] w-[calc(100%-2em)] pb-4 
			">
                        <div
                            class="absolute -bottom-[1px] left-0 w-[114px] h-[1px] bg-gradient-to-r from-[#B78260] to-[#815030]">
                        </div>
                        <div class="product-swiper-{{ $item['id'] }}-pagination"></div>
                        <div class="product-swiper-{{ $item['id'] }}-prev"><i
                                class="far fa-long-arrow-left text-[#845536] before:text-[22px]"></i></div>
                        <div class="product-swiper-{{ $item['id'] }}-next ml-3"><i
                                class="far fa-long-arrow-right text-[#845536] before:text-[22px]"></i></div>
                    </div>
                </div>
                <div class="w-full min-w-0 product-category-main__items md:w-auto md:flex-1">
                    <div class="product-swiper-{{ $item['id'] }} swiper">
                        <div class="swiper-wrapper">
                            @foreach ($products as $keyProduct => $itemProduct)
                                <div class="hidden [.swiper-initialized_&]:block swiper-slide ">
                                    <x-product :item="$itemProduct"></x-product>
                                    {{-- <div class="box-product-item">
							<a href="" class="bg-[#FBECD5] rounded-[3px] block mb-4 pb-[120%] relative">
								<img src="{{ asset('img/product.png') }}" class="absolute max-w-full -translate-x-1/2 -translate-y-1/2 left-1/2 top-1/2" alt="">
							</a>
							<div>
								<h3 class="text-base line-clamp-2 mb-[6px]"><a class="text-black" href="">Lorem ipsum dolor sit amet, xkjj consectetur adipiscing elit...</a></h3>
								<div>
									<span class="text-xs">Ut imperdiet.</span>
								</div>
								<div class="flex items-end justify-between flex-nowrap">
									<div class="flex-1 min-w-0">
										<strong class="text-base text-primary">245.000đ</strong>
										<span class="ml-2 text-xs line-through">128.000đ</span>
									</div>
									<a href="" class="rounded-[3px] w-[30px] h-[30px] bg-[linear-gradient(90deg,#B78260_-14.95%,#815030_66.53%)] flex justify-center items-center"><span class="text-white text-[35px]">+</span></a>
								</div>
							</div>
						</div> --}}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    {{-- @php
		$demoUUID = ['uuid0','uuid1','uuid2','uuid3'];
	@endphp
	@for ($j = 0; $j < 4; $j++)
	@php
		$class = (($j+1)%2 == 0)?'even':'';
	@endphp
	<div class="product-category-feature mb-7">
		<div class="container">
			<figure>
				<img src="{{ asset('img/advertisement.png') }}" class="w-full" alt="">
			</figure>
		</div>
	</div>
	<div class="product-category-main product-category-main--{{ $class }} pb-7 max-w-[1366px] mx-auto flex 
		flex-wrap md:flex-nowrap
	">
		<div class="product-category-main__info mb-[25px] md:mb-0 w-full md:w-[43%] flex flex-col">
			<div class="product-category-main__info__content pl-[1em] pr-[1em] md:pr-0 md:pl-[15%] md:max-w-[345px]">
				<h5 class="mt-8 mb-5 text-xl font-bold uppercase md:mt-24">vegan vitamin suplement</h5>
				<p class="mb-5 text-sm font-light line-clamp-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquet pellentesque lectus adipiscing amet nisi nulla volutpat. Tincidunt adipiscing orci, lacinia amet.</p>
				@php
					$data = [
						'title' => '',
						'class' => '',
						'link' => '#',
						'icon' => '',
					];
				@endphp
				@include('desktop.layouts.button-primary', ['data' => $data])
			</div>
			<div class="slider-product-pagination relative border-b border-[#845536] border-opacity-20 flex items-end justify-between w-full md:ml-[15%] md:max-w-[345px] mt-4 ml-[1em] w-[calc(100%-2em)] pb-4 
			">
				<div class="absolute -bottom-[1px] left-0 w-[114px] h-[1px] bg-gradient-to-r from-[#B78260] to-[#815030]"></div>
				<div class="product-swiper-{{ $demoUUID[$j] }}-pagination"></div>
				<div class="product-swiper-{{ $demoUUID[$j] }}-prev"><i class="far fa-long-arrow-left text-[#845536] before:text-[22px]"></i></div>
				<div class="product-swiper-{{ $demoUUID[$j] }}-next ml-3"><i class="far fa-long-arrow-right text-[#845536] before:text-[22px]"></i></div>
			</div>
		</div>
		<div class="w-full min-w-0 product-category-main__items md:w-auto md:flex-1">
			<div class="product-swiper-{{ $demoUUID[$j] }} swiper">
				<div class="swiper-wrapper">
					@for ($i = 0; $i < 5; $i++)
					<div class="swiper-slide">
						<div class="box-product-item">
							<a href="" class="bg-[#FBECD5] rounded-[3px] block mb-4 pb-[120%] relative">
								<img src="{{ asset('img/product.png') }}" class="absolute max-w-full -translate-x-1/2 -translate-y-1/2 left-1/2 top-1/2" alt="">
							</a>
							<div>
								<h3 class="text-base line-clamp-2 mb-[6px]"><a class="text-black" href="">Lorem ipsum dolor sit amet, xkjj consectetur adipiscing elit...</a></h3>
								<div>
									<span class="text-xs">Ut imperdiet.</span>
								</div>
								<div class="flex items-end justify-between flex-nowrap">
									<div class="flex-1 min-w-0">
										<strong class="text-base text-primary">245.000đ</strong>
										<span class="ml-2 text-xs line-through">128.000đ</span>
									</div>
									<a href="" class="rounded-[3px] w-[30px] h-[30px] bg-[linear-gradient(90deg,#B78260_-14.95%,#815030_66.53%)] flex justify-center items-center"><span class="text-white text-[35px]">+</span></a>
								</div>
							</div>
						</div>
					</div>
					@endfor
				</div>
			</div>
		</div>
	</div>
	@endfor --}}


</div>
<!--js thêm cho mỗi trang-->
@push('js_page')
    <script>
        // demoUUID = ['uuid0','uuid1','uuid2','uuid3'];
        demoUUID = @json($categoriesNoibat);
        $(document).ready(function() {
            // Pause and play the video, and change the button text
            for (let index = 0; index < demoUUID.length; index++) {
                const element = demoUUID[index].id;
                var slider__content__swiper = new Swiper(`.product-swiper-${element}`, {
                    slidesPerView: 2.2,
                    spaceBetween: 10,
                    speed: 800,
                    loop: true,
                    autoHeight: true,
                    /*autoplay: {
                    	delay: 8000,
                    	disableOnInteraction: false,
                    },*/
                    pagination: {
                        el: `.product-swiper-${element}-pagination`,
                        type: "fraction",
                    },
                    navigation: {
                        nextEl: `.product-swiper-${element}-next`,
                        prevEl: `.product-swiper-${element}-prev`,
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 3.2,
                            spaceBetween: 15,
                        }
                    },
                });
            }
        });
    </script>
@endpush
