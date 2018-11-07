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
use myGiftApp\view\myGiftAppView;

require_once __DIR__ . '/vendor/autoload.php';

$config = parse_ini_file('conf/config.ini');

$loader = new ClassLoader();
$loader -> register();

myGiftAppView::addStyleSheet("html/css/style.css");

$db = new Illuminate\Database\Capsule\Manager();

$db->addConnection( $config ); /* configuration avec nos paramètres */
$db->setAsGlobal();            /* visible de tout fichier */
$db->bootEloquent();           /* établir la connexion */

$router = new Router();
$router->addRoute('home', '/home/', '\myGiftApp\control\GiftBoxController',
    'viewHome', GiftBoxAuth::ACCESS_LEVEL_USER);

$router->addRoute('login','/login/','\myGiftApp\control\GiftBoxAdminController',
    'viewLogin',GiftBoxAuth::ACCESS_LEVEL_NONE);

$router->addRoute('loginVerify','/loginV/','\myGiftApp\control\GiftBoxAdminController',
    'checkLogin',GiftBoxAuth::ACCESS_LEVEL_NONE);

$router->addRoute('logout','/logout/','\myGiftApp\control\GiftBoxAdminController',
    'logOut',GiftBoxAuth::ACCESS_LEVEL_NONE);

$router->addRoute('signUp','/signUp/','\myGiftApp\control\GiftBoxAdminController',
    'viewSignUp',GiftBoxAuth::ACCESS_LEVEL_NONE);

$router->addRoute('signUpVerify','/signUpV/','\myGiftApp\control\GiftBoxAdminController',
    'checkSignUp',GiftBoxAuth::ACCESS_LEVEL_NONE);

$router->addRoute('addToCart','/home/','\myGiftApp\control\GiftBoxController',
    'addToCart',GiftBoxAuth::ACCESS_LEVEL_USER);

$router->addRoute('cart','/cart/','\myGiftApp\control\GiftBoxController',
    'viewCart',GiftBoxAuth::ACCESS_LEVEL_USER);

$router->setDefaultRoute('/home/');

$router->run();

