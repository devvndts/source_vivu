<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class SeoPageRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {        
        return \App\Models\SeoPage::class;       
    }
}