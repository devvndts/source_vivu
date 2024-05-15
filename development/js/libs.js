$('.way-wow').addClass('hidden');
$('.way-wow').waypoint(function(direction) {
  myfunc_zoomIn(this.element, direction);
},{offset:'80%'});

function scrollTO_ex(id){
    $("html, body").animate({ scrollTop: $(id).offset().top  }, 900);
}
$(document).ready(function() {
  $(".widget-toc a").each(function(){
    $(this).attr("href",_curl+$(this).attr("href"));
  });
  $('#btnchiduong').click(function(e){
    $('.toolbar__list').toggleClass("active");
    return false;

  });
  $('.hoverhori').hover(function() {
      var vitri = $(this).position().top;
      $('.hoverhori> ul').css({
        'top': vitri + 'px'
      })
    });
  setTimeout(function(){
    $(".wap_load").fadeOut(1000);
  },1000);
});

var radius = 200; // adjust to move out items in and out 
// container width bao nhieu thì radius = 1/2
var fields = $('.rotate-item'),
  container = $('#rotate_container'),
  width = container.width(),
  height = container.height();
var angle = 0,
  step = (2 * Math.PI) / fields.length;
fields.each(function() {
  var x = Math.round(width / 2 + radius * Math.cos(angle) - $(this).width() / 2);
  var y = Math.round(height / 2 + radius * Math.sin(angle) - $(this).height() / 2);
  if (window.console) {
    console.log($(this).text(), x, y);
  }
  $(this).css({
    left: x + 'px',
    top: y + 'px'
  });
  angle += step;
});