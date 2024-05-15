@props([
    'data' => null,
    ])
<td class="dev-item-stt">
    <input type="number"
    class="m-auto form-control form-control-mini update-stt {{ $attributes->get("class") }}" {{ $attributes }} min="0" 
    value="{{ $data['stt'] ?? 0 }}" data-id="{{ $data['id'] ?? 0 }}"
    data-model="{{ $data['model'] ?? 'product' }}" data-level="{{ $data['level'] ?? 'man' }}" />
</td>