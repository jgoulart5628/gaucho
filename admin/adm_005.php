<?php
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT));
// error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set('default_charset','UTF-8');
require_once '../inc/sessao.php';
$sessao    = new Session; 
include("../inc/Classes_Dados.php");
$db = new getDados_model('MYSQL_deal');
// require("../logar.php");
$usuario    =  $_SESSION['Deal_usuario'];
$id_usuario =  $_SESSION['Deal_id'];
//AJAX
require_once("../xajax/xajax_core/xajax.inc.php");
$xajax = new xajax();
// $xajax->configure('debug',true);
$xajax->register(XAJAX_FUNCTION,"Lista");
$xajax->register(XAJAX_FUNCTION,"Altera");
$xajax->register(XAJAX_FUNCTION,"Cancela");
$xajax->processRequest();
$xajax->configure('javascript URI','../xajax/');
?>

<html>
<head>
  <title> Troca de Senhas </title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link rel=stylesheet href="../css/nain.css" type="text/css">
  <style type="text/css">
 /*   margin: 10em 10em 10em 20em;   margin: 0 0 1em 0; */
     fieldset > div { border: 1px solid gray; padding: 5px;  background-color: white; }
     .dados_pag     { width: 65%; height: 50% }
     fieldset       {  clear: both;  width: 65%;  padding: 0; border: 2px solid #BFBAB0; background-color: #CCFFCC;
                           -moz-box-shadow:5px 5px 5px #666666; -webit-box-shadow:5px 5px 5px #666666;  margin: 10em 10em 10em 20em; }
     legend         {  background-color: #0F95E6; border: 1px outset;  font-weight: bold; }
     fieldset ol    { padding: 0 0 0 0; list-style: none; }
     fieldset li    { padding-bottom: 1em; }
     .submit        { background: #D3D3D3;  height: 25px;  width: 120px; float: left;}
      label         { float: left; font-size: 12px; text-align: right; color: #000080; font-weight: bold; width: 16em; margin-right: 1em;}
     html           { font: small/1.4 "Lucida Grande", Tahoma, sans-serif;  }
     table          {  border-collapse: collapse;  font-size: 10pt; }
#shadow-box { -moz-box-shadow:5px 5px 5px #666666; -webit-box-shadow:5px 5px 5px #666666; background:none repeat scroll 0 0 #CCCCCC;
                           height:auto; margin:15px 0; width:400px; color:#555; font-size:24px; text-align:center; padding:30px; }
 .entra       { color: #000088; border: 1px inset #00008D; background-color: #ADD8E0; height: 20px;}
 fieldset input:focus { border: 2px inset red;}
  </style>
    <script type="text/javascript" src="../js/main.js"></script>
    <script type="text/javascript">
            function chamar(frm) {
            frm.action = '../capa.php';
            frm.target ='conteudo';
            frm.submit();
            frm.action = '../menu.php';
            frm.target ='menu';
            frm.submit();
        }
</script>
    <?php $xajax->printJavascript('../xajax'); ?>
</head>
<body>
    <script type="text/javascript">xajax_Lista('<? echo $usuario; ?>');</script>
    <div id="tela_saida"  class="dados_pag"></div>
    <br>
</body>
</html>

<?php
// Funcoes AJAX
function Lista($usu) {
   $resp = new xajaxResponse();
   $vazio = '&nbsp;';
   $tela  = '<form id="dados_pag" name="altpag">
               <fieldset>
               <legend> Troca de Senha do  Usuário '.$usu.'</legend>
              <ol>
                  <li>
                    <label for="senha_ant">Senha Anterior : </label>
                    <input type="password"  class="entra" id="senha_ant"  name="senha_ant" size="15" maxlength="15" value="">
                  </li>
                  <li>
                    <label for="senha">Nova Senha :</label>
                    <input type="password" class="entra" id="senha"  name="senha" size="15" maxlength="15" value="">
                    &nbsp;Repetir: <input type="password" class="entra" id="senhax"  name="senhax" size="15" maxlength="15" value="">
                  </li>
               </ol>
                 <input type="hidden" name="usuario" value="'.$usu.'">
                 <input type="button"   class="submit" name="Altera" value="Altera" onclick="xajax_Altera(xajax.getFormValues(\'dados_pag\')); return false;">
                 <input type="button"   class="submit" name="Cancela" value="Cancela" onclick="xajax_Cancela(); return false;">
              </fieldset>
             </form>';
   $resp->assign("tela_saida","innerHTML", $tela);
   $script = "document.getElementById('senha_ant').focus()";
   $resp->script($script);
   return $resp;
}

function Cancela () {
    $resp = new xajaxResponse();
    $resp->redirect($_SERVER["PHP_SELF"]);
    return $resp;
}

function Altera($dados) {
     $resp       = new xajaxResponse();
     global  $sessao;
     global  $db;
     $usuario    = $dados['usuario'];
     $senha_ant  = $dados['senha_ant'];
     $senha      = $dados['senha'];
     $senhax    = $dados['senhax'];
     if ($senha_ant)  {
        if (!$senha || !$senhax)   {  $resp->alert("É necessário preencher a senha e repetí-la");  return $resp; }
        if ($senha !== $senhax) {  $resp->alert("As duas senha devem ser iguais, digite novamente.");  return $resp; }
     }
     if ($usuario )   {
        $query       = " select senha, from adm_usuario where codigo = '$usuario' ";
        $resul = $db->Execta_Query_Single($query);
     }  
//     $resp->addAlert(strtoupper($senha_ant).'-'.decode5t($resul['SENHA']).'-'.$query); return $resp;
     if ($senha)  {
        if (sha1($senha_ant) == $resul['senha'] ) { 
           $senha_nova =   sha1($senha); 
        } else { $resp->alert("Senha anterior incorreta!");   return $resp;
         } 
//        $resp->addAlert(strtoupper($senha_ant).'-'.decode5t($resul['SENHA'])); return $resp;
     }
     $query = " update adm_usuario set senha = '$senha_nova'  where usuario = '$usuario' ";
//     $resp->addAlert($query); return $resp;
     $e = $db->Executa_Query_SQL($query);
     if ($e == 2) {
        $resp->alert("Senha nao alterada! ".$query);
     } else   
     	{ $resp->alert("Senha Alterada! Fazer novo Login.");  session_destroy(); 
                 $db->Executa_Query_SQL(" delete adm_sess_login where usuario = '$usuario' ");
                 $resp->script('chamar(document.forms[0])');
     } 

     return $resp;
}
