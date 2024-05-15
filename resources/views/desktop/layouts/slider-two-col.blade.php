@php
	$slider = get_photos('slide', $lang, ["order_by" => ["stt" => "asc"]])->toArray();
	// $slidemobile = get_photos('slidemobile', $lang, ["order_by" => ["stt" => "asc"]])->toArray();
	$slideBg = get_static_photo('logo-address', $lang);
	$img = Thumb::Crop(UPLOAD_PHOTO, $slideBg->photo ?? '', 1265, 520, 1);
@endphp
@isset($slider)
<div class="container my-8 max-w-screen-2xl">
	<div class="relative z-10 pb-4 overflow-hidden bg-cover rounded-lg md:bg-auto md:pb-0 slider-swiper" style="background-image: url('{{ $img }}')" >
		<div class="group slider-swiper-box swiper">
			<div class="swiper-wrapper">
				@foreach ($slider as $key => $item)
				@php
					$name = $item->{'ten'.$lang} ?? '';
					$desc = $item->{'mota'.$lang} ?? '';
					$url = $item->link ?? '';
					$img = Thumb::Crop(UPLOAD_PHOTO, $item->photo ?? '', 630, 520, 1);
				@endphp
				<div class="swiper-slide">
					<div class="flex flex-wrap justify-between md:flex-nowrap ">
						<figure class="md:w-1/2 md:order-2">
							<x-shared.image class="lg:min-h-[520px]" alt="{{ $name }}" src="{{ $img }}" />
						</figure>
						<div class="md:pt-12 md:w-1/2 lg:pt-24">
							<div class="w-full px-4 mx-auto md:px-0 md:w-3/4 ">
								@if ($name)
								<div class="text-xl font-bold lg:text-3xl text-primary line-clamp-3">{{ $name }}</div>
								@endif
								@if ($desc)
								<div class="mt-3 text-sm lg:mt-6 text-secondary line-clamp-5">{{ $desc }}</div>
								@endif
								@if ($url)
								<a href="{{ $url }}" class="inline-block px-6 py-2 mt-6 text-xs font-bold text-white rounded-lg bg-primary-500">{{ __('Xem chi tiết') }}</a>
								@endif
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>

			<!-- If we need navigation buttons -->
			<div class="swiper-button-prev [body_&]:bg-transparent [body_&]:text-transparent group-hover:!text-secondary"></div>
			<div class="swiper-button-next [body_&]:bg-transparent [body_&]:text-transparent group-hover:!text-secondary"></div>
		</div>
	</div>
</div>
@endisset
@push('js_page')
<script>
	$(document).ready(function(){
		var slider_swiper_box = new Swiper(".slider-swiper-box", {
			loop: true,
			// If we need pagination
			// pagination: {
			// 	el: '.swiper-pagination',
			// },

			// Navigation arrows
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
		});
	});
</script>
@endpush