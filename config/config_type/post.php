<?php
    $config= array();
    /* Tin tức */
    $nametype = "tin-tuc";
    $config[$nametype]['com'] = 'tin-tuc';
    $config[$nametype]['menu'] = true;
    $config[$nametype]['sitemap'] = true;
    $config[$nametype]['title_main'] = "Tin tức";
    $config[$nametype]['dropdown'] = true;
    $config[$nametype]['tags'] = false;
    $config[$nametype]['iframe'] = true;
    $config[$nametype]['view'] = true;
    $config[$nametype]['copy'] = true;
    $config[$nametype]['copy_image'] = true;
    $config[$nametype]['slug'] = true;
    $config[$nametype]['check'] = array("noibat" => "Nổi bật");
    $config[$nametype]['images'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['watermark'] = false;
    $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['gallery'] = array
    // (
    //     $nametype => array
    //     (
    //         "title_main_photo" => "Hình ảnh Tin tức",
    //         "title_sub_photo" => "Hình ảnh",
    //         "number_photo" => 3,
    //         "images_photo" => true,
    //         "avatar_photo" => true,
    //         "tieude_photo" => true,
    //         "width_photo" => 540,
    //         "height_photo" => 540,
    //         "thumb_photo" => '100x100x1',
    //         "img_type_photo" => '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF'
    //     ),
    //     "video" => array
    //     (
    //         "title_main_photo" => "Video Tin tức",
    //         "title_sub_photo" => "Video",
    //         "number_photo" => 2,
    //         "video_photo" => true,
    //         "tieude_photo" => true
    //     ),
    //     "taptin" => array
    //     (
    //         "title_main_photo" => "Tập tin Tin tức",
    //         "title_sub_photo" => "Tập tin",
    //         "number_photo" => 2,
    //         "file_photo" => true,
    //         "tieude_photo" => true,
    //         "file_type_photo" => 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS'
    //     )
    // );
    $config[$nametype]['mota'] = true;
    $config[$nametype]['noidung'] = true;
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['seo'] = true;
    $config[$nametype]['width_icon'] = 400;
    $config[$nametype]['height_icon'] = 300;
    $config[$nametype]['width'] = 400;
    $config[$nametype]['height'] = 300;
    $config[$nametype]['width2'] = 400;
    $config[$nametype]['height2'] = 300;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '100x80x2';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Thông số kỹ thuật */
    $nametype = "thongsokythuat";
    $config[$nametype]['com'] = 'thongsokythuat';
    $config[$nametype]['title_main'] = "Thông số kỹ thuật";
    $config[$nametype]['mota'] = true;
    $config[$nametype]['noidung'] = false;
    $config[$nametype]['noidung_cke'] = true;
    /* Đối tượng học viên */
    $nametype = "doituonghocvien";
    $config[$nametype]['com'] = 'doituonghocvien';
    $config[$nametype]['title_main'] = "Đối tượng học viên";
    $config[$nametype]['images'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['noidung'] = false;
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['width'] = 70;
    $config[$nametype]['height'] = 70;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '70x70x2';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Quyền lợi học viên */
    $nametype = "quyenloi";
    $config[$nametype]['com'] = 'quyenloi';
    $config[$nametype]['title_main'] = "Quyền lợi học viên";
    $config[$nametype]['images'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['noidung'] = false;
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['width'] = 250;
    $config[$nametype]['height'] = 250;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '100x100x2';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Cam kết sau khóa học */
    $nametype = "camket";
    $config[$nametype]['com'] = 'camket';
    $config[$nametype]['title_main'] = "Cam kết sau khóa học";
    $config[$nametype]['images'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['noidung'] = false;
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['width'] = 50;
    $config[$nametype]['height'] = 50;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '50x50x2';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Lộ trình tham gia */
    $nametype = "lotrinhthamgia";
    $config[$nametype]['com'] = 'lotrinhthamgia';
    $config[$nametype]['title_main'] = "Lộ trình tham gia";
    $config[$nametype]['images'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['noidung'] = false;
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['width'] = 70;
    $config[$nametype]['height'] = 70;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '70x70x2';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Lộ trình đào tạo */
    $nametype = "lotrinhdaotao";
    $config[$nametype]['com'] = 'lotrinhdaotao';
    $config[$nametype]['title_main'] = "Lộ trình đào tạo";
    $config[$nametype]['images'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['mota_cke_custom'] = true;
    $config[$nametype]['noidung'] = false;
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['width'] = 50;
    $config[$nametype]['height'] = 50;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '50x50x2';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Kết quả sau khóa học */
    $nametype = "ketquasaukhoahoc";
    $config[$nametype]['com'] = 'ketquasaukhoahoc';
    $config[$nametype]['title_main'] = "Kết quả sau khóa học";
    $config[$nametype]['images'] = true;
    $config[$nametype]['images2'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['noidung'] = false;
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['width'] = 50;
    $config[$nametype]['height'] = 50;
    $config[$nametype]['width2'] = 800;
    $config[$nametype]['height2'] = 260;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '50x50x2';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Sản phẩm học viên */
    $nametype = "sanphamhocvien";
    $config[$nametype]['com'] = 'sanphamhocvien';
    $config[$nametype]['title_main'] = "Sản phẩm học viên";
    $config[$nametype]['images'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['mota'] = false;
    $config[$nametype]['noidung'] = false;
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['width'] = 1140;
    $config[$nametype]['height'] = 750;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '200x100x2';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Sứ mệnh */
    // $nametype = "su-menh";
    // $config[$nametype]['com'] = 'su-menh';
    // $config[$nametype]['menu'] = true;
    // $config[$nametype]['sitemap'] = true;
    // $config[$nametype]['title_main'] = "Sứ mệnh";
    // $config[$nametype]['dropdown'] = false;
    // $config[$nametype]['tags'] = false;
    // $config[$nametype]['view'] = true;
    // $config[$nametype]['copy'] = true;
    // $config[$nametype]['copy_image'] = true;
    // $config[$nametype]['slug'] = true;
    // $config[$nametype]['images'] = true;
    // $config[$nametype]['show_images'] = true;
    // $config[$nametype]['watermark'] = false;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['mota'] = true;
    // $config[$nametype]['noidung'] = true;
    // $config[$nametype]['noidung_cke'] = true;
    // $config[$nametype]['seo'] = true;
    // $config[$nametype]['width'] = 400;
    // $config[$nametype]['height'] = 300;
    // $config[$nametype]['ratio'] = 1;
    // $config[$nametype]['thumb'] = '100x80x2';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Slogan */
    // $nametype = "slogan";
    // $config[$nametype]['title_main'] = "Slogan";
    /* Vì sao chọn chúng tôi */
    // $nametype = "vi-sao";
    // $config[$nametype]['title_main'] = "Vì sao chọn chúng tôi";
    // $config[$nametype]['images'] = true;
    // $config[$nametype]['show_images'] = true;
    // $config[$nametype]['mota'] = true;
    // $config[$nametype]['width'] = 110;
    // $config[$nametype]['height'] = 110;
    // $config[$nametype]['ratio'] = 1;
    // $config[$nametype]['thumb'] = '110x110x2';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Lĩnh vực hoạt động */
    // $nametype = "linh-vuc";
    // $config[$nametype]['com'] = 'linh-vuc';
    // $config[$nametype]['menu'] = true;
    // $config[$nametype]['sitemap'] = true;
    // $config[$nametype]['title_main'] = "Lĩnh vực hoạt động";
    // $config[$nametype]['slug'] = true;
    // $config[$nametype]['images'] = true;
    // $config[$nametype]['show_images'] = true;
    // $config[$nametype]['mota'] = true;
    // $config[$nametype]['noidung'] = true;
    // $config[$nametype]['noidung_cke'] = true;
    // $config[$nametype]['seo'] = true;
    // $config[$nametype]['width'] = 500;
    // $config[$nametype]['height'] = 635;
    // $config[$nametype]['ratio'] = 1;
    // $config[$nametype]['thumb'] = '100x130x2';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';

    /* Video */
    // $nametype = "video";
    // $config[$nametype]['com'] = 'video';
    // $config[$nametype]['menu'] = true;
    // $config[$nametype]['sitemap'] = true;
    // $config[$nametype]['title_main'] = "Video";
    // $config[$nametype]['dropdown'] = true;
    // $config[$nametype]['tags'] = false;
    // $config[$nametype]['view'] = true;
    // $config[$nametype]['copy'] = true;
    // $config[$nametype]['copy_image'] = true;
    // $config[$nametype]['slug'] = true;
    // $config[$nametype]['check'] = array("noibat" => "Nổi bật");
    // $config[$nametype]['images'] = true;
    // $config[$nametype]['show_images'] = true;
    // $config[$nametype]['watermark'] = false;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['show_video'] = true;
    // $config[$nametype]['mota'] = true;
    // $config[$nametype]['noidung'] = true;
    // $config[$nametype]['noidung_cke'] = true;
    // $config[$nametype]['seo'] = true;
    // $config[$nametype]['width'] = 210;
    // $config[$nametype]['height'] = 118;
    // $config[$nametype]['ratio'] = 3;
    // $config[$nametype]['thumb'] = '210x118x1';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Tài nguyên */
    // $nametype = "cuahang";
    // $config[$nametype]['com'] = 'cua-hang';
    // $config[$nametype]['menu'] = false;
    // $config[$nametype]['sitemap'] = false;
    // $config[$nametype]['title_main'] = "Cửa hàng";
    // $config[$nametype]['dropdown'] = false;
    // $config[$nametype]['tags'] = false;
    // $config[$nametype]['view'] = false;
    // $config[$nametype]['copy'] = false;
    // $config[$nametype]['copy_image'] = false;
    // $config[$nametype]['slug'] = false;
    // $config[$nametype]['place'] = true;
    // $config[$nametype]['iframe'] = true;
    // $config[$nametype]['check'] = array();
    // $config[$nametype]['images'] = false;
    // $config[$nametype]['show_images'] = false;
    // $config[$nametype]['watermark'] = false;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['mota'] = true;
    // $config[$nametype]['noidung'] = false;
    // $config[$nametype]['noidung_cke'] = false;
    // $config[$nametype]['seo'] = false;
    // $config[$nametype]['width'] = 300;
    // $config[$nametype]['height'] = 250;
    // $config[$nametype]['ratio'] = 2;
    // $config[$nametype]['thumb'] = '300x250x1';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Hỗ trợ khách hàng */
    // $nametype = "ho-tro";
    // $config[$nametype]['com'] = 'ho-tro';
    // $config[$nametype]['menu'] = true;
    // $config[$nametype]['sitemap'] = true;
    // $config[$nametype]['title_main'] = "Hỗ trợ khách hàng";
    // $config[$nametype]['dropdown'] = false;
    // $config[$nametype]['tags'] = false;
    // $config[$nametype]['view'] = true;
    // $config[$nametype]['copy'] = true;
    // $config[$nametype]['copy_image'] = true;
    // $config[$nametype]['slug'] = true;
    // $config[$nametype]['check'] = array();
    // $config[$nametype]['images'] = true;
    // $config[$nametype]['show_images'] = true;
    // $config[$nametype]['watermark'] = false;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['mota'] = false;
    // $config[$nametype]['noidung'] = true;
    // $config[$nametype]['noidung_cke'] = true;
    // $config[$nametype]['seo'] = true;
    // $config[$nametype]['width'] = 300;
    // $config[$nametype]['height'] = 200;
    // $config[$nametype]['ratio'] = 2;
    // $config[$nametype]['thumb'] = '300x200x2';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Q and A */
    // $nametype = "q_a";
    // $config[$nametype]['com'] = 'hoi-dap';
    // $config[$nametype]['menu'] = false;
    // $config[$nametype]['sitemap'] = false;
    // $config[$nametype]['title_main'] = "Khách hàng hỏi đáp";
    // $config[$nametype]['dropdown'] = false;
    // $config[$nametype]['tags'] = false;
    // $config[$nametype]['view'] = false;
    // $config[$nametype]['copy'] = false;
    // $config[$nametype]['rating'] = false;
    // $config[$nametype]['copy_image'] = false;
    // $config[$nametype]['slug'] = false;
    // $config[$nametype]['check'] = array();
    // $config[$nametype]['images'] = false;
    // $config[$nametype]['show_images'] = false;
    // $config[$nametype]['watermark'] = false;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['mota'] = false;
    // $config[$nametype]['noidung'] = true;
    // $config[$nametype]['noidung_cke'] = true;
    // $config[$nametype]['seo'] = false;
    // $config[$nametype]['width'] = 350;
    // $config[$nametype]['height'] = 230;
    // $config[$nametype]['ratio'] = 2;
    // $config[$nametype]['thumb'] = '350x230x1';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Khách hàng đánh giá */
    // $nametype = "chamsockhachhang";
    // $config[$nametype]['com'] = 'cham-soc-khach-hang';
    // $config[$nametype]['menu'] = false;
    // $config[$nametype]['sitemap'] = false;
    // $config[$nametype]['title_main'] = "Chăm sóc khách hàng";
    // $config[$nametype]['dropdown'] = false;
    // $config[$nametype]['tags'] = false;
    // $config[$nametype]['view'] = true;
    // $config[$nametype]['copy'] = true;
    // $config[$nametype]['rating'] = true;
    // $config[$nametype]['copy_image'] = true;
    // $config[$nametype]['slug'] = true;
    // $config[$nametype]['check'] = array();
    // $config[$nametype]['images'] = true;
    // $config[$nametype]['show_images'] = true;
    // $config[$nametype]['watermark'] = false;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['mota'] = false;
    // $config[$nametype]['noidung'] = false;
    // $config[$nametype]['noidung_cke'] = false;
    // $config[$nametype]['seo'] = false;
    // $config[$nametype]['width'] = 100;
    // $config[$nametype]['height'] = 100;
    // $config[$nametype]['ratio'] = 2;
    // $config[$nametype]['thumb'] = '100x100x1';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Thông tin bảo hành */
    // $nametype = "thong-tin-bao-hanh";
    // $config[$nametype]['title_main'] = "Thông tin bảo hành";
    // $config[$nametype]['mota'] = true;
    // $config[$nametype]['com'] = 'thong-tin-bao-hanh';
    // $config[$nametype]['menu'] = true;
    // $config[$nametype]['mota_cke'] = true;
    // $config[$nametype]['mota_cke_custom'] = true;
    // $config[$nametype]['sl_options'] = array (
    //     'hoten' => array("type" => "text", "title" => "Họ tên", "groupClass" => "form-group col-md-6 col-sm-6" ),
    //     'dienthoai' => array("type" => "text", "title" => "Điện thoại", "groupClass" => "form-group col-md-6 col-sm-6" ),
    //     'diachi' => array("type" => "text", "title" => "Địa chỉ", "groupClass" => "form-group col-md-6 col-sm-6" ),
    //     'phongkham' => array("type" => "text", "title" => "Phòng khám", "groupClass" => "form-group col-md-6 col-sm-6" ),
    // );
    /* Tiêu chí */
    // $nametype = "criteria";
    // $config[$nametype]['title_main'] = "Tiêu chí";
    // $config[$nametype]['images'] = false;
    // $config[$nametype]['show_images'] = false;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['mota'] = false;
    // $config[$nametype]['width'] = 80;
    // $config[$nametype]['height'] = 60;
    // $config[$nametype]['ratio'] = 1;
    // $config[$nametype]['thumb'] = '80x60x2';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    // $config[$nametype]['sl_options'] = array (
    //     'conso' => array("type" => "number", "title" => "Số liệu", "groupClass" => "form-group col-md-6 col-sm-6" ),
    // );
    /* Thành tựu */
    $nametype = "thanhtuu";
    $config[$nametype]['title_main'] = "Thành tựu";
    $config[$nametype]['images'] = false;
    $config[$nametype]['show_images'] = false;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['mota'] = false;
    $config[$nametype]['width'] = 80;
    $config[$nametype]['height'] = 60;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '80x60x2';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    $config[$nametype]['sl_options'] = array (
        'conso' => array("type" => "number", "title" => "Số liệu", "groupClass" => "form-group col-md-6 col-sm-6" ),
    );
    /* Dịch vụ */
    // $nametype = "dich-vu";
    // $config[$nametype]['com'] = 'dich-vu';
    // $config[$nametype]['menu'] = true;
    // $config[$nametype]['sitemap'] = true;
    // $config[$nametype]['title_main'] = "Dịch vụ";
    // $config[$nametype]['dropdown'] = true;
    // $config[$nametype]['tags'] = false;
    // $config[$nametype]['view'] = true;
    // $config[$nametype]['copy'] = true;
    // $config[$nametype]['copy_image'] = true;
    // $config[$nametype]['slug'] = true;
    // $config[$nametype]['check'] = array("noibat" => "Nổi bật");
    // $config[$nametype]['icon'] = false;
    // $config[$nametype]['images'] = true;
    // $config[$nametype]['show_images'] = true;
    // $config[$nametype]['watermark'] = false;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['mota'] = true;
    // $config[$nametype]['noidung'] = true;
    // $config[$nametype]['noidung_cke'] = true;
    // $config[$nametype]['seo'] = true;
    // $config[$nametype]['width'] = 400;
    // $config[$nametype]['height'] = 300;
    // $config[$nametype]['width_icon'] = 50;
    // $config[$nametype]['height_icon'] = 50;
    // $config[$nametype]['ratio'] = 1;
    // $config[$nametype]['thumb'] = '100x150x2';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Hỏi đáp */
    // $nametype = "hoi-dap";
    // $config[$nametype]['com'] = 'hoi-dap';
    // $config[$nametype]['menu'] = true;
    // $config[$nametype]['sitemap'] = true;
    // $config[$nametype]['title_main'] = "Hỏi đáp";
    // $config[$nametype]['dropdown'] = false;
    // $config[$nametype]['tags'] = false;
    // $config[$nametype]['view'] = true;
    // $config[$nametype]['copy'] = true;
    // $config[$nametype]['copy_image'] = true;
    // $config[$nametype]['slug'] = false;
    // // $config[$nametype]['check'] = array("noibat" => "Nổi bật");
    // $config[$nametype]['icon'] = false;
    // $config[$nametype]['images'] = false;
    // $config[$nametype]['show_images'] = false;
    // $config[$nametype]['watermark'] = false;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['mota'] = true;
    // $config[$nametype]['mota_cke'] = true;
    // $config[$nametype]['mota_cke_custom'] = true;
    // $config[$nametype]['noidung'] = false;
    // $config[$nametype]['noidung_cke'] = false;
    // $config[$nametype]['seo'] = false;
    // $config[$nametype]['width'] = 400;
    // $config[$nametype]['height'] = 300;
    // $config[$nametype]['width_icon'] = 50;
    // $config[$nametype]['height_icon'] = 50;
    // $config[$nametype]['ratio'] = 1;
    // $config[$nametype]['thumb'] = '200x150x2';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Catalogue */
    // $nametype = "catalogue";
    // $config[$nametype]['com'] = 'catalogue';
    // $config[$nametype]['menu'] = true;
    // $config[$nametype]['sitemap'] = true;
    // $config[$nametype]['title_main'] = "Catalogue";
    // $config[$nametype]['dropdown'] = false;
    // $config[$nametype]['tags'] = false;
    // $config[$nametype]['view'] = true;
    // $config[$nametype]['copy'] = true;
    // $config[$nametype]['copy_image'] = true;
    // $config[$nametype]['slug'] = true;
    // // $config[$nametype]['check'] = array("noibat" => "Nổi bật");
    // $config[$nametype]['icon'] = false;
    // $config[$nametype]['images'] = true;
    // $config[$nametype]['show_images'] = true;
    // $config[$nametype]['watermark'] = false;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['mota'] = true;
    // $config[$nametype]['noidung'] = true;
    // $config[$nametype]['noidung_cke'] = true;
    // $config[$nametype]['seo'] = true;
    // $config[$nametype]['width'] = 400;
    // $config[$nametype]['height'] = 300;
    // $config[$nametype]['width_icon'] = 50;
    // $config[$nametype]['height_icon'] = 50;
    // $config[$nametype]['ratio'] = 2;
    // $config[$nametype]['thumb'] = '200x150x1';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Help */
    $nametype = "chinh-sach";
    $config[$nametype]['com'] = 'chinh-sach';
    $config[$nametype]['menu'] = true;
    $config[$nametype]['sitemap'] = true;
    $config[$nametype]['title_main'] = "Help";
    $config[$nametype]['dropdown'] = false;
    $config[$nametype]['tags'] = false;
    $config[$nametype]['view'] = true;
    $config[$nametype]['copy'] = true;
    $config[$nametype]['copy_image'] = true;
    $config[$nametype]['slug'] = true;
    // $config[$nametype]['check'] = array("noibat" => "Nổi bật");
    $config[$nametype]['icon'] = false;
    $config[$nametype]['images'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['watermark'] = false;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['noidung'] = true;
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['seo'] = true;
    $config[$nametype]['width'] = 300;
    $config[$nametype]['height'] = 200;
    $config[$nametype]['width_icon'] = 50;
    $config[$nametype]['height_icon'] = 50;
    $config[$nametype]['ratio'] = 2;
    $config[$nametype]['thumb'] = '200x100x2';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* About */
    $nametype = "ve-chung-toi";
    $config[$nametype]['com'] = 've-chung-toi';
    $config[$nametype]['menu'] = true;
    $config[$nametype]['sitemap'] = true;
    $config[$nametype]['title_main'] = "About";
    $config[$nametype]['dropdown'] = false;
    $config[$nametype]['tags'] = false;
    $config[$nametype]['view'] = true;
    $config[$nametype]['copy'] = true;
    $config[$nametype]['copy_image'] = true;
    $config[$nametype]['slug'] = true;
    // $config[$nametype]['check'] = array("noibat" => "Nổi bật");
    $config[$nametype]['icon'] = false;
    $config[$nametype]['images2'] = true;
    $config[$nametype]['images'] = false;
    $config[$nametype]['show_images'] = false;
    $config[$nametype]['watermark'] = false;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['noidung'] = true;
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['seo'] = true;
    $config[$nametype]['width'] = 600;
    $config[$nametype]['height'] = 650;
    $config[$nametype]['width_icon'] = 45;
    $config[$nametype]['height_icon'] = 35;
    $config[$nametype]['width2'] = 45;
    $config[$nametype]['height2'] = 35;
    $config[$nametype]['ratio'] = 2;
    $config[$nametype]['thumb'] = '100x120x2';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Giá trị */
    $nametype = "gia-tri";
    $config[$nametype]['com'] = 'gia-tri';
    $config[$nametype]['menu'] = false;
    $config[$nametype]['sitemap'] = false;
    $config[$nametype]['title_main'] = "Giá trị";
    $config[$nametype]['dropdown'] = false;
    $config[$nametype]['tags'] = false;
    $config[$nametype]['view'] = false;
    $config[$nametype]['copy'] = false;
    $config[$nametype]['copy_image'] = false;
    $config[$nametype]['slug'] = false;
    // $config[$nametype]['check'] = array("noibat" => "Nổi bật");
    $config[$nametype]['icon'] = false;
    $config[$nametype]['images'] = true;
    $config[$nametype]['images2'] = true;
    $config[$nametype]['show_images'] = false;
    $config[$nametype]['watermark'] = false;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['noidung'] = false;
    $config[$nametype]['noidung_cke'] = true;
    $config[$nametype]['seo'] = false;
    $config[$nametype]['width'] = 800;
    $config[$nametype]['height'] = 450;
    $config[$nametype]['width2'] = 50;
    $config[$nametype]['height2'] = 30;
    $config[$nametype]['width_icon'] = 50;
    $config[$nametype]['height_icon'] = 30;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '150x100x2';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    $config[$nametype]['sl_options'] = array (
        'link_youtube' => array("type" => "text", "title" => "Link youtube", "groupClass" => "form-group col-md-6 col-sm-6" ),
    );
    /* Ý kiến học viên */
    $nametype = "feedback";
    $config[$nametype]['title_main'] = "Ý kiến học viên";
    $config[$nametype]['com'] = 'feedback';
    $config[$nametype]['menu'] = false;
    $config[$nametype]['tags'] = false;
    $config[$nametype]['view'] = true;
    $config[$nametype]['copy'] = true;
    $config[$nametype]['copy_image'] = true;
    $config[$nametype]['slug'] = false;
    // $config[$nametype]['check'] = array("noibat" => "Nổi bật");
    $config[$nametype]['icon'] = false;
    $config[$nametype]['images'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['watermark'] = false;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['mota_cke'] = false;
    $config[$nametype]['mota_cke_custom'] = false;
    $config[$nametype]['noidung'] = false;
    $config[$nametype]['noidung_cke'] = false;
    $config[$nametype]['width'] = 200;
    $config[$nametype]['height'] = 200;
    $config[$nametype]['width_icon'] = 50;
    $config[$nametype]['height_icon'] = 50;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '100x100x1';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    $config[$nametype]['sl_options'] = array (
        'tieudetop' => array("type" => "text", "title" => "Tiêu đề top", "groupClass" => "form-group col-md-6 col-sm-6" ),
        'congty' => array("type" => "text", "title" => "Công ty", "groupClass" => "form-group col-md-6 col-sm-6" ),
    );

    /* Ý kiến doanh nghiệp */
    $nametype = "feedback2";
    $config[$nametype]['title_main'] = "Ý kiến doanh nghiệp";
    $config[$nametype]['com'] = 'feedback2';
    $config[$nametype]['menu'] = false;
    $config[$nametype]['tags'] = false;
    $config[$nametype]['view'] = true;
    $config[$nametype]['copy'] = true;
    $config[$nametype]['copy_image'] = true;
    $config[$nametype]['slug'] = false;
    // $config[$nametype]['check'] = array("noibat" => "Nổi bật");
    $config[$nametype]['icon'] = false;
    $config[$nametype]['images'] = true;
    $config[$nametype]['show_images'] = true;
    $config[$nametype]['watermark'] = false;
    $config[$nametype]['amount_images'] = 1;
    $config[$nametype]['mota'] = true;
    $config[$nametype]['mota_cke'] = false;
    $config[$nametype]['mota_cke_custom'] = false;
    $config[$nametype]['noidung'] = false;
    $config[$nametype]['noidung_cke'] = false;
    $config[$nametype]['width'] = 200;
    $config[$nametype]['height'] = 200;
    $config[$nametype]['width_icon'] = 50;
    $config[$nametype]['height_icon'] = 50;
    $config[$nametype]['ratio'] = 1;
    $config[$nametype]['thumb'] = '100x100x1';
    $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    $config[$nametype]['sl_options'] = array (
        'tieudetop' => array("type" => "text", "title" => "Tiêu đề top", "groupClass" => "form-group col-md-6 col-sm-6" ),
        'congty' => array("type" => "text", "title" => "Công ty", "groupClass" => "form-group col-md-6 col-sm-6" ),
    );
    /* Chính sách */
    // $nametype = "shop";
    // $config[$nametype]['com'] = 'shop';
    // $config[$nametype]['menu'] = true;
    // $config[$nametype]['sitemap'] = true;
    // $config[$nametype]['title_main'] = "Shop";
    // $config[$nametype]['dropdown'] = false;
    // $config[$nametype]['tags'] = false;
    // $config[$nametype]['view'] = true;
    // $config[$nametype]['copy'] = true;
    // $config[$nametype]['copy_image'] = true;
    // $config[$nametype]['slug'] = true;
    // // $config[$nametype]['check'] = array("noibat" => "Nổi bật");
    // $config[$nametype]['icon'] = false;
    // $config[$nametype]['images'] = false;
    // $config[$nametype]['show_images'] = false;
    // $config[$nametype]['watermark'] = false;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['mota'] = false;
    // $config[$nametype]['noidung'] = true;
    // $config[$nametype]['noidung_cke'] = true;
    // $config[$nametype]['seo'] = true;
    // $config[$nametype]['width'] = 300;
    // $config[$nametype]['height'] = 250;
    // $config[$nametype]['width_icon'] = 50;
    // $config[$nametype]['height_icon'] = 50;
    // $config[$nametype]['ratio'] = 2;
    // $config[$nametype]['thumb'] = '300x250x1';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Chính sách */
    // $nametype = "chinhsachfooter";
    // $config[$nametype]['com'] = 'chinh-sach-footer';
    // $config[$nametype]['menu'] = false;
    // $config[$nametype]['sitemap'] = true;
    // $config[$nametype]['title_main'] = "Chính sách footer";
    // $config[$nametype]['dropdown'] = false;
    // $config[$nametype]['tags'] = false;
    // $config[$nametype]['view'] = true;
    // $config[$nametype]['copy'] = true;
    // $config[$nametype]['copy_image'] = true;
    // $config[$nametype]['slug'] = true;
    // // $config[$nametype]['check'] = array("noibat" => "Nổi bật");
    // $config[$nametype]['icon'] = false;
    // $config[$nametype]['images'] = true;
    // $config[$nametype]['show_images'] = true;
    // $config[$nametype]['watermark'] = false;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['mota'] = false;
    // $config[$nametype]['noidung'] = true;
    // $config[$nametype]['noidung_cke'] = true;
    // $config[$nametype]['seo'] = true;
    // $config[$nametype]['width'] = 300;
    // $config[$nametype]['height'] = 250;
    // $config[$nametype]['width_icon'] = 50;
    // $config[$nametype]['height_icon'] = 50;
    // $config[$nametype]['ratio'] = 2;
    // $config[$nametype]['thumb'] = '300x250x1';
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';
    /* Hình thức thanh toán */
    // $nametype = "hinh-thuc-thanh-toan";
    // $config[$nametype]['title_main'] = "Hình thức thanh toán";
    // $config[$nametype]['check'] = array();
    // $config[$nametype]['mota'] = false;
    // $config[$nametype]['noidung'] = true;
    // $config[$nametype]['noidung_cke'] = true;
    /* Quản lý mục (Không cấp) */
    if ($config) {
        foreach ($config as $key => $value) {
            if (!isset($value['dropdown']) || (isset($value['dropdown']) && $value['dropdown'] == false)) {
                $config['shownews'][$key] = $value;
            }
        }
    }
    return $config;
