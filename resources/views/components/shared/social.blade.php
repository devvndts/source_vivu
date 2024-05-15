@props(['data' => null])
<div class=" {{ $attributes['class'] }}" {{ $attributes }}>
    @if (@$title)
        <span class=" {{ $title->attributes['class'] }}" {{ $attributes }}>
            {{ $title }}
        </span>
    @endif
    @if ($data)
        @foreach ($data as $item)
            @php
                $url = $item->link;
                $name = $item->{"ten$lang"};
                $img = Thumb::Crop(UPLOAD_PHOTO,$item->photo,30,30,2);
            @endphp
            <a href="{{ $url }}" target="_blank" class="flex items-center mb-4">
                <x-shared.image class="w-[24px] h-[24px]" src="{{ $img }}" />
                <span class="ml-[10px] text-white text-base">{{ $name }}</span>
            </a>
        @endforeach
    @endif
</div>