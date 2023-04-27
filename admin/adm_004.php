<?php
// Liberação de menus por Usuário
// error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
error_reporting(E_ALL);
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set('memory_limit', -1);
ini_set('default_charset', 'UTF-8');
ini_set('display_errors', true);
define('TABELA', 'adm_menus_usuario');
define('ROOT', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
require ROOT.DS.'autoload.php';
$sessao = new sessao();
// Banco de dados
$db = new acesso_db('MYSQL_gaucho');
require_once '../xajax/xajax_core/xajax.inc.php';
$xajax = new xajax();   
//$xajax->configure('deb    ug',true);
$xajax->configure('errorHandler', true);
$xajax->configure('logFile', 'xajax_error.log');
$xajax->register(XAJAX_FUNCTION, 'Tela');
$xajax->register(XAJAX_FUNCTION, 'Monta_Menus_Usuario');
$xajax->register(XAJAX_FUNCTION, 'Atualiza_Permissao');
$xajax->register(XAJAX_FUNCTION, 'Exclui_Menu_Usuario');
$xajax->register(XAJAX_FUNCTION, 'IncMenu');
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
    <title> Liberação- Menus - Usuários </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="JGWeb Software">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Vendor: Bootstrap Stylesheets http://getbootstrap.com -->
    <link rel=stylesheet href="../css/css-treeview.css" type="text/css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Our Website CSS Styles -->
    <link rel="stylesheet" href="../css/style4.css">
    <link rel="stylesheet" href="../css/main.css">
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

    <script type="text/javascript" src="../js/modernizr.js"></script>
    <script type="text/javaScript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javaScript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javaScript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.min.js"></script>
    <script type="text/javaScript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular-route.min.js"></script> 
    <script type="text/JavaScript" SRC="../js/tabelas.js"></script>
    <script type="text/javascript">
        function checkAll(formname, checktoggle)
         {
           var checkboxes = new Array();
           checkboxes = document[formname].getElementsByTagName('input');
            for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type === 'checkbox') {
               checkboxes[i].checked = checktoggle;
            }
        }
     }
/*
          function Checkall(){
            var form = document.forms["tela"];
            for (var i = 0; i < form.elements.length; i++){
                eval("form.elements[" + i + "].checked = false");
            }
        }
        */
    </script>
    <!-- Our Website CSS Styles -->
    <?php $xajax->printJavascript('../xajax'); ?>
</head>
<body class="opaco">
  <form name="tela" id="tela" method="post">
       <div class="container-fluid nova_tela">
         <h3 class="text-muted centro">Liberações Menus</h3>
         <div class="col-sm-12"> 
           <div class="row">
             <div class="col-sm-6">
               <div id="seleca"></div> 
               <hr>
             </div> 
             <div class="col-sm-6">
               <div id="opera"></div> 
               <hr>
             </div> 
          </div>
          <hr>
           <div class="row">
             <div class="col-sm-6">
               <div id="menus_usu" class="fundo"></div> 
             </div> 
             <div class="col-sm-6">
               <div id="menus_disp" class="fundo"></div> 
             </div> 
          </div>
         </div>
         <div class="footer">
            <span class="glyphicon glyphicon-thumbs-up"></span>&#174; JGWeb
        </div>
    </div>
  </form>    
</body>
   <script type="text/javascript" src="../js/treeview.js"></script>
   <script type="text/javaScript">xajax_Tela('') </script>
</html>
<?php

function Tela()
{
    $resp = new xajaxResponse();
    global $db;
    $tela = '<div class="form-group col-sm-4">
                <label for="id_usu">Usuário : </label>';
    $tela .= combo_usuarios($resp);
    $tela .= '</div><div class="col-sm-4"><button type="submit" style="margin-top: 25px;" class="btn btn-primary"   onclick="xajax_Monta_Menus_Usuario(xajax.getFormValues(\'tela\')); return false; " />Montar Menus</button></div>';
    $resp->assign('seleca', 'innerHTML', $tela);

    return $resp;
}

function Exclui_Menu_Usuario($usu, $prog)
{
    $resp = new xajaxResponse();
    global $db;
    $query = " delete from adm_menus_usuario
                where id_usuario  ='".$usu."'
                  and id_menu     = ".$prog;
    $e = $db->Executa_Query_SQL($query, $resp);
    if ($e == 2) {
        $resp->alert('Erro no SQL: '.$query);

        return $resp;
    }
    $dados = 'X-'.$usu;
    $script = "xajax_Monta_Menus_Usuario('$dados');";
    $resp->script($script);

    return $resp;
}

