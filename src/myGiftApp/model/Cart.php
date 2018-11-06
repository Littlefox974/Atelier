<?php
/**
 * Created by PhpStorm.
 * User: rubenconde
 * Date: 11/6/18
 * Time: 9:16 AM
 */

namespace myGiftApp\model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'MGB_cart';
    protected $primaryKey = 'id';

    public function orders(){
        return self::hasMany('myGiftApp\model\Order','idCart');
    }

    public function bodies(){
        return self::hasMany('myGiftApp\model\Body','idCart');
    }
}