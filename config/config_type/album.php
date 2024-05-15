<?php
	$config= array();

	/* Album */
    // $nametype = "bosuutap";
    // $config[$nametype]['com'] = 'bo-suu-tap';
    // $config[$nametype]['menu'] = true;
    // $config[$nametype]['sitemap'] = false;
    // $config[$nametype]['title_main'] = "Bộ sưu tập";
    // $config[$nametype]['dropdown'] = true;    
    // $config[$nametype]['view'] = true;
    // $config[$nametype]['copy'] = true;
    // $config[$nametype]['copy_image'] = true;
    // $config[$nametype]['slug'] = true;
    // $config[$nametype]['check'] = array("noibat" => "Nổi bật");
    // $config[$nametype]['images'] = true;
    // $config[$nametype]['show_images'] = true;
    // $config[$nametype]['amount_images'] = 1;
    // $config[$nametype]['gallery'] = array
    // (
    //     $nametype => array
    //     (
    //         "title_main_photo" => "Hình ảnh",
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
    //         "title_main_photo" => "Video",
    //         "title_sub_photo" => "Video",
    //         "number_photo" => 2,
    //         "video_photo" => true,
    //         "tieude_photo" => true
    //     ),
    //     "taptin" => array
    //     (
    //         "title_main_photo" => "Tập tin",
    //         "title_sub_photo" => "Tập tin",
    //         "number_photo" => 2,
    //         "file_photo" => true,
    //         "tieude_photo" => true,
    //         "file_type_photo" => 'doc|docx|pdf|rar|zip|ppt|pptx|DOC|DOCX|PDF|RAR|ZIP|PPT|PPTX|xls|jpg|png|gif|JPG|PNG|GIF|xls|XLS'
    //     )
    // );
    // $config[$nametype]['mota'] = true;
    // $config[$nametype]['noidung'] = true;
    // $config[$nametype]['noidung_cke'] = true;
    // $config[$nametype]['seo'] = true;
    // $config[$nametype]['width'] = 270;
    // $config[$nametype]['height'] = 270;
    // $config[$nametype]['thumb'] = '100x100x1';
	// $config[$nametype]['ratio'] = 2;
    // $config[$nametype]['img_type'] = '.jpg|.gif|.png|.jpeg|.gif|.JPG|.PNG|.JPEG|.Png|.GIF';


	/* Quản lý mục (Không cấp) */
    if($config)
    {
        foreach($config as $key => $value)
        {
            if(!isset($value['dropdown']) || (isset($value['dropdown']) && $value['dropdown'] == false))
            {
                $config['shownews'][$key] = $value;
            }
        }
    }

	return $config;
?>
