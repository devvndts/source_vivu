<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class InventoryRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Inventory::class;
    }
}