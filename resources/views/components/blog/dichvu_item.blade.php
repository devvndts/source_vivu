@props([
    'isFancybox' => false,
    'data' => null,
    ])
    @php
    $fancyboxText = ($isFancybox) ? "data-fancybox=\"\"" : '';   
    @endphp
<article class="mb-6 transition-all bg-white rounded-lg group shadow-transparent hover:shadow-lg ">
    <a {!! $fancyboxText !!} href="{{ $data["url"] }}" class="relative block mb-4 overflow-hidden rounded-md">
        {{-- <div class="absolute top-0 left-0 z-20 w-full h-full transition-all bg-transparent hover:bg-white hover:bg-opacity-30"></div> --}}
        <figure class="z-10 overflow-hidden transition-all duration-300 bg-cover aspect-w-4 aspect-h-3 group-hover:scale-125" style="background-image: url({{ $config_base . $data["img"] }})"></figure>
    </a>
    <div class="px-4 pb-4">
        <p class="text-[#B6B8B8] text-sm tracking-wide mb-2">
            By Admin - {{ $data["post_date"] }}</p>
        <h5 class="text-sm">
            <a href="{{ $data["url"] }}" {!! $fancyboxText !!}
                class="block tracking-wide text-black transition-all line-clamp-2 group-hover:text-gray-600"
            >{{ $data["name"] }}</a>
        </h5>
    </div>
</article>