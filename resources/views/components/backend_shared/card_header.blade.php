@props([
    'isShowMinus' => false,
    ])
<div class="card-header">
    <h3 class="card-title">{{ $slot }}</h3>
    @isset($other_info)
    {{ $other_info }}
    @endisset
    @if ($isShowMinus)
    <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
        </button>
    </div>
    @endif
</div>