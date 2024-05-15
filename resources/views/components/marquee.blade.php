{{-- https://play.tailwindcss.com/VJvK9YXBoB?layout=horizontal --}}
@props([
    'items' => null
    ])
@if ($items)
    <div class="relative flex overflow-x-hidden">
        <div class="py-12 animate-marquee whitespace-nowrap">
            @foreach ($items as $item)
                <span class="mx-4 text-4xl">{{ $item->name }}</span>
            @endforeach
        </div>

        <div class="absolute top-0 py-12 animate-marquee2 whitespace-nowrap">
            @foreach ($items as $item)
                <span class="mx-4 text-4xl">{{ $item->name }}</span>
            @endforeach
        </div>
    </div>
@endif
{{-- theme: {
    extend: {
        animation: {
            marquee: 'marquee 25s linear infinite',
            marquee2: 'marquee2 25s linear infinite',
        },
        keyframes: {
            marquee: {
                '0%': { transform: 'translateX(0%)' },
                '100%': { transform: 'translateX(-100%)' },
            },  
            ma  rquee2: {
                '0%': { transform: 'translateX(100%)' },
                '100%': { transform: 'translateX(0%)' },
            },
        },
    },
    }, --}}
