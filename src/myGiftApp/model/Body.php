<?php
/**
 * Created by PhpStorm.
 * User: rubenconde
 * Date: 11/6/18
 * Time: 9:18 AM
 */

namespace myGiftApp\model;

use Illuminate\Database\Eloquent\Model;

class Body extends Model
{
    protected $table = 'MGB_body';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function cart(){
        return self::belongsTo('myGiftApp\model\Cart','idCart');
    }

    public function prestation(){
        return self::belongsTo('myGiftApp\model\Prestation','idPrestation');
    }
}