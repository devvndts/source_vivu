@extends('desktop.master')

@section('element_detail','product_detail_content')

@section('content')
@if(isset($background_category))
    @section('background_category')
        <div class="category_bg_photo himg" style="background:url('{{ Thumb::Crop(UPLOAD_PHOTO,$background_category['photo'],1440,255,1)}}') no-repeat center center; background-size: cover;">
            <div class="center-layout"><h2 class="category-detail-title"><span>Tra cứu đơn hàng</span></h2></div>
        </div>
    @endsection
@endif

<div class="max-w-3xl pt-5 pb-5 mx-auto check-cart-contain display-relative">
    <div class="cart-check-tabs">
        <a class="cart-check-item cart-check-active" data-tinhtrang="1">Đơn mới</a>
        <a class="cart-check-item" data-tinhtrang="2">Đơn đã nhận</a>
        <a class="cart-check-item" data-tinhtrang="5">Đơn đã hủy</a>
    </div>

    <div class="cart-check-phone">
        <div class="cart-phone-bottom"><i class="mr-2 far fa-hand-point-right" style="font-size: 22px;"></i> Tìm kiếm đơn hàng theo số điện thoại</div>
        <div class="cart-phone-top">
            <form method="GET">
                <input type="text" class="cart-phone-number" id="cart-phone-number" name="phonenumber" placeholder="Số điện thoại đặt hàng" value="{{$phonenumber}}">
                <button type="submit" class="w-10 cart-phone-search shrink-0"><img src="img/icon search.png" alt="" class="mx-auto"></button>
            </form>
        </div>
    </div>

    @if($order)
        <div class="cart-check-list">
            <table class="table m-0 table-hover text-nowrap">
                <thead>
                    <tr>
                        <th><i class="fas fa-code"></i> Mã đơn hàng</th>
                        <th class="text-center"><i class="far fa-calendar-minus"></i> Ngày đặt</th>
                        <th class="text-center"><i class="fas fa-dollar-sign"></i> Tổng giá</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order as $k=>$v)
                    @php
                        $details = $v['has_order_detail_all'];
                        $clsNone = ($k > 0) ? 'd-none' : '';
                    @endphp
                    <tr class="check-cart-item check-cart-item-{{$k}} check-cart-tinhtrang-{{$v['tinhtrang']}} d-none" data-id="{{$v['tinhtrang']}}">
                        <td>
                            <div class="text-info"><b>{{$v['madonhang']}}</b></div>
                        </td>
                        <td class="text-center"><div>{{date('h:m', $v['ngaytao'])}}</div>{{date('d-m-Y', $v['ngaytao'])}}</td>
                        <td class="text-center"><span class="text-danger font-weight-bold">{{ number_format($v['tonggia'],0,',','.') }}đ</span></td>
                    </tr>
                    <tr class="check-cart-detail check-cart-detail-{{$v['tinhtrang']}} {{$clsNone}}">
                        @if($details)
                        <td colspan="3">
                            <div class="check-cart-products">
                                <p class="check-cart-products-title">Chi tiết đơn hàng</p>
                                @foreach($details as $od=>$detail)
                                    <div class="check-cart-product">                                        
                                        <div class="check-cart-product-info">
                                            <div class="check-cart-product-img">
                                                <a class="text-decoration-none" title="{{$detail['ten']}}">
                                                    <img src="{{ Thumb::Crop(UPLOAD_PRODUCT,$detail['photo'],300,0,1) }}" alt="{{$detail['ten']}}"/>
                                                </a>
                                            </div>
                                            <div class="ml-2">
                                                <h3 class="check-cart-product-name"><a class="text-decoration-none">{{$detail['ten']}}</a></h3>
                                                <p class="check-cart-product-price">{{ ($detail['giamoi']>0) ? number_format($detail['giamoi'],0,',','.') : number_format($detail['gia'],0,',','.')}}đ</p>
                                                @if($detail['giamoi']>0)<p class="check-cart-product-priceold">{{ number_format($detail['gia'],0,',','.') }}đ</p>@endif
                                            </div>
                                        </div>
                                        <p class="check-cart-product-amount">x<span>{{$detail['soluong']}}</span></p>
                                    </div>
                                @endforeach
                                <div class="check-cart-product-footer"> 
                                    @if($v['voucher_code']!='')                             
                                    <div class="check-cart-product-footer-item">
                                        <p>Mã voucher đã dùng: </p>
                                        <span class="text-info">{{$v['voucher_code']}}</span>
                                    </div>
                                    @endif
                                    <div class="check-cart-product-footer-item">
                                        <p>Tạm tính: </p>
                                        <span style="color: #999;font-style: italic;">{{Helper::Format_Money($v['tamtinh'])}}</span>
                                    </div>
                                    @if($v['phiship']>0)
                                    <div class="check-cart-product-footer-item">
                                        <p>Phí vận chuyển: </p>
                                        <span>{{Helper::Format_Money($v['phiship'])}}</span>
                                    </div>
                                    @endif
                                    @if($v['giamgia']>0)
                                    <div class="check-cart-product-footer-item">
                                        <p>Khuyến mãi: </p>
                                        <span>-{{Helper::Format_Money($v['giamgia'])}}</span>
                                    </div>
                                    @endif
                                    <div class="check-cart-product-footer-item">
                                        <p><strong>Tổng tiền:</strong> </p>
                                        <span><strong>{{Helper::Format_Money($v['tonggia'])}}</strong></span>
                                    </div>
                                    <div class="check-cart-product-footer-item">
                                        <p><strong class="{{($v['status_payments']==1) ? 'text-success' : 'text-danger'}} ">* {{($v['status_payments']==1) ? 'Đơn hàng đã thanh toán' : 'Đơn hàng chưa thanh toán'}}</strong> </p>                                      
                                    </div>
                                </div>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div id="" class="cart-check-show {{(!$order) ? 'cart-check-alert-main' : ''}}">
        @if(!$order)
            <div class="cart-check-alert">
                <img src="img/svg/empty-cart.svg" alt="">
                <p>Đơn hàng của bạn đang trống</p>
                <a href="san-pham">Mua sắm ngay</a>
            </div>
        @endif
    </div>
