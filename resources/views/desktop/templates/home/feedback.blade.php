@php
$feedback = get_static('text-feedback');
@endphp
<div class="brand-story feedback bg-[#F7FCF0] py-16">
    <div class="container">
        <div class="brand-story-wrap">
            <div class="brand-story__image order-1 !w-full md:!w-[47%]"> 
                <img src="{{ asset(UPLOAD_STATICPOST . $feedback->photo) }}"
                    onerror=src="{{ asset('img/noimage.png') }}" alt="Logo" class="new-bg">
            </div>
            <div class="w-full min-w-0 mb-6 brand-story__info md:mr-12 md:flex-1 md:mb-0">
                <x-title>
                    <x-slot name='title' class="ml-0"> FEEDBACK KHÁCH HÀNG </x-slot>
                </x-title>

                <div class="brand-story__info__content">
                    <p class="text-sm font-light text-center md:text-left line-clamp-5 text-secondary">{{ $feedback->{"mota$lang"} }}</p>
                    <x-button title="{{ __('site.readmore') }}" href="#" class="block mx-auto mt-7 md:ml-0 w-fit">
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