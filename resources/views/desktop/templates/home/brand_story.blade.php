@php
    $name = 'câu chuyện thương hiệu';
    $desc = $textCauChuyen['mota'.$lang];
    $url = 'cau-chuyen-thuong-hieu';
    $img = sprintf('<img src="%s" alt="%s" onerror="src=\'%s\'">', Thumb::Crop(UPLOAD_STATICPOST,$textCauChuyen['photo'],615,485,2,$textCauChuyen['type']), $name, Thumb::Crop('img','noimage.png',615,485,2,$textCauChuyen['type']));
@endphp
<div class="brand-story bg-[#F7FCF0] py-16">
    <div class="container">
        <div class="brand-story-wrap">
            <div class="brand-story__image w-full order-1 mt-[25px] md:mt-0 md:order-none md:w-[48.5%]">
                {!! $img !!}
            </div>
            <div class="w-full min-w-0 brand-story__info md:ml-5 md:flex-1 md:w-auto">
                <x-title > 
                    <x-slot name="title">{{ $name }}</x-slot>
                    <x-slot name="icon"></x-slot>
                </x-title>

                <div class="brand-story__info__content md:pl-20">
                    <p class="text-sm font-light line-clamp-5 text-secondary">{{ $desc }}</p>
                    <x-button title="{{ __('site.readmore') }}" :href="$url" class="mt-7">
                        <x-slot name="icon"></x-slot>
                    </x-button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--js thêm cho mỗi trang-->
@push('js_page')
<script>
	$(document).ready(function(){
	});
</script>
@endpush