<?php
/**
 * Created by PhpStorm.
 * User: Jalil
 * Date: 10/11/2018
 * Time: 10:49 AM
 */
namespace mf\utils;

class ClassLoader{

    private $prefix;

    function __construct ($prefix){
        $this -> prefix = $prefix . "\\";
    }

    function autoLoad($className) {
        if (file_exists($this -> prefix . $className . '.php')) {
            require_once $this -> prefix . $className . '.php';
            return true;
        }
//        echo $this -> prefix . $className . '.php';
        return false;
    }

    public function register(){
        spl_autoload_register(array($this,"autoLoad"));
        return true;
    }
}