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
$db = new classe_evento('MYSQL_gaucho');
// XAJAX
require_once '../xajax/xajax_core/xajax.inc.php';
$xajax = new xajax();
// $xajax->configure('debug',true);
$xajax->configure('errorHandler', true);
$xajax->configure('logFile', 'xajax_error.log');
$xajax->register(XAJAX_FUNCTION, 'Tela_Inicial');
$xajax->register(XAJAX_FUNCTION, 'Manut_CRUD');
$xajax->register(XAJAX_FUNCTION, 'valida_cnpj');
$xajax->register(XAJAX_FUNCTION, 'Excluir');
$xajax->register(XAJAX_FUNCTION, 'Gravar');
$xajax->register(XAJAX_FUNCTION, 'busca_cep');
$xajax->register(XAJAX_FUNCTION, 'Grava_Ender');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style4.css">
    <link rel="stylesheet" href="../css/Navigation-with-Search.css">
    <style>
      .teste {
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

</head>    <?php $xajax->printJavascript('../xajax'); ?>
 </head>
 <body class="opaco">
    <div class="container-fluid" style="width: 90%; padding-top: 10px;" >  
         <div id="tela_evento" class="col-sm-12" style="padding: 5px 0;"></div> 
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
    $res = $db->Monta_lista($resp);
    if (count($res) == 0) {
        $resp->script('xajax_Manut_CRUD();');
        return $resp;
    }
 //   $resp->alert('Aqui - '.print_r($res,true));
    $tela = '<div class="container-fluid table-responsive teste">
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
                <div class="panel with-nav-tabs panel-secondary  teste">
                  <div class="panel-heading">
                     <ul class="nav nav-tabs">
                        <li class="active"><a href="#aba1" data-toggle="tab">Evento</a></li>
                        <li><a href="#aba2" data-toggle="tab">Extras </a></li>
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
                        '.Combo_Entidade($entidade, $resp).'
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
                   <button type="submit"  class="btn btn-lg btn-primary" onclick="xajax_Gravar(xajax.getFormValues(\'tela_evento\')); return false;">'.$label.'</button>
                 </div>
                 <div class="col-sm-3">  
                   <button type="submit"  class="btn btn-lg btn-danger" onclick="xajax_Excluir(\''.$evento_id.'\'); return false;">Exclui</button>
                 </div>
                 <div class="col-sm-3">  
                  <button type="submit"  class="btn btn-lg btn-warning" onclick="xajax_Tela_Inicial(\''.$evento_id.'\'); return false;">Cancela</button>
                </div>
            </div></div></form></div>';
    $resp->assign('tela_evento', 'innerHTML', $tela);

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
