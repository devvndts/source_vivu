@props(['data' => null])
<div class="flex flex-wrap  gap-4 align-baseline {{ $attributes['class'] }}" {{ $attributes }}>
    @if (@$title)
        <span class=" {{ $title->attributes['class'] }}" {{ $attributes }}>
            {{ $title }}
        </span>
    @endif
    @if ($data)
        @foreach ($data as $item)
            @php
                $url = $item->link;
                $img = UPLOAD_PHOTO . $item->photo;
            @endphp
            <a href="{{ $url }}" target="_blank" class="inline-flex items-center justify-center ">
                <x-shared.image class="max-h-[30px] " src="{{ $img }}" />
            </a>
        @endforeach
    @endif
</div>