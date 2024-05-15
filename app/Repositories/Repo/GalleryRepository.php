<?php

namespace App\Repositories\Repo;

use App\Repositories\BaseRepository;

class GalleryRepository extends BaseRepository
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Gallery::class;
    }

    public function UpdateHashGallery($idphoto, $hash)
    {
        if ($hash!='' && $idphoto > 0) {
            $this->model->where('hash', $hash)
            ->where('id_photo', 0)
            ->update(['id_photo'=>$idphoto,'id_photo_old'=>$idphoto,'hash'=>'']);
        }
    }
}
