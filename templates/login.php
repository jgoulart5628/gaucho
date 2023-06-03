<?php
   session_start();
//   header('Cache-control: private, no-cache');
   header('Expires: Mon, 26 Jun 1997 05:00:00 GMT');
   ini_set('date.timezone', 'America/Sao_Paulo');
   ini_set('memory_limit', -1);
   ini_set('default_charset', 'UTF-8');
   ini_set('display_errors', true);
// $header = Header("Pragma: no-cache");
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
define('ROOT', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
require ROOT.DS.'autoload.php';
// Session;
$sessao = new sessao();
$db = new banco_Dados('MYSQL_gaucho');
$sessao->nova();
$sessao->set('Gaucho_usuario', '');
$sessao->set('Gaucho_id', '');
$sessao->set('Gaucho_nivel', '');
$sessao->set('Gaucho_entidade', '');
$sessao->set('login_conectado', '');
setcookie('GAUCHO', '', time() - 7200);
$query = " select id, codigo from adm_usuario where email like '%@%' order by 1 ";
$res = $db->Executa_Query_Array($query);
$telax = '<select name="usuario" class="form-control"><option selected value="eu" selected ></option>';
foreach ($res as $pes) {
    $telax .= '<option  value="'.$pes['codigo'].'" >'.$pes['codigo'].'</option>';
}
$telax .= '</select>';
require_once '../xajax/xajax_core/xajax.inc.php';
$xajax = new xajax();
$xajax->configure('errorHandler', true);
$xajax->configure('logFile', 'xajax_error.log');
$xajax->register(XAJAX_FUNCTION, 'Valida');
$xajax->processRequest();
$xajax->configure('javascript URI', '../xajax/');

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- SmartMenus core CSS (required) -->
     <link rel="stylesheet" href="../css/bootstrap.min.css">
     <link rel="stylesheet" href="../css/all.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="../css/style4.css">

    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>

    <script defer src="https://use.fontawesome.com/releases/v5.5.0/js/all.js" integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0" crossorigin="anonymous"></script>
    <!--script type="text/javascript" src="js/deal.js"></script -->
    <!-- "sm-blue" menu theme (optional, you can use your own CSS, too) -->
    <?php $xajax->printJavascript('../xajax'); ?>
  </head>

  <body>
   <form id="geral"  name="geral" class="opaco" method="post"> 
       <div id="modal">
          <div class="modal-dialog modal-login">
	        <div class="modal-content caixa-sombra">
               <div class="modal-header">				
		         <h3 class="modal-title"><b>Gaucho Login</b></h3>
               </div>
		       <div class="modal-body">
		          <div class="form-group"><i class="fa fa-user"></i><?php echo $telax; ?></div>
                  <div class="form-group"><i class="fa fa-lock"></i>
	                  <input type="password" name="senha" class="form-control" placeholder="Senha" required="required">			
                  </div>
		          <div class="form-group">
   		            <input type="submit" class="btn btn-primary btn-block btn-lg" value="Entrar" onclick="xajax_Valida(xajax.getFormValues('geral')); return true;">
       	          </div>
       	       </div>
        	   <div class="modal-footer">
                  <span class="glyphicon glyphicon-thumbs-up"></span>&#174; JGWeb
               </div>
            </div>
         </div>
      </div> 
    </form>
    <!-- /.row -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
 </body>
</html>
<?php

function Valida($dados)
{
    $resp = new xajaxResponse();
    $usuario = $dados['usuario'];
    $senha = $dados['senha'];
    if (!$usuario) {
        $resp->alert(' Escolha um usuário para autenticar');

        return $resp;
    }
    if (!$senha) {
        $resp->alert(' Preencha a senha! ');

        return $resp;
    }
    global $sessao;
    global $db;
    $query = " select * from adm_usuario where codigo = '$usuario' ";
    $resul = $db->Executa_Query_Single($query);
    $id = $resul['id'];
    $usuario = $resul['codigo'];
    $nivel = $resul['nivel'];
    $entidade = $resul['entidade'];
    $pass = trim($resul['senha']);
    if ($pass !== sha1($senha)) {
        $resp->alert(' Senha incorreta! ');
        return $resp;
    }
    $sessao->nova();
    setcookie('Gaucho', $usuario, date('Ymd'), time() + (60 * 60 * 24 * 30));  /* expira em 10 horas */
    $sessao->set('Gaucho_usuario', $usuario);
    $sessao->set('Gaucho_id', $id);
    $sessao->set('Gaucho_nivel', $nivel);
    $sessao->set('Gaucho_entidade', $entidade);
    $sessao->set('login_conectado', '1');
    $sessid = session_id();
//     $sessidx = "'".$sessid."'";
    $sessao->set('sessao', $sessid);
    $usuario = $sessao->get('Gaucho_usuario');
    $usuario_id = $sessao->get('Gaucho_id');
    $query = " delete from adm_sess_login  where usuario_id = $usuario_id ";
    $e = $db->Executa_Query_SQL($query);
    if ($e == 2) {
        $resp->alert('Erro limpando login : '.$query);
        return $resp;
    }
    $data = date('Y-m-d G:i');
    $unico = mt_rand();
    $query = " insert into adm_sess_login values ($usuario_id, '$sessid', '$data', $unico) ";
    $e = $db->Executa_Query_SQL($query, $resp);
    if ($e == 2) {
        $resp->alert('Erro inserindo login : '.$query);
        return $resp;
    }
    $resp->alert($sessid.'-'.$usuario.' - '.$query.'-'.$e.'-'.$_SERVER);
//    header('location: ../index_teste.php');
//    $resp->redirect($_SERVER['../index_teste.php']);
    //    $resp->alert(print_r($_SESSION, true));
//     $resp->script('xajax_Menu();');

    return $resp;
}
