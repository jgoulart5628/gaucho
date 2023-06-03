<?php
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
//error_reporting(E_ALL);
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set('memory_limit', -1);
ini_set('default_charset', 'UTF-8');
ini_set('display_errors', true);
define('TABELA', 'entidade');
define('ROOT', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
require ROOT.DS.'autoload.php';
// Session;
$sessao = new sessao();
// Banco de dados
$db = new banco_Dados(DB);
// XAJAX
require_once '../xajax/xajax_core/xajax.inc.php';
$xajax = new xajax();
// $xajax->configure('debug',true);
$xajax->configure('errorHandler', true);
$xajax->configure('logFile', 'xajax_error.log');
$xajax->register(XAJAX_FUNCTION, 'Tela_Inicial');
$xajax->processRequest();
$xajax->configure('javascript URI', '../xajax/');
// <meta http-equiv="X-UA-Compatible" content="IE=edge">
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre os Gauchos</title>
    <!-- SmartMenus core CSS (required) -->
     <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!--- <link rel="stylesheet" href="../css/all.css" -->
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../css/style4.css">
    <link rel="stylesheet" href="../css/tela_nova.css">
   <?php $xajax->printJavascript('../xajax'); ?>
  </head>
  <body>
<!-- Page Content -->
    <div id="tela_evento" class="container-fluid tela_nova col-xs-12 col-sm-8" style="margin-top: 20px;"></div>
    <script type="text/javaScript">xajax_Tela_Inicial() </script>
 </body>
</html>
<?php
function Tela_Inicial()
{
    $resp = new xajaxResponse();
    global $db;
    $query = " select * from lista_eventos "; 
    $res = $db->Executa_Query_Array($query, $resp);
    $tela =  '<div class="container-fluid table-responsive tela_nova">
                <h3 class="text-muted centro">Informação</h3>
               <table class="table table-bordered table-stripped">
               <thead><tr><th>Titulo Evento</th><th>Entidade Promotora</th><th>Data do Evento</th>
               <th>Links Externos</th></tr></thead><tbody>';
//   $resp->alert('Aqui : '.print_r($res,true)); return $resp;
    if (count($res) > 0) {
        for ($a = 0; $a < count($res); ++$a) {
            $evento_id = $res[$a]['evento_id'];
            $titulo_evento = $res[$a]['titulo_evento'];
            $entidade = $res[$a]['nome_entidade'];
            $data_evento = date('d/m/Y', strtotime($res[$a]['data_evento']));
            $tela_imagem = Visualiza_Fotos($evento_id, $resp);
            $telax = '';
            if ($tela_imagem !== 'X') {
              $telax = '<br>
                   <div class="row">
                     <div id="div_foto">'.$tela_imagem.'</div>
                   </div>
                <br>';
            }
            $tela_links =  lista_links($evento_id, $resp);
//            $resp->alert('Aqui : '.$tela_imagem); return $resp;
            $tela .= '<tr><td>'.$titulo_evento.$telax.'</td>
                      <td>'.$entidade.'</td>
                      <td>'.$data_evento.'</td>
                      <td>'.$tela_links.'</td>
                      </tr>';
          $tela .= '</tbody>';
        }
      }
    $tela .= '</table></div>';
    $resp->assign('tela_evento', 'innerHTML', $tela);
    return $resp;
}

function lista_links($evento_id, $resp)  {
  global $db;
  $query = " select * from links_evento where evento_id = $evento_id ";
  $links = $db->Executa_Query_Array($query, $resp);
  $lista_links = '';
  if (count($links) == 0) { return '<div></div>'; }
  foreach ($links as $link) {
       $link_titulo = $link['link_titulo'];
       $link_url    = $link['link_url'];
       $lista_links .= '<a href="'.$link_url.'" class="form-control btn btn-primary" target="_blank" >'.$link_titulo.'</a>';
  }
  return $lista_links;
}

function Visualiza_Fotos($evento_id, $resp)  {
  global $db;
  $query   = " select * from img_evento  where evento_id = $evento_id  ";
  $imagem  = $db->Executa_Query_Array($query, $resp);
  if (count($imagem) == 0)  { return 'X'; }
  $tela_imagem = '<div class="col-sm-12">';
  if (is_array($imagem))  { 
      foreach($imagem as $img) {
          $tela_imagem .= '<div class="col-sm-3">';
          $img_seq = $img['img_seq'];
          $temp =  'temp/'.$evento_id.'_'.$img_seq.'.jpg';
          $foto =  $img['imagem'];       
          $fh = fopen($temp,'w');
          fwrite($fh,$foto);
          fclose($fh);
          list($larg, $alt) = getimagesize($temp);
          if ($alt > 320)  {
              $divisor = gmp_intval( gmp_gcd( $alt, $larg ) );
              $rat1 = floor($larg / $divisor);
              $rat2 = floor($alt / $divisor);
              $ratio =  $rat1 . ':' . $rat2;
              if ($rat2 > $rat1) { $largx = floor(320 * ($rat1 / $rat2)); } else {
                  $largx = floor(320 * ($rat2 / $rat1));
              }
              if ($larg > $largx) { $larg = $largx; }
              if ($alt > 320)  {  $alt = 320; }
          }
          $tela_imagem .= '<a href="'.$temp.'" id="foto" target="_blank"><img src="'.$temp.'" id="foto" class="magnify" width="'.$larg.'"  height="'.$alt.'"></a></div>';
      }       
  } else { $tela_imagem = 'Deu pobrema'; }  
  $tela_imagem .= '</div>';
  return $tela_imagem;
}
