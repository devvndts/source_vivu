@php
// use App\Models\Category;
// $chinhsachfooters = app('chinhsachfooters');
// $danhmuc_cap3 = app('danhmuc_cap3');
// $danhmuc_cap1 = app('danhmuc_cap1');
// $bocongthuong = $photo_static['bocongthuong'];
// $bocongthuong2 = $photo_static["bocongthuong2"];
// $banner_2 = $photo_static["banner_2"];
// $ketnoi = app('ketnoi');
$chinh_sach = get_posts('chinh-sach', $lang,  ["order_by" => ["stt" => "asc"]]);
$ve_chung_toi = get_posts('ve-chung-toi', $lang,  ["order_by" => ["stt" => "asc"]]);
// $dich_vu = get_posts('dich-vu', $lang,  ["order_by" => ["stt" => "asc"]]);
$mangxahoi_f = get_photos('mangxahoi_f', $lang, ["order_by" => ["stt" => "asc"]]);
$bocongthuong = get_static_photo('bocongthuong');
// $mangxahoi3 = get_photos('icon_payment', $lang, ["order_by" => ["stt" => "asc"]]);
// $productCategories = get_categories('product', $lang, ["query" => ["level" => "0"]]);
// $shops = get_posts('shop',$lang);
$footer = get_static('footer', $lang);
// $logo_address = get_static_photo('logo-address', $lang);
// $bocongthuong = get_photos('bocongthuong', $lang);
$img = (isset($footer->photo) && $footer->photo) ? UPLOAD_STATICPOST . $footer->photo : '';
// $img2 = (isset($bocongthuong->photo) && $bocongthuong->photo) ? Thumb::Crop(UPLOAD_PHOTO, $bocongthuong->photo, 80, 30, 2) : '';
$footer_title = __('Đăng ký nhận thông báo');
$footer_title_1 = $settingOption['footer_title_1'] ?? '';
$footer_title_2 = $settingOption['footer_title_2'] ?? '';
$footer_title_3 = $settingOption['footer_title_3'] ?? '';
@endphp
{{-- <div class="home-dangkynhantin bg-primary bg-dangkynhantin bg-no-repeat bg-right-top py-10">
	<div class="container lg:flex flex-wrap gap-7 items-center justify-between">
		<div class="uppercase text-[#404040] text-3xl font-bold">{{ __('Đăng ký nhận tin') }}</div>
		<x-buk-form id="frm_newsletter" class="relative form-newsletter z-20 validation-newsletter flex flex-wrap flex-1 gap-3 xl:mt-0 mt-3" action="{{ route('allpage') }}" novalidate>
			<x-buk-input type="hidden" name="allpage_type" value="dangkynhantin" />
			<x-buk-input type="hidden" name="dangkynhantin[type]" value="dangkynhantin" />
			<x-forms.group class="!mb-0 w-full flex-none xl:flex-1 xl:w-auto">
				<x-buk-input placeholder="Tên" class='form-control rounded-[50px] !bg-transparent h-[45px] border placeholder:text-white text-white border-solid border-white ' type="text"  name="dangkynhantin[tenvi]" required />
				<x-alerts.alert >{{ __('Vui lòng nhập tên') }}</x-alerts.alert>
			</x-forms.group>
			<x-forms.group class="!mb-0 w-full flex-none xl:flex-1 xl:w-auto">
				<x-buk-input placeholder="Email" class='form-control rounded-[50px] !bg-transparent h-[45px] border placeholder:text-white text-white border-solid border-white ' type="email" name="dangkynhantin[email]" required />
				<x-alerts.alert >{{ __('Vui lòng nhập địa chỉ email') }}</x-alerts.alert>
			</x-forms.group>
			<x-buk-input type="submit" name="submit-nhantin" value="{{ __('Đăng ký nhận tin') }}" class="btn [&]:!shadow-none !outline-0 !outline-none btn-primary px-[86px] [&]:leading-none !bg-white text-xs text-primary uppercase w-full xl:w-auto font-bold rounded-[50px] h-[45px] [&]:mb-0 [&]:mx-0 "  />
		</x-buk-form>
	</div>
</div> --}}
<div class="bg-[#000000] pt-8 pb-2" style="background: url('img/bgfooter.png') no-repeat">
	<div class="container border-b-[1px] border-white border-dashed max-w-[1220px] px-[10px] flex flex-wrap justify-between md:gap-5">
		<div class="w-full md:w-[35%]">
			<x-shared.image class="max-w-full mx-auto inline-block" src="{{ $img }}" />
			<div class="content-main text-white mt-5">
				@if($footer){!!$footer->{'mota'.$lang}!!}@endif
			</div>
		</div>
		<div class="pt-[54px] w-1/2 md:w-[17%] ">
			<x-shared.footer_title  :title="$footer_title_1" />
			<x-footer.list class="mb-5 text-sm" >
				<x-footer.list.item href="cam-nang"  >Cảm Nang</x-footer.list.item>
				<x-footer.list.item href="kham-pha"  >Khám Phá</x-footer.list.item>
				<x-footer.list.item href="sale"  >Sale</x-footer.list.item>
			</x-footer.list>
			{{-- <a href="{{ $bocongthuong->link ?? '' }}" class="mb-5">
				<x-shared.image class="max-w-[80px] mx-auto inline-block" src="{{ $img2 }}" />
			</a> --}}
		</div>
		<div class="pt-[54px] w-1/2 md:w-[17%] ">
			<x-shared.footer_title  :title="$footer_title_2" />
			<x-footer.list class="mb-5 text-sm" >
				@foreach ($ve_chung_toi as $item)
				@php
					$name = $item->{"ten$lang"} ?? '';
					$url = url($item->{$sluglang} ?? '');
				@endphp
					<x-footer.list.item href="{{ $url }}"  >{{ $name }} </x-footer.list.item>
				@endforeach
			</x-footer.list>
		</div>
		<div class="pt-[54px] w-full md:w-[17%] ">
			<x-shared.footer_title  :title="$footer_title_3" />
			<x-shared.social class="mt-12" :data=$mangxahoi_f />
		</div>
	</div>
	<div class="text-sm my-5 text-white text-center">Bản quyền © <strong class="text-primary text-bold">VNDTS - 2024</strong>. All rights reserved.</div>
