<p class="product_filter_title">Lọc sản phẩm <span class="product_filter_close"><i class="far fa-times"></i></span></p>
<div class="product_filter_contain">
	<!--DANH MỤC-->
	@if(isset($danhmuc3))
	<div class="product_danhmuc_layout mb-4">
		<p class="product_danhmuc_title"><i class="fas fa-list"></i> Danh mục</p>
		<ul class="product_danhmuc_list">			
			@foreach($danhmuc3 as $k=>$v)
			<li>
				<label class="form-control-600">
				  <input type="checkbox" name="checkbox-category" value="{{$v['tenkhongdau'.$lang]}}" class="checkbox-input" {{(in_array($v['tenkhongdau'.$lang], $categorylist)) ? 'checked' : ''}} >
				  {{$v['ten'.$lang]}}
				</label>
			</li>
			@endforeach			
		</ul>
	</div>
	@endif


	<!--THƯƠNG HIỆU-->
	@if(isset($thuonghieus))
	<div class="product_danhmuc_layout mb-3">
		<p class="product_danhmuc_title"><i class="fas fa-tags"></i> Thương hiệu</p>
		<ul class="product_danhmuc_list">			
			@foreach($thuonghieus as $k=>$v)
			<li>
				<label class="form-control-600">
				  <input type="checkbox" name="checkbox-brand" value="{{$v['tenkhongdau'.$lang]}}" class="checkbox-input" {{(in_array($v['tenkhongdau'.$lang], $brandlist)) ? 'checked' : ''}} >
				  {{$v['ten'.$lang]}}
				</label>
			</li>
			@endforeach			
		</ul>
	</div>
	@endif

	<input type="hidden" name="url_curent_hidden" value="{{url()->current()}}">
</div>

@push('js_page')
	<script>
		$('.checkbox-input').click(function(){
			//### ids category
			var array_category_id = [];
            $("input:checkbox[name=checkbox-category]:checked").each(function() {
                array_category_id.push($(this).val());
            });
            array_category_id = array_category_id.join(",");


            //### ids brand
            var array_brand_id = [];
            $("input:checkbox[name=checkbox-brand]:checked").each(function() {
                array_brand_id.push($(this).val());
            });
            array_brand_id = array_brand_id.join(",");


            //### lấy url
            var url_current = $('input[name="url_curent_hidden"]').val();
            if(array_category_id!=''){
            	url_current += '?&category_query='+array_category_id;
            }
            if(array_brand_id!=''){
            	if(array_category_id==''){
            		url_current += '?';
            	}
            	url_current += '&brand_query='+array_brand_id;
            }

            //console.log(url_current);
            //document.location = url_current;

            //### ajax filter category
            AjaxDataFilter(array_category_id,array_brand_id,url_current);
		});


		$('.product_filter_close, .filter-product-btn').click(function(){
			if($('.product_layout_left').hasClass('product_layout_active')){
				$('.product_layout_left').removeClass('product_layout_active');
			}else{
				$('.product_layout_left').addClass('product_layout_active');
			}
		});


		function AjaxDataFilter(array_category_id,array_brand_id,url_current){
			$.ajax({
				url:"{{route('ajax.category.filter')}}",
				type: "GET",
				dataType: 'html',
				data: {'array_category_id':array_category_id, 'array_brand_id':array_brand_id},
				success: function(result){
					if(result){
						$('#showcategory_products').html(result);
					}
				},
				complete: function(){
					ChangeUrlBrowser(url_current);
				}
			});
		}
	</script>
@endpush