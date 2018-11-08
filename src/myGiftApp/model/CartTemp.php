<?php
/**
 * Created by PhpStorm.
 * User: jalil
 * Date: 11/8/18
 * Time: 2:14 PM
 */

namespace myGiftApp\myGiftApp\model;


use Illuminate\Database\Eloquent\Model;

class CartTemp extends Model {

    protected $table = 'MGB_cartTemp';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function user(){
        return self::belongsTo('myGiftApp\model\User','idUser');
    }

}