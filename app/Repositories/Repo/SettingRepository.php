<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class SettingRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {        
        return \App\Models\Setting::class;        
    }
}