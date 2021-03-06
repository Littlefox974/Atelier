<?php
/**
 * Created by PhpStorm.
 * User: jalil
 * Date: 11/6/18
 * Time: 11:30 AM
 */

namespace myGiftApp\control;

use Carbon\Carbon;
use mf\control\AbstractController;
use mf\router\Router;
use myGiftApp\model\Body;
use myGiftApp\model\Cart;
use myGiftApp\model\CartTemp;
use myGiftApp\model\Order;
use myGiftApp\model\Prestation;
use myGiftApp\model\User;
use myGiftApp\view\myGiftAppView;

class GiftBoxController extends AbstractController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function viewHome(){
        if (isset($_POST['idCat'])) {
            if ($_POST['idCat'] == 5)
                $prestations = Prestation::all();
            else if ($_POST['idCat'] == 6)
                $prestations = Prestation::orderBy('prix', 'ASC')->get();
            else if ($_POST['idCat'] == 7)
                $prestations = Prestation::orderBy('prix', 'DESC')->get();
            else
                $prestations = Prestation::all()->where('cat_id', '=', $_POST['idCat']);
        } else {
            $prestations = Prestation::all();
        }
        $view = new myGiftAppView($prestations);
        $view->render('home');
    }

    public function viewCart()
    {
        $profileId = User::query()->select(['id'])->where('username', '=', $_SESSION['user_login'])->get();
        $id = $profileId[0]->id;

        $cart = CartTemp::query()->select(['*'])->where('idUser', '=', $id)->get();

        $view = new myGiftAppView($cart);
        $view->render('cart');
    }

    public function viewProfile()
    {
        $profileId = User::query()->select(['id'])->where('username', '=', $_SESSION['user_login'])->get();
        $id = $profileId[0]->id;

        $orders = Order::query()->
        join('MGB_cart', 'MGB_order.idCart', '=', 'MGB_cart.id')->
        join('MGB_body', 'MGB_cart.id', '=', 'MGB_body.idCart')->
        join('MGB_prestation', 'MGB_body.idPrestation', '=', 'MGB_prestation.id')->
        select(['MGB_order.id as orderId','MGB_prestation.img as presImg','MGB_prestation.nom as presName','MGB_prestation.descr as presDescr','MGB_order.state as orderState'])->
        where('idUser','=',$id)->
        get();
        $view = new myGiftAppView($orders);
        $view->render('profile');
    }

    public function addToCart()
    {
        $profileId = User::query()->select(['id'])->where('username', '=', $_SESSION['user_login'])->get();

        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            //$item Item de l'user
            $item = CartTemp::query()->select(['*'])->where('item', '=', $id)
                ->where('idUser', '=', $profileId[0]->id)->get();

                $quantity = $item[0]->quantity;

//            echo "Before if: quantity: " . $quantity;
            if ($quantity >= 1) {
//                var_dump($item[0]->quantity);
                $item[0]->quantity = $item[0]->quantity + 1;
                $item[0]->save();
                unset($_SESSION['id']);
            } else {
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
        $id = isset($_GET['idItem']) ? $_GET['idItem'] : "";
        $prestation = Prestation::query()->select(['*'])->where('id', '=', $id)->get();
        $view = new myGiftAppView($prestation[0]);
        $view->render('item');
    }

    public function viewPay()
    {
        $profileId = User::query()->select(['id'])->where('username', '=', $_SESSION['user_login'])->get();
        $cartTemp = CartTemp::all()->where('idUser', '=', $profileId[0]->id);

        unset($_SESSION['total']);
        $_SESSION['total'] = 0;
        foreach ($cartTemp as $item) {
            $prestation = Prestation::query()->select(['*'])->where('id', '=', $item->item)->get();
            $price = $prestation[0]->prix;
            $_SESSION['total'] += $price * $item->quantity;
        }
        //validation
        $noItem = 0;
        $cat[] = array();
        foreach ($cartTemp as $item) {
            $prestation = Prestation::query()->select(['*'])->where('id', '=', $item->item)->get();
            $cat[] = $prestation[0]->cat_id;
            $noItem++;
        }
        $ar = array_replace($cat,array_fill_keys(array_keys($cat, null),''));
        $uniqueCat = array_count_values($ar);
        $noCat = count($uniqueCat);
        if ($noItem >= 2 && $noCat >= 2) {
            $view = new myGiftAppView($_SESSION['total']);
            $view->render('pay');
        } else {
            echo "Vous avez besoin d'ajouter 2 prestations de 2 categories differentes au moins";
            $this->viewCart();
        }


    }

    public function payOrder()
    {
        $profileId = User::query()->select(['id'])->where('username', '=', $_SESSION['user_login'])->get();
        $cartTemp = CartTemp::all()->where('idUser', '=', $profileId[0]->id);
        $cart = new Cart();


        if (isset($_POST['dateDisponible'])) {
            $date = Carbon::parse($_POST['dateDisponible']);
            $cart->dateDisponible = $date->format('Y-m-d');
        } else
            $cart->dateDisponible = date("Y-m-d");

        $cart->dateCreation = date("Y-m-d");;
        $cart->save();

        $lastCartId = $cart->id;

        foreach ($cartTemp as $items) {
            $body = new Body();
            $body->idPrestation = $items->item;
            $body->idCart = $lastCartId;
            $body->quantity = $items->quantity;
            $body->save();
        }

        $cart->total = $_SESSION['total'];
        $cart->save();

        $_SESSION['newUrl'] = $this->createUrl($profileId[0]->id, $lastCartId);
        $this->viewUrl();

        CartTemp::where('idUser', '=', $profileId[0]->id)->delete();


    }

    public function viewUrl()
    {
        $view = new myGiftAppView($this);
        $view->render('viewUrl');
    }

    public function viewGift(){

        if (isset($_GET['giftId'])) {
            $orderUrl = Order::query()->select(['*'])->where('id', '=', $_GET['giftId'])->get();

            if ($orderUrl[0]->state != 3) { //not open
                $view = new myGiftAppView($orderUrl[0]);
                $view->render('openGift');
            } else { //if opened

                $order = Order::query()->
                join('MGB_cart', 'MGB_order.idCart', '=', 'MGB_cart.id')->
                join('MGB_body', 'MGB_cart.id', '=', 'MGB_body.idCart')->
                join('MGB_prestation', 'MGB_body.idPrestation', '=', 'MGB_prestation.id')->
                select(['MGB_prestation.img', 'MGB_prestation.nom', 'MGB_prestation.descr', 'MGB_prestation.cat_id', 'MGB_prestation.id'])->
                where('MGB_order.id', '=', $_GET['giftId'])->get();

                $view = new myGiftAppView($order);
                $view->render('viewGift');
            }
        }
    }

    public function openGift()
    {
        if (isset($_GET['giftId'])) {
            $orderState = Order::query()->select(['*'])->where('id', '=', $_GET['giftId'])->get();
            $orderState[0]->id = $_GET['giftId'];
            $orderState[0]->state = 3;
            $orderState[0]->save();
            $this->viewGift();
//            unset($_GET['giftId']);
        } else {
            $this->viewGift();
        }
    }

    public function createUrl($idUser, $idCart)
    {
        $bytes = random_bytes(32);
        $bytesString = bin2hex($bytes);

        $order = new Order();
        $order->id = $bytesString;
        $order->idUser = $idUser;
        $order->idCart = $idCart;
        $order->state = 1;
        $order->save();

        return $bytesString;
    }

    public function increaseQty()
    {
        $profileId = User::query()->select(['id'])->where('username', '=', $_SESSION['user_login'])->get();

        if (isset($_POST['idAdd'])) {
            $id = $_POST['idAdd'];
            $item = CartTemp::query()->select(['*'])->where('item', '=', $id)
                ->where('idUser', '=', $profileId[0]->id)->get();

            $item[0]->quantity += 1;
            $item[0]->save();
        }

        $this->viewCart();

    }

    public function decreaseQty()
    {
        $profileId = User::query()->select(['id'])->where('username', '=', $_SESSION['user_login'])->get();

        if (isset($_POST['idRemove'])) {
            $id = $_POST['idRemove'];
            $item = CartTemp::query()->select(['*'])->where('item', '=', $id)
                ->where('idUser', '=', $profileId[0]->id)->get();
            $quantity = $item[0]->quantity;


            if (($quantity - 1) <= 0) {
                CartTemp::query()->where('item', '=', $id)->delete();
            } else {
                $item[0]->quantity -= 1;
                $item[0]->save();
            }
        }
        $this->viewCart();

    }

}