<?php
/**
 * Interface para crear clases de Autenticación
 */

interface AuthInterface {
    public function getName();

    public function authenticated();

    public function initSession($login, $password);

    public function setTokenAuth($token_auth);

    public function setLogin($login);
}

/**
 * Class AuthResult. Guardará la información de autenticación.
 */
class AuthResult {
    const FAILURE = 0;
    const SUCCESS = 1;
    const SUCCESS_SUPERUSER_CODE = 1;

    protected $tokenAuth = null;

    protected $login = null;

    protected $code = null;

    public function __construct($code, $login, $tokenAuth)
    {
        $this->code = (int)$code;
        $this->login = $login;
        $this->tokenAuth = $tokenAuth;
    }

    public function getIdentity()
    {
        return $this->login;
    }

    public function getTokenAuth()
    {
        return $this->tokenAuth;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function hasSuperUserAccess()
    {
        return $this->getCode() == self::SUCCESS_SUPERUSER_CODE;
    }

    public function wasAuthenticationSuccessful()
    {
        return $this->code > self::FAILURE;
    }
}