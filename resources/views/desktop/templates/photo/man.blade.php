@extends('desktop.master')

@section('content')
@php
@endphp
<div class="container max-w-screen-xl">
	<x-shared.subtitle title="{{ $title_crumb }}" />
	@if ($data->count() > 0)
	<ul>
		@foreach ($data as $item)
			@php
				$img = Thumb::Crop(UPLOAD_PHOTO, $item->photo, 150, 100, 1);
				$name = $item->{"ten$lang"};
				$url = $item->link;
			@endphp
			<li class="flex items-center justify-between p-2 mb-3 border-2 border-primary flex-nowrap">
				<figure class="w-2/12">
					<x-shared.image src="{{ $img }}" />
				</figure>
				<span class="flex-1 min-w-0 ml-2">{{ $name }}</span>
				@if ($url)
				<x-shared.button onclick="window.open('{{ $url }}', '_blank');" title="Download" />
				@endif
			</li>
		@endforeach
	</ul>
	@endif
	
</div>
@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')

@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')

@endpush

@push('strucdata')
	@include('desktop.layouts.strucdata')
@endpush