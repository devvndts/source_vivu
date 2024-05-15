<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
{{-- <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet"> --}}
{{-- <link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet"> --}}
{{-- <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"> --}}
{{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"> --}}
{{-- <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.7/dist/flowbite.min.css" /> --}}
{{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"> --}}
{{-- <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"> --}}
{{-- <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,500;1,500&display=swap" rel="stylesheet"> --}}
{{-- <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;600;700;800&display=swap" rel="stylesheet"> --}}
<!--minify-->
{!! Packer::css([
	'/css/animate.min.css',
	'/css/all.min.css',
	'/plugins/sweetalert2/sweetalert2.min.css',
	'/plugins/slick/slick.css',
	'/plugins/slick/slick-theme.css',
	'/plugins/slick/slick-style.css',
	'/plugins/swiper/swiper-bundle.min.css',
	// '/plugins/mmenu/mmenu.css',
	'/css/menutoggle.css',
	'/plugins/aos/aos.css',
	'/css/jquery.fancybox.min.css',
	'/plugins/ar-contactus/res/css/jquery.contactus.min.css',
	// '/css/bootstrap.min.css',
	//'/css/fonts.css',
	//'/css/style.css',
	//'/css/responsive.css',
	'/css/owl.carousel.min.css',
	'/css/owl.theme.default.min.css',
	'/css/cart.css',
	'css/product_detail.css',
], 'css/minify.css') !!}
<link href="{{ asset('public/css/main.css') }}" rel="stylesheet">
<link href="{{ asset('public/css/tailwind.css') }}" rel="stylesheet">
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>