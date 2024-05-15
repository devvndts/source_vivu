@php
    $feedback = get_posts('feedback', $lang, ['order_by' => ['stt' => 'asc']]);
@endphp
    <div class="container max-w-screen-lg my-4">
        <x-shared.subtitle title="{{ $title_crumb }}" />
        @if (isset($feedback) && $feedback)
            @foreach ($feedback as $item)
            @php
                $name = $item->{"ten$lang"} ?? '';
                $desc = $item->{"mota$lang"} ?? '';
                $img = Thumb::Crop(UPLOAD_POST, $item->photo, 500, 500, 1, null, 'png');
            @endphp
                <div class="flex flex-wrap items-start justify-between mb-7 group">
                    <figure class="w-full mb-4 overflow-hidden md:group-even:order-2 md:mb-0 md:w-1/2 rounded-3xl">
                        <x-shared.image class="w-full" src="{{ $img }}" />
                    </figure>
                    <div class="w-full md:w-1/2 md:group-odd:pl-5 md:group-even:pr-5 ">
                        <div class="relative md:pl-16">
                            <x-shared.image class="absolute left-0 hidden md:inline-block" src="{{ asset('public/pts/Vector.png') }}" />
                            <div class="mb-5 text-sm font-light">
                                {{ $desc }}
                            </div>
                            <div class="mb-5 text-lg font-semibold">{{ $name }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <x-alerts.alerts type="warning">
                <strong>{{ __('Thông báo') }}:</strong> {{ __('Không tìm thấy kết quả') }}
            </x-alerts.alerts>
        @endif
    </div>

<!--css thêm cho mỗi trang-->
@push('css_page')
@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')
@endpush
