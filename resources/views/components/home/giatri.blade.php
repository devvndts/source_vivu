@php
    $giaTri = get_posts('gia-tri', $lang, ['order_by' => ['stt' => 'asc']]);
@endphp
<div class="bg-[#F0F2F5] py-16 relative">
    <img src="public/pts/giatri.png" alt="giatri" class="absolute z-10 hidden md:inline-block left-0 xl:-top-[100px] xl:w-[354px] w-[200px] top-0">
    <div class="border-b border-primary pb-4 mb-4 md:mb-16 relative">
        <div class="bg-[#F0F2F5] h-[1px] w-[354px] absolute left-0 -bottom-[1px]"></div>
        <div class="container max-w-[1600px]">
            <x-shared.title class="text-right">
                <x-slot name="title">{{ __('GIÁ TRỊ VMO ACADEMY MANG LẠI') }}</x-slot>
            </x-shared.title>
        </div>
    </div>
    <div class="container max-w-[1600px]">
        <div class="flex flex-wrap justify-between">
            <div class="w-full md:w-[37%] pt-5 xl:pt-[100px]">
                <nav class="flex md:mx-5 xl:mx-12 flex-col space-y-2" aria-label="Tabs" role="tablist" data-hs-tabs-vertical="true">
                    @foreach ($giaTri as $item)
                        @php
                            $active = $loop->index == 0 ? 'active' : '';
                            $position = $loop->index + 1;
                            $name = $item->{"ten$lang"} ?? '';
                            // $photo = Thumb::Crop(UPLOAD_POST, $item->photo2 ?? '', 50, 30, 2);
                            $photo = UPLOAD_POST . $item->photo2;
                        @endphp
                        <button type="button"
                        class="hs-tab-active:text-primary group dark:hs-tab-active:text-primary-600 py-4 pr-4    hs-tab-active:border-primary text-base xl:text-xl font-bold text-[#8B8B8B] text-left border-r-0 hover:text-primary {{ $active }} border-solid border-b border-[#8B8B8B]"
                        id="vertical-tab-with-border-item-{{ $position }}" data-hs-tab="#vertical-tab-with-border-{{ $position }}"
                        aria-controls="vertical-tab-with-border-{{ $position }}" role="tab">
                            {{-- <x-shared.eye class="w-5 h-5" /> --}}
                            {{-- <img src="public/pts/eye.png" alt="eye" class="inline-block group-hover:hidden w-[47px] shrink-0">
                            <img src="public/pts/eye_hover.png" alt="eye" class="hidden group-hover:inline-block w-[47px] shrink-0"> --}}
                            <x-shared.image src="{{ $photo }}" alt="{{ $name }}" class="inline-block  w-[40px] mr-2 shrink-0" />
                            {{ $name }}
                            {{-- <span class="w-[calc(100%_-_47px] block pl-2">
                            </span> --}}
                        </button>
                    @endforeach
                </nav>
            </div>
            <div class="w-full mt-5 md:mt-0 md:w-[63%] shrink-0">
                @foreach ($giaTri as $item)
                    @php
                        $active = $loop->index == 0 ? '' : 'hidden';
                        $position = $loop->index + 1;
                        $description = $item->{"mota$lang"} ?? '';
                        $sl_options = (isset($item->sl_options) && $item->sl_options != '') ? json_decode($item->sl_options, true) : null;
                        $link_youtube = $sl_options['link_youtube'] ?? '';
                        $photo = Thumb::Crop(UPLOAD_POST, $item->photo ?? '', 800, 450, 1);
                    @endphp
                    <div id="vertical-tab-with-border-{{ $position }}" role="tabpanel" aria-labelledby="vertical-tab-with-border-item-{{ $position }}" class="{{ $active }}">
                        @if (!empty($link_youtube))
                            <div class="aspect-w-16 shadow-lg overflow-hidden aspect-h-9 rounded-xl">
                                <iframe src="https://www.youtube.com/embed/{{ Helper::getYoutube($link_youtube ?? '') }}" class="absolute inset-0 w-full h-full" allowfullscreen></iframe>
                            </div>
                        @else
                            <div style="background-image: url({{ $photo }})" class="aspect-w-16 shadow-lg overflow-hidden aspect-h-9 rounded-xl bg-no-repeat bg-cover"></div>
                        @endif
                        <div class="text-base mt-8 text-[#404040]">{{ $description }}</div>
                    </div>
                @endforeach
                {{-- @for ($i = 0; $i < 3; $i++)
                @php
                    $active = $i == 0 ? '' : 'hidden';
                    $position = $i + 1;
                @endphp
                <div id="vertical-tab-with-border-{{ $position }}" role="tabpanel" aria-labelledby="vertical-tab-with-border-item-{{ $position }}" class="{{ $active }}">
                    <div class="aspect-w-16 shadow-lg overflow-hidden aspect-h-9 rounded-xl">
                        <iframe src="https://www.youtube.com/embed/{video_id}" class="absolute inset-0 w-full h-full" allowfullscreen></iframe>
                    </div>
                    <div class="text-base mt-8 text-[#404040]">Năm 2022 không chỉ là năm tiền đề cho hành trình 3 năm chinh phục mục tiêu lớn IPO vào năm 2025 mà còn ghi dấu hành trình 10 năm VMO không ngừng chuyển mình,</div>
                </div>
                @endfor --}}
            </div>
        </div>
    </div>
</div>
