@if($products)
<div class="fix_carousel_owl">
	@php
		$doisizecolor = app('doisizecolor');
		$doisizecolor = ($doisizecolor) ? UPLOAD_PHOTO.$doisizecolor['photo'] : '';
	@endphp
	<div class="product_owl_tab owl-carousel owl-theme">
		@foreach($products as $k=>$v)
			@if($k==0 || $k%6==0)<div class="box_product_owl">@endif
			<div class="box-product-item">
				<div class="box-product-img">
					<a href="{{$v['tenkhongdau'.$lang]}}" class="himg aspect-ratio aspect-ratio--1-1" title="{{$v['ten'.$lang]}}">
		                <img class="lazy loaded" data-src="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],387,0,1,$v['type']): app('noimage') }}" data-srcset="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],387,0,1,$v['type']):app('noimage') }} 1024w, {{ (isset($v['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],387,0,1,$v['type']):app('noimage') }} 600w" data-sizes="auto" alt="{{$v['ten'.$lang]}}" sizes="auto" srcset="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],387,0,1,$v['type']):app('noimage') }} 1024w, {{ (isset($v['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],387,0,1,$v['type']):app('noimage') }} 600w" src="{{ (isset($v['photo']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo'],387,0,1,$v['type']):app('noimage') }}" data-was-processed="true" widht="387" height="387">
		                @if($v['photo2'])
		                <img class="box-product-img2 lazy loaded" data-src="{{ (isset($v['photo2']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo2'],387,0,1,$v['type']):app('noimage') }}" data-srcset="{{ (isset($v['photo2']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo2'],387,0,1,$v['type']):app('noimage') }} 1024w, {{ (isset($v['photo2']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo2'],387,0,1,$v['type']):app('noimage') }} 600w" data-sizes="auto" alt="{{$v['ten'.$lang]}}" sizes="auto" srcset="{{ (isset($v['photo2']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo2'],387,0,1,$v['type']):app('noimage') }} 1024w, {{ (isset($v['photo2']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo2'],387,0,1,$v['type']):app('noimage') }} 600w" src="{{ (isset($v['photo2']))?Thumb::Crop(UPLOAD_PRODUCT,$v['photo2'],387,0,1,$v['type']):app('noimage') }}" data-was-processed="true" widht="387" height="387">
		                @endif
		            </a>

		            @if($v['id_mau']!='' || $v['id_size']!='')<div class="box-product-btncart //btn-buy-cart change-prop-btn" data-code="" data-id="{{$v['id']}}" data-action="addnow"><p><span></span>Thêm vào giỏ hàng</p></div>@endif

		            @if($v['giakm']>0)
			            <div class="box-product-sale">
			            	<span>Sale up to</span>
			            	<div class="box-product-number">{{$v['giakm']}}<div class="box-product-char"><span>0</span><span>0</span><span>OFF</span></div></div>
			            </div>
		            @endif
		            
		            <div class="box-product-sizecolor">
		            	@if($v['id_mau']!='')
		            	<div class="box-product-color">
		            		@php
		            			$colors = Helper::GetCheckColor($v);
		            		@endphp		            		
		            		@if($colors)
		            			<span>Màu:</span>
			            		<div class="box-product-listcolor">
			            			@foreach($colors as $c=>$color)
			            				<span class="color-btn {{($c==0)?'color-active':''}}" style="background:#{{$color['mau']}}; outline-color:#{{$color['mau']}}" data-idproduct="{{$v['id']}}" data-id="{{$color['id']}}" title="{{$color['ten'.$lang]}}"></span>
			            			@endforeach
			            			<input type="hidden" name="cart-color" value="{{$colors[0]['id']}}">
			            		</div>
			            	@endif
		            	</div>
		            	@endif  

		            	@if($v['id_size']!='')
		            	<div class="box-product-size">
		            		@php
		            			$sizes = Helper::GetCheckSize($v);		            			
		            		@endphp
		            		@if($sizes)
		            			<span>Size:</span>
		            			<div class="box-product-listsize">
		            				<select name="cart-size">
		            					@foreach($sizes as $s=>$size)
		            						<option value="{{$size['id']}}">{{$size['ten'.$lang]}}</option>
		            					@endforeach
		            				</select>
		            			</div>
		            		@endif
		            	</div>
		            	@endif  
		            </div>
	            </div>
	            <div class="box-product-info">	            	
	            	<div class="box-product-detail">
	            		<p class="box-product-category">{{Helper::ShowCategoryName($v['id_category'])}}</p>
	            		<h3 class="box-product-name">{{$v['ten'.$lang]}}</h3>
	            		<p class="box-product-nameshop">{{$setting['ten'.$lang]}}</p>
	            	</div>
	            	<div class="box-product-price">
	            		<p class="box-product-newprice">{{($v['giamoi']>0) ? Helper::Format_Money($v['giamoi']) : (($v['gia']>0) ? Helper::Format_Money($v['gia']) : 'Liên hệ' )}}</p>
	            		<p class="box-product-oldprice">{{($v['giamoi']>0) ? Helper::Format_Money($v['gia']) : ''}}</p>
	            	</div>
	            	@if($doisizecolor)
	            	<p class="box-product-doisize"><img class="" src="{{$doisizecolor}}" alt="doi-size"></p>
	            	@endif
	            </div>
			</div>
			@if(($k+1)%6==0 || ($k+1)>=count($products))</div>@endif
		@endforeach
	</div>
</div>
@endif