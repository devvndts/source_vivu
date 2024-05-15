$(document).ready(function() {
     $('body').append('<div id="toptop" title="Lên đầu trang"><i class="fas fa-arrow-circle-right"></i></div>');
     $(window).scroll(function() {
      if($(window).scrollTop() != 0){
        $('#toptop').fadeIn();
      }else {
        $('#toptop').fadeOut();
      }
     });

     $('#toptop').click(function() {
      $('html, body').animate({scrollTop:0},500);
     });
});