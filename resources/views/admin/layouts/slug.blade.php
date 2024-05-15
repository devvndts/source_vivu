<div class="text-sm card card-primary card-outline">
    <x-backend_shared.card_header>
        {{ __('Đường dẫn') }}
        <x-slot name="other_info">
            <span class="pl-2 text-danger">({{ __('Vui lòng không nhập trùng tiêu đề') }})</span>
        </x-slot>
    </x-backend_shared.card_header>
    <div class="card-body card-slug">
        <?php //if(isset($slugchange) && $slugchange == 1) { ?>
            <div class="mb-2 form-group">
                <label for="slugchange" class="mb-0 mr-2 align-middle d-inline-block text-info">{{ __('Thay đổi đường dẫn theo tiêu đề mới') }}:</label>
                <div class="align-middle custom-control custom-checkbox d-inline-block">
                    <input type="checkbox" class="custom-control-input" name="slugchange" id="slugchange">
                    <label for="slugchange" class="custom-control-label"></label>
                </div>
            </div>
        <?php //} ?>

        <input type="hidden" class="slug-id" value="{{ (isset($rowItem['id'])) ? $rowItem['id'] : 0}}">
        <input type="hidden" class="slug-copy" value="{{(isset($copy) && $copy == true) ? 1 : 0}}">

        <div class="card card-primary card-outline card-outline-tabs">
            <div class="p-0 card-header border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                    @foreach(config('config_all.slug') as $k => $v)
                        <li class="nav-item">
                            <a class="nav-link {{($k=='vi')?'active':''}}" id="tabs-lang" data-toggle="pill" href="#tabs-sluglang-{{$k}}" role="tab" aria-controls="tabs-sluglang-{{$k}}" aria-selected="true">{{$v}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content dev-tab-slug" id="custom-tabs-three-tabContent-lang">
                    @foreach(config('config_all.slug') as $k => $v)
                    @php
                        $rowItem['tenkhongdau'.$k] = $rowItem['tenkhongdau'.$k]??'';
                    @endphp
                        <div class="tab-pane fade show {{($k=='vi')?'active':''}}" id="tabs-sluglang-{{$k}}" role="tabpanel" aria-labelledby="tabs-lang">
                            <div class="mb-0 form-gourp">
                                <label class="d-block">{{ __('Đường dẫn mẫu') }} ({{$k}}):<span class="pl-2 font-weight-normal" id="slugurlpreview{{$k}}">{{config('config_all.config_all_url')}}/<strong class="text-info">{{ (isset($rowItem))?$rowItem['tenkhongdau'.$k]:'' }}</strong></span></label>
                                <input type="text" class="form-control slug-input no-validate" name="data[slug{{$k}}]" id="slug{{$k}}" placeholder="{{ __('Đường dẫn') }} ({{$k}})" value="{{ (isset($rowItem))?$rowItem['tenkhongdau'.$k]:'' }}">
                                <input type="hidden" id="slug-default{{$k}}" value="">
                                <p class="alert-slug{{$k}} text-danger d-none mt-2 mb-0" id="alert-slug-danger{{$k}}">
                                    <i class="mr-1 fas fa-exclamation-triangle"></i>
                                    <span>{{ __('Đường dẫn đã tồn tại. Đường dẫn truy cập mục này có thể bị trùng lặp.') }}</span>
                                </p>
                                <p class="alert-slug{{$k}} text-success d-none mt-2 mb-0" id="alert-slug-success{{$k}}">
                                    <i class="mr-1 fas fa-check-circle"></i>
                                    <span>{{ __('Đường dẫn hợp lệ.') }}</span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
