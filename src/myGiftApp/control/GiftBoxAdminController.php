<?php
/**
 * Created by PhpStorm.
 * User: jalil
 * Date: 11/6/18
 * Time: 9:10 AM
 */
namespace myGiftApp\control;

use mf\control\AbstractController;
use mf\router\Router;
use mf\utils\HttpRequest;
use myGiftApp\auth\GiftBoxAuth;
use myGiftApp\model\Prestation;
use myGiftApp\model\User;
use myGiftApp\view\myGiftAppView;

class GiftBoxAdminController extends AbstractController{

    public function __construct(){
        parent::__construct();
    }

    public function viewLogin(){

        if (isset($_SESSION['user_login'])){
            $router = new Router();
            $router->executeRoute('/home/');
        }else {
            $view = new myGiftAppView($this);
            $view->render('login');
        }

    }
    public function checkLogin(){
        $username = $_POST['userName'];
        $password = $_POST['password'];

        $giftBoxAuth = new GiftBoxAuth();
        if ($giftBoxAuth->loginUser($username,$password)){
            $router = new Router();
            $router->executeRoute('/home/');
        }else{
            self::viewLogin();
        }
    }

    public function logOut(){
        $giftBoxAuth = new GiftBoxAuth();
        $giftBoxAuth->logout();
        self::viewLogin();
    }

    public function viewSignUp(){
        $view = new myGiftAppView($this);
        $view->render('signUp');
    }
    public function checkSignUp(){

        $name = $_POST['name'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $giftBoxAuth = new GiftBoxAuth();
        $router = new Router();

        $DBusername= User::query()->select(['username'])->where('username','=',$username)->get();

        if (($password === $password2) && $username !== $DBusername[0]->username){
            $giftBoxAuth->createUser($username,$password,$name,$lastName,$email);
            $router->executeRoute('/home/');

        }
        else{
            $router->executeRoute('/signUp/');
        }
    }


}