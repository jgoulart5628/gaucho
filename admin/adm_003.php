<?php
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
//error_reporting(E_ALL);
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set('memory_limit', -1);
ini_set('default_charset', 'UTF-8');
ini_set('display_errors', true);
define('TABELA', 'adm_rotinas');
define('ROOT', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
require ROOT.DS.'autoload.php';
$sessao = new sessao();
// Banco de dados
$db = new banco_Dados(DB);
require_once '../xajax/xajax_core/xajax.inc.php';
$xajax = new xajax();
//$xajax->configure('debug',true);
$xajax->register(XAJAX_FUNCTION, 'Tela');
$xajax->register(XAJAX_FUNCTION, 'Lista');
$xajax->register(XAJAX_FUNCTION, 'Alterar');
$xajax->register(XAJAX_FUNCTION, 'Gravar');
$xajax->register(XAJAX_FUNCTION, 'Excluir');
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
    <title> Cadastro - Rotinas </title>
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
    <!-- Our Website CSS Styles -->
    <?php $xajax->printJavascript('../xajax'); ?>
</head>
<body class="opaco">
    <form name="tela" id="tela" method="post">
    <div class="container-fluid" style="width: 80%; padding-top: 10px;" >  
          <div id="tela_dados"></div> 
    </div>     
    <div class="footer">
       <span class="glyphicon glyphicon-thumbs-up"></span>&#174; JGWeb
     </div>
   </form>    
</body>
   <script type="text/javaScript" src="../js/jquery-1.11.1.min.js" ></script>
   <script type="text/javaScript" src="../js/jquery.dataTables.min.js" ></script>
   <script type="text/javaScript" src="../js/bootstrap.min.js" ></script> 
   <script type="text/javaScript" src="../js/dataTables.bootstrap.js" ></script> 
   <script type="text/javaScript">xajax_Tela('') </script>
</html>
<?php
function Tela()
{
    $resp = new xajaxResponse();
    global $db;
    $query = ' Select * From adm_rotinas order by 2 ';
    $id = 0;
    $rset = $db->Executa_Query_Array($query);
    $tela = '<div class="container-fluid table-responsive nova_tela"
                <h3 class="text-muted centro"> Cadastro Rotinas</h3>
                <button type="submit" class="btn btn-primary" onclick="xajax_Alterar('.$id.'); return false;">Incluir nova rotina</button>
                <h3>  Rotinas </h3>
                <table id="tabclas" data-toggle="table" class="table table-striped table-bordered">
       	        <thead><tr>	
                  <th> Nome Rotina </th>
                  <th> Funcionalidade </th>
                  <th> Servidor Web </th>
                </tr></thead><tbody>';
//    $resp->alert('Aqui'.count($rset)); return $resp;
    if (count($rset) > 0) {
        $i = 0;
        foreach ($rset as $res):
           $rotina = $res['rotina'];
           $id = $res['id'];
           $func = $res['funcionalidade'];
          $caminho = $res['caminho_http'];
          $tela .= '<tr>
                    <td><input type="submit" class="btn" value="'.$rotina.'" onclick="xajax_Alterar('.$id.'); return false;"></td>
                    <td>'.$func.'</td>
                    <td>'.$caminho.'</td>
                 </tr>';
        ++$i;
        endforeach;
    }
    $tela .= '</tbody></table></div><div id="consulta" ></div>';
    $resp->assign('tela_dados', 'innerHTML', $tela);
    $resp->script('tabela()');

    return $resp;
}

function Alterar($id)
{
    $resp = new xajaxResponse();
    $tela = monta_form($id, $resp);
    $resp->assign('tela_dados', 'innerHTML', $tela);

    return $resp;
}

function monta_form($id, $resp)
{
    if ($id > 0) {
        global $db;
        $query = " select * from adm_rotinas where id = $id ";
        $res = $db->Executa_Query_Single($query);
        $rotina = $res['rotina'];
        $id = $res['id'];
        $func = $res['funcionalidade'];
        $caminho = $res['caminho_http'];
        $rd = 'readonly';
        $oper = 'A';
    } else {
        $rotina = '';
        $func = '';
        $caminho = '';
        $rd = '';
        $oper = 'I';
    }
    $tela = ' <div class="col-sm-12 nova_tela"
                <div class="row">
                 <div class="col-sm-12">
                   <div class="form-group col-sm-2">
                     <label for="rotina">Nome Rotina</label>
                     <input type="text" name="rotina" id="rotina" value="'.$rotina.'" '.$rd.'>
                   </div>
                   <div class="form-group col-sm-4">
                    <label for="func">Funcionalidade </label>
                    <textarea name="func" class="form-control" id="func" rows="3">'.$func.'</textarea>
                   </div>
                   <div class="form-group col-sm-2">
                    <label for="caminho">Servidor Web </label>
                    <input type="text" id="caminho" name="caminho" value="'.$caminho.'">
                   </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-12">
                   <input type="hidden" name="oper" value="'.$oper.'">
                   <input type="hidden" name="id" value="'.$id.'">
                   <button type="submit" class="btn btn-lg btn-primary"  onclick="xajax_Gravar(xajax.getFormValues(\'tela\')); return false;">Gravar</button>
                   <button type="submit" class="btn btn-lg btn-primary"  onclick="xajax_Tela(); return false;">Desistir</button>
                   <button type="submit" class="btn btn-lg btn-primary"  onclick="xajax_Excluir('.$id.',\''.$rotina.'\');return false;">Excluir</button>
                </div></div>';
    return $tela;
}

function Excluir($chave, $rotina)
{
    $resp = new xajaxResponse();
    global  $db;
    $query = " delete from adm_rotinas where id = $chave ";
    $e = $db->Executa_Query_SQL($query, $resp);
    if ($e == 2) {
        $resp->alert('Erro no SQL, verifique a mensagem!');

        return $resp;
    }
//    $script = 'rm  -rf ../'.strtolower($rotina);
//    if (file_exists('../'.strtolower($rotina))) { $x = shell_exec($script); }
//    $resp->alert($script.' - '.$x);
    $resp->redirect($_SERVER['PHP_SELF']);

    return $resp;
}

function Gravar($dados)
{
    $resp = new xajaxResponse();
    global   $db;
    $id = $dados['id'];
    $oper = $dados['oper'];
    $rotina = mb_strtoupper($dados['rotina'], 'UTF-8');
    $pasta = strtolower($dados['rotina']);
    $func = $dados['func'];
    $caminho = $dados['caminho'];
    if (!$rotina) {
        $resp->alert('Preencha o nome da rotina!');

        return $resp;
    }
    if (!$func) {
        $resp->alert('Preencha a Funcionalidade!');

        return $resp;
    }
    if ($oper == 'I') {
//                   $id = $db->Executa_Query_Unico(" select  ifnull((max(id) + 1),1) from usuario ");

        $query = " insert into adm_rotinas
                           ( id, rotina ,funcionalidade,caminho_http)
                    Values (( select  ifnull((max(aa.id) + 1),1) from adm_rotinas aa), '$rotina','".$func."','$caminho' ) ";
        $e = $db->Executa_Query_SQL($query, $resp);
        if ($e == 2) {
            $resp->alert('Erro no SQL, verifique a mensagem!');

            return $resp;
        }
        if (!file_exists('../'.$pasta)) {
            mkdir('../'.$pasta, 0777, true);
        }
//        $resp->addAlert('Passei Aqui!'.$query); return $resp;
    }
    if ($oper == 'A') {
        $query = "update adm_rotinas
                     set rotina  = '$rotina' ,funcionalidade  = '$func', caminho_http = '$caminho'
                       where id  = $id ";
        $e = $db->Executa_Query_SQL($query, $resp);
        if ($e == 2) {
            $resp->alert('Erro no SQL, verifique a mensagem!');

            return $resp;
        }
    }
    $resp->redirect($_SERVER['PHP_SELF']);

    return $resp;
}
