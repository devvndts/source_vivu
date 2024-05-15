<?php
    return [
        //### config all
        "config_base" => '',
        "config_url" => "",
        "config_all_url" => env('APP_URL')."",
        "debug_developer" => false,
        "ishost" => true,
        "lockpage" => false,

        "author" => [
            "name" => "",
            "email" => "",
            "website" => "",
            // 'salt2' => '6@#KTx96WB^',
            'hotline' => '123456789',
            'appkey' => 'pMxQzvonBMxGf0eD8CoEiXuxQbrAXADjsBaH02FFwvw='
        ],

        "arrayDomainSSL" => [
            'minigo.vn',
        ],

        "lang" => [
            "vi" => "Tiếng Việt",
            // "en" => "Tiếng Anh"
        ],

        "slug" => [
            "vi" => "Tiếng Việt",
            //"en" => "Tiếng Anh"
        ],

        "seo" => [
            "vi" => "Tiếng Việt",
            //"en" => "Tiếng Anh"
        ],

        "coupon" => [
            "active" => true,
        ],

        "extension_img" => ['png','gif','jpg','webp'],

        "fileupload" => false,
        "autosave_time" => 15*60, //second

        "transport" => [
            "active" => true,
        ],
        "recaptcha" => [
            "active" => false,
        ],
        // "setting" => [
        // 	"diachi" => true,
        // 	"dienthoai" => true,
        // 	"hotline" => true,
        // 	"zalo" => true,
        // 	"oaidzalo" => true,
        // 	"email" => true,
        // 	"website" => true,
        // 	"fanpage" => true,
        // 	"messenger" => true,
        // 	"toado" => true,
        // 	"toado_iframe" => true
        // ],
        "group" => [
            // "Group Lĩnh vực hoạt động" => array(
            //     "staticpost" => array("text-linh-vuc"),
            //     "post" => array("linh-vuc"),
            // ),
            // "Group Giới thiệu" => array(
            //     "staticpost" => array("gioi-thieu"),
            //     "post" => array("criteria"),
            // ),
            // "Group Sản phẩm" => array(
            //     "product" => array("product"),
            //   "tags" => array("san-pham"),
                // "staticpost" => array("text-sanpham"),
            //   "photo" => array("slide-product"),
            //   "photo_static" => array("watermark"),
            //   "newsletter" => array("dangkybaogia")
            // ),
            // "Group Tin Tức" => array(
            //   "news" => array("tin-tuc"),
            //   "static" => array("gioi-thieu-tin-tuc"),
              // "photo" => array("slide-tieu-chi"),
              // "tags" => array("tin-tuc"),
              // "photo_static" => array("watermark-news"),
              // "newsletter" => array("dangkytuyendung")
            // ),
        ],
        "setting" => [
            'diachi' => array("type" => "text", "title" => "Địa chỉ", "groupClass" => "form-group col-md-6 col-sm-6" ),
            'dienthoai' => array("type" => "text", "title" => "Điện thoại", "groupClass" => "form-group col-md-6 col-sm-6" ),
            'hotline' => array("type" => "text", "title" => "Hotline", "groupClass" => "form-group col-md-6 col-sm-6" ),
            // 'hotline2' => array("type" => "text", "title" => "Hỗ trợ", "groupClass" => "form-group col-md-6 col-sm-6" ),
            'zalo' => array("type" => "text", "title" => "Zalo", "groupClass" => "form-group col-md-6 col-sm-6" ),
            'oaidzalo' => array("type" => "text", "title" => "OAID Zalo", "groupClass" => "form-group col-md-6 col-sm-6" ),
            'email' => array("type" => "text", "title" => "Email", "groupClass" => "form-group col-md-6 col-sm-6" ),
            'giolamviec' => array("type" => "text", "title" => "Giờ làm việc", "groupClass" => "form-group col-md-6 col-sm-6" ),
            // 'tenlienlac' => array ("type" => "text", "title" => "Tên liên lạc", "groupClass" => "form-group col-md-6 col-sm-6" ),
            'website' => array("type" => "text", "title" => "Website", "groupClass" => "form-group col-md-6 col-sm-6" ),
            'fanpage' => array("type" => "text", "title" => "Fanpage", "groupClass" => "form-group col-md-6 col-sm-6" ),
            'toado' => array("type" => "text", "title" => "Tọa độ google map", "groupClass" => "form-group col-md-6 col-sm-6" ),
            'copyright' => array ("type" => "text", "title" => "Copyright", "groupClass" => "form-group col-md-6 col-sm-6" ),
            'footer_title_1' => array ("type" => "text", "title" => "Tiêu đề footer 1", "groupClass" => "form-group col-md-6 col-sm-6" ),
            'footer_title_2' => array ("type" => "text", "title" => "Tiêu đề footer 2", "groupClass" => "form-group col-md-6 col-sm-6" ),
            'footer_title_3' => array ("type" => "text", "title" => "Tiêu đề footer 3", "groupClass" => "form-group col-md-6 col-sm-6" ),
            // 'slogan' => array ("type" => "text", "title" => "Slogan", "groupClass" => "form-group col-md-6 col-sm-6" ),
            // 'link_map' => array ("type" => "text", "title" => "Link google map", "groupClass" => "form-group col-md-4 col-sm-6" ),
            // 'hienthi' => array ("type" => "checkbox", "title" => "Hiển thị", "groupClass" => "form-group col-md-4 col-sm-6", "data" => ["phone" => "Phone cửa hàng"] ),
            // 'paging_product' => array ("type" => "text", "title" => "Phân trang sản phẩm", "groupClass" => "form-group col-md-4 col-sm-6" ),
            // 'paging_news' => array ("type" => "text", "title" => "Phân trang tin tức", "groupClass" => "form-group col-md-4 col-sm-6" ),
            // 'paging_index' => array ("type" => "text", "title" => "Phân trang trang chủ", "groupClass" => "form-group col-md-4 col-sm-6" ),
            'toado_iframe' => array("type" => "textarea", "title" => "Tọa độ google map iframe", "groupClass" => "form-group col-md-12 col-sm-12", "rows" => "5", "subtitle" => '<span>Tọa độ google map iframe:</span><a class="ml-1 text-sm font-weight-normal" 
            href="https://www.google.com/maps" target="_blank" title="Lấy mã nhúng google map">(Lấy mã nhúng)</a>' ),
        ],

        "question" => [
            "active" => false
        ],

        "order" => [
            "soluong" => true,
            "active" => true,
            "ship" => true,
            "printOrder" => true,
            "export_excel" => true,
            "dongboall" => true,
            "search"=>true
        ],
        'login' => [
            'admin' => 'LoginAdmin'.env('DB_DATABASE'),
            'member' => 'LoginMember'.env('DB_DATABASE'),
            'attempt' => 3,
            'delay' => 15
        ],

        "export_exel" => false,
        "import_exel" => false,

        /* Quản lý phân quyền */
        "permission" => true,

        /* Quản lý tỉnh thành */
        "places" => false,

        /* Quản lý menu */
        "menus" => false,

        /* Quản lý phân trang */
        "numberperpage" => [
            // number per page of product
            "category" => 12,
            "productman" => 12,
            "postman" => 12,
            "albumman" => 12,
            // number per page of photo
            "photo" => 12,
            // number per page of size and color
            "color" => 12,
            "size" => 12,
            "brand" => 12,
            "tags" => 12,
            "newsletter"=>12,
            "contact"=>12,
            "coupon"=>12,
            "question"=>12,
        ],

        'folder_gallery' => [
            '1' => [
                'type'  => 'product',
                'name' => 'Thư mục sản phẩm'
            ],
            '2' => [
                'type'  => 'post',
                'name' => 'Thư mục bài viết'
            ],
            '3' => [
                'type'  => 'album',
                'name' => 'Thư mục album'
            ],
            '4' => [
                'type'  => 'photo',
                'name' => 'Thư mục hình ảnh'
            ]
        ],

        /*'payment_define' => true,
        'payment_method' => [
            '1' => [
                'name'  => 'Thanh toán khi nhận hàng (COD)',
                'color' => 'dark'
            ],
            '2' => [
                'name'  => 'Chuyển khoản ngân hàng',
                'color' => 'dark'
            ],
            '3' => [
                'name'  => 'Online quốc tế',
                'color' => 'dark'
            ],
            '4' => [
                'name'  => 'Online ATM',
                'color' => 'dark'
            ]
        ],*/
        'payment_status' => [
            '0' => [
                'name'  => 'Chưa thanh toán',
                'color' => 'danger'
            ],
            '1' => [
                'name'  => 'Đã thanh toán',
                'color' => 'success'
            ],
            '2' => [
                'name'  => 'Thanh toán không thành công',
                'color' => 'warning'
            ]
        ],
        'order_status' => [
            '1' => [
                'name'  => 'Mới đặt',
                'color' => 'primary'
            ],
            '2' => [
                'name'  => 'Đã xác nhận',
                'color' => 'info'
            ],
            '3' => [
                'name'  => 'Đang giao hàng',
                'color' => 'warning'
            ],
            '4' => [
                'name'  => 'Đã giao',
                'color' => 'success'
            ],
            '6' => [
                'name'  => 'Đang chuyển hoàn',
                'color' => 'info'
            ],
            '7' => [
                'name'  => 'Đã chuyển hoàn',
                'color' => 'success'
            ],
            '5' => [
                'name'  => 'Đã hủy',
                'color' => 'danger'
            ],
        ],
        'delivery_status' => [
            '1' => [
                'name'     => 'Mới đặt',
                'color'    => 'primary',
                'log_name' => 'Đã tiếp nhận',
                'log_text' => 'Đơn hàng đã được tiếp nhận thành công'
            ],
            '2' => [
                'name'     => 'Đã xác nhận',
                'color'    => 'info',
                'log_name' => 'Đã xác nhận',
                'log_text' => 'Đơn hàng đã được xác nhận'
            ],
            '3' => [
                'name'     => 'Đang giao hàng',
                'color'    => 'warning',
                'log_name' => 'Đang giao hàng',
                'log_text' => 'Đơn hàng đang được giao'
            ],
            '4' => [
                'name'     => 'Đã giao',
                'color'    => 'success',
                'log_name' => 'Đã giao',
                'log_text' => 'Đơn hàng đã được giao thành công'
            ],
            '5' => [
                'name'     => 'Đã hủy',
                'color'    => 'danger',
                'log_name' => 'Đã hủy',
                'log_text' => 'Đơn hàng đã hủy'
            ],
            '6' => [
                'name'     => 'Đang chuyển hoàn',
                'color'    => 'info',
                'log_name' => 'Đang chuyển hoàn',
                'log_text' => 'Đơn hàng đang chuyển hoàn'
            ],
            '7' => [
                'name'     => 'Đã chuyển hoàn',
                'color'    => 'success',
                'log_name' => 'Đã chuyển hoàn',
                'log_text' => 'Đơn hàng đã chuyển hoàn'
            ]
        ],
        'channel' => [
            '0' => [
                'name'  => 'Website',
                'color' => 'success',
                'active' => true
            ],
            '1' => [
                'name'  => 'Facebook',
                'color' => 'primary',
                'active' => false
            ],
            '2' => [
                'name'  => 'Shopee',
                'color' => 'danger',
                'active' => true
            ],
            '3' => [
                'name'  => 'Lazada',
                'color' => 'warning',
                'active' => true
            ],
            '4' => [
                'name'  => 'Tiki',
                'color' => 'info',
                'active' => false
            ],
            '5' => [
                'name'  => 'Khác',
                'color' => 'secondary',
                'active' => false
            ]
        ]
    ];
