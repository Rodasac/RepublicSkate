<?php

/* Establecemos que las páginas no pueden ser cacheadas */
header("Expires: Tue, 01 Jul 2001 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-type: text/html');
$cstrong = TRUE;

$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
$_SESSION['SKey'] = openssl_random_pseudo_bytes(35, $cstrong);
$_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
$_SESSION['LastActivity'] = $_SERVER['REQUEST_TIME'];