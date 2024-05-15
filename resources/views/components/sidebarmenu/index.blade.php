@props([
    'type' => 'product',
    'bsParent' => '',
    'isOpen' => false,
    ])
@php
$query = DB::table('category as A')
    ->select('A.*')
    ->where('A.type', $type)
    ->where('level', '0')
    ->where('A.hienthi', '1')
    ->orderBy('A.id', 'desc')
    ->get();    
@endphp
@if ($query->count() > 0)
<div class="{{ $attributes->get("class") }}" {{ $attributes }} >
    <ul class="relative">
    @foreach ($query as $item)
        @php
            $queryLevel = $item->level + 1;
            $getQuery = DB::table('category as A')
                ->select('A.*')
                ->where('A.type', $type)
                ->where('level', $queryLevel)
                ->whereRaw('FIND_IN_SET("'. $item->id .'", ids_level_'. $queryLevel .')')
                ->where('A.hienthi', '1')
                ->orderBy('A.id', 'desc')
                ->get(); 
            $sidenavEx = $loop->iteration;
        @endphp
        <li class="relative" id="sidenavEx{{ $sidenavEx }}">
            <div class="flex items-center h-12 px-6 py-4 overflow-hidden text-sm text-gray-700 transition duration-300 ease-in-out rounded cursor-pointer text-ellipsis whitespace-nowrap hover:text-gray-900 hover:bg-gray-100"
                >
                <a href="{!! $item->{$sluglang} !!}">{!! $item->{"ten$lang"} !!}</a>
                @if ($getQuery->count() > 0)
                <svg aria-hidden="true" focusable="false" data-prefix="fas" class="w-3 h-3 ml-auto" role="img"
                data-mdb-ripple="true" data-mdb-ripple-color="dark" data-bs-toggle="collapse"
                data-bs-target="#collapseSidenavEx{{ $sidenavEx }}" aria-expanded="true" aria-controls="collapseSidenavEx{{ $sidenavEx }}"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path fill="currentColor"
                        d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z">
                    </path>
                </svg>
                @endif
            </div>
            <x-sidebarmenu.item class="relative accordion-collapse collapse {{ $isOpen ? 'show' : '' }}" id="collapseSidenavEx{{ $sidenavEx }}" aria-labelledby="sidenavEx{{ $sidenavEx }}" :data-bs-parent="$bsParent" :sidenavEx="$sidenavEx" :data="$getQuery"></x-sidebarmenu.item>
        </li>
    @endforeach    
    </ul>
</div>
@endif
