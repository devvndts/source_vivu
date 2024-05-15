<div class="px-3 pb-2 pt-4" style="width: calc(100% - 10px); max-width: 600px;">
	<h5 class="font-weight-bold mb-3">{{danhsachdiachi}}</h5>
	<div class="js-ouput-address">
		@if(count($user_address))
			@foreach ($user_address as $key => $value)
				<div class="address-items bg-light rounded mb-2">
					<h6 class="{{($value['is_default'] == 1) ? 'bg-warning' : 'bg-secondary'}} d-flex justify-content-between align-items-center text-white rounded m-0 p-2">
						<div class="d-flex align-content-center">
							<i class="fal fa-home mr-1"></i>
							<span>{{$value['tenvi']}}</span>
						</div>
						@if($value['is_default'] == 1)
							<span class="fs-13"><i class="fal fa-map-marker-check"></i> {{diachimacdinh}}</span>
						@endif
					</h6>
					<div class="p-2" id="address_type_{{$value['id']}}">
                        <span class="d-block">{{hotennguoinhan}}: {{$value['hoten']}}</span>
                        <span class="d-block">{{sodienthoai}}: {{$value['dienthoai']}}</span>
                        <span class="d-block">{{diachi}}: {{$value['address']}}, {{Helper::getFullPlace("item", $value['id_ward'])}}, {{Helper::getFullPlace("cat", $value['id_district'])}}, {{Helper::getFullPlace("list", $value['id_city'])}}</span>
					</div>
					<div class="d-flex justify-content-end px-2 pb-2">
						@if($value['is_default'] == 0)
							<button type="button" class="btn btn-sm js-set-default" data-id="{{$value['id']}}">{{datlamdiachimacdinh}}</button>
						@endif
						<button type="button" class="btn btn-sm js-set-address-delivery ml-2" data-id="{{$value['id']}}">{{giaotoidiachinay}}</button>
						<button type="button" class="btn btn-sm ml-2" data-fancybox data-type="ajax" data-src="address/show/{{$value['id']}}" >{{sua}}</button>
					</div>
				</div>
			@endforeach
		@else
			<div class="alert alert-danger">{{banchuacodiachinaoduocluu}}</div>
		@endif
	</div>
	<div class="d-flex justify-content-end">
		<button type="button" class="btn btn-dark" data-fancybox data-type="ajax" data-src="address/show"><i class="fal fa-map-marker-plus"></i> {{themdiachimoi}}</button>
	</div>
</div>


<script>
    $('document').ready(function(){
        $('.js-set-default').click(function(){
            var id = $(this).attr('data-id');
            $.ajax({
                url: 'address/save-default',
                type: 'POST',
                dataType: 'json',
                data: {id:id, _token:$('input[name="_token"]').val()},
                success: function(result){
                    if(result.login){window.location = CONFIG_BASE + "gio-hang";}
                }
            })
        });

        $('.js-set-address-delivery').click(function(){
            var id = $(this).attr('data-id');
            var html = $('#address_type_'+id).html();
            $('#id_address_delivery').val(id);
            $('#show_address_type').html(html);
            $.fancybox.close();
        });
    });
</script>
