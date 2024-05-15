@php
    $gioiThieu = get_static('gioi-thieu', $lang);
    $thanhtuu = get_posts('thanhtuu', $lang, ['order_by' => ['stt' => 'asc']]);
    $veChungToi = get_posts('ve-chung-toi', $lang, ['order_by' => ['stt' => 'asc']]);
@endphp
<div class="home-gioithieuchung pt-16 pb-16 md:pb-[150px] bg-gioithieuchung bg-right-top bg-no-repeat">
    <div class="container">
        <div class="gioithieuchung">
            <div class="font-title font-bold text-xl text-[#404040] opacity-[0.5] uppercase">{{ __('Giới thiệu chung') }}
            </div>
            <div class="content-main font-title max-w-5xl font-bold text-[#404040] md:text-5xl text-xl mt-9">{!! $gioiThieu->{'mota' . $lang} !!}</div>
            <x-shared.readmore class="mt-9" href="{{ url('gioi-thieu') }}" title="{{ __('Về VMA chúng tôi') }}" />
        </div>
        <section id="section_counter">
            <div class="thanhtuu mt-20 grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-5">
                @foreach ($thanhtuu as $item)
                @php
                    $name = $item->{"ten".$lang};
                    $sl_options = (isset($item->sl_options) && $item->sl_options != '') ? json_decode($item->sl_options, true) : null;
                    $number = (int)$sl_options['conso'];
                @endphp
                    <div >
                        <div class="counter-item">
                            <div class="font-title text-primary font-bold text-6xl  uppercase counter-item-counter" data-target="{{ $number }}">0</div>
                            <hr class="opacity-20 mt-2 border-[#404040]">
                            <div class="text-base font-title font-bold mt-7 text-[#404040]">{{ $name }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        @php
            $data["img"] = Thumb::Crop(UPLOAD_PHOTO, $photo_static['bg-tamnhinsumenh']['photo'], 1200, 760, 1);
        @endphp
        <div style="background-image: url({{ $data["img"] }});" class="grid missions md:mt-14 grid-cols-2 bg-no-repeat bg-cover">
            @foreach ($veChungToi as $item)
                @php
                    $data["name"] = $item->{"ten$lang"} ?? '';
                    $data["desc"] = $item->{"mota$lang"} ?? '';
                    $data["url"] = url($item->$sluglang ?? '');
                    $data["img"] = Thumb::Crop(UPLOAD_POST, $item->photo, 600, 650, 1);
                    $data["img2"] = UPLOAD_POST. $item->photo2;
                @endphp
                <div 
                class="bg-no-repeat bg-cover relative  group">
                    <div
                        class="bg-dots group-hover:bg-none transition-all duration-300 group-hover:bg-white group-hover:bg-opacity-80 bg-cover /bg-blend-multiply absolute w-full h-full left-0 top-0 z-30">
                    </div>
                    <div class="relative z-40 flex h-full justify-center items-center mission-box max-sm:!min-h-[540px] min-h-[590px]">
                        <div class="max-w-[330px] text-center">
                            <img src="{{ $data["img2"] }}" alt="mission"
                                class="mx-auto w-[85px] transition-all duration-300 md:group-hover:w-[188px]">
                            <div class="uppercase mt-8 text-3xl font-bold font-title">{{ $data["name"] }}</div>
                            <div class="transition-all duration-300 group-hover:block block md:hidden mission-content">
                                <div class="mt-5 h-[120px] line-clamp-5 text-base">{!! $data["desc"] !!}</div>
                                <x-shared.readmore2 href="{{ url('gioi-thieu') }}">
                                    <x-slot name="icon"></x-slot>
                                </x-shared.readmore2>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<style>
    :root {
        --white: #fff;
        --bg-hero: #251c5a;
        --bg-counter: #2f2371;
        --bg-item: #5d46e2;
    }
    .counter-item {
        /* background: var(--bg-item); */
        transition: all 0.5s ease-in-out;
        transform: translateY(6rem);
    }
    .counter-item:hover {
        /* background: var(--bg-hero); */
        cursor: pointer;
        transition: all 0.5s ease-in-out;
    }
    .counter-item .counter-item-counter {
        /* letter-spacing: 0.5rem; */
        /* color: transparent; */
        /* -webkit-text-stroke-width: 0.15rem;
        -moz-text-stroke-width: 0.15rem;
        -ms-text-stroke-width: 0.15rem;
        -o-text-stroke-width: 0.15rem;
        -webkit-text-stroke-color: var(--white);
        -moz-text-stroke-color: var(--white);
        -ms-text-stroke-color: var(--white);
        -o-text-stroke-color: var(--white); */
    }

    @keyframes slide-up {
        0% {
            transform: translateY(6rem);
        }
        100% {
            transform: translateY(0rem);
        }
    }
</style>
@push('js_page')
    <script>
        $(document).ready(function() {
            // get getBoundingClientRect
            // $('.mission-box').each(function() {
            //     var heightBox = $(this).outerHeight(true);
            //     var heightContent = $(this).find('.mission-content').outerHeight(true);
            //     $(this).css('min-height', heightBox + heightContent);
            // });
            let section_counter = document.querySelector('#section_counter');
            let counters = document.querySelectorAll('.counter-item .counter-item-counter');

            // Scroll Animation

            let CounterObserver = new IntersectionObserver(
            (entries, observer) => {
                let [entry] = entries;
                if (!entry.isIntersecting) return;

                let speed = 200;
                counters.forEach((counter, index) => {
                function UpdateCounter() {
                    const targetNumber = +counter.dataset.target;
                    const initialNumber = +counter.innerText;
                    const incPerCount = targetNumber / speed;
                    if (initialNumber < targetNumber) {
                    counter.innerText = Math.ceil(initialNumber + incPerCount);
                    setTimeout(UpdateCounter, 40);
                    }
                }
                UpdateCounter();

                if (counter.parentElement.style.animation) {
                    counter.parentElement.style.animation = '';
                } else {
                    counter.parentElement.style.animation = `slide-up 0.3s ease forwards ${
                    index / counters.length + 0.5
                    }s`;
                }
                });
                observer.unobserve(section_counter);
            },
            {
                root: null,
                threshold: window.innerWidth > 768 ? 0.4 : 0.3,
            }
            );

            CounterObserver.observe(section_counter);
        });
    </script>
@endpush
