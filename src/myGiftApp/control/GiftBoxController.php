<?php
/**
 * Created by PhpStorm.
 * User: jalil
 * Date: 11/6/18
 * Time: 11:30 AM
 */

namespace myGiftApp\control;

use mf\control\AbstractController;
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




    /* MÃ©thode viewTweet :
     *
     * RÃ©alise la fonctionnalitÃ© afficher un Tweet
     *
     */
    public function viewTweet(){

        $id = $_GET['id'];
        $tweet = Tweet::query()->select(['*'])->where('id',"=", $id)->get();
        $view = new TweeterView($tweet);
        $view->render('tweet');

    }


    public function viewUserTweets(){

        $id = $_GET['id'];
        $tweets = Tweet::all()->where('author',"=",$id);
        $view = new TweeterView($tweets);
        $view->render('userTweets');

    }

}