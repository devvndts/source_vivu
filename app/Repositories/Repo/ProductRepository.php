<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {
        $this->numberPerpage = config('config_all.numberperpage.productman');
        return \App\Models\Product::class;
    }
}