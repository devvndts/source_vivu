@props([
    'data' => null,
    'loai' => 'edit',
    ])
@php
    $oparation = [
        'print' => ['class'=>'','title'=>__('In đơn hàng'),'icon'=>'<i class="far fa-print"></i>','url'=>$data['print_url'] ?? ''],
        'edit' => ['class'=>'','title'=>__('Chỉnh sửa'),'icon'=>'<i class="fas fa-pencil-alt"></i>','url'=>$data['edit_url'] ?? ''],
        'delete' => ['class'=>'delete-item','title'=>__('Xóa'),'icon'=>'<i class="fas fa-trash-alt"></i>','url'=>$data['delete_url'] ?? ''],
    ];
@endphp
<a class="btn btn-sm d-block {{ $attributes["class"] }} {{ $oparation[$loai]['class'] }} btn-none-css" {{ $attributes }}
    @if (in_array($loai, ['edit', 'print']))
        href="{{ $oparation[$loai]['url'] }}"
    @else
        data-url="{{ $oparation[$loai]['url'] }}"
    @endif
    title="{{ $oparation[$loai]['title'] }}">{!! $oparation[$loai]['icon'] !!} {{ $oparation[$loai]['title'] }}</a>