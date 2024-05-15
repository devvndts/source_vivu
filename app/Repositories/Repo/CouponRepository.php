<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class CouponRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {
        $this->numberPerpage = config('config_all.numberperpage.coupon');
        return \App\Models\Coupon::class;
    }
}