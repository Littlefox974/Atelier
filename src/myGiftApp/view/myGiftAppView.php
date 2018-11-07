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
    private function renderHeader(){
        $router = new Router();
        $httpReq = new HttpRequest();
        $routeCart = $router->urlFor('cart');
        return "<h1>My Gift App</h1>
                <a href='$routeCart'>  <img src=\"$httpReq->root"."html/img/cart.svg\"></a>
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

    private function renderHome(){
        /*
         * Retourne le fragment HTML qui affiche tous les prestations.
         *
         * L'attribut $this->data contient un tableau d'objets prestation.
         *
         */

        $httpReq = new HttpRequest();
        $router = new Router();

        $html = "";
        foreach($this->data as $prest) {
            $addToCart = $router->urlFor('addToCart',[['id',$prest->id]]);

            $html .= "<h1>$prest->nom</h1>
                       <div>
                       <img src=\"$httpReq->root"."html/img/$prest->img\">
                        <p> $prest->descr</p>
                        <p> $prest->prix</p>
                       </div>
                       <form action='$addToCart' method='get'>
                            <button type='submit'>Ajouter</button>
                       </form>
                       
                     ";

        }

        return $html;
    }

    /* Méthode renderUeserTweets
     *
     * Vue de la fonctionalité afficher tout les Tweets d'un utilisateur donné.
     *
     */

    private function renderUser()
    {

        /*
         * Retourne le fragment HTML pour afficher
         * tous les Tweets d'un utilisateur donné.
         *
         * L'attribut $this->data contient un objet User.
         *
         */


    }

    /* Méthode renderViewTweet
     *
     * Rréalise la vue de la fonctionnalité affichage d'un tweet
     *
     */

    private function renderView()
    {

        /*
         * Retourne le fragment HTML qui réalise l'affichage d'une prestation
         * en particulié
         *
         * L'attribut $this->data contient un objet Prestation
         *
         */


    }


    /* Méthode renderPostTweet
     *
     * Realise la vue de régider un Tweet
     *
     */
    protected function renderPostPrestation()
    {

        /* Méthode renderPostPrestation
         *
         * Retourne la framgment HTML qui dessine un formulaire pour la rédaction
         * d'une prestation, l'action du formulaire est la route "send"
         *
         */

    }


    /* Méthode renderBody
     *
     * Retourne la framgment HTML de la balise <body> elle est appelée
     * par la méthode héritée render.
     *
     */

    protected function renderBody($selector = null)
    {

        /*
         * voire la classe AbstractView
         *
         */


        $header = $this->renderHeader();
        $footer = $this->renderFooter();

        switch ($selector) {
            case "home":
                $main = $this->renderHome();
                break;

            case "login":
                $main = $this->renderLogin();
                break;

            case "signUp":
                $main = $this->renderSignUp();
                break;

            case "item":
                $main = $this->renderItem();
                break;

            case "cart":
                $main = $this->renderCart();
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

    private function renderLogin()
    {
        $router = new Router();
        $routeVerify = $router->urlFor('loginVerify');

        return "
            <div>
                <form action=\"$routeVerify\" method=\"post\">
                    <label for=\"uname\"><b>Username</b></label>
                    <input type=\"text\" placeholder=\"Username\" name=\"userName\" required>
                
                    <label for=\"psw\"><b>Mot de passe</b></label>
                    <input type=\"password\" placeholder=\"Mot de passe\" name=\"password\" required>
                    
                    <button type=\"submit\">Submit</button>
                </form>
            </div>
        ";

    }

    private function renderSignUp()
    {
        $router = new Router();
        $routeVerify = $router->urlFor('signUpVerify');
        return "
            <div>
                <form action=\"$routeVerify\" method=\"post\">
                    <label for=\"nom\"><b>Nom</b></label>
                    <input type=\"text\" placeholder=\"Nom\" name=\"name\" required>
                    
                    <label for=\"prenom\"><b>Prenom</b></label>
                    <input type=\"text\" placeholder=\"Prenom\" name=\"lastName\" required>
                
                    <label for=\"username\"><b>Username</b></label>
                    <input type=\"text\" placeholder=\"Enter Username\" name=\"username\" required>
                    
                    <label for=\"email\"><b>Email</b></label>
                    <input type=\"email\" placeholder=\"Enter e-mail\" name=\"email\" required>
                
                    <label for=\"psw\"><b>Mot de passe</b></label>
                    <input type=\"password\" placeholder=\"Enter Password\" name=\"password\" required>
                    
                    <label for=\"psw2\"><b>Confirmer mot de passe</b></label>
                    <input type=\"password\" placeholder=\"Retype Password\" name=\"password2\" required>
                
                    <button type=\"submit\">Creer</button>
                </form>
            </div>
        ";

    }

    private function renderItem(){
        $httpReq = new HttpRequest();
        return "
            <div>
                <h1>$this->data->nom</h1>
                <div>
                       <img src=\"$httpReq->root"."html/img/$this->data->img\">
                        <p> $this->data->descr</p>
                        <p> $this->data->prix</p>
                </div>
            </div>
        
        ";
    }

    private function renderCart(){

        $html = "";
        $total = 0;
        $httpReq = new HttpRequest();

        foreach($this->data as $prest) {

            $html .= "<h1>$prest->nom</h1>
                       <div>
                       <img src=\"$httpReq->root"."html/img/$prest->img\">
                        <p> $prest->descr</p>
                        <p> $prest->prix</p>
                       </div>
                       
                     ";
            $total += $prest->prix;
        }
        $html .= "<button>Payer $total</button>";

        return $html;
    }
}