<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class WebhookRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {        
        return \App\Models\Webhook::class;        
    }
}