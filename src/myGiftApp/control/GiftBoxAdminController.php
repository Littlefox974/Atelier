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
use myGiftApp\auth\GiftBoxAuth;
use myGiftApp\model\Prestation;
use myGiftApp\model\User;
use myGiftApp\view\myGiftAppView;

class GiftBoxAdminController extends AbstractController{

    public function __construct(){
        parent::__construct();
    }

    public function viewLogin(){

        $view = new myGiftAppView($this);
        $view->render('login');

    }
    public function checkLogin(){
        $username = $_POST['userName'];
        $password = $_POST['password'];

        $giftBoxAuth = new GiftBoxAuth();
        if ($giftBoxAuth->loginUser($username,$password)){
            echo "logged in";
        }else{
            echo "nope";
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
        $email = $_POST['username'];
        $username = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $giftBoxAuth = new GiftBoxAuth();

        $user = User::query()->select(['*'])->where('username','=',$username)->get()->first();
        if (($password === $password2) && !is_null($user)){
            $giftBoxAuth->createUser($username,$password,$name,$lastName,$email);
            $prestations = Prestation::all();
            $view = new myGiftAppView($prestations);
            $view->render('home');
        }
        else
            self::viewSignUp();
    }


}