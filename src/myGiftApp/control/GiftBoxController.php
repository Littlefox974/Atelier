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
use myGiftApp\model\CartTemp;
use myGiftApp\model\Order;
use myGiftApp\model\Prestation;
use myGiftApp\model\User;
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

    public function viewPay(){
        $view = new myGiftAppView();
        $view->render('payScreen');
    }
    public function payOrder()
    {
            $profileId = User::query()->select(['id'])->where('username', '=', $_SESSION['user_login'])->get();
            $cartTemp = CartTemp::all()->where('idUser', '=', $profileId[0]->id);
            foreach ($cartTemp as $items){
                $cart = new Cart();
                $cart->dateCreation = 'getDate()';
                $cart->dateDisponible = '';
                $cart->total = $_SESSION['total'];
            }

    }

    public function viewUrl()
    {

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

    public function increaseQty(){
        if (isset($_POST['idAdd'])){
            $id = $_POST['idAdd'];
            $cart = CartTemp::query()->select(['quantity'])->where('item','=',$id)->get();

            echo "ID: " . $id . " QUANTITY: " . $cart[0]->quantity;
            CartTemp::query()->where('item','=',$id)->update(['quantity' => $cart[0]->quantity + 1]);
        }
//        $this->viewCart();
//        self::viewCart();

    }

    public function decreaseQty(){
        if (isset($_POST['idRemove'])){
            $id = $_POST['idRemove'];
            $cart = CartTemp::query()->select(['quantity'])->where('item','=',$id)->get();
            if (($cart->quantity - 1) <= 0)
                CartTemp::query()->where('item','=',$id)->delete();
            else
                CartTemp::query()->where('item','=',$id)->update(['quantity' => $cart[0]->quantity - 1]);
        }
//        $this->viewCart();
//        self::viewCart();
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