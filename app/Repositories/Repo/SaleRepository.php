<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class SaleRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Sale::class;
    }
}
