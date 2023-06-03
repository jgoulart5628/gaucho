<?php
define('UPLOAD_DIR', 'tmp/');
$img = $_POST['base64image'];
$img = str_replace('data:image/jpeg;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
// $file = UPLOAD_DIR . uniqid() . '.jpg';
$file = UPLOAD_DIR . $_POST['evento_id'] . '.jpg';
if (file_exists($file)) { unlink($file); }
$success = file_put_contents($file, $data);
print $success ? $file : 'Não é possível salvar o arquivo.';
// print_r($_POST);
?>
 