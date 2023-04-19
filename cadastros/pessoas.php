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
$db = new classe_pessoa('MYSQL_gaucho');
// XAJAX
require_once '../xajax/xajax_core/xajax.inc.php';
$xajax = new xajax();
// $xajax->configure('debug',true);
$xajax->configure('errorHandler', true);
$xajax->configure('logFile', 'xajax_error.log');
$xajax->register(XAJAX_FUNCTION, 'Tela_Inicial');
$xajax->register(XAJAX_FUNCTION, 'Manut_CRUD');
$xajax->register(XAJAX_FUNCTION, 'valida_cpf');
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
    <title>Cadastro Pessoas</title>
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
      <div id="tela_pessoa" class="col-sm-12" style="padding: 5px 0;"></div> 
  </div>
  <div class="footer">
        <span> <i class="fa fa-thumbs-up" aria-hidden="true"></i></span>&#174; JGWeb
    </div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>  
   <script type="text/javaScript" src="../js/jquery.dataTables.min.js" ></script>
   <script type="text/javaScript" src="../js/dataTables.bootstrap.js" ></script> 
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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
    /*
    `pessoa_id` `nome` `data_nascimento` `sexo` `entidade`
    `docto_mtg` `validade_docto_mtg`  `cpf`  `email`  `id_altera` `data_altera`
    */

    $tela = '<div class="container-fluid table-responsive teste">
               <h3 class="text-muted centro"> Cadastro Pessoas </h3>
               <table  class="table table-striped table-bordered table-sm">
                    <button type="submit"  class="btn btn-primary" onclick="xajax_Manut_CRUD(0,\'I\'); return false;">Inclui Nova Pessoa</button>
                  <thead class="table-dark">  
                     <tr>
                        <th style="text-align: center;">Alt/Exc.</th> 
                        <th style="text-align: center;">Nome Pessoa</th>
                        <th style="text-align: center;">CPF</th>
                        <th style="text-align: center;">Data Nascimento</th>
                        <th style="text-align: center;">Entidade</th>
                       </tr style="text-align: center;"></thead><tbody>';
    if (is_array($res)) {
        $tt = count($res);
        for ($a = 0; $a < $tt; ++$a) {
            $id = $res[$a]['pessoa_id'];
            $nome = $res[$a]['nome'];
            if ($res[$a]['cpf'] > 0) {
                $cpf = mask($res[$a]['cpf'], '###.###.###-##');
            } else {
                $cpf = '';
            }
            $dt_nasc = $res[$a]['data_nascimento'];
            $ent = $res[$a]['entidade'];
            $entidade = Combo_Entidade($ent, 'P', $resp);
            $tela .= '<tr> 
                     <td><input type="image" src="../img/edit-icon.png" border="0" width="24" height="24" data-toggle="tooltip" data-placement="bottom" title="Altera/Exclui registro da Entidade" onclick="xajax_Manut_CRUD('.$id.',\'A\'); return false;"> '.$id.'</td>
                     <td>'.$nome.'</td>
                     <td>'.$cpf.'</td>
                     <td>'.date('d/m/Y', strtotime($dt_nasc)).'</td>
                     <td>'.$entidade.'</td>
                  </tr>';
        }
    }
    $tela .= '</tbody></table></div>';
    $resp->assign('tela_pessoa', 'innerHTML', $tela);

    return $resp;
}
function Manut_CRUD($id, $oper)
{
    $resp = new xajaxResponse();
    global $db;
    global $sessao;
    $id_altera = $sessao->get('Gaucho_id');
//    $resp->alert('Aqui :'.$login.' - '.$id_altera.' - '.$usuario);

    if ($oper !== 'I') {
        $res = $db->Ler_Registro($id, $resp);
        $pessoa_id = $res['pessoa_id'];
        $nome = $res['nome'];
        $data_nascimento = $res['data_nascimento'];
        $sexo = $res['sexo'];
        $entidade = $res['entidade'];
        $docto_mtg = $res['docto_mtg'];
        $validade_docto_mtg = $res['validade_docto_mtg'];
        $cpf = mask($res['cpf'], '###.###.###-##');
        $email = $res['email'];
        $sexo = $res['sexo'];
        $checkM = '';
        $checkF = '';
        if ($sexo == 'F') {
            $checkF = 'checked="true"';
        }
        if ($sexo == 'M') {
            $checkM = 'checked="true"';
        }
    } else {
        $pessoa_id = $db->Busca_Proximo_ID($resp);
        $nome = '';
        $data_nascimento = '';
        $sexo = '';
        $entidade = '';
        $docto_mtg = '';
        $validade_docto_mtg = '';
        $cpf = '';
        $email = '';
    }

    if ($oper == 'I') {
        $opera = 'Incluir';
        $label = 'Gravar';
        $rd = 'readonly';
    } else {
        $opera = 'Alterar';
        $label = 'Altera';
    }
    /*
    `pessoa_id` `nome` `data_nascimento` `sexo` `entidade`
    `docto_mtg` `validade_docto_mtg`  `cpf`  `email`  `id_altera` `data_altera`
    */
    $tela = '<div class="col-md-12 teste">
              <h3 style="align-top: 1px; text-align="center"> Cadastro Pessoas </h3>
              <form name="tela_pessoa" method="POST">
                   <input type="hidden" name="pessoa_id" value="'.$pessoa_id.'">
                   <input type="hidden" name="id_altera" value="'.$id_altera.'">
                   <input type="hidden" name="oper" value="'.$oper.'">
                   <div class="row">
                     <div class="col-sm-4">
                        <label for="nome">Nome : </label>
                        <input class="form-control" type="text" name="nome" id="nome" value="'.$nome.'" required="required">
                     </div>   
                     <div class="col-sm-3">
                        <label for="nome">Data nascimento : </label>
                        <input class="form-control" type="date" name="data_nascimento" id="data_nascimento" value="'.$data_nascimento.'" required="required">
                     </div>   
                     <div class="col-sm-3">
                          <label for="sexo">Sexo:</label>
                          <div class="custom-control custom-radio">
                            <input type="radio" class="form-control-input" name="sexo" value="M" '.$checkM.'> Masc
                            <input type="radio" class="form-control-input" name="sexo" value="F" '.$checkF.'> Fem.
                          </div>  
                    </div>
                  </div>
                  <br>
                  <div class="row">
                     <div class="col-sm-3">
                      <label for="entidade">Afiliação :  </label>
                      '.Combo_Entidade($entidade, '', $resp).'
                     </div>   
                     <div class="col-sm-3">
                       <label for="docto_mtg">Documento MTG : </label>
                       <input class="form-control" type="text" name="docto_mtg" id="docto_mtg" value="'.$docto_mtg.'">
                     </div>
                     <div class="col-sm-3">
                       <label for="validade_docto_mtg">Val. Doc. MTG : </label>
                       <input class="form-control" type="date" name="validade_docto_mtg" id="validade_docto_mtg" value="'.$validade_docto_mtg.'">
                     </div>
                   </div>
                   <br>  
                   <div class="row">
                     <div class="col-sm-3">
                        <label for="cpf">C.P.F. : </label>
                        <input class="form-control" type="text" name="cpf" id="cpf" value="'.$cpf.'" placeholder="000.000.000-00" onchange="xajax_valida_cpf(xajax.getFormValues(\'tela_pessoa\')); return false;">
                     </div>
                     <div class="col-sm-3">
                       <label for="email">Email : </label>
                       <input class="form-control" type="email" name="email" id="email" value="'.$email.'">
                     </div>
                   </div>
                   <br>
                <br>';
    $tela .= '<div class="row">
                 <div class="col-sm-3">
                   <button type="submit"  class="btn btn-lg btn-block btn-primary" onclick="xajax_Gravar(xajax.getFormValues(\'tela_pessoa\')); return false;">'.$label.'</button>
                 </div>
                 <div class="col-sm-3">  
                   <button type="submit"  class="btn btn-lg btn-block btn-danger" onclick="xajax_Excluir(\''.$pessoa_id.'\'); return false;">Exclui</button>
                 </div>
                 <div class="col-sm-3">  
                  <button type="submit"  class="btn btn-lg btn-block btn-success" onclick="xajax_Tela_Inicial(\''.$pessoa_id.'\'); return false;">Cancela</button>
                </div>
              </div>
            </form></div>';

    $script = "$(document).ready(function(){
                $('#cpf').mask('000.000.000-00');
              });";
    $resp->script($script);
    $resp->assign('tela_pessoa', 'innerHTML', $tela);

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
//    $resp->alert('Aqui - '.print_r($dados, true));
    if (!$dados['nome']) {
        $resp->alert('Nome da Pessoa!');

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
function limpaCPF($valor)
{
    $valor = trim($valor);
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '', $valor);
    $valor = str_replace('-', '', $valor);
    $valor = str_replace('/', '', $valor);

    return $valor;
}
 function valida_cpf($dados)
 {
     $resp = new xajaxResponse();
     $xcodigo = $dados['cpf'];
     if (!$xcodigo) {
         $resp->alert('Digite o código, por facor!');

         return $resp;
     }
     if ($xcodigo > 0) {
         $retorna = shell_exec('curl -X GET https://www.receitaws.com.br/v1/cpf/'.$xcodigo);
         $saida = object_to_array(json_decode($retorna));
         $status = $saida['status'];
         $msg = $saida['message'];
         if ($status == 'ERROR') {
             $resp->alert($msg);

             return $resp;
         }
     }

     return $resp;
 }
 function object_to_array($object)
 {
     if (is_object($object)) {
         return array_map(__FUNCTION__, get_object_vars($object));
     } elseif (is_array($object)) {
         return array_map(__FUNCTION__, $object);
     } else {
         return $object;
     }
 }

function mask($val, $mask)
{
    //  echo mask($cnpj,'##.###.###/####-##');
    //  echo mask($cpf,'###.###.###-##');
    // echo mask($cep,'#####-###');
    // echo mask($data,'##/##/####');

    $maskared = '';
    $k = 0;
    for ($i = 0; $i <= strlen($mask) - 1; ++$i) {
        if ($mask[$i] == '#') {
            if (isset($val[$k])) {
                $maskared .= $val[$k++];
            }
        } else {
            if (isset($mask[$i])) {
                $maskared .= $mask[$i];
            }
        }
    }

    return $maskared;
}
function Combo_Entidade($entidade, $tipo, $resp)
{
    global $db;
    if ($tipo == 'P') {
        $nome_entidade = $db->Busca_Entidade($entidade, $resp);

        return '<input type="text" class="form-control" name="entidade" value="'.$nome_entidade.'" readonly>';
    }

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
