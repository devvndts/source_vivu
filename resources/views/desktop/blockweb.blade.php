<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{ asset('public/css/tailwind.css') }}" rel="stylesheet">
</head>

<body class="bg-[#fef1ef]">
    <div>
        <div class="max-w-[1366px] mx-auto relative overflow-x-hidden">
            <img class="w-full hidden lg:inline-block" src="{{ asset('img/coming-soon.png') }}" alt="">
            <img class="w-full lg:hidden" src="{{ asset('img/coming-soon-mobile.png') }}" alt="">
            <div class="wrap-countdown mercado-countdown absolute lg:left-60 bottom-1/4 flex justify-center w-full lg:block" data-expire="2022/08/07 23:59:59"></div>
        </div>
    </div>
    @if (config('app.env') == 'local')
        <script src="//localhost:35729/livereload.js"></script>
    @endif
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
    <script>
        ;
        (function($) {

            var MERCADO_JS = {
                init: function() {
                    this.mercado_countdown();

                },
                mercado_countdown: function() {
                    if ($(".mercado-countdown").length > 0) {
                        $(".mercado-countdown").each(function(index, el) {
                            var _this = $(this),
                                _expire = _this.data('expire');
                            _this.countdown(_expire, function(event) {
                                $(this).html(event.strftime(
                                    '<span class="counter2 font-body"><b>%D</b> Ngày</span> <span class="counter2 font-body"><b>%-H</b> Giờ</span> <span class="counter2 font-body"><b>%M</b> Phút</span> <span class="counter2 font-body"><b>%S</b> Giây</span>'
                                    ));
                            });
                        });
                    }
                },
            }

            window.onload = function() {
                MERCADO_JS.init();
            }

        })(window.Zepto || window.jQuery, window, document);
    </script>
</body>

</html>
