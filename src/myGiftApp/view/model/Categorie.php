<?php
/**
 * Created by PhpStorm.
 * User: rubenconde
 * Date: 11/6/18
 * Time: 9:25 AM
 */

namespace myGiftApp\model;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $table = 'MGB_categorie';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function prestations(){
        return self::hasMany('myGiftApp\model\Prestation','cat_id');
    }


}