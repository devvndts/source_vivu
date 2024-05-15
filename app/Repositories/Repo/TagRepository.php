<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class TagRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {        
        $this->numberPerpage = config('config_all.numberperpage.tags');        
        return \App\Models\Tags::class;
    }
}