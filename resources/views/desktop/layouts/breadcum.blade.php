@php
	$excView = [
		'desktop.templates.static.about_ingredient',
		'desktop.templates.static.about',
		'desktop.templates.home',
	];
@endphp
@if(isset($breadcrumbs) && !in_array($view_name, $excView))
<div class="">
	<nav class="py-2 hbreadcrumb " aria-label="breadcrumb">
		<div class="container max-w-screen-xl">
			{!!$breadcrumbs!!}
		</div>
	</nav> 
</div>
@endif
