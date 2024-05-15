<!DOCTYPE html>
<html>
<head>
	<!-- UTF-8 -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  	<style>
		body{overflow: hidden;}
		.bg-inform{background: url({{asset('img/mail/inform.png')}}) no-repeat bottom center;height: 100vh;/*display: flex; justify-content: center;*/}
		.bg-inform-title{width: 100%; min-height: 0px; /*border-radius: 20px; */border: 2px dashed rgba(38, 185, 154, 0.5); text-align: center;/*display: flex; justify-content: center; align-items: center;*/background: #fff;}
		.bg-inform-title span{background: rgba(38, 185, 154, 0.3); color: #26b99a;font-weight: bold;font-size: 22px;padding: 15px 10px;display: block;}
	</style>
</head>
<body>
	<div class="bg-inform">
		<div class="bg-inform-title"><span>
			{{-- {{$text}} --}}
		</span></div>
	</div>
</body>
</html>

<!-- Js Config -->
<script>
	var CONFIG_ALL = @json(config('config_all'));
	var CONFIG_BASE = CONFIG_ALL.config_all_url;
</script>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script>
	$(document).ready(function(){
		setTimeout(function(){ 
			window.location = CONFIG_BASE + "";
		}, 3000);
	});
</script>
