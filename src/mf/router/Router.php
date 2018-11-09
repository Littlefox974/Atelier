<?php
/**
 * Created by PhpStorm.
 * User: Jalil
 * Date: 10/16/2018
 * Time: 3:45 PM
 */
namespace mf\router;
use mf\auth\Authentification;


class Router extends AbstractRouter{

    protected static $routes = [];
    protected static $aliases;
    protected $http_req;

    public function __construct(){
        parent::__construct();
    }


    public function run()
    {
        $reqUrl = $this->http_req->path_info;

        $auth = new Authentification();

        if (array_key_exists($reqUrl,self::$routes)
            && $auth->checkAccessRight(self::$routes[$reqUrl][2]))
        {
            $controllerName = self::$routes[$reqUrl][0];
            $methodName = self::$routes[$reqUrl][1];

        }else {
            $defaultRoute =  self::$routes[self::$aliases['default']];
            $controllerName = $defaultRoute[0];
            $methodName = $defaultRoute[1];
        }

        $controller = $controllerName;
        $controller = new $controller();
        $controller->$methodName();
    }

    public function executeRoute($alias){
        $route = self::$aliases[$alias];
        $control = self::$routes[$route][0];
        $method = self::$routes[$route][1];

        $exec = new $control();
        $exec->$method();
    }

    public function urlFor($route_name, $param_list = []){
        $reqUrl = $this->http_req->script_name;
        $route =  self::$aliases[$route_name];

        $urlComplete = $reqUrl . $route;

        if (count($param_list) > 0){
            $arr = [];

            foreach ($param_list as $value){
                $arr = implode("=",$value);
            }
            if (count($arr) > 1)
                $urlComplete .= "?" . implode("&amp;",$arr);
            else
                $urlComplete .= "?" . $arr;
        }

        return $urlComplete;

    }

    public function setDefaultRoute($url){
        self::$aliases['default'] = $url;
    }

    public function addRoute($name, $url, $ctrl, $mth, $accLvl){
        self::$routes[$url] = [$ctrl,$mth, $accLvl];
        self::$aliases[$name] = $url;
    }

    public function printRoutes(){
        print_r(self::$routes);

        print_r(self::$aliases);
    }

}

