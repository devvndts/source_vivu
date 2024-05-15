<?php
    $config = array();

    /* Đào tạo đại học */
    $nametype = "dich-vu-dao-tao";
    $config[$nametype]['com'] = 'dich-vu-dao-tao';
    $config[$nametype]['menu'] = true;
    $config[$nametype]['sell'] = false;
    $config[$nametype]['sitemap'] = true;
    $config[$nametype]['title_main'] = "Đào tạo đại học";
    $config[$nametype]['dropdown'] = true;
    $config[$nametype]['brand'] = false;
    $config[$nametype]['com-brand'] = 'thuong-hieu';
    $config[$nametype]['cta'] = false;
    $config[$nametype]['mau'] = false;
    $config[$nametype]['size'] = false;
    $config[$nametype]['tags'] = false;
    $config[$nametype]['bst'] = false;
    $config[$nametype]['import'] = false;
    $config[$nametype]['import_price'] = false;
    $config[$nametype]['export'] = false;
    $config[$nametype]['view'] = true;
    $config[$nametype]['copy'] = true;
    $config[$nametype]['copy_image'] = true;
    $config[$nametype]['option'] = false;
    $config[$nametype]['images_option'] = true;
    $config[$nametype]['show_images_option'] = true;
    $config[$nametype]['price_option'] = false;
    $config[$nametype]['motangan_option'] = false;
    $config[$nametype]['motangan_option_ck'] = false;
    $config[$nametype]['mota_option'] = true;
    $config[$nametype]['mota_option_ck'] = false;
    $config[$nametype]['noidung_option'] = false;
    $config[$nametype]['noidung_option_ck'] = false;
    $config[$nametype]['seo_option'] = false;
    $config[$nametype]['slug'] = true;
    // $config[$nametype]['check'] = array("noibat" => "Nổi bật");//, "banchay" => "Flashsale"
    $config[$nametype]['images2_title'] = 'Đăng ký';
    $config[$nametype]['images2'] = true;
    $config[$nametype]['width2'] = 430;
    $config[$nametype]['height2'] = 300;
    $config[$nametype]['images'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['images3_title'] = 'Cam kết sau đào tạo';
    $config[$nametype]['images3'] = true;
    $config[$nametype]['width3'] = 630;
    $config[$nametype]['height3'] = 470;
    $config[$nametype]['import_excel'] = false;
    $config[$nametype]['export_excel'] = false;
    $config[$nametype]['watermark'] = false;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['menu_multiple'] = true;
    $config[$nametype]['gallery_option'] = false;
    $config[$nametype]['attribute'] = array(
        ["id" => "thongso", "name" => "Thông số kỹ thuật", "params" => ["tenvi" => "Tên", "noidungvi" => "Giá trị"]],
        ["id" => "tailieu", "name" => "Tài liệu", "params" => ["tenvi" => "Tên", "noidungvi" => "Giá trị"]],
    );
    $config[$nametype]['post_product'] = [
        "doituonghocvien" => [ "title" => "Đối tượng học viên", ],
        "quyenloi" => [ "title" => "Quyền lợi học viên", ],
        "camket" => [ "title" => "Cam kết", ],
        "lotrinhthamgia" => [ "title" => "Lộ trình tham gia", ],
        "lotrinhdaotao" => [ "title" => "Lộ trình đào tạo", ],
        "ketquasaukhoahoc" => [ "title" => "Kết quả", ],
        "sanphamhocvien" => [ "title" => "Sản phẩm học viên", ],
        "thongsokythuat" => [ "title" => "Thông số kỹ thuật", ],
    ];
    $config[$nametype]['gallery'] = array(
        $nametype => array(
            "title_main_photo" => "Hình ảnh",
            "title_sub_photo" => "Hình ảnh",
            "number_photo" => 1,
            "images_photo" => true,
            "cart_photo" => false,
            "avatar_photo" => true,
            "tieude_photo" => true,
            "width_photo" => 1920,
            "height_photo" => 770,
            "thumb_photo" => '150x100x2',
            "img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF'
        ),
        "video" => array(
            "title_main_photo" => "Video sản phẩm",
            "title_sub_photo" => "Video",
            "number_photo" => 2,
            "video_photo" => true,
            "tieude_photo" => true
        ),
        "taptin" => array(
            "title_main_photo" => "Tập tin sản phẩm",
            "title_sub_photo" => "Tập tin",
            "number_photo" => 2,
            "file_photo" => true,
            "tieude_photo" => true,
            "file_type_photo" => 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS'
        )
    );
    $config[$nametype]['taptin'] = false;
    $config[$nametype]['ma'] = false;
    $config[$nametype]['giacu'] = false;
    $config[$nametype]['gia'] = false;
    $config[$nametype]['giamoi'] = false;
    $config[$nametype]['giakm'] = false;
    $config[$nametype]['motangan'] = false;
    $config[$nametype]['motangan_cke'] = false;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['mota_cke'] = true;
    $config[$nametype]['mota_cke_custom'] = true;
    $config[$nametype]['noidung'] = true;
    $config[$nametype]['noidung_title'] = "Description";
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['huongdan'] = true;
    $config[$nametype]['huongdan_title'] = "Overview";
    $config[$nametype]['huongdan_cke'] = true;
    $config[$nametype]['thanhphan'] = true;
    $config[$nametype]['thanhphan_title'] = "Reviews";
    $config[$nametype]['thanhphan_cke'] = true;
    $config[$nametype]['seo'] = true;
    $config[$nametype]['width'] = 600;
    $config[$nametype]['height'] = 400;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '150x100x2';
    $config[$nametype]['img_type'] = '.jpg|.JPG|.png|.PNG';
    $config[$nametype]['sl_options'] = array(
        // 'link_youtube_dangky' => array("type" => "text", "title" => "Link youtube đăng ký", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'link_youtube_camket' => array("type" => "text", "title" => "Link youtube cam kết", "groupClass" => "form-group col-md-4 col-sm-6" ),
        'hinhthuchoc' => array("type" => "text", "title" => "Hình thức học", "groupClass" => "form-group col-md-4 col-sm-6" ),
        'thoihan' => array("type" => "text", "title" => "Thời hạn", "groupClass" => "form-group col-md-4 col-sm-6" ),
        'khoinganh' => array("type" => "text", "title" => "Khối ngành", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'vangso' => array("type" => "text", "title" => "Vang số", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'bg-color' => array("type" => "color", "title" => "Background", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'birthday' => array("type" => "date", "title" => "Birthday", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'vangso2' => array("type" => "text", "title" => "Vang số 2", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'sex' => array("type" => "radio", "title" => "Sex", "groupClass" => "form-group col-md-4 col-sm-6", 'list' => [
        //     'male' => ['value' => 0, 'title' => 'Nữ'],
        //     'female' => ['value' => 1, 'title' => 'Nam']
        // ] ),
        // 'favorite' => array("type" => "checkbox", "title" => "Favorite", "groupClass" => "form-group col-md-4 col-sm-6", 'list' => [
        //     ['value' => 0, 'title' => 'Basketball'],
        //     ['value' => 1, 'title' => 'Swimming'],
        //     ['value' => 2, 'title' => 'Playing chess'],
        // ] ),
        // 'gender' => array("type" => "select", "title" => "Gender", "groupClass" => "form-group col-md-4 col-sm-6", 'list' => [
        //     ['value' => 0, 'title' => 'Nữ'],
        //     ['value' => 1, 'title' => 'Nam']
        // ] ),
    );
    /* Địa điểm du lịch */
    $nametype = "dia-diem-du-lich";
    $config[$nametype]['com'] = 'dia-diem-du-lich';
    $config[$nametype]['menu'] = true;
    $config[$nametype]['sell'] = false;
    $config[$nametype]['sitemap'] = true;
    $config[$nametype]['title_main'] = "Địa điểm du lịch";
    $config[$nametype]['dropdown'] = true;
    $config[$nametype]['brand'] = false;
    $config[$nametype]['com-brand'] = 'thuong-hieu';
    $config[$nametype]['cta'] = false;
    $config[$nametype]['mau'] = false;
    $config[$nametype]['size'] = false;
    $config[$nametype]['tags'] = false;
    $config[$nametype]['bst'] = false;
    $config[$nametype]['import'] = false;
    $config[$nametype]['import_price'] = false;
    $config[$nametype]['export'] = false;
    $config[$nametype]['view'] = true;
    $config[$nametype]['copy'] = true;
    $config[$nametype]['copy_image'] = true;
    $config[$nametype]['option'] = false;
    $config[$nametype]['images_option'] = true;
    $config[$nametype]['show_images_option'] = true;
    $config[$nametype]['price_option'] = false;
    $config[$nametype]['motangan_option'] = false;
    $config[$nametype]['motangan_option_ck'] = false;
    $config[$nametype]['mota_option'] = true;
    $config[$nametype]['mota_option_ck'] = false;
    $config[$nametype]['noidung_option'] = false;
    $config[$nametype]['noidung_option_ck'] = false;
    $config[$nametype]['seo_option'] = false;
    $config[$nametype]['slug'] = true;
    // $config[$nametype]['check'] = array("noibat" => "Nổi bật");//, "banchay" => "Flashsale"
    $config[$nametype]['images2_title'] = 'Đăng ký';
    $config[$nametype]['images2'] = true;
    $config[$nametype]['width2'] = 430;
    $config[$nametype]['height2'] = 300;
    $config[$nametype]['images'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['images3_title'] = 'Cam kết sau đào tạo';
    $config[$nametype]['images3'] = true;
    $config[$nametype]['width3'] = 630;
    $config[$nametype]['height3'] = 470;
    $config[$nametype]['import_excel'] = false;
    $config[$nametype]['export_excel'] = false;
    $config[$nametype]['watermark'] = false;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['menu_multiple'] = true;
    $config[$nametype]['gallery_option'] = false;
    $config[$nametype]['attribute'] = array(
        ["id" => "thongso", "name" => "Thông số kỹ thuật", "params" => ["tenvi" => "Tên", "noidungvi" => "Giá trị"]],
        ["id" => "tailieu", "name" => "Tài liệu", "params" => ["tenvi" => "Tên", "noidungvi" => "Giá trị"]],
    );
    $config[$nametype]['post_product'] = [
        "doituonghocvien" => [ "title" => "Đối tượng học viên", ],
        "quyenloi" => [ "title" => "Quyền lợi học viên", ],
        "camket" => [ "title" => "Cam kết", ],
        "lotrinhthamgia" => [ "title" => "Lộ trình tham gia", ],
        "lotrinhdaotao" => [ "title" => "Lộ trình đào tạo", ],
        "ketquasaukhoahoc" => [ "title" => "Kết quả", ],
        "sanphamhocvien" => [ "title" => "Sản phẩm học viên", ],
        "thongsokythuat" => [ "title" => "Thông số kỹ thuật", ],
    ];
    $config[$nametype]['gallery'] = array(
        $nametype => array(
            "title_main_photo" => "Hình ảnh",
            "title_sub_photo" => "Hình ảnh",
            "number_photo" => 1,
            "images_photo" => true,
            "cart_photo" => false,
            "avatar_photo" => true,
            "tieude_photo" => true,
            "width_photo" => 1920,
            "height_photo" => 770,
            "thumb_photo" => '150x100x2',
            "img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF'
        ),
        "video" => array(
            "title_main_photo" => "Video sản phẩm",
            "title_sub_photo" => "Video",
            "number_photo" => 2,
            "video_photo" => true,
            "tieude_photo" => true
        ),
        "taptin" => array(
            "title_main_photo" => "Tập tin sản phẩm",
            "title_sub_photo" => "Tập tin",
            "number_photo" => 2,
            "file_photo" => true,
            "tieude_photo" => true,
            "file_type_photo" => 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS'
        )
    );
    $config[$nametype]['taptin'] = false;
    $config[$nametype]['ma'] = false;
    $config[$nametype]['giacu'] = false;
    $config[$nametype]['gia'] = false;
    $config[$nametype]['giamoi'] = false;
    $config[$nametype]['giakm'] = false;
    $config[$nametype]['motangan'] = false;
    $config[$nametype]['motangan_cke'] = false;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['mota_cke'] = true;
    $config[$nametype]['mota_cke_custom'] = true;
    $config[$nametype]['noidung'] = true;
    $config[$nametype]['noidung_title'] = "Description";
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['huongdan'] = true;
    $config[$nametype]['huongdan_title'] = "Overview";
    $config[$nametype]['huongdan_cke'] = true;
    $config[$nametype]['thanhphan'] = true;
    $config[$nametype]['thanhphan_title'] = "Reviews";
    $config[$nametype]['thanhphan_cke'] = true;
    $config[$nametype]['seo'] = true;
    $config[$nametype]['width'] = 600;
    $config[$nametype]['height'] = 400;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '150x100x2';
    $config[$nametype]['img_type'] = '.jpg|.JPG|.png|.PNG';
    $config[$nametype]['sl_options'] = array(
        // 'link_youtube_dangky' => array("type" => "text", "title" => "Link youtube đăng ký", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'link_youtube_camket' => array("type" => "text", "title" => "Link youtube cam kết", "groupClass" => "form-group col-md-4 col-sm-6" ),
        'hinhthuchoc' => array("type" => "text", "title" => "Hình thức học", "groupClass" => "form-group col-md-4 col-sm-6" ),
        'thoihan' => array("type" => "text", "title" => "Thời hạn", "groupClass" => "form-group col-md-4 col-sm-6" ),
        'khoinganh' => array("type" => "text", "title" => "Khối ngành", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'vangso' => array("type" => "text", "title" => "Vang số", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'bg-color' => array("type" => "color", "title" => "Background", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'birthday' => array("type" => "date", "title" => "Birthday", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'vangso2' => array("type" => "text", "title" => "Vang số 2", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'sex' => array("type" => "radio", "title" => "Sex", "groupClass" => "form-group col-md-4 col-sm-6", 'list' => [
        //     'male' => ['value' => 0, 'title' => 'Nữ'],
        //     'female' => ['value' => 1, 'title' => 'Nam']
        // ] ),
        // 'favorite' => array("type" => "checkbox", "title" => "Favorite", "groupClass" => "form-group col-md-4 col-sm-6", 'list' => [
        //     ['value' => 0, 'title' => 'Basketball'],
        //     ['value' => 1, 'title' => 'Swimming'],
        //     ['value' => 2, 'title' => 'Playing chess'],
        // ] ),
        // 'gender' => array("type" => "select", "title" => "Gender", "groupClass" => "form-group col-md-4 col-sm-6", 'list' => [
        //     ['value' => 0, 'title' => 'Nữ'],
        //     ['value' => 1, 'title' => 'Nam']
        // ] ),
    );

    /* Chương trình đào tạo */
    $nametype = "chuong-trinh-dao-tao";
    $config[$nametype]['com'] = 'chuong-trinh-dao-tao';
    $config[$nametype]['menu'] = true;
    $config[$nametype]['sell'] = false;
    $config[$nametype]['sitemap'] = true;
    $config[$nametype]['title_main'] = "Chương trình đào tạo";
    $config[$nametype]['dropdown'] = true;
    $config[$nametype]['brand'] = false;
    $config[$nametype]['com-brand'] = 'thuong-hieu';
    $config[$nametype]['cta'] = false;
    $config[$nametype]['mau'] = false;
    $config[$nametype]['size'] = false;
    $config[$nametype]['tags'] = false;
    $config[$nametype]['bst'] = false;
    $config[$nametype]['import'] = false;
    $config[$nametype]['import_price'] = false;
    $config[$nametype]['export'] = false;
    $config[$nametype]['view'] = true;
    $config[$nametype]['copy'] = true;
    $config[$nametype]['copy_image'] = true;
    $config[$nametype]['option'] = false;
    $config[$nametype]['images_option'] = true;
    $config[$nametype]['show_images_option'] = true;
    $config[$nametype]['price_option'] = false;
    $config[$nametype]['motangan_option'] = false;
    $config[$nametype]['motangan_option_ck'] = false;
    $config[$nametype]['mota_option'] = true;
    $config[$nametype]['mota_option_ck'] = false;
    $config[$nametype]['noidung_option'] = false;
    $config[$nametype]['noidung_option_ck'] = false;
    $config[$nametype]['seo_option'] = false;
    $config[$nametype]['slug'] = true;
    // $config[$nametype]['check'] = array("noibat" => "Nổi bật");//, "banchay" => "Flashsale"
    $config[$nametype]['images2_title'] = 'Đăng ký';
    $config[$nametype]['images2'] = true;
    $config[$nametype]['width2'] = 430;
    $config[$nametype]['height2'] = 300;
    $config[$nametype]['images'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['images3_title'] = 'Cam kết sau đào tạo';
    $config[$nametype]['images3'] = true;
    $config[$nametype]['width3'] = 630;
    $config[$nametype]['height3'] = 470;
    $config[$nametype]['import_excel'] = false;
    $config[$nametype]['export_excel'] = false;
    $config[$nametype]['watermark'] = false;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['menu_multiple'] = true;
    $config[$nametype]['gallery_option'] = false;
    $config[$nametype]['attribute'] = array(
        ["id" => "thongso", "name" => "Thông số kỹ thuật", "params" => ["tenvi" => "Tên", "noidungvi" => "Giá trị"]],
        ["id" => "tailieu", "name" => "Tài liệu", "params" => ["tenvi" => "Tên", "noidungvi" => "Giá trị"]],
    );
    $config[$nametype]['post_product'] = [
        "doituonghocvien" => [ "title" => "Đối tượng học viên", ],
        "quyenloi" => [ "title" => "Quyền lợi học viên", ],
        "camket" => [ "title" => "Cam kết", ],
        "lotrinhthamgia" => [ "title" => "Lộ trình tham gia", ],
        "lotrinhdaotao" => [ "title" => "Lộ trình đào tạo", ],
        "ketquasaukhoahoc" => [ "title" => "Kết quả", ],
        "sanphamhocvien" => [ "title" => "Sản phẩm học viên", ],
        "thongsokythuat" => [ "title" => "Thông số kỹ thuật", ],
    ];
    $config[$nametype]['gallery'] = array(
        $nametype => array(
            "title_main_photo" => "Hình ảnh",
            "title_sub_photo" => "Hình ảnh",
            "number_photo" => 1,
            "images_photo" => true,
            "cart_photo" => false,
            "avatar_photo" => true,
            "tieude_photo" => true,
            "width_photo" => 1920,
            "height_photo" => 770,
            "thumb_photo" => '150x100x2',
            "img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF'
        ),
        "video" => array(
            "title_main_photo" => "Video sản phẩm",
            "title_sub_photo" => "Video",
            "number_photo" => 2,
            "video_photo" => true,
            "tieude_photo" => true
        ),
        "taptin" => array(
            "title_main_photo" => "Tập tin sản phẩm",
            "title_sub_photo" => "Tập tin",
            "number_photo" => 2,
            "file_photo" => true,
            "tieude_photo" => true,
            "file_type_photo" => 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS'
        )
    );
    $config[$nametype]['taptin'] = false;
    $config[$nametype]['ma'] = false;
    $config[$nametype]['giacu'] = false;
    $config[$nametype]['gia'] = false;
    $config[$nametype]['giamoi'] = false;
    $config[$nametype]['giakm'] = false;
    $config[$nametype]['motangan'] = false;
    $config[$nametype]['motangan_cke'] = false;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['mota_cke'] = true;
    $config[$nametype]['mota_cke_custom'] = true;
    $config[$nametype]['noidung'] = true;
    $config[$nametype]['noidung_title'] = "Description";
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['huongdan'] = true;
    $config[$nametype]['huongdan_title'] = "Overview";
    $config[$nametype]['huongdan_cke'] = true;
    $config[$nametype]['thanhphan'] = true;
    $config[$nametype]['thanhphan_title'] = "Reviews";
    $config[$nametype]['thanhphan_cke'] = true;
    $config[$nametype]['seo'] = true;
    $config[$nametype]['width'] = 600;
    $config[$nametype]['height'] = 400;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '150x100x2';
    $config[$nametype]['img_type'] = '.jpg|.JPG|.png|.PNG';
    $config[$nametype]['sl_options'] = array(
        // 'link_youtube_dangky' => array("type" => "text", "title" => "Link youtube đăng ký", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'link_youtube_camket' => array("type" => "text", "title" => "Link youtube cam kết", "groupClass" => "form-group col-md-4 col-sm-6" ),
        'hinhthuchoc' => array("type" => "text", "title" => "Hình thức học", "groupClass" => "form-group col-md-4 col-sm-6" ),
        'thoihan' => array("type" => "text", "title" => "Thời hạn", "groupClass" => "form-group col-md-4 col-sm-6" ),
        'khoinganh' => array("type" => "text", "title" => "Khối ngành", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'vangso' => array("type" => "text", "title" => "Vang số", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'bg-color' => array("type" => "color", "title" => "Background", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'birthday' => array("type" => "date", "title" => "Birthday", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'vangso2' => array("type" => "text", "title" => "Vang số 2", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'sex' => array("type" => "radio", "title" => "Sex", "groupClass" => "form-group col-md-4 col-sm-6", 'list' => [
        //     'male' => ['value' => 0, 'title' => 'Nữ'],
        //     'female' => ['value' => 1, 'title' => 'Nam']
        // ] ),
        // 'favorite' => array("type" => "checkbox", "title" => "Favorite", "groupClass" => "form-group col-md-4 col-sm-6", 'list' => [
        //     ['value' => 0, 'title' => 'Basketball'],
        //     ['value' => 1, 'title' => 'Swimming'],
        //     ['value' => 2, 'title' => 'Playing chess'],
        // ] ),
        // 'gender' => array("type" => "select", "title" => "Gender", "groupClass" => "form-group col-md-4 col-sm-6", 'list' => [
        //     ['value' => 0, 'title' => 'Nữ'],
        //     ['value' => 1, 'title' => 'Nam']
        // ] ),
    );

    /* Sản phẩm */
    // $nametype = "product";
    // $config[$nametype]['com'] = 'san-pham';
    // $config[$nametype]['menu'] = true;
    // $config[$nametype]['sell'] = false;
    // $config[$nametype]['sitemap'] = true;
    // $config[$nametype]['title_main'] = "Sản phẩm";
    // $config[$nametype]['dropdown'] = true;
    // $config[$nametype]['brand'] = false;
    // $config[$nametype]['com-brand'] = 'thuong-hieu';
    // $config[$nametype]['cta'] = false;
    // $config[$nametype]['mau'] = false;
    // $config[$nametype]['size'] = false;
    // $config[$nametype]['tags'] = false;
    // $config[$nametype]['bst'] = false;
    // $config[$nametype]['import'] = false;
    // $config[$nametype]['import_price'] = false;
    // $config[$nametype]['export'] = false;
    // $config[$nametype]['view'] = true;
    // $config[$nametype]['copy'] = true;
    // $config[$nametype]['copy_image'] = true;
    // $config[$nametype]['option'] = false;
    // $config[$nametype]['images_option'] = true;
    // $config[$nametype]['show_images_option'] = true;
    // $config[$nametype]['price_option'] = false;
    // $config[$nametype]['motangan_option'] = false;
    // $config[$nametype]['motangan_option_ck'] = false;
    // $config[$nametype]['mota_option'] = true;
    // $config[$nametype]['mota_option_ck'] = false;
    // $config[$nametype]['noidung_option'] = false;
    // $config[$nametype]['noidung_option_ck'] = false;
    // $config[$nametype]['seo_option'] = false;
    // $config[$nametype]['slug'] = true;
    // $config[$nametype]['check'] = array("noibat" => "Nổi bật");//, "banchay" => "Flashsale"
    // $config[$nametype]['images2'] = true;
    // $config[$nametype]['width2'] = 800;
    // $config[$nametype]['height2'] = 480;
    // $config[$nametype]['images'] = true;
    // $config[$nametype]['show_images'] = true;
    // $config[$nametype]['import_excel'] = false;
    // $config[$nametype]['export_excel'] = false;
    // $config[$nametype]['watermark'] = false;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['menu_multiple'] = true;
    // $config[$nametype]['gallery_option'] = false;
    // $config[$nametype]['attribute'] = array(
    //     ["id" => "thongso", "name" => "Thông số kỹ thuật", "params" => ["tenvi" => "Tên", "noidungvi" => "Giá trị"]],
    //     ["id" => "tailieu", "name" => "Tài liệu", "params" => ["tenvi" => "Tên", "noidungvi" => "Giá trị"]],
    // );
    // $config[$nametype]['gallery'] = array(
    //     $nametype => array(
    //         "title_main_photo" => "Hình ảnh sản phẩm",
    //         "title_sub_photo" => "Hình ảnh",
    //         "number_photo" => 1,
    //         "images_photo" => true,
    //         "cart_photo" => false,
    //         "avatar_photo" => true,
    //         "tieude_photo" => true,
    //         "width_photo" => 600,
    //         "height_photo" => 790,
    //         "thumb_photo" => '100x150x2',
    //         "img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF'
    //     ),
        // "video" => array(
        //     "title_main_photo" => "Video sản phẩm",
        //     "title_sub_photo" => "Video",
        //     "number_photo" => 2,
        //     "video_photo" => true,
        //     "tieude_photo" => true
        // ),
        // "taptin" => array(
        //     "title_main_photo" => "Tập tin sản phẩm",
        //     "title_sub_photo" => "Tập tin",
        //     "number_photo" => 2,
        //     "file_photo" => true,
        //     "tieude_photo" => true,
        //     "file_type_photo" => 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS'
        // )
    // );
    // $config[$nametype]['taptin'] = true;
    // $config[$nametype]['ma'] = true;
    // $config[$nametype]['giacu'] = false;
    // $config[$nametype]['gia'] = true;
    // $config[$nametype]['giamoi'] = true;
    // $config[$nametype]['giakm'] = true;
    // $config[$nametype]['motangan'] = true;
    // $config[$nametype]['motangan_cke'] = true;
    // $config[$nametype]['mota'] = true;
    // $config[$nametype]['mota_cke'] = true;
    // $config[$nametype]['mota_cke_custom'] = true;
    // $config[$nametype]['noidung'] = true;
    // $config[$nametype]['noidung_title'] = "Nội dung";
    // $config[$nametype]['noidung_cke'] = true;
    // $config[$nametype]['huongdan'] = false;
    // $config[$nametype]['huongdan_title'] = "Chất gây dị ứng";
    // $config[$nametype]['huongdan_cke'] = true;
    // $config[$nametype]['thanhphan'] = false;
    // $config[$nametype]['thanhphan_title'] = "Thành phần";
    // $config[$nametype]['thanhphan_cke'] = true;
    // $config[$nametype]['seo'] = true;
    // $config[$nametype]['width'] = 600;
    // $config[$nametype]['height'] = 790;
    // $config[$nametype]['ratio'] = 1;
    // $config[$nametype]['thumb'] = '100x150x2';
    // $config[$nametype]['img_type'] = '.jpg|.JPG|.png|.PNG';
    // $config[$nametype]['sl_options'] = array(
    //     'vangso' => array("type" => "text", "title" => "Vang số", "groupClass" => "form-group col-md-4 col-sm-6" ),
    //     'bg-color' => array("type" => "color", "title" => "Background", "groupClass" => "form-group col-md-4 col-sm-6" ),
    //     'birthday' => array("type" => "date", "title" => "Birthday", "groupClass" => "form-group col-md-4 col-sm-6" ),
    //     'vangso2' => array("type" => "text", "title" => "Vang số 2", "groupClass" => "form-group col-md-4 col-sm-6" ),
    //     'sex' => array("type" => "radio", "title" => "Sex", "groupClass" => "form-group col-md-4 col-sm-6", 'list' => [
    //         'male' => ['value' => 0, 'title' => 'Nữ'],
    //         'female' => ['value' => 1, 'title' => 'Nam']
    //     ] ),
    //     'favorite' => array("type" => "checkbox", "title" => "Favorite", "groupClass" => "form-group col-md-4 col-sm-6", 'list' => [
    //         ['value' => 0, 'title' => 'Basketball'],
    //         ['value' => 1, 'title' => 'Swimming'],
    //         ['value' => 2, 'title' => 'Playing chess'],
    //     ] ),
    //     'gender' => array("type" => "select", "title" => "Gender", "groupClass" => "form-group col-md-4 col-sm-6", 'list' => [
    //         ['value' => 0, 'title' => 'Nữ'],
    //         ['value' => 1, 'title' => 'Nam']
    //     ] ),
    // );

    // /* Sản phẩm (Màu) */
    // // $config[$nametype]['mau_images'] = true;
    // // $config[$nametype]['mau_mau'] = true;
    // // $config[$nametype]['mau_loai'] = true;
    // // $config[$nametype]['width_mau'] = 30;
    // // $config[$nametype]['height_mau'] = 30;
    // // $config[$nametype]['thumb_mau'] = '30x30x1';
    // // $config[$nametype]['img_type_mau'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';


    // /* Sản phẩm (Hãng) */
    // $config[$nametype]['title_main_brand'] = "Thương hiệu";
    // $config[$nametype]['sitemap_brand'] = true;
    // $config[$nametype]['images_brand'] = true;
    // $config[$nametype]['show_images_brand'] = true;
    // $config[$nametype]['slug_brand'] = true;
    // $config[$nametype]['mota_brand'] = false;
    // $config[$nametype]['noidung_brand'] = false;
    // $config[$nametype]['check_brand'] = array("noibat" => "Nổi bật");
    // $config[$nametype]['seo_brand'] = true;
    // $config[$nametype]['width_brand'] = 210;
    // $config[$nametype]['height_brand'] = 275;
    // $config[$nametype]['thumb_brand'] = '210x275x1';
    // $config[$nametype]['width_brand_bg'] = 1440;
    // $config[$nametype]['height_brand_bg'] = 635;
    // $config[$nametype]['img_type_brand'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

    // /* Quản lý mục (Không cấp) */
    // if ($config) {
    //     foreach ($config as $key => $value) {
    //         if (!isset($value['dropdown']) || (isset($value['dropdown']) && $value['dropdown'] == false)) {
    //             $config['shownews'][$key] = $value;
    //         }
    //     }
    // }

    //dd($config);

    return $config;
