<div class="product__grid product__grid--4 pd-10 ">
    @foreach($items as $k=>$v)
        <div class="product-items">
            <div class="product-items__image">
                <a href="{{$v['tenkhongdau'.$lang]}}" class="himg aspect-ratio aspect-ratio--1-1">
                    <img src="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],300,0,1,$v['type']):'' }}" alt="{{$v['tenkhongdau'.$lang]}}" onerror=src="{{Thumb::Crop('img/','noimage.png',300,0,1)}}" />
                </a>
                <button type="button" class="d-flex justify-content-center align-items-center product-items__button product-items__cart" data-fancybox="" data-type="ajax" data-src="ajax/QuickViewProduct.php?code={{md5($v['id'])}}"><svg fill="currentColor" width="17" height="17"> <use xlink:href="assets/sprites/light.svg#shopping-bag"></use> </svg></button>
                <button type="button" class="d-flex justify-content-center align-items-center product-items__button product-items__favourite js-add-wishlist" data-id="406"><svg fill="currentColor" width="18" height="18"> <use xlink:href="assets/sprites/light.svg#star"></use> </svg></button>
                <button type="button" class="d-flex justify-content-center align-items-center product-items__button product-items__quickview js-quick-view" data-fancybox="" data-type="ajax" data-src="ajax/QuickViewProduct.php?code={{md5($v['id'])}}"><svg fill="currentColor" width="17" height="17"> <use xlink:href="assets/sprites/light.svg#search"></use> </svg></button>
            </div>
            <div class="product-items__info">
                <a class="product-items__name" href="tui-deo-cheo-dang-hop-dung-minigo-unisex-limited-hoa-van-star-of-david">{{$v['ten'.$lang]}}</a>
                <div class="d-flex justify-content-center align-items-center">
                    @if($v['giakm'] > 0)<div class="product-items__sale">-{{$v['giakm']}}%</div>@endif
                    <div class="d-flex align-items-end">
                        <div class="product-items__price product-items__price--current">
                            {{($v['gia']>0)?Helper::Format_Money($v['gia']):'Giá: Liên hệ'}}
                        </div>
                        @if($v['giacu'] > $v['gia'])
                        <div class="product-items__price product-items__price--old">{{Helper::Format_Money($v['giacu'])}}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="row">
   <div class="col-sm-12 dev-center dev-paginator">{{ $items->links() }}</div>
</div>
