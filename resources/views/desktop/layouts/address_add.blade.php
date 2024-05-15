<div style="display:none;">
    <div id="address_user">
        <h5 class="font-weight-bold text-center mb-3">Thêm địa chỉ nhận hàng</h5>
        <form class="js-add-address validation-address" autocomplete="off" novalidate method="post" action="{{route('address.add')}}">
            @csrf
            <div class="bg-light rounded p-2 input-cart mb-3">
                <label class="fs-14 font-weight-bold">Loại địa chỉ (Cơ quan, Nhà riêng, Chung cư,...) </label>
                <input type="text" class="form-control" id="tenvi" name="data[tenvi]" placeholder="Loại địa chỉ" required />
                <div class="invalid-feedback">Vui lòng nhập loại địa chỉ (Cơ quan, Nhà riêng, Chung cư,...)</div>
            </div>
            <div class="bg-light rounded p-2 input-cart mb-3">
                <label class="fs-14 font-weight-bold">Họ và tên</label>
                <input type="text" class="form-control" id="hoten" name="data[hoten]" placeholder="Họ và tên" value="{{$user_info['name']}}" required />
                <div class="invalid-feedback">Vui lòng nhập Họ và tên</div>
            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="bg-light rounded p-2 input-cart mb-3">
                        <label class="fs-14 font-weight-bold">Email</label>
                        <input type="email" class="form-control" id="email" name="data[email]" placeholder="Email" value="{{$user_info['email']}}" required />
                        <div class="invalid-feedback">Vui lòng nhập Email</div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="bg-light rounded p-2 input-cart mb-3">
                        <label class="fs-14 font-weight-bold">Số điện thoại</label>
                        <input type="number" class="form-control" id="dienthoai" name="data[dienthoai]" placeholder="Số điện thoại" value="{{$user_info['phonenumber']}}" required />
                        <div class="invalid-feedback">Vui lòng nhập Số điện thoại</div>
                    </div>
                </div>
            </div>
            <div class="bg-light rounded p-2 input-cart mb-3">
                <label class="fs-14 font-weight-bold">Tỉnh/Thành phố</label>
                <select class="select-city-cart select2 w-100" id="id_city" name="data[id_city]" required>
                    <option value="">{{tinhthanh}}</option>
                    @foreach ($city as $key => $value)
                        <option value="{{$value['id']}}">{{$value['ten']}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">Vui lòng chọn Tỉnh/Thành phố</div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="bg-light rounded p-2 input-cart mb-3">
                        <label class="fs-14 font-weight-bold">Quận/Huyện</label>
                        <select class="select-district-cart select-district select2 w-100" id="id_district" name="data[id_district]" required>
                            <option value="">Quận/Huyện</option>
                        </select>
                        <div class="invalid-feedback">Vui lòng chọn Quận/Huyện</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="bg-light rounded p-2 input-cart mb-3">
                        <label class="fs-14 font-weight-bold">Phường/Xã</label>
                        <select class="select-wards-cart select-wards select2 w-100" id="id_ward" name="data[id_ward]" required>
                            <option value="">Phường/Xã</option>
                        </select>
                        <div class="invalid-feedback">Vui lòng chọn Phường/Xã</div>
                    </div>
                </div>
            </div>
            <div class="bg-light rounded p-2 input-cart mb-3">
                <label class="fs-14 font-weight-bold">Số nhà, Ấp (thôn, xóm), Đường</label>
                <textarea class="form-control" name="data[address]" id="address" placeholder="Địa chỉ chi tiết" required></textarea>
                <div class="invalid-feedback">Vui lòng nhập địa chỉ chi tiết</div>
            </div>
            <div class="d-flex justify-content-end">
                <button type="button" data-fancybox-close class="btn btn-light">Hủy</button>
                <button type="submit" class="btn btn-dark ml-2">Lưu</button>
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
