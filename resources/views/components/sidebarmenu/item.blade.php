@props(['data' => null])
@if ($data->count() > 0)
<ul {{ $attributes }}>
@foreach ($data as $item)
    @php
        $queryLevel = $item->level + 1;
        $paddingLeft = 'padding-left: ' . (24 + ($queryLevel * 10)) . 'px;';
        $getQuery = DB::table('category as A')
            ->select('A.*')
            ->where('A.type', 'product')
            ->where('level', $queryLevel)
            ->whereRaw('FIND_IN_SET("'. $item->id .'", ids_level_'. $queryLevel .')')
            ->where('A.hienthi', '1')
            ->orderBy('A.id', 'desc')
            ->get(); 
    @endphp
    <li class="relative">
        <a href="{{ $item->{$sluglang} }}"
            class="flex items-center h-6 py-4 pr-6 overflow-hidden text-xs text-gray-700 transition duration-300 ease-in-out rounded text-ellipsis whitespace-nowrap hover:text-gray-900 hover:bg-gray-100"
            style="{{ $paddingLeft }}"
            data-mdb-ripple="true" data-mdb-ripple-color="dark">
            {!! $item->{"ten$lang"} !!}
        </a>
        @if ($getQuery->count() > 0)
        <x-sidebarmenu.item :data="$getQuery"></x-sidebarmenu.item>
        @endif
    </li>
@endforeach    
</ul>
@endif