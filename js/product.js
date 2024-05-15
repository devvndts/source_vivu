function ColorClick(e) {
	$(".color-pro-detail").removeClass("active");
	$(e).addClass("active");
	var id = $(e).data("id");
	var mau = $(e).find('input').val();
	var size = ($(".size-pro-detail.active input").val()) ? $(".size-pro-detail.active input").val() : 0;
	var masp_color = $(e).data("masp");
	var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
	$('.gallery-photo-item').removeClass('gallery-photo-show');
	$('#gallery-photo-show-' + mau).addClass('gallery-photo-show');
	if (id) {
		$.ajax({
			url: 'ajax/ajax-product-detail',
			type: "POST",
			dataType: 'json',
			async: false,
			data: { mau: mau, size: size, id: id, cmd: 'color_click', _token: _token },
			success: function (result) {
				$("#product_detail_size").html(result.size);
				//$('.sku'+id).html(result.sku);
				$('.sku' + id).html(masp_color);
				$('.detail__price--new' + id).html(result.giamoi);
				$('.detail__price--old' + id).html(result.gia);
				$('.gallery-photo-first').find('img').attr('src', result.photo);
				$('.gallery-thumb-first').find('img').attr('src', result.photo);
				//console.log(result.photo);
				if (result.giakm > 0) {
					$('.detail__price--km' + id).html('-' + result.giakm + '%');
				} else {
					$('.detail__price--km' + id).addClass('d-none');
				}
				if (result.is_soluong == true) {
					$('#isStock').text('Còn hàng');
					$('#show_btn_conhang').removeClass('btn-cart-hidden');
					$('#show_btn_conhang').addClass('btn-cart-grid');
					$('#show_btn_mobile_conhang').removeClass('btn-cart-hidden');
					$('#show_btn_mobile_conhang').addClass('btn-cart-grid');
					$('#show_btn_hethang').removeClass('btn-hethang-show');
					$('#show_btn_hethang').addClass('btn-hethang-hidden');
				} else {
					$('#isStock').text('Hết hàng');
					$('#show_btn_conhang').addClass('btn-cart-hidden');
					$('#show_btn_conhang').removeClass('btn-cart-grid');
					$('#show_btn_mobile_conhang').addClass('btn-cart-hidden');
					$('#show_btn_mobile_conhang').removeClass('btn-cart-grid');
					$('#show_btn_hethang').addClass('btn-hethang-show');
					$('#show_btn_hethang').removeClass('btn-hethang-hidden');
				}
			}
		});
	}
}
function SizeClick(e) {
	$(".size-pro-detail").removeClass("active current-active");
	$(e).addClass("active").addClass("current-active");
	var mau = ($(".color-pro-detail.active input").val()) ? $(".color-pro-detail.active input").val() : 0;
	var size = $(e).find('input').val();
	var id = $(e).data("id");
	var _token = $('input[name="_token"]').val(); // token để mã hóa dữ liệu
	if (id) {
		$.ajax({
			url: 'ajax/ajax-product-detail',
			type: "POST",
			dataType: 'json',
			async: true,
			data: { mau: mau, size: size, id: id, cmd: 'size_click', _token: _token },
			success: function (result) {
				console.log('result',result);
				$('.detail__price--from-to').addClass('hidden');
				// $(".album-detail" + id).html(result.album);
				// $(".product_detail_des").html(result.mota);
				//$('.sku'+id).html(result.sku);
				if (result.giakm) {
					$('.detail__price--new' + id).html(result.giamoi);
				} else {
					$('.detail__price--new' + id).html(result.gia);
				}
				
				$('.detail__price--old' + id).html(result.gia);
				$('.gallery-photo-first').find('img').attr('src', result.photo);
				$('.gallery-thumb-first').find('img').attr('src', result.photo);
				if (result.giakm > 0) {
					$('.detail__price--km' + id).html('-' + result.giakm + '%');
				} else {
					$('.detail__price--km' + id).addClass('hidden');
				}
				if (result.is_soluong == true) {
					$('#isStock').text('Còn hàng');
					$('#show_btn_conhang').removeClass('btn-cart-hidden');
					$('#show_btn_conhang').addClass('btn-cart-grid');
					$('#show_btn_mobile_conhang').removeClass('btn-cart-hidden');
					$('#show_btn_mobile_conhang').addClass('btn-cart-grid');
					$('#show_btn_hethang').removeClass('btn-hethang-show');
					$('#show_btn_hethang').addClass('btn-hethang-hidden');
				} else {
					$('#isStock').text('Hết hàng');
					$('#show_btn_conhang').addClass('btn-cart-hidden');
					$('#show_btn_conhang').removeClass('btn-cart-grid');
					$('#show_btn_mobile_conhang').addClass('btn-cart-hidden');
					$('#show_btn_mobile_conhang').removeClass('btn-cart-grid');
					$('#show_btn_hethang').addClass('btn-hethang-show');
					$('#show_btn_hethang').removeClass('btn-hethang-hidden');
				}
				$('.owl-thumb-pro-ajax').owlCarousel({
					margin: 10,
					dots: false,
					responsive: {
						0: {
							items: 3,
							margin: 10
						},
						500: {
							items: 3,
							margin: 10
						},
						992: {
							items: 5,
							margin: 10
						}
					}
				});
				MagicZoom.refresh();
			}
		});
	}
}
$(document).ready(function () {
	if ($(".color-pro-detail.active").exists()) {
		$(".color-pro-detail.active").on("click", function () {
			$('#color-current').html($(this).attr('title'));
			ColorClick(this);
		});
		$(".color-pro-detail.active").trigger("click");
	}
	if ($(".color-pro-detail").exists()) {
		$('body').on('click', '.color-pro-detail', function () {
			$('#color-current').html($(this).attr('title'));
			ColorClick(this);
		});
	}
	if ($(".size-pro-detail").exists()) {
		$('body').on('click', '.size-pro-detail', function () {
			SizeClick(this);
		});
	}
	if ($("#page-product-detail .SizefirstOption").exists()) {
		$('#page-product-detail .SizefirstOption').trigger('click');
	}
});