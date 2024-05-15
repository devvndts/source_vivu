@php
    $dichVuDaoTaoLevel1 = get_categories('dich-vu-dao-tao', $lang, ["query" => ["level" => "0", "noibat" => "1"]]);
    $text_general = get_static('text-general', $lang);
@endphp
<div class="dichvudaotao pt-20 pb-12 relative">
    <div class="container">
        <x-shared.title class="text-center" >
            <x-slot name="title" href="{{ url('dich-vu-dao-tao') }}">{{ __('Đào tạo đại học') }}</x-slot>
        </x-shared.title>
        <div class="mt-7 grid grid-cols-2 gap-3 md:grid-cols-3 md:gap-6">
            @foreach ($dichVuDaoTaoLevel1 as $item)
                @php
                    $data["name"] = $item->{"ten$lang"} ?? '';
                    $data["desc"] = $item->{"mota$lang"} ?? '';
                    $data["photoUrl"] = $item->photo ?? '';
                    $data["url"] = $item->$sluglang ?? '';
                    $data["img"] = Thumb::Crop(UPLOAD_CATEGORY, $data["photoUrl"] ?? '', 400, 300, 1);
                @endphp
            <div class="aspect-w-[1.45] aspect-h-1 relative rounded-lg overflow-hidden bg-cover" style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), linear-gradient(180deg, rgba(255, 114, 0, 0) 0%, rgba(255, 114, 0, 0.8) 72.92%), url({{ $data["img"] }});">
                <a href="{{ $data["url"] }}" class="absolute top-0 left-0 w-full h-full flex items-end">
                    <div class="w-full px-6 py-5 text-white">
                        <h3 class="md:text-2xl text-base font-bold">{{ $data["name"] }}</h3>
                        <p class="text-sm mt-2 md:block hidden">{{ $data["desc"] }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <x-shared.title class="text-center mt-20" >
            <x-slot name="title" href="{{ url('chuong-trinh-dao-tao') }}">{{ __('CHƯƠNG TRÌNH ĐÀO TẠO') }}</x-slot>
            <x-slot name="desc">{!! $text_general->{'mota'.$lang} !!}</x-slot>
        </x-shared.title>
    </div>
</div>