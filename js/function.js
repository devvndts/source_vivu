/* Exists */
$.fn.exists = function(){
    return this.length;
};
/*
|--------------------------------------------------------------------------
| Kiểm tra validate form
|--------------------------------------------------------------------------
*/
function ValidationFormSelf(ele='')
{
    $('#loading_order').hide();
    if(ele)
    {
        $("."+ele).find("input[type=submit]").removeAttr("disabled");
        var forms = document.getElementsByClassName(ele);
        var validation = Array.prototype.filter.call(forms,function(form){            
            form.addEventListener('submit', function(event){
                if(form.checkValidity() === false){
                    event.preventDefault();
                    event.stopPropagation();                    
                }else{                    
                    $('#loading_order').show(); 
                    var action = 'contact';
					grecaptcha.execute(SITE_KEY_GOOGLE, {action: action}).then(function(token) {
						var $recaptchaAction = document.querySelector("."+ele +" #recaptcha_active");
                        var $recaptchaToken = document.querySelector("."+ele +" #recaptcha_token");
                        if ($recaptchaAction) {
                            $recaptchaAction.val(action);
                        } else {
                            $("."+ele).append( '<input type="hidden" name="recaptcha_action" id="recaptcha_action" value="' + action + '" />' );
                        }

                        if ($recaptchaToken) {
                            $recaptchaToken.val(token);
                        } else {
                            $("."+ele).append( '<input type="hidden" name="recaptcha_token" id="recaptcha_token" value="' + action + '" />' );
                        }
						$("."+ele).submit();
					}); 
                                    
                }
                form.classList.add('was-validated');
            }, false);
        });
    }
}


/*
|--------------------------------------------------------------------------
| Đăng ký bằng facebook , google, ect...
|--------------------------------------------------------------------------
*/
function SocialLogin(url){
    $('#loading_order').show();
    window.location.href.substr(0, window.location.href.indexOf('#'))
    window.location = url;
}


/*
|--------------------------------------------------------------------------
| Tìm kiếm
|--------------------------------------------------------------------------
*/

function modalNotify(text)
{
    Swal.fire({
      position: 'top',
      icon: 'warning',
      title: '<p class="h6">'+text+'</p>',
      showConfirmButton: false,
      timer: 1500,
      toast: true
    });
}

function doEnter(event,obj){

    if(event.keyCode == 13 || event.which == 13) onSearch(obj);
}


function onSearch(obj){
    var keyword = $("#"+obj).val();

    if(keyword==''){
        modalNotify(LANG_KEY['no_keywords']);
        return false;
    }else{
        location.href = "tim-kiem?keyword="+keyword;
        //loadPage(document.location);
    }
}


/*
|--------------------------------------------------------------------------
| Cập nhật giỏ hàng
|--------------------------------------------------------------------------
*/
function update_cart(id=0,code='',quantity=1){
    if(id){
        var ship = $(".price-ship").val();
        var voucher_code = $('#voucher').val();
        var dienthoai = $('#dienthoai').val();

        $.ajax({
            type: "POST",
            url: "ajax/ajax-cart",
            dataType: 'json',
            data: {voucher_code:voucher_code, dienthoai:dienthoai, cmd:'update-cart',id:id,code:code,quantity:quantity,ship:ship, _token:$('input[name="_token"]').val()},
            success: function(result){
                if(result.is_soluong==false){
                    $('.quantity-counter-procart-'+code).find('.quantity-procat').val(result.soluong_buy);
                    Swal.fire({
                      position: 'center',
                      icon: 'info',
                      title: '<p class="h5">'+result.thongbao_status+'</p>',
                      showConfirmButton: false,
                      timer: 2500,
                      toast: true
                    })
                    return false;
                }

                if(result){                    
                    $('.load-price-'+code).html(result.gia);
                    $('.load-price-new-'+code).html(result.giamoi);
                    $('.price-temp').val(result.temp);
                    $('.load-price-temp').html(result.tempText);
                    $('.price-total').val(result.total);
                    $('.load-price-total').html(result.totalText);

                    $('.coupon-temp').val(result.coupon);
                    $('.load-price-discount').html(result.couponText);
                    $('.ajax-count-cart').each(function(){
                        $(this).html(result.max);
                    }); 

                    //### change insurance price
                    //console.log('option_delivery ajax clicked');
                    $('input[name="insurance-temp"]').val(result.insurance_temp);
                    $('input[name="option_delivery"]:checked').trigger('change');
                    ChangeDeliveryPrice();

                    //$('.count-cart').html(result.max);
                    if(result.total>=5000){
                        $('.payments-alepay').removeClass('d-none');
                    }else{
                        $('.payments-alepay').addClass('d-none');
                        $('#payments-3').prop('checked',false);
                        $('#payments-4').prop('checked',false);
                    }

                    if(result.status==false){
                        if(result.text && result.text!=''){$('#voucher-content').removeClass('text-success').addClass('d-block text-error').text(result.text);}
                        $('.load-price-coupon').text(result.sotien_duocgiam_text);
                    }else{
                        if(result.text && result.text!=''){$('#voucher-content').removeClass('text-error').addClass('d-block text-success').text(result.text);}
                        $('input[name="coupon-temp"]').val(result.sotien_duocgiam);   
                        $('.load-price-coupon').text(result.sotien_duocgiam_text);                     
                        $('.load-price-total').text(result.tongtien_saugiam_text);
                    }
                    //console.log(result);
                }
            }
        });
    }
}

