<?php
/**
 * Created by PhpStorm.
 * User: Jalil
 * Date: 10/11/2018
 * Time: 10:49 AM
 */
namespace mf\utils;

class HttpRequest extends AbstractHttpRequest {

    function __construct(){
        if (isset($_SERVER['PATH_INFO'])) {
            $this->path_info = $_SERVER['PATH_INFO'];
        }
        $this->script_name = $_SERVER['SCRIPT_NAME'];
        $this->root = dirname($_SERVER['SCRIPT_NAME']);
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->get = $_GET;
        $this->post = $_POST;

    }
}