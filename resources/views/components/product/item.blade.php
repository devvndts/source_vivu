@props([
    'item' => null,
    'isPriceCenter' => false,
    'isFlashsale' => false
    ])

@php
    // use App\Models\OrderDetail;
    // if (isset($photo_static['logo-flashsale']['photo']) && $photo_static['logo-flashsale']['photo']) {
    //     $logoFlashsaleImg = UPLOAD_PHOTO . $photo_static['logo-flashsale']['photo'];
    // }
    // $order_detail = new OrderDetail();
    
    if (is_array($item)) {
        $id = $item["id"] ?? 0;
        
        $default_sell = $item["sell"] ?? 0;
        $name = $item["ten$lang"] ?? '';
        $summary = $item["mota$lang"] ?? '';
        $url = $item[$sluglang] ?? '';
        $photo = $item["photo"] ?? '';
        $gia = $item["gia"] ?? 0;
        $giamoi = $item["giamoi"] ?? 0;
        $giakm = $item["giakm"] ?? 0;
        $type = $item["type"] ?? '';
        $levelID = $item["ids_level_1"] ?? 0;
        $sl_options = $item["sl_options"] ?? [];
        $sl_options = json_decode($sl_options, true);
    } else {
        $id = $item->id ?? 0;
        $default_sell = $item->sell ?? 0;
        $name = $item->{"ten$lang"} ?? '';
        $summary = $item->{"mota$lang"} ?? '';
        $url = $item->{$sluglang} ?? '';
        $photo = $item->photo ?? '';
        $gia = $item->gia ?? 0;
        $giamoi = $item->giamoi ?? 0;
        $giakm = $item->giakm ?? 0;
        $type = $item->type ?? '';
        $levelID = $item->ids_level_1 ?? 0;
        $sl_options = $item->sl_options ?? [];
        $sl_options = json_decode($sl_options, true);
    }
    // $count_luotmua = $order_detail->where('id_product', $id)->where('hienthi', 1)->count();
    // $categoryPhoto = Helper::ShowCategoryPhoto($levelID);
    $img = $photo ? Thumb::Crop(UPLOAD_PRODUCT, $photo, 400, 300, 1, $type) : '';
    $priceText = '';
    $giaText = Helper::Format_Money($gia, 'đ', true);
    $giamoiText = Helper::Format_Money($giamoi, 'đ', true);
    if ($giamoi > 0) {
        $priceText .= sprintf('<span class="inline-flex items-end mr-2 text-xl font-semibold leading-none text-[#EB5757] md:text-xl">%s</span><span class="inline-flex items-end text-xs text-black text-opacity-40 leading-none line-through pb-[5px]">%s</span>', $giamoiText, $giaText);
    } elseif ($gia > 0) {
        $priceText .= sprintf('<span class="inline-flex items-end mr-2 text-xl font-semibold leading-none text-[#EB5757] md:text-xl">%s</span>', $giaText);
    } else {
        $priceText .= sprintf('<span class="inline-flex items-end mr-2 text-xl font-semibold leading-none text-[#EB5757] md:text-xl">%s</span>', __('Liên hệ'));
    }
