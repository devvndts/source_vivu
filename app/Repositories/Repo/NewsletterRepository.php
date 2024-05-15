<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class NewsletterRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {        
        return \App\Models\Newsletter::class;        
    }
}