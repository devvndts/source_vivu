@extends('desktop.master')

@section('content')
    <div class="container flex flex-wrap max-w-screen-xl pt-5 mb-5 detail-page-post detail-page-chinhsach bortop">
        <div class="w-full mb-5 chinhsach-left md:w-1/3">
            <div class="chinhsach-left-main">
                <div class="chinhsach-left-box">
					<x-shared.subtitle class="!text-left" title="Chính sách" >
						<span class="chinh-sach-toggle"
						data-id="#post-chinhsach"></span>
					</x-shared.subtitle>
                    <ul class="chinhsach-other {{ isset($e_active) && $e_active == 'chinhsach' ? 'post-active' : '' }}"
                        id="post-chinhsach">
                        @if (isset($chinhsach) && count($chinhsach) > 0)
                            @foreach ($chinhsach as $k => $v)
                                <li><a class="text-decoration-none [.chinhsach-active&]:bg-primary [.chinhsach-active&]:bg-opacity-10 [.chinhsach-active&]:border-primary [.chinhsach-active&]:text-primary [.chinhsach-active&]:border-solid [.chinhsach-active&]:border-[1px] {{ $v['tenkhongdau' . $lang] == $row_detail['tenkhongdau' . $lang] ? 'chinhsach-active' : '' }}"
                                        href="{{ $v['tenkhongdau' . $lang] }}" title="{{ $v['ten' . $lang] }}">
                                        {{ $v['ten' . $lang] }}
                                    </a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>

                {{-- <div class="chinhsach-left-box">
				<p class="chinhsach-list-title">Hỗ trợ khách hàng <span class="chinh-sach-toggle" data-id="#post-hotro"></span></p>
				<ul class="chinhsach-other {{(isset($e_active) && $e_active=='huongdanmuahang') ? 'post-active' : ''}}" id="post-hotro">
					@php
						$footer = app('footer');
					@endphp
					<li><div>@if ($footer){!!$footer['noidung'.$lang]!!}@endif</div></li>
		            <li><a class="text-decoration-none {{(isset($slug) && $slug=='huong-dan-mua-hang') ? 'chinhsach-active' : ''}}" href="huong-dan-mua-hang" title="Hướng dẫn mua hàng">Hướng dẫn mua hàng</a></li>
		            <li><a class="text-decoration-none" href="{{route('cart.checkcart')}}" title="Kiểm tra đơn hàng">Kiểm tra đơn hàng</a></li>
		            <li><a class="text-decoration-none {{(isset($slug) && $slug=='ma-giam-gia') ? 'chinhsach-active' : ''}}" href="ma-giam-gia" title="Mã giảm giá">Mã giảm giá</a></li>
		        </ul>
		    </div> --}}
            </div>
        </div>
        <div class="flex-1 md:ml-5 chinhsach-right">
            <div class="bg-white rounded">
				<x-shared.subtitle class="!text-left" title="{{ $row_detail['ten' . $lang] }}" />
                <div class="mb-3 text-muted d-none"><small>{{ ngaydang }}:
                        {{ date('d/m/Y h:i A', $row_detail['ngaytao']) }}</small></div>

                @if (isset($row_detail['video']) && $row_detail['video'] != '')
                    <div class="content-video"><iframe
                            src="//www.youtube.com/embed/{{ Helper::getYoutube($row_detail['video']) }}" width="100%"
                            height="0px" frameborder="0" allowfullscreen></iframe></div>
                @endif

                @if (isset($row_detail['noidung' . $lang]) && $row_detail['noidung' . $lang] != '')
                    <div class="meta-toc">
                        <div class="box-readmore">
                            <ul class="toc-list" data-toc="article" data-toc-headings="h1, h2, h3"></ul>
                        </div>
                    </div>
                    <div class="content-main w-clear" id="toc-content">{!! $row_detail['noidung' . $lang] !!}</div>
                    <div class="share">
                        <div class="flex-wrap social-plugin d-flex w-clear">
                            <div class="addthis_inline_share_toolbox_qj48"></div>
                            <div class="ml-2 zalo-share-button" data-href="{{ Helper::getCurrentPageURL() }}"
                                data-oaid="{{ $settingOption['oaidzalo'] != '' ? $settingOption['oaidzalo'] : '579745863508352884' }}"
                                data-layout="1" data-color="blue" data-customize=false></div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning" role="alert">
                        <strong>{{ noidungdangcapnhat }}</strong>
                    </div>
                @endif
            </div>

			<x-shared.subtitle class="!text-left" title="Feedback" />
			<x-buk-form id="frm_contact" class="form-contact validation-contact " action="{{ route('allpage') }}" hasFiles novalidate>
                <x-buk-input type="hidden" name="datlich[type]" value="dangkynhantin" />
                <div class="flex flex-wrap justify-between">
                    <div class="flex-1 min-w-0 mb-2 even:ml-4">
                        <x-buk-label for="{{ hoten }}" class="form-label" /> 
                        <x-buk-input class="form-control" name="datlich[tenvi]" required="true" />
                        <x-alerts.alert >{{ vuilongnhaphoten }}</x-alerts.alert>
                    </div>
                    <div class="flex-1 min-w-0 mb-2 even:ml-4">
                        <x-buk-label for="{{ sodienthoai }}" class="form-label" />
                        <x-buk-input class="form-control" name="datlich[dienthoai]" required="true" />
                        <x-alerts.alert >{{ vuilongnhapsodienthoai }}</x-alerts.alert>
                    </div>
                </div>
                <div class="flex flex-wrap justify-between">
                    <div class="flex-1 min-w-0 mb-2 even:ml-4">
                        <x-buk-label for="{{ diachi }}" class="form-label" />
                        <x-buk-input class="form-control" name="datlich[diachi]" required="true" />
                        <x-alerts.alert >{{ vuilongnhapdiachi }}</x-alerts.alert>
                    </div>
                    <div class="flex-1 min-w-0 mb-2 even:ml-4">
                        <x-buk-label for="Email" class="form-label" />
                        <x-buk-input class="form-control" name="datlich[email]" required="true" />
                        <x-alerts.alert >{{ vuilongnhapdiachiemail }}</x-alerts.alert>
                    </div>
                </div>
                <div class="flex flex-wrap justify-between">
                    <div class="flex-1 min-w-0 mb-2 even:ml-4">
                        <x-buk-label for="Bạn đã mua sản phẩm nào của Freshc?" class="form-label" />
                        <x-buk-input class="form-control" name="datlich[chude]" required="true" />
                        <x-alerts.alert >{{ vuilongnhapchude }}</x-alerts.alert>
                    </div>
                </div>
                <div class="flex flex-wrap justify-between">
                    <div class="flex-1 min-w-0 mb-2 even:ml-4">
                        <x-buk-label for="{{ noidung }} đánh giá" class="form-label" />
                        <x-buk-textarea class="form-control" name="datlich[noidung]" rows="5" required="true" />
                        <x-alerts.alert >{{ vuilongnhapnoidung }}</x-alerts.alert>
                    </div>
                </div>
                <div class="flex flex-wrap justify-between">
                    <div class="flex-1 min-w-0 mb-2 even:ml-4">
                        <x-buk-label for="{{ dinhkemtaptin }}" class="form-label" />
                        <x-buk-input type="file" name="file" class="form-control" />
                    </div>
                </div>
                <div class="flex flex-wrap justify-between">
                    <div class="flex-1 min-w-0 mb-2 even:ml-4">
                        <x-buk-label for="{{ dinhkemtaptin }} 2" class="form-label" />
                        <x-buk-input type="file" name="file2" class="form-control" />
                    </div>
                </div>
                <div class="flex flex-wrap justify-between">
                    <div class="flex-1 min-w-0 mb-2 even:ml-4">
                        <x-buk-input type="submit" name="submit-contact" value="{{ gui }}" class="btn btn-primary"  />
                    </div>
                </div>
            </x-buk-form>
        </div>

        <div class="row">
            <div class="col-sm-12 dev-center dev-paginator">{{ $chinhsach->render('desktop.layouts.paginator') }}</div>
        </div>
    </div>
