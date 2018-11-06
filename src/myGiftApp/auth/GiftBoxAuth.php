<?php
namespace myGiftApp\auth;
use mf\auth\Authentification;
use myGiftApp\model\User;

/**
 * Created by PhpStorm.
 * User: jalil
 * Date: 11/6/18
 * Time: 9:11 AM
 */

class GiftBoxAuth extends Authentification {
    const ACCESS_LEVEL_USER  = 0;
    const ACCESS_LEVEL_ADMIN = 1;

    /* constructeur */
    public function __construct(){
        parent::__construct();
    }

    /* La mÃ©thode createUser
     *
     *  Permet la crÃ©ation d'un nouvel utilisateur de l'application
     *
     *
     * @param : $username : le nom d'utilisateur choisi
     * @param : $pass : le mot de passe choisi
     * @param : $fullname : le nom complet
     * @param : $level : le niveaux d'accÃ¨s (par dÃ©faut ACCESS_LEVEL_USER)
     *
     * Algorithme :
     *
     *  Si un utilisateur avec le mÃªme nom d'utilisateur existe dÃ©jÃ  en BD
     *     - soulever une exception
     *  Sinon
     *     - crÃ©er un nouvel modÃ¨le User avec les valeurs en paramÃ¨tre
     *       ATTENTION : Le mot de passe ne doit pas Ãªtre enregistrÃ© en clair.
     *
     */
    public function createUser($username, $pass, $name, $lastname, $email,
                               $level=self::ACCESS_LEVEL_USER) {

        $user = new User;
        $user->username = $username;
        $hashedPass = parent::hashPAssword($pass);
        $user->password = $hashedPass;
        $user->name = $name;
        $user->lastname = $lastname;
        $user->email = $email;
        $user->typeUser = $level;

        $user->save();
    }

    /* La mÃ©thode loginUser
     *
     * permet de connecter un utilisateur qui a fourni son nom d'utilisateur
     * et son mot de passe (depuis un formulaire de connexion)
     *
     * @param : $username : le nom d'utilisateur
     * @param : $password : le mot de passe tapÃ© sur le formulaire
     *
     * Algorithme :
     *
     *  - RÃ©cupÃ©rer l'utilisateur avec l'identifiant $username depuis la BD
     *  - Si aucun de trouvÃ©
     *      - soulever une exception
     *  - sinon
     *      - rÃ©aliser l'authentification et la connexion
     *
     */
    public function loginUser($username, $password){
        try {
            $dbPassword = User::query()->select(["password"])->where("username" ,"=",$username)->get();
            parent::login($username, $dbPassword, $password, self::ACCESS_LEVEL_USER);
            return true;
        } catch (\Exception $e) {
            echo "79: " . $e->getMessage();
        }
        return false;
    }

}