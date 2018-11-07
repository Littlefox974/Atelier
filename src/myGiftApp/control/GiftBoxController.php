<?php
/**
 * Created by PhpStorm.
 * User: jalil
 * Date: 11/6/18
 * Time: 11:30 AM
 */

namespace myGiftApp\control;

use mf\control\AbstractController;
use myGiftApp\model\Order;
use myGiftApp\model\Prestation;
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
        $view = new myGiftAppView($needToAdd);
        $view->render('cart');
    }

    public function addToCart(){
        $id = isset($_GET['id']) ? $_GET['id'] : "";

        $item = Prestation::query()->select(['*'])->where('id','=',$id)->get();

        if (empty($cartItem)){
            $cartItem[] = array();
            $cartItem[] = $item;
        }else{
            $cartItem[] = $item;
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