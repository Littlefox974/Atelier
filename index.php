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

require_once 'vendor/autoload.php';

$config = parse_ini_file('conf/config.ini');

//$loader = new ClassLoader();
//$loader -> register();

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

$router->addRoute('increaseQty','/increaseQty/','\myGiftApp\control\GiftBoxController',
    'increaseQty',GiftBoxAuth::ACCESS_LEVEL_USER);

$router->addRoute('decreaseQty','/decreaseQty/','\myGiftApp\control\GiftBoxController',
    'decreaseQty',GiftBoxAuth::ACCESS_LEVEL_USER);

$router->addRoute('profile','/profile/','\myGiftApp\control\GiftBoxController',
    'viewProfile',GiftBoxAuth::ACCESS_LEVEL_USER);

$router->addRoute('pay','/pay/','\myGiftApp\control\GiftBoxController',
    'viewPay',GiftBoxAuth::ACCESS_LEVEL_USER);

$router->addRoute('payOrder','/payOrder/','\myGiftApp\control\GiftBoxController',
    'payOrder',GiftBoxAuth::ACCESS_LEVEL_USER);

$router->addRoute('viewUrl','/viewUrl/','\myGiftApp\control\GiftBoxController',
    'viewUrl',GiftBoxAuth::ACCESS_LEVEL_USER);

$router->setDefaultRoute('/login/');

$router->run();

