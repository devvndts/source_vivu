  $('.main_manu_valak ul li').each(function(index, el) {
    if($(this).children("ul").length) {
      $(this).prepend('<div class="btn_expand_menu_valak"></div>');
    }
  });
  $(document).on('click', '#humber_valak', function(event) {
    event.preventDefault();
    $("#valak_openmmenu").addClass('expand_menu');
  });
  $(document).on('click', '#close_valak', function(event) {
    event.preventDefault();
    $("#valak_openmmenu").removeClass('expand_menu');
  });
  $(document).on('click', '.btn_expand_menu_valak', function(event) {
    event.preventDefault();
    if($(this).hasClass('more')) {
      $(this).removeClass('more');
    }
    else {
      $(this).addClass('more');
    }
    $(this).parent('li').children('ul').toggle();
  });
  $(window).scroll(function() {
    if($(window).scrollTop() >= $(".header").height()) 
    {
      $("#valak_mmenu").css({position:"fixed",left:'0px',right:'0px',top:'0px',zIndex:'999'});
    }
    else
    {
      $("#valak_mmenu").css({position:"relative"});
    }
  });