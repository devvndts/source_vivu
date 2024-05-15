<li class="mb-2 {{ $attributes->get('class') }}">
    
    @if ($attributes->get('href'))
        <a class="block text-sm text-white transition-colors hover:text-primary-300" href="{{ $attributes->get('href') }}">{{ $slot }}</a>
    @else
        <span class="block text-sm text-white transition-colors " >{{ $slot }}</span>
    @endif
</li>
