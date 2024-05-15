<?php

namespace App\Helpers;

/*use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;*/

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableManipulation{
	/*
    |--------------------------------------------------------------------------
    | thêm 1 trường vô 1 bảng đã tồn tại
    |--------------------------------------------------------------------------
    */
	public static function AddFieldToTable($tablename,$fieldname,$fieldtype='int'){		
		if(!Schema::hasColumn($tablename, $fieldname)) {
            Schema::table($tablename, function (Blueprint $table) use ($fieldtype, $fieldname) {
            	switch ($fieldtype) {
            		case 'int':
            			$table->bigInteger($fieldname)->default(0);
            			break;
            		case 'string':
            			$table->string($fieldname)->nullable();
            			break;
            		case 'text':
            			$table->text($fieldname)->nullable();
            			break;
            	}
                
            });
        }
	}


    /*
    |--------------------------------------------------------------------------
    | Check field
    |--------------------------------------------------------------------------
    */
    public static function CheckFieldToTable($tablename, $fieldname){
        if(Schema::hasColumn($tablename, $fieldname)) {
            return true;
        }
        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | thêm 1 trường vô 1 bảng đã tồn tại
    |--------------------------------------------------------------------------
    */
    public static function RemoveFieldToTable($tablename,$fieldname){     
        if(Schema::hasColumn($tablename, $fieldname)) {
            Schema::table($tablename, function (Blueprint $table) use ($fieldname) {
                $table->dropColumn($fieldname);
            });
        }
    }
}
