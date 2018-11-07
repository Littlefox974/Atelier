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

class myGiftAppView extends AbstractView{

    /* Constructeur
        *
        * Appelle le constructeur de la classe parent
        */
    public function __construct( $data ){
        parent::__construct($data);
    }

    /* Méthode renderHeader
     *
     *  Retourne le fragment HTML de l'entête (unique pour toutes les vues)
     */
    private function renderHeader(){
        return '<h1>My Gift App</h1>';
    }

    /* Méthode renderFooter
     *
     * Retourne le fragment HTML du bas de la page (unique pour toutes les vues)
     */
    private function renderFooter(){
        return '';
    }

    /* Méthode renderHome
     *
     * Vue de la fonctionalité afficher tous les users.
     *
     */
// <p> $prest->descr</p>
    private function renderHome(){
        $httpReq = new HttpRequest();

        /*
         * Retourne le fragment HTML qui affiche tous les prestations.
         *
         * L'attribut $this->data contient un tableau d'objets prestation.
         *
         */
        $html = "";
        foreach($this->data as $prest) {

            $html .= "<div>
                       <div class='prestation'>
                       <img src=\"html/img/$prest->img\">
                       <h3>$prest->nom</h3>
                       <p> $prest->prix</p>
                       <button>Ajouter</button>
                       </div>
                       </div></div>
                     ";

        }

        return $html;
    }

    /* Méthode renderUeserTweets
     *
     * Vue de la fonctionalité afficher tout les Tweets d'un utilisateur donné.
     *
     */

    private function renderUser(){

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

    private function renderView(){

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
    protected function renderPostPrestation(){

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

    protected function renderBody($selector=null){

        /*
         * voire la classe AbstractView
         *
         */



        $header = $this->renderHeader();
        $footer = $this->renderFooter();

        switch($selector)
        {
            case "home":
                $main = $this->renderHome();
                break;

            case "login":
                $main = $this->renderLogin();
                break;

            case "signUp":
                $main = $this->renderSignUp();
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

    private function renderLogin(){
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

    private function renderSignUp(){
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
}