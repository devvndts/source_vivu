<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class AlbumRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {
        $this->numberPerpage = config('config_all.numberperpage.albumman');
        return \App\Models\Album::class;
    }
}