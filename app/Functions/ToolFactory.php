<?php

namespace App\Functions;

use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\App;
use Helper;
use Illuminate\Support\Facades\Lang;

class ToolFactory
{
    public function getPosts($type, $lang = 'vi', $options = null)
    {
        $query = DB::table('post as A')
            ->select('A.*')
            ->where('A.type', $type)
            ->where('A.hienthi', '1');

        if (isset($options["query"])) {
            foreach ($options["query"] as $key => $value) {
                $query->where($key, $value);
            }
        }

        if (isset($options["order_by"])) {
            foreach ($options["order_by"] as $key => $value) {
                $query->orderBy($key, $value);
            }
        } else {
            $query->orderBy('A.id', 'desc');
        }

        if (isset($options["limit"])) {
            $query->limit($options["limit"]);
        }
        return $query->get();
    }
    public function getTags($type, $lang = 'vi', $options = null)
    {
        $query = DB::table('tags as A')
            ->select('A.*')
            ->where('A.type', $type)
            ->where('A.hienthi', '1');

        if (isset($options["query"])) {
            foreach ($options["query"] as $key => $value) {
                $query->where($key, $value);
            }
        }

        if (isset($options["order_by"])) {
            foreach ($options["order_by"] as $key => $value) {
                $query->orderBy($key, $value);
            }
        } else {
            $query->orderBy('A.id', 'desc');
        }

        if (isset($options["limit"])) {
            $query->limit($options["limit"]);
        }
        return $query->get();
    }
    public function getProducts($type, $lang = 'vi', $options = null)
    {
        $query = DB::table('product as A')
            ->select('A.*')
            ->where('A.type', $type)
            ->where('A.hienthi', '1');

        if (isset($options["query"])) {
            foreach ($options["query"] as $key => $value) {
                $query->where($key, $value);
            }
        }

        if (isset($options["order_by"])) {
            foreach ($options["order_by"] as $key => $value) {
                $query->orderBy($key, $value);
            }
        } else {
            $query->orderBy('A.id', 'desc');
        }

        if (isset($options["limit"])) {
            $query->limit($options["limit"]);
        }

        if (isset($options["toSql"]) && $options["toSql"]) {
            echo Helper::showSql($query);
        } else {
            return $query->get();
        }
    }
    public function getStatic($type, $lang = 'vi')
    {
        return DB::table('static as A')
            ->select('A.*')
            ->where('A.type', $type)
            ->where('A.hienthi', '1')
            ->first();
    }
    public function getSales($type, $lang = 'vi', $options = null)
    {
        return DB::table('sales as A')
            ->select('A.*')
            ->where('A.type', $type)
            ->where('A.hienthi', '1')
            ->get();
    }
    public function getStaticPhoto($type, $lang = 'vi', $options = null)
    {
        return DB::table('photo as A')
        ->select('A.*')
        ->where('A.type', $type)
        ->where('A.hienthi', '1')
        ->first();
    }
    public function getPhotos($type, $lang = 'vi', $options = null)
    {
        $query = DB::table('photo as A')
        ->select('A.*')
        ->where('A.type', $type)
        ->where('A.hienthi', '1');

        if (isset($options["order_by"])) {
            foreach ($options["order_by"] as $key => $value) {
                $query->orderBy($key, $value);
            }
        } else {
            $query->orderBy('A.id', 'desc');
        }

        if (isset($options["toSql"]) && $options["toSql"]) {
            echo Helper::showSql($query);
        } else {
            return $query->get();
        }
    }
    public function getCategories($type, $lang = 'vi', $options = null)
    {
        $query = DB::table('category as A')
            ->select('A.*')
            ->where('A.type', $type)
            ->where('A.hienthi', '1');
            
        if (isset($options["query"])) {
            foreach ($options["query"] as $key => $value) {
                $query->where($key, $value);
            }
        }

        if (isset($options["order_by"])) {
            foreach ($options["order_by"] as $key => $value) {
                $query->orderBy($key, $value);
            }
        } else {
            $query->orderBy('A.id', 'desc');
        }

        if (isset($options["toSql"]) && $options["toSql"]) {
            echo Helper::showSql($query);
        } else {
            return $query->get();
        }
    }
    public function getGalleries($type, $lang = 'vi', $options = null)
    {
        $query = DB::table('gallery as A')
            ->select('A.*')
            ->where('A.type', $type)
            ->where('A.hienthi', '1');
            
        if (isset($options["query"])) {
            foreach ($options["query"] as $key => $value) {
                $query->where($key, $value);
            }
        }

        if (isset($options["order_by"])) {
            foreach ($options["order_by"] as $key => $value) {
                $query->orderBy($key, $value);
            }
        } else {
            $query->orderBy('A.id', 'desc');
        }

        if (isset($options["toSql"]) && $options["toSql"]) {
            echo Helper::showSql($query);
        } else {
            return $query->get();
        }
    }
    public function getStringForLocale($stringKey, $options = null)
    {
        $locale = App::currentLocale();
        $result = $stringKey;
        if (Lang::hasForLocale($stringKey, $locale)) {
            $result = __($stringKey);
        }
        return $result;
    }
}
