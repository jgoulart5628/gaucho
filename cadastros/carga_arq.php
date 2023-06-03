<?php
ini_set("memory_limit","512M");
ini_set('display_errors', true);
if (!isset($_GET['name'])) {  $arq = "ARQUIVO"; }
 else { $arq = $_GET['name'].'.jpg'; }
if (file_exists($arq)) { unlink($arq); }
$arquivo      = $_FILES['imagem_carga']['name'];
$imagem_carga = $_FILES['imagem_carga']['tmp_name'];
$imagem_tipo  = $_FILES['imagem_carga']['type'];
// echo $arq;
// print_r($_FILES);
if (is_file($imagem_carga)) { 
	rename($imagem_carga, $arq);
	chmod($arq ,0777); 
} else { die($arq.'-'.$imagem_carga.'-'.$imagem_tipo); }
