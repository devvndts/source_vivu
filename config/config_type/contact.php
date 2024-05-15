<?php
    $config= array();

    /* Đăng ký nhận tin */
    $nametype = "lienhe";
    $config[$nametype]['com'] = 'lien-he';
    $config[$nametype]['menu'] = true;
    $config[$nametype]['title_main'] = "site.contact";
    $config[$nametype]['file'] = true;
    $config[$nametype]['email'] = true;
    $config[$nametype]['guiemail'] = true;
    $config[$nametype]['ten'] = true;
    $config[$nametype]['dienthoai'] = true;
    $config[$nametype]['diachi'] = true;
    $config[$nametype]['tieude'] = true;
    $config[$nametype]['noidung'] = true;
    $config[$nametype]['ghichu'] = true;
    $config[$nametype]['showten'] = true;
    $config[$nametype]['showdienthoai'] = true;
    $config[$nametype]['showngaytao'] = true;
    $config[$nametype]['file_type'] = 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS';

    return $config;
