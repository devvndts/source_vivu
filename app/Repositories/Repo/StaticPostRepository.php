<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class StaticPostRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {        
        return \App\Models\StaticPost::class;       
    }
}