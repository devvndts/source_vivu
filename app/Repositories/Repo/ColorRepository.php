<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class ColorRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {        
        $this->numberPerpage = config('config_all.numberperpage.color');
        return \App\Models\Color::class;       
    }
}