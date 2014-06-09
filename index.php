<?php
/**
 * SkateWeb - Sitio Oficial
 *
 * Esta es nuestra página de inicio. Desde aquí accederemos a los demás archivos
 * y módulos del Sistema
 */
date_default_timezone_set('America/Caracas');
ini_set('date.timezone', 'America/Caracas');
ini_set('intl.default_locale', 'es_VE');

require_once dirname(__FILE__)."/bootstrap.php";

class_alias('Cartalyst\Sentry\Facades\Native\Sentry', 'Sentry');
require_once dirname(__FILE__)."/util/seguridad.php";
require_once dirname(__FILE__)."/util/crypt.php";
require_once dirname(__FILE__)."/modulos/Auth/Auth.php";

$uri = $_SERVER['REQUEST_URI'];

// URI's o URL's disponibles
// Index
$rindex1 = '/^[skate|\/]*$/';
$rindex2 = '/^[skate|\/]\?page=[\d]+[\/]*$/';
$rindex3 = '/^[skate|\/]\?page=[\d]+[\/]*&vaciar=true[\/]*$/';
$rindex4 = '/^[skate|\/]\?page=[\d]+[\/]*&addp=true[\/]*$/';
$rindex5 = '/^[skate|\/]\?page=[\d]+[\/]*&email=true[\/]*$/';
$raddNov = '/^[\\w|\/]*addNovedad[\/]*$/';
$rupnov = '/^[\\w|\/]*upnovedad[\/]*$/';
$rdelnov = '/^[\\w|\/]*delnovedad[\/]*$/';
$rnovId = '/^[\\w|\/]*novedad\/\?id=[\d]+[\/]*$/';
//Auth
$rlogin = '/^[\\w|\/]*login[\/]*$/';
$rlogin2 = '/^[\\w|\/]*login\/\?error=[\d]+[\/]*$/';
$rregister = '/^[\\w|\/]*registrarse[\/]*$/';
$rlogout = '/^[\\w|\/]*logout[\/]*$/';
$rupdate = '/^[\\w|\/]*update[\/]*$/';
$ruserlist = '/^[\\w|\/]*userlist[\/]*$/';
$ruserperfil = '/^[\\w|\/]*perfil[\/]*$/';
$rdeleteUser = '/^[\\w|\/]*deleteuser[\/]*$/';
//Categorias
$raddCat = '/^[\\w|\/]*addCategory[\/]*$/';
$raddCatnext = '/^[\\w|\/]*addCategory\/\?next=[\w]*[\/]*$/';
$rupcat = '/^[\\w|\/]*upcategoria[\/]*$/';
$rcat = '/^[\\w|\/]*categorias[\/]*$/';
$rcatPage = '/^[\\w|\/]*categorias\/\?page=[\d]+[\/]*$/';
$rcatId = '/^[\\w|\/]*categoria\/\?id=[\d]+[\/]*$/';
$rcatIdpage = '/^[\\w|\/]*categoria\/\?id=[\d]+[\/]*&page=[\d]+[\/]*$/';
$rdelcat = '/^[\\w|\/]*delcategoria[\/]*$/';
//Productos
$raddPro = '/^[\\w|\/]*addProduct[\/]*$/';
$ruppro = '/^[\\w|\/]*upproducto[\/]*$/';
$rdelpro = '/^[\\w|\/]*delproducto[\/]*$/';
$rpro = '/^[\\w|\/]*productos[\/]*$/';
$rproPage = '/^[\\w|\/]*productos\/\?page=[\d]+[\/]*$/';
$rproId = '/^[\\w|\/]*producto\/\?id=[\d]+[\/]*$/';
$rprosearch = '/^[\\w|\/]*prodsearch[\/]*$/';
$rprosearchPage = '/^[\\w|\/]*prodsearch\/\?page=[\d]+[\/]*$/';
//Acerca de
$racerca = '/^[\\w|\/]*acerca[\/]*$/';
//Compras
$rcarrito = '/^[\\w|\/]*carrito[\/]*$/';
$rcomprar = '/^[\\w|\/]*comprar[\/]*$/';
$rtickets = '/^[\\w|\/]*tickets\/\?page=[\d]+[\/]*$/';
$rticket = '/^[\\w|\/]*ticket[\/]*$/';
$rticketId = '/^[\\w|\/]*ticket\/\?id=[\d]+[\/]*$/';
$rupticket = '/^[\\w|\/]*updateTicket[\/]*$/';
$rupticketId = '/^[\\w|\/]*updateTicket\/\?id=[\d]+[\/]*$/';
$rreport = '/^[\\w|\/]*reportes[\/]*$/';
$rreportType = '/^[\\w|\/]*reportes\/\?tipo=[\d]+[\/]*$/';


