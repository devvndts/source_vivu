@php
    $sale = get_sales('sale','vi')->toArray();
    if (isset($sale[0]) && $sale[0]->hienthi) {
        $saleProducts = DB::table('sale_products')
        ->where('sale_products.sale_id', $sale[0]->id)
        ->join('product', 'sale_products.product_id', '=', 'product.id')
        ->select('product.*')
        ->get()->toArray();
    }
@endphp
@if (isset($sale[0]) && $sale[0]->hienthi && $sale[0]->sale_date > Carbon\Carbon::now() && (!empty($saleProducts)))
<div class="container my-9">
    <div class="bg-[#FBECD5] py-14 px-7">
        <div class="flex">
            <x-title class="mr-8"> 
                <x-slot name="title" class="!text-xl !text-left ml-0">FLASHSALE CHỚP NHOÁNG</x-slot>
                <x-slot name="desc" class="!text-sm !text-left ml-0 normal-case text-opacity-70 text-black">Sản phẩm sẽ trở về giá gốc khi hết giờ</x-slot>
            </x-title>
            <div class="wrap-countdown mercado-countdown" data-expire="{{ Carbon\Carbon::parse($sale[0]->sale_date)->format('Y/m/d h:i:s A') }}"></div>
        </div>
        <div class="flex flex-wrap -mx-4">
        @foreach ($saleProducts as $keyProduct => $itemProduct)
            <x-product :item="(array)$itemProduct" isFlashSale class="basis-[calc(100%/5)] px-2"></x-product>
        @endforeach
        </div>
    </div>
</div>
<!--js thêm cho mỗi trang-->
@push('js_page')
<script src="{{asset('js/jquery.countdown.min.js')}}"></script>
<script>
    ;(function($) {
    
    var MERCADO_JS = {
        init: function(){
        this.mercado_countdown();
        
    }, 
    mercado_countdown: function() {
        if($(".mercado-countdown").length > 0){
                $(".mercado-countdown").each( function(index, el){
                    var _this = $(this),
                    _expire = _this.data('expire');
                    _this.countdown(_expire, function(event) {
                        $(this).html( event.strftime('<span class="counter"><b>%D</b> Ngày</span> <span class="counter"><b>%-H</b> Giờ</span> <span class="counter"><b>%M</b> Phút</span> <span class="counter"><b>%S</b> Giây</span>'));
                    });
                });
            }
        },
    }
    
    window.onload = function () {
        MERCADO_JS.init();
    }
    
    })(window.Zepto || window.jQuery, window, document);
</script>
@endpush
@endif