@php
    use App\Helpers\Form as FormTemplate;
    $formLabelAttr = config('zvn.template.form_label.class');
    $formInputAttr = config('zvn.template.form_input.class');
    $formGroupClass = config('zvn.template.form_group.class');
    $sttInputClass = config('zvn.template.stt_form_input.class');
    $sttLabelClass = config('zvn.template.stt_form_label.class');
    $rowItem = $rowItem ?? [];
    
    $urlSave = route('admin.setting.save', ['man', $type]);
    $urlMan = route('admin.setting.show', ['man', $type]);
    $urlOption = '';
    $isShowOption = false;
@endphp
@extends('admin.master')

@section('content')
    <form class="validation-form" novalidate method="post" action="{{ $urlSave }}" enctype="multipart/form-data">
        @csrf
        <x-backend_shared.action_buttons :urlMan=$urlMan :urlOption=$urlOption :isShowOption=$isShowOption />

        <div
            class="card card-primary card-outline text-sm {{ config('config_all.debug_developer') == true ? 'd-block' : 'd-none' }}">
            <x-backend_shared.card_header>
                {{ __('Cấu hình mailer') }}
            </x-backend_shared.card_header>
            <div class="card-body">
                <div class="form-group">
                    <div class="mr-3 custom-control custom-radio d-inline-block text-md">
                        <input class="custom-control-input mailertype" type="radio" id="mailertype-host"
                            name="data[options][mailertype]" value="1"
                            {{ $options['mailertype'] == 1 || $options['mailertype'] == 0 ? 'checked' : '' }}>
                        <label for="mailertype-host" class="custom-control-label font-weight-normal">Host email</label>
                    </div>
                    <div class="mr-3 custom-control custom-radio d-inline-block text-md">
                        <input class="custom-control-input mailertype" type="radio" id="mailertype-gmail"
                            name="data[options][mailertype]" value="2"
                            {{ $options['mailertype'] == 2 || $options['mailertype'] == 0 ? 'checked' : '' }}>
                        <label for="mailertype-gmail" class="custom-control-label font-weight-normal">Gmail email</label>
                    </div>
                </div>
                <div class="host-email {{ $options['mailertype'] == 1 || $options['mailertype'] == 0 ? 'd-block' : 'd-none' }}">
                    <div class="row">
                        <div class="mb-4 form-group col-md-4 col-sm-6">
                            <label for="ip_host" class="inp">
                                <input type="text" class="form-control for-seo" name="data[options][ip_host]"
                                    id="ip_host" placeholder="&nbsp;" value="{{ $options['ip_host'] }}">
                                <span class="label">Host</span>
                            </label>
                        </div>
                        <div class="mb-4 form-group col-md-4 col-sm-6">
                            <label for="port_host" class="inp">
                                <input type="text" class="form-control for-seo" name="data[options][port_host]"
                                    id="port_host" placeholder="&nbsp;" value="{{ $options['port_host'] }}">
                                <span class="label">Port</span>
                            </label>
                        </div>
                        <div class="mb-4 form-group col-md-4 col-sm-6">
                            <label for="secure_host" class="inp">
                                <select class="form-control" name="data[options][secure_host]" id="secure_host"
                                    placeholder="&nbsp;">
                                    <option {{ $options['secure_host'] == 'tls' ? 'selected' : '' }} value="tls">TLS</option>
                                    <option {{ $options['secure_host'] == 'ssl' ? 'selected' : '' }} value="ssl">SSL</option>
                                </select>
                                <span class="label">Secure</span>
                            </label>
                        </div>
                        <div class="mb-4 form-group col-md-4 col-sm-6">
                            <label for="email_host" class="inp">
                                <input type="text" class="form-control for-seo" name="data[options][email_host]"
                                    id="email_host" placeholder="&nbsp;" value="{{ $options['email_host'] }}">
                                <span class="label">Email host</span>
                            </label>
                        </div>
                        <div class="mb-4 form-group col-md-4 col-sm-6">
                            <label for="password_host" class="inp">
                                <input type="text" class="form-control for-seo" name="data[options][password_host]"
                                    id="password_host" placeholder="&nbsp;" value="{{ $options['password_host'] }}">
                                <span class="label">Password host</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="gmail-email {{ $options['mailertype'] == 2 ? 'd-block' : 'd-none' }}">
                    <div class="row">
                        <div class="mb-4 form-group col-md-4 col-sm-6">
                            <label for="host_gmail" class="inp">
                                <input type="text" class="form-control for-seo" name="data[options][host_gmail]"
                                    id="host_gmail" placeholder="&nbsp;" value="{{ $options['host_gmail'] }}">
                                <span class="label">Host</span>
                            </label>
                        </div>
                        <div class="mb-4 form-group col-md-4 col-sm-6">
                            <label for="port_gmail" class="inp">
                                <input type="text" class="form-control for-seo" name="data[options][port_gmail]"
                                    id="port_gmail" placeholder="&nbsp;" value="{{ $options['port_gmail'] }}">
                                <span class="label">Port</span>
                            </label>
                        </div>
                        <div class="mb-4 form-group col-md-4 col-sm-6">
                            <label for="secure_gmail" class="inp">
                                <select class="form-control" name="data[options][secure_gmail]" id="secure_gmail"
                                    placeholder="&nbsp;">
                                    <option {{ $options['secure_host'] == 'tls' ? 'selected' : '' }} value="tls">TLS
                                    </option>
                                    <option {{ $options['secure_host'] == 'ssl' ? 'selected' : '' }} value="ssl">SSL
                                    </option>
                                </select>
                                <span class="label">Secure</span>
                            </label>
                        </div>
                        <div class="mb-4 form-group col-md-4 col-sm-6">
                            <label for="email_gmail" class="inp">
                                <input type="text" class="form-control for-seo" name="data[options][email_gmail]"
                                    id="email_gmail" placeholder="&nbsp;" value="{{ $options['email_gmail'] }}">
                                <span class="label">Email</span>
                            </label>
                        </div>
                        <div class="mb-4 form-group col-md-4 col-sm-6">
                            <label for="password_gmail" class="inp">
                                <input type="text" class="form-control for-seo" name="data[options][password_gmail]"
                                    id="password_gmail" placeholder="&nbsp;" value="{{ $options['password_gmail'] }}">
                                <span class="label">Password</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                @if (config('config_all.menus') == true)
                    <div class="text-sm card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Menu thể hiện ngoài website</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                @foreach ($menus as $k => $v)
                                    <div class="mr-3 custom-control custom-radio d-inline-block text-md">
                                        <input class="custom-control-input mailertype" type="radio"
                                            id="menu-select-{{ $v['id'] }}" name="data[menu]"
                                            value="{{ $v['id'] }}"
                                            {{ isset($rowItem['menu']) && $rowItem['menu'] == $v['id'] ? 'checked' : '' }}>
                                        <label for="menu-select-{{ $v['id'] }}"
                                            class="custom-control-label font-weight-normal">{{ $v['title'] }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <div class="text-sm card card-primary card-outline">
					<x-backend_shared.card_header >
                        {{ __('Thông tin chung') }}
                    </x-backend_shared.card_header>
                    <div class="card-body">
                        @if (count(config('config_all.lang')) > 1)
                            <div class="form-group">
                                <label>{{ __('Ngôn ngữ mặc định') }}:</label>
                                <div class="form-group">
                                    @foreach (config('config_all.lang') as $k => $v)
                                        <div class="mr-3 custom-control custom-radio d-inline-block text-md">
                                            <input class="custom-control-input" type="radio"
                                                id="lang_default-{{ $k }}" name="data[options][lang_default]"
                                                value="{{ $k }}"
                                                {{ @$options['lang_default'] == $k ? 'checked' : '' }}>
                                            <label for="lang_default-{{ $k }}"
                                                class="custom-control-label font-weight-normal">{{ $v }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="row">
                            @php
                                $elements = renderBackendComponent(config('config_all.setting'), 'data[options]', $options);
                            @endphp
                            {!! FormTemplate::show($elements) !!}
                        </div>

						@php
							$class = "for-seo ";
						@endphp
						<x-backend_form.group >
							<x-backend_form.label >Google analytics: </x-backend_form.label>
							<x-backend_form.textarea class="{{ $class }}" name="data[options][annalytics]" id="analytics" rows="5">{{$rowItem['annalytics'] ?? '' }}</x-backend_form.textarea>
						</x-backend_form.group>

						@php
							$class = "for-seo ";
						@endphp
						<x-backend_form.group >
							<x-backend_form.label >Google Webmaster Tool: </x-backend_form.label>
							<x-backend_form.textarea class="{{ $class }}" name="data[options][mastertool]" id="mastertool" rows="5">{{$rowItem['mastertool'] ?? '' }}</x-backend_form.textarea>
						</x-backend_form.group>
                    </div>
                </div>

                <div class="text-sm card card-primary card-outline">
					<x-backend_shared.card_header >
                        {{ __('Thông tin khác') }}
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
                                            id="tabs-lang-{{ $k }}" role="tabpanel"
                                            aria-labelledby="tabs-lang">
											@php
                                                $class = "for-seo ";
                                            @endphp
                                            <x-backend_form.group >
                                                <x-backend_form.label >{{ __('Tiêu đề') }} ({{ $k }}): </x-backend_form.label>
                                                <x-backend_form.input type="text" name="data[ten{{ $k }}]" id="ten{{ $k }}" value="{{ $rowItem['ten' . $k] ?? '' }}" required />
                                            </x-backend_form.group>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

						@php
							$class = "for-seo ";
						@endphp
						<x-backend_form.group >
							<x-backend_form.label >[Link admin] - {{ config('config_all.config_all_url') }}: </x-backend_form.label>
							<x-backend_form.input type="text" name="data[options][linkadmin]" id="linkadmin" value="{{ $options['linkadmin'] ?? '' }}" required />
						</x-backend_form.group>

						@php
							$class = "for-seo ";
						@endphp
						<x-backend_form.group >
							<x-backend_form.label >Head JS: </x-backend_form.label>
							<x-backend_form.textarea class="{{ $class }}" name="data[headjs]" id="headjs" rows="5">{{$rowItem['headjs'] ?? '' }}</x-backend_form.textarea>
						</x-backend_form.group>

						@php
							$class = "for-seo ";
						@endphp
						<x-backend_form.group >
							<x-backend_form.label >Body JS: </x-backend_form.label>
							<x-backend_form.textarea class="{{ $class }}" name="data[bodyjs]" id="bodyjs" rows="5">{{$rowItem['bodyjs'] ?? '' }}</x-backend_form.textarea>
						</x-backend_form.group>

						@php
							$class = "for-seo ";
						@endphp
						<x-backend_form.group >
							<x-backend_form.label >Fanpage JS: </x-backend_form.label>
							<x-backend_form.textarea class="{{ $class }}" name="data[fanpagejs]" id="fanpagejs" rows="5">{{$rowItem['fanpagejs'] ?? '' }}</x-backend_form.textarea>
						</x-backend_form.group>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                {{--
        		@if (config('config_all.order.soluong'))
        		<div class="text-sm card card-primary card-outline">					
					<div class="mt-4 card-body">
						<div class="form-group">
	                        <label for="hienthi" class="mb-0 mr-2 align-middle d-inline-block">Đặt hàng giới hạn số lượng:</label>
	                        <div class="align-middle custom-control custom-checkbox d-inline-block">
	                            @if ($rowItem['isSoluong'] == 1 || !isset($rowItem))
	                            <input type="checkbox" class="custom-control-input soluong-checkbox" name="data[isSoluong]" id="soluong-checkbox" checked>
	                            @else
	                            <input type="checkbox" class="custom-control-input soluong-checkbox" name="data[isSoluong]" id="soluong-checkbox">
	                            @endif
	                            <label for="soluong-checkbox" class="custom-control-label"></label>
	                        </div>
	                    </div>
	                    <div style="background: #f5f5f5; padding: 10px; border-radius: 5px; font-style: italic;">	                    	
	                    	<i class="far fa-question-square"></i> Chọn thiết lập này sẽ giúp quản lý số lượng sản phẩm, khách hàng chỉ có thể mua và tạo đơn hàng khi số lượng sản phẩm còn cho phép. Quản trị viên quản lý số lượng sản phẩm tại mục 'Số lượng' trong mỗi sản phẩm.</br>
	                    	<i class="far fa-question-square"></i> Bỏ chọn thiết lập đồng nghĩa với việc <strong>không cho phép</strong> quản lý số lượng sản phẩm.
	                    </div>
					</div>
				</div>
				@endif
				--}}

                <div class="text-sm card card-primary card-outline">
					<x-backend_shared.card_header isShowMinus>
						{{ __('Hình đại diện') }}
					</x-backend_shared.card_header>
                    <div class="card-body">
						@php
                            $rowPhoto = $rowItem['photo'] ?? '';
                            $photoUrl = Helper::GetFolder($folder_upload,true) . $rowPhoto;
                            $photoWidth = 200;
                            $photoHeight = 200;
                            $photoRatio = $config[$type]['ratio'] ?? null;
                        @endphp
                        <x-backend_shared.photo_upload :photoUrl=$photoUrl :photoWidth=$photoWidth :photoHeight=$photoHeight :photoRatio=$photoRatio />
                    </div>
                </div>

                @if (isset($config[$type]['seo']) && $config[$type]['seo'] == true)
                    <div class="text-sm card card-primary card-outline">
						<x-backend_shared.card_header >
                            {{ __('Nội dung') }} SEO
                            <x-slot name="other_info">
                                <a class="float-right text-white btn btn-sm bg-gradient-success d-inline-block create-seo"
                                >{{ __('Tạo') }} SEO</a>
                            </x-slot>
                        </x-backend_shared.card_header>
                        <div class="card-body">
                            @include('admin.layouts.seo')
                        </div>
                    </div>
                @endif


                @if (config('delivery.active') == true)
                    @php
                        $transport_method = config('delivery.transpost_method');
                    @endphp

                    @foreach ($transport_method as $p => $port)
                        <div class="text-sm card card-primary card-outline">
							<x-backend_shared.card_header >
								{{ __('Cấu hình') }} {{ $p }}
							</x-backend_shared.card_header>
                            <div class="card-body">
                                @if ($viettelinventory)
                                    @foreach ($viettelinventory as $i => $item)
                                        <div class="setting-transport-item">
                                            <p><strong>{{ __('Tên kho') }}: {{ $item['name'] }}</strong></p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>

        <div class="text-sm card-footer">
            <input type="hidden" name="id" value="{{ isset($rowItem['id']) ? $rowItem['id'] : '' }}">
        </div>
    </form>
@endsection

<!--js thêm cho mỗi trang-->
@section('js_page')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".mailertype").click(function() {
                var value = parseInt($(this).val());

                if (value == 1) {
                    $(".host-email").removeClass("d-none");
                    $(".host-email").addClass("d-block");
                    $(".gmail-email").removeClass("d-block");
                    $(".gmail-email").addClass("d-none");
                }
                if (value == 2) {
                    $(".gmail-email").removeClass("d-none");
                    $(".gmail-email").addClass("d-block");
                    $(".host-email").removeClass("d-block");
                    $(".host-email").addClass("d-none");
                }
            })
        })
    </script>
@endsection
