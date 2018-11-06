<?php
/**
 * Created by PhpStorm.
 * User: jalil
 * Date: 11/5/18
 * Time: 5:03 PM
 */


use myGiftApp\auth\GiftBoxAuth;

require_once 'vendor/autoload.php';

$config = parse_ini_file('conf/config.ini');

$db = new Illuminate\Database\Capsule\Manager();

$db->addConnection( $config ); /* configuration avec nos paramètres */
$db->setAsGlobal();            /* visible de tout fichier */
$db->bootEloquent();           /* établir la connexion */

$router = new \mf\router\Router();
$router->addRoute('home', '/home/', '\myGiftApp\control\GiftBoxController',
    'viewHome', GiftBoxAuth::ACCESS_LEVEL_NONE);

$router->addRoute('login','/login/','\myGiftApp\control\GiftBoxController',
    'viewLogin',GiftBoxAuth::ACCESS_LEVEL_NONE);

$router->setDefaultRoute('/home/');

$router->run();


