/* -----------------------------------------------
/* How to use? : Check the GitHub README
/* ----------------------------------------------- */

/* To load a config file (particles.json) you need to host this demo (MAMP/WAMP/local)... */

$(document).ready(function(){
  var e_page = $('#particles-js');
  var random_type = Math.floor((Math.random() * 5) + 1);
  var random_bg = Math.floor((Math.random() * 2) + 1);
  var page_type = 'default.json';

  //random_type = 2;
  switch(random_type) {
    case 1:
      page_type = 'bubble.json';
      //e_page.css("background","#fafafa");
      e_page.css('background-image', 'url(../img/admin/bubble'+random_bg+'.jpg)');
      break;
    case 2:
      page_type = 'nasa.json';
      //e_page.css("background","#fafafa");
      e_page.css('background-image', 'url(../img/admin/nasa'+random_bg+'.jpg)'); 
      break;
    case 3:
      page_type = 'snow.json';
      //e_page.css("background","#fafafa");
      e_page.css('background-image', 'url(../img/admin/snow'+random_bg+'.jpg)');
      break;
    case 4:
      page_type = 'star.json';
      //e_page.css("background","#fafafa");
      e_page.css('background-image', 'url(../img/admin/star'+random_bg+'.jpg)');
      break;
    default:
      page_type = 'default.json';
  }

  particlesJS.load('particles-js', '../js/particle/json/'+page_type, function() {
    console.log('particles.js loaded - callback : '+page_type);
  });
});
