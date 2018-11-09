<?php
/**
 * Created by PhpStorm.
 * User: monte
 * Date: 06/11/2018
 * Time: 09:05
 */

namespace myGiftApp\view;

use mf\router\Router;
use mf\utils\HttpRequest;
use mf\view\AbstractView;
use myGiftApp\model\Prestation;

class myGiftAppView extends AbstractView
{

    /* Constructeur
        *
        * Appelle le constructeur de la classe parent
        */
    public function __construct($data)
    {
        parent::__construct($data);
    }

    /* Méthode renderHeader
     *
     *  Retourne le fragment HTML de l'entête (unique pour toutes les vues)
     */
    private function renderHeader()
    {
        $router = new Router();
        $httpReq = new HttpRequest();
        $routeCart = $router->urlFor('cart');
        $routeProfile = $router->urlFor('profile');
        $routeHome = $router->urlFor('home');


        return "<div class='headercatalogue'>
                    <h3>Prestations</h3>
                    <a href='$routeHome'> <img src=\"$httpReq->root"."/html/img/home.svg\"> </a>
                    <a href='$routeProfile'> <img src=\"$httpReq->root"."/html/img/profile.svg\"> </a>
                    <a href='$routeCart'><img src=\"$httpReq->root"."/html/img/cart.svg\"></a>
                    <!--<input>
                    <button>
                        <img src=\"$httpReq->root" . "/html/img/blob.png\">
                    </button>-->
                </div>
                ";
    }

    private function renderHeaderLogin()
    {
        $router = new Router();
        $httpReq = new HttpRequest();
        $routeCart = $router->urlFor('cart');
        return "<div class='headerlogin'>
                    
                </div>
                ";
    }

    /* Méthode renderFooter
     *
     * Retourne le fragment HTML du bas de la page (unique pour toutes les vues)
     */
    private function renderFooter()
    {
        return '';
    }



    /* Méthode renderHome
     *
     * Vue de la fonctionalité afficher tous les users.
     *
     */
    private function renderHome()
    {
        /*
         * Retourne le fragment HTML qui affiche tous les prestations.
         *
         * L'attribut $this->data contient un tableau d'objets prestation.
         *
         */

        $httpReq = new HttpRequest();
        $router = new Router();

        $html = "";
        foreach ($this->data as $prest) {
            $addToCart = $router->urlFor('addToCart');
            $html .= "<div class='prestation'>
                        <img src=\"$httpReq->root" . "/html/img/$prest->img\">
                        <h3>$prest->nom</h3>
                        <p> $prest->prix</p>
                        <form action='$addToCart' method='post'>
                            <button type='submit' name='id' value=\"$prest->id\">Ajouter</button>                       
                        </form>
                      </div>";
        }

        return $html;
    }


    private function renderLogin(){
        $router = new Router();
        $routeVerify = $router->urlFor('loginVerify');
        $routeSignUp = $router->urlFor('signUp');
        $httpReq = new HttpRequest();
        return "
            <div class='login'>
                <img src=\"$httpReq->root" . "/html/img/user.png\">
                <form action=\"$routeVerify\" method=\"post\">
                    <div>
                        <input type=\"text\" placeholder=\"Username\" name=\"userName\" required>
                    </div>  
                    <div>
                        <input type=\"password\" placeholder=\"Mot de passe\" name=\"password\" required>
                    </div>
                    <button type=\"submit\"> LogIn</button>
                    <a href='#'>Forgot password?</a>
                    <a href='$routeSignUp'>Sign Up</a>
                </form>
            </div>
            <div class='loginMsg'>A BOX FULL OF SURPRISES!</div>
        ";

    }

    private function renderSignUp()
    {
        $router = new Router();
        $routeVerify = $router->urlFor('signUpVerify');
        $httpReq = new HttpRequest();
        return "
            <div class='signUp'>
                 <img src=\"$httpReq->root" . "/html/img/user.png\">
                <form action=\"$routeVerify\" method=\"post\">
                    <div>
                        <label for=\"nom\"><b>Nom</b></label>
                    </div>
                    <div>
                        <input type=\"text\" placeholder=\"Nom\" name=\"name\" required>
                    </div>
                    <div>
                        <label for=\"prenom\"><b>Prenom</b></label>
                    </div>
                    <div>
                         <input type=\"text\" placeholder=\"Prenom\" name=\"lastName\" required>
                    </div>
                    <div>
                         <label for=\"username\"><b>Username</b></label>
                    </div>
                    <div>
                         <input type=\"text\" placeholder=\"Enter Username\" name=\"username\" required>
                    </div>
                    <div>
                         <label for=\"email\"><b>Email</b></label>
                    </div>
                    <div>
                        <input type=\"email\" placeholder=\"Enter e-mail\" name=\"email\" required>
                    </div>
                    <div>
                        <label for=\"psw\"><b>Mot de passe</b></label>
                    </div>
                    <div>
                         <input type=\"password\" placeholder=\"Enter Password\" name=\"password\" required>
                    </div>
                    <div>
                        <label for=\"psw2\"><b>Confirmer mot de passe</b></label>
                    </div>
                    <div>
                        <input type=\"password\" placeholder=\"Retype Password\" name=\"password2\" required>
                    </div>

                    <button type=\"submit\">Creer</button>
                </form>
            </div>
        ";

    }

