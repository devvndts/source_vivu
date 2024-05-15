@props([
    'url' => '',
    'keyword' => '',
])
<div class="mb-2 align-middle form-inline col-sm-3 form-search d-inline-block">
    <div class="input-group input-group-sm">
        <input class="text-sm form-control form-control-navbar" type="search" id="keyword" placeholder="{{ __('Tìm kiếm') }}" aria-label="{{ __('Tìm kiếm') }}" value="{{ $keyword ?? '' }}" onkeypress="doEnter(event,'keyword','{{ $url }}')" />
        <div class="input-group-append bg-primary rounded-right">
            <button class="text-white btn btn-navbar" type="button"
            onclick="onSearch('keyword','{{ $url }}')">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</div>