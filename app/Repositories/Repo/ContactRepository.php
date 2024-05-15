<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class ContactRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Contact::class;
    }
}