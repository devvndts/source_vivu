<div>
	<div class="relative text-white flex z-2 h-[500px] !bg-cover !bg-[50%]" style="background: linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.6)),url('{{ UPLOAD_PHOTO . $photo_static['bg-slide']['photo'] }}') no-repeat" >
		<div class="w-[1220px] px-[10px] m-auto">
            <div class="flex flex-col items-center">
                <h2 class="text-[42px] font-semibold">TÌM KIẾM ĐỊA ĐIỂM DU LỊCH TẠI TPHCM</h2>
                <p class="font-medium text-xl">Địa Điểm Ăn Uống - Mua Sắm - Giải Trí - Du Lịch tại TP. Hồ Chí Minh</p>
            </div>
            <div class="w-full mt-8">
                <div class="relative flex gap-5 items-stretch w-full input-group">
                    <input onkeypress="doEnter(event,'keyword');" id="keyword" type="search"
                        class="form-control /order-2 relative flex-auto min-w-0 block w-full px-3 py-1.5 text-sm placeholder:text-[#858585] placeholder:text-opacity-50 placeholder:text-[16px] placeholder:font-medium indent-[38px] bg-white text-white bg-transparent bg-clip-padding border border-transparent border-solid  rounded-full transition ease-in-out m-0 focus:text-[#22B5BB] focus:bg-white focus:border-transparent focus:outline-none focus:outline-0 focus:!shadow-none"
                        placeholder="{{ __("Tìm kiếm tên quán, khu vực, kiểu quán, ...") }}" aria-label="Search" aria-describedby="button-addon2">
                        <button onclick="onSearch('keyword');"
                        class="flex items-center justify-center px-0 py-0 mb-0 mr-0 text-xs font-medium leading-tight text-white uppercase transition duration-150 ease-in-out rounded-full h-[60px]  bg-[#22B5BB] w-[200px] btn /hover:bg-primary-700 /hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                        type="button" id="button-addon2">
                        <strong class="font-semibold mr-2 text-xl">TÌM NGAY</strong>
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.9268 8.85642C15.8832 5.26201 13.4168 2.34788 9.99318 1.76664C5.45719 0.99637 1.37519 4.68303 1.68766 9.26787C1.91976 12.6738 4.44504 15.3768 7.83076 15.8449C8.95386 16 10.0487 15.8794 11.1225 15.5296C11.6133 15.3695 12.0509 15.541 12.2383 15.9626C12.4477 16.434 12.1975 16.9383 11.6569 17.1172C9.92808 17.6893 8.18399 17.7556 6.42348 17.266C2.89341 16.2846 0.34379 13.2092 0.032446 9.55594C-0.364376 4.89527 2.92172 0.747348 7.5313 0.0902691C12.3696 -0.599636 16.8495 2.73953 17.5085 7.55811C17.8068 9.74045 17.3556 11.7768 16.1419 13.6303C15.8034 14.147 15.843 14.6479 16.2806 15.091C17.076 15.8964 17.8787 16.6944 18.6797 17.4941C18.9129 17.7267 19.0584 17.9921 18.9774 18.3306C18.8172 19.0001 18.0717 19.2242 17.5628 18.7403C16.9548 18.1619 16.3701 17.5586 15.7768 16.9655C15.1762 16.3656 14.579 15.7628 13.9773 15.164C13.4751 14.6643 13.4661 14.2313 13.9484 13.7208C15.2589 12.3331 15.898 10.6765 15.9268 8.85642Z" fill="white"/>
                            <path d="M9.05236 14.3389C8.86046 14.3151 8.66516 14.3208 8.49194 14.2625C8.1121 14.1346 7.90378 13.7384 7.96888 13.3332C8.02832 12.9647 8.33683 12.671 8.73139 12.6568C9.66429 12.6234 10.5145 12.3727 11.2369 11.7626C12.0599 11.0671 12.5366 10.1887 12.6175 9.106C12.6266 8.98376 12.6334 8.86151 12.647 8.73983C12.7013 8.25763 13.054 7.94635 13.5227 7.96446C13.9789 7.98201 14.3056 8.33856 14.3112 8.82529C14.339 11.3489 12.5207 13.6127 9.99771 14.1849C9.6875 14.2551 9.36823 14.2885 9.05236 14.3389Z" fill="white"/>
                            </svg>
                            
                    </button>
                </div>
            </div>
        </div>
	</div>
</div>