function Monta_Menus_Usuario($dados)
{
    $resp = new xajaxResponse();
    if (!is_array($dados)) {
       if (substr($dados, 0, 1) === 'X') {
          $dad = explode('-', $dados);
          $id_usu = $dad[1];
       }   
    } else {
        $id_usu = $dados['id_usu'];
    }
    if (!is_numeric($id_usu)) {
        $resp->alert('É necessárioo escolher um usuário! '.$id_usu);

        return $resp;
    }
    $result = leitura_menu($id_usu, $resp);
    $tela = '<div><label>Menus em uso : </label></div><div><ul id="tree_menu" class="treeview">';
    $sis_ant = '';
    $id_lst = -1;
    $prog_class = [];
    $nome_class = [];

    for ($i = 0; $i < count($result); ++$i) {
        $sis = $result[$i]['rotina'];
        $nome_menu = $result[$i]['nome_menu'];
        $arq = $result[$i]['arquivo'];
        $id_menu = $result[$i]['id_menu'];
        $prog = $result[$i]['id'];
        $check_insert = '';
        $check_update = '';
        $check_delete = '';
        $db_insert = $result[$i]['db_insert'];
        if ($db_insert) {
            $check_insert = ' checked="checked" ';
        }
        $db_update = $result[$i]['db_update'];
        if ($db_update) {
            $check_update = ' checked="checked" ';
        }
        $db_delete = $result[$i]['db_delete'];
        if ($db_delete) {
            $check_delete = ' checked="checked" ';
        }
        if ($sis != $sis_ant) {
            if ($i > 0) {
                for ($x = 0; $x < count($prog_class); ++$x) {
                    $tela .= '<li class="treeviewFolderLi" style="margin-left:0px; width:98%">
                                  <label style="display:inline-block; width:300px;"><img src="../img/document.gif">**'.$nome_class[$x].'-'.$prog_class[$x].'**</label>
                                  <label style="display:inline-block; width:020px;"><img src="../img/x.jpg" onclick="xajax_Exclui_Menu_Usuario(\''.$id_usu.'\','.$prog_class[$x].'); return false;" border="0px" height="16px" whidt="16px"></label>
                                </li>';
                }
                //encerra lista
                $tela .= '</ul>';
                //limpa variaveis
                $prog_class = [];
                $nome_class = [];
            }

            $tela .= '<li class="treeviewFolderLi" style="margin-left:0px;">
                            <img id="objTreeCollapserX'.$i.'" src="../img/expander.gif" style="visibility:show"
                                 onclick="treeviewExpandCollapse(\'X'.$i.'\');">
                            <img id="folderX'.$i.'" src="../img/folder.gif"
                                 ondblclick="treeviewExpandCollapse(\'X'.$i.'\');">
                            <span ondblclick="treeviewExpandCollapse(\'X'.$i.'\');"
                                  onselectstart="return false;"> '.$sis.'</span>
                        </li>
                        <ul id="objTreeULX'.$i.'" class="treeviewFolderUl" style="display: none">';
            $sis_ant = $sis;
        }

        if ($result[$i]['classificacao'] == 2) {
            //adiciona lista de programas sem menu
            array_push($prog_class, $result[$i]['rotina']);
            array_push($nome_class, $result[$i]['nome_menu']);
        } else {
            //programas normais
            $tela .= '<li class="treeviewFolderLi" style="margin-left:5px; width:98%">
                        <label style="display:inline-block; width:300px;"> <img src="../img/document.gif">&nbsp;&nbsp;'.$nome_menu.'</label>
                        <label style="display:inline-block; width:250px;">
                          <input type="checkbox" name="db_insert" id="db_insert" value="'.$db_insert.'" onchange="xajax_Atualiza_Permissao(\''.$id_usu.'\','.$prog.',\'db_insert\','.$db_insert.'); return false;" '.$check_insert.'> Insert
                          <input type="checkbox" name="db_update" id="db_update" value="'.$db_update.'" onchange="xajax_Atualiza_Permissao(\''.$id_usu.'\','.$prog.',\'db_update\','.$db_update.'); return false;" '.$check_update.'> Update
                          <input type="checkbox" name="db_delete" id="db_delete" value="'.$db_delete.'" onchange="xajax_Atualiza_Permissao(\''.$id_usu.'\','.$prog.',\'db_delete\','.$db_delete.'); return false;" '.$check_delete.'> Delete
                        </label>
                        <label style="display:inline-block; width:030px;"><img src="../img/x.jpg" onclick="xajax_Exclui_Menu_Usuario(\''.$id_usu.'\','.$prog.'); return false; " border="0px" height="16px" whidt="16px">Excluir</label>
                      </li>';
        }
    }

    for ($i = 0; $i < count($prog_class); ++$i) {
        $tela .= '<li class="treeviewFolderLi" style="margin-left:0px; width:98%">
                      <label style="display:inline-block; width:300px;"><img src="../img/document.gif">**'.$nome_class[$i].'-'.$prog_class[$i].'**</label>
                      <label style="display:inline-block; width:020px;"><img src="../img/x.jpg" onclick="xajax_ExcluiMenu_Usuario(\''.$id_usu.'\','.$prog_class[$i].'); return false;" border="0px" height="16px" whidt="16px"></label>
                    </li>';
    }
    $tela .= '</ul><hr></div>';
    $resp->assign('menus_usu', 'innerHTML', $tela);
    //  fim tela da esquerda
    //  tela direita
    $result = leitura_opcoes($id_usu, $resp);
    $tela = '<div><label>Menus Disponíveis : (clique para marcar/desmarcar)</label></div><div><ul id="objtree" class="treeview">';
    $sis_ant = '';
    $vez = 0;
    if (is_array($result)) {
        $conta = count($result);
    } else {
        $conta = -1;
    }
    for ($i = 0; $i < $conta; ++$i) {
        $sis = $result[$i]['rotina'];
        $nome = $result[$i]['nome_menu'];
        $arq = $result[$i]['arquivo'];
        $prog = $result[$i]['id'];
        $id_usuario = $result[$i]['id_usuario'];
        if ($id_usuario) {
            $marca = 'checked="checked"';
        } else {
            $marca = ' ';
        }

        if ($result[$i]['classificacao'] == 2) {
            $nome = '**'.$nome.'**';
        }

        if ($sis != $sis_ant) {
            if ($i > 0) {
                $tela .= '</ul>';
            }
            $tela .= '<li class="treeviewFolderLi">
                            <img id="objTreeCollapser'.$i.'" src="../img/expander.gif" style="visibility:show"
                                 onclick="treeviewExpandCollapse(\''.$i.'\');">
                            <img id="folder'.$i.'"
                                 src="../img/folder.gif"
                                 ondblclick="treeviewExpandCollapse(\''.$i.'\');">
                            <span ondblclick="treeviewExpandCollapse(\''.$i.'\');"
                                  onselectstart="return false;"> '.$sis.'</span>
                        </li>
                        <ul id="objTreeUL'.$i.'" class="treeviewFolderUl" style="display: none">';
            $sis_ant = $sis;
            $obj = $i;
        }
        $tela .= '<li class="treeviewFolderLi" style="margin-left: 18px;">
                        <input type="checkbox" name="prog[]" value="'.$prog.'"  '.$marca.'>
                        <img src="../img/document.gif">'.$nome.' - '.$arq.'
                    </li>';
    }
    $tela .= '</ul><hr></div><div>
              <a href="#"  class="btn btn-danger" style="text-decoration: none;"  onClick="checkAll(\'tela\',true);"> Marcar todos </a>
              <a href="#"  class="btn btn-warning" style="text-decoration: none;"  onClick="checkAll(\'tela\',false);"> Desmarcar todos </a>
              <button type="submit" class="btn btn-primary"  onclick="xajax_IncMenu(xajax.getFormValues(\'tela\'),\''.$id_usu.'\'); return false;">Gravar</button></div>';
//                            <a href="#"   style="text-decoration: none;"  onClick="treeviewExpandAll (\'\');">Expandir todos</a>
    //            <a href="#" class="btn btn-success" style="text-decoration: none;" onClick="treeviewCollapseAll (\'\');"> Encolher todos </a>

    $resp->assign('menus_disp', 'innerHTML', $tela);

    return $resp;
}

