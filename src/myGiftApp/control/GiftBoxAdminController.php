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

class GiftBoxAdminController extends AbstractController{

    public function __construct(){
        parent::__construct();
    }

    public function login(){

        $view = new myGiftAppView($this);
        $view->render('login');

    }
    public function checkLogin(){
        $username = $_POST['formName'];
        $password = $_POST['formPass'];

        $tweetAuth = new GiftBoxAuth();
        if ($tweetAuth->loginUser($username,$password)){

        }else{
            self::login();
        }
    }

    public function logOut(){
        $tweetAuth = new GiftBoxAuth();
        $tweetAuth->logout();
        self::login();
    }

    public function signUp(){
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
        $tweetAuth = new GiftBoxAuth();

        if ($password === $password2)
            $tweetAuth->createUser($username,$password,$name,$lastName,$email);
        else
            self::signUp();
    }


}