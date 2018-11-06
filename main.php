<?php
/**
 * Created by PhpStorm.
 * User: jalil
 * Date: 11/5/18
 * Time: 5:03 PM
 */

require_once 'src/myGiftApp/model/User.php';

$config = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'fierrolo1u',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''];

$db = new Illuminate\Database\Capsule\Manager();

$db->addConnection($config); /* configuration avec nos paramètres */
$db->setAsGlobal(); /* visible de tout fichier */
$db->bootEloquent(); /* établir la connexion */

$requete = \myGiftApp\model\User::select();  /* SQL : select * from 'ville' */
$lignes = $requete->get();   /* exécution de la requête et plusieurs lignes résultat */

foreach ($lignes as $v)      /* $v est une instance de la classe Ville */
       echo "Identifiant = $v->id, Nom = $v->nom\n" ;