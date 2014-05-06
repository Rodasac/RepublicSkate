<?php
/**
 *
 */
require_once "Auth.php";
require_once 'Log.php';
require_once 'Log/observer.php';

function loginFunction($username = null, $status = null, &$auth = null)
{
    /*
     * Esto retornara el html que será mostrado a el usuario.
     */
    require_once __DIR__."/../../vistas/loggin.php";
}

class Auth_Log_Observer extends Log_observer {

    var $messages = array();

    function notify($event) {

        $this->messages[] = $event;

    }

}

$options = array(
        'enableLogging' => true,
        'cryptType' => 'md5',
        'users' => array(
            'guest' => md5('password'),
            ),
        );
$a = new Auth("Array", $options, "loginFunction");

$infoObserver = new Auth_Log_Observer(PEAR_LOG_INFO);

$a->attachLogObserver($infoObserver);

$debugObserver = new Auth_Log_Observer(PEAR_LOG_DEBUG);

$a->attachLogObserver($debugObserver);