<?php
/**
 * Created by PhpStorm.
 * User: jalil
 * Date: 11/6/18
 * Time: 9:10 AM
 */
namespace myGiftApp\control;

use mf\control\AbstractController;
use myGiftApp\auth\GiftBoxAuth;
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

        $name = $_POST[''];
        $lastName = $_POST[''];
        $email = $_POST[''];
        $username = $_POST[''];
        $password = $_POST[''];
        $password2 = $_POST[''];
        $giftBoxAuth = new GiftBoxAuth();

        if ($password === $password2)
            $giftBoxAuth->createUser($username,$password,$name,$lastName,$email);
        else
            self::viewSignUp();
    }


}