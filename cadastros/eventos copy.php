<?php
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
//error_reporting(E_ALL);
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set('memory_limit', -1);
ini_set('default_charset', 'UTF-8');
ini_set('display_errors', true);
$amb = $_SERVER['HTTP_USER_AGENT'];
$and = strpos($amb, 'Android');
if($and > 0) { $an = True;} else { $an = false; }
define('AN', $an);
define('TABELA', 'entidade');
define('ROOT', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
require ROOT.DS.'autoload.php';
// Session;
$sessao = new sessao();
// Banco de dados
$db = new classe_evento(DB);
// XAJAX
require_once '../xajax/xajax_core/xajax.inc.php';
$xajax = new xajax();
// $xajax->configure('debug',true);
$xajax->configure('errorHandler', true);
$xajax->configure('logFile', 'xajax_error.log');
$xajax->register(XAJAX_FUNCTION, 'Tela_Inicial');
$xajax->register(XAJAX_FUNCTION, 'Manut_CRUD');
$xajax->register(XAJAX_FUNCTION, 'Excluir');
$xajax->register(XAJAX_FUNCTION, 'Gravar');
$xajax->register(XAJAX_FUNCTION, 'Monta_Modal');
$xajax->register(XAJAX_FUNCTION, 'Salva_Modal');
$xajax->register(XAJAX_FUNCTION, 'Desiste');
$xajax->register(XAJAX_FUNCTION, 'Carrega_Arquivo');
$xajax->register(XAJAX_FUNCTION, 'Grava_Imagem');
$xajax->register(XAJAX_FUNCTION, 'Exclui_Imagem');
$xajax->register(XAJAX_FUNCTION, 'Captura_Fotos');
$xajax->register(XAJAX_FUNCTION, 'Manut_Links');
$xajax->register(XAJAX_FUNCTION, 'Gravar_Link');
$xajax->register(XAJAX_FUNCTION, 'Exclui_Link');
$xajax->register(XAJAX_FUNCTION, 'Cancela_Link');
$xajax->register(XAJAX_FUNCTION, 'Retorna_cap');
$xajax->processRequest();
$xajax->configure('javascript URI', '../xajax/');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Cadastro Eventos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style4.css">
    <link rel="stylesheet" href="../css/tela_nova.css">
    <link rel="stylesheet" href="../css/Navigation-with-Search.css">
    <script type="text/javascript" src="../js/micoxUpload.js"></script>
    <script type="text/javascript" src="../js/webcam.min.js"></script>
    <script type="text/javascript" src="../js/camera.js"></script>
   <?php $xajax->printJavascript('../xajax'); ?>
 </head>
 <body class="opaco">
    <div class="container-fluid" style="padding-top: 10px;" >
         <div id="tela_evento" class="col-xs-12" style="padding: 5px 0;"></div>
    </div>
    <div class="footer">
        <span class="glyphicon glyphicon-thumbs-up"></span>&#174; JGWeb
    </div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>  
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
   <script type="text/javaScript" src="../js/jquery.dataTables.min.js" ></script>
   <script type="text/javaScript" src="../js/dataTables.bootstrap.js" ></script>
   <script type="text/javaScript">xajax_Tela_Inicial() </script>
 </body>
</html>
<?php
function Tela_Inicial()
{
    $resp = new xajaxResponse();
    global $db;
    $res = $db->Monta_lista($resp);
    if (count($res) == 0) {
        $resp->script('xajax_Manut_CRUD();');
        return $resp;
    }
 //   $resp->alert('Aqui - '.print_r($res,true));
    $tela = '<div class="container-fluid table-responsive tela_nova">
               <h3 class="text-muted centro">Cadastro Eventos</h3>
               <table  class="table table-striped table-bordered table-sm">
                   <button type="submit"  class="btn btn-primary" onclick="xajax_Manut_CRUD(0,\'I\'); return false;">Inclui Novo Evento</button>
                    <thead class="table-dark">  
                       <tr>
                        <th style="text-align: center;">Alt/Exc.</th> 
                        <th style="text-align: center;">Titulo Evento </th>
                        <th style="text-align: center;">Entidade Promotora </th>
                        <th style="text-align: center;">Data do Evento</th>
                       </tr></thead><tbody>';
    if (is_array($res)) {
        $tt = count($res);
        for ($a = 0; $a < $tt; ++$a) {
            $id = $res[$a]['evento_id'];
            $titulo_evento = $res[$a]['titulo_evento'];
            $entidade = $res[$a]['entidade_id'];
            $data_evento = $res[$a]['data_evento'];
            $tela .= '<tr> 
                     <td><input type="image" src="../img/edit-icon.png" border="0" width="24" height="24" data-toggle="tooltip" data-placement="bottom" title="Altera/Exclui registro do Evento" onclick="xajax_Manut_CRUD('.$id.',\'A\'); return false;"> '.$id.'</td>
                     <td>'.$titulo_evento.'</td>
                     <td>'.Combo_Entidade($entidade, $resp).'</td>
                     <td>'.date('d/m/Y', strtotime($data_evento)).'</td>
                  </tr>';
        }
    }
    $tela .= '</tbody></table></div>';
    $resp->assign('tela_evento', 'innerHTML', $tela);

    return $resp;
}

function Manut_CRUD($id=0, $oper='I')
{
    $resp = new xajaxResponse();
    global $db;
    if ($oper !== 'I') {
        $res = $db->Ler_Registro($id, $resp);
        $evento_id = $res['evento_id'];
        $entidade_id = $res['entidade_id'];
        $titulo_evento = $res['titulo_evento'];
        $info_complementar = $res['info_complementar'];
        $data_evento = $res['data_evento'];
        $data_inicio_inscri = $res['data_inicio_inscri'];
        $data_final_inscri = $res['data_final_inscri'];
        $data_base_calculo_idade = $res['data_base_calculo_idade'];
    } else {
        $evento_id = $db->Busca_Proximo_ID($resp);
        $entidade_id = 0;
        $titulo_evento = '';
        $info_complementar = '';
        $data_evento = '';
        $data_inicio_inscri = '';
        $data_final_inscri = '';
        $data_base_calculo_idade = '';
    }

    if ($oper == 'I') {
        $opera = 'Incluir';
        $label = 'Gravar';
        $rd = 'readonly';
    } else {
        $opera = 'Alterar';
        $label = 'Altera';
    }
   // tela de abas                   <div class="panel-body" style="background-color: #7FDBFF;">
    $tela = '<div class="col-md-12">
                <div class="panel with-nav-tabs panel-secondary tela_nova">
                  <div class="panel-heading">
                     <ul class="nav nav-pills" id="abas">
                        <li class="nav-item active"><a href="#aba1" data-toggle="tab">Evento</a></li>
                        <li class="nav-item"><a href="#aba2" data-toggle="tab">Modalidades </a></li>
                        <li class="nav-item"><a href="#aba3" data-toggle="tab">Imagens</a></li>
                        <li class="nav-item"><a href="#aba4" data-toggle="tab">Links</a></li>
                     </ul>
                  </div>
                  <div class="panel-body">                     
                   <div class="tab-content">
                    <div class="tab-pane fade in active"  id="aba1"><h4>Evento</h4>
                     <form id="tela_entidade" name="tela_entidade"  role="form" method="POST" data-toggle="validator">
                     <div class="form-group required">';
        /*
        `evento_id` `entidade_id` `titulo_evento` `info_complementar` `data_evento`
          `data_inicio_inscri`  `data_final_inscri`  `data_base_calculo_idade`
        */

    $tela .= '<input type="hidden" name="evento_id" value="'.$evento_id.'">
             <input type="hidden" name="oper" value="'.$oper.'">
                   <div class="row">
                     <div class="col-sm-4">
                        <label for="titulo_evento" class="control-label">Título do Evento : </label>
                        <input class="form-control" type="text" name="titulo_evento" id="titulo_evento" value="'.$titulo_evento.'" required="true">
                     </div>   
                     <div class="col-sm-3">
                        <label for="entidade">Entidade. : </label>
                        '.Combo_Entidade($entidade_id, $resp).'
                     </div>
                     <div class="col-sm-4">
                        <label for="info_complementar">Mais Informações. : </label>
                        <textarea name="info_complementar" id="info_complementar" rows="3" class="form-control" >'.$info_complementar.'</textarea>
                     </div>
                    </div>
                    <br>
                    <div class="row">
                     <div class="col-sm-3">
                       <label for="data_evento">Data do Evento : </label>
                       <input class="form-control" type="date" name="data_evento" id="data_evento" value="'.$data_evento.'" required="true">
                     </div>   
                     <div class="col-sm-3">
                       <label for="data_inicio_inscri">Data Inícial Inscrições: </label>
                       <input class="form-control" type="date" name="data_inicio_inscri" id="data_inicio_inscri" value="'.$data_inicio_inscri.'" required="true">
                     </div>
                     <div class="col-sm-3">
                       <label for="data_final_inscri">Data Final Inscrições: </label>
                       <input class="form-control" type="date" name="data_final_inscri" id="data_final_inscri" value="'.$data_final_inscri.'" required="true">
                     </div>
                     <div class="col-sm-3">
                       <label for="data_base_calculo_idade">Data para cálculo idade: </label>
                       <input class="form-control" type="date" name="data_base_calculo_idade" id="data_base_calculo_idade" value="'.$data_base_calculo_idade.'" required="true">
                     </div>
                   </div>
                   <br>
                <br>';
    $tela .= '<div class="row">
                 <div class="col-sm-3">
                   <button type="submit"  class="btn btn-lg btn-block btn-primary" onclick="xajax_Gravar(xajax.getFormValues(\'tela_evento\')); return false;">'.$label.'</button>
                 </div>
                 <div class="col-sm-3">  
                   <button type="submit"  class="btn btn-lg btn-block btn-danger" onclick="xajax_Excluir(\''.$evento_id.'\'); return false;">Exclui</button>
                 </div>
                 <div class="col-sm-3">  
                  <button type="submit"  class="btn btn-lg btn-block btn-warning" onclick="xajax_Tela_Inicial(\''.$evento_id.'\'); return false;">Cancela</button>
                </div>
            </div></div></form></div>';

    $tela .= tela_modalidades($evento_id, $titulo_evento, $resp);
    $tela .= tela_fotos($evento_id, $titulo_evento, $resp);
    $tela .= tela_links($evento_id, $titulo_evento, $resp);

    $resp->assign('tela_evento', 'innerHTML', $tela);
    return $resp;
}

function Lista_Links($evento_id, $resp)  {
  global $db;
  $links = $db->Lista_Links($evento_id, $resp);
  $lista_links = '<table class="table table-stripped table-bordered">
                    <thead class="table-dark">
             <tr><th>Seq.</th><th>Titulo Link</th></th><th>Url do Link</th></tr></thead><tbody>';
  $link_seq = 0;
  if (is_array($links)) {
    foreach ($links as $link) {
       $link_seq    = $link['link_seq'];
       $link_titulo = $link['link_titulo'];
       $link_url    = $link['link_url'];
       $lista_links .= '<tr><td><a href="#" onclick="xajax_Manut_Links('.$evento_id.','.$link_seq.'); return false;">'.$link_seq.'</td>
                      <td>'.$link_titulo.'</td><td>'.$link_url.'</td></tr>';
    }   
  }
  $lista_links .= '</tbody></table>';
  return $lista_links;
}
function tela_links($evento_id, $titulo_evento, $resp) {
  $lista_links = Lista_Links($evento_id, $resp);
  $tela = '<div class="tab-pane fade in" id="aba4">
            <h4>Links: </h4>
             <form name="tela_links" id="tela_links" role="form" method="POST">
             <input type="hidden" name="evento_id" value="'.$evento_id.'">
              <div class="row">
              <div class="form-group col-sm-4">
                <label for="evento_id">Código/Nome</label>
                <input type="text" class="form-control" name="evento" id="evento" value="'.$evento_id.' - '.$titulo_evento.'" readonly>
             </div>
             <div class="col-sm-3">
                 <label></label>
                 <button type="submit" class="btn btn-lg btn-primary form-control" onclick="xajax_Manut_Links('.$evento_id.',0); return false;">Incluir Novo Link</button>
             </div></div>';
   $tela .= '<div class="row">
               <div id="div_links" class="container-fluid table-responsive">'.$lista_links.'</div>
             </div>
             <br></div></form>';
          
 return $tela;     
}        

function Manut_Links($evento_id, $link_seq=0)  {
  $resp = new xajaxResponse();
  global $db;
  $link = $db->Leitura_Link($evento_id, $link_seq, $resp);
  if ($link > 0) {
    $link_titulo = $link['link_titulo'];
    $link_url = $link['link_url'];
    $oper = "Alterar";
  } else {
    $link_seq = $db->Proximo_Indice_Link($evento_id, $resp);
    $link_titulo = '';
    $link_url = '';
    $oper = 'Incluir';
  }
//   $resp->alert('Aqui : '.$evento_id.'-'.$link_seq.'-'.print_r($link,true)); return $resp;
  $tela = ' <input type="hidden" name="oper" value="'.$oper.'"><div class="row">
                  <div class="form-group col-sm-2">
                   <label for="link_seq">Sequêmcia</label>
                   <input type="text" class="form-control" name="link_seq" value="'.$link_seq.'" readonly>
                 </div>
                 <div class="col-sm-4">
                   <label for="link_titulo">Titulo do Link</label>
                   <input type="text" class="form-control" name="link_titulo" value="'.$link_titulo.'">
                </div> 
               <div class="col-sm-4">
                 <label for="link_url">Endereço do Link</label>
                 <input type="text" class="form-control" name="link_url" value="'.$link_url.'">
               </div> 
               <div class="row">
                 <div class="col-sm-4">
                   <button type="submit" class="btn btn-lg btn-block btn-primary form-control" onclick="xajax_Gravar_Link(xajax.getFormValues(\'tela_links\')); return false;">'.$oper.'</button>
                  </div> 
                  <div class="col-sm-4">
                   <button type="submit" class="btn btn-lg btn-block btn-danger form-control" onclick="xajax_Excluir_Link('.$evento_id.','.$link_seq.'); return false;">Excluit</button>
                  </div> 
                  <div class="col-sm-4">
                   <button type="submit" class="btn btn-lg btn-block btn-success form-control" onclick="xajax_Cancela_Link(); return false;">Cancela</button>
                  </div> 
                </div>';

   $resp->assign('div_links', 'innerHTML', $tela);
   return $resp;
}
function Cancela_Link()  {
  $resp    = new xajaxResponse();
  $resp->assign("div_links","innerHTML","");
  return $resp;    
}

function Gravar_Link($dados)  {
  $resp    = new xajaxResponse();
  $evento_id = $dados['evento_id'];
  global $db;
  if (!$dados['link_titulo']) {
    $resp->alert('É necessário dar um tiulo ao Link!'); return $resp;
  }
  if (!$dados['link_url']) {
    $resp->alert('É necessário informar o endereço do Link!'); return $resp;
  }
  $e = $db->Atualiza_Link($dados,  $resp);
//  $resp->alert('Aqui : '.$e.'-'.print_r($dados,true)); return $resp;
  $lista_links = Lista_Links($evento_id, $resp);
  $resp->assign('div_links', 'innerHTML', $lista_links);
  return $resp;
}

function Excluir_Link($evento_id, $link_seq )  {
  $resp    = new xajaxResponse();
  global $db;
  $resp->confirmCommands(1, ' Confirma exclusão deste Link: '.$evento_id.'-'.$link_seq.'? ');
  $e = $db->Elimina_Link($evento_id, $link_seq,  $resp);
  $resp->script("xajax_Manut_CRUD($evento_id, 'A')");
  return $resp;
}


function tela_fotos($evento_id, $titulo_evento, $resp) {

  $tela_imagem = Visualiza_Fotos($evento_id, $resp);
  $tela = '<div class="tab-pane fade in" id="aba3">
            <h4>Foto: </h4>
            <div class="row">
              <div class="form-group col-sm-4">
                <label for="evento_id">Código/Nome</label>
                <input type="text" class="form-control" name="evento" id="evento" value="'.$evento_id.' - '.$titulo_evento.'" readonly>
             </div>
             <div class="col-sm-3">
                 <label></label>
                 <button type="submit" class="btn btn-lg btn-primary form-control" onclick="xajax_Carrega_Arquivo('.$evento_id.'); return false;">Carregar Fotos</button>
             </div>';
   if (!AN) {          
      $tela .= '<div class="col-sm-4">
                 <label></label>
                 <button type="submit" class="btn btn-lg btn-primary form-control" onclick="xajax_Captura_Fotos('.$evento_id.'); return false;">Capturar Camera</button>
             </div>
             <br>';
           }    
   $tela .= '<div class="row">
                <div id="div_foto">'.$tela_imagem.'</div>
             </div>
             <br>
             <div class="row">
               <div id="tela_carga"></div>
             </div>'; 
   if (!AN) {          
      $tela .= '<div class="row">
               <div id="tela_captura"></div>
             </div>';
           }
   $tela .= '</div></div>';
          
 return $tela;     
}        

function Captura_Fotos($evento_id)  {
  $resp    = new xajaxResponse();
//    $resp->alert('Implementar captura de Câmera');
  $arq_imagem = 'tmp/'.$evento_id;
  $tela = '<fieldset style="border: 2px outset">
            <br>
            <input type="hidden" name="evento_id" id="evento_id" value="'.$evento_id.'">
            <div class="contem" id="camera"><b>Câmera:</b>
            <div id="minha_camera"></div>
              <form>
                <input type="hidden" name="evento_id" id="evento_id" value="'.$evento_id.'">
                <input type="button" value="Tirar Foto" onClick="bater_foto()">
              </form>
            </div>
            <div class="contem" id="previa">
            <b>Prévia:</b><div id="results"></div>
            </div>
            <div class="contem" id="salva">
            <span id="carregando"></span><img id="completado" src=""/>
            </div>
           
            <div class="form-group col-sm-2">
                <label></label>
                <button type="submit" class="btn btn-lg btn-primary form-control" onclick="xajax_Retorna_cap(); return false;">Cancela</button>
            </div>   
          </fieldset>';
  $resp->assign("tela_captura","className","mostrar");
  $resp->assign("tela_captura", "innerHTML", $tela);
  $resp->script("mostrar_camera(); ");
  $resp->script("Webcam.attach('#minha_camera'); ");
  return $resp;
}   

function Visualiza_Fotos($evento_id, $resp)  {
  global $db;
  /*
   `evento_id` int(5) NOT NULL,
  `img_seq` int(2) NOT NULL,
  `imagem` blob DEFAULT NULL,
  */    
  $imagem = $db->Busca_Imagem($evento_id, $resp);
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
          $tela_imagem .= '<a href="'.$temp.'" id="foto" target="_blank"><img src="'.$temp.'" id="foto" class="magnify" width="'.$larg.'"  height="'.$alt.'"></a>';
          $tela_imagem .= '<button class="btn btn-danger" onclick="xajax_Exclui_Imagem('.$evento_id.','.$img_seq.',\''.$temp.'\'); return false;">Excluir </button></div>';
      }       
  } else { $tela_imagem = 'Deu pobrema'; }  
  $tela_imagem .= '</div>';
  return $tela_imagem;
}

