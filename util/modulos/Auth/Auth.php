<?php
/**
 *
 */
// Base de datos
$dsn = 'mysql:dbname=u897309850_skate;host=mysql.nixiweb.com';
$u = 'u897309850_skate';
$p = 'republic12&22';
Sentry::setupDatabaseResolver( new PDO($dsn, $u, $p));