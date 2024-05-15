<!-- Slider main container -->
<div class="swiper swiper-name">
    <!-- Additional required wrapper -->
    <div class="swiper-wrapper">
        <!-- Slides -->
        <div class="swiper-slide">
            <img src="{{ Thumb::Crop($galPath, $v['photo'], 800, 400, 1, $v['com']) }}" alt="{{ $v['ten' . $lang] }}">
        </div>
    </div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div>

const swiperOpinion = new Swiper('.opinion-swiper-box', {
loop: true,
slidesPerView: 1,
// If we need pagination
pagination: {
el: '.swiper-pagination',
},
// Navigation arrows
navigation: {
nextEl: '.opinion-button-next',
prevEl: '.opinion-button-prev',
},
});
const swiperFlashslide = new Swiper('.flashslide-swiper-box', {
loop: true,
slidesPerView: 1,
// If we need pagination
pagination: {
el: '.flashslide-pagination',
},
// Navigation arrows
navigation: {
nextEl: '.flashslide-button-next',
prevEl: '.flashslide-button-prev',
},
});
const swiperAchievement = new Swiper('.achievement-swiper-box', {
loop: true,
slidesPerView: 4,
spaceBetween: 48,
// Navigation arrows
navigation: {
nextEl: '.swiper-button-next',
prevEl: '.swiper-button-prev',
},
breakpoints: {
// when window width is >= 320px
320: {
slidesPerView: 1,
},
// when window width is >= 480px
480: {
slidesPerView: 1,
},
// when window width is >= 640px
640: {
slidesPerView: 2,
},
// when window width is >= 640px
1024: {
slidesPerView: 4,
}
}
});
const swiperProject = new Swiper('.project-swiper-box', {
effect: 'fade',
fadeEffect: {
crossFade: true
},
loop: true,
slidesPerView: 1,
// Navigation arrows
navigation: {
nextEl: '.swiper-button-next',
prevEl: '.swiper-button-prev',
},
});
const swiperPartner2 = new Swiper('.partner-swiper-box', {
// Optional parameters
loop: true,
spaceBetween: 20,
slidesPerView: 5,
// Navigation arrows
pagination: {
el: '.swiper-pagination',
},
breakpoints: {
// when window width is >= 320px
320: {
slidesPerView: 2,
},
// when window width is >= 480px
480: {
slidesPerView: 2,
},
// when window width is >= 640px
640: {
slidesPerView: 3,
},
// when window width is >= 640px
1024: {
slidesPerView: 5,
}
}
});
const swiperNewsHome = new Swiper('.swiper-news-home', {
// Optional parameters
loop: true,
spaceBetween: 20,
slidesPerView: 3,
// Navigation arrows
navigation: {
nextEl: '.swiper-button-next',
prevEl: '.swiper-button-prev',
},
breakpoints: {
// when window width is >= 320px
320: {
slidesPerView: 1,
},
// when window width is >= 480px
480: {
slidesPerView: 1,
},
// when window width is >= 640px
640: {
slidesPerView: 2,
},
// when window width is >= 640px
1024: {
slidesPerView: 3,
}
}
});
const swiperPartner = new Swiper('.swiper-partner-home', {
// Optional parameters
loop: true,
spaceBetween: 40,
slidesPerView: 2,
// If we need pagination
pagination: {
el: '.swiper-partner-home-pagination',
type: "fraction",

formatFractionCurrent: function (number) {
let formattedNumber = number.toLocaleString('en-US', {
minimumIntegerDigits: 2,
useGrouping: false
})
return formattedNumber
},
formatFractionTotal: function (number) {
let formattedNumber = number.toLocaleString('en-US', {
minimumIntegerDigits: 2,
useGrouping: false
})
return formattedNumber
},
renderFraction: function (currentClass, totalClass) {
return '<span class="text-base inline-block w-[20px] text-[#B3B3B3] ' + currentClass + '"></span>' + ' <span
    class="text-[#B3B3B3]">/</span> ' + '<span class="text-xs text-secondary ' + totalClass + '"></span>';
}
},

// Navigation arrows
navigation: {
nextEl: '.swiper-partner-home-button-next',
prevEl: '.swiper-partner-home-button-prev',
},
breakpoints: {
// when window width is >= 320px
320: {
spaceBetween: 20
},
// when window width is >= 480px
480: {
spaceBetween: 30
},
// when window width is >= 640px
640: {
spaceBetween: 30
}
}
});
const swiper = new Swiper('.swiper-product-home', {
// Optional parameters
loop: true,
// initialSlide: -1,
// slidesOffsetAfter: 40,
// slidesOffsetBefore: 80,
spaceBetween: 40,
slidesPerView: 3,
// If we need pagination
pagination: {
el: '.swiper-product-home-pagination',
type: "fraction",

formatFractionCurrent: function (number) {
let formattedNumber = number.toLocaleString('en-US', {
minimumIntegerDigits: 2,
useGrouping: false
})
return formattedNumber
},
formatFractionTotal: function (number) {
let formattedNumber = number.toLocaleString('en-US', {
minimumIntegerDigits: 2,
useGrouping: false
})
return formattedNumber
},
renderFraction: function (currentClass, totalClass) {
return '<span class="text-base inline-block w-[20px] text-[#B3B3B3] ' + currentClass + '"></span>' + ' <span
    class="text-[#B3B3B3]">/</span> ' + '<span class="text-xs text-secondary ' + totalClass + '"></span>';
}
},

// Navigation arrows
navigation: {
nextEl: '.swiper-product-home-button-next',
prevEl: '.swiper-product-home-button-prev',
},
breakpoints: {
// when window width is >= 320px
320: {
spaceBetween: 20,
slidesPerView: 2,
},
// when window width is >= 480px
480: {
spaceBetween: 30,
slidesPerView: 3,
},
// when window width is >= 640px
640: {
spaceBetween: 30
},
992: {
spaceBetween: 40,
slidesOffsetBefore: 80,
slidesPerView: 2.2,
}
}
});
const swiperService = new Swiper('.swiper-service-home', {
// Optional parameters
loop: true,
// initialSlide: -1,
// slidesOffsetAfter: 40,
// slidesOffsetBefore: 80,
spaceBetween: 120,
slidesPerView: 1.3,
// If we need pagination
pagination: {
el: '.swiper-service-home-pagination',
type: "fraction",

formatFractionCurrent: function (number) {
let formattedNumber = number.toLocaleString('en-US', {
minimumIntegerDigits: 2,
useGrouping: false
})
return formattedNumber
},
formatFractionTotal: function (number) {
let formattedNumber = number.toLocaleString('en-US', {
minimumIntegerDigits: 2,
useGrouping: false
})
return formattedNumber
},
renderFraction: function (currentClass, totalClass) {
return '<span class="text-base inline-block w-[20px] text-[#B3B3B3] ' + currentClass + '"></span>' + ' <span
    class="text-[#B3B3B3]">/</span> ' + '<span class="text-xs text-secondary ' + totalClass + '"></span>';
}
},

// Navigation arrows
navigation: {
nextEl: '.swiper-service-home-button-next',
prevEl: '.swiper-service-home-button-prev',
},
breakpoints: {
// when window width is >= 320px
320: {
spaceBetween: 20
},
// when window width is >= 480px
480: {
spaceBetween: 30
},
// when window width is >= 640px
640: {
spaceBetween: 40
}
}
});
$('.cretiria-slick').slick(
{
lazyLoad: 'ondemand',
infinite: true,
arrows:true,
accessibility:false,
slidesToShow: 3,
slidesToScroll: 1,
autoplay: JS_AUTOPLAY,
// appendDots: $(".home-partner-appendDots"),
autoplaySpeed:3000,
speed:1000,
centerMode:false,
// dots:true,
draggable:true,
responsive: [
{
breakpoint: 850,
settings: {
slidesToShow: 2
}
},
{
breakpoint: 430,
settings: {
slidesToShow: 1
}
}
]
});
$('.package-slick').slick(
{
lazyLoad: 'ondemand',
infinite: true,
arrows:true,
accessibility:false,
slidesToShow: 2,
slidesToScroll: 1,
autoplay: JS_AUTOPLAY,
// appendDots: $(".home-partner-appendDots"),
autoplaySpeed:3000,
speed:1000,
centerMode:false,
// dots:true,
draggable:true,
responsive: [
{
breakpoint: 850,
settings: {
slidesToShow: 2
}
},
{
breakpoint: 430,
settings: {
slidesToShow: 1
}
}
]
});
// $('.home-feedback-slick').slick(
// {
// lazyLoad: 'ondemand',
// infinite: true,
// accessibility:false,
// slidesToShow: 3,
// slidesToScroll: 1,
// autoplay: JS_AUTOPLAY,
// autoplaySpeed:3000,
// speed:1000,
// arrows:true,
// nextArrow: '<button type="button" class="slick-next xl:!-right-14">Next</button>',
// prevArrow: '<button type="button" class="slick-prev xl:!-left-14">Previous</button>',
// centerMode:false,
// dots:false,
// draggable:true,
// responsive: [
// {
// breakpoint: 1030,
// settings: {
// slidesToShow: 2
// }
// },{
// breakpoint: 600,
// settings: {
// slidesToShow: 2
// }
// },
// {
// breakpoint: 430,
// settings: {
// slidesToShow: 1
// }
// }
// ]
// });
// $('.home-feature-product-slick').slick(
// {
// lazyLoad: 'ondemand',
// infinite: true,
// accessibility:false,
// slidesToShow: 4,
// slidesToScroll: 1,
// autoplay: JS_AUTOPLAY,
// autoplaySpeed:3000,
// speed:1000,
// arrows:true,
// nextArrow: '<button type="button" class="slick-next xl:!-right-14">Next</button>',
// prevArrow: '<button type="button" class="slick-prev xl:!-left-14">Previous</button>',
// centerMode:false,
// dots:false,
// draggable:true,
// responsive: [
// {
// breakpoint: 1030,
// settings: {
// slidesToShow: 3
// }
// },{
// breakpoint: 600,
// settings: {
// slidesToShow: 2
// }
// },
// {
// breakpoint: 430,
// settings: {
// slidesToShow: 2
// }
// }
// ]
// });
// $('.home-project-slick').slick(
// {
// lazyLoad: 'ondemand',
// infinite: true,
// accessibility:false,
// slidesToShow: 1,
// slidesToScroll: 1,
// autoplay: JS_AUTOPLAY,
// autoplaySpeed:3000,
// speed:1000,
// arrows:true,
// prevArrow: '<button type="button" class="slick-prev !left-2 md:!-left-5 !top-1/4 md:!top-1/2">Previous</button>',
// nextArrow: '<button type="button"
    class="slick-next !right-2 md:!left-1/2 md:-ml-5 !top-1/4 md:!top-1/2">Next</button>',
// centerMode:false,
// dots:false,
// draggable:true,
// });
// $('.home-product-slick').slick(
// {
// lazyLoad: 'ondemand',
// infinite: true,
// accessibility: false,
// slidesToShow: 4,
// // slidesToScroll: 1,
// swipeToSlide: true,
// autoplay: JS_AUTOPLAY,
// autoplaySpeed: 3000,
// speed: 1000,
// arrows: true,
// appendArrows: $(".home-product-appendArrows"),
// nextArrow: '<button type="button" class="slick-next !right-0">Next</button>',
// prevArrow: '',
// centerMode: false,
// dots: false,
// // vertical: true,
// // verticalswipe: true,
// draggable: true,
// responsive: [
// {
// breakpoint: 1030,
// settings: {
// slidesToShow: 3
// }
// },{
// breakpoint: 600,
// settings: {
// slidesToShow: 2
// }
// },
// {
// breakpoint: 430,
// settings: {
// slidesToShow: 2
// }
// }
// ]
// });