function Exclui_Imagem($evento_id, $img_seq, $temp)  {
  $resp    = new xajaxResponse();
  global $db;
  $resp->confirmCommands(1, ' Confirma exclusão desta imagem: '.$evento_id.'-'.$img_seq.'? ');
  $e = $db->Elimina_Imagem($evento_id, $img_seq,  $resp);
  unlink($temp);
  $tela_imagem = Visualiza_Fotos($evento_id, $resp);
  $resp->assign("div_foto","innerHTML", $tela_imagem);
  return $resp;
}
function Retorna()  {
  $resp    = new xajaxResponse();
  $resp->assign("tela_carga","className","esconder");
  return $resp;    
}
function Retorna_cap()  {
  $resp    = new xajaxResponse();
  $resp->assign("tela_captura","className","esconder");
  return $resp;    
}

function Carrega_Arquivo($evento_id)  {
  $resp = new xajaxResponse();
  $arq_imagem = 'tmp/'.$evento_id;
  $tela = '<form id="carga_img" name="carga_img" enctype="multipart/form-data" role="form" method="post">
            <fieldset style="border: 2px outset">
            <br>
            <input type="hidden" name="evento_id" id="evento_id" value="'.$evento_id.'">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group col-sm-5">
                  <label for="arquivo">Escolha o arquivo de imagem:</label>
                  <input type="file" class="form-control"  id="imagem_carga" name="imagem_carga" 
                 onchange="micoxUpload(this.form,\'carga_arq.php?name='.$arq_imagem.'\',\'recebe_up_3\',\'Carregando...\',\'Erro ao carregar\')" >
                  <div id="recebe_up_3" class="recebe"></div>
                </div>  
                <div class="form-group col-sm-2">
                  <label></label>
                   <button type="submit" class="btn btn-lg btn-block btn-primary form-control" onclick="xajax_Grava_Imagem(xajax.getFormValues(\'carga_img\')); return false;">Gravar!</button>
                </div>   
                <div class="form-group col-sm-2">
                  <label></label>
                   <button type="submit" class="btn btn-lg btn-block btn-primary form-control" onclick="xajax_Retorna(); return false;">Desiste e  Retorna</button>
                </div>   
              </div>
             </div>  
          </fieldset>
         </form>';
  $resp->assign("tela_carga","className","mostrar");
  $resp->assign("tela_carga", "innerHTML", $tela);        
  return $resp;
}
function Grava_Imagem($dados)  {
  $resp = new xajaxResponse();
//  $resp->alert(' Aqui! '.print_r($dados, true));  return $resp; 
  global $db; 
  if (is_array($dados)) {
      $arq     = $dados['imagem_carga'];
      $arqx    = explode('.', $arq);
      $tipo    = $arqx[1];
      $evento_id = $dados['evento_id'];
  } else { $evento_id = $dados; $tipo = 'jpg'; }    
//    $arquivo = __DIR__.'/tmp/'.$avatar_id.'.jpg';
  $arquivo = 'tmp/'.$evento_id.'.jpg';
  if(is_file($arquivo)) { 
   if(filesize($arquivo) > 0) {
     $index   = $db->Proximo_Indice_Imagem($evento_id, $resp);
     // $im = file_get_contents($arquivo); 
     $query   = " insert into img_evento (evento_id, img_seq, imagem) 
                  values($evento_id, $index , :imagem);";
     $e = $db->BLOB_IMAGEM($query, $arquivo, $resp);
     if ($e == 2) { $resp->alert('Erro na inclusão da imagem!'); return $resp; }
   }
  }           
//    $resp->alert('Aqui - '.$query.' - '.$arquivo.' - '.$im); return $resp;
  unlink($arquivo);
  $resp->assign("tela_carga","className","esconder");
  $tela_imagem = Visualiza_Fotos($evento_id, $resp);
  $resp->assign("div_foto","innerHTML", $tela_imagem);
  return $resp;
}

