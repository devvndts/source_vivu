<div class="text-sm card card-primary card-outline">
    <x-backend_shared.card_header isShowMinus>
        {{ __('Nội dung') }} {{ __($config[$type]['title_main']) }}
    </x-backend_shared.card_header>
    <div class="card-body">
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="p-0 card-header border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab-lang" role="tablist">
                    @foreach (config('config_all.lang') as $k => $v)
                        <li class="nav-item">
                            <a class="nav-link {{ $k == 'vi' ? 'active' : '' }}" id="tabs-lang"
                                data-toggle="pill" href="#tabs-lang-{{ $k }}" role="tab"
                                aria-controls="tabs-lang-{{ $k }}"
                                aria-selected="true">{{ $v }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="card-body card-article">
                <div class="tab-content" id="custom-tabs-three-tabContent-lang">
                    @foreach (config('config_all.lang') as $k => $v)
                        <div class="tab-pane fade show {{ $k == 'vi' ? 'active' : '' }}"
                            id="tabs-lang-{{ $k }}" role="tabpanel" aria-labelledby="tabs-lang">
                            @php
                                $class = "for-seo ";
                            @endphp
                            <x-backend_form.group >
                                <x-backend_form.label >{{ __('Tiêu đề') }} ({{ $k }}): </x-backend_form.label>
                                <x-backend_form.input type="text" name="data[ten{{ $k }}]" id="ten{{ $k }}" value="{{ $rowItem['ten' . $k] ?? '' }}" required />
                            </x-backend_form.group>
                            
                            @if (isset($config[$type]['mota']) && $config[$type]['mota'])
                            @php
                                $class = "for-seo ";
                                if (isset($config[$type]['mota_cke_custom']) 
                                    && $config[$type]['mota_cke_custom']) {
                                    $class .= "form-control-ckeditor-custom ";
                                } elseif (isset($config[$type]['mota_cke']) 
                                    && $config[$type]['mota_cke']) {
                                    $class .= "form-control-ckeditor ";
                                }
                            @endphp
                            <x-backend_form.group >
                                <x-backend_form.label >{{ __('Mô tả') }} ({{ $k }}): </x-backend_form.label>
                                <x-backend_form.textarea class="{{ $class }}" name="data[mota{{ $k }}]" id="mota{{ $k }}" rows="5">{{$rowItem['mota' . $k] ?? '' }}</x-backend_form.textarea>
                            </x-backend_form.group>
                            @endif

                            @if (isset($config[$type]['motangan']) && $config[$type]['motangan'])
                            @php
                                $class = "for-seo ";
                                if (isset($config[$type]['motangan_cke_custom']) 
                                    && $config[$type]['motangan_cke_custom']) {
                                    $class .= "form-control-ckeditor-custom ";
                                } elseif (isset($config[$type]['motangan_cke']) 
                                    && $config[$type]['motangan_cke']) {
                                    $class .= "form-control-ckeditor ";
                                }
                            @endphp
                            <x-backend_form.group >
                                <x-backend_form.label >{{ __('Mô tả ngắn') }} ({{ $k }}): </x-backend_form.label>
                                <x-backend_form.textarea class="{{ $class }}" name="data[motangan{{ $k }}]" id="motangan{{ $k }}" rows="5">{{$rowItem['motangan' . $k] ?? '' }}</x-backend_form.textarea>
                            </x-backend_form.group>
                            @endif

                            @if (isset($config[$type]['noidung']) && $config[$type]['noidung'])
                            @php
                                $class = "for-seo form-control-ckeditor ";
                                $labelName = __($config[$type]['noidung_title']) ?? __('Nội dung');
                            @endphp
                            <x-backend_form.group >
                                <x-backend_form.label >{{ $labelName }} ({{ $k }}): </x-backend_form.label>
                                <x-backend_form.textarea class="{{ $class }}" name="data[noidung{{ $k }}]" id="noidung{{ $k }}" rows="5">{{$rowItem['noidung' . $k] ?? '' }}</x-backend_form.textarea>
                            </x-backend_form.group>
                            @endif
                            
                            @if (isset($config[$type]['huongdan']) && $config[$type]['huongdan'])
                            @php
                                $class = "for-seo form-control-ckeditor ";
                                $labelName = __($config[$type]['huongdan_title']) ?? __('Nội dung');
                            @endphp
                            <x-backend_form.group >
                                <x-backend_form.label >{{ $labelName }} ({{ $k }}): </x-backend_form.label>
                                <x-backend_form.textarea class="{{ $class }}" name="data[huongdan{{ $k }}]" id="huongdan{{ $k }}" rows="5">{{$rowItem['huongdan' . $k] ?? '' }}</x-backend_form.textarea>
                            </x-backend_form.group>
                            @endif

                            @if (isset($config[$type]['thanhphan']) && $config[$type]['thanhphan'])
                            @php
                                $class = "for-seo form-control-ckeditor ";
                                $labelName = __($config[$type]['thanhphan_title']) ?? __('Nội dung');
                            @endphp
                            <x-backend_form.group >
                                <x-backend_form.label >{{ $labelName }} ({{ $k }}): </x-backend_form.label>
                                <x-backend_form.textarea class="{{ $class }}" name="data[thanhphan{{ $k }}]" id="thanhphan{{ $k }}" rows="5">{{$rowItem['thanhphan' . $k] ?? '' }}</x-backend_form.textarea>
                            </x-backend_form.group>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>