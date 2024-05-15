if(js_deviceType == "computer"){
  new WOW().init();
}
function add_popup(str){
  $('body').append('<div class="login-popup" style="width:300px;"><div class="close-popup">x</div>'+
    '<div class="popup_thongbao"><p class="tieude_tb">'+lang_thongbao+'</p><p class="popup_kq">'+str+'</p></div></div>');
  $('.thongbao').html('');
  $('.login-popup').fadeIn(300);
  $('body').append('<div id="baophu"></div>');
  $('#baophu').fadeIn(300);
  return false;
}
  function myfunc_zoomIn(target, direction){
      if(direction === "down"){
        $(target).removeClass("hidden");
        $(target).addClass("animated zoomIn");
        setTimeout(function(){
            $(target).removeClass("animated zoomIn");
        }, 1000);
      }
    }
    
var myLazyLoad = new LazyLoad({
 elements_selector: ".lazy"
});
function loadData(page,id_tab,loai){
  $.ajax({
    type: "POST",
    dataType:'json',
    url: "ajax/paging_ajax/ajax_paging.php",
    data: {page:page,id_danhmuc:loai},
    success: function(msg)
    {
      $(id_tab+' .pagination').remove();
      $(id_tab+' .product-grid').html(msg.spthem);
      $(id_tab).append(msg.morebtn);
      myLazyLoad.update();
      $(id_tab+" .pagination li.active").click(function(){
        var pager = $(this).attr("p");
        var id_danhmucr = $(this).parents().parents().parents().attr("data-rel");
        loadData(pager,id_tab,id_danhmucr);
      });  
    }
  });
}
$(document).ready(function() {
  $(".various").fancybox({
      maxWidth  : 800,
      maxHeight : 600,
      fitToView : false,
      width   : '70%',
      height    : '70%',
      autoSize  : false,
      closeClick  : false,
      openEffect  : 'none',
      closeEffect : 'none'
    });
  $.fancybox.open($('#popup_box'));
  $('.hoverhori').hover(function() {
      var vitri = $(this).position().top;
      $('.hoverhori> ul').css({
        'top': vitri + 'px'
      })
    });
  $( "a.scrollLink" ).click(function( event ) {
        event.preventDefault();
        $("html, body").animate({ scrollTop: $($(this).attr("href")).offset().top - 100 }, 500);
    });
     $('.chatface').click(function(){
         $('#khungchatn').toggle(300);
     });
    $(document).on('click','#baophu, .close-popup,.ttmh',function(){
        $('#baophu,.popup_donhang,.login-popup').animate({left:'-100%'},500);
        setTimeout(function(){
            $('#baophu,.wap_giohang,.login-popup').remove()
        }, 700);
    });

  $('.slider-main').slick({
    lazyLoad: 'ondemand',
    infinite: true,
    accessibility:false,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay:true,
    autoplaySpeed:3000,
    speed:1000,
    arrows:true,
    centerMode:false,
    dots:false,
    draggable:true,
  });
    $(".video-khac a").click(function(a) {
     $("#iframe").attr("src", "https://www.youtube.com/embed/" + $(this).data("val") + "?autoplay=1"), a.preventDefault()
    });
    $('#lstvideo').change(function(){
     $("#iframe").attr("src","//www.youtube.com/embed/"+$(this).val()+"?autoplay=1");
    }); 
    $('img').each(function(index, element) {
     if(!$(this).attr('alt') || $(this).attr('alt')=='')
     {
      $(this).attr('alt',lang_tencty);
    }
  });
  if ($(document.body).height() < $(window).height()) {
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id; js.async=true;
      js.src = "//connect.facebook.net/"+js_langfb+"/sdk.js#xfbml=1&version=v2.8";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    $(".codebando").html(js_bando);
    if(js_linkvideo){ 
      $("#video-idx").html('<iframe id="iframe" src="https://www.youtube.com/embed/'+js_linkvideo+
    '" frameborder="0" allowfullscreen></iframe>');
    }
  }else{
    var fired = false;
    window.addEventListener("scroll", function(){
      if ((document.documentElement.scrollTop != 0 && fired === false) || (document.body.scrollTop != 0 && fired === false)) {
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id; js.async=true;
          js.src = "//connect.facebook.net/"+js_langfb+"/sdk.js#xfbml=1&version=v2.8";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        $(".codebando").html(js_bando);
        if(js_linkvideo){ 
          $("#video-idx").html('<iframe id="iframe" src="https://www.youtube.com/embed/'+js_linkvideo+
        '" frameborder="0" allowfullscreen></iframe>');
        }
        fired = true;
      }
    }, true);
  };
  if(js_deviceType == "computer"){
    $(window).scroll(function(){
      // var cach_top = $(window).scrollTop();
      // var heaigt_header = $('.header').height();
      // if(cach_top >= heaigt_header){
      //   $('.nav-bg').css({position: 'fixed', top: '0px', zIndex:99999});
      //   $('.nav-bg').addClass('fixed');
      // }else{
      //   $('.nav-bg').css({position: 'relative', top: '0px'});
      //   $('.nav-bg').removeClass('fixed');
      // }
    });
  }
  
});

