<?php
/**
 * Created by PhpStorm.
 * User: rubenconde
 * Date: 11/6/18
 * Time: 9:23 AM
 */

namespace myGiftApp\model;

use Illuminate\Database\Eloquent\Model;

class Prestation extends Model
{
    protected $table = 'MGB_prestation';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function bodies(){
        return self::hasMany('myGiftApp\model\Body','idPrestation');
    }

    public function categorie(){
        return self::belongsTo('myGiftApp\model\Categorie','cat_id');
    }

}