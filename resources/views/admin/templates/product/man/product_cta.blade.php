@php
    $cta = get_photos('cta', 'vi', ['order_by' => ['stt' => 'asc']])->toArray();
    $ctaLink = ($rowItem["cta_link"]) ? @unserialize($rowItem["cta_link"]) : null;
@endphp
@if ($cta)
<div class="card-seo">
    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-body">
            <p class="mt-3"><i>Để trống nếu không có</i></p>
            @foreach ($cta as $item)
                @php
                    $name = $item->{"tenvi"};
                    $id = $item->{"id"};
                    $value = ($ctaLink) ? htmlspecialchars_decode($ctaLink[$id]) : '';
                @endphp
                <div class="form-group">
                    <label class="d-block">{{ $name }}:</label>
                    <input type="text" class="form-control " name="data[cta_link][{{ $id }}]" placeholder="Link" value="{{ $value }}">
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif