<?php
/**
 * Created by PhpStorm.
 * User: jalil
 * Date: 11/6/18
 * Time: 11:30 AM
 */

namespace myGiftApp\control;

use mf\control\AbstractController;
use mf\router\Router;
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
        $profileId = User::query()->select(['id'])->where('username','=',$_SESSION['user_login'])->get();

        if (isset($_POST['id'])){
            $id = $_POST['id'];

            //$item Item de l'user
            $item = CartTemp::query()->select(['*'])->where('item', '=', $id)
                ->where('idUser','=',$profileId[0]->id)->get();
            $quantity = $item[0]->quantity;
            echo "Before if: quantity: " . $quantity;
            if ($quantity >= 1){
                var_dump($item[0]->quantity);
//                CartTemp::query()->where('item','=',$id)->update(['quantity' => $quantity + 1]);
                $item[0]->quantity = $item[0]->quantity + 1;
                $item[0]->save();
                unset($_SESSION['id']);
            }else{
                $cart = new CartTemp();
                $cart->idUser = $profileId[0]->id;
                $cart->item = $id;
                $cart->quantity = 1;

                $cart->save();
                unset($_SESSION['id']);
            }
        }
        unset($_SESSION['id']);
        $this->viewHome();
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
        $profileId = User::query()->select(['id'])->where('username','=',$_SESSION['user_login'])->get();

        if (isset($_POST['idAdd'])){
            $id = $_POST['idAdd'];
            $item = CartTemp::query()->select(['*'])->where('item', '=', $id)
                ->where('idUser','=',$profileId[0]->id)->get();

            $item[0]->quantity = $item[0]->quantity + 1;
            $item[0]->save();
        }

        $this->viewCart();

    }

    public function decreaseQty(){
        $profileId = User::query()->select(['id'])->where('username','=',$_SESSION['user_login'])->get();

        if (isset($_POST['idRemove'])){
            $id = $_POST['idRemove'];
            $item = CartTemp::query()->select(['*'])->where('item', '=', $id)
                ->where('idUser','=',$profileId[0]->id)->get();
            $quantity = $item[0]->quantity;

            if (($quantity - 1) <= 0)
                CartTemp::query()->where('item','=',$id)->delete();
            else{
                $item[0]->quantity = $item[0]->quantity - 1;
                $item[0]->save();
            }
        }
        $this->viewCart();

    }

}