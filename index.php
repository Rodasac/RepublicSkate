<?php
/**
 * SkateWeb - Sitio Oficial
 *
 * Esta es nuestra página de inicio. Desde aquí accederemos a los demás archivos
 * y módulos del Sistema
 */
session_start();
$_SESSION['Anonymous'] = True;

require_once __DIR__."/util/seguridad.php";
include_once __DIR__."/modulos/DB/Model.php";

$uri = $_SERVER['REQUEST_URI'];
$rindex = '/\/SkateWeb\//';

$session_general_verify = session_id();
$session_SKey_verify = $_SESSION['SKey'];

if(isset($_COOKIE['PHPSESSID'])){
    if($session_general_verify != $_COOKIE['PHPSESSID']
    || $session_SKey_verify != $_SESSION['SKey']){
        header('Status: 401 Unauthorized');
        echo '<html><body><h1>Unauthorized</h1></body></html>';
        throw new Exception("No intentes hacer nada malo");
    }
}

if (preg_match($rindex, $uri)){
    require_once __DIR__."/vistas/vista-index.php";
}
else{
    header('Status: 404 Not Found');
    echo '<html><body><h1>Page Not Found</h1></body></html>';
}

