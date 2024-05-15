<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class PostRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {        
        $this->numberPerpage = config('config_all.numberperpage.postman');
        return \App\Models\Post::class;
    }
}