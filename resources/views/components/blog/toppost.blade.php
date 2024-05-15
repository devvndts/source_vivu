@props(['data' => null])
<article class="flex items-center justify-between mb-5 transition-all bg-white group shadow-transparent hover:shadow-lg">
    <a href="{{ $data["url"] }}" class="block flex-shrink-0 w-[90px] relative overflow-hidden
    ">
        <figure class="z-10 transition-all duration-300 bg-cover aspect-w-1 aspect-h-1 group-hover:scale-125" style="background-image: url({{ $config_base . $data["img"] }})"></figure>
    </a>
    <div class="flex-1 min-w-0 ml-4">
        <h5 class="mb-2 text-sm">
            <a href="{{ $data["url"] }}"
            class="block tracking-wide text-black transition-all line-clamp-2 group-hover:text-gray-600"
            >{{ $data["name"] }}</a>
        </h5>
        <p class="text-[#B6B8B8] text-xs tracking-wide mb-2">
            {{ $data["post_date"] }}</p>
    </div>
</article>