</div>

<!--CHÍNH SÁCH-->
{{-- 
<div class="home-chinhsach bortop padlr">   

    <div class="px-0 center-layout home-chinhsach-main">

        @php

            $chinhsachs = app('chinhsachs');

        @endphp

        @if($chinhsachs)

            @foreach($chinhsachs as $k=>$v)

                @if($v['noibat']==1)

                <a class="chinhsach_item" target="_blank" href="{{$v['tenkhongdau'.$lang]}}" class="">

                    <img src="{{ Thumb::Crop(UPLOAD_POST,$v['icon'],30,0,1,$v['type']) }}" width="30" height="30">

                    <span>{{$v['ten'.$lang]}}</span>

                </a>

                @endif

            @endforeach

        @endif

    </div>

</div> --}}
@endsection


<!--css thêm cho mỗi trang-->
@push('css_page')

@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')
    <script>
        $(window).on('load', function () {
            var tinhtrang_active = $('.cart-check-active').attr('data-tinhtrang');
            var e_show = $('.check-cart-tinhtrang-'+tinhtrang_active);
            $('.check-cart-detail').addClass('d-none');
            $('.check-cart-detail-'+tinhtrang_active).removeClass('d-none');
            $(e_show).each(function(){
                if($(this).hasClass('d-none')){
                    $(this).removeClass('d-none');
                }
            });
        });


        $('.cart-check-item').click(function(){
            var tinhtrang_active = $(this).attr('data-tinhtrang');
            var e_show = $('.check-cart-tinhtrang-'+tinhtrang_active);

            $('.cart-check-item').removeClass('cart-check-active');
            $(this).addClass('cart-check-active');

            $('.check-cart-item').addClass('d-none');
            $('.check-cart-detail').addClass('d-none');
            $('.check-cart-detail-'+tinhtrang_active).removeClass('d-none');

            $(e_show).each(function(){
                if($(this).hasClass('d-none')){
                    $(this).removeClass('d-none');
                }
            });
        });
        // var e_show = $('.cart-check-active').data('tinhtrang');
        // $('.check-cart-detail-'+e_show).removeClass('d-none');
        // $('.check-cart-item').click(function(){
        //  var pos = $(this).attr('data-id');
        //  var e_detail = $('.check-cart-detail-'+pos);
        //  if(e_detail.hasClass('d-none')){
        //      e_detail.removeClass('d-none');
        //  }else{
        //      e_detail.addClass('d-none');
        //  }
        // });
    </script>
@endpush