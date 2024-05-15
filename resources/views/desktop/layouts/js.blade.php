
<input type="hidden" name="no_keywords" value="{{ __('Chưa nhập từ khóa tìm kiếm') }}" />
<input type="hidden" name="delete_product_from_cart" value="{{ __('Bạn muốn xóa sản phẩm này?') }}" />
<input type="hidden" name="no_products_in_cart" value="{{ __('Không tồn tại sản phảm trong giỏ hàng') }}" />
<input type="hidden" name="back_to_home" value="{{ __('Về trang chủ') }}" />
<input type="hidden" name="da_them_san_pham_vao_gio_hang" value="{{ __('Đã thêm sản phảm vào giỏ hàng') }}" />
<input type="hidden" name="wards" value="{{ __('Phường xã') }}" />
<input type="hidden" name="dahieu" value="{{ __('Đã hiểu') }}" />
<!-- Js Config -->
<script>
    var MIKOTECH = MIKOTECH || {};
    var CONFIG_ALL = @json($config_all);
    var CONFIG_BASE = CONFIG_ALL.config_base;
    var JS_AUTOPLAY = {{ $_SERVER['SERVER_NAME'] != 'localhost' ? 'true' : 'false' }};
    var WEBSITE_NAME = '{{ isset($setting['tenvi']) && $setting['tenvi'] ? $setting['tenvi'] : '' }}';
    var SHIP_CART = CONFIG_ALL.order.ship;
    var GOTOP = '{{ asset('img/top.png') }}';
    var LANG = '{{ $lang }}';
    var LANG_KEY = {
        'no_keywords': $('input[name="no_keywords"]').val(),
        'delete_product_from_cart': $('input[name="delete_product_from_cart"]').val(),
        'no_products_in_cart': $('input[name="no_products_in_cart"]').val(),
        'back_to_home': $('input[name="back_to_home"]').val(),
        'da_them_san_pham_vao_gio_hang': $('input[name="da_them_san_pham_vao_gio_hang"]').val(),
        'wards': $('input[name="wards"]').val(),
        'dahieu': $('input[name="dahieu"]').val(),
    };
    var SITE_KEY_GOOGLE = @json(config('recapcha.site_key_google'));
    var NOT_FOUND_IMAGE = '{{ asset('img/noimage.png') }}';
</script>

<!--minify-->
{!! Packer::js(
    [
        '/plugins/sweetalert2/sweetalert2.all.min.js',
        '/plugins/slick/slick.js',
        '/plugins/swiper/swiper-bundle.min.js',
        // '/plugins/mmenu/mmenu.js',
        '/js/menutoggle.js',
        '/plugins/aos/aos.js',
        '/plugins/numscroller/numscroller-1.0.js',
        '/js/jquery.fancybox.min.js',
        '/js/owl.carousel.min.js',
        '/plugins/ar-contactus/res/js/jquery.contactus.min.js',
        '/plugins/ar-contactus/res/js/scripts.js',
        // '/js/bootstrap.js',
        '/js/modernizr-2.7.2.js',
        '/js/function.js',
        '/js/app.js',
        '/js/addon.js',
        '/js/jquery.ripples.min.js',
        '/js/product.js',
    ],
    'js/minify.js',
) !!}
<script src="./plugins/preline/dist/preline.js"></script>
{{--
<script src="{{ asset('js/product.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
--}}


<!-- lazy load -->
<script src="{{ asset('js/lazyload.min.js') }}"></script>
<script>
    var myLazyLoad = new LazyLoad({
        elements_selector: ".lazy"
    });
</script>
@if (config('app.env') == 'local')
    <script src="//localhost:35729/livereload.js"></script>
@endif

<!-- recaptcha show-->
<div id="recaptcha_element"></div>
<script src="https://www.google.com/recaptcha/api.js?render={{ config('recapcha.site_key_google') }}"></script>
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'vi',
            autoDisplay: false
        }, 'google_translate_element');
    }
	$(document).ready(function() {
		// hide the element by default
		$('#google_translate_element').hide();
		
		// add a click event listener to the button
		$('#toggle-button').click(function() {
			// toggle the visibility of the element
			$('#google_translate_element').toggle();
		});
	});
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
</script>
<script>
    // var recaptchaResponseContact = document.getElementById('recaptcha_response_contact');
    // var formContact = $('#form_contact');
    // var jsFormContact = document.getElementById('form_contact');
    // if (formContact) {
    // 	grecaptcha.ready(function() {
    // 		if (formContact) {
    // 			formContact.submit(function( event ) {
    // 				event.preventDefault();
    // 				var action = 'contact/submit';

    // 				grecaptcha.execute(SITE_KEY_GOOGLE, {action: action}).then(function(token) {
    // 					var $recaptchaAction = $('#form_contact #recaptcha_action');
    //                     var $recaptchaToken = $('#form_contact #recaptcha_token');

    //                     if ($recaptchaAction.length) {
    //                         $recaptchaAction.val(action);
    //                     } else {
    //                         formContact.append('<input type="hidden" name="recaptcha_action" id="recaptcha_action" value="' + action + '" />');
    //                     }

    //                     if ($recaptchaToken.length) {
    //                         $recaptchaToken.val(token);
    //                     } else {
    //                         formContact.append('<input type="hidden" name="recaptcha_token" id="recaptcha_token" value="' + token + '" />');
    //                     }
    // 				});    

    // 				if (jsFormContact.checkValidity()) {
    // 					jsFormContact.submit();
    // 				}
    // 				jsFormContact.classList.add('was-validated');
    // 			});
    // 		}
    // 	});
    // }
    // var formContactId = 'FormContact';
    // var formContact = document.getElementById(formContactId);
    // var recaptchaFormContact = document.querySelector("#FormContact .example");
    // if(formContact){
    // 	console.log('vo');
    // 	grecaptcha.ready(function () {
    // 		if(formContact){
    // 			formContact.addEventListener("submit", function(event) {
    // 				event.preventDefault();
    // 				var action = 'contact';
    // 				grecaptcha.execute(SITE_KEY_GOOGLE, {action: action}).then(function(token) {
    // 					var $recaptchaAction = document.querySelector("#"+ formContactId +" #recaptcha_active");
    //                     var $recaptchaToken = document.querySelector("#"+ formContactId +" #recaptcha_token");
    //                     if ($recaptchaAction) {
    //                         $recaptchaAction.val(action);
    //                     } else {
    // 						$( "#"+formContactId ).append( '<input type="hidden" name="recaptcha_action" id="recaptcha_action" value="' + action + '" />' );
    // 						// formContact.innerHTML += '<input type="hidden" name="recaptcha_action" id="recaptcha_action" value="' + action + '" />';
    //                     }

    //                     if ($recaptchaToken) {
    //                         $recaptchaToken.val(token);
    //                     } else {
    // 						$( "#"+formContactId ).append( '<input type="hidden" name="recaptcha_token" id="recaptcha_token" value="' + action + '" />' );
    // 						// formContact.innerHTML += '<input type="hidden" name="recaptcha_token" id="recaptcha_token" value="' + token + '" />';
    //                     }
    // 					formContact.submit();
    // 				});        
    // 			}, false);
    // 		}
    // 	});
    // }
</script>
<!-- Js Body -->
{!! $setting['bodyjs'] !!}

<!-- Js Fanpage -->
{!! $setting['fanpagejs'] !!}
