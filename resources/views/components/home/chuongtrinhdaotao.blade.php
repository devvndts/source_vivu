@php
    $chuongTrinhDaoTaoLevel1 = get_categories('chuong-trinh-dao-tao', $lang, ["query" => ["level" => "0", "noibat" => "1"]]);
    $bgChuongTrinhDaoTao = get_photos('bg-chuongtrinhdaotao', $lang);
    $styleBg = '';
    if(count($bgChuongTrinhDaoTao) > 0) {
        // $styleBg = 'style="background-image: url('.UPLOAD_CATEGORY.$bgChuongTrinhDaoTao[0]->photo.')"';
        $styleBg = sprintf('style="background-image: url(%s)"', UPLOAD_PHOTO.$bgChuongTrinhDaoTao[0]->photo);
    }
@endphp
<div {!! $styleBg !!} class=" py-20 bg-cover bg-no-repeat">
    <div class="container max-w-[1412px] grid gap-3 grid-cols-2 md:gap-6 md:grid-cols-4">
        @if ($chuongTrinhDaoTaoLevel1)
        @php
            $data["name"] = $chuongTrinhDaoTaoLevel1[0]->{"ten$lang"} ?? '';
            $data["desc"] = $chuongTrinhDaoTaoLevel1[0]->{"mota$lang"} ?? '';
            $data["photoUrl"] = $chuongTrinhDaoTaoLevel1[0]->photo ?? '';
            $data["url"] = $chuongTrinhDaoTaoLevel1[0]->$sluglang ?? '';
            $data["img"] = Thumb::Crop(UPLOAD_CATEGORY, $data["photoUrl"] ?? '', 100, 100, 2);
        @endphp
        <div class="rounded-[50px] bg-white bg-opacity-10 md:py-[100px] py-5 px-5 md:px-[47px] border border-primary col-start-1 col-end-3 /md:col-start-1 /md:col-end-3 md:row-span-2 group hover:bg-primary transition-all duration-300">
            <div>
                <div class="w-[100px]">
                    <a href="{{ $data["url"] }}" class=" block aspect-w-1 aspect-h-1 bg-contain transition-all duration-300 /group-hover:bg-white group-hover:filter group-hover:brightness-0 group-hover:invert group-hover:grayscale" style="background-image: url({{ $data["img"] }})">
                        {{-- <img src="public/pts/chuongtrinhdaotao01.png" alt="" class="w-[100px]"> --}}
                    </a>
                </div>
                <h3 class="text-xl md:text-4xl mt-10 font-extrabold">
                    <a href="{{ $data["url"] }}" class="text-white uppercase">
                        {{ $data["name"] }}
                    </a>
                </h3>
                <div class="content-main mt-6 text-sm line-clamp-9 text-white">
                    {!! nl2br($data["desc"]) !!}
                </div>
            </div>
        </div>
        @foreach ($chuongTrinhDaoTaoLevel1 as $item)
            @if ($loop->index == 0)
                @continue
            @endif
            @php
                $data["name"] = $item->{"ten$lang"} ?? '';
                $data["desc"] = $item->{"mota$lang"} ?? '';
                $data["photoUrl"] = $item->photo ?? '';
                $data["url"] = $item->$sluglang ?? '';
                $data["img"] = Thumb::Crop(UPLOAD_CATEGORY, $data["photoUrl"] ?? '', 100, 100, 2);
            @endphp
            <div class="rounded-[10px] bg-white bg-opacity-10 py-3 px-3 md:py-[45px] md:px-[27px] border border-primary hover:bg-primary transition-all duration-300 group">
                <div>
                    <div class="w-[40px]">
                        <a href="{{ $data["url"] }}" class=" block aspect-w-1 aspect-h-1 bg-contain transition-all duration-300 /group-hover:bg-white group-hover:filter group-hover:brightness-0 group-hover:invert group-hover:grayscale" style="background-image: url({{ $data["img"] }})">
                            {{-- <img src="public/pts/chuongtrinhdaotao01.png" alt="" class="w-[40px]"> --}}
                        </a>
                    </div>
                    <h3 class="text-sm md:text-2xl mt-5 font-extrabold">
                        <a href="{{ $data["url"] }}" class="text-white uppercase">
                            {{ $data["name"] }}
                        </a>
                    </h3>
                    <div class="content-main mt-2 md:mt-4 text-xs md:text-sm line-clamp-4 text-white">
                            {!! nl2br($data["desc"]) !!}
                    </div>
                </div>
            </div>
        @endforeach
        @endif
        {{-- <div class="rounded-[10px] bg-white bg-opacity-10 py-[100px] px-[47px] border border-primary col-start-1 col-end-3 row-span-2">
            <div>
                <a href="">
                    <img src="public/pts/chuongtrinhdaotao01.png" alt="" class="w-[100px]">
                </a>
                <h3 class=" text-4xl mt-10 font-extrabold">
                    <a href="" class="text-white uppercase">
                        Tester/Automation
                    </a>
                </h3>
                <div class="content-main mt-6 text-sm line-clamp-9 text-white">
                        Năm 2022 không chỉ là năm tiền đề cho hành trình 3 năm chinh phục mục tiêu lớn IPO vào năm 2025 mà còn ghi dấu hành trình 10 năm VMO không ngừng chuyển mình, đổi mới và tăng trưởng bứt phá. Đặc biệt, với việc hoàn thiện hệ sinh thái, VMO tự hào chào đón các công ty thành viên mới đang từng bước cùng VMO khẳng định vị thế toàn cầu.
                        <br>
                        Năm 2022 không chỉ là năm tiền đề cho hành trình 3 năm chinh phục mục tiêu lớn IPO vào năm 2025 mà còn ghi dấu hành trình 10 năm VMO không ngừng chuyển mình, đổi mới và tăng trưởng bứt phá. Đặc biệt, với việc hoàn thiện hệ sinh thái, VMO tự hào chào đón các công ty thành viên mới đang từng bước cùng VMO khẳng định vị thế toàn cầu.
                </div>
            </div>
        </div>
        @for ($i = 0; $i < 4; $i++)
            <div class="rounded-[10px] bg-white bg-opacity-10 py-[45px] px-[27px] border border-primary">
                <div>
                    <a href="">
                        <img src="public/pts/chuongtrinhdaotao01.png" alt="" class="w-[40px]">
                    </a>
                    <h3 class=" text-2xl mt-5 font-extrabold">
                        <a href="" class="text-white uppercase">
                            Tester/Automation
                        </a>
                    </h3>
                    <div class="content-main mt-4 text-sm line-clamp-4 text-white">
                            Năm 2022 không chỉ là năm tiền đề cho hành trình 3 năm chinh phục mục tiêu lớn IPO vào năm 2025 mà còn ghi dấu hành trình 10 năm VMO không ngừng chuyển mình, đổi mới và tăng trưởng bứt phá. Đặc biệt, với việc hoàn thiện hệ sinh thái, VMO tự hào chào đón các công ty thành viên mới đang từng bước cùng VMO khẳng định vị thế toàn cầu.
                            <br>
                            Năm 2022 không chỉ là năm tiền đề cho hành trình 3 năm chinh phục mục tiêu lớn IPO vào năm 2025 mà còn ghi dấu hành trình 10 năm VMO không ngừng chuyển mình, đổi mới và tăng trưởng bứt phá. Đặc biệt, với việc hoàn thiện hệ sinh thái, VMO tự hào chào đón các công ty thành viên mới đang từng bước cùng VMO khẳng định vị thế toàn cầu.
                    </div>
                </div>
            </div>
        @endfor --}}
    </div>
</div>