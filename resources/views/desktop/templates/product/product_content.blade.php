@php
    // $currentSlug = Route::current()->parameters['slug'];
    // $currentURL = url($currentSlug);
    // $qaData = get_posts('q_a', 'vi', ['query' => ['id_product' => $row_detail['id']], 'order_by' => ['stt' => 'asc']]);
@endphp
{{-- <ul id="scrollspy1"
    class="flex items-center justify-center py-4 mt-16 bg-white border product-detail-nav sticky-top border-x-0 border-primary border-opacity-20">
    <a href="#example-1"
        class="block text-base border-transparent cursor-pointer lp-title border-y current-active current-active:border-b-black">{{ __('site.product_detail') }}</a>
    <a href="#example-2"
        class="block text-base border-transparent cursor-pointer ml-7 lp-title border-y current-active:border-b-black">{{ __('site.product_guide') }}</a> --}}
{{-- <a href="#example-3"
        class="block text-base border-transparent cursor-pointer ml-7 lp-title border-y current-active:border-b-black">Thành
        phần</a>
    <a href="#example-4"
        class="block text-base border-transparent cursor-pointer ml-7 lp-title border-y current-active:border-b-black">Hỏi
        đáp</a>
    <a href="#example-5"
        class="block text-base border-transparent cursor-pointer ml-7 lp-title border-y current-active:border-b-black">Đánh
        giá</a> --}}
{{-- </ul> --}}
{{-- <div class="accordion accordion-flush" id="accordionFlushExample">
    <div id="example-1" class="pt-6 content-main">{!! $row_detail['noidung' . $lang] !!}</div>
    <div class="h-[1px] bg-primary bg-opacity-20 my-4"></div>
    <div>
        <div class="flex items-center justify-between cursor-pointer" id="example-2" data-bs-toggle="collapse" data-bs-target="#collapseHuongdan" aria-expanded="false"
        aria-controls="collapseHuongdan">
            <span class="flex-1 text-2xl text-black">{{ __('site.product_guide') }}</span>
            <span 
                class="flex-shrink-0 text-xl font-bold cursor-pointer text-primary">+</span>
        </div>
        <div class="border-0 accordion-collapse collapse " id="collapseHuongdan">
            <div class="pt-6 content-main">{!! $row_detail['huongdan' . $lang] ?? '' !!}</div>
        </div>
    </div>

    <div class="h-[1px] bg-primary bg-opacity-20 my-4"></div>
    <div>
        <div class="flex items-center justify-between cursor-pointer" id="example-3" data-bs-toggle="collapse" data-bs-target="#collapseThanhphan" aria-expanded="false"
        aria-controls="collapseThanhphan">
            <span class="flex-1 text-2xl text-black">Thành phần</span>
            <span 
                class="flex-shrink-0 text-xl font-bold cursor-pointer text-primary">+</span>
        </div>
        <div class="border-0 accordion-collapse collapse " id="collapseThanhphan">
            <div class="pt-6 content-main">{!! $row_detail['thanhphan' . $lang] ?? '' !!}</div>
        </div>
    </div> --}}

