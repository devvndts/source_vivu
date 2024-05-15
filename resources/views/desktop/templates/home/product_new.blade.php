@php
@endphp
<div class="product-new-home">
    <div class="container">
        <x-title class="!mb-0"> 
            <x-slot name="title">các dòng sản phẩm mới của</x-slot>
            <x-slot name="icon"></x-slot>
        </x-title>

        
        <div class="flex flex-wrap product-new-items md:block ">
            @foreach ($productsNew as $key => $item)
            @php
                $ordering = $key+1;
                $name = $item['ten'.$lang];
                $opt = Helper::JsonDecode($item['sl_options']);
                $class = (($key+1) % 2 ==0) ? 'current-even current-even:justify-end' : '';
                $desc = $item['mota'.$lang];
                $url = $opt['link'] ?? '';
                $img = sprintf('<img src="%s" alt="%s" onerror="src=\'%s\'">', Thumb::Crop(UPLOAD_POST,$item['photo'],280,330,2,$item['type']), $name, Thumb::Crop('img','noimage.png',280,330,2,$item['type']));
            @endphp
                <div class="product-new-item basis-1/2 {{ $class }}">
                    <div class="product-new-item__box max-w-[800px]">
                        <div class="product-new-item__image md:p-[10px] flex flex-col items-center">
                            {{-- <img src="{{ asset('img/new-bg.png') }}" class="new-bg ml-[-10px] md:ml-0 mb-[-10px] md:mb-0" alt=""> --}}
                            <img src="{{ asset('img/circle_bg.png') }}" class="relative z-20 block" alt="bg">
                            <img src="{{ asset('img/circle_blur.png') }}" class="relative z-10 block -mt-2" alt="blur">
                            <figure class="max-w-[110px] md:max-w-[280px] absolute z-30 bottom-0">
                                {!! $img !!}
                            </figure>
                        </div>
                        
                        <div class="product-new-item__info md:p-[10px]">
                            @if ($opt["sloganvi"])
                            <div class="text-center md:text-left"><span class="text-[#845536] font-semibold text-sm">{{ $opt["sloganvi"] }}</span></div>
                            @endif
                            <h3 class="text-primary leading-tight text-center md:text-left font-bold text-[16px] md:text-[20px]">{{ $name }}</h3>
                            <p class="text-sm text-center text-secondary md:text-left line-clamp-2">{{ $desc }}</p>
                            <x-button title="{{ __('site.readmore') }}" :href="$url" class="mt-5 mx-auto block w-fit md:inline-block md:w-auto md:ml-0">
                                <x-slot name="icon"></x-slot>
                            </x-button>
                        </div>
                    </div>
                </div> 
            @endforeach
            {{-- <div class="product-new-item basis-1/2">
                <div class="product-new-item__box max-w-[800px]">
                    <div class="product-new-item__image md:p-[10px]">
                        <img src="{{ asset('img/new-bg.png') }}" class="new-bg ml-[-10px] md:ml-0 mb-[-10px] md:mb-0" alt="">
                        <figure class="max-w-[110px] md:max-w-none bottom-0 md:bottom-[30px]"><img src="{{ asset('img/new-item.png') }}" alt=""></figure>
                    </div>
                    
                    <div class="product-new-item__info md:p-[10px]">
                        <div class="text-center md:text-left"><span class="text-[#845536] font-semibold text-sm">Vegan vitamin suplement</span></div>
                        <h3 class="text-primary text-center md:text-left font-bold text-[16px] md:text-[20px]">Morbi consequat morbi amet.</h3>
                        <p class="text-sm text-center text-secondary md:text-left line-clamp-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Eu tempus turpis vitae a consequat euismod.</p>
                        @php
                            $data = [
                                'title' => '',
                                'class' => 'mt-5 mx-auto block w-fit md:inline-block md:w-auto md:ml-0',
                                'link' => '',
                                'icon' => '',
                            ];
                        @endphp
                        @include('desktop.layouts.button-primary', ['data' => $data])
                    </div>
                </div>
            </div> 
            <div class="product-new-item basis-1/2 current-even current-even:justify-end">
                <div class="product-new-item__box max-w-[800px]">
                    <div class="product-new-item__image md:p-[10px]">
                        <img src="{{ asset('img/new-bg.png') }}" class="new-bg ml-[-10px] md:ml-0 mb-[-10px] md:mb-0" alt="">
                        <figure class="max-w-[110px] md:max-w-none bottom-0 md:bottom-[30px]"><img src="{{ asset('img/new-item.png') }}" alt=""></figure>
                    </div>
                    
                    <div class="product-new-item__info md:p-[10px]">
                        <div class="text-center md:text-left"><span class="text-[#845536] font-semibold text-sm">Vegan vitamin suplement</span></div>
                        <h3 class="text-primary text-center md:text-left font-bold text-[16px] md:text-[20px]">Morbi consequat morbi amet.</h3>
                        <p class="text-sm text-center text-secondary md:text-left line-clamp-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Eu tempus turpis vitae a consequat euismod.</p>
                        @php
                            $data = [
                                'title' => '',
                                'class' => 'mt-5 mx-auto block w-fit md:inline-block md:w-auto md:ml-0',
                                'link' => '',
                                'icon' => '',
                            ];
                        @endphp
                        @include('desktop.layouts.button-primary', ['data' => $data])
                    </div>
                </div>
            </div>  
            <div class="product-new-item basis-1/2">
                <div class="product-new-item__box max-w-[800px]">
                    <div class="product-new-item__image md:p-[10px]">
                        <img src="{{ asset('img/new-bg.png') }}" class="new-bg ml-[-10px] md:ml-0 mb-[-10px] md:mb-0" alt="">
                        <figure class="max-w-[110px] md:max-w-none bottom-0 md:bottom-[30px]"><img src="{{ asset('img/new-item.png') }}" alt=""></figure>
                    </div>
                    
                    <div class="product-new-item__info md:p-[10px]">
                        <div class="text-center md:text-left"><span class="text-[#845536] font-semibold text-sm">Vegan vitamin suplement</span></div>
                        <h3 class="text-primary text-center md:text-left font-bold text-[16px] md:text-[20px]">Morbi consequat morbi amet.</h3>
                        <p class="text-sm text-center text-secondary md:text-left line-clamp-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Eu tempus turpis vitae a consequat euismod.</p>
                        @php
                            $data = [
                                'title' => '',
                                'class' => 'mt-5 mx-auto block w-fit md:inline-block md:w-auto md:ml-0',
                                'link' => '',
                                'icon' => '',
                            ];
                        @endphp
                        @include('desktop.layouts.button-primary', ['data' => $data])
                    </div>
                </div>
            </div>    --}}
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