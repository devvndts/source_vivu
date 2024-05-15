@php
	$quangcao = get_photos('quangcao', $lang, ["order_by" => ["stt" => "asc"]])->toArray();
@endphp
<div class="swiper swiper-quangcao">
    <div class="swiper-wrapper">
        @foreach ($quangcao as $item)
            @php
                $name = $item->{"ten$lang"} ?? '';
                $desc = $item->{"mota$lang"} ?? '';
                $photoUrl = $item->photo ?? '';
                $photo = Thumb::Crop(UPLOAD_PHOTO, $photoUrl ?? '', 1440, 320, 1);
                $url = $item->link ?? '';
            @endphp
            <div class="swiper-slide">
                <div class="relative ">
                    <x-shared.image src="{{ $photo }}" alt="{{ $name }}" class="w-full " />
                    <div class="absolute top-0 right-0 bottom-0 left-0 z-20 flex items-center">
                        <div class="container">
                            <div class="font-title text-lg md:text-3xl xl:text-5xl text-white uppercase">{{ $name }}</div>
                            <x-shared.readmore title="Liên hệ" class="hidden mt-8 xl:inline-flex" href="{{ $url }}" ></x-shared.readmore>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@push('js_page')
<script>
	$(document).ready(function(){
		var swiper_quangcao = new Swiper(".swiper-quangcao", {
			loop: true,
			autoplay: JS_AUTOPLAY && {
				delay: 5000,
			},
		});
	});
</script>
@endpush