@endsection

<!--css thêm cho mỗi trang-->
@push('css_page')
    <link href="{{ asset('css/chinhsach.css') }}" rel="stylesheet">
@endpush

<!--js thêm cho mỗi trang-->
@push('js_page')
    <!-- Like Share -->
    <script src="//sp.zalo.me/plugins/sdk.js"></script>

    <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55e11040eb7c994c" async="async"></script>
    <script type="text/javascript">
        var addthis_config = addthis_config || {};
        addthis_config.lang = LANG
    </script>

    <script>
        $('.chinh-sach-toggle').click(function() {
            var e_id = $(this).attr('data-id');
            $(e_id).slideToggle(400);
        });
    </script>
@endpush


@push('strucdata')
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "mainEntityOfPage":
            {
                "@type": "WebPage",
                "@id": "https://google.com/article"
            },
            "headline": "{!! $row_detail['ten' . $lang] !!}",
            "image":
            [
                "{{ isset($row_detail['photo']) ? url('/') . '/' . UPLOAD_POST . $row_detail['photo'] : '' }}"
            ],
            "datePublished": "{{ date('Y-m-d', $row_detail['ngaytao']) }}",
            "dateModified": "{{ date('Y-m-d', $row_detail['ngaysua']) }}",
            "author":
            {
                "@type": "Person",
                "name": "{!! $setting['ten' . $lang] !!}",
                "url": "{{ url()->current() }}"
            },
            "publisher":
            {
                "@type": "Organization",
                "name": "Google",
                "logo":
                {
                    "@type": "ImageObject",
                    "url": "{{ isset($logo) ? url('/') . '/' . UPLOAD_PHOTO . $logo['photo'] : '' }}"
                }
            },
            "description": "{{ SEOMeta::getDescription() }}"
        }
    </script>
@endpush
