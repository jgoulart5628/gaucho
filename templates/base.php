<?php
    header('Cache-control: private, no-cache');
    header('Expires: Mon, 26 Jun 1997 05:00:00 GMT');
    ini_set('date.timezone', 'America/Sao_Paulo');
    ini_set('memory_limit', -1);
    ini_set('default_charset', 'UTF-8');
    ini_set('display_errors', true);
    error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
    // error_reporting(E_ALL);
    $amb = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');
    $and = strpos($amb, 'Android');
    if($and > 0) { $an = 'Android';} else { $an = ''; }
    define('AN', $an);
    define('ROOT', dirname(__DIR__));
    define('DS', DIRECTORY_SEPARATOR);
    require ROOT.DS.'autoload.php';
        // Session;
    $sessao = new sessao();
    // Banco de dados
    $db = new banco_Dados(DB);
    //    ****
    // Xajax **
    require_once '../xajax/xajax_core/xajax.inc.php';
    $xajax = new xajax();
    // $xajax->configure('debug',true);
    $xajax->configure('errorHandler', true);
    $xajax->configure('logFile', 'xajax_error_log.log');
    $xajax->register(XAJAX_FUNCTION, 'Tela_Inicial');
    $xajax->processRequest();
    $xajax->configure('javascript URI', '../xajax/');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>JGWeb SW</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style4.css">
    <?php
       $xajax->printJavascript('../xajax');
    ?>
  </head>
  <body>
     <div id="saida_geral" class="wrapper"></div>  
     <script src="../js/jquery-3.3.1.min.js"></script>
     <script src="../js/bootstrap.bundle.min.js"></script>
     <script type="text/javaScript">xajax_Tela_Inicial();</script>
  </body>
 </html>
<?php
function Tela_Inicial() 
{
   $resp = new xajaxResponse();
   global $sessao;
   $resp->alert('Template modelo');
   return $resp;   
}
   