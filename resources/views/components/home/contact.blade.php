<div class="py-[83px]">
    <div class="container max-w-screen-xl mx-auto">
        <div class="font-title text-2xl lg:text-[40px] flex justify-center items-center gap-1 revealOnScroll flex-wrap text-primary" data-animation="animate__zoomIn" timeout="500">
            Đến gặp <img src="img/yodiva.png" alt=""> hôm nay nha
        </div>
        <div class="my-10 text-xl font-medium text-center uppercase">
            <p>thứ 2 - thứ 6: 11am - 7pm</p>
            <p>thứ 7 - chủ nhật: 10am - 8pm</p>
        </div>
        <div class="flex flex-wrap justify-center gap-4 revealOnScroll" data-animation="animate__zoomIn" timeout="500">
            @php
                $url = url('lien-he');
                $url2 = url('dich-vu');
            @endphp
            <x-shared.readmore class="lg:w-[300px] justify-center text-center" href="{{ $url }}" title="{{ __('Đặt lịch hẹn') }}" ></x-shared.readmore>
            <x-shared.readmore class="lg:w-[300px] justify-center text-center" href="{{ $url2 }}" title="{{ __('Xem dịch vụ') }}" ></x-shared.readmore>
        </div>
    </div>
</div>