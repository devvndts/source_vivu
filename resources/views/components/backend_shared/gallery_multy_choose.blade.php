@props([
    'level' => 'man',
    'gallery' => $gallery,
    'label' => $label,
    'model' => $model,
    'type' => $type,
    ])
@php
    $tieude = (in_array($type, ['dich-vu-dao-tao', 'chuong-trinh-dao-tao'])) ? 'Link' : __('Tiêu đề');
@endphp
<div class="form-group" id="photo-upload-group">
    <label for="filer-gallery" class="mb-3 label-filer-gallery">{{ $label }}</label>
    <input type="file" name="files[]" id="filer-gallery" multiple="multiple">
    <input type="hidden" class="col-filer" value="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6">
    <input type="hidden" class="act-filer" name="level" value="{{ $level }}">
    <input type="hidden" class="folder-filer" name="model" value="{{ $model }}">
    <input type="hidden" class="folder-filer" name="type" value="{{ $type }}">
    <input type="hidden" name="hash" value="{{ Helper::generateHash() }}" />
</div>
@isset($gallery)
    @if ($gallery)
        <div class="form-group form-group-gallery form-group-gallery-main">
            {{-- <label class="label-filer">Album hiện tại:</label> --}}
            <div class="mb-3 action-filer d-none">
                <a class="mr-1 text-white btn btn-sm bg-gradient-primary check-all-filer">
                    <i class="mr-2 far fa-square"></i>{{ __('Chọn tất cả') }}
                </a>
                <button type="button"
                    class="mr-1 text-white btn btn-sm bg-gradient-success sort-filer">
                    <i class="mr-2 fas fa-random"></i>{{ __('Sắp xếp') }}
                </button>
                <a class="text-white btn btn-sm bg-gradient-danger delete-all-filer">
                    <i class="mr-2 far fa-trash-alt"></i>{{ __('Xóa tất cả') }}
                </a>
            </div>
            <div class="text-sm text-white alert my-alert alert-sort-filer alert-info bg-gradient-info">
                <i class="mr-2 fas fa-info-circle"></i>{{ __('Có thể chọn nhiều hình để di chuyển') }}
            </div>
            <div class="jFiler-items my-jFiler-items jFiler-row">
                <ul class="jFiler-items-list jFiler-items-grid row scroll-bar" id="jFilerSortable">
                    @foreach ($gallery as $v)
                        {{ Helper::galleryFiler($v['stt'], $v['id'], $v['photo'], $v['tenvi'], $model, 'col-xl-2 col-lg-3 col-md-3 col-sm-4 col-6', '', $tieude) }}
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
@endisset