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
$xajax->register(XAJAX_FUNCTION, 'Manut_CRUD');
$xajax->register(XAJAX_FUNCTION, 'Excluir');
$xajax->register(XAJAX_FUNCTION, 'Gravar');
$xajax->processRequest();
$xajax->configure('javascript URI', '../xajax/');
?>
<!DOCTYPE html>
<html>  
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Cadastro Modalidades</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style4.css">
    <link rel="stylesheet" href="../css/tela_nova.css">
    <link rel="stylesheet" href="../css/Navigation-with-Search.css">
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
</head>    <?php $xajax->printJavascript('../xajax'); ?>
 </head>
 <body class="opaco">
    <div class="container-fluid" style="padding-top: 10px;" >  
         <div id="tela_modal" class="col-xs-12 col-sm-8" style="padding: 5px 0;"></div> 
    </div>
    <div class="footer">
        <span class="glyphicon glyphicon-thumbs-up"></span>&#174; JGWeb
    </div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>  
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
    /*
    CREATE TABLE `modalidades` (
        `mod_id` int(3) NOT NULL AUTO_INCREMENT,
        `descri` varchar(50) NOT NULL,
        `tipo` enum('I','G') NOT NULL,
        idade_minima, idade_maxima
        PRIMARY KEY (`mod_id`)
    */
    $query = " select mod_id, descri, tipo, idade_minima, idade_maxima from modalidades order by descri ";    
    $res = $db->Executa_Query_Array($query, $resp);
    if (count($res) == 0) {
        $resp->script('xajax_Manut_CRUD();');
        return $resp;
    }
 //   $resp->alert('Aqui - '.print_r($res,true));
    $tela = '<div class="container-fluid table-responsive tela_nova">
                <button type="submit"  class="btn btn-primary" onclick="xajax_Manut_CRUD(0,\'I\'); return false;">Inclui Nova Modalidade</button>
                  <h3 class="text-muted centro">Cadastro Modalidades</h3>
                   <table id="tabclas" data-toggle="table" class="table table-striped table-bordered">
                    <thead>  
                       <tr>
                        <th style="text-align: center;">Alt/Exc.</th> 
                        <th style="text-align: center;">Descrição </th>
                        <th style="text-align: center;" nowrap>Tipo Mod. </th>
                        <th style="text-align: center;" nowrap>Idade Mínima </th>
                        <th style="text-align: center;" nowrap>Idade Máxima </th>
                       </tr></thead><tbody>';
    if (is_array($res)) {
        $tt = count($res);
        for ($a = 0; $a < $tt; ++$a) {
            $id = $res[$a]['mod_id'];
            $descri_mod = $res[$a]['descri'];
            if ($res[$a]['tipo'] == 'I') { $tipo = "Individual";} else { $tipo = "Grupo"; }
            $idade_minima = $res[$a]['idade_minima'];
            $idade_maxima = $res[$a]['idade_maxima'];
            $tela .= '<tr> 
                     <td><input type="image" src="../img/edit-icon.png" border="0" width="24" height="24" data-toggle="tooltip" data-placement="bottom" title="Altera/Exclui registro do Evento" onclick="xajax_Manut_CRUD('.$id.',\'A\'); return false;"> '.$id.'</td>
                     <td nowrap> '.$descri_mod.'</td>
                     <td align="center">'.$tipo.'</td>
                     <td align="center">'.$idade_minima.'</td>
                     <td align="center">'.$idade_maxima.'</td>
                  </tr>';
        }
    }
    $tela .= '</tbody></table></div>';
    $resp->assign('tela_modal', 'innerHTML', $tela);
    $resp->script('tabela();');
    return $resp;
}

