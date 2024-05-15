@props([
    'data' => null,
    ])
<td class="text-center align-middle dev-item-checkbox">
    <div class="icheck-primary d-inline dev-check">
        <input type="checkbox" class="select-checkbox"
            id="checkItem-{{ $data['id'] ?? 0 }}" value="{{ $data['id'] ?? 0 }}">
        <label for="checkItem-{{ $data['id'] ?? 0 }}"></label>
    </div>
</td>