function load_district(id=0){
    $.ajax({
        type: 'post',
        url: 'ajax/ajax-district',
        data: {id_city:id, _token:$('input[name="_token"]').val()},
        success: function(result){
            $(".select-district").html(result);
            $(".select-wards").html('<option value="">'+LANG_KEY['wards']+'</option>');
        }
    });
}

function load_wards(id=0){
    $.ajax({
        type: 'post',
        url: 'ajax/ajax-wards',
        data: {id_district:id, _token:$('input[name="_token"]').val()},
        success: function(result){
            $(".select-wards").html(result);
        }
    });
}


/*
|--------------------------------------------------------------------------
| submit form with recaptcha google
|--------------------------------------------------------------------------
*/
function submitNewsletterForm() {
    window.grecaptcha.ready(function () {
        $( ".frm_check_recaptcha" ).each(function( index ) {
            var $formContact = $(this);
            var type = $(this).find('input[name="type"]').val();
            if ($formContact.length) {
                $formContact.submit(function (e) {
                    e.preventDefault();
                    var action = type;
                    window.grecaptcha.execute(SITE_KEY_GOOGLE, {action: action}).then(function (token) {
                        var $recaptchaAction = $('#recaptcha_action');
                        var $recaptchaToken = $('#recaptcha_token');
                        if ($recaptchaAction.length) {
                            $recaptchaAction.val(action);
                        } else {
                            $formContact.append('<input type="hidden" name="recaptcha_action" id="recaptcha_action" value="' + action + '" />');
                        }
                        if ($recaptchaToken.length) {
                            $recaptchaToken.val(token);
                        } else {
                            $formContact.append('<input type="hidden" name="recaptcha_token" id="recaptcha_token" value="' + token + '" />');
                        }
                        $formContact.unbind('submit');
                    });
                });
            } // End if
        });
    })
}

$(document).ready(function () {
    //submitNewsletterForm();
});


// var onloadCallback = function() {
//     console.log("grecaptcha is ready!");

//     $( ".frm_check_recaptcha" ).each(function( index ) {        
//         var $formContact = $(this);
//         var type = $(this).find('input[name="type"]').val();

//         if ($formContact.length) {
//             $formContact.submit(function (e) {
//                 e.preventDefault();
//                 var action = type;
                
//                 window.grecaptcha.execute(SITE_KEY_GOOGLE, {action: action}).then(function (token) {
//                     var $recaptchaAction = $('#recaptcha_action');
//                     var $recaptchaToken = $('#recaptcha_token');
//                     if ($recaptchaAction.length) {
//                         $recaptchaAction.val(action);
//                     } else {
//                         $formContact.append('<input type="hidden" name="recaptcha_action" id="recaptcha_action" value="' + action + '" />');
//                     }
//                     if ($recaptchaToken.length) {
//                         $recaptchaToken.val(token);
//                     } else {
//                         $formContact.append('<input type="hidden" name="recaptcha_token" id="recaptcha_token" value="' + token + '" />');
//                     }
//                     $formContact.unbind('submit');//.submit();
//                 });
//             });
//         } // End if
//     });
// };

function ChangeDeliveryPrice(){
    var price_insurance = $('input[name="insurance-temp"]').val();
    $('.delivery_option').each(function(){
        var original_price = $(this).find('.delivery_option_price').attr('data-price-original');
        var full_price = parseInt(original_price)+parseInt(price_insurance);
        $(this).find('.delivery_option_price').text(full_price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")+'đ');
    });
}


// $(window).on('load', function () {
//     if($('.frm_check_recaptcha').exists()){
//         $.ajax({
//             url:'ajax/ajax-js',
//             type: "GET",
//             dataType: 'html',
//             success: function(result){
//                 if(result) {
//                     if($("#recaptcha_element").exists()) {
//                         $('#recaptcha_element').html(result);
//                     }
//                 }
//             }
//         });
//     }    
// });



function ShipCart(){
    var ship = $(".price-ship").val();

    $.ajax({
        type: "POST",
        url:'ajax/ajax-cart',
        dataType: 'json',
        data: {cmd:'ship-cart',ship:ship, _token:$('input[name="_token"]').val()},
        success: function(result){
            if(result){
                $('.price-temp').val(result.temp);
                $('.load-price-temp').html(result.tempText);
                $('.price-total').val(result.total);
                $('.coupon-temp').val(result.sotien_duocgiam);
                $('.load-price-total').html(result.totalText);
                $('input[name="insurance-temp"]').val(result.insurance_temp);
            }
        }
    });
}

function ChangeUrlBrowser(urlNew){
    const nextURL = urlNew;
    const nextTitle = '';
    const nextState = {};
    // This will create a new entry in the browser's history, without reloading
    //window.history.pushState(nextState, nextTitle, nextURL);

    // This will replace the current entry in the browser's history, without reloading
    window.history.replaceState(nextState, nextTitle, nextURL);
}