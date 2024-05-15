<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class DanhgiaRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {             
        return \App\Models\Danhgia::class;
    }
}