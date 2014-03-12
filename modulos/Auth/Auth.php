<?php
/**
 *
 */
include_once __DIR__."AuthCommon.php";
include_once __DIR__."/../../Models/User/UserModel.php";

class Auth implements AuthInterface {
    protected $login = null;
    protected $token_auth = null;

    public function __construct($user, $pass){
        $model = new UserModel();
        $login = $model->getForUser("'$user'");
        $hash = $user["pass"];
        if(password_verify($pass, $hash)){
            $this->login = $this->setLogin($login);
        }
    }

    public function getName(){}

    public function initSession($login, $password){}

    public function authenticated(){}

    public function setLogin($login){
        $forhash = "crypt".$login["user"]."forlogin";
        $hashlogin = password_hash($forhash, PASSWORD_BCRYPT);
        return $hashlogin;
    }

    public function setTokenAuth($token_auth){}
} 