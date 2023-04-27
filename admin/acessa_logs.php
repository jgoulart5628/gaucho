<?php
   header('Cache-control: private, no-cache');
   header('Expires: Mon, 26 Jun 1997 05:00:00 GMT');
   ini_set('date.timezone', 'America/Sao_Paulo');
   ini_set('memory_limit', -1);
   ini_set('default_charset', 'UTF-8');
   ini_set('display_errors', true);
// $header = Header("Pragma: no-cache");
//   select prdbascodint, prdbastpcodint, prdbasnomcoml, prdregnomtec, prdregnroreg, prdbasrestrito from produto;
   error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
   define('ROOT', dirname(__DIR__));
   define('DS', DIRECTORY_SEPARATOR);
   define('ERRO', ROOT.DS.'log_erros'.DS);
   define('TRANS', ROOT.DS.'log_trans'.DS);
//   error_reporting(E_ALL & ~(E_NOTICE));
   require_once '../xajax/xajax_core/xajax.inc.php';
   $xajax = new xajax();
   // $xajax->configure('debug',true);
   $xajax->configure('errorHandler', true);
   $xajax->configure('logFile', 'xajax_error_log.log');
   $xajax->register(XAJAX_FUNCTION, 'Tela');
   $xajax->register(XAJAX_FUNCTION, 'mostra_erro');
   $xajax->register(XAJAX_FUNCTION, 'mostra_tran');
   $xajax->register(XAJAX_FUNCTION, 'Exclui');
   $xajax->processRequest();
   $xajax->configure('javascript URI', '../xajax/');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Visualizar Arquivos de Log</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <link href="../css/style4.css" rel="stylesheet" type="text/css" />
    <link href="../css/main.css" rel="stylesheet" type="text/css" />
    <style>
      .nova_tela {
         max-width: 90%;
         width: 90%;
         margin: 0 auto;
         background-color: #bbb8c1;
         padding: 20px;
         border-radius: 12px;
         color: #505e6c;
         box-shadow: 1px 1px 5px rgba(0,0,0,0.1);
      }
     </style>   
    <?php $xajax->printJavascript('../xajax'); ?>
</head>
<body class="opaco">
  <div class="container-fluid nova_tela">
     <form id="tela" name="tela" class="border border-success rounded-sm">
       <div class="col-sm-12"> 
           <div class="row">
             <div class="col-sm-6">
               <div id="tela_erro" class="fundo"></div>
             </div>
             <div class="col-sm-6">
               <div id="tela_trans" class="fundox"></div> 
             </div> 
           </div>
       </div>  
       <div class="col-sm-12"> 
          <div class="row">
             <div class="col-sm-6">
               <div id="log_erro" class="fundo"></div>
             </div>
             <div class="col-sm-6">
               <div id="log_trans" style="border: 2px inset;" class="fundox"></div> 
             </div> 
          </div>
       </div>
     </form>    
  </div> 
    <script type="text/javaScript">xajax_Tela();</script>
</body>
</html>

<?php
function Tela()
{
    $resp = new xajaxResponse();
    // metadados tabelas
    $lista_erro = [];
    $lista_tran = [];
    foreach (new DirectoryIterator(ERRO) as $file) {
        if (substr($file, 0, 1) != '.') {
            $lista_erro[] .= $file;
        }
    }
    foreach (new DirectoryIterator(TRANS) as $file) {
        if (substr($file, 0, 1) != '.') {
            $lista_tran[] .= $file;
        }
    }
    $tela = '<div><h5>Log Erros #'.count($lista_erro).'</h5>';
    for ($i = 0; $i < count($lista_erro); ++$i) {
        $arq = $lista_erro[$i];
        $arqx = ERRO.$arq;
        $tela .= '<input type="button"  onclick="xajax_mostra_erro(\''.$arqx.'\'); return false;" value="'.$arq.'"><input type="image" onclick="xajax_Exclui(\''.$arqx.'\'); return false;" style="vertical-align: bottom;" height="24" width="24" src="../img/lixeira.png"></p>';
    }
    $tela .= '</div>';

    $resp->assign('tela_erro', 'innerHTML', $tela);

    // Tela Json
    // sql

    $telax = '<div><h5>Logs de Transação #'.count($lista_tran).'</h5><div id="Gerado"></div>';
    for ($i = 0; $i < count($lista_tran); ++$i) {
        $arq = $lista_tran[$i];
        $arqx = TRANS.$arq;
        $telax .= '<input type="button"  onclick="xajax_mostra_tran(\''.$arqx.'\'); return false;" value="'.$arq.'"><input type="image"  onclick="xajax_Exclui(\''.$arqx.'\'); return false;" style="vertical-align: bottom;" height="24" width="24" src="../img/lixeira.png"></p>';
    }
    $telax .= '</div>';
    $resp->assign('tela_trans', 'innerHTML', $telax);
    // inserts
    return $resp;
}

function mostra_erro($arqx)
{
    $resp = new xajaxResponse();
    if (is_file($arqx)) {
        $text = file($arqx);
    } else {
        $resp->alert('Arquivo '.$arqx.' Não encontrado.');

        return $resp;
    }
    $tela = '<b>'.basename($arqx).' : </b>';
    foreach ($text as $lin) {
        $tela .= $lin.'</p>';
    }
    $resp->assign('log_erro', 'innerHTML', $tela);

    return $resp;
}

function mostra_tran($arqx)
{
    $resp = new xajaxResponse();
    if (is_file($arqx)) {
        $text = file($arqx);
    } else {
        $resp->alert('Arquivo '.$arqx.' Não encontrado.');

        return $resp;
    }
    $tela = '<b>'.basename($arqx).' : </b>';
    foreach ($text as $lin) {
        $tela .= $lin.'</p>';
    }
    //    $resp->alert('Aqui '.$arqx.'-'.count($text)); return $resp;
    $resp->assign('log_trans', 'innerHTML', $tela);

    return $resp;
}

function Exclui($arqx)
{
    $resp = new xajaxResponse();
    if (is_file($arqx)) {
        unlink($arqx);
    } else {
        $resp->alert('Arquivo '.$arqx.' Não encontrado.');

        return $resp;
    }
    $resp->redirect($_SERVER['PHP_SELF']);

    return $resp;
}