function IncMenu($dados, $usu)
{
    $resp = new xajaxResponse();
    global $db;
//    $resp->alert('Aqui - '.count($form['prog']).' - '.$usu); return $resp;
    foreach ($dados['prog'] as $prog) {
        $query = " select 1 from adm_menus_usuario
                    where id_usuario  =  $usu and id_menu = $prog ";
        $existe = $db->Executa_Query_Nrows($query, $resp);
        // verifica se já existe o menu
//        $resp->alert('Aqui - '.$existe.' - '.$usu.' - '.$prog);
        if ($existe == 0) {
            $query = " Insert into adm_menus_usuario (id_usuario, id_menu , db_insert, db_update, db_delete)
                       values ($usu , $prog, 1, 1, 1) ";
            $e = $db->Executa_Query_SQL($query, $resp);
            if ($e == 2) {
                $resp->alert('Erro no SQL: '.$query);

                return $resp;
            }
        }
    }
    $resp->alert('Registros de Menu do usuário alterados. Faça novo login para utilizar.');
    $dados = 'X-'.$usu;
    $script = "xajax_Monta_Menus_Usuario('$dados');";
    $resp->script($script);

    return $resp;
}

function leitura_opcoes($id_usu, $resp)
{
    global $db;
    $sit = '3,2,1,0';
    $query = "select distinct a.id_rotina,  a.funcionalidade, a.nome_menu, a.arquivo,  a.id, a.classificacao, b.id_menu,  b.id_usuario,
               c.rotina, b.db_insert, b.db_update, b.db_delete
                 from adm_menus a
                    left join 
                      adm_menus_usuario b     
                      on b.id_menu = a.id
                      and b.id_usuario = $id_usu
                , adm_rotinas c
               where a.id_rotina = c.id
                and  a.classificacao   in ($sit)
             order by c.rotina, a.nome_menu ";
    $result = $db->Executa_Query_Array($query, $resp);

    return $result;
}

