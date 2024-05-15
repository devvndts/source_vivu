@if($products)
	<x-product.index>
		@foreach ($products as $item)
			<x-product.item :item="$item"></x-product.item>	
		@endforeach
	</x-product.index>
@endif