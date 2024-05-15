<form method="post" action="" enctype="multipart/form-data">
    <div class="wrap-cart">
        @if(count($row_cart)>0)
        <div class="top-cart">
            <div class="top-cart-top">
                @for($i=0;$i<count($row_cart);$i++)
                    @php
                    $pid = $row_cart[$i]['id_product'];
                    $quantity = $row_cart[$i]['soluong'];
                    $mau = ($row_cart[$i]['mau'])?$row_cart[$i]['mau']:0;
                    $size = ($row_cart[$i]['size'])?$row_cart[$i]['size']:0;
                    $code = ($row_cart[$i]['code'])?$row_cart[$i]['code']:"";
                    $km = ($row_cart[$i]['km'])?$row_cart[$i]['km']:"";
                    $proinfo = CartHelper::get_product_info($pid,$size,$mau);
                    
                    $pro_price = $proinfo['gia'];
                    $pro_price_new = $proinfo['giamoi'];
                    $pro_price_qty = $pro_price*$quantity;
                    $pro_price_new_qty = $pro_price_new*$quantity;
                    @endphp
                    <div class="procart procart-{{$code}} flex items-start justify-between">
                        <div class="pic-procart">
                            <a class="text-decoration-none" href="{{$proinfo['tenkhongdauvi']}}" target="_blank" title="{{$proinfo['ten'.$lang]}}"><img src="{{ (isset($proinfo['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$proinfo['photo'],85,0,1,$proinfo['type']):'' }}" alt="{{$proinfo['tenkhongdau'.$lang]}}" onerror=src="{{Thumb::Crop('img/','noimage.png',85,0,1)}}" /></a>                            
                        </div>
                        <div class="info-procart">
                            <h3 class="name-procart"><a class="text-decoration-none" href="{{$proinfo['tenkhongdauvi']}}" target="_blank" title="{{$proinfo['ten'.$lang]}}">{{$proinfo['ten'.$lang]}}</a></h3>
                            <div class="properties-procart">
                                @if($mau)
                                    @php
                                        $maudetail = CartHelper::get_mau_info($mau);
                                    @endphp
                                    <p class="change-prop-btn change-prop-btn-css" data-code="{{$code}}"><strong>{{$maudetail['ten'.$lang]}} <i class="fal fa-chevron-down"></i></strong></p>
                                @endif
                                @if($size) 
                                    @php
                                        $sizedetail = CartHelper::get_size_info($size);
                                    @endphp 
                                    <p class="change-prop-btn change-prop-btn-css" data-code="{{$code}}"><strong>{{$sizedetail['ten'.$lang]}} <i class="fal fa-chevron-down"></i></strong></p>
                                @endif
                                <a class="del-procart text-decoration-none" data-code="{{$code}}">x</a>
                                <div class="price-procart">
                                    @if($proinfo['giamoi'])
                                        <p class="price-new-cart load-price-new-{{$code}}">
                                            {{Helper::Format_Money($pro_price_new_qty)}}
                                        </p>

                                        @if($proinfo['giamoi']<$proinfo['gia'])
                                        <p class="price-old-cart load-price-{{$code}}">
                                            {{Helper::Format_Money($pro_price_qty)}}
                                        </p>
                                        @endif
                                    @else
                                        <p class="price-new-cart load-price-{{$code}}">
                                            {{Helper::Format_Money($pro_price_qty)}}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="price-procart hide-price">
                                @if($proinfo['giamoi'])
                                    <p class="price-new-cart load-price-new-{{$code}}">
                                        {{Helper::Format_Money($pro_price_new_qty)}}
                                    </p>

                                    @if($proinfo['giamoi']<$proinfo['gia'])
                                    <p class="price-old-cart load-price-{{$code}}">
                                        {{Helper::Format_Money($pro_price_qty)}}
                                    </p>
                                    @endif
                                @else
                                    <p class="price-new-cart">
                                        Giá: <b class="load-price-{{$code}}">{{Helper::Format_Money($pro_price_qty)}}</b>
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="quantity-procart">                            
                            <div class="quantity-counter-procart quantity-counter-procart-{{$code}} flex items-stretch justify-between">
                                <span class="counter-procart-minus counter-procart">-</span>
                                <input type="number" class="quantity-procat" min="1" value="{{$quantity}}" data-pid="{{$pid}}" data-code="{{$code}}"/>
                                <span class="counter-procart-plus counter-procart">+</span>
                            </div>
                            <div class="pic-procart pic-procart-rp">
                                <a class="text-decoration-none" href="{{$proinfo['tenkhongdauvi']}}" target="_blank" title="{{$proinfo['ten'.$lang]}}"><img src="{{ (isset($proinfo['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$proinfo['photo'],85,0,1,$proinfo['type']):'' }}" alt="{{$proinfo['tenkhongdau'.$lang]}}" onerror=src="{{Thumb::Crop('img/','noimage.png',85,0,1)}}" /></a>
                                <a class="del-procart text-decoration-none" data-code="{{$code}}">
                                    <i class="fa fa-times-circle"></i>
                                </a>                        
                            </div>
                        </div>                              
                    </div>
                @endfor
            </div>
            <div class="top-cart-bot">
                <div class="money-procart">
                    @if(config('config_all.order.ship')==true)
                    <div class="flex items-center justify-between total-procart">
                        <p>Tổng thanh toán:</p>
                        <p class="total-price load-price-temp">{{Helper::Format_Money(CartHelper::get_order_total($id_login,$token_member_cart))}}</p>
                    </div>
                    @endif
                </div>            
                <div class="modal-footer">
                    <a class="block btn-cart btn btn-danger btn-cart-buy" href="gio-hang" title="{{thanhtoan}}">{{thanhtoan}} <i class="far fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
        @else
            <a href="" class="empty-cart text-decoration-none">
                <i class="fal fa-shopping-cart"></i>
                <p>{{khongtontaisanphamtronggiohang}}</p>
                <span>{{vetrangchu}}</span>
            </a>
        @endif
    </div>
</form>