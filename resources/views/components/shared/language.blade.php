<div class="h-10 w-[100px] px-5 bg-primary rounded-3xl">
    {{-- <span class="mr-5 text-lg font-bold">{{ __('Ngôn ngữ') }}</span> --}}
    <div class="flex items-center h-10">
        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <div class="mx-2 text-sm font-bold uppercase">
                <a class="text-white [.active&]:text-opacity-100 text-opacity-50 js-hreflang" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                    {{ $localeCode }}
                    {{-- {{ $properties['native'] }} --}}
                    {{-- <x-shared.image src="{{ asset('img/'.$localeCode.'.png') }}"></x-shared.image> --}}
                </a>
            </div>
        @endforeach
    </div>
</div>
@push('js_page')
    <script>
        $(document).ready(function() {
            $( '.js-hreflang' ).each(function( index ) {
                if ($( this ).attr('hreflang') == LANG) {
                    $( this ).addClass('active');
                }
            });
        })
    </script>
@endpush
