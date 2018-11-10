<?php
/**
 * Created by PhpStorm.
 * User: jalil
 * Date: 11/5/18
 * Time: 5:13 PM
 */

namespace myGiftApp\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    protected $table = 'MGB_user';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function orders(){
        return self::hasMany('myGiftApp\model\Order','idUser');
    }

}