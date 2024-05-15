@props([
    'data' => null,
    'selectedIds' => null,
])
<select class="form-control
    {{ $attributes->get('class') }}"
    {{ $attributes }}>
    <option value="0|0">{{ __('Chọn danh mục') }}</option>
    {{ Helper::showCategories($data, (int)$selectedIds) }}
</select>