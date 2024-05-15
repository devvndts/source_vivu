<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {        
        $this->numberPerpage = config('config_all.numberperpage.category');
        return \App\Models\Category::class;
    }

    /*
    |--------------------------------------------------------------------------
    | Lấy dữ liệu id của danh mục con
    |--------------------------------------------------------------------------
    */
    public function GetChildCategory($type,$id_parent){
        $arr_child = array();
        $run_sql = $this->model;

        $run_sql=$run_sql->select('id');
        if($id_parent){
            $run_sql=$run_sql->where('id_parent', $id_parent);
        }
        $run_sql = $run_sql->where('type', $type)->hienthi()->orderBy('stt', 'asc');
        if($run_sql){
            $run_sql = $run_sql->get();
            foreach($run_sql as $k=>$v){
                array_push($arr_child, $v->id);
                $arr_child = array_merge($arr_child, $this->GetChildCategory($type,$v->id));
            }
        }
        return $arr_child;
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy dữ liệu id của danh mục cha
    |--------------------------------------------------------------------------
    */
    public function GetParentCategory($type,$id_parent){
        $arr_parent = array();
        $run_sql = $this->model;

        $run_sql=$run_sql->select('id_parent');
        $run_sql=$run_sql->where('id', $id_parent)->where('type', $type)->hienthi()->orderBy('stt', 'asc');

        if($run_sql){
            $run_sql = $run_sql->get();
            foreach($run_sql as $k=>$v){
                if($v->id_parent>0){array_push($arr_parent, $v->id_parent);}
                $arr_parent = array_merge($arr_parent, $this->GetParentCategory($type,$v->id_parent));
            }
        }
        return $arr_parent;
    }


    /*
    |--------------------------------------------------------------------------
    | Lấy tất cả dòng dữ liệu theo type tương ứng - hoặc lọc theo danh mục - hoặc tìm theo từ khóa - để hiển thị ra view
    |--------------------------------------------------------------------------
    */
    public function GetAllCategory($params=null,$relations=null, $showHienthi=false){
        $run_sql = $this->model;

        if($relations){
            $run_sql = $run_sql->with($relations);
        }

        if($params){
            foreach($params as $k=>$v){
                if($k!='keyword' && $v>0){
                    $run_sql=$run_sql->where($k, $v);
                }
                if($k=='xoatam'){
                    $run_sql=$run_sql->where($k, $v);
                }
                if($k=='keyword'){
                    $run_sql=$run_sql->like('tenvi', $v);
                }
                if($k=='id_category'){
                    $run_sql=$run_sql->where($k, $v);
                }
            }
        }

        if($showHienthi){
            $run_sql = $run_sql->hienthi();
        }

        $run_sql = $run_sql->orderBy('type', 'asc')->orderBy('stt', 'asc');
        if($run_sql){
            return $run_sql->get();
        }

        return null;
    }
}