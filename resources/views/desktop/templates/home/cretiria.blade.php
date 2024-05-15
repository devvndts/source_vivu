@php
$slideCretiria = get_photos('slide-cretiria');
@endphp
<div class="py-20 cretiria-home">
    <div class="container">
        <x-title>
            <x-slot name='title' >ĐẶC QUYỀN MUA SẮM TẠI WEBSITE</x-slot>
            <x-slot name='icon' ></x-slot>
        </x-title>

        <div class="cretiria-items flex flex-wrap lg:mx-[-50px]">
            @foreach ($slideCretiria as $key => $item)
                @php
                    $name = $item->{'ten'.$lang};
                    $img = sprintf('<img src="%s" alt="%s" onerror="src=\'%s\'">', Thumb::Crop(UPLOAD_PHOTO,$item->photo,70,70,2,$item->type), $name, asset('img/noimage.png'));
                @endphp
            <div class="cretiria-item w-[calc(100%/2)] md:w-[calc(100%/4)] px-2 md:px-[25px] mb-5">
                <div>
                    <div class="cretiria-item__image w-[130px] h-[130px] rounded-full flex justify-center items-center mx-auto">
                        <figure class="w-[115px] h-[115px] rounded-full border-white border-[1px] flex justify-center items-center">
                            {!! $img !!}</figure> 
                    </div>    
                    <h6 class="mt-5 text-xl font-bold text-center text-primary">
                        {{ $name }}
                    </h6>

                </div>
            </div>
            @endforeach
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