{{-- 

    <div class="h-[1px] bg-primary bg-opacity-20 my-4"></div>
    <div>
        <div class="flex items-center justify-between" id="example-4">
            <span class="flex-1 text-2xl text-black">Hỏi đáp</span>
        </div>
        <div class="">
            <div class="mt-4 accordion accordion-flush" id="accordionFlushExample">
                @foreach ($qaData as $key => $item)
                    @php
                        $idenHeading = 'flush-heading' . $key;
                        $idenCollapse = 'flush-collapse' . $key;
                        $name = $item->tenvi;
                        $desc = nl2br($item->motavi);
                        $isShowClass = $key == 0 ? 'show' : '';
                        $isCollapsedClass = $key == 0 ? '' : 'collapsed';
                    @endphp
                    <div class="bg-white border border-l-0 border-r-0 border-gray-200 rounded-none accordion-item">
                        <h2 class="mb-0 accordion-header" id="{{ $idenHeading }}">
                            <button
                                class="relative flex items-center w-full px-5 py-4 text-base text-left bg-[#FFF5F2] text-gray-800 transition border-0 rounded-none accordion-button {{ $isCollapsedClass }} focus:outline-none"
                                type="button" data-bs-toggle="collapse" data-bs-target="#{{ $idenCollapse }}"
                                aria-expanded="false" aria-controls="{{ $idenCollapse }}">
                                {{ $name }}
                            </button>
                        </h2>
                        <div id="{{ $idenCollapse }}" class="border-0 accordion-collapse collapse {{ $isShowClass }} "
                            aria-labelledby="{{ $idenHeading }}" data-bs-parent="#accordionFlushExample">
                            <div class="px-5 py-4 accordion-body">{!! $desc !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="h-[1px] bg-primary bg-opacity-20 my-4"></div>
    <!--ĐÁNH GIÁ-->
    @include('desktop.layouts.danhgia') --}}
{{-- </div> --}}
{{-- <div class="accordion accordion-flush" id="accordionFlushExample">
    @php
        $title = __("Thành phần");
        $target = "collapseThanhphan";
        $content = $row_detail['thanhphan' . $lang];
    @endphp
    <x-shared.collapse title="{{ $title }}" target="{{ $target }}">
        {!! $content !!}
    </x-shared.collapse>

    @php
        $title = __("Giá trị dinh dưỡng");
        $target = "collapseNoidung";
        $content = $row_detail['noidung' . $lang];
    @endphp
    <x-shared.collapse title="{{ $title }}" target="{{ $target }}">
        {!! $content !!}
    </x-shared.collapse>

    @php
        $title = __("Chất gây dị ứng");
        $target = "collapseHuongdan";
        $content = $row_detail['huongdan' . $lang];
    @endphp
    <x-shared.collapse title="{{ $title }}" target="{{ $target }}">
        {!! $content !!}
    </x-shared.collapse>
</div> --}}
{{-- <x-shared.content>
    {!! $row_detail['noidung' . $lang] !!}
</x-shared.content> --}}
{{-- @php
    $cta = get_photos('cta', 'vi', ['order_by' => ['stt' => 'asc']])->toArray();
    $ctaLink = ($row_detail["cta_link"]) ? unserialize($row_detail["cta_link"]) : null;
@endphp
<div class="flex flex-wrap my-2 mt-5 align-baseline">
    @if ($cta && $ctaLink)
        @foreach ($cta as $item)
            @if ($ctaLink[$item->id])
                @php
                    $url = htmlspecialchars_decode($ctaLink[$item->id]);
                    $img = Thumb::Crop(UPLOAD_PHOTO,$item->photo,25,25,2);
                @endphp
                <a href="{{ $url }}" target="_blank" class="inline-block mr-4">
                    <x-shared.image src="{{ $img }}" />
                </a>
            @endif
            
        @endforeach
    @endif
</div> --}}
<x-tabnav.index class="[&]:flex-row w-full justify-start">
    <x-tabnav.item active tabId="thongtinchitiet" parentClass="[&]:flex-none" class="[&]:text-base [.active&]:!text-primary [.active&]:!border-primary">
        Thông tin chi tiết
    </x-tabnav.item>
    {{-- <x-tabnav.item tabId="thongso" parentClass="[&]:flex-none" class="[&]:text-base">
        Thông số kỹ thuật
    </x-tabnav.item>
    <x-tabnav.item tabId="tailieu" parentClass="[&]:flex-none" class="[&]:text-base">
        Tài liệu
    </x-tabnav.item> --}}
</x-tabnav.index>
<x-tabpane.index>
    <x-tabpane.item active tabId="thongtinchitiet">
        <x-shared.content>
            {!! $row_detail['noidung' . $lang] !!}
        </x-shared.content>
    </x-tabpane.item>
    {{-- <x-tabpane.item tabId="thongso">
        @php
            if ($row_detail['attribute']) {
                $attrThongso = json_decode($row_detail['attribute'], true);
                if (is_array($attrThongso)) {
                    $thongso = $attrThongso['thongso'];
                    $tailieu = $attrThongso['tailieu'];
                }
            }
        @endphp
        @if (isset($thongso) && !empty($thongso))
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <table class="">
                                <tbody>
                                    @foreach ($thongso as $item)
                                    @php
                                        $name = $item["tenvi"] ?? '';
                                        $desc = $item["noidungvi"] ?? '';
                                    @endphp
                                    <tr class="border-b">
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $name }} </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $desc }} </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </x-tabpane.item>
    <x-tabpane.item tabId="tailieu">
        @if (isset($tailieu) && !empty($tailieu))
            <div class="flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block py-2 sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                            <table class="">
                                <tbody>
                                    @foreach ($tailieu as $item)
                                    @php
                                        $name = $item["tenvi"] ?? '';
                                        $desc = $item["noidungvi"] ?? '';
                                    @endphp
                                    <tr class="border-b">
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $name }} </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        <a class="btn-primary btn" href="{{ $desc }}" target="_blank">Download</a>    
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </x-tabpane.item> --}}
</x-tabpane.index>
<!--js thêm cho mỗi trang-->
@push('js_page')
    <script>
        $(document).ready(function() {
            // $('.lp-title').click(function(event) {
            //     event.preventDefault();
            //     let _target = $(this).attr('href');
            //     $(this).addClass('current-active').siblings().removeClass('current-active');
            //     $('html,body').animate({
            //         scrollTop: $(_target).offset().top - 94
            //     }, 'slow');
            // });
        });
    </script>
@endpush
