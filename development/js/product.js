     var mzOptions = {
      zoomMode:true,
      zoomPosition: 'inner ',
      onExpandClose: function(){MagicZoom.refresh();}
    };
    $(document).ready(function() {
      $('.slick2').slick({
        slidesToShow: 1, 
        slidesToScroll: 1, 
        arrows: true, 
        fade: true, 
        autoplay:false, 
        autoplaySpeed:5000, 
        asNavFor: '.slick'
      });
      $('.slick').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        asNavFor: '.slick2',
        dots: false,
        arrows: false, 
        centerMode: false,
        focusOnSelect: true,
        vertical: true,
        responsive: [
        {
          breakpoint: 800,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          }
        },
        {
          breakpoint: 376,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          } 
        } 
        ] 
      });
      
      var giatri_default = js_num_danhgiasao;
      $('.danhgiasao span:lt('+giatri_default+')').addClass('active');
      $('.danhgiasao span').hover(function(){
        var giatri = $(this).data('value');
        $('.danhgiasao span').removeClass('hover');
        $('.danhgiasao span:lt('+giatri+')').addClass('hover');
      },function(){
        $('.danhgiasao span').removeClass('hover');
      });
      $('.danhgiasao span').click(function(){
        var url = $('.danhgiasao').data('url');
        var giatri = $(this).data('value');
        var idsp = $(this).data('id');
        $.ajax({
          type:'post',
          url:'ajax/danhgiasao.php',
          data:{idsp:idsp,giatri:giatri,url:url},
          success:function(kq){
            if(kq==1){
              $('.danhgiasao span:lt('+giatri+')').addClass('active');
              alert(lang_bandanhgia+': '+giatri+'/5');
              $('.num_danhgia').html(+giatri+'/5');
            }
            else if(kq==2){
              alert(lang_danhgiaroi);
            }
            else{
              alert(lang_hethongloi);
            }
          }
        });
      });
    });
