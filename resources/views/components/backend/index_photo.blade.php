@props([
    'data' => null,
    ])
<td class="dev-item-img">
    <x-shared.image src="{{ $data['photo_url'] ?? '' }}" />
</td>