function tela_modalidades($evento_id, $titulo_evento = '', $resp)  {
    global $db;
    /*
    CREATE TABLE `modal_evento` (
        `evento_id` int(5) NOT NULL,
        `modal_id` int(3) NOT NULL,
        `limite_inscritos` int(3) DEFAULT NULL
    */    
    if (!$evento_id) {
        $resp->alert('É necessário um evento selecionado!');
        return $resp;
    }
    $telax = '';
    $resul = $db->Monta_lista_Modalidades_Evento($evento_id, $resp);
    if (count($resul) > 0) {
       foreach ($resul as $mod) {
        $modal_id = $mod['modal_id'];
        $nome_modal = $mod['nome_modal'];
        $limite_insc = $mod['limite_inscritos'];
        $telax .= '<div class="row"><input type="text" class="form-control" value="'.$modal_id.'-'.$nome_modal.'"></div>';
       } 
    } 
//    $telax .= '<button class="btn" value="Deu pobrema - '.count($resul).'"></button>'; 
    $tela = '<div class="tab-pane fade in" id="aba2"><h4>Modalidades</h4>
              <form id="tela_modal" name="tela_modal"  role="form" method="POST">
               <input type="hidden" name="evento_id" value="'.$evento_id.'">
               <div class="row">
                 <div class="col-sm-12">
                   <div class="form-group col-sm-5">
                      <label for="evento_id">Código/Nome</label>
                      <input type="text" class="form-control" name="nome" id="nome" value="'.$evento_id.' - '.$titulo_evento.'" readonly>
                   </div>
                 </div>
               </div>
               <br>
               <div class="row">
                  <div class="form-group col-sm-4">
                     <label for="modalidades">Modalidades: </label>
                     '.$telax.'
                  </div>
                  <div class="form-group col-sm-3">
                    <button type="submit" class="btn btn-lg btn-primary" onclick="xajax_Monta_Modal(xajax.getFormValues(\'tela_modal\')); return false;">Atualiza Modalidades</button>
                  </div>                  
                </div>  
                <div id="atu_modal"></div>
             </form></div>';
    return $tela;
    }

