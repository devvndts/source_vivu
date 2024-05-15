<div class="container max-w-screen-xl ">
    <x-shared.subtitle class="mb-10" title="{{ $title_crumb }}" />
    <div class="w-full ">
        @if (isset($row_detail['noidung' . $lang]) && !empty($row_detail['noidung' . $lang]))
            <x-shared.content>
                {!! $row_detail['noidung' . $lang] !!}
            </x-shared.content>
        @endif
        @if ($posts->count() > 0)
            <x-blog.index class=" lg:grid-cols-4">
                @foreach ($posts as $item)
                @php
                    $data["name"] = $item->{"ten$lang"};
                    $data["desc"] = $item->{"mota$lang"};
                    $data["url"] = $item->{$sluglang};
                    $data["post_date"] = date('D m, Y', $item->ngaytao);
                    $post_type = $item->type ?? null;
                    $data["img"] = Thumb::Crop(UPLOAD_POST, $item->photo, 330, 245, 1, $post_type);
                @endphp
                    <x-blog.dichvu_item :data="$data" />
                @endforeach
            </x-blog.index>
        @else
            <x-alerts.alerts type="warning">
                <strong>{{ __('Thông báo') }}:</strong> {{ __('Không tìm thấy kết quả') }}
            </x-alerts.alerts>
        @endif
        <div class="clear"></div>
        <div class="row">
            <div class="col-sm-12 dev-center dev-paginator">{{ $posts->links() }}</div>
        </div>
    </div>
</div>