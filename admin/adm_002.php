<?php
// cadastro e manutenção de Menus
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
//error_reporting(E_ALL);
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set('memory_limit', -1);
ini_set('default_charset', 'UTF-8');
ini_set('display_errors', true);
define('TABELA', 'adm_menus');
define('ROOT', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
require ROOT.DS.'autoload.php';
$sessao = new sessao();
// Banco de dados
$db = new banco_Dados(DB);
require_once '../xajax/xajax_core/xajax.inc.php';
$xajax = new xajax();
$xajax->configure('errorHandler', true);
$xajax->configure('logFile', 'xajax_error.log');
$xajax->register(XAJAX_FUNCTION, 'Tela');
$xajax->register(XAJAX_FUNCTION, 'Lista');
$xajax->register(XAJAX_FUNCTION, 'Alterar');
$xajax->register(XAJAX_FUNCTION, 'Gravar');
$xajax->register(XAJAX_FUNCTION, 'valida_nome');
$xajax->register(XAJAX_FUNCTION, 'valida_nome_completo');
$xajax->register(XAJAX_FUNCTION, 'Excluir');
$xajax->register(XAJAX_FUNCTION, 'Limpar');
$xajax->register(XAJAX_FUNCTION, 'Recarrega');
// $xajax->configure('debug',true);
$xajax->processRequest();
$xajax->configure('javascript URI', '../xajax/');
// <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
    <!-- Meta-Information -->
    <title> Cadastro - Menus </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="JGWeb Software">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Vendor: Bootstrap Stylesheets http://getbootstrap.com -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Our Website CSS Styles -->
    <link rel="stylesheet" href="../css/style4.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/tela_nova.css">
    <script type="text/javascript" src="../js/main.js"></script>
    <script type="text/javascript" src="../js/modernizr.js"></script>
    <script type="text/javaScript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javaScript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javaScript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.min.js"></script>
    <script type="text/javaScript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular-route.min.js"></script> 
    <!-- Our Website CSS Styles -->
    <script type="text/javascript">
    function tabela() {  
        $('#tabclas').dataTable( 
           { "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, 'Todos']], 
             "language":  {"url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json" },
             "order": [[ 2, 'asc' ]]
           }
         );
    }
    </script>
    <?php $xajax->printJavascript('../xajax'); ?>
</head>
<body class="opaco">
    <form name="tela" id="tela" class="form" method="post">
     <div class="container-fluid" style="padding-top: 10px;" >  
          <div id="tela_carga"></div> 
     </div>     
     <div class="footer">
          <span class="glyphicon glyphicon-thumbs-up"></span>&#174; JGWeb
     </div>
   </form>
 </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>  
    <script type="text/javaScript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javaScript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" ></script>
    <script type="text/javaScript">xajax_Tela() </script>
</html>
<?php

function Tela($dados = '', $id_rotina = '', $nome_menu = '')
{
    $resp = new xajaxResponse();
    if (!$id_rotina) {
        $id_rotina = 1;
    }
    $form = '<div class="col-sm-12 tela_nova">
                <h3 class="text-muted centro"> Cadastro de Menus do Usuário</h3>
                <div class="col-sm-3">
                     <label for="id_rotina" name="id_rotina">Rotina : </label>
                        '.combo_rotina($id_rotina, $resp).'
                </div>      
                <div class="col-sm-6">
                     <button type="submit" class="btn btn-primary" onclick="xajax_Lista(xajax.getFormValues(\'tela\')); return false;">Consultar</button>
                     <button type="submit" class="btn btn-primary" onclick="xajax_Alterar(xajax.getFormValues(\'tela\'),\'I\'); return false;">Novo Menu</button>
                     <button type="submit" class="btn btn-primary" onclick="Saida(\'adm_003.php\'); return false;">Cadastro Rotinas</button>
                </div>
             </div>
             <br>
             <div id="tela_dados"></div>';
         $script = "document.getElementById('id_rotina').focus()";
    $resp->assign('tela_carga', 'innerHTML', $form);
    $resp->script($script);

    return $resp;
}

// Funcoes AJAX

function Lista($dados)
{
    $resp = new xajaxResponse();
    $id_rotina = $dados['id_rotina'];
//    $resp->alert('Aqui - '.print_r($dados, true));     return $resp;
    global   $db;
    $query = ' SELECT distinct  id_rotina, nome_menu, funcionalidade,  observacao, classificacao, indisponivel, indisponivel_msg, icone, arquivo, id ';
    $query .= "  FROM adm_menus where id_rotina = $id_rotina order by  nome_menu ";
    $rset = $db->Executa_Query_Array($query);
    if (is_array($rset)) {
        $reg = count($rset);
    } else {
        $reg = 0;
        $id_menu = 0;
    }
    if ($reg == 0) {
        $resp->alert('Nenhum menu cadastrado, use o botão Novo Menu.');

        return $resp;
    }
    // else {    }
    //   if ($reg > 0) {
//       foreach ($rset as $resul) {
//         $prog = ( $prog + $resul["QTD"] );
//    } }
//            . '<b>Total de Programas Selecionados : '.$reg.' (utilizando '.$prog.' arquivos).</b>';
    $oper = "'A'";
    $tela = '<div class="container-fluid table-responsive tela_nova">
              <table id="tabclas" data-toggle="table" class="table table-striped table-bordered">
       	        <thead>
                <tr align="center">
                  <th> Nome Menu </th>
                  <th> Funcionalidade </th>
                  <th> Observação </th>
                  <th> Classificação </th>
                  <th> Indisponível </th>
                  <th> Msg.Indisponível </th>
                  <th> Icone </th>
                  <th> Arquivo </th>
                </tr></thead><tbody>';
    for ($i = 0; $i < $reg; ++$i) {
//            id_rotina, nome_menu,  funcionalidade,  observacao, classificacao, indisponivel, indisponivel_msg, icone, arquivo, id
        $id_rotina = $rset[$i]['id_rotina'];
        $nome_menu = $rset[$i]['nome_menu'];
        $funciona = $rset[$i]['funcionalidade'];
        $observ = $rset[$i]['observacao'];
        $class = $rset[$i]['classificacao'];
        $indisp = $rset[$i]['indisponivel'];
        $indisp_msg = $rset[$i]['indisponivel_msg'];
        $icone = $rset[$i]['icone'];
        $arquivo = $rset[$i]['arquivo'];
        $id_menu = $rset[$i]['id'];
        $tela .= '<tr>
                        <td align="left"><button type="submit"  class="btn btn-primary"  onclick="xajax_Alterar('.$id_menu.',\'A\'); return false;">'.$nome_menu.'</button></td>
                        <td> '.$funciona.' </td>
                        <td> '.$observ.' </td>
                        <td> '.cmb_class($class).' </td>
                        <td> '.cmb_indisponivel($indisp).' </td>
                        <td> '.$indisp_msg.' </td>
                        <td> '.$icone.' </td>
                        <td> '.$arquivo.' </td>
                    </tr>  ';
    }
    $tela .= '</tbody></table><input type="hidden" name="id_menu" value="'.$id_menu.'"></div>';
    $resp->assign('tela_dados', 'innerHTML', $tela);
    $resp->script('tabela()');

    return $resp;
}

function Alterar($id_menu, $oper)
{
    $resp = new xajaxResponse();
//    $resp->alert('Opaaa  '.$id_menu); return $resp;
    $tela = monta_form($id_menu, $oper, $resp);
    $script = "document.getElementById('nome_menu').focus()";
    $resp->assign('tela_dados', 'innerHTML', $tela);
    $resp->script($script);

    return $resp;
}

function Limpar()
{
    $resp = new xajaxResponse();
    $resp->assign('tela_dados', 'innerHTML', ' ');
    $resp->script("xajax_Tela('','','');");

    return $resp;
}

function Recarrega()
{
    $resp = new xajaxResponse();
    $resp->redirect($_SERVER['PHP_SELF']);

    return $resp;
}

function monta_form($id_menu, $oper, $resp)
{
    if ($oper === 'A') {
        global $db;
        $query = " Select * from adm_menus where id = $id_menu ";
        $rset = $db->Executa_Query_Single($query);
        $id_rotina = $rset['id_rotina'];
        $nome_menu = $rset['nome_menu'];
        $funciona = $rset['funcionalidade'];
        $obs = $rset['observacao'];
        $class = $rset['classificacao'];
        $inds = $rset['indisponivel'];
        $msg_inds = $rset['indisponivel_msg'];
        $icone = $rset['icone'];
        $arq = $rset['arquivo'];
        $id = $rset['id'];
    } else {
        $nome_menu = '';
        $funciona = '';
        $obs = '';
        $class = 0;
        $inds = 0;
        $msg_inds = '';
        $icone = '';
        $arq = '';
    }
    //  $resp->alert('Opaaa  '.$funciona.' - '.$nome_menu.'-'.$oper);

    $tela = '<div class="col-sm-12 tela_nova">
               <div class="row">
                <div class="form-group col-lg-4">
                    <label for="nome_menu">Programa</label>
                    <input type="text" name="nome_menu" id="nome_menu" class="form-control"  value="'.$nome_menu.'" onblur="blur_nome(this);" onchange="xajax_valida_nome(xajax.getFormValues(\'tela\')); return false;">
                </div> 
                <div class="form-group col-lg-4">
                    <label for="funcio">Funcionalidade</label>
                    <textarea name="funcionalidade" id="funcio" rows="3" class="form-control" >'.$funciona.'</textarea>
                </div>   
              </div> 
              <div class="row">
               <div class="form-group col-lg-4">
                    <label for="indisp">Disponível : </label>
                    '.cmb_indisponivel($ind).'
                     Msg indisp. <input type="text" name="msg" id="msg" class="form-control" value="'.$msg.'">
                </div>  
               <div class="form-group col-lg-4">
                    <label for="obs">Observação</label>
                    <textarea name="observacao" id="obs" rows="3"  class="form-control" >'.$obs.'</textarea>
               </div>
              </div>         
              <div class="row">
                  <div class="form-group col-lg-4">
                     <label for="class">Classificação</label>
                    '.cmb_class($class).'
                  </div>
                  <div class="form-group col-lg-4">
                    <label for="arqs">Arquivo </label>
                    <input type="text"  name="arq"  value="'.$arq.'" class="form-control">
                  </div>
               </div>
               <div class="row">
                 <div class="form-group col-lg-4">
                   <input type="hidden" name="oper" value="'.$oper.'">
                   <input type="hidden" name="id_menu" value="'.$id_menu.'">
                   <button type="submit"  class="btn btn-lg btn-block btn-primary"  onclick="xajax_Gravar(xajax.getFormValues(\'tela\')); return false;"> Gravar</button>
                   <button type="submit"  class="btn btn-lg btn-block btn-success"  onclick="xajax_Limpar(); return false;">Desistir</button>
                   <button type="submit"  class="btn btn-lg btn-block btn-danger"  onclick="xajax_Excluir(\''.$id_menu.'\');return false;">Excluir</button>
                </div> 
              </div></div>';

    return  $tela;
}

function valida_nome($dados)
{
    $resp = new xajaxResponse();
    $nome_menu = $dados['nome_menu'];
//    $resp->addAlert($nome); return $resp;
    // Nome
    global $db;
    $query = " SELECT nome_menu FROM adm_menus  WHERE nome_menu = '$nome_menu' ";
    $result = $db->Executa_Query_Unico($query);
    if ($result) {
        $msg = ' Este Nome Menu ['.$nome_menu.'] já está em uso no Programa '.$result;
        $resp->alert($msg);
        $resp->assign('nome_menu', 'value', ' ');
        $script = "document.getElementById('nome_menu').focus()";
        $resp->script($script);
    }

    return $resp;
}

function Gravar($form)
{
    $respo = new xajaxResponse();
    $id_rotina = $form['id_rotina'];
    $nome_menu = trim($form['nome_menu']);
    $funciona = $form['funcionalidade'];
    $observ = $form['observacao'];
    $class = $form['classificacao'];
    $ind = $form['indisponivel'];
    $msg = $form['msg'];
    $icone = $form['icone'];
    $arq = $form['arq'];
    $oper = $form['oper'];
    $id_menu = $form['id_menu'];
    $usuario = strtoupper($_SESSION['Deal_usuario']);
//            id_rotina, nome_menu, funcionalidade,  observacao, classificacao, indisponivel, indisponivel_msg, icone, arquivo, id
    // ignora erro de arquivos
    //   $respo->addAlert($raiz[0]); return $respo;
    $erro = '';
    if (!$funciona) {
        $erro = 'Preencha a funcionalidade do Menu!';
    }
    if ($id_rotina === 0) {
        $erro = 'Escolha uma rotina para o Menu!';
    }
    if (!$nome_menu) {
        $erro = 'Preencha o nome do Menu!';
    }
//    if (!$obs)       $erro = 'Preencha a Observa��o!';

    if (strpos($arquivo, '.php') !== false) {
        if (substr($arquivo, 0, 4) != 'http') {
            $arq1 = $_SERVER['DOCUMENT_ROOT'].'/'.trim($arquivo);
            if (!file_exists($arq1)) {
                $erro = 'O arquivo ['.trim($arq1).'] não existe no local indicado.';
            }
        }
    }
    if ($erro) {
        $respo->alert('Atenção: '.$erro);

        return $respo;
    }
    global $db;

    if ($oper == 'A') {
        $query = " UPDATE adm_menus
                     SET id_rotina      = $id_rotina
                       , nome_menu      = '$nome_menu'
                       , funcionalidade = '$funciona'
                       , observacao     = '$observ'
                       , classificacao  = $class
                       , indisponivel   = $ind
                       , indisponivel_msg = '$msg'
                       , icone          = '$icone'
                       , arquivo        = '$arq'
                   WHERE id  =  $id_menu ";
    } else {
        $id_menu = $db->Executa_Query_Unico('select  ifnull((max(aa.id) + 1),1) from adm_menus aa');
        $query = " INSERT INTO adm_menus (id_rotina, nome_menu, funcionalidade,  observacao, classificacao, indisponivel, indisponivel_msg, icone, arquivo, id )
                    VALUES
                       ($id_rotina, '$nome_menu','$funciona','$obs',  $class, $ind, '$msg', '$icone', '$arq', $id_menu )";
    }
    //( select  ifnull((max(aa.id) + 1),1) from rotinas aa)
    //Executa Comando
    $e = $db->Executa_Query_SQL($query, $resp);
    if ($e == 2) {
        $erro = 'Erro na inclusão do programa '.$query;
        $respo->alert($erro);

        return $respo;
    }

    // chegou aqui é sucesso
    $respo->assign('tela_dados', 'innerHTML', '');
    $respo->script("xajax_Lista('')");

    return $respo;
}

function Excluir($id_menu)
{
    $resp = new xajaxResponse();
    global $db;
    $query = " delete From adm_menus where id = $id_menu ";
    $e = $db->Executa_Query_SQL($query, $resp);
    if ($e == 2) {
        $resp->alert('Erro excluido Menu, verifique o SQL: '.$query);

        return $resp;
    }
    $resp->script('xajax_Tela()');

    return $resp;
}

function cmb_class($class)
{
    if (!$class) {
        $class = 0;
    }
    $opc[0] = 'Disponível para o Menu de Todos Usuários';
    $opc[1] = 'Disponível apenas para ADMIN';
    $opc[2] = 'Não disponível para Menu';
    $opc[3] = 'Bloqueio Especial';

    $ret = ' <select name="classificacao" class="form-control"> ';
    for ($a = 0; $a < count($opc); ++$a) {
        if ($a == $class) {
            $sel = ' Selected';
        } else {
            $sel = '';
        }
        $ret .= ' <option value="'.$a.'"'.$sel.'>'.$opc[$a].'</option>';
    }
    $ret .= '</select>';

    return $ret;
}

function cmb_indisponivel($ind)
{
    if (!$ind) {
        $ind = 0;
    }
    if ($ind == 0) {
        $check0 = ' checked ';
    } else {
        $check0 = '';
    }
    if ($ind == 1) {
        $check1 = ' checked ';
    } else {
        $check1 = '';
    }
    $ret = '<input type="radio" id="indisp"  name="indisponivel" value="0" '.$check0.'>Sim&nbsp;
          <input type="radio" id="indisp"  name="indisponivel" value="1" '.$check1.'>Não&nbsp;&nbsp;&nbsp;';

    return $ret;
}

function combo_rotina($id_rotina, $resp = '')
{
    $query = ' SELECT id, rotina from adm_rotinas order by id ';
    global $db;
    $rset = $db->Executa_Query_Array($query, $resp);
    $reg = count($rset);
    $ret = '<select class="form-control" name="id_rotina" id="id_rotina">';
    $sel = '';
    for ($i = 0; $i < $reg; ++$i) {
        if (is_numeric($id_rotina)) {
            if ($rset[$i]['id_rotina'] == $id_rotina) {
                $sel = ' selected ';
            } else {
                $sel = '';
            }
        }
        $ret .= '<option value="'.$rset[$i]['id'].'"'.$sel.' class="form-control"> '.$rset[$i]['rotina'].' </option> ';
    }
    $ret .= '</select> ';

    return $ret;
}