function Atualiza_Permissao($id_usu, $id_menu, $tipo, $valor)
{
    $resp = new xajaxResponse();
    //  $resp->alert('Aqui - '.$id_usu.' - '.$id_menu.' - '.$tipo.' - '.$valor);     return $resp;
    global $db;
    if ($tipo == 'db_insert') {
        if ($valor == 1) {
            $db_insert = 0;
        } else {
            $db_insert = 1;
        }
        $qq = " db_insert = $db_insert ";
    }
    if ($tipo == 'db_update') {
        if ($valor == 1) {
            $db_update = 0;
        } else {
            $db_update = 1;
        }
        $qq = " db_update = $db_update ";
    }
    if ($tipo == 'db_delete') {
        if ($valor == 1) {
            $db_delete = 0;
        } else {
            $db_delete = 1;
        }
        $qq = " db_delete = $db_delete ";
    }

    $query = ' update adm_menus_usuario set
               '.$qq."  
         where id_usuario = $id_usu and id_menu = $id_menu ";
    $e = $db->Executa_Query_SQL($query, $resp);
    if ($e == 2) {
        $resp->alert('Erro no SQL: '.$query);

        return $resp;
    }
}

function leitura_menu($id_usu, $resp)
{
    global $db;
    $qry = " select distinct aa.id_usuario, aa.id_menu, aa.db_insert, aa.db_update, aa.db_delete,
               bb.id_rotina, bb.arquivo, bb.nome_menu, bb.id, bb.funcionalidade,  bb.classificacao, cc.rotina, bb.id
              from adm_menus_usuario aa, adm_menus bb, adm_rotinas cc
             where aa.id_menu = bb.id 
               and  bb.id_rotina = cc.id
               and  id_usuario = $id_usu
               order by cc.rotina, bb.nome_menu ";
    $result = $db->Executa_Query_Array($qry, $resp);

    return $result;
}

function le_usuarios($resp)
{
    global $db;
    $qry = 'select id, codigo  from adm_usuario   order by codigo ';
    $result = $db->Executa_Query_Array($qry, $resp);

    return $result;
}

function combo_usuarios($resp)
{
    $res = le_usuarios($resp);
    $ret = '<select class="form-control" name="id_usu" id="id_usu" required="required" > <option value ="" ></option> ';
    $sel = '';
    for ($i = 0; $i < count($res); ++$i) {
        $usuario = $res[$i]['codigo'];
        $id_usu = $res[$i]['id'];
//          if ($xcodigo == $tipopessoa) { $sel = ' selected '; } else { $sel = ''; }
        $ret .= '<option value="'.$id_usu.'"  class="f_texto"> '.$usuario.' </option> ';
    }
    $ret .= '</select> ';

    return $ret;
}
