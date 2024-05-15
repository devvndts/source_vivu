<?php
//Thông tin cấu hình
define('URL_DEMO', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . '/naturalpharm');
define('URL_CALLBACK', URL_DEMO . '/alepay/success'); // URL đón nhận kết quả 
    return [
        "payment_online" => false,
        "momo" => [
            "active" => false,
        ],
        "alepay" => [
            "active" => false,
            "type" => "sandbox",
            "sandbox" => array(
                "apiKey" => "sTGY4EUpU2np6cEmNJai6ZTslSpsaG", //Là key dùng để xác định tài khoản nào đang được sử dụng.
                "encryptKey" => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCXPY7pOqLnriRjBWElfPFHwUC10MlYs1mDccVhyjX7U2euKuwLHGHSRJReaIA5GU7xxbRAjCyECJA0XrbtMJXvSTIp5TAPvrsxd9BIDeGSXznvV949dHZyPQ", //Là key dùng để mã hóa dữ liệu truyền tới Alepay.
                "checksumKey" => "EGXLT4z3IN8RHdBbE15HQcctNNqpGI", //Là key dùng để tạo checksum data.
                "callbackUrl" => URL_CALLBACK,
                "env" => "test",
            )
        ],
        "nganluong" => [
            "active" => false,
            "type" => "live",
            "sandbox" => [
                "URL_API" => "https://sandbox.nganluong.vn:8088/nl35/checkout.api.nganluong.post.php",
                "RECEIVER" => "anbinh.itweb@gmail.com",
                "MERCHANT_ID" => "51063",
                'MERCHANT_PASS' => '8474a26bc293e51883957fdc56531950'
            ],
            "live"=> [
                "URL_API" => "https://www.nganluong.vn/checkout.api.nganluong.post.php",
                "RECEIVER" => "minhhieu@lovefishaqua.com.vn",
                "MERCHANT_ID" => "66216",
                'MERCHANT_PASS' => "42979bdc11a51d9c283720714520f685"
            ],
            'payment_method' => [
                'COD' => [
                    'name'  => 'Thanh toán khi nhận hàng COD',
                    'color' => 'dark'
                ],
                'VISA' => [
                    'name'  => 'Thanh toán thẻ quốc tế',
                    'color' => 'dark'
                ],
                'ATM_ONLINE' => [
                    'name'  => 'Thanh toán online bằng thẻ ngân hàng nội địa',
                    'color' => 'dark'
                ]
            ],
        ],
        
    ];
