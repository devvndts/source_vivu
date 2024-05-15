<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class SaleProductRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\SaleProduct::class;
    }
}
