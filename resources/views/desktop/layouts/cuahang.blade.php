<div class="product_cuahang_main">
	<div class="product_cuahang_layout">
		<div class="product_cuahang_title">
			<div><i class="far fa-map-marker-question"></i> Tìm cửa hàng</div>
			<span class="product_cuahang_close"><i class="fal fa-times"></i></span>
		</div>
		<div class="product_cuahang_content">
			<div class="product_cuahang_search">
				{!! Helper::get_ajax_places("places", "places", "list", null, '', 'required', 'Chọn tỉnh thành') !!}
				<span id="cuahang_submit_btn">Tìm cửa hàng</span>
			</div>

			<div id="show_cuahang_div"></div>
			<div id="load_cuahang_div" class="mt-3"></div>
		</div>
	</div>
</div>

@push('js_page')
	<script>
		$('#cuahang_submit_btn').click(function(){
			$.ajax({
				url:'{{route('ajax.search.cuahang')}}',
				type: "GET",
				dataType: 'html',
				data: {'id_city':$('#id_city').val()},
				success: function(result){
					if(result) {
						$('#show_cuahang_div').html(result);

						$('.product_cuahang_item').click(function(){
							var id = $(this).attr('data-id');

							$('.product_cuahang_item').removeClass('product_cuahang_item_active');
							$(this).addClass('product_cuahang_item_active');

							$.ajax({
								url:'{{route('ajax.load.cuahang')}}',
								type: "GET",
								dataType: 'html',
								data: {'id':id},
								success: function(result){
									if(result) {
										$('#load_cuahang_div').html(result);										
									}
								},
								complete: function(){}
							});
						});
					}
				},
				complete: function(){}
			});
		});	
	</script>
@endpush