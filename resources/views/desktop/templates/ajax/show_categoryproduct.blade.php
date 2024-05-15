@if($products)
	<div class="product__grid">
		@foreach($products as $k=>$v)			
			<div class="box-product-item">
				<div class="box-product-img">
					<a href="{{$v['tenkhongdau'.$lang]}}" class="himg aspect-ratio aspect-ratio--1-1" title="{{$v['ten'.$lang]}}">
		                <img class="lazy loaded" src="{{ Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],277,310,2,$v['type'])}}" alt="{{$v['ten'.$lang]}}" width="277" height="310">
		                <span class="box-product-iconnew">
		                	@if($v['noibat'])<img src="img/icon/new.png" alt="icon new" width="50" height="28">@endif
		                	@if($v['muanhieu'])<img src="img/icon/best.png" alt="icon new" width="65" height="37">@endif
		                </span>	
		                <span class="box-product-outstock"><img src="img/icon_outstock.png" alt="outstock"></span>
		            </a>            
		            <div class="box-product-btncart /btn-buy-cart change-prop-btn" data-code="" data-id="{{$v['id']}}" data-action="addnow"><img src="img/icon_cart.png" alt="cart" width="38" height="38"></div>
		            @php
            			$colors = Helper::GetCheckColor($v);
            			$sizes = Helper::GetCheckSize($v);
            			$pricebetween = Helper::GetPriceBetween($v['id']);
            		@endphp	
            		@if($colors)
            			<input type="hidden" name="cart-color" value="{{$colors[0]['id']}}">
	            	@endif
	            	@if($sizes)
            			<input type="hidden" name="cart-size" value="{{$sizes[0]['id']}}">
	            	@endif
	            </div>
	            <div class="box-product-info">
	            	<div class="box-product-detail">
	            		<h3 class="box-product-name"><a href="{{$v['tenkhongdau'.$lang]}}">{{$v['ten'.$lang]}}</a></h3>
	            		<div class="box-product-price">
	            			<p class="box-product-newprice">{{Helper::Format_Money($pricebetween['giamin'])}}</p>
	            			<span>-</span>
	            			<p class="box-product-oldprice">{{Helper::Format_Money($pricebetween['giamax'])}}</p>
	            		</div>
	            		{{--
	            		<div class="box-product-price">
	            			<p class="box-product-newprice">{{($v['giamoi']>0) ? Helper::Format_Money($v['giamoi']) : (($v['gia']>0) ? Helper::Format_Money($v['gia']) : 'Liên hệ' )}}</p>
	            			<p class="box-product-oldprice">{!! ($v['giamoi']>0) ? '<span>-</span>'.Helper::Format_Money($v['gia']) : '' !!}</p>
	            		</div>
	            		--}}
	            	</div>
	            	<div class="box-product-brand">{{$v['belong_to_brand']['ten'.$lang]}}</div>
	            </div>
			</div>
		@endforeach
	</div>	
	<div class="row">
	    <div class="col-sm-12 dev-center dev-paginator">{{ $products->links() }}</div>
	</div>	
@endif
