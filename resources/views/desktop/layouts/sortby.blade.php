<div class="flex justify-between my-4">
	<div class="flex items-center flex-nowrap">
		<span class="shrink-0 text-[#5D5F5F] text-sm">Sort by - </span>
		<select class="block js_order_by w-full px-4 py-2 ml-2 text-xl font-bold text-[#1D1F1F] transition ease-in-out bg-white bg-no-repeat border-transparent rounded appearance-none form-select form-select-lg bg-clip-padding focus:text-gray-700 focus:bg-white focus:outline-none" aria-label=".form-select-lg example">
			<option {{ (!isset($params['order_by'])) ? 'selected' : '' }} value="">{{ __('Sắp xếp theo') }}</option>
			<option {{ (isset($params['order_by']) && $params['order_by'] === 'gia_caothap') ? 'selected' : '' }} value="gia_caothap">{{ __('Giá từ cao - thấp') }}</option>
			<option {{ (isset($params['order_by']) && $params['order_by'] === 'gia_thapcao') ? 'selected' : '' }}  value="gia_thapcao">{{ __('Giá từ cao thấp - cao') }}</option>
			<option {{ (isset($params['order_by']) && $params['order_by'] === 'tu_az') ? 'selected' : '' }}  value="tu_az">{{ __('Ký tự a-z') }}</option>
			<option {{ (isset($params['order_by']) && $params['order_by'] === 'tu_za') ? 'selected' : '' }}  value="tu_za">{{ __('Ký tự z-a') }}</option>
		</select>
	</div>
	<div class="flex justify-end flex-1 min-w-0 my-4">
		<button class="js_product_view text-neutral-500 [&.active]:text-primary active" data-type="view-grid">
			<i class="fas fa-th-large fa-2x"></i>
		</button>
		<button class="ml-4 js_product_view text-neutral-500 [&.active]:text-primary" data-type="view-list">
			<i class="fas fa-list-ul fa-2x"></i>
		</button>
	</div>
</div>

<!--js thêm cho mỗi trang-->
@push('js_page')
<script>
	$(document).ready(function(){
		$('.js_product_view').click(function() {
			const $viewType = $(this).data('type')
			$('body').removeClass('view-grid').removeClass('view-list')	
			$('body').addClass($viewType)	
			$('.js_product_view').removeClass('active')	
			$(this).addClass('active')	
		})
		$('.js_order_by').change(function() {
			const $orderBy = $(this).val()
			var pathname = window.location.pathname;
			if ($orderBy) {
				let params = [""];
				let searchParams = new URLSearchParams(window.location.search); // ?filter_status=active

				let link = "";
				$.each(params, function (key, param) {
					// filter_status
					if (searchParams.has(param)) {
						link += param + "=" + searchParams.get(param) + "&"; // filter_status=active
					}
				});

				window.location.href =
						pathname +
						"?" +
						link +
						"order_by=" +
						$orderBy;
			} else {
				window.location.href = pathname
			}
			
		})
	})
</script>
@endpush