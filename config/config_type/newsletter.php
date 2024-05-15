<?php
	$config= array();

    /* Đăng ký nhận tin */
    $nametype = "dangkynhantin";
    $config[$nametype]['title_main'] = "Đăng ký nhận tin";
    $config[$nametype]['file'] = false;
    $config[$nametype]['file2'] = false;
    $config[$nametype]['email'] = true;
    $config[$nametype]['guiemail'] = true;
    $config[$nametype]['ten'] = true;
    $config[$nametype]['dienthoai'] = false;
    $config[$nametype]['diachi'] = false;
    $config[$nametype]['chude'] = false;
    $config[$nametype]['noidung'] = false;
    $config[$nametype]['ghichu'] = true;
    $config[$nametype]['tinhtrang'] = array("1" => "Đã xem", "2" => "Đã liên hệ", "3" => "Đã thông báo");
    $config[$nametype]['showten'] = true;
    $config[$nametype]['showdienthoai'] = false;
    $config[$nametype]['showngaytao'] = true;
    $config[$nametype]['file_type'] = 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS';
    // $config[$nametype]['sl_options'] = array(
    //     'sokhach' => array("type" => "number", "title" => "Số khách", "groupClass" => "form-group col-md-4 col-sm-6" ),
    //     'ngayden' => array("type" => "date", "title" => "Ngày đến", "groupClass" => "form-group col-md-4 col-sm-6" ),
    // );

    /* Đăng ký tư vấn */
    $nametype = "dangkytuvan";
    $config[$nametype]['title_main'] = "Đăng ký tư vấn";
    $config[$nametype]['file'] = false;
    $config[$nametype]['file2'] = false;
    $config[$nametype]['email'] = true;
    $config[$nametype]['guiemail'] = false;
    $config[$nametype]['ten'] = true;
    $config[$nametype]['dienthoai'] = true;
    $config[$nametype]['diachi'] = false;
    $config[$nametype]['chude'] = true;
    $config[$nametype]['noidung'] = true;
    $config[$nametype]['ghichu'] = true;
    $config[$nametype]['tinhtrang'] = array("1" => "Đã xem", "2" => "Đã liên hệ", "3" => "Đã thông báo");
    $config[$nametype]['showten'] = true;
    $config[$nametype]['showdienthoai'] = true;
    $config[$nametype]['showngaytao'] = true;
    $config[$nametype]['file_type'] = 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS';
    // $config[$nametype]['sl_options'] = array(
        // 'sokhach' => array("type" => "number", "title" => "Số khách", "groupClass" => "form-group col-md-4 col-sm-6" ),
        // 'ngayden' => array("type" => "date", "title" => "Ngày đến", "groupClass" => "form-group col-md-4 col-sm-6" ),
    // );

    return $config;
