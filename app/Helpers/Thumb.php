<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

use App\Repositories\Repo\PhotoRepository;
use App\Repositories\Repo\SettingRepository;
use Spatie\Permission\Models\Role;

use DB;
use Image;
use Browser;

class Thumb
{
    /*
    |--------------------------------------------------------------------------
    | remove folder thumbs after 30 days
    |--------------------------------------------------------------------------
    */
    public static function RemoveThumbs()
    {
        //check time to remove thumbs folder and load again the folder
        $model_setting = new SettingRepository();
        $setting = $model_setting->GetItem();
        $date_remove_thumb = $setting['dateremovethumb'];

        if (time()>=$date_remove_thumb) {
            foreach (glob(public_path() . '/thumbs/*') as $folder) {
                if (File::isDirectory($folder)) {
                    File::deleteDirectory($folder);
                }
            }
            $time_now = date('d/m/Y', time());
            $time_to_remove = strtotime('+3 days', strtotime(str_replace('/', '-', $time_now)));
            $data['dateremovethumb'] = $time_to_remove;
            $row = $model_setting->SaveItem($data, $setting['id']);
            Cache::flush();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Tạo thumb ảnh
    |--------------------------------------------------------------------------
    */
    public static function Crop($path, $image, $width = null, $height = null, $typethumb = null, $type = null, $extension = 'png', $quality = 100)
    {
        /*
         * $path: folder upload của hình gốc
         * $image: tên file hình gốc
         * $width : chiều dài muốn tạo thumb
         * $height: chiều cao muốn tạo thumb
         * $typethumb: loại thumb muốn tạo: fit - resize - crop
         * $quality: chất lượng ảnh sau khi thumb
         * $type: loại watermark sản phẩm theo type
         //onerror=src="{{asset('img/noimage.png')}}"
        */


        //### check browser deteck
        $ext_arr = explode('.', $image);
        $ext = $ext_arr[count($ext_arr)-1];

        //$extension = $ext;

        if ($ext!='gif' && $ext!='mp4') {
            $extension = ($extension!='') ? $extension : 'webp';
            if (Browser::isSafari() || Browser::isIE()) {
                $extension = 'png';
            }
        } else {
            return $path.$image;
        }


        // ### tạo folder thumbs chứa các file hình kiểu thumb
        $public_thumb = 'public/thumbs/'.$width.'x'.$height.'x'.$typethumb.'/';
        $savedDir = base_path($public_thumb);
        $imageFullPath = base_path($path.$image);

        //nếu ảnh (gốc) truyền vào ko tồn tại hoặc ko có giá trị
        if (!file_exists($imageFullPath) || $image=='') {
            return self::Crop('img/', 'noimage.png', $width, $height, 1);
        }


        /* nếu type watermark có tồn tại */
        $watermark_name = $watermark_position = $watermark_photo = '';

        if ($type && isset(config('config_type.photo')[$type]['watermark']) && config('config_type.photo')[$type]['watermark']==true) {
            // lấy watermark
            $model_photo = new PhotoRepository();
            $arr_watermark = $model_photo->GetWatermark(['act'=>'photo_static','type'=>$type]);
            $watermark = $arr_watermark[$type];
            $watermark_name = $watermark['name'];
            $watermark_position = $watermark['position'];
            $watermark_photo = $watermark['photo'];
        }


        //change extension
        if ($extension!='') {
            $image_name = '';
            $image_data = explode('.', $image);
            unset($image_data[count($image_data)-1]);
            foreach ($image_data as $k => $v) {
                $image_name.=$v;
            }
            $new_image = $image_name.'.'.$extension;
        } else {
            $new_image = $image;
        }
        

        // ### kiểm tra folder lưu thumb tương ứng đã tồn tại ?
        $savedPath = ($watermark_name!='') ? $savedDir.$quality.'_'.$watermark_name.'_'.$new_image : $savedDir.$quality.'_'.$new_image;
        if (!is_dir($savedDir)) {
            mkdir($savedDir, 0777, true);
        }

        if (is_dir($savedDir) && (!is_null($width) && !is_null($height) && $height > 0 && $width > 0)) {
            if (!is_file($savedDir.'transparent.png')) {
                $background = imagecreatetruecolor($width, $height) or die("Cannot Initialize new GD image stream");
                $bg_tran = imagecolorallocate($background, 0, 0, 0);
                imagecolortransparent($background, $bg_tran);
                imagepng($background, $savedDir.'transparent.png');
                imagedestroy($background);

                $savedDir = base_path($savedDir);
            }
        }


        // ### kiểm tra file đã tồn tại chưa?
        if (file_exists($public_thumb.$quality.'_'.$new_image)) {
            return $public_thumb.$quality.'_'.$new_image;
        }
        

        // ### tạo ảnh cache
        $img = Image::cache(function ($image) use ($imageFullPath, $typethumb, $height, $width, $watermark_photo, $watermark_position, $savedPath, $quality, $savedDir) {
            if (!is_null($width) && !is_null($height) && $height > 0 && $width > 0 && $typethumb==2) {
                if (is_file($savedDir.'transparent.png')) {
                    $image_tmp = $savedDir.'transparent.png';
                    $image->make($image_tmp);

                    if ($imageFullPath) {
                        $image_main = Image::make($imageFullPath);
                        $image_main->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    }
                    
                    $image->insert($image_main, 'center');
                } else {
                    $image->make($imageFullPath);
                }
            } else {
                $image->make($imageFullPath);
            }

            switch ($typethumb) {
                case 1:
                    if ($height != 0 && $width!=0 && !is_null($height) && !is_null($width)) {
                        $image->orientate()->fit($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } elseif (is_null($height) || $height == 0) {
                        $image->fit($width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } elseif (is_null($width) || $width == 0) {
                        $image->fit(null, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    break;
                case 2:
                    if (is_null($height) || $height == 0) {
                        $image->resize($width, null, function ($constraint) {
                            $constraint->aspectRatio();
                            // $constraint->upsize();
                        });
                    } elseif (is_null($width) || $width == 0) {
                        $image->resize(null, $height, function ($constraint) {
                            $constraint->aspectRatio();
                            // $constraint->upsize();
                        });
                    }
                    break;
                case 3:
                    if (is_null($height) || $height == 0) {
                        $image->crop($width, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } elseif (is_null($width) || $width == 0) {
                        $image->crop(null, $height, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    break;
                default:
                    $image->fit($width, $height);
                    break;
            }


            if ($watermark_photo!='' && $watermark_position!='') {
                $image->insert($watermark_photo, $watermark_position);
            }
            $image->save($savedPath, $quality);
        }, 30*24*60*60, true);

        return ($watermark_name!='') ? $public_thumb . $quality . '_'. $watermark_name . '_' . $new_image : $public_thumb . $quality . '_' . $new_image;
    }
}