    private function renderItem()
    {
        $httpReq = new HttpRequest();
        return "
            <div>
                <h1>$this->data->nom</h1>
                <div>
                       <img src=\"$httpReq->root" . "/html/img/$this->data->img\" alt=\"$this->data->img\">
                        <p> $this->data->descr</p>
                        <p> $this->data->prix</p>
                </div>
            </div>
        
        ";
    }

    

    private function renderCart()
    {

        $html = "";
        $httpReq = new HttpRequest();
        $router = new Router();
        $routeAdd = $router->urlFor('increaseQty');
        $routeRemove = $router->urlFor('decreaseQty');
        $routePay = $router->urlFor('pay');

        foreach ($this->data as $cart) {
            $prest = Prestation::query()->select(['*'])->where('id','=',$cart->item)->get();
            $p = $prest[0];
            $html .= "
                       <div class='item-cart'>
                            <h1>$p->nom</h1>
                            <img src=\"$httpReq->root" . "/html/img/$p->img\">
                            <p>$p->descr</p>
                            <p>$p->prix</p>
                            <p>$cart->quantity</p>
                            <form action='$routeAdd' method='post'>
                                <button type='submit' name='idAdd' value=\"$cart->item\"><img src=\"$httpReq->root"."/html/img/add.svg\"></button>                       
                            </form>
                            <form action='$routeRemove' method='post'>
                                <button type='submit' name='idRemove' value=\"$cart->item\"><img src=\"$httpReq->root"."/html/img/remove.svg\"></button>                       
                            </form>
                       </div>
                     ";
        }

        $html .= "<form action='$routePay' method='post'>
                                <button >
                                    Payer 
                                </button>                       
                            </form>";

        return $html;
    }

    private function renderPay(){
        $router = new Router();
        $payOrder = $router->urlFor('payOrder');
        $html="
<div>
<form action=\"$payOrder\" method=\"post\">
    <!--<input type=\"text\" placeholder=\"Nom du titulaire de la carte\" name=\"titulaire\">
    <input type=\"text\" placeholder=\"Numéro de la carte\" name=\"numeroCarte\" >
    <input type=\"text\" placeholder=\"Jour d'expiration\" name=\"jourExp\" >
    <input type=\"text\" placeholder=\"Mois d'expiration\" name=\"moisExp\" >
    <input type=\"text\" placeholder=\"Cryptogramme visuel\" name=\"cryptVis\" >-->
    <label>Date</label>
    <input id=\"dateDisponible\" type=\"date\" name=\"dateDisponible\">
    <button type='submit'>Payer $this->data</button>
    </form>        
</div>
        ";
        return $html;
    }

    private function renderProfile()
    {
        $router = new Router();
        $routeProfile = $router->executeRoute("");

        $html= "<div>";
        $html .= "User name :". $_SESSION['user_login'];

        foreach ($this->data as $orders) {
            $url = "http://$_SERVER[HTTP_HOST]/www/fierrolo1u/index.php/openGift/?giftId=" . $orders->id;
            $html .= "<input value=\"$url\">";
            $html .= "<button id=\"copy\">Copier</button>";
        }

        $html .= "</div>
        <script>
        function copy() {
          var copyText = document.querySelector(\"#input\");
          copyText.select();
          document.execCommand(\"copy\");
        }
        document.querySelector(\"#copy\").addEventListener(\"click\", copy);
        </script>
        ";

        return $html;
    }

    private function renderUrl()
    {
        $url = "http://$_SERVER[HTTP_HOST]/www/condemag1u/index.php/openGift/?giftId=" . $_SESSION['newUrl'];
        $html = "
<div>
    <img>
    <input type='text' value=\"$url\" disabled='true'>
    <button>Copier URL</button>       
</div>
        ";

        return $html;
    }

    private function renderOpenGift()
    {
        $html="";
    }

    private function renderViewGift()
    {
        $html="";
    }

    protected function renderBody($selector = null)
    {
        $header = $this->renderHeader();
        $footer = $this->renderFooter();

        switch ($selector) {
            case "home":
                $main = $this->renderHome();
                break;

            case "login":
                $main = $this->renderLogin();
                $header = $this->renderHeaderLogin();
                break;

            case "signUp":
                $main = $this->renderSignUp();
                $header = $this->renderHeaderLogin();
                break;

            case "item":
                $main = $this->renderItem();
                break;

            case "cart":
                $main = $this->renderCart();
                break;

            case "profile":
                $main = $this->renderProfile();
                break;

            case "pay":
                $main = $this->renderPay();
                break;

            case "viewUrl";
                $main = $this->renderUrl();
                break;

            case "openGift";
                $main = $this->renderOpenGift();
                break;

            case "viewGift";
                $main = $this->renderViewGift();
                break;

            default:
                $main = $this->renderHome();
                break;

        }


        $html = <<<EOT
<header>
${header}
</header>
<section>
${main}
</section>
<fotter>
${footer}
</fotter>
EOT;

        return $html;
    }




}