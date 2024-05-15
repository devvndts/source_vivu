<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all
     * @return mixed
     */
    public function getAll($type,$params,$relations);


     /**
     * Get all
     * @return mixed
     */
    public function GetAllItems($type,$params,$relations, $paginate);


    /**
     * get array data with field which you want after response data
     * @param array $attributes
     * @return mixed
     */
    public function GetAllItemsByParamsPluck($field, $params);


    /**
     * Get all except one
     * @param array $attributes
     * @return mixed
     */
    public function GetAllItemsExceptId($type,$params,$relations,$paginate);

    /**
     * Get all by search
     * @return mixed
     */
    public function GetItemsBySearch($type,$keyword, $relations);

    /**
     * Find in set
     * @param $id
     * @return mixed
     */
    public function GetAllItemsFindInSet($type, $tag_id , $field_search, $relations, $paginate);


    /**
     * Get one item by id
     * @param $id
     * @return mixed
     */
    public function GetOneItem($id, $relations);


    /**
     * Get one item by params
     * @param $id
     * @return mixed
     */
    public function GetItem($params);

    /**
     * get all items by ids
     * @param $id
     * @return mixed
     */
    public function GetAllItemByIds($ids, $relations);


    /**
     * get all items by ids string
     * @param $id
     * @return mixed
     */
    public function GetItemByListId($listid);


    /**
     * check one item by params
     * @param $id
     * @return mixed
     */
    public function CheckOneItemByParams($params);

    /**
     * save or update item
     * @param $id
     * @return mixed
     */
    public function SaveItem($data,$id);


    /**
     * delete one item
     * @param $id
     * @return mixed
     */
    public function DeleteOneItem($id, $folder_name);


    /**
     * delete multy item
     * @param $id
     * @return mixed
     */
    public function DeleteMultiItem($listid, $folder_name);
    
    /**
     * delete tmp one item
     * @param $id
     * @return mixed
     */
    public function DeleteTMPOneItem($id);

    /**
     * delete tmp all item
     * @param $id
     * @return mixed
     */
    public function DeleteTMPMultiItem($listid);

    /**
     * get all watermark
     * @param $id
     * @return mixed
     */
    //public function GetAllWatermark($params);

    /**
     * get all watermark
     * @param $id
     * @return mixed
     */
    //public function GetWatermark($params);


     /**
     * get all gallery
     * @param $id
     * @return mixed
     */
    public function GetAllGallery($type,$idphoto,$com);


    /**
     * delete gallery
     * @param $id
     * @return mixed
     */
    public function DeleteGallery($id_photo,$kind,$type,$folder,$com);


    /**
     * delete multy gallery
     * @param $id
     * @return mixed
     */
    public function DeleteMultiGallery($listid,$kind,$type,$folder,$com);


    /**
     * count item
     * @param $id
     * @return mixed
     */
    public function CountItems($type);
}