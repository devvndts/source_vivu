@props([
    'data' => null,
    ])
    @php
        $categories = [];
        $result = null;
        if ($data['ids_level_1']) {
            $object = Helper::getInfoCategory($data['ids_level_1']);
            $name = $object["tenvi"]; 
            $url = route('admin.category.edit', [$object['type'], $object['id']]);
            $categories[] = ['name'=>$name,'url'=>$url];
        }
        if ($data['ids_level_2']) {
            $object = Helper::getInfoCategory($data['ids_level_2']);
            $name = $object["tenvi"]; 
            $url = route('admin.category.edit', [$object['type'], $object['id']]);
            $categories[] = ['name'=>$name,'url'=>$url];
        }
        foreach ($categories as $key => $item) {
            $result[] = sprintf('<a href="%s">%s</a>', $item['url'], $item['name']);
        }
    @endphp
    <td class="dev-item-name">
    @if ($result)
        {!! implode(' | ', $result) !!}
    @endif
    </td>
