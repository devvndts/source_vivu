<div class="container max-w-[1390px] gap-5 mt-3 flex flex-wrap justify-between items-start" id="child_content">
    <x-shared.readmore id="child_content_button" class="hidden bottom-[280px] right-[20px] z-50 justify-center cursor-pointer" data-hs-overlay="#hs-basic-modal" title="{{ __('Đăng ký ngay') }}" />
    <div class="w-full xl:flex-1 xl:w-auto">
        <div >
            <nav class="flex gap-8 p-7 items-center bg-[#F5F5F5]" aria-label="Tabs" role="tablist">
                <button type="button"
                    class="hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary   inline-flex items-center gap-2 border-b-[1px] border-transparent text-base xl:text-3xl whitespace-nowrap text-gray-500 hover:text-primary font-title active uppercase "
                    id="tabs-with-underline-item-1" data-hs-tab="#tabs-with-underline-1"
                    aria-controls="tabs-with-underline-1" role="tab">
                    description
                </button>
                {{-- <hr class="w-[2px] hidden md:block h-5 border-0 bg-[#404040] mx-8">
                <button type="button"
                    class="hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary   inline-flex items-center gap-2 border-b-[1px]  border-transparent text-base xl:text-3xl whitespace-nowrap text-gray-500 hover:text-primary font-title uppercase"
                    id="tabs-with-underline-item-2" data-hs-tab="#tabs-with-underline-2"
                    aria-controls="tabs-with-underline-2" role="tab">
                    overview
                </button>
                <hr class="w-[2px]  hidden md:block h-5 border-0 bg-[#404040] mx-8">
                <button type="button"
                    class="hs-tab-active:font-semibold hs-tab-active:border-primary hs-tab-active:text-primary   inline-flex items-center gap-2 border-b-[1px] border-transparent text-base xl:text-3xl font-title whitespace-nowrap text-gray-500 hover:text-primary uppercase "
                    id="tabs-with-underline-item-3" data-hs-tab="#tabs-with-underline-3"
                    aria-controls="tabs-with-underline-3" role="tab">
                    reviews
                </button> --}}
            </nav>
        </div>

        <div class="mt-3">
            <div id="tabs-with-underline-1" role="tabpanel" aria-labelledby="tabs-with-underline-item-1">
                {!! $data['description'] !!}
            </div>
            {{-- <div id="tabs-with-underline-2" class="hidden" role="tabpanel" aria-labelledby="tabs-with-underline-item-2">
                {!! $data['overview'] !!}
            </div>
            <div id="tabs-with-underline-3" class="hidden" role="tabpanel" aria-labelledby="tabs-with-underline-item-3">
                {!! $data['reviews'] !!}
            </div> --}}
        </div>
    </div>

    <div class="w-full xl:w-1/3 border bg-white p-3 rounded-md border-gray-400">
        <div style="background-image: url({{ Thumb::Crop(UPLOAD_PRODUCT, $row_detail['photo2'] ?? '', 430, 300, 1) }})" class="aspect-w-6 overflow-hidden aspect-h-4 rounded-md bg-cover bg-no-repeat">
            {{-- <iframe src="https://www.youtube.com/embed/{{ Helper::getYoutube($data['sl_options']['link_youtube_dangky'] ?? '') }}"
                class="absolute inset-0 w-full h-full" allowfullscreen></iframe> --}}
        </div>
        <div class="divide-y">
            @foreach ($data['thongsokythuat'] as $item)
                @php
                    $name = $item["ten$lang"] ?? '';
                    $description = $item["mota$lang"] ?? '';
                @endphp
                <div class="flex justify-between flex-wrap items-center py-2">
                    <div class="flex-1 flex gap-4 items-center">
                        <img src="public/pts/list-icon.png" alt="list">
                        <strong class="text-lg">{{ $name }}</strong>
                    </div>
                    <span class="text-base">{{ $description }}</span>
                </div>
            @endforeach
        </div>
        <x-shared.readmore class="mt-2 justify-center w-full cursor-pointer" data-hs-overlay="#hs-basic-modal" title="{{ __('Đăng ký ngay') }}" />
        <div class="flex justify-center gap-4 mt-2 flex-wrap">
            <span class="text-base">Share:</span>
            <a href=""><img src="public/pts/Twitter.png" alt="Twitter"></a>
            <a href=""><img src="public/pts/TikTok.png" alt="TikTok"></a>
            <a href=""><img src="public/pts/Facebook.png" alt="Facebook"></a>
            <a href=""><img src="public/pts/Pinterest.png" alt="Pinterest"></a>
            <a href=""><img src="public/pts/LinkedIn.png" alt="LinkedIn"></a>
        </div>
    </div>
</div>
@push('js_page')
        <script>
            $(document).ready(function() {
                $(window).scroll(function() {
                    var element = $('#child_content');
                    var elementOffset = element.offset().top + element.outerHeight();
                    var windowOffset = $(window).scrollTop() + $(window).height();

                    if (windowOffset > elementOffset) {
                        $('#child_content_button').removeClass('hidden');
                        $('#child_content_button').addClass('fixed');
                    } else {
                        $('#child_content_button').removeClass('fixed');
                        $('#child_content_button').addClass('hidden');

                    }
                });
            });
        </script>
    @endpush