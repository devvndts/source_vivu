<div id="localtion-modal" class="localtion-modal">
    <div class="location-layout">
        <div class="location-box">
            <div class="location-header">
                <p class="location-title"><i class="fas fa-chevron-left mr-2"></i> CHỌN <span id="location-header-title"></span></p>
                <span class="location-close"><i class="fal fa-times"></i></span>
            </div>
            <div class="location-body"></div>
        </div>
    </div>
</div>

@push('js_page')
	<script>
		/*$('.select-city-delivery').click(function(){
			$('.localtion-modal').addClass('location-modal-active');
		});*/

		$('.location-close').click(function(){
			$('.localtion-modal').removeClass('location-modal-active');
		});

		$(".localtion-modal").click(function(event) {
			if(event.target.id=="localtion-modal"){
				$(this).removeClass('location-modal-active');
			}
		});
	</script>
@endpush