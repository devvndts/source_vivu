@php
    $duanCategories = get_categories('du-an', $lang, ["query" => ["level" => "0"]]);
@endphp
<div class="home-project bg-[#081152] bg-opacity-5 py-12">
    <div class="container max-w-screen-lg">
        @isset($duanCategories)
        <div class="flex flex-wrap justify-center mb-6">
            @foreach ($duanCategories as $item)
                @php
                    $name = $item->{"ten$lang"} ?? '';
                    $url = $item->{$sluglang} ?? '';
                @endphp
                <div class="w-1/2 my-2 md:mx-3 md:w-auto">
                    <x-shared.readmore class="js-project-category [.active&]:bg-white [.active&]:text-primary-500" href="{{ url($url) }}" :title=$name />
                </div>
            @endforeach
        </div>
        @endisset
        <div class="grid grid-cols-2 gap-5 lg:grid-cols-3">
            @foreach ($posts as $item)
                @php
                    $name = $item->{"ten$lang"} ?? '';
                    $desc = $item->{"mota$lang"} ?? '';
                    $url = $item->{$sluglang} ?? '';
                    $img = Thumb::Crop(UPLOAD_POST, $item->photo, 320, 250, 1, null, 'png');
                @endphp
                <div class="group">
                    <a class="block text-center" href="{{ $url }}">
                        <figure class="relative mb-4 overflow-hidden">
                            <x-shared.image class="w-full" src="{{ $img }}" />
                            <div
                                class="absolute top-0 left-0 flex items-center justify-center w-full h-full transition-all duration-200 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100">
                                <x-shared.readmore class="[&]:w-fit [&]:mx-auto transition-all duration-200 "
                                    title="{{ __('Xem thêm') }}" />
                            </div>
                        </figure>
                        <h2 class="md:text-xl text-base mt-[10px] mb-2 font-semibold uppercase text-secondary-500 line-clamp-2">
                            {{ $name }}</h2>
                        <div class="text-sm text-[#5E6572] line-clamp-2">{{ $desc }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
<!--js thêm cho mỗi trang-->
@push('js_page')
<script>
    $(document).ready(function() {
        currLoc = $(location).attr('href');
        $('.js-project-category').removeClass('active');
        $(`.js-project-category[href="${currLoc}"]`).addClass('active');
    })
</script>
@endpush