$uploaddir = dirname(__FILE__).'/uploads/';


if(session_status() === PHP_SESSION_ACTIVE){
    $session_general_verify = session_id();
    if($session_general_verify != $_COOKIE['PHPSESSID']){
        header('Status: 401 Unauthorized');
        require_once dirname(__FILE__)."/vistas/401.php";
    }
}

function Head401(){
    header('Status: 401 Unauthorized');
    require_once dirname(__FILE__)."/vistas/401.php";
}

// Autentificación
if (preg_match($rlogin, $uri) || preg_match($rlogin2, $uri)){
    if(!Sentry::check()){
        require_once dirname(__FILE__) . "/vistas/auth/loggin.php";
    }
    else{
        header("location: /");
    }
}
elseif (preg_match($rregister, $uri)){
    if(!Sentry::check()){
        require_once dirname(__FILE__) . "/vistas/auth/register.php";
    }
    else{
        header("location: /");
    }
}
elseif (preg_match($ruserlist, $uri)){
    if(Sentry::check() && Sentry::getUser()->hasAccess('write')){
        require_once dirname(__FILE__) . "/vistas/auth/userlist.php";
    }
    else{
        Head401();
    }
}
elseif (preg_match($rdeleteUser, $uri)){
    if(Sentry::check()){
        require_once dirname(__FILE__) . "/vistas/auth/deleteUser.php";
    }
    else{
        Head401();
    }
}
elseif (preg_match($ruserperfil, $uri)){
    if(Sentry::check()){
        require_once dirname(__FILE__) . "/vistas/auth/UserPerfil.php";
    }
    else{
        Head401();
    }
}
elseif (preg_match($rupdate, $uri)){
    if(Sentry::check()){
        require_once dirname(__FILE__) . "/vistas/auth/updateUser.php";
    }
    else{
        Head401();
    }
}
elseif (preg_match($rlogout, $uri)){
    Sentry::logout();
    session_destroy();
    session_unset();
    header("location: /");
}
//carrito
elseif (preg_match($rcomprar, $uri)){
    require_once dirname(__FILE__) . "/vistas/carrito/comprar.php";
}
elseif (preg_match($rcarrito, $uri)){
    require_once dirname(__FILE__)."/modulos/Carrito/carrito.php";
}
elseif (preg_match($rtickets, $uri)){
    if($user = Sentry::getUser()){
        if ($user->hasAccess('write')){
            require_once dirname(__FILE__)."/vistas/carrito/verTicket.php";
        }
        else {
            Head401();
        }
    }
    else {
        header("location: /");
    }
}
elseif (preg_match($rticket, $uri) || preg_match($rticketId, $uri)){
    if($user = Sentry::getUser()){
        if ($user->hasAccess('write')){
            require_once dirname(__FILE__)."/vistas/carrito/searchTicket.php";
        }
        else {
            Head401();
        }
    }
    else {
        header("location: /");
    }
}
elseif (preg_match($rupticket, $uri) || preg_match($rupticketId, $uri)){
    if($user = Sentry::getUser()){
        if ($user->hasAccess('write')){
            require_once dirname(__FILE__)."/vistas/carrito/updateTicket.php";
        }
        else {
            Head401();
        }
    }
    else {
        header("location: /");
    }
}
elseif (preg_match($rreport, $uri) || preg_match($rreportType, $uri)){
    if($user = Sentry::getUser()){
        if ($user->hasAccess('write')){
            require_once dirname(__FILE__)."/vistas/reportes/reportePDF.php";
        }
        else {
            Head401();
        }
    }
    else {
        header("location: /");
    }
}
//categorias
elseif (preg_match($rcat, $uri) || preg_match($rcatPage, $uri)){
    require_once dirname(__FILE__) . "/vistas/categorias/categorias.php";
}
elseif (preg_match($rcatId, $uri) || preg_match($rcatIdpage, $uri)){
    require_once dirname(__FILE__) . "/vistas/categorias/categoria.php";
}
elseif (preg_match($rdelcat, $uri)){
    require_once dirname(__FILE__) . "/vistas/categorias/deleteCategory.php";
}
elseif (preg_match($rupcat, $uri)){
    if(Sentry::check() && Sentry::getUser()->hasAccess('write')){
        require_once dirname(__FILE__) . "/vistas/categorias/updateCategory.php";
    }
    else {
        Head401();
    }
}
elseif (preg_match($raddCat, $uri) || preg_match($raddCatnext, $uri)){
    if(Sentry::check() && $user = Sentry::getUser()){
        if ($user->hasAccess('write')){
            require_once dirname(__FILE__) . "/vistas/categorias/addCategory.php";
        }
        else {
            Head401();
        }
    }
    else{
        header("location: /");
    }
}
//novedades
elseif (preg_match($rnovId, $uri)){
    require_once dirname(__FILE__) . "/vistas/novedades/novedad.php";
}
elseif (preg_match($raddNov, $uri)){
    if(Sentry::check() && $user = Sentry::getUser()){
        if ($user->hasAccess('write')){
            require_once dirname(__FILE__) . "/vistas/novedades/addNovedad.php";
        }
        else {
            Head401();
        }
    }
    else{
        header("location: /");
    }
}
elseif (preg_match($rupnov, $uri)){
    if(Sentry::check() && Sentry::getUser()->hasAccess('write')){
        require_once dirname(__FILE__) . "/vistas/novedades/updateNovedad.php";
    }
    else {
        Head401();
    }
}
elseif (preg_match($rdelnov, $uri)){
    require_once dirname(__FILE__) . "/vistas/novedades/deleteNovedad.php";
}
//productos
elseif (preg_match($rpro, $uri) || preg_match($rproPage, $uri)){
    require_once dirname(__FILE__) . "/vistas/productos/productos.php";
}
elseif (preg_match($rproId, $uri)){
    require_once dirname(__FILE__) . "/vistas/productos/producto.php";
}
elseif (preg_match($raddPro, $uri)){
    if(Sentry::check() && $user = Sentry::getUser()){
        if ($user->hasAccess('write')){
            require_once dirname(__FILE__) . "/vistas/productos/addProduct.php";
        }
        else {
            Head401();
        }
    }
    else{
        header("location: /");
    }
}
elseif (preg_match($ruppro, $uri)){
    if(Sentry::check() && Sentry::getUser()->hasAccess('write')){
        require_once dirname(__FILE__) . "/vistas/productos/updateProduct.php";
    }
    else {
        Head401();
    }
}
elseif (preg_match($rdelpro, $uri)){
    require_once dirname(__FILE__) . "/vistas/productos/deleteProduct.php";
}
elseif (preg_match($rprosearch, $uri) || preg_match($rprosearchPage, $uri)){
    require_once dirname(__FILE__) . "/vistas/productos/productosSearch.php";
}
// Inicio y demás...
elseif (preg_match($racerca, $uri)){
    require_once dirname(__FILE__)."/vistas/acerca.php";
}
elseif (preg_match($rindex1, $uri) || preg_match($rindex2, $uri) || preg_match($rindex3, $uri) || preg_match($rindex4, $uri) || preg_match($rindex5, $uri)){
    require_once dirname(__FILE__)."/vistas/vista-index.php";
}
else{
    header('Status: 404 Not Found');
    require_once dirname(__FILE__)."/vistas/404.php";
}

