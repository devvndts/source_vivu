<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class BrandRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {        
        $this->numberPerpage = config('config_all.numberperpage.brand');
        return \App\Models\Brand::class;       
    }
}