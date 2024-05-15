<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class InventoryDetailRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\InventoryDetail::class;
    }
}