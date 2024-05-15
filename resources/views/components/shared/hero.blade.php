@props([
    'data' => null
    ])
@php
    $type_banner = [
        'gioi-thieu' => 'banner_gioi-thieu',
        'chuyen-gia' => 'banner_chuyen-gia',
        'dich-vu-dao-tao' => 'banner_dich-vu-dao-tao',
        'chuong-trinh-dao-tao' => 'banner_chuong-trinh-dao-tao',
        'hoc-vien-va-doanh-nghiep' => 'banner_hoc-vien-va-doanh-nghiep',
        'tin-tuc' => 'banner_tin-tuc',
        'lienhe' => 'banner_lien-he',
    ];
    $banner_photo = UPLOAD_PHOTO . $photo_static[$type_banner['tin-tuc']]['photo'];

    if (in_array($data['type'], array_keys($type_banner))) {
        $banner_photo = UPLOAD_PHOTO . $photo_static[$type_banner[$data['type']]]['photo'];
    }
    $background_category = $data["background_category"] ?? '';
    // if (in_array($data['type'], array_keys($type_banner)) && $background_category != '') {
    //     $banner_photo = UPLOAD_CATEGORY . $background_category;
    // }
@endphp
<div class="relative bg-no-repeat bg-cover  h-[200px] lg:h-[400px]" style="background-image: url({{ $banner_photo }});">
    {{-- <div class="absolute top-0 left-0 flex flex-col items-center justify-center w-full h-full ">
        
        @if ($data['title_crumb'])
            <div class="mt-4 text-3xl font-title text-center uppercase text-primary">{{ $data['title_crumb'] }}</div>
        @endif
    </div> --}}
</div>