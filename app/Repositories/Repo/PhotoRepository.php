<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class PhotoRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {        
        $this->numberPerpage = config('config_all.numberperpage.photo');
        return \App\Models\Photo::class;
    }

    /*
    |--------------------------------------------------------------------------
    | Lấy danh sách watermark
    |--------------------------------------------------------------------------
    */
    public function GetAllWatermark($params=null){
        $run_sql = $this->model;
        if($params){
            foreach($params as $k=>$v){
                $run_sql=$run_sql->where($k, $v);
            }
        }
        $run_sql = $run_sql->where('options','<>',null)->hienthi()->orderBy('stt', 'asc');
        $result = $run_sql->get()->toArray();

        $arr_tmp = array();
        $upload_folder = config('config_upload.UPLOAD_PHOTO');

        foreach($result as $k=>$v){
            $arr_tmp[$v['type']]['position'] = json_decode($v['options'],true)['watermark']['position'];
            $arr_tmp[$v['type']]['photo'] = $upload_folder.$v['photo'];
            $arr_tmp[$v['type']]['name'] = $v['ngaytao'];
        }
        return $arr_tmp;
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy watermark theo type
    |--------------------------------------------------------------------------
    */
    public function GetWatermark($params=null){
        $run_sql = $this->model;
        if($params){
            foreach($params as $k=>$v){
                $run_sql=$run_sql->where($k, $v);
            }
        }
        $run_sql = $run_sql->where('options','<>',null)->hienthi()->orderBy('stt', 'asc');
        $result = $run_sql->first()->toArray();

        $arr_tmp = array();
        $upload_folder = config('config_upload.UPLOAD_PHOTO');

        $arr_tmp[$result['type']]['position'] = json_decode($result['options'],true)['watermark']['position'];
        $arr_tmp[$result['type']]['photo'] = $upload_folder.$result['photo'];
        $arr_tmp[$result['type']]['name'] = $result['ngaytao'];
        return $arr_tmp;
    }

    /*
    |--------------------------------------------------------------------------
    | Lấy 1 dòng dữ liệu theo params truyền vào
    |--------------------------------------------------------------------------
    */
    public function GetPhotoStatic($params=null){
        $run_sql = $this->model;

        if($params){
            foreach($params as $k=>$v){
                if($k!='keyword' && $v>0){
                    $run_sql=$run_sql->where($k, $v);
                }
                if($k=='xoatam'){
                    $run_sql=$run_sql->where($k, $v);
                }
                if($k=='keyword' && $v!=''){
                    $run_sql=$run_sql->like('tenvi', $v);
                }
                $run_sql=$run_sql->where($k, $v);
            }
        }
        $run_sql = $run_sql->get()->keyBy('type');
        if($run_sql){
            $run_sql = $run_sql->toArray();
        }else{
            $run_sql = null;
        }
        return $run_sql;
    }
}