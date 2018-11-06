<?php
/**
 * Created by PhpStorm.
 * User: jalil
 * Date: 11/5/18
 * Time: 5:03 PM
 */
session_start();

use Composer\Autoload\ClassLoader;
use mf\router\Router;
use myGiftApp\auth\GiftBoxAuth;

require_once __DIR__ . '/vendor/autoload.php';

$config = parse_ini_file('conf/config.ini');

$loader = new ClassLoader();
$loader -> register();

$db = new Illuminate\Database\Capsule\Manager();

$db->addConnection( $config ); /* configuration avec nos paramètres */
$db->setAsGlobal();            /* visible de tout fichier */
$db->bootEloquent();           /* établir la connexion */

$router = new Router();
$router->addRoute('home', '/home/', '\myGiftApp\control\GiftBoxController',
    'viewHome', GiftBoxAuth::ACCESS_LEVEL_NONE);

$router->addRoute('login','/login/','\myGiftApp\control\GiftBoxController',
    'viewLogin',GiftBoxAuth::ACCESS_LEVEL_NONE);

$router->setDefaultRoute('/home/');

$router->run();

