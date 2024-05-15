<div style="display:none;">
    <div id="address_user">
        <h5 class="font-weight-bold text-center mb-3">{{themdiachinhanhang}}</h5>
        <form class="js-add-address validation-address" autocomplete="off" novalidate method="post" action="{{route('address.add')}}">
            @csrf
            <div class="bg-light rounded p-2 input-cart mb-3">
                <label class="fs-14 font-weight-bold">{{loaidiachi}}</label>
                <input type="text" class="form-control" id="tenvi" name="data[tenvi]" value="{{(isset($row_address))?$row_address['tenvi']:''}}" placeholder="{{loaidiachitext}}" required />
                <div class="invalid-feedback">{{vuilongnhaploaidiachi}}</div>
            </div>
            <div class="bg-light rounded p-2 input-cart mb-3">
                <label class="fs-14 font-weight-bold">{{hoten}}</label>
                <input type="text" class="form-control" id="hoten" name="data[hoten]" placeholder="{{hoten}}" value="{{$user_info['name']}}" required />
                <div class="invalid-feedback">{{vuilongnhaphoten}}</div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="bg-light rounded p-2 input-cart mb-3">
                        <label class="fs-14 font-weight-bold">Email</label>
                        <input type="email" class="form-control" id="email" name="data[email]" placeholder="Email" value="{{$user_info['email']}}" required />
                        <div class="invalid-feedback">{{vuilongnhapemail}}</div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="bg-light rounded p-2 input-cart mb-3">
                        <label class="fs-14 font-weight-bold">{{sodienthoai}}</label>
                        <input type="number" class="form-control" id="dienthoai" name="data[dienthoai]" placeholder="{{sodienthoai}}" value="{{$user_info['phonenumber']}}" required />
                        <div class="invalid-feedback">{{vuilongnhapsodienthoai}}</div>
                    </div>
                </div>
            </div>
            <div class="bg-light rounded p-2 input-cart mb-3">
                <label class="fs-14 font-weight-bold">{{tinhthanh}}</label>
                <select class="select-city-cart select2 w-100" id="id_city" name="data[id_city]" required>
                    <option value="">{{tinhthanh}}</option>
                    @foreach ($city as $key => $value)
                        <option value="{{$value['id']}}" {{($value['id']==$row_address['id_city'])?'selected':''}}>{{$value['ten']}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">{{vuilongchontinhthanh}}</div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="bg-light rounded p-2 input-cart mb-3">
                        <label class="fs-14 font-weight-bold">{{quanhuyen}}</label>
                        <select class="select-district-cart select-district select2 w-100" id="id_district" name="data[id_district]" required>
                            <option value="">{{quanhuyen}}</option>
                            @if($row_address)
                                @foreach ($district as $key => $value)
                                    <option value="{{$value['id']}}" {{($value['id']==$row_address['id_district'])?'selected':''}}>{{$value['ten']}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback">{{vuilongchonquanhuyen}}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-light rounded p-2 input-cart mb-3">
                        <label class="fs-14 font-weight-bold">{{phuongxa}}</label>
                        <select class="select-wards-cart select-wards select2 w-100" id="id_ward" name="data[id_ward]" required>
                            <option value="">{{phuongxa}}</option>
                            @if($row_address)
                                @foreach ($ward as $key => $value)
                                    <option value="{{$value['id']}}" {{($value['id']==$row_address['id_ward'])?'selected':''}}>{{$value['ten']}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="invalid-feedback">{{vuilongchonphuongxa}}</div>
                    </div>
                </div>
            </div>
            <div class="bg-light rounded p-2 input-cart mb-3">
                <label class="fs-14 font-weight-bold">{{sonha}}</label>
                <textarea class="form-control" name="data[address]" id="address" placeholder="{{diachichitiet}}" required>{{(isset($row_address))?$row_address['address']:''}}</textarea>
                <div class="invalid-feedback">{{vuilongnhapdiachichitiet}}</div>
            </div>
            <div class="d-flex justify-content-end">
                <input type="hidden" name="id" value="{{(isset($row_address))?$row_address['id']:''}}" />
                <button type="button" data-fancybox-close class="btn btn-light">{{huy}}</button>
                <button type="submit" class="btn btn-dark ml-2">{{luu}}</button>
            </div>
        </form>
    </div>
</div>
{{--### END ADDRESS ADD FORM--}}


<!--css thêm cho mỗi trang-->
<!-- select2 -->
<link href="{{ asset('css/select2.min.css') }} " rel="stylesheet">
<link href="{{ asset('css/select2-bootstrap4.min.css') }} " rel="stylesheet">

<!--js thêm cho mỗi trang-->
<!-- select2 -->
<script src="{{ asset('plugins/select2/select2.full.js') }}"></script>
<script>
    ValidationFormSelf("validation-address");
    $(document).ready(function() {
        $(".select-city-cart").change(function() {
			let id = $(this).val();
			load_district(id);
		});
		$(".select-district-cart").change(function() {
			let id = $(this).val();
			load_wards(id);
		});
		$(".select-wards-cart").change(function() {
			let id = $(this).val();
		});
        $('.select2').each(function () {
            $(this).select2({
                theme: 'bootstrap4',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
                placeholder: $(this).data('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
                closeOnSelect: !$(this).attr('multiple'),
            });
        });
    });
</script>