function Manut_CRUD($id=0, $oper='I')
{
    $resp = new xajaxResponse();
    global $db;
    if ($oper !== 'I') {
        $query = " select * from modalidades where mod_id = $id ";
        $res = $db->Executa_Query_Single($query, $resp);
        $mod_id = $res['mod_id'];
        $descri = $res['descri'];
        $idade_minima = $res['idade_minima'];
        $idade_maxima = $res['idade_maxima'];
        $tipo = $res['tipo'];
        $checkI = '';
        $checkG = '';
        if ($tipo == 'I') {
            $checkI = 'checked="true"';
        }
        if ($tipo == 'G') {
            $checkG = 'checked="true"';
        }

    } else {
        $mod_id = $db->Executa_Query_Unico("select nvl(max(mod_id + 1) ,1) as num  from modalidades", $resp);
        $descri = '';
        $tipo = '';
        $idade_minima = '';
        $idade_maxima = '';
    }

    if ($oper == 'I') {
        $opera = 'Incluir';
        $label = 'Gravar';
        $rd = 'readonly';
    } else {
        $opera = 'Alterar';
        $label = 'Altera';
    }
    $tela = '<div class="tela_nova col-xs-12">
                 <h3 class="text-muted centro">Cadastro Modalidades</h3>
                 <form id="modal" name="modal"  role="form" method="POST">
                 <input type="hidden" name="mod_id" value="'.$mod_id.'">
                 <input type="hidden" name="oper" value="'.$oper.'">
                   <div class="row">
                     <div class="col-sm-4">
                        <label for="descri" class="control-label">Descrição : </label>
                        <input class="form-control" type="text" name="descri" id="descri" value="'.$descri.'" required="true">
                      </div>
                      <br>
                      <div class="col-sm-4">
                        <label for="tipo">Tipo Mod.: </label>
                        <div class="custom-control custom-radio">
                          <input type="radio" class="form-control-input" name="tipo" value="I" '.$checkI.'> Indiv.
                          <input type="radio" class="form-control-input" name="tipo" value="G" '.$checkG.'> Grupo
                        </div>  
                      </div>
                   </div>
                   <br>
                   <div class="row">
                     <div class="col-sm-3">
                       <label for="idade_minima" class="control-label">Idade Mínima : </label>
                       <input class="form-control" type="number" name="idade_minima" id="idade_minima" value="'.$idade_minima.'">
                     </div>                    
                     <div class="col-sm-3">
                       <label for="idade_maxima" class="control-label">Idade Máxima : </label>
                       <input class="form-control" type="number" name="idade_maxima" id="idade_maxima" value="'.$idade_maxima.'">
                     </div>                    
                   </div>
                   <br>
                   <div class="row">
                      <div class="col-sm-3">
                       <button type="submit"  class="btn btn-lg btn-primary" onclick="xajax_Gravar(xajax.getFormValues(\'modal\')); return false;">'.$label.'</button>
                      </div>
                      <div class="col-sm-3">  
                        <button type="submit"  class="btn btn-lg btn-danger" onclick="xajax_Excluir(\''.$mod_id.'\'); return false;">Exclui</button>
                      </div>
                     <div class="col-sm-3">  
                       <button type="submit"  class="btn btn-lg btn-warning" onclick="xajax_Tela_Inicial(\''.$mod_id.'\'); return false;">Cancela</button>
                     </div>
                   </div>
                   </form></div>';
    $resp->assign('tela_modal', 'innerHTML', $tela);
    return $resp;
}



function Excluir($id)
{
    $resp = new xajaxResponse();
    global $db;
    $resp->confirmCommands(1, " Confirma exclusão do Registro ($id) ? ");
    $db->Executa_Query_SQL(" delete from modalidades where mod id = $id ", $resp);
    $resp->script('xajax_Tela_inicial()');

    return $resp;
}

function Gravar($dados)
{
    $resp = new xajaxResponse();
    $oper = $dados['oper'];
//    $resp->alert('Aqui - '.print_r($dados, true));   return $resp;

    if (!$dados['descri']) {
        $resp->alert('Descrição da Modadlidade deve estar preenchida!');
        return $resp;
    }
    if (!$dados['tipo']) {
        $resp->alert('Tipo de modalidade (individial/grupo) deve ser escolhida!');
        return $resp;
    }
    if ($dados['idade_maxima']) {
       if ($dados['idade_maxima'] < $dados['idade_minima']) {
          $resp->alert("Confira idades mímima e máxima!"); return $resp;
       }
    }
    global $db;
    $mod_id =  $dados['mod_id'];
    $descri =  $dados['descri'];
    $tipo   =  $dados['tipo'];
    $idade_minima = $dados['idade_minima'];
    $idade_maxima = $dados['idade_maxima'];
    if ($oper == 'A') {
        $query = "update modalidades set descri = '$descri', tipo = '$tipo', idade_minima = $idade_minima, idade_maxima = $idade_maxima where mod_id = $mod_id ";
    } else {
        $query = "insert into modalidades values ($mod_id, '$descri', '$tipo', $idade_minima, $idade_maxima )";
    }
    $ret = $db->Executa_Query_SQL($query, $resp);
    $resp->script('xajax_Tela_Inicial();');

    return $resp;
}
