$(document).ready(function() {
  $('.pro-cate-main').on({
        beforeChange: function(event, slick, currentSlide, nextSlide) {
            myLazyLoad.update();
        }
    }).slick({
        lazyLoad: 'ondemand',
        infinite: true,
        accessibility: false,
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: js_autoplay,
        autoplaySpeed: 3000,
        speed: 1000,
        arrows: true,
        centerMode: false,
        dots: false,
        draggable: true,
        responsive: [{
            breakpoint: 850,
            settings: {
                slidesToShow: 4
            }
        },{
            breakpoint: 500,
            settings: {
                slidesToShow: 3
            }
        },{
            breakpoint: 330,
            settings: {
                slidesToShow: 2
            }
        }]
    });
});