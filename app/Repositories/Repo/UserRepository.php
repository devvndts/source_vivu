<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {
        $this->numberPerpage = config('config_all.numberperpage.tags');
        return \App\Models\User::class;
    }
}
