<?php
/**
 * Created by PhpStorm.
 * User: jalil
 * Date: 11/6/18
 * Time: 11:30 AM
 */

namespace myGiftApp\control;

use mf\control\AbstractController;
use myGiftApp\model\Cart;
use myGiftApp\model\Order;
use myGiftApp\model\Prestation;
use myGiftApp\model\User;
use myGiftApp\model\CartTemp;
use myGiftApp\view\myGiftAppView;

class GiftBoxController extends AbstractController{

    public function __construct(){
        parent::__construct();
    }


    /* MÃ©thode viewHome :
     *
     * RÃ©alise la fonctionnalitÃ© : afficher la liste de Tweet
     *
     */

    public function viewHome(){

        $prestations = Prestation::all();
        $view = new myGiftAppView($prestations);
        $view->render('home');
    }

    public function viewCart(){
        $profileId = User::query()->select(['id'])->where('username','=',$_SESSION['user_login'])->get();
        $id = $profileId[0]->id;

        $cart = CartTemp::query()->select(['*'])->where('idUser','=',$id)->get();

        $view = new myGiftAppView($cart);
        $view->render('cart');
    }

    public function viewProfile(){
        $profile = User::query()->select(['*'])->where('username','=',$_SESSION['user_login'])->get();

        $view = new myGiftAppView($profile);
        $view->render('profile');
    }

    public function addToCart(){
        if (isset($_POST['id'])){
            $id = $_POST['id'];
            $profileId = User::query()->select(['id'])->where('username','=',$_SESSION['user_login'])->get();
            $cart = new CartTemp();
            $cart->idUser = $profileId[0]->id;
            $cart->item = $id;
            $cart->quantity = 1;

            $cart->save();
        }

        self::viewHome();
    }


    public function viewItem(){
        $id = isset($_GET['id']) ? $_GET['id'] : "";
        $prestation = Prestation::query()->select(['*'])->where('id','=',$id)->get();
        $view = new myGiftAppView($prestation);
        $view->render('item');
    }

    public function createUrl($idUser, $idCart){
        $bytes = random_bytes(32);
        $bytesString = bin2hex($bytes);

        $order = new Order();
        $order->id = $bytesString;
        $order->User = $idUser;
        $order->idCart = $idCart;
        $order->save();

        return $bytesString;
    }


//    public function viewUserTweets(){
//
//        $id = $_GET['id'];
//        $tweets = Tweet::all()->where('author',"=",$id);
//        $view = new TweeterView($tweets);
//        $view->render('userTweets');
//
//    }

}