<x-backend_shared.card_header isShowMinus>
    {{ __('Thông tin') }} {{ __($config[$type]['title_main']) }}
</x-backend_shared.card_header>
<div class="card-body card-article">
    {{-- <div class="form-group">
        <label for="hienthi" class="mb-0 mr-2 align-middle d-inline-block">Hiển thị:</label>
        <div class="align-middle custom-control custom-checkbox d-inline-block">
            <input type="checkbox" class="custom-control-input hienthi-checkbox" name="data[hienthi]"
                id="hienthi-checkbox"
                {{ !isset($rowItem['hienthi']) || $rowItem['hienthi'] == 1 ? 'checked' : '' }}>
            <label for="hienthi-checkbox" class="custom-control-label"></label>
        </div>
    </div> --}}

    @php
        $isChecked = false;
        if (!isset($rowItem['hienthi']) || $rowItem['hienthi'] == 1) {
            $isChecked = true;
        }
    @endphp
    <x-backend_form.group>
        <x-backend_form.label isInlineBlock class="{{ $sttLabelClass }}" >{{ __('Hiển thị') }}: </x-backend_form.label>
        <x-backend_form.hienthi_input_group :isChecked="$isChecked" name="data[hienthi]"
        id="hienthi-checkbox" />
    </x-backend_form.group>

    <x-backend_form.group>
        <x-backend_form.label isInlineBlock class="{{ $sttLabelClass }}" >{{ __('Số thứ tự') }}: </x-backend_form.label>
        <x-backend_form.input type="number" name="data[stt]"
        id="stt" value="{{ $rowItem['stt'] ?? 1 }}" class="{{ $sttInputClass }}" />
    </x-backend_form.group>

    <div class="row">
        @if (isset($config[$type]['ma']) && $config[$type]['ma'])
            {{-- <div class="form-group col-md-4 d-none">
                <label class="d-block" for="masp">Mã sản phẩm (của hãng):</label>
                <input type="text" class="form-control" name="data[masp_brand]" id="masp_brand"
                    placeholder="Mã sản phẩm" value="{{ $rowItem['masp_brand'] }}">
            </div> --}}
            <x-backend_form.group class="{{ $formGroupClass }}">
                <x-backend_form.label >{{ __('Mã sản phẩm') }}: </x-backend_form.label>
                <x-backend_form.input type="text" name="data[masp]" id="masp" value="{{ $rowItem['masp'] ?? '' }}" required />
                <p class="mt-2 mb-0 alert-masp text-danger d-none" id="alert-masp-danger">
                    <i class="mr-1 fas fa-exclamation-triangle"></i>
                    <span>{{ __('Mã SP đã tồn tại') }}.</span>
                </p>
                <p class="mt-2 mb-0 alert-masp text-success d-none" id="alert-masp-success">
                    <i class="mr-1 fas fa-check-circle"></i>
                    <span>{{ __('Mã SP hợp lệ') }}.</span>
                </p>
            </x-backend_form.group>
        @endif
        {{-- <div class="form-group col-md-4">
        <label class="d-block" for="giamoi">Kích thước đóng gói(cm):</label>
        <div class="input-group">
            <input type="text" class="form-control format-price dai" name="data[dai]" id="dai" placeholder="Chiều dài" value="{{$rowItem['dai']}}">
            <div class="input-group-append">
                <div class="input-group-text"><strong>x</strong></div>
            </div>
            <input type="text" class="form-control format-price rong" name="data[rong]" id="rong" placeholder="Chiều rộng" value="{{$rowItem['rong']}}">
            <div class="input-group-append">
                <div class="input-group-text"><strong>x</strong></div>
            </div>
            <input type="text" class="form-control format-price cao" name="data[cao]" id="cao" placeholder="Chiều cao" value="{{$rowItem['cao']}}">
            <div class="input-group-append">
                <div class="input-group-text"><strong>/4000</strong></div>
            </div>
        </div>
    </div>
    <div class="form-group col-md-4">
        <label class="d-block" for="giamoi">Khối lượng đóng gói:</label>
        <div class="input-group">
            <input type="text" class="form-control format-price khoiluong" name="data[khoiluong]" id="khoiluong" placeholder="Khối lượng" value="{{$rowItem['khoiluong']}}">
            <div class="input-group-append">
                <div class="input-group-text"><strong>Gram</strong></div>
            </div>
        </div>
    </div> --}}
        @if (isset($config[$type]['giacu']) && $config[$type]['giacu'])
        <x-backend_form.group class="{{ $formGroupClass }}">
            <x-backend_form.label >{{ __('Giá cũ') }}: </x-backend_form.label>
            <x-backend_form.input_group type="text" name="data[giacu]"
            id="giacu" value="{{ $rowItem['giacu'] ?? 0 }}" class="format-price gia_cu">
                VNĐ
            </x-backend_form.input_group>
        </x-backend_form.group>
        @endif

        @if (isset($config[$type]['gia']) && $config[$type]['gia'])
        <x-backend_form.group class="{{ $formGroupClass }}">
            <x-backend_form.label >{{ __('Giá bán') }}: </x-backend_form.label>
            <x-backend_form.input_group type="text" name="data[gia]"
            id="gia" value="{{ $rowItem['gia'] ?? 0 }}" class="format-price gia_ban">
                VNĐ
            </x-backend_form.input_group>
        </x-backend_form.group>
        @endif

        @if (isset($config[$type]['giamoi']) && $config[$type]['giamoi'])
        <x-backend_form.group class="{{ $formGroupClass }}">
            <x-backend_form.label >{{ __('Giá mới') }}: </x-backend_form.label>
            <x-backend_form.input_group type="text" name="data[giamoi]"
            id="giamoi" value="{{ $rowItem['giamoi'] ?? 0 }}" class="format-price gia_moi">
                VNĐ
            </x-backend_form.input_group>
        </x-backend_form.group>
        @endif

        @if (isset($config[$type]['giakm']) && $config[$type]['giakm'])
        <x-backend_form.group class="{{ $formGroupClass }}">
            <x-backend_form.label >{{ __('Chiết khấu') }}: </x-backend_form.label>
            <x-backend_form.input_group type="text" name="data[giakm]"
            id="giakm" value="{{ $rowItem['giakm'] ?? 0 }}" class="gia_km" maxlength="3" readonly>
            %
            </x-backend_form.input_group>
        </x-backend_form.group>
        @endif

        @if (isset($config[$type]['sell']) && $config[$type]['sell'])
        <x-backend_form.group class="{{ $formGroupClass }}">
            <x-backend_form.label >{{ __('Sản phẩm đã bán') }}: </x-backend_form.label>
            <x-backend_form.input_group type="text" name="data[sell]"
            id="sell" value="{{ $rowItem['sell'] ?? 0 }}" class="format-price sell">
            SL
            </x-backend_form.input_group>
        </x-backend_form.group>
        @endif
    </div>
</div>