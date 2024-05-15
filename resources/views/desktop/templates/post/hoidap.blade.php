<div class=" home-question">
    <div class="container max-w-screen-lg">
        <x-shared.subtitle title="{{ $title_crumb }}" />
        <div class="overflow-hidden rounded-xl ">
            @foreach ($posts as $item)
                @php
                    $name = $item->{"ten$lang"} ?? '';
                    $desc = $item->{"mota$lang"} ?? '';
                    $iden = sprintf('qa_%d', $item->id);
                @endphp
                <x-shared.collapse target="{{ $iden }}" title="{{ $name }}" >
                    {!! $desc !!}
                </x-shared.collapse>
            @endforeach
        </div>
    </div>
</div>

<!--css thêm cho mỗi trang-->
@push('css_page')

@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')

@endpush