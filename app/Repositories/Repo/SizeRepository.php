<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class SizeRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {        
        $this->numberPerpage = config('config_all.numberperpage.size');
        return \App\Models\Size::class;       
    }
}