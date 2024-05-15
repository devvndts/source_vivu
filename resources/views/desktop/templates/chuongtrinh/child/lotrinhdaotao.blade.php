@if ($data['lotrinhdaotao'])
@php
    $photoAddress = $photo_static['logo-address']['photo'] ?? '';
@endphp
    <div class="detail-daotao md:bg-lotrinhdaotao bg-no-repeat bg-contain bg-[center_top_100px] py-10 md:py-20">
        <div class="container max-w-[896px]">
            <x-shared.title class="text-center">
                <x-slot name="title">{{ __('lộ trình đào tạo') }}</x-slot>
                <x-slot name="desc">{!! $text_general->{'mota'.$lang} !!}</x-slot>
            </x-shared.title>
            <div class="relative pt-12">
                <img src="public/pts/PROCESS.png" alt="PROCESS" class="absolute top-0 right-0 z-0 hidden md:inline-block">
                <x-shared.image src="{{ UPLOAD_PHOTO . $photoAddress }}" alt="PROCESS" class="absolute w-[75px] top-0 -right-[50px] z-0 hidden md:inline-block" />
                <div class="flex flex-wrap md:flex-nowrap md:gap-[10px] relative">
                    @foreach ($data['lotrinhdaotao'] as $key => $item)
                        @php
                            $name = $item["ten$lang"] ?? '';
                            $identity = 'lotrinhdaotao' . $item["id"];
                            $description = $item["mota$lang"] ?? '';
                            $photoUrl = $item['photo'] ?? '';
                            $photo = Thumb::Crop(UPLOAD_POST, $photoUrl ?? '', 50, 50, 1);
                        @endphp
                        <div class="flex mt-4 md:mt-0 w-full  md:w-[170px] even:items-end even:pb-4 md:h-[277px] lg:h-[377px]">
                            <div class="flex gap-3 justify-between md:block md:text-center cursor-pointer w-full" data-hs-overlay="#{{ $identity }}">
                                <x-shared.image src="{{ $photo }}" alt="{{ $name }}" class="mx-auto" />
                                <div class="text-lg flex-1 hover:text-primary font-bold md:max-w-[160px] mx-auto mt-4">
                                    {{ $name }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @push('strucdata')
    @foreach ($data['lotrinhdaotao'] as $key => $item)
    @php
        $name = $item["ten$lang"] ?? '';
        $identity = 'lotrinhdaotao' . $item["id"];
        $description = $item["mota$lang"] ?? '';
        $photoUrl = $item['photo'] ?? '';
        $photo = Thumb::Crop(UPLOAD_POST, $photoUrl ?? '', 50, 50, 1);
    @endphp
    <div id="{{ $identity }}"
        class="hs-overlay hidden w-full h-full fixed top-0 left-0 z-[60] overflow-x-hidden overflow-y-auto">
        <div
            class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all sm:max-w-lg sm:w-full m-3 sm:mx-auto">
            <div
                class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
                <div class="p-4 overflow-y-auto">
                    @if (isset($description) && !empty($description))
                    <x-shared.content>
                        {!! $description !!}
                    </x-shared.content>
                    @endif
                </div>
                <div
                    class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-gray-700">
                    <button type="button"
                        class="hs-dropdown-toggle py-3 px-4 inline-flex justify-center items-center gap-2 rounded-md border font-medium bg-white text-gray-700 shadow-sm align-middle hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-blue-600 transition-all text-sm dark:bg-slate-900 dark:hover:bg-slate-800 dark:border-gray-700 dark:text-gray-400 dark:hover:text-white dark:focus:ring-offset-gray-800"
                        data-hs-overlay="#{{ $identity }}">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endpush
    {{-- @push('js_page')
    <script>
        $(document).ready(function() {
        }
        
    </script>
@endpush --}}
@endif
