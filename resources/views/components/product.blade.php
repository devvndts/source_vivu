{{-- @php
    if (is_array($item)) {
        $url = $item[$sluglang];
        $name = $item["ten".$lang];
        $img = Thumb::Crop(UPLOAD_PRODUCT,$item['photo'],240,240,1,$item['type']);

        $ajaxGiamoi = $item['giamoi'];
        $ajaxGia = $item['gia'];
        $ajaxGiakm = $item['giakm'];
    } else {
        $url = $item->{$sluglang};
        $name = $item->{"ten".$lang};
        $img = Thumb::Crop(UPLOAD_PRODUCT, $item->photo,240,240, 1, $item->type);

        $ajaxGiamoi = $item->giamoi;
        $ajaxGia = $item->gia;
        $ajaxGiakm = $item->giakm;
    }
    
@endphp

<div class="box-product-item group flex flex-col {{ $attributes['class'] }}" {{ $attributes }}>
    @if (isset($isCource) && $isCource)
        <a href="{{ $url }}" class="relative block overflow-hidden bg-no-repeat bg-cover rounded-md overflow-hidden">
            <img src="{{ $img }}" class="w-full transition duration-300 ease-in-out group-hover:scale-110" alt="{{ $name }}">
        </a>
    @else
        <a href="{{ $url }}" class="relative block overflow-hidden bg-no-repeat bg-cover aspect-w-1 aspect-h-1 rounded-md">
            <img src="{{ $img }}" class="object-cover object-center w-full transition duration-300 ease-in-out hover:scale-110" alt="{{ $name }}">
        </a> 
    @endif
    
    <div>
        <h3 class="mt-3 px-4 text-lg font-bold line-clamp-2">
            <a class="text-black transition-all group-hover:text-primary" href="{{ $url }}">
                {{ $name }}
            </a>
        </h3>
    </div>
</div> --}}