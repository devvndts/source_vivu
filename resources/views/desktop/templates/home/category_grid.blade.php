@php
$thumbValues = [
    ['w'=>516, 'h'=>607],
    ['w'=>360, 'h'=>332],
    ['w'=>360, 'h'=>332],
    ['w'=>730, 'h'=>260],
    ['w'=>1266, 'h'=>260],
];
@endphp
<div class="category-grid-home">
    <div class="container">
        <div class="category-grid">
            @foreach ($categoriesFirst as $key => $item)
            @php
                $ordering = $key+1;
                $name = $item['ten'.$lang];
                $url = $item[$sluglang];
                $img = sprintf('<img src="%s" alt="%s" onerror="src=\'%s\'">', Thumb::Crop(UPLOAD_CATEGORY,$item['photo'],$thumbValues[$key]['w'],$thumbValues[$key]['h'],1,$item['type']), $name, Thumb::Crop('img','noimage.png',$thumbValues[$key]['w'],$thumbValues[$key]['h'],2,$item['type']));
            @endphp
                <div class="gri{{ $ordering }}">
                    <div class="category-grid-item">
                        <figure>{!! $img !!}</figure>
                        <a href="{{ $url }}" class="category-grid-item__info">
                            <h3 class="mb-0 md:mb-[20px]">{{ $name }}</h3>
                            <x-button title="{{ __('site.readmore') }}" class="border-0 md:border p-0 md:px-[10px] md:py-[10px]">
                                <x-slot name="icon"></x-slot>
                            </x-button>
                        </a>
                    </div>
                </div>
            @endforeach
            {{-- <div class="gri1">
                <div class="category-grid-item">
                    <figure><img src="{{ asset('img/gri1.png') }}" alt=""></figure>
                    <a href="" class="category-grid-item__info">
                        <h3 class="mb-0 md:mb-[20px]">vegan vitamin suplement</h3>
                        @php
                            $data = [
                                'title' => '',
                                'class' => 'border-0 md:border p-0 md:px-[10px] md:py-[10px]',
                                'link' => '',
                                'icon' => '',
                            ];
                        @endphp
                        @include('desktop.layouts.button-primary', ['data' => $data])
                    </a>
                </div>
            </div>
            <div class="gri2">
                <div class="category-grid-item">
                    <figure><img src="{{ asset('img/gri2.png') }}" alt=""></figure>
                    <a href="" class="category-grid-item__info">
                        <h3 class="mb-0 md:mb-[20px]">health & wellness</h3>
                        @php
                            $data = [
                                'title' => '',
                                'class' => 'border-0 md:border p-0 md:px-[10px] md:py-[10px]',
                                'link' => '',
                                'icon' => '',
                            ];
                        @endphp
                        @include('desktop.layouts.button-primary', ['data' => $data])
                    </a>
                </div>
            </div>
            <div class="gri3">
                <div class="category-grid-item">
                    <figure><img src="{{ asset('img/gri3.png') }}" alt=""></figure>
                    <a href="" class="category-grid-item__info">
                        <h3 class="mb-0 md:mb-[20px]">vegan sport</h3>
                        @php
                            $data = [
                                'title' => '',
                                'class' => 'border-0 md:border p-0 md:px-[10px] md:py-[10px]',
                                'link' => '',
                                'icon' => '',
                            ];
                        @endphp
                        @include('desktop.layouts.button-primary', ['data' => $data])
                    </a>
                </div>
            </div>
            <div class="gri4">
                <div class="category-grid-item">
                    <figure><img src="{{ asset('img/gri4.png') }}" alt=""></figure>
                    <a href="" class="category-grid-item__info">
                        <h3 class="mb-0 md:mb-[20px]">vegan beauty</h3>
                        @php
                            $data = [
                                'title' => '',
                                'class' => 'border-0 md:border p-0 md:px-[10px] md:py-[10px]',
                                'link' => '',
                                'icon' => '',
                            ];
                        @endphp
                        @include('desktop.layouts.button-primary', ['data' => $data])
                    </a>
                </div>
            </div>
            <div class="gri5">
                <div class="category-grid-item">
                    <figure><img src="{{ asset('img/gri5.png') }}" alt=""></figure>
                    <a href="" class="category-grid-item__info">
                        <h3 class="mb-0 md:mb-[20px]">natural beauty</h3>
                        @php
                            $data = [
                                'title' => '',
                                'class' => 'border-0 md:border p-0 md:px-[10px] md:py-[10px]',
                                'link' => '',
                                'icon' => '',
                            ];
                        @endphp
                        @include('desktop.layouts.button-primary', ['data' => $data])
                    </a>
                </div>
            </div> --}}
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