@props([
    'data' => null,
    ])
<td class="dev-item-name">
    <a href="{{ $data['edit_url'] }}">{{ $data['name'] }}</a>
</td>