@endphp
<div class="group shadow-2xl {{ $attributes->get("class") }} " 
    {{ $attributes }} >
    <div data-aos="zoom-in" class="transition-all duration-300 bg-white rounded-lg">
        <div class="relative ">
            <a href="{{ $url }}" class="relative block overflow-hidden ">
                <x-shared.image class="relative z-10 w-full mx-auto transition duration-300 ease-in-out group-hover:scale-110" src="{{ $img }}" />
                {{-- <div class="absolute overflow-hidden left-0 top-0 transition-all duration-300 w-full group-hover:h-full z-30 bg-black bg-opacity-50 h-0 [&_p]:text-sm [&_p]:text-white  [&_p]:font-medium pl-7 flex flex-col justify-center items-start">
                    {!! $summary !!}
                </div> --}}
            </a>
        </div>
        <div class="p-3">
            {{-- <div class="md:w-[190px] w-full mx-auto h-[17px] rounded-lg flex flex-wrap justify-start bg-[#EB5757] bg-opacity-30 overflow-hidden mb-[6px]">
                <div class="inline-flex px-3 text-xs text-white bg-[#EB5757]">Đã bán {{ $count_luotmua + $default_sell }} sản phẩm</div>
            </div> --}}
            <h3 class="text-xl font-bold ">
                <a class="block text-black font-title group-hover:text-primary" href="{{ $url }}">{{ $name }}</a>
            </h3>
            <div class="line-clamp-2 text-sm mt-2">{!! $summary !!}</div>
            <div class="flex text-sm flex-wrap gap-3 mt-3">
                <div><span>Hình thức học: </span><strong>{{ $sl_options['hinhthuchoc'] ?? '' }}</strong></div>
                <div><span>Thời hạn: </span><strong>{{ $sl_options['thoihan'] ?? '' }}</strong></div>
                <div class="w-full"><span>Khối ngành: </span><strong class="text-red-500">{{ $sl_options['khoinganh'] ?? '' }}</strong></div>
            </div>
            {{-- <div class="flex justify-between">
                <x-shared.readmore class="transition-all [&]:flex-1 [&]:px-1 duration-200 " title="{{ __('Xem thêm') }}" href="{{ $url }}" />
                <x-shared.readmore class="transition-all hidden md:flex [&]:ml-2 [&]:flex-1 [&]:px-1 [&]:bg-white [&]:text-primary hover:[&]:bg-primary hover:[&]:text-white duration-200 " title="{{ __('Liên hệ') }}" href="{{ url('lien-he') }}" />
            </div> --}}
            {{-- <div class="flex flex-wrap {{ ($isPriceCenter) ? 'justify-center' : 'justify-center' }}">
                {!! $priceText !!}
            </div> --}}
            {{-- <div class="mb-4 text-base text-left [&>p]:before:content-[''] [&>p]:before:rounded-full [&>p]:before:w-2 [&>p]:before:h-2 [&>p]:before:block [&>p]:before:absolute [&>p]:pl-4 [&>p]:before:left-0 [&>p]:before:top-2 [&>p]:before:bg-black [&>p]:relative">
                {!! $summary !!}
            </div> --}}
            {{-- <div class="mb-[6px]">
                <i class="text-xs text-yellow-500 fas fa-star"></i>
                <i class="text-xs text-yellow-500 fas fa-star"></i>
                <i class="text-xs text-yellow-500 fas fa-star"></i>
                <i class="text-xs text-yellow-500 fas fa-star"></i>
                <i class="fas text-xs text-[#E0E0E0] fa-star"></i>
            </div> --}}
            {{-- <div class="flex mt-2 flex-nowrap buy-btn-box">
                <input type="number" data-id="{{ $id }}" step="1" min="1" placeholder="1" class="form-control buy-btn-quantity">
                <div class="inline-flex flex-shrink-0 ml-3 cursor-pointer text-xs font-bold items-center px-4 justify-center min-h-[32px] max-w-[188px] text-white rounded-lg flex-nowrap bg-[#30B053] transition-all duration-300 hover:bg-primary-600 js-action-cart" data-id="{{ $id }}" data-action="addnow">
                    {{ __('Thêm vào giỏ hàng') }}
                    <img src="public/images/cart--white.png" class="hidden ml-5 md:inline-block" alt="cart">
                </div>
            </div> --}}
            
            {{-- <div class="flex justify-center">
                <x-shared.readmore class="[&]:py-1 [&]:px-4" href="{{ $url }}" >
                </x-readmore> --}}
                {{-- <x-shared.button onclick="location.href='{{ $url }}'" title="{{ __('Chi tiết') }}"
                class="
                bg-white
                text-secondary
                border-secondary
                hover:bg-secondary
                hover:text-white
                !shadow-none
                border
                "
                /> --}}
            {{-- </div> --}}
        </div>
    </div>
</div>