function Monta_Modal($dados) {
    $resp = new xajaxResponse();
    global $db;
    $evento_id = $dados['evento_id'];
    $res = $db->Lista_Modalidades($evento_id, $resp);
    $telaz = '<input type="hidden" name="evento_id" value="'.$evento_id.'">
               <div class="row">
                 <div class="col-sm-6">
                <select class="form-control" name="lista[]" multiple size="10">';
   foreach ($res as $mod) {
      $sel    = $mod['selected'];
      $mod_id = $mod['mod_id'];
      $descri = $mod['descri'];
      $telaz .= '<option value="'.$mod_id.'" '.$sel.'>'.$descri.'</option>';
    }
    $telaz .=  '</select>
              </div>
                <div class="col-sm-3">
                  <button type="submit" class="btn btn-primary" onclick="xajax_Salva_Modal(xajax.getFormValues(\'tela_modal\')); return false;">Salva Modalidades</button>
                </div>
                <div class="col-sm-2">
                  <button type="submit" class="btn btn-success" onclick="xajax_Desiste(); return false;">Cancela</button>
                </div>  
              </div></div>';
    $resp->assign('atu_modal', 'innerHTML', $telaz);
//    $script = "$('#multiselect').multiselect();";
//    $script = "$('select').selectpicker();";
//    $resp->script($script);
    return $resp;  
}    

