<?php
/**
 * Created by PhpStorm.
 * User: monte
 * Date: 06/11/2018
 * Time: 09:05
 */
namespace myGiftApp\view;

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

    private function renderHome(){



        /*
         * Retourne le fragment HTML qui affiche tous les prestations.
         *
         * L'attribut $this->data contient un tableau d'objets prestation.
         *
         */
        $html = "<ul>";
        $router = new \mf\router\Router();
        foreach($this->data as $prest)
        {

            $html .= "<h1>$prest->nom</h1>
                      <p> $prest->descr</p>

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

        $res = "<div>";
        foreach ($this->data as $tweet){
            $res .=
                "Texte: $tweet->text <br>"
                ."Autheur: ".$tweet->author()->first()->fullname ."<br>"
                . "Date de Création : $tweet->created_at <br>";
        }

        $res .= "</div>";
        return $res;

    }

    /* Méthode renderViewTweet
     *
     * Rréalise la vue de la fonctionnalité affichage d'un tweet
     *
     */

    private function renderView(){

        /*
         * Retourne le fragment HTML qui réalise l'affichage d'un tweet
         * en particulié
         *
         * L'attribut $this->data contient un objet Tweet
         *
         */
        $html= "<div><PRE>";
        $html .= "Text :".$this->data->text;
        $html.="Auteur:".$this->data->author()->first()->fullname;
        $html.="Date de création".$this->data->created_at;
        $html .= "</PRE></div>";
        return $html;

    }



    /* Méthode renderPostTweet
     *
     * Realise la vue de régider un Tweet
     *
     */
    protected function renderPostTweet(){

        /* Méthode renderPostTweet
         *
         * Retourne la framgment HTML qui dessine un formulaire pour la rédaction
         * d'un tweet, l'action du formulaire est la route "send"
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
            case "RenderOnePrestation":
                $main = $this->renderViewTweet();
                break;

            case "RenderUser":
                $main = $this->renderUserTweets();
                break;

            case "RenderHome":
                $main = $this->renderHome();
                break;

            case "login":
                $main = $this->renderLogin();
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
            return "
            <div>
                <form action=\"\" method=\"post\">
                    <label for=\"uname\"><b>Username</b></label>
                    <input type=\"text\" placeholder=\"Enter Username\" name=\"userName\" required>
                
                    <label for=\"psw\"><b>Password</b></label>
                    <input type=\"password\" placeholder=\"Enter Password\" name=\"password\" required>
                
                    <button type=\"submit\">Login</button>
                </form>
            </div>
        ";

    }
}