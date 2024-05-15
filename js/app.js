/* Check Form */
ValidationFormSelf("validation-contact");
ValidationFormSelf("validation-contact2");
ValidationFormSelf("validation-tuvan");
ValidationFormSelf("validation-cart");
ValidationFormSelf("validation-newsletter");
ValidationFormSelf("validation-user");
/* Exists */
$.fn.exists = function () {
	return this.length;
};
if (window.location.hash === "#_=_") {
	history.replaceState ? history.replaceState(null, null, window.location.href.split("#")[0]) : window.location.hash = "";
}
MIKOTECH.AllPage = function () {
	$(function () {
        var $window = $(window),
            win_height_padded = $window.height() * 1.1,
            isTouch = Modernizr.touch;
        //if (isTouch) { $('.revealOnScroll').addClass('animated'); }
        $window.on("scroll load", revealOnScroll);
        function revealOnScroll() {
            var scrolled = $window.scrollTop(),
                win_height_padded = $window.height() * 1.1;
            // Showed...
            $(".revealOnScroll:not(.animated)").each(function () {
                var $this = $(this),
                    offsetTop = $this.offset().top;

                if (scrolled + win_height_padded > offsetTop) {
                    if ($this.data("timeout")) {
                        window.setTimeout(function () {
                            $this.addClass(
                                "animated " + $this.attr("data-animation")
                            );
                        }, parseInt($this.data("timeout"), 10));
                    } else {
                        $this.addClass(
                            "animated " +
                                $this.attr("data-animation") +
                                " " +
                                offsetTop
                        );
                    }
                }
            });
            // Hidden...
            $(".revealOnScroll.animated").each(function (index) {
                var $this = $(this),
                    offsetTop = $this.offset().top;
                if (scrolled + win_height_padded < offsetTop) {
                    $(this).removeClass(
                        "animated animate__fadeInUp animate__fadeInDown animate__fadeInLeft animate__fadeInUpBig animate__fadeIn animate__backInRight animate__backInLeft animate__zoomIn"
                    );
                }
            });
        }
        revealOnScroll();
    });
	$(function(){
		var realImageSrc = $(".safelyLoadImage").data("imgsrc");	
		$(".safelyLoadImage").attr("onerror", "this.onerror=null; this.src='" + NOT_FOUND_IMAGE + "';");			
		$(".safelyLoadImage").attr("src", realImageSrc);
		$(".safelyLoadImage").removeClass("safelyLoadImage");		
	});
	$('#menu-verticle>li').hover(function () {
		var vitri = $(this).position().top;
		$('#menu-verticle>li>ul').css({
			'top': vitri + 'px'
		})
	});
	const toggleItem = (item) => {
		const accordionBody = item.querySelector('.accordion__body');
		if (item.classList.contains('accordion-open')) {
			accordionBody.removeAttribute('style');
			item.classList.remove('accordion-open');
		} else {
			accordionBody.style.height = accordionBody.scrollHeight + 'px';
			item.classList.add('accordion-open');
		}
	}
	const accordionItems = document.querySelectorAll('.accordion__item');
	accordionItems.forEach((item, index) => {
		if (item.classList.contains('accordion-open')) {
			const accordionBody = item.querySelector('.accordion__body');
			accordionBody.style.height = accordionBody.scrollHeight + 'px';
		}
		const accordionHeader = item.querySelector('.accordion__header');
		accordionHeader.addEventListener('click', () => {
			const openItem = document.querySelector('.accordion-open');
			toggleItem(item);
			if (openItem && openItem !== item) {
				toggleItem(openItem);
			}
		})
	})
	// $(document).keydown(function (event) {
	//     if (event.keyCode == 123) { // Prevent F12
	//         return false;
	//     } else if ((event.ctrlKey && event.shiftKey && event.keyCode == 73) || (event.ctrlKey && event.keyCode == 85) ) { // Prevent Ctrl+Shift+I        
	//         return false;
	//     } else if(event.ctrlKey && event.keyCode == 67){
	//     	return false;
	//     }
	// });
	// $(document).on("contextmenu", function (e) {        
	//     e.preventDefault();
	// });
	/*$("#water-page").ripples({
		resolution: 500,
		perturbance: 10,
	});*/
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) $('.back-to-top').fadeIn();
		else $('.back-to-top').fadeOut();
	});
	$('body').on("click", ".back-to-top", function () {
		$('html, body').animate({ scrollTop: 0 }, 800);
		return false;
	});
	$('body').on("click", ".back-to-top-button", function () {
		$('html, body').animate({ scrollTop: 0 }, 800);
		return false;
	});
	$('.menu-side-title span').click(function () {
		$(this).parents('li').children('ul').toggle(300);
	});
	$(window).scroll(function () {
		var h_header = $('#header').height();
		if ($(this).scrollTop() >= h_header) {
			$('#header').addClass('fixed-top');
			$('#header').removeClass('relative');
		} else {
			$('#header').removeClass('fixed-top');
			$('#header').addClass('relative');
		}
	});
	$('.header-search button, .header-search-close').click(function () {
		var e_target = $('.header-search-container');
		if (!e_target.hasClass('header-search-active')) {
			e_target.addClass('header-search-active');
		} else {
			e_target.removeClass('header-search-active');
		}
	});
	$('.header-menu-btn').click(function () {
		var e_show = $(this).attr('data-id');
		$(e_show).addClass('modal-menu-show');
		$('.modal-menu-close').attr('data-id', e_show);
	});
	$('.nav-menu').hcOffcanvasNav({
		maxWidth: false,
		customToggle: $('.menu-mobile .bar'),
		//navTitle: 'Menu',
		//levelTitles: true,
		//pushContent: '.container',
		levelOpen:'expand', // 'overlap, expand, false'
		levelSpacing: 20,
		insertClose: 0,
		closeLevels: true
	});
	$('.header-menu-btn').click(function () {
		var e_show = $(this).attr('data-id');
		$(e_show).addClass('modal-menu-show');
		$('.modal-menu-close').attr('data-id', e_show);
	});
	$('.modal-menu-close').click(function () {
		var e_show = $(this).attr('data-id');
		$(e_show).removeClass('modal-menu-show');
	});
	$('#menu-sidebar ul li').children('ul').addClass('menu-sidebar-pad');
	$('#menu-sidebar >li').append('<span class="menu-sidebar-right"><i class="fal fa-chevron-right"></i><span>');
	$('#menu-sidebar li').children('ul').parent().append('<span class="menu-sidebar-down" data-change="fa-chevron-down" ><i class="fal fa-chevron-down"></i><span>');
	$('#menu-sidebar >li').hover(function () {
		$('#menu-sidebar li').removeClass('menu-sidebar-active');
		$(this).addClass('menu-sidebar-active');
	});
	$('.menu-sidebar-down').click(function () {
		$(this).parent('li').children('ul').toggle(300);
		var e_idown = $(this).find('i');
		var dataClass = $(this).attr('data-change');
		if (dataClass == 'fa-chevron-down') {
			e_idown.removeClass('fa-chevron-down');
			e_idown.addClass('fa-horizontal-rule');
			$(this).attr('data-change', 'fa-horizontal-rule');
		}
		if (dataClass == 'fa-horizontal-rule') {
			e_idown.addClass('fa-chevron-down');
			e_idown.removeClass('fa-horizontal-rule');
			$(this).attr('data-change', 'fa-chevron-down');
		}
	});
};
MIKOTECH.FormLogin = function () {
	if ($(".hlogin__owl").exists()) {
		$('.hlogin__owl').owlCarousel({
			items: 1,
			loop: true,
			mouseDrag: false,
			pullDrag: false,
			autoHeight: true,
			dots: false
		});
		$('#resetAccount_form').submit(function (e) {
			e.preventDefault();
			$('#loading_order').show();
			$.ajax({
				url: 'account/reset-account',
				type: "POST",
				dataType: 'json',
				async: true,
				data: $(this).serialize(),
				success: function (result) {
					if (result) {
						Swal.fire({
							position: 'top',
							icon: result.icon,
							title: '<p class="h6">' + result.text + '</p>',
							showConfirmButton: false,
							timer: 1500,
							toast: true
						});
						if (result.icon == 'success') {
							window.location = CONFIG_BASE + "";
						}
					}
				},
				complete: function () {
					$('#loading_order').hide();
				}
			});
		});
		//### đăng ký
		$('#signin_form').submit(function (e) {
			e.preventDefault();
			$('#loading_order').show();
			$.ajax({
				url: 'account/signin',
				type: "POST",
				dataType: 'json',
				async: false,
				data: $(this).serialize(),
				success: function (result) {
					if (result) {
						$('#loading_order').hide();
						Swal.fire({
							position: 'top-end',
							//icon: result.icon,
							title: '<div class="h6">' + result.text + '</div>',
							showConfirmButton: true,
							confirmButtonText: LANG_KEY.dahieu,
							timer: 4000,
							toast: true
						})
						if (result.icon == 'success') {
							window.location = CONFIG_BASE + "";
						}
					}
				},
				complete: function () {
					$('#loading_order').hide();
				}
			});
		});
		//### đăng nhập
		$('#login_form').submit(function (e) {
			e.preventDefault();
			$.ajax({
				url: 'account/login',
				type: "POST",
				dataType: 'json',
				async: false,
				data: $(this).serialize(),
				success: function (result) {
					if (result) {
						Swal.fire({
							position: 'top',
							icon: result.icon,
							title: '<p class="h6">' + result.text + '</p>',
							showConfirmButton: false,
							timer: 1500,
							toast: true
						})
						if (result.icon == 'success') {
							window.location.href = CONFIG_BASE + "";
						}
					}
				}
			});
		});
	}
};
MIKOTECH.OwlProDetail = function () {
	$("#back_btn").click(function () {
		window.history.back();
	});
	/*$(window).on("resize load", function() {
		  if($(window).width() < 1025){
				var owl1 = $(".detail__gallery_list");
			var owl2 = $(".detail__gallery_thumb");
			var slidesPerPage = 5; //globaly define number of elements per page
			var syncedSecondary = true;
			$('.detail__gallery_list').addClass('owl-carousel owl-theme owl-thumb-pro');
			owl1.owlCarousel({
				margin: 0,
				slideSpeed: 5000,
				dots: false,
				loop:false,
				responsive: {
					0: {
						items: 1,
						margin: 0
					},
					500: {
						items: 1,
						margin: 0
					},
					1025: {
						items: 1,
						margin: 0
					}
				}
			}).on('changed.owl.carousel', syncPosition);
			owl2.on('initialized.owl.carousel', function() {
					owl2.find(".owl-item").eq(0).addClass("owl-thumb-active");
				})
				.owlCarousel({
				margin: 0,
				dots: false,
				loop:false,
				responsive: {
					0: {
						items: slidesPerPage,
						margin: 0
					},
					500: {
						items: slidesPerPage,
						margin: 0
					},
					1025: {
						items: slidesPerPage,
						margin: 0
					}
				}
			});
			function syncPosition(el) {		        
				var count = el.item.count - 1;
				var current = Math.round(el.item.index - (el.item.count / 2) - .5);
				if (current < 0) {
					current = count;
				}
				if (current > count) {
					current = 0;
				}
				//end block
				owl2.find(".owl-item")
					.removeClass("current")
					.eq(current)
					.addClass("current");
				var onscreen = owl2.find('.owl-item.active').length - 1;
				var start = owl2.find('.owl-item.active').first().index();
				var end = owl2.find('.owl-item.active').last().index();
				if (current > end) {
					owl2.data('owl.carousel').to(current, 100, true);
				}
				if (current < start) {
					owl2.data('owl.carousel').to(current - onscreen, 100, true);
				}
			}
			function syncPosition2(el) {
				if (syncedSecondary) {
					var number = el.item.index;
					owl1.data('owl.carousel').to(number, 100, true);
				}
			}
			owl2.on("click", ".owl-item", function(e) {
				e.preventDefault();
				var number = $(this).index();
				owl1.data('owl.carousel').to(number, 300, true);
				$('.owl-item').removeClass('owl-thumb-active');
				$(this).addClass('owl-thumb-active');
			});
		}else{			
			var owl = $('.owl-thumb-pro');
			owl.trigger('destroy.owl.carousel');
			$('.detail__gallery_list').removeClass('owl-carousel owl-theme owl-thumb-pro');
		}
	});*/
	$('body').on("click", "a.gallery-photo-scroll", function (event) {
		event.preventDefault();
		var header_height = $('#header').height();
		$("html, body").animate({ scrollTop: ($($(this).attr("href")).offset().top - header_height) }, 700);
	})
};
MIKOTECH.OwlPage = function () {
	if ($(".icon-search").exists()) {
		$(".icon-search").click(function () {
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
				$(".header-bottom .search-grid").stop(true, true).animate({ opacity: "0", width: "0px" }, 200);
			}
			else {
				$(this).addClass('active');
				$(".header-bottom  .search-grid").stop(true, true).animate({ opacity: "1", width: "230px" }, 200);
			}
			document.getElementById($(this).next().find("input").attr('id')).focus();
			$('.icon-search i').toggleClass('fa fa-search fa fa-times');
		});
	};
	$('body').on("click", ".custom-owl-prev", function () {
		let owl_target = $(this).attr('data-target');
		$(owl_target).trigger('prev.owl.carousel');
	});
	$('body').on("click", ".custom-owl-next", function () {
		let owl_target = $(this).attr('data-target');
		$(owl_target).trigger('next.owl.carousel');
	});
	$('body').on("click", ".custom-owl-to", function () {
		let owl_target = $(this).attr('data-target');
		let position = $(this).attr('data-position');
		$(owl_target).trigger('to.owl.carousel', [position, 500]);
	});
	if ($(".slider__owl").exists()) {
		var owl = $('.slider__owl');
		owl.on('initialized.owl.carousel', function (event) {
			$(event.target).find('.owl-item.active').addClass('slideItem-active');
		})
		owl.on('translate.owl.carousel', function (event) {
			$(event.target).find('.owl-item.active').removeClass('slideItem-active');
		})
		owl.on('translated.owl.carousel', function (event) {
			$(event.target).find('.owl-item.active').addClass('slideItem-active');
		})
		owl.owlCarousel({
			items: 1,
			autoplay: true,
			loop: true,
			lazyLoad: true,
			mouseDrag: false,
			touchDrag: false,
			autoplayHoverPause: true,
			animateOut: 'fadeOut slide-fadeOut',
			//animateIn: 'fadeIn',
			margin: 0,
			smartSpeed: 500,
			autoplaySpeed: 5000,
			nav: false,
			dots: true
		});
	}
	if ($(".ketnoi_owl").exists()) {
		var owl = $('.ketnoi_owl');
		owl.owlCarousel({
			items: 2,
			autoplay: false,
			loop: false,
			lazyLoad: true,
			mouseDrag: true,
			autoplayHoverPause: true,
			nav: false,
			dots: true,
			margin: 38,
			responsiveClass: true,
			responsive: {
				0: {
					items: 2,
					nav: false,
					margin: 10,
					dots: false
				},
				651: {
					items: 2,
					nav: false,
					margin: 10,
					dots: false
				},
				1025: {
					items: 2,
					nav: false,
					margin: 39,
					dots: false
				}
			}
		});
	}
	if ($(".newshome_owl").exists()) {
		var owl = $('.newshome_owl');
		owl.owlCarousel({
			items: 4,
			autoplay: false,
			loop: false,
			lazyLoad: true,
			mouseDrag: true,
			autoplayHoverPause: true,
			nav: false,
			dots: true,
			margin: 24,
			stagePadding: 50,
			responsiveClass: true,
			responsive: {
				0: {
					items: 2,
					nav: false,
					margin: 10,
					stagePadding: 0,
					dots: false
				},
				651: {
					items: 2,
					nav: false,
					margin: 10,
					dots: false
				},
				1025: {
					items: 3,
					nav: false,
					margin: 24,
					stagePadding: 50,
					dots: false
				}
			}
		});
	}
	if ($(".post__owl__tab").exists()) {
		var owl = $('.post__owl__tab');
		owl.owlCarousel({
			items: 4,
			autoplay: false,
			loop: false,
			lazyLoad: true,
			mouseDrag: true,
			autoplayHoverPause: true,
			nav: false,
			dots: true,
			margin: 34,
			responsiveClass: true,
			responsive: {
				0: {
					items: 2,
					nav: false,
					margin: 10,
					dots: false
				},
				651: {
					items: 3,
					nav: false,
					margin: 10,
					dots: false
				},
				1025: {
					items: 4,
					nav: false,
					margin: 34,
					dots: false
				}
			}
		});
	}
	$(document).ready(function () {
		if ($(window).width() < 1025) {
			stopCarousel();
		} else {
			startCarousel();
		}
	});
	$(window).on("resize", function () {
		if ($(window).width() < 1025) {
			stopCarousel();
		} else {
			startCarousel();
		}
	});
	function startCarousel() {
		if ($(".product__owl").exists()) {
			var owl = $('.product__owl');
			owl.owlCarousel({
				items: 3,
				autoplay: false,
				loop: false,
				lazyLoad: true,
				mouseDrag: true,
				autoplayHoverPause: true,
				margin: 0,
				nav: false,
				dots: true
			});
		}
		if ($(".nhacungcap_owl").exists()) {
			var owl = $('.nhacungcap_owl');
			owl.owlCarousel({
				items: 4,
				autoplay: false,
				loop: false,
				lazyLoad: true,
				mouseDrag: true,
				autoplayHoverPause: true,
				margin: 0,
				nav: false,
				dots: true,
				margin: 25,
			});
		}
		if ($(".product_owl_tab").exists()) {
			var owl = $('.product_owl_tab');
			owl.owlCarousel({
				items: 1,
				autoplay: false,
				loop: false,
				lazyLoad: true,
				mouseDrag: true,
				autoplayHoverPause: true,
				margin: 0,
				nav: false,
				dots: true
			});
		}
		if ($(".khachhang__owl").exists()) {
			var owl = $('.khachhang__owl');
			owl.owlCarousel({
				items: 4,
				autoplay: true,
				loop: false,
				lazyLoad: true,
				mouseDrag: true,
				autoplayHoverPause: true,
				nav: false,
				dots: true,
				margin: 34,
			});
		}
	}
	function stopCarousel() {
		if (!$('.product__owl').hasClass('fix-carousel-off')) {
			var owl = $('.product__owl');
			owl.trigger('destroy.owl.carousel');
			owl.addClass('fix-carousel-off');
		}
		var owl_feed = $('.khachhang__owl');
		owl_feed.trigger('destroy.owl.carousel');
		owl_feed.addClass('fix-carousel-off');
		/*var owl_feed = $('.ketnoi_owl');
		owl_feed.trigger('destroy.owl.carousel');
		owl_feed.addClass('fix-carousel-off');*/
		var owl_feed = $('.nhacungcap__owl');
		owl_feed.trigger('destroy.owl.carousel');
		owl_feed.addClass('fix-carousel-off');
		/*var owl = $('.post__owl__tab');
		owl.trigger('destroy.owl.carousel');
		owl.addClass('fix-carousel-off');*/
		var owl = $('.product_owl_tab');
		owl.trigger('destroy.owl.carousel');
		owl.addClass('fix-carousel-off');
		var owl = $('.nhacungcap_owl');
		owl.trigger('destroy.owl.carousel');
		owl.addClass('fix-carousel-off');
	}
	/* ### END CHANGE CAROUSEL */
	/* CHANGE HEIGHT FEEDBACK ITEMS ODD - EVEN */
	function changeHeightFeed() {
		var maxHeightOdd = maxHeightEven = -1;
		$('.feedback-items').removeAttr('style');
		$('.feedback-items-odd').each(function () {
			maxHeightOdd = maxHeightOdd > $(this).height() ? maxHeightOdd : $(this).height();
		});
		//alert(maxHeightOdd);
		$('.feedback-items-odd').height(maxHeightOdd + 80);
		$('.feedback-items-even').each(function () {
			maxHeightEven = maxHeightEven > $(this).height() ? maxHeightEven : $(this).height();
		});
		maxHeightEven = maxHeightEven > maxHeightOdd ? maxHeightEven : (maxHeightOdd + 110);
		$('.feedback-items-even').height(maxHeightEven);
	}
	function autoHeightFeed() {
		var maxHeight = -1;
		$('.feedback-items').removeAttr('style');
		$('.feedback-items').each(function () {
			maxHeight = maxHeight > $(this).height() ? maxHeight : $(this).height();
		});
		$('.feedback-items').height(maxHeight + 80);
	}
	if ($(".quangcao__owl").exists()) {
		var owl = $('.quangcao__owl');
		owl.owlCarousel({
			items: 1,
			autoplay: true,
			loop: true,
			lazyLoad: true,
			mouseDrag: true,
			autoplayHoverPause: true,
			margin: 16,
			nav: false,
			dots: false,
			responsiveClass: true,
			responsive: {
				0: {
					items: 1,
					nav: false
				},
				551: {
					items: 1,
					nav: false
				}
			}
		});
	}
};
/* Cart */
MIKOTECH.Cart = function () {
	function ViewCart(cmd = 'popup-cart') {
		$.ajax({
			url: "ajax/ajax-cart",
			type: "POST",
			dataType: 'html',
			async: false,
			data: { cmd: cmd, _token: $('input[name="_token"]').val() },
			success: function (result) {
				$.fancybox.close();
				//$("#popup-cart .modal-body").html(result);
				//$('#popup-cart').modal('show');
				$('.fixmodel_cart_view').html(result);
				$('#fixmodel_cart').addClass('active');
				$('#fixmodel_cart').addClass('show-cart');
				$('#fix_site_overlay').addClass('active');
				$('#fixmodel_cart_site_close, .fix_site_overlay').click(function () {
					$('#fixmodel_cart').removeClass('active');
					$('#fixmodel_cart').removeClass('show-cart');
					$('#fix_site_overlay').removeClass('active');
				});
			}
		});
	}
	$("body").on("click", ".fix_cart_count", function () {
		ViewCart();
	});
	$("body").on("click", ".change-prop-btn-quantity", function () {
		var code = $(this).attr('data-code');
		var id = $(this).attr('data-id');
		var mau = 0;
		var size = ($(this).parent('.box-product-img').find('input[name="cart-size"]').val()) ? $(this).parent('.box-product-img').find('input[name="cart-size"]').val() : 0;
		var quantity = parseInt($(`.change-prop-btn-quantity-input[data-id=${id}]`).val());
		if (!quantity) {
			quantity = 1;
		}
		$.ajax({
			url: "ajax/ajax-cart",
			type: "POST",
			dataType: 'json',
			async: false,
			data: { cmd: 'add-cart', id: id, mau: mau, size: size, quantity: quantity, _token: $('input[name="_token"]').val() },
			success: function (result) {
				$('.ajax-count-cart').each(function () {
					$(this).html(result.max);
				});
				// ViewCart();
			}
		});
	});
	$("body").on("click", ".change-prop-btn", function () {
		var code = $(this).attr('data-code');
		var id = $(this).attr('data-id');
		$.ajax({
			url: "ajax/ajax-cart",
			type: "POST",
			dataType: 'html',
			async: false,
			data: { cmd: 'popup-change-cart', code: code, id: id, _token: $('input[name="_token"]').val() },
			success: function (result) {
				$('.model_changecart_contain').html(result);
				$('.cartchange_site_overlay').addClass('active');
				$('.model_change_cart').addClass('active');
				$('#model_changecart_site_close, .cartchange_site_overlay').click(function () {
					$('#model_change_cart').removeClass('active');
					$('#cartchange_site_overlay').removeClass('active');
					$('#cartchange_site_overlay').removeClass('active');
				});
				$('.gallery_cart_product').owlCarousel({
					items: 1,
					autoplay: false,
					loop: true,
					lazyLoad: true,
					mouseDrag: true,
					autoplayHoverPause: true,
					margin: 0,
					nav: false,
					dots: true,
					responsiveClass: true
				});
				if ($("#model_changecart_site .SizefirstOption").exists()) {
					$('#model_changecart_site').find('.SizefirstOption').trigger('click');
				}
			}
		});
	});
	$('body').on('click', '#model_changecart_site .size-pro-detail', function () {
		SizeClick(this);
	});
	$('.box-product-item').each(function () {
		if (!$(this).find('.color-btn').exists()) {
			var e_select = $(this).find('select[name="cart-size"]');
			var e_item = e_select.parents('.box-product-item');
			var idproduct = e_item.find('.box-product-btncart').attr('data-id');
			var id_mau = e_item.find('.color-active').attr('data-id');
			var id_size = e_select.val();
			if (id_mau > 0) {
				$.ajax({
					type: "POST",
					url: 'ajax/ajax-get-size',
					dataType: 'json',
					data: { idproduct: idproduct, idmau: id_mau, idsize: id_size, _token: $('input[name="_token"]').val() },
					success: function (result) {
						e_item.find('.box-product-newprice').text(result.giamoi);
						e_item.find('.box-product-oldprice').text(result.gia);
						e_item.find('.box-product-value').text(result.giakm);
					}
				});
			}
		}
	});
	$('body').on('click', '.color-btn', function () {
		var id = $(this).attr('data-id');
		var idproduct = $(this).attr('data-idproduct');
		var e_size = $(this).parents('.box-product-sizecolor').find('.box-product-listsize select');
		var e_item = $(this).parents('.box-product-item');
		$(this).parent('.box-product-listcolor').find('input[name="cart-color"]').val(id);
		$(this).parent('.box-product-listcolor').find('.color-btn').removeClass('color-active');
		$(this).addClass('color-active');
		$.ajax({
			type: "POST",
			url: 'ajax/ajax-get-size',
			dataType: 'json',
			data: { idproduct: idproduct, idmau: id, _token: $('input[name="_token"]').val() },
			success: function (result) {
				e_size.html(result.select);
				e_item.find('.box-product-newprice').text(result.giamoi);
				e_item.find('.box-product-oldprice').text(result.gia);
				e_item.find('.box-product-value').text(result.giakm);
				//console.log(result.giamoi);
				//console.log(result.gia);
			}
		});
	});
	$('body').on('change', 'select[name="cart-size"]', function () {
		console.log('select change');
		var e_item = $(this).parents('.box-product-item');
		var idproduct = e_item.find('.box-product-btncart').attr('data-id');
		var id_mau = e_item.find('.color-active').attr('data-id');
		var id_size = $(this).val();
		$.ajax({
			type: "POST",
			url: 'ajax/ajax-get-size',
			dataType: 'json',
			data: { idproduct: idproduct, idmau: id_mau, idsize: id_size, _token: $('input[name="_token"]').val() },
			success: function (result) {
				//e_size.html(result.select);
				e_item.find('.box-product-newprice').text(result.giamoi);
				e_item.find('.box-product-oldprice').text(result.gia);
				e_item.find('.box-product-value').text(result.giakm);
				//console.log(result.giamoi);
				//console.log(result.gia);
			}
		});
	});
	$('.box-product-detail .color-active').each(function () {
		$(this).trigger('click');
	});
	$('body').on('click', '.btn-buy-cart', function () {
		var id = $(this).data("id");
		var action = $(this).data("action");
		var quantity = ($("#quantity").val()) ? $("#quantity").val() : 1;
		var mau = ($(this).parent('.box-product-img').find('input[name="cart-color"]').val()) ? $(this).parent('.box-product-img').find('input[name="cart-color"]').val() : 0;
		var size = ($(this).parent('.box-product-img').find('input[name="cart-size"]').val()) ? $(this).parent('.box-product-img').find('input[name="cart-size"]').val() : 0;
		//var size =($(this).parent('.box-product-img').find('select[name="cart-size"]').val()) ? $(this).parent('.box-product-img').find('select[name="cart-size"]').val() : 0;
		if (id) {
			$.ajax({
				url: "ajax/ajax-cart",
				type: "POST",
				dataType: 'json',
				async: false,
				data: { cmd: 'add-cart', id: id, mau: mau, size: size, quantity: quantity, _token: $('input[name="_token"]').val() },
				success: function (result) {
					if (result.is_soluong == false) {
						Swal.fire({
							position: 'center',
							icon: 'info',
							title: '<p class="h5">' + result.thongbao_status + '</p>',
							showConfirmButton: false,
							timer: 2500,
							toast: true
						})
						return false;
					}
					if (result.warning && result.warning != '') {
						Swal.fire({
							position: 'center',
							icon: 'warning',
							title: '<p class="h5">' + result.warning + '</p>',
							showConfirmButton: false,
							timer: 2500,
							toast: true
						})
						return false;
					}
					if (action == 'addnow') {
						$('.ajax-count-cart').each(function () {
							$(this).html(result.max);
						});
						ViewCart();
					} else if (action == 'buynow') {
						window.location = CONFIG_BASE + "gio-hang";
					}
				}
			});
		}
	});
	$("body").on("click", ".js-action-cart", function () {
		var mau = ($(".color-pro-detail.active input").val()) ? $(".color-pro-detail.active input").val() : 0;
		var size = ($(".size-pro-detail.active input").val()) ? $(".size-pro-detail.active input").val() : 0;
		var id = $(this).attr("data-id");
		var action = $(this).attr("data-action");
		// var quantity = ($("#quantity").val()) ? $("#quantity").val() : 1;
		var quantity = $(this).parents(".buy-btn-box").find('.buy-btn-quantity').val();
		if (!quantity) {
			quantity = 1;
		}
		var oldcode = $(this).attr("data-oldcode");
		if (id) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: 'ajax/ajax-cart',
				type: "POST",
				dataType: 'json',
				async: false,
				data: { cmd: 'add-cart', id: id, mau: mau, size: size, quantity: quantity, oldcode: oldcode, action: action, _token: $('input[name="_token"]').val() },
				success: function (result) {
					if (result.is_soluong == false) {
						Swal.fire({
							position: 'center',
							icon: 'info',
							title: '<p class="h5">' + result.thongbao_status + '</p>',
							showConfirmButton: false,
							timer: 2500,
							toast: true
						})
						return false;
					}
					if (action == 'addnow') {
						$('.ajax-count-cart').each(function () {
							$(this).html(result.max);
						});
						$.ajax({
							url: 'ajax/ajax-cart',
							type: "POST",
							dataType: 'html',
							async: false,
							data: { cmd: 'popup-cart', _token: $('input[name="_token"]').val() },
							success: function (result) {
								$('.ajax-count-cart').each(function () {
									$(this).html(result.max);
								});
								ViewCart();
							}
						});
					} else if (action == 'buynow') {
						window.location = CONFIG_BASE + "gio-hang";
					} else if (action == 'changenow') {
						$('.ajax-count-cart').each(function () {
							$(this).html(result.max);
						});
						ViewCart();
						$('.model_changecart_site_close').trigger('click');
					}
				}
			});
		}
	});
	$("body").on("click", ".del-procart", function () {
		let code = $(this).data("code");
		let ship = $(".price-ship").val();
		Swal.fire({
			title: '<h5>Bạn có chắc muốn xóa sản phẩm này?</h5>',
			showDenyButton: true,
			confirmButtonText: 'Đồng ý',
			denyButtonText: 'Hủy bỏ',
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: "POST",
					url: 'ajax/ajax-cart',
					dataType: 'json',
					data: { cmd: 'delete-cart', code: code, ship: ship, _token: $('input[name="_token"]').val() },
					success: function (result) {
						$('.ajax-count-cart').each(function () {
							$(this).html(result.max);
						});
						//$('.count-cart').html(result.max);
						if (result.max) {
							$('.price-temp').val(result.temp);
							$('.load-price-temp').html(result.tempText);
							$('.price-total').val(result.total);
							$('.coupon-temp').val(result.coupon);
							$('.load-price-discount').html(result.couponText);
							$('.load-price-total').html(result.totalText);
							$(".procart-" + code).remove();
							$('input[name="insurance-temp"]').val(result.insurance_temp);
							$('input[name="option_delivery"]:checked').trigger('change');
							ChangeDeliveryPrice();
							if (result.total >= 5000) {
								$('.payments-alepay').removeClass('d-none');
							} else {
								$('.payments-alepay').addClass('d-none');
								$('#payments-3').prop('checked', false);
								$('#payments-4').prop('checked', false);
							}
						} else {
							$(".wrap-cart").html('<a href="" class="empty-cart text-decoration-none"><i class="fa fa-cart-arrow-down"></i><p>' + LANG_KEY['no_products_in_cart'] + '</p><span>' + LANG_KEY['back_to_home'] + '</span></a>');
						}
					}
				});
			}
		});
	});
	$("body").on("click", ".counter-procart", function () {
		var $button = $(this);
		var input = $button.parent().find("input");
		var id = input.data('pid');
		var code = input.data('code');
		var oldValue = $button.parent().find("input").val();
		if ($button.text() == "+") quantity = parseFloat(oldValue) + 1;
		else if (oldValue > 1) quantity = parseFloat(oldValue) - 1;
		$button.parent().find("input").val(quantity);
		update_cart(id, code, quantity);
	});
	$("body").on("change", "input.quantity-procat", function () {
		var quantity = $(this).val();
		var id = $(this).data("pid");
		var code = $(this).data("code");
		update_cart(id, code, quantity);
	});
	if ($(".select-city-cart").exists()) {
		$(".select-city-cart").change(function () {
			var id = $(this).val();
			load_district(id);
			//load_ship();
		});
	}
	if ($("#nhanhangtaishop").exists()) {
		$("#nhanhangtaishop").change(function () {
			if ($(this).is(":checked")) {
				// load_ship(0,1);
				$('.info_nhanhang').animate({ height: 'show' }, 400);
				$('.default_address').animate({ height: 'hide' }, 200);
				$('.dienthoai').attr({ 'id': 'dienthoai1', 'name': 'dienthoai1' });
				$('.dienthoai1').attr({ 'id': 'dienthoai', 'name': 'dienthoai' });
				$('.dienthoai1').prop('required', true);
				$('.ten').prop('required', true);
				$('#city').prop('required', false);
				$('#district').prop('required', false);
				$('#wards').prop('required', false);
				$('#diachi').prop('required', false);
			} else {
				let id = $('#id_address_delivery').val();
				if (id = 'undefined') {
					let id_dist = $('#district').val();
					// load_ship(id_dist);
					$('.info_nhanhang').animate({ height: 'hide' }, 200);
					$('.default_address').animate({ height: 'show' }, 400);
					$('.dienthoai1').attr({ 'id': 'dienthoai1', 'name': 'dienthoai1' });
					$('.dienthoai').attr({ 'id': 'dienthoai', 'name': 'dienthoai' });
					$('#city').prop('required', true);
					$('#district').prop('required', true);
					$('#wards').prop('required', true);
					$('#diachi').prop('required', true);
				} else {
					$.ajax({
						url: 'ajax/getIdDistrict.php',
						type: 'POST',
						dataType: 'json',
						data: { id: id },
					})
						.done(function (res) {
							//load_ship(res.id_district);
							$('.info_nhanhang').animate({ height: 'hide' }, 200);
							$('.default_address').animate({ height: 'show' }, 400);
							$('.dienthoai1').attr({ 'id': 'dienthoai1', 'name': 'dienthoai1' });
							$('.dienthoai').attr({ 'id': 'dienthoai', 'name': 'dienthoai' });
							$('.dienthoai1').prop('required', false);
							$('.ten').prop('required', false);
						})
						.fail(function () {
							console.log("error");
						})
				}
			}
		});
	}
	if ($(".select-district-cart").exists()) {
		$(".select-district-cart").change(function () {
			var id = $(this).val();
			load_wards(id);
			// load_ship(id);
		});
	}
	if ($(".select-wards-cart").exists()) {
		$(".select-wards-cart").change(function () {
			var id = $(this).val();
		});
	}
	if ($(".payments-label").exists()) {
		$(".payments-label").click(function () {
			var payments = $(this).data("payments");
			$(".payments-cart .payments-label, .payments-info").removeClass("active");
			$(this).addClass("active");
			$(".payments-info-" + payments).addClass("active");
		});
	}
	if ($(".js-change-quantity").exists()) {
		$(".js-change-quantity").click(function () {
			var $button = $(this);
			var oldValue = $("#quantity").val();
			if ($button.attr("data-action") == "plus") {
				var newVal = parseFloat(oldValue) + 1;
			} else {
				if (oldValue > 1) var newVal = parseFloat(oldValue) - 1;
				else var newVal = 1;
			}
			$("#quantity").val(newVal);
		});
	}
	if ($(".btn-payment-cart").exists()) {
		$('#loading_order').hide();
		$('.btn-payment-cart').click(function () {
			$.ajax({
				url: 'ajax/ajax-check-cart',
				type: "GET",
				dataType: 'json',
				async: true,
				success: function (result) {
					if (result.success == false) {
						if (result.data) {
							$('.cart-warning-product').addClass('d-none');
							var data = result.data;
							for (let i in data) {
								$('.cart-warning-' + i).removeClass('d-none');
								if (data[i] > 0) {
									$('.cart-warning-' + i).text('(Sản phẩm này chỉ còn ' + data[i] + ' sản phẩm)');
									//console.log(data[i]);
								} else {
									$('.cart-warning-' + i).text('(Sản phẩm này vừa mới hết hàng)');
									//console.log(0);		
								}
							}
						}
						//console.log('error ajax-check-cart');
						return false;
					} else {
						var forms = document.getElementsByClassName('form-cart');
						var validation = Array.prototype.filter.call(forms, function (form) {
							if (form.checkValidity() === false) {
								event.preventDefault();
								event.stopPropagation();
								console.log('error validate');
							} else {
								$('#loading_order').show();
								form.submit();
							}
							form.classList.add('was-validated');
						});
					}
				}
			});
			return false;
		});
	}
	if ($("#voucher").exists()) {
		$('#voucher-check-btn').click(function () {
			var voucher_code = $('#voucher').val();
			var dienthoai = $('#dienthoai').val();
			let ship = $(".price-ship").val();
			$.ajax({
				url: "ajax/ajax-check-voucher",
				type: 'POST',
				dataType: 'json',
				data: { voucher_code: voucher_code, dienthoai: dienthoai, ship: ship, _token: $('input[name="_token"]').val() },
			})
				.done(function (result) {
					if (result.status == false) {
						if (result.text && result.text != '') { $('#voucher-content').removeClass('text-success').addClass('d-block text-error').text(result.text); }
						$('.load-price-coupon').text(result.sotien_duocgiam_text);
					} else {
						if (result.text && result.text != '') { $('#voucher-content').removeClass('text-error').addClass('d-block text-success').text(result.text); }
						$('input[name="coupon-temp"]').val(result.sotien_duocgiam);
						$('.load-price-coupon').text(result.sotien_duocgiam_text);
						$('.load-price-total').text(result.tongtien_saugiam_text);
					}
				})
				.fail(function () {
					console.log("error");
				})
		});
	}
};
MIKOTECH.Mmenu = function () {
	if ($("nav#menu").exists()) {
		$('nav#menu').mmenu(
			{
				"extensions": [
					"border-full",
					// "multiline",
					// "theme-dark",
					// "position-back",
					// "position-top",
					// "fullscreen"
				],
				setSelected: {
					hover: true,
					parent: true,
				},
				// slidingSubmenus: false,
				// iconbar: {
				//     use: "(min-width: 450px)",
				//     top: [
				//         '<a href="#/"><span class="fa fa-home"></span></a>',
				//     ],
				//     bottom: [
				//         '<a href="#/"><span class="fa fa-home"></span></a>',
				//         '<a href="#/"><span class="fa fa-home"></span></a>',
				//         '<a href="#/"><span class="fa fa-home"></span></a>',
				//     ],
				// },
				// iconPanels: {
				//     add: true,
				//     visible: 1,
				// },
				// navbars: [
				//     {
				//          "position": "top",
				//          type: "tabs",
				//          content: [
				//             '<a href="#panel-menu"><i class="fa fa-bars mr-2"></i> <span>Menu</span></a>',
				//             '<a href="#panel-account"><i class="fa fa-user mr-2"></i> <span>Account</span></a>',
				//             '<a href="#panel-cart"><i class="fa fa-shopping-cart mr-2"></i> <span>Cart</span></a>',
				//         ],
				//     },
				//     {
				//         content: ["prev", "title", "close"],
				//     },
				// ],
				"navbars": [
				{
					"position": "top",
					"content": [
						// "breadcrumbs",
						"prev",
						"title",
						"close"
					]
				}
				]
			},
			{
				// configuration
				offCanvas: {
					pageSelector: "#my-page"
				},
				// classNames: {
                //     vertical: "expand"
                // }
			},

		);
	}
};
/* AOS */
MIKOTECH.AOS = function(){
    AOS.init({
		animatedClassName: 'animate__animated',
	});
};
function scrollToElement(elementId) {
	const element = document.getElementById(elementId);
	element.scrollIntoView({ behavior: 'smooth' });
}
/* Ready */
$(document).ready(function () {
	const navigationHeight = document.querySelector('#header').offsetHeight;
	document.documentElement.style.setProperty('--scroll-padding', `${navigationHeight}px`);

	MIKOTECH.Mmenu();
	MIKOTECH.AllPage();
	MIKOTECH.OwlPage();
	MIKOTECH.OwlProDetail();
	MIKOTECH.Cart();
	MIKOTECH.AOS();
	MIKOTECH.FormLogin();
});