function Desiste() {
    $resp = new xajaxResponse();
    $resp->assign('atu_modal', "innerHTML", '');
    return $resp;  
}    
function Salva_Modal($dados)
{
    $resp = new xajaxResponse();
    global $db;
    $evento_id = $dados['evento_id'];
    $lista = $dados['lista'];
//    $resp->alert('Aqui : '.print_r($lista[0],true)); return $resp; 
    if (count($lista) > 0) {
      $res = $db->Atualiza_modal_evento($evento_id, $lista, $resp);
    }
    $resp->assign('atu_modal', "innerHTML", '');
    $resp->script("xajax_Manut_CRUD($evento_id, 'A');");
    return $resp;
}

function Excluir($id)
{
    $resp = new xajaxResponse();
    global $db;
    $resp->confirmCommands(1, " Confirma exclusão do Registro ($id) ? ");
    $db->Excluir_Registro($id, $resp);
    $resp->script('xajax_Tela_inicial()');

    return $resp;
}

function Gravar($dados)
{
    $resp = new xajaxResponse();
    $oper = $dados['oper'];
//    $resp->alert('Aqui - '.print_r($dados, true));   return $resp;

    if (!$dados['titulo_evento']) {
        $resp->alert('Titulo do Evento deve estar preenchido!');

        return $resp;
    }
    if (!$dados['entidade']) {
        $resp->alert('Falta a Entidade promotora do Evento!');

        return $resp;
    }
    if (!$dados['data_evento']) {
        $resp->alert('Data do Evento de estar preenchida!');

        return $resp;
    }
    global $db;
    if ($oper == 'A') {
        $ret = $db->Alterar_Registro($dados, $resp);
    } else {
        $ret = $db->Incluir_Registro($dados, $resp);
    }
    $resp->script('xajax_Tela_Inicial();');

    return $resp;
}

function Combo_Entidade($entidade, $resp)
{
    global $db;
    if (!$entidade) {
        $entidade = 0;
    }
    $res = $db->Monta_lista_Entidades($entidade, $resp);
    // $ret = print_r($res, true);    return $ret;

    $ret = '<select class="form-control" name="entidade" id="entidade">
             <option value="0" class="form-control">Escolha a Entidade: </option>';
    for ($i = 0; $i < count($res); ++$i) {
        $id = $res[$i]['entidade_id'];
        $nome_entidade = $res[$i]['nome_entidade'];
        $sel = $res[$i]['sel'];
        $ret .= '<option value="'.$id.'" '.$sel.' class="form-control"> '.$nome_entidade.' </option> ';
    }
    $ret .= '</select> ';

    return $ret;
}
