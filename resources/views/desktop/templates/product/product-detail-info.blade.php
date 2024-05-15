<div class="detail__right ">
    <div class="text-2xl font-bold text-black detail__name">{{ $row_detail['ten' . $lang] }}</div>
    <div class="my-2 text-base font-semibold text-primary detail__properties__masp">
        <span
            class="sku{{ $row_detail['id'] }}">{{ $row_detail['masp'] }}</span>
    </div>
<?php /*
<div class="h-[1px] bg-primary bg-opacity-20 my-4"></div>
    
*/ ?>

<div class="flex justify-between detail__price_contain">
    <div class="flex flex-col items-start detail__price">
        {{-- <div class="inline-flex detail__price--from-to">
            <p class="text-lg font-bold detail__price--from text-primary">
                {{ Helper::Format_Money($pricebetween['giamin']) ?? '' }}</p>
            <span class="px-1 text-lg">-</span>
            <p class="text-lg font-bold detail__price--to text-primary">
                {{ Helper::Format_Money($pricebetween['giamax']) ?? '' }}</p>
        </div> --}}
        @if ($ajaxGiamoi > 0)
            <div class="flex">
                <div class="detail__price--new font-semibold text-2xl text-primary detail__price--new{{$row_detail['id']}}">{{Helper::Format_Money($giamoi)}}</div>	
                <div class="ml-5 leading-6 text-base text-white py-[2px] px-[7px] rounded-[3px] bg-primary detail__price--km detail__price--km{{$row_detail['id']}} {{($giakm>0) ? '': 'hidden'}}">-{{$giakm}}%</div>
            </div>
            <div class="detail__price--old font-semibold text-base mt-3 text-black text-opacity-50 line-through detail__price--old{{$row_detail['id']}}">{{Helper::Format_Money($gia)}}</div>
        @else
            <div class="detail__price--new detail__price--new{{ $row_detail['id'] }}">{{ ($gia > 0) ? Helper::Format_Money($gia) : __('Liên hệ') }}</div>	
        @endif
        {{-- @if ($ajaxGiamoi > 0)
            <div class="flex">
                <div
                    class="detail__price--new font-semibold text-2xl text-primary detail__price--new{{ $row_detail['id'] }}">
                </div>
                <div
                    class="ml-5 leading-6 text-base empty:hidden text-white py-[2px] px-[7px] rounded-[3px] bg-primary detail__price--km detail__price--km{{ $row_detail['id'] }}"></div>
            </div>
            <div
                class="detail__price--old font-semibold text-base mt-3 text-black text-opacity-50 line-through detail__price--old{{ $row_detail['id'] }}">
            </div>
        @else
            <div class="detail__price--new detail__price--new{{ $row_detail['id'] }}">
            </div>
        @endif --}}
    </div>

    {{-- <div class="flex flex-col items-end flex-1 min-w-0 detail__product_rating">
        @if (!$average_score)
            <div class="detail_rating_count">
                @for ($i = 1; $i <= $average_score; $i++)
                    <i class="fas fa-star"></i>
                @endfor
                @for ($i = $average_score + 1; $i <= 5; $i++)
                    <i class="far fa-star"></i>
                @endfor
                <span class="ml-5 text-sm font-semibold text-black text-opacity-50">
                    {{ $average_score }}.0
                    ({{ $info_rating['allrating'] ? $info_rating['allrating'] : 0 }} đánh giá)
                </span>
            </div>
        @endif
        <div class="mt-5 detail_order_count">
            <span
                class="ml-5 text-sm font-semibold text-black text-opacity-50">{{ $count_luotmua + $default_sell }}
                lượt mua</span> <span class="mx-2">|</span>
            <strong class="text-sm font-semibold text-black"
                id="isStock">{{ $row_detail['soluong'] > 0 ? 'Còn hàng' : 'Hết hàng' }}</strong>
        </div>
    </div> --}}
