@if ($data['camket'])
<div class="detail-camket">
    <div class="container">
        <x-shared.title class="text-center mt-20">
            <x-slot name="title">{{ __('CAM KẾT SAU ĐÀO TẠO') }}</x-slot>
            <x-slot name="desc">{!! $text_general->{'mota'.$lang} !!}</x-slot>
        </x-shared.title>
        <div class="lg:flex justify-between items-start">
            <div class="lg:w-1/2 relative z-10">
                <div style="background-image: url({{ Thumb::Crop(UPLOAD_PRODUCT, $row_detail['photo3'] ?? '', 630, 470, 1) }})"  class="aspect-w-4 bg-cover bg-no-repeat overflow-hidden aspect-h-3 rounded-md">
                    {{-- <iframe src="https://www.youtube.com/embed/{{ Helper::getYoutube($data['sl_options']['link_youtube_camket'] ?? '') }}"
                        class="absolute inset-0 w-full h-full" allowfullscreen></iframe> --}}
                </div>
            </div>
            <div class="lg:w-[calc(50%_+_60px)] mt-5 relative z-20 lg:-ml-[60px] rounded-xl bg-white shadow-xl md:px-20 py-4 px-4 md:py-8" style="--shadow: 0px 18px 26px rgba(0, 0, 0, 0.05);">
                <div class="">
                    @foreach ($data['camket'] as $item)
                        @php
                            $name = $item["ten$lang"] ?? '';
                            $description = $item["mota$lang"] ?? '';
                            $photoUrl = $item["photo"] ?? '';
                            $photo = Thumb::Crop(UPLOAD_POST, $photoUrl ?? '', 50, 50, 1);
                        @endphp 
                        <div class="flex md:gap-x-8 gap-x-3 items-center justify-between mt-2 md:mt-9 first:mt-0">
                            <x-shared.image src="{{ $photo }}" alt="{{ $name }}" class="md:mt-5 w-10" />
                            <div class="flex-1">
                                <div><strong class="text-base text-black hover:text-primary">{{ $name }}</strong></div>
                                <div class="text-sm line-clamp-2 text-[#404040]">{{ $description }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
{{-- @push('js_page')
    <script>
        $(document).ready(function() {
        });
    </script>
@endpush --}}
@endif