</div>
{{-- <div class="py-5 bg-secondary">
	<div class="container flex flex-wrap justify-between max-w-screen-xl mx-auto lg:flex-nowrap">
		<div class="lg:px-[86px] p-5 lg:py-[30px] border-opacity-50 border-white w-full lg:w-1/2 lg:order-2 border-solid lg:border-[1px] border-y-0 text-center">
			<figure class="mb-5">
				<x-shared.image class="max-w-[270px] mx-auto inline-block" src="{{ $img }}" />
			</figure>
			<div class="text-sm text-secondary mb-[20px]">
				@if($footer){!! nl2br($footer->{'mota'.$lang}) !!}@endif
			</div>
			<div class="mb-4 text-base font-medium text-center uppercase text-secondary">Theo dõi tôi</div>
			
		</div>
		<div class="lg:order-1 pt-[54px] w-[49%] lg:w-[265px] text-center">
			<x-shared.footer_title  title="Về chúng tôi" />
			<x-footer.list class="mb-5 text-sm" >
				@foreach ($ve_chung_toi as $item)
				@php
					$name = $item->{"ten$lang"} ?? '';
					$url = url($item->{$sluglang} ?? '');
				@endphp
					<x-footer.list.item href="{{ $url }}"  >{{ $name }} </x-footer.list.item>
				@endforeach
			</x-footer.list>
			<div class="text-sm text-white">© 2023 Yodiva Spa. Designed by Nexty</div>
		</div>
		<div class="lg:order-3 pt-[54px] w-[49%] lg:w-[265px] text-center">
			<x-shared.footer_title  title="Chính sách" />
			<x-footer.list class="mb-5 text-sm" >
				@foreach ($chinh_sach as $item)
				@php
					$name = $item->{"ten$lang"} ?? '';
					$url = url($item->{$sluglang} ?? '');
				@endphp
					<x-footer.list.item href="{{ $url }}"  >{{ $name }} </x-footer.list.item>
				@endforeach
			</x-footer.list>
			<a href="{{ $bocongthuong->link ?? '' }}" class="mb-5">
				<x-shared.image class="max-w-[80px] mx-auto inline-block" src="{{ $img2 }}" />
			</a>
		</div>
	</div>
</div> --}}
{{-- <div class="relative z-10 footer bg-[#4B8564]/20">
	<div class="absolute left-0 z-0 top-0 w-full h-[200px] [.home\_content_&]:bg-[#f6f9f7] bg-white"></div>
	<div class="relative z-10">
		<div class="container max-w-screen-xl">
			<x-home.cohoikinhdoanh />
			<div class="flex flex-wrap justify-between lg:flex-nowrap">
				<div class="w-full mb-3 lg:w-1/3 lg:mb-0">
					<div class="flex items-center">
						<span class="material-icons text-primary"> phone </span>
						<span class="text-base text-[#121212]/50 ml-2">Hotline</span>
					</div>
					<div class="text-base text-[#121212]">
						{{ $settingOption["hotline"] ?? '' }}
					</div>
				</div>
				<div class="flex flex-wrap justify-between lg:flex-nowrap lg:flex-1">
					<div class="w-full mb-3 lg:mb-0 lg:w-auto">
						<div class="flex items-center">
							<span class="material-icons text-primary"> email </span>
							<span class="text-base text-[#121212]/50 ml-2">Chăm Sóc Khách Hàng</span>
						</div>
						<div class="text-base text-[#121212]">
							{{ $settingOption["email"] ?? '' }}
						</div>
					</div>
					<div class="w-full lg:w-auto">
						<div class="flex items-center">
							<span class="material-icons text-primary"> location_on </span>
							<span class="text-base text-[#121212]/50 ml-2">Địa chỉ</span>
						</div>
						<div class="text-base text-[#121212]">
							{{ $settingOption["diachi"] ?? '' }}
						</div>
					</div>
				</div>
			</div>
			<hr class="my-7">
			<div class="flex flex-wrap justify-between lg:flex-nowrap">
				<div class="w-full mb-4 lg:mb-0 lg:w-1/3">
					<div>
						@if($footer){!!$footer['noidung'.$lang]!!}@endif
					</div>
				</div>
				<div class="flex flex-wrap justify-between w-full lg:flex-nowrap lg:w-auto lg:flex-1">
					<div>
						<x-shared.footer_title title="{{ __('Chính sách') }}" />
						<x-footer.list class="text-sm" >
							@foreach ($chinh_sach as $item)
							@php
								$name = $item->{"ten$lang"} ?? '';
								$url = url($item->{$sluglang} ?? '');
							@endphp
								<x-footer.list.item href="{{ url($url) }}"  >{{ $name }} </x-footer.list.item>
							@endforeach
						</x-footer.list>
					</div>
					<div>
						<x-shared.footer_title title="{{ __('Sản phẩm') }}" />
						<x-footer.list class="text-sm" >
							@foreach ($productCategories as $item)
							@php
								$name = $item->{"ten$lang"} ?? '';
								$url = url($item->{$sluglang} ?? '');
							@endphp
								<x-footer.list.item href="{{ url($url) }}"  >{{ $name }} </x-footer.list.item>
							@endforeach
						</x-footer.list>
					</div>
					<div>
						<x-shared.footer_title title="{{ __('Theo dõi chúng tôi') }}" />
						<x-shared.social :data=$mangxahoi />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="bg-primary">
	<div class="container max-w-screen-xl">
		<div class="flex flex-wrap justify-center items-center min-h-[30px] ">
			<div class="text-xs text-white copyright__text">
				{{ $settingOption["copyright"] ?? '' }}
			</div>
		</div>
	</div>
</div> --}}
<x-shared.utilities  />
