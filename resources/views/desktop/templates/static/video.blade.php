@extends('desktop.master')
@php
    $video = get_photos('video', $lang);
@endphp
@section('content')
    <div class="container max-w-screen-xl">
        <x-shared.subtitle title="Video" />
        <x-blog.index>
            @foreach ($video as $item)
            @php
                $data["name"] = $item->{"ten$lang"};
                $data["desc"] = $item->{"mota$lang"};
                $data["url"] = "https://www.youtube.com/watch?v=".Helper::getYoutube($item->link_video);
                $data["post_date"] = date('D m, Y', $item->ngaytao);
                $post_type = $item->type ?? null;
                $data["img"] = Thumb::Crop(UPLOAD_PHOTO, $item->photo, 330, 245, 1, $post_type);
            @endphp
                <x-blog.item isFancybox :data="$data" />
            @endforeach
        </x-blog.index>
    </div>
@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')
@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')
@endpush


@push('strucdata')
    
@endpush