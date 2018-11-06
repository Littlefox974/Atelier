<?php
/**
 * Created by PhpStorm.
 * User: rubenconde
 * Date: 11/6/18
 * Time: 9:09 AM
 */

namespace myGiftApp\model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'MGB_order';
    protected $primaryKey = 'id';

    public function user(){
        return self::belongsTo('myGiftApp\model\User','idUser');
    }

    public function cart(){
        return self::belongsTo('myGiftApp\model\Cart','idCart');
    }
}