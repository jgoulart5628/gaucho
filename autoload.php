<?php
spl_autoload_register(
    function ($className) { 
        $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
        include_once $_SERVER['DOCUMENT_ROOT'] . '/gaucho/classes/' . $className . '.php';
    }
);
$cc = $_SERVER['DOCUMENT_ROOT'] . '/gaucho/admin/config/banco.ini';
$cfg = parse_ini_file($cc, true);
$banco = $cfg['CONECTA']['banco'];
define('DB', $banco);