</div>
    

    <div class="h-[1px] bg-primary bg-opacity-20 my-4"></div>
    @if ($row_detail['motangan' . $lang] != '')
        <div class="">
            {{-- <div class="mb-2 text-sm font-semibold">Mô tả ngắn: </div> --}}
            <div class="product_detail_des">{!! nl2br($row_detail['motangan' . $lang]) !!}</div>
        </div>
        <div class="h-[1px] bg-primary bg-opacity-20 my-4"></div>
    @endif

    @if ($mau != '')
        @php
            $masp_colors = $row_detail['masp_color'] != '' ? json_decode($row_detail['masp_color'], true) : null;
        @endphp
        <div class="py-2 detail__properties detail__properties__color">
            <div class="mb-2 detail__properties__name">Màu sắc: <span id="color-current"></span></div>
            <div class="flex flex-wrap">
                @foreach ($mau as $key => $value)
                    @if ($value['loaihienthi'] == 1)
                        <div class="color-pro-detail {{ $key == 0 ? 'current-active active' : '' }} {{ $key == 0 && count($mau) > 1 ? 'ColorfirstOption' : '' }}"
                            data-id="{{ $row_detail['id'] }}"
                            data-masp="{{ $masp_colors[$value['id']] ? $masp_colors[$value['id']] : $row_detail['masp'] }}"
                            title="{{ $value['ten' . $lang] }}">
                            <input class="detail__properties-items js-select-variant"
                                style="background-image: url({{ UPLOAD_COLOR . $value['photo'] }})" type="radio"
                                value="{{ $value['id'] }}" name="color-pro-detail">
                        </div>
                    @else
                        <div class="color-pro-detail {{ $key == 0 ? 'current-active active' : '' }} {{ $key == 0 && count($mau) > 1 ? 'ColorfirstOption' : '' }}"
                            data-id="{{ $row_detail['id'] }}"
                            data-masp="{{ $masp_colors[$value['id']] ? $masp_colors[$value['id']] : $row_detail['masp'] }}"
                            title="{{ $value['ten' . $lang] }}">
                            <input class="detail__properties-items js-select-variant"
                                style="background-color: #{{ $value['mau'] }}" type="radio"
                                value="{{ $value['id'] }}" name="color-pro-detail">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

    @if (isset($size) && count($size) > 0)
        @php
            // dd($size);
            $sizeName = $sl_options['sizeName'] ?? 'Loại';
        @endphp
        <div class="detail__properties detail__properties__size">
            <div class="mb-2 text-sm font-semibold detail__properties__name">{{ $sizeName }}: <span
                    id="size-current"></span></div>
            <div class="flex flex-wrap" id="product_detail_size">
                @foreach ($size as $key => $value)
                    @php
                        $saleGiamoi = $value['giamoi'];
                        $saleGia = $value['gia'];
                        
                        if (isset($sale[0]) && $sale[0]->hienthi && $sale[0]->sale_date > Carbon\Carbon::now()) {
                            $saleGiamoi = $value['sale_giamoi'];
                        }
                        $priceSold = $saleGia > $saleGiamoi && $saleGiamoi > 0 ? $saleGiamoi : $saleGia;
                    @endphp
                    <a class="size-pro-detail cursor-pointer inline-flex flex-col items-center relative border border-[#B78260] current-active:bg-[#FBECD5] bg-opacity-50 border-opacity-50 py-2 px-5 rounded-[3px] text-black text-decoration-none mr-4 mb-2 {{ $key == 0 ? 'SizefirstOption' : '' }}"
                        data-id="{{ $row_detail['id'] }}">
                        <input type="radio" value="{{ $value['id'] }}"
                            class="detail__properties-items js-select-variant !bg-none !outline-0 focus:!outline-offset-0 !shadow-none focus:!shadow-none !bg-transparent text-transparent rounded-none bg-opacity-50 appearance-none border-none border-0 absolute w-full h-full top-0 left-0"
                            name="size-pro-detail">
                        <span
                            class="mb-1 text-sm font-semibold text-black text-opacity-70">{{ $value['ten' . $lang] }}</span>
                        <span class="text-sm font-semibold text-primary">{{ Helper::Format_Money($priceSold) }}</span>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="h-[1px] bg-primary bg-opacity-20 my-4"></div>
    @endif

    <!--nếu sản phẩm ko có size và màu thì lấy phiên bản mẫu-->
    @if (isset($size) && count($size) == 0)
        @php
            $sample_product = $row_detail['has_product_options_sample'];
        @endphp
        <div class="hidden py-3 detail__properties detail__properties__size">
            <div class="flex flex-wrap" id="product_detail_size">
                <a class="mr-1 size-pro-detail text-decoration-none active SizefirstOption"
                    data-id="{{ $row_detail['id'] }}">
                    <input type="radio" value="0" class="detail__properties-items js-select-variant"
                        name="size-pro-detail" checked>
                </a>
            </div>
        </div>
    @endif

    @if ($row_detail['mota' . $lang] != '')
        <div class="my-2 detail__properties__des">
            <div class="product_detail_des product-item-desc">{!! $row_detail['mota' . $lang] !!}</div>
        </div>
    @endif

    {{-- <div class=" hidden detail__button__grid py-2 fix_button_cart mobile_button_cart {{ $is_soluong ? 'btn-cart-grid' : 'btn-cart-hidden' }}"
        id="show_btn_mobile_conhang">
        <button type="button" class="flex items-center justify-center detail__button detail__wishlist js-action-cart"
            data-id="{{ $row_detail['id'] }}" data-action="addnow">
            <span><i class="mr-2 fal fa-shopping-bag"></i> Thêm vào giỏ</span>
        </button>
        <!-- <button type="button" class="flex justify-content-center align-items-center detail__button detail__buynow js-action-cart" data-id="{{$row_detail['id']}}" data-action="buynow">
        <span>Mua ngay</span>				
    </button> -->
    </div> --}}

    @if ($tags)
        <div class="my-3 detail__product_tags">
            <span class="mr-2"><i class="mr-1 fas fa-tags"></i> Từ khóa:</span>
            @if ($tags)
                @foreach ($tags as $k => $v)
                    <a href="tags/{{ $v['tenkhongdau' . $lang] }}">{{ $v['ten' . $lang] }}</a>
                @endforeach
            @endif
        </div>
    @endif

    <a href="{{ url('lien-he') }}" class="inline-block px-4 py-1 text-center text-white bg-black rounded-sm hover:bg-black/60 ">Liên hệ ngay</a>

    <div class="py-0 detail__properties detail__properties_quantity" id="show_soluong_khung ">
        <div class="mb-2 text-sm font-semibold">{{ __('cart.quantity') }}: </div>
        <div class="flex items-center">
            <div class="flex justify-between items-center quantity w-36 lg:w-full border-[#BABABA] border rounded-[3px]">
                <button type="button"
                    class="quantity__button text-[#C4C4C4] hover:text-black text-lg font-extrabold w-8 h-8 inline-flex justify-center items-center quantity__button--minus js-change-quantity"
                    data-action="minus">-</button>
                <input type="text" class="flex-1 buy-btn-quantity border-y-0 text-center border-[#BABABA] min-w-0 h-8"
                    id="quantity" value="1">
                <button type="button"
                    class="quantity__button text-[#C4C4C4] hover:text-black text-lg font-extrabold w-8 h-8 inline-flex justify-center items-center quantity__button--plus js-change-quantity"
                    data-action="plus">+</button>
            </div> 
        </div> 
    </div>

    {{-- <div class="detail__button__grid buy-btn-box py-2 {{ $is_soluong ? 'fix_button_cart btn-cart-grid' : 'btn-cart-hidden' }}"
    id="show_btn_conhang"> --}}
        {{-- <div class="py-0 detail__properties detail__properties_quantity" id="show_soluong_khung ">
            <div class="mb-2 text-sm font-semibold">{{ __('cart.quantity') }}: </div>
            <div class="flex items-center">
                <div class="flex justify-between items-center quantity w-36 lg:w-full border-[#BABABA] border rounded-[3px]">
                    <button type="button"
                        class="quantity__button text-[#C4C4C4] hover:text-black text-lg font-extrabold w-8 h-8 inline-flex justify-center items-center quantity__button--minus js-change-quantity"
                        data-action="minus">-</button>
                    <input type="text" class="flex-1 buy-btn-quantity border-y-0 text-center border-[#BABABA] min-w-0 h-8"
                        id="quantity" value="1">
                    <button type="button"
                        class="quantity__button text-[#C4C4C4] hover:text-black text-lg font-extrabold w-8 h-8 inline-flex justify-center items-center quantity__button--plus js-change-quantity"
                        data-action="plus">+</button>
                </div> 
                <div class="bg-primary w-[1px] h-10 mx-6"></div>
                <div class="flex items-center justify-between flex-1 min-w-0">
                    <img class="flex-shrink-0 w-8" src="{{ asset('img/coupon.png') }}" alt="coupon">
                    <div
                        class="flex-1 min-w-0 py-1 ml-3 px-2 bg-[#FBECD5] bg-opacity-50 border-black border-opacity-30 
                flex items-center rounded-[3px] 
                ">
                        <p class="flex-1 text-sm text-black text-opacity-70">Nhập mã <strong>BHHSD</strong>
                            giảm 10%</p>
                        <span
                            class="cursor-pointer text-sm text-white text-opacity-70 bg-primary 
                    rounded-[3px] px-2 py-1 
                    ">Copy</span>
                    </div>
                </div><div class="bg-primary w-[1px] h-10 mx-6"></div>
                <div class="flex items-center justify-between flex-1 min-w-0">
                    <img class="flex-shrink-0 w-8" src="{{ asset('img/coupon.png') }}" alt="coupon">
                    <div
                        class="flex-1 min-w-0 py-1 ml-3 px-2 bg-[#FBECD5] bg-opacity-50 border-black border-opacity-30 
                flex items-center rounded-[3px] 
                ">
                        <p class="flex-1 text-sm text-black text-opacity-70">Nhập mã <strong>BHHSD</strong>
                            giảm 10%</p>
                        <span
                            class="cursor-pointer text-sm text-white text-opacity-70 bg-primary 
                    rounded-[3px] px-2 py-1 
                    ">Copy</span>
                    </div>
                </div>
            </div> 
        </div> --}}
        <div class="flex justify-between mt-4 uppercase lg:mt-7">
            <button type="button"
                class="flex flex-1 justify-center items-center  detail__button detail__buynow js-action-cart bg-gradient-to-r from-primary-300 to-primary rounded-[3px] p-3"
                data-id="{{ $row_detail['id'] }}" data-action="buynow">
                <span class="text-lg font-extrabold text-white">{{ __('cart.buy_now') }}</span>
            </button>
            <button type="button"
                class="flex border border-primary rounded-[3px] ml-4 flex-1 items-center justify-center detail__button detail__wishlist js-action-cart py-3"
                data-id="{{ $row_detail['id'] }}" data-action="addnow">
                <span class="text-lg font-extrabold text-primary">{{ __('cart.add_to_cart') }} <i
                        class="ml-2 fal fa-shopping-bag"></i></span>
            </button>
        </div>
        <!-- <div class="flex items-center mt-5 buy-at">
            <div class="mr-4 text-sm font-semibold">Mua sản phẩm trên:</div>
            <ul class="flex flex-1 min-w-0">
                @foreach ($ketnoi as $key => $item)
                    @php
                        $name = $item->{'ten' . $lang};
                        $url = $item->link;
                        $img = sprintf('<img class="max-h-8" src="%s" alt="%s" onerror="src=\'%s\'">', Thumb::Crop(UPLOAD_PHOTO, $item->photo, 60, 30, 2, $item->type), $name, asset('img/noimage.png'));
                    @endphp
                    <li class="inline-flex items-center justify-center w-16 h-8 ml-4 border rounded-md border-primary">
                        <a href="{{ $url }}"> {!! $img !!} </a>
                    </li>
                @endforeach
            </ul>
        </div>  -->
    {{-- </div> --}}
    {{-- <div class="my-3 detail__product_shop">
    <i class="far fa-map-marker-question"></i> Tìm cửa hàng
    </div> --}}
</div>
