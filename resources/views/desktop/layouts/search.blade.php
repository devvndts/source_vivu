{{-- <span class="inline-flex items-center justify-center bg-transparent rounded-full cursor-pointer flex-nowrap header-search  text-primary ml-[30px]">
    <img src="{{ asset('public/images/ic-search.png') }}" alt="cart">
    <span class="material-icons"> search </span>
</span> --}}
<div
    class="/absolute shadow-2xl border-0 right-0 /hidden hidden lg:flex justify-center  transition-all [.active&]:flex top-full bg-transparent dekstop-search rounded-sm">
    <div class="w-full">
        <div class="relative flex  items-stretch w-full input-group">
            <button onclick="onSearch('keyword');"
                class="flex items-center justify-center px-0 py-0 mb-0 mr-0 text-xs font-medium leading-tight text-white uppercase transition duration-150 ease-in-out rounded-none  bg-primary w-9 btn /hover:bg-primary-700 /hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                type="button" id="button-addon2">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="search" class="w-5"
                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path fill="currentColor"
                        d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z">
                    </path>
                </svg>
            </button>
            <input onkeypress="doEnter(event,'keyword');" id="keyword" type="search"
                class="form-control /order-2 relative flex-auto min-w-0 block w-[120px] px-3 py-1.5 text-sm font-normal placeholder:text-[#404040] placeholder:text-opacity-50 text-white bg-transparent bg-clip-padding border border-transparent border-solid  rounded-none transition ease-in-out m-0 focus:text-white focus:bg-transparent focus:border-transparent focus:outline-none focus:outline-0 focus:!shadow-none"
                placeholder="{{ __("Tìm kiếm") }}" aria-label="Search" aria-describedby="button-addon2">
        </div>
    </div>
</div>

@push('js_page')
    <script>
        $(document).ready(function() {
            // $('.header-search').click(() => {
            //     $('.dekstop-search').toggleClass('active');
            // });
        })
    </script>
@endpush

