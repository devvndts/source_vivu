<div class="container max-w-screen-xl ">
    <x-shared.subtitle title="{{ $title_crumb }}" />
    <div class="flex justify-between">
        <div class="hidden w-1/4 mr-5 lg:block">
            <p class="mb-5 text-base font-bold">{{ __('Bài nổi bật') }}</p>
            @if ($posts->count() > 0)
                @foreach ($posts as $item)
                @php
                    if ($loop->index > 4) break;
                    $data["name"] = $item->{"ten$lang"};
                    $data["desc"] = $item->{"mota$lang"};
                    $data["url"] = $item->{$sluglang};
                    $data["post_date"] = date('D m, Y', $item->ngaytao);
                    $post_type = $item->type ?? null;
                    $data["img"] = Thumb::Crop(UPLOAD_POST, $item->photo, 330, 245, 1, $post_type);
                @endphp
                    <x-blog.toppost :data="$data" />
                @endforeach
            @endif
        </div>
        <div class="w-full lg:w-3/4">
            @if (isset($row_detail['noidung' . $lang]) && !empty($row_detail['noidung' . $lang]))
            <x-shared.content>
                {!! $row_detail['noidung' . $lang] !!}
            </x-shared.content>
            @endif
            @if ($posts->count() > 0)
                <x-blog.index>
                    @foreach ($posts as $item)
                    @php
                        $data["name"] = $item->{"ten$lang"};
                        $data["desc"] = $item->{"mota$lang"};
                        $data["url"] = $item->{$sluglang};
                        $data["post_date"] = date('D m, Y', $item->ngaytao);
                        $post_type = $item->type ?? null;
                        $data["img"] = Thumb::Crop(UPLOAD_POST, $item->photo, 330, 245, 1, $post_type);
                    @endphp
                        <x-blog.item :data="$data" />
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
</div>