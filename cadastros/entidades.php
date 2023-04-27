<?php
    header('Cache-control: private, no-cache');
    header('Expires: Mon, 26 Jun 1997 05:00:00 GMT');
    ini_set('date.timezone', 'America/Sao_Paulo');
    ini_set('memory_limit', -1);
    ini_set('default_charset', 'UTF-8');
    ini_set('display_errors', true);
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
define('TABELA', 'entidade');
define('ROOT', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
require ROOT.DS.'autoload.php';
// Session;
$sessao = new sessao();
// Banco de dados
$db = new classe_entidade('MYSQL_gaucho');
$end = new classe_endereço('MYSQL_gaucho');
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
    <title>Cadastro Entidades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/all.css">
    <link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../css/Navigation-with-Search.css">
    <link rel="stylesheet" href="../css/style4.css">
    <style>
        .mostrar  { display: visible; } 
        .esconder { display: none;  }
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
    <div class="container-fluid" style="width: 90%; padding-top: 10px;" >  
         <div id="tela_entidade" class="col-sm-12" style="padding: 5px 0;"></div> 
    </div>
    <div class="footer">
    <span> <i class="fa fa-thumbs-up" aria-hidden="true"></i></span>&#174; JGWeb
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>  
    <script type="text/javaScript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javaScript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" ></script>
   <script type="text/javaScript">xajax_Tela_Inicial() </script>
 </body>
</html>
<?php
function Tela_Inicial()
{
    $resp = new xajaxResponse();
    global $db;
    $res = $db->Monta_lista($resp);

    $tela = '<div class="container-fluid table-responsive teste">
              <h3 class="text-muted centro"> Cadastro Entidades</h3>
                 <button type="submit"  class="btn btn-primary" onclick="xajax_Manut_CRUD(0,\'I\'); return false;">Inclui Nova Entidade</button>
                 <table  id="tabclas" data-toggle="table" class="table table-striped table-bordered">
                     <thead>  
                       <tr align="center">
                        <th>Alt/Exc.</th> 
                        <th>RT</th>
                        <th>Nome Entidade</th>
                        <th>CNPJ</th>
                        <th>Nome Prim. Resp.(Patrão)</th>
                       </tr></thead><tbody>';
    if (is_array($res)) {
        $tt = count($res);
        for ($a = 0; $a < $tt; ++$a) {
            $id = $res[$a]['entidade_id'];
            $sigla = $res[$a]['sigla'];
            $RT = $res[$a]['RT'];
            $nome_entidade = $res[$a]['nome_entidade'];
            if ($sigla) {
                $nome_entidade = $sigla.' - '.$nome_entidade;
            }
            if ($res[$a]['cnpj'] > 0) {
                $cnpj = mask($res[$a]['cnpj'], '##.###.###/####-##');
            } else {
                $cnpj = '';
            }
            $resp1 = $res[$a]['resp1'];
            $tela .= '<tr> 
                     <td><input type="image" src="../img/edit-icon.png" border="0" width="24" height="24" data-toggle="tooltip" data-placement="bottom" title="Altera/Exclui registro da Entidade" onclick="xajax_Manut_CRUD('.$id.',\'A\'); return false;"> '.$id.'</td>
                     <td>'.$RT.'</td>
                     <td>'.$nome_entidade.'</td>
                     <td>'.$cnpj.'</td>
                     <td>'.$resp1.'</td>
                  </tr>';
        }
    }
    $tela .= '</tbody></table></div>';
    $resp->assign('tela_entidade', 'innerHTML', $tela);
    $resp->script('tabela();');

    return $resp;
}
/*
"Field","Type","Null","Key","Default","Extra"
"entidade_id","int(5)","NO","PRI","","auto_increment"
"sigla","varchar(3)","YES","","",""
"nome_entidade","varchar(100)","NO","","",""
"cnpj","decimal(14,0)","YES","","",""
"resp1","varchar(100)","NO","","",""
"email_resp1","varchar(50)","YES","","",""
"telefone_resp1","varchar(50)","YES","","",""
"resp2","varchar(100)","YES","","",""
"email_resp2","varchar(50)","YES","","",""
"telefone_resp2","varchar(50)","YES","","",""
"data_fundação","date","YES","","",""
"RT","varchar(3)","YES","","",""
"matricula","int(5)","YES","","",""
*/
function Manut_CRUD($id, $oper)
{
    $resp = new xajaxResponse();
    global $db;
    if ($oper !== 'I') {
        $res = $db->Ler_Registro($id, $resp);
        $entidade_id = $res['entidade_id'];
        $sigla = $res['sigla'];
        $nome_entidade = $res['nome_entidade'];
        $cnpj = mask($res['cnpj'], '##.###.###/####-##');
        $resp1 = $res['resp1'];
        $email_resp1 = $res['email_resp1'];
        $telefone_resp1 = $res['telefone_resp1'];
        $resp2 = $res['resp2'];
        $email_resp2 = $res['email_resp2'];
        $telefone_resp2 = $res['telefone_resp2'];
        $data_fundação = $res['data_fundação'];
        $RT = $res['RT'];
        $matricula = $res['matricula'];
        $invern = $db->Busca_Invernadas($entidade_id, $resp);
        $resul = $db->Tipo_Invernada($resp);
        $inver = '<b>Invernadas: ';
        $invernada = array();
        for ($i = 0; $i < count($invern); ++$i) {
//            $invernada[] .= $invern[$i]['tipo_invernada'];
            $invernada[count($invernada)-1] = $invern[$i]['tipo_invernada'];
        }
        for ($i = 0; $i < count($resul); ++$i) {
            $tipo = $resul[$i]['tipo'];
            $descri = $resul[$i]['titulo'];
            if (in_array($tipo, $invernada)) {
                $check = ' checked ';
            } else {
                $check = '';
            }
            $inver .= '&nbsp;&nbsp;&nbsp;<input type="checkbox"  name="invern'.$i.'" value="'.$tipo.'" '.$check.'>&nbsp;'.$descri;
        }
    } else {
        $entidade_id = $db->Busca_Proximo_ID($resp);
        if (!$entidade_id) {
            $entidade_id = 1;
        }
        $sigla = '';
        $nome_entidade = '';
        $cnpj = 0;
        $resp1 = '';
        $email_resp1 = '';
        $telefone_resp1 = '';
        $resp2 = '';
        $email_resp2 = '';
        $telefone_resp2 = '';
        $data_fundação = '';
        $RT = '';
        $matricula = 0;
        $res = $db->Tipo_Invernada($resp);
        $inver = '<b>Invernadas: ';
        for ($i = 0; $i < count($res); ++$i) {
            $tipo = $res[$i]['tipo'];
            $descri = $res[$i]['titulo'];
            $inver .= '&nbsp;&nbsp;&nbsp;<input type="checkbox"  name="invern'.$i.'" value="'.$tipo.'" >&nbsp;'.$descri;
        }
    }

    if ($oper == 'I') {
        $opera = 'Incluir';
        $label = 'Gravar';
        $rd = 'readonly';
    } else {
        $opera = 'Alterar';
        $label = 'Altera';
    }
//    $resp->alert('Aqui...- '.print_r($invernada, true));    return $resp;
    // tela de abas                   <div class="panel-body" style="background-color: #7FDBFF;">
    $tela = '<div class="col-md-12">
                <div class="panel with-nav-tabs panel-secondary teste">
                  <div class="panel-heading">
                     <ul class="nav nav-tabs">
                        <li class="active"><a href="#aba1" data-toggle="tab">Dados Básicos</a></li>
                        <li><a href="#aba2" data-toggle="tab">Endereços </a></li>
                     </ul>
                  </div>
                  <div class="panel-body">                     
                   <div class="tab-content">
                    <div class="tab-pane fade in active"  id="aba1"><h4>Dados Básicos</h4>
                     <form id="tela_entidade" name="tela_entidade"  role="form" method="POST">';

    $tela .= '<input type="hidden" name="entidade_id" value="'.$entidade_id.'">
             <input type="hidden" name="oper" value="'.$oper.'">
                   <div class="row">
                     <div class="col-sm-2">
                       <label for="sigla">Sigla: </label>
                       <input class="form-control" type="text" name="sigla" id="sigla" value="'.$sigla.'" required="required">
                     </div>   
                     <div class="col-sm-4">
                        <label for="nome_entidade">Nome da Entidade : </label>
                        <input class="form-control" type="text" name="nome_entidade" id="nome_entidade" value="'.$nome_entidade.'" required="required">
                     </div>   
                     <div class="col-sm-3">
                        <label for="cnpj">C.N.P.J. : </label>
                        <input class="form-control" type="text" name="cnpj" id="cnpj" value="'.$cnpj.'" onchange="xajax_valida_cnpj(xajax.getFormValues(\'dados_tela\')); return false;">
                     </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-sm-1">
                        <label for="RT">RT: </label>
                        <input class="form-control" type="text" name="RT" id="RT" value="'.$RT.'" >
                    </div>   
                    <div class="col-sm-4">
                       <label for="data_fundação">Data de Fundação : </label>
                       <input class="form-control" type="date" name="data_fundação" id="data_fundação" value="'.$data_fundação.'" required="required">
                    </div>   
                    <div class="col-sm-3">
                       <label for="matricula">Matricula MTG : </label>
                       <input class="form-control" type="text" name="matricula" id="matricula" value="'.$matricula.'" onchange="xajax_valida_cnpj(xajax.getFormValues(\'dados_tela\')); return false;">
                    </div>
                   </div>
                   <br>
                   <div class="row">
                     <div class="col-sm-3">
                       <label for="resp1">Nome Prim. Resp. (Patrão): </label>
                       <input class="form-control" type="text" name="resp1" id="resp1" value="'.$resp1.'">
                     </div>   
                     <div class="col-sm-3">
                       <label for="email_resp1">Email do Primeiro Responśavel : </label>
                       <input class="form-control" type="email" name="email_resp1" id="email_resp1" value="'.$email_resp1.'">
                     </div>
                     <div class="col-sm-3">
                       <label for="telefone_resp1">Telefone do Primeiro Responśavel : </label>
                       <input class="form-control" type="text" name="telefone_resp1" id="telefone_resp1" value="'.$telefone_resp1.'" pattern="[0-9]{3}-[0-9]{5}-[0-9]{4}"
                       <small>Formato: DDD-99999-9999</small>
                     </div>
                   </div>
                   <div class="row">
                    <div class="col-sm-3">
                     <label for="resp2">Nome Segundo Responsável : </label>
                     <input class="form-control" type="text" name="resp2" id="resp2" value="'.$resp2.'">
                    </div>   
                    <div class="col-sm-3">
                      <label for="email_resp2">Email do Segundo Responśavel : </label>
                      <input class="form-control" type="email" name="email_resp2" id="email_resp2" value="'.$email_resp2.'">
                    </div>
                    <div class="col-sm-3">
                      <label for="telefone_resp2">Telefone do Segundo Responśavel : </label>
                      <input class="form-control" type="text" name="telefone_resp2" id="telefone_resp2" value="'.$telefone_resp2.'">
                    </div>
                   </div>
                   <br>
                <div class="row">
                   <div class="col-sm-8">'.$inver.'</div>
                </div>
                <br>';
    $tela .= '<div class="row">
                 <div class="col-sm-3">
                   <button type="submit"  class="btn btn-lg btn-primary" onclick="xajax_Gravar(xajax.getFormValues(\'tela_entidade\')); return false;">'.$label.'</button>
                 </div>
                 <div class="col-sm-3">  
                   <button type="submit"  class="btn btn-lg btn-danger" onclick="xajax_Excluir(\''.$entidade_id.'\'); return false;">Exclui</button>
                 </div>
                 <div class="col-sm-3">  
                  <button type="submit"  class="btn btn-lg btn-success" onclick="xajax_Tela_Inicial(\''.$id.'\'); return false;">Cancela</button>
                </div>
              </div></form></div>';
//            $pessoa_41070 = $db->Leitura_Endereco($xcodigo, '', $resp);
    $tela .= tela_endereco($entidade_id, $nome_entidade, $oper, $resp);
    $resp->assign('tela_entidade', 'innerHTML', $tela);

    return $resp;
}

function tela_endereco($entidade_id = 0, $nome_entidade = '', $oper, $resp)
{
    global $end;
    if (!$entidade_id) {
        $resp->alert('É necessário uma entidade origem para o endereço');

        return $resp;
    }
    $tipo_end = 0;
    $logradouro = '';
    $numero = '';
    $complemento = '';
    $bairro = '';
    $distrito = '';
    $cidade = '';
    $cep = '';
    $uf = '';
    $ends = $end->Monta_Lista($entidade_id, $resp);
    if ($oper == 'A') {
        for ($i = 0; $i < count($ends); ++$i) {
            $end_id = $ends[$i]['end_id'];
            $tipo_end = $ends[$i]['tipo_end'];
            $logradouro = $ends[$i]['logradouro'];
            $numero = $ends[$i]['numero'];
            $complemento = $ends[$i]['complemento'];
            $bairro = $ends[$i]['bairro'];
            $distrito = $ends[$i]['distrito'];
            $cidade = $ends[$i]['cidade'];
//            $cep = mask($ends[$i]['cep'], '#####-###');
            $cep = $ends[$i]['cep'];
            $uf = $ends[$i]['uf'];
        }
    }
    $tela = '<div class="tab-pane fade in" id="aba2"><h4>Endereços</h4>
                <form id="tela_endereco" name="tela_endereco"  role="form" method="POST">
                   <input type="hidden" name="oper" value="'.$oper.'">
                   <input type="hidden" name="end_id" value="'.$entidade_id.'">
                   <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group col-sm-5">
                                <label for="entidade_id">Código/Nome</label>
                                <input type="text" class="form-control" name="nome" id="nome" value="'.$entidade_id.' - '.$nome_entidade.'" readonly>
                            </div>
                            <div class="form-group col-sm-3">
                               <label for="tipo_end">Tipo Endereço</label>
                              '.combo_tipo_end($tipo_end, $resp).'
                            </div>
                        </div>
                    <div class="row">
                       <div class="form-group col-sm-2">
                         <label for="cep">CEP</label>
                         <input type="text" class="form-control" name="cep" id="cep" value="'.$cep.'">
                         <button type="submit" class="btn btn-warning"  onclick="xajax_busca_cep(xajax.getFormValues(\'tela_endereco\')); return false;">Buscar Cep</button>
                       </div>
                       <div class="form-group col-sm-4">
                          <label for="logradouro">Logradouro</label>
                          <input type="text" class="form-control" name="logradouro" id="logradouro" value="'.$logradouro.'" placeholder="Rua, Avenida, etc..">
                       </div>
                       <div class="form-group col-sm-2">
                          <label for="numero">Nro</label>
                         <input type="number" class="form-control" name="numero" id="numero" value="'.$numero.'" >
                       </div>
                       <div class="form-group col-sm-2">
                         <label for="complemento">Complemento</label>
                         <input type="text" class="form-control" name="complemento" id="complemento" value="'.$complemento.'" >
                        </div>
                    </div>    
                    <div class="row">
                       <div class="form-group col-sm-2">
                           <label for="bairro">Bairro</label>
                           <input type="text" class="form-control" name="bairro" id="bairro" value="'.$bairro.'" >
                       </div>
                       <div class="form-group col-sm-2">
                          <label for="distrito">Distrito</label>
                          <input type="text" class="form-control" name="distrito" id="distrito" value="'.$distrito.'" >
                       </div>
                       <div class="form-group col-sm-2">
                          <label for="distrito">Cidade</label>
                          <input type="text" class="form-control" name="cidade" id="cidade" value="'.$cidade.'" >
                       </div>
                       <div class="form-group col-sm-2">
                            <label for="uf">UF</label>
                            <input type="text" class="form-control" name="uf" id="uf" value="'.$uf.'" >
                       </div>                
                    </div>
                    <div class="form-group col-sm-3">
                    <button type="submit" class="btn btn-lg btn-primary" onclick="xajax_Grava_Ender(xajax.getFormValues(\'tela_endereco\')); return false;">Grava Endereço</button>
                </div>                  
                </form>
               </div>';

    return $tela;
}

function Grava_Ender($dados_tela)
{
    $resp = new xajaxResponse();
    global $end;
    $end_id = $dados_tela['end_id'];
    if (!$dados_tela['tipo_end']) {
        $tipo_end = 1;
    } else {
        $tipo_end = $dados_tela['tipo_end'];
    }
    $dados_tabela = $end->Ler_Registro($end_id, $tipo_end, $resp);
    if (is_array($dados_tabela)) {
        $oper = 'A';
    } else {
        $oper = 'I';
    }
    if ($oper == 'A') {
        $ret = $end->Alterar_Registro($dados_tela, $dados_tabela, $resp);
    } else {
        $ret = $end->Incluir_Registro($dados_tela, $dados_tabela, $resp);
    }
    if ($ret == 2) {
        $resp->alert('Erro na atualização do endereço.'.$ret);
    } else {
        $resp->alert('Endereço gravado!');
    }

    return $resp;
}
function combo_tipo_end($tipo_end = 0, $resp = '')
{
    global $end;
    $res = $end->Tipo_Endereco($resp);
    $tela = '<select  class="form-control" name="tipo_end" id="tipo_end">';
    for ($i = 0; $i < count($res); ++$i) {
        $tipo = $res[$i]['tipo_id'];
        $descri = $res[$i]['descri_tipo'];
        if ($tipo === $tipo_end) {
            $sel = ' selected ';
        } else {
            $sel = '';
        }
        $tela .= '<option value="'.$tipo.'"  '.$sel.' class="form-control" > '.$descri.' </option> ';
    }
    $tela .= '</select>';

    return $tela;
}
/*
function tela_endereco($entidade_id, $resp)
{
    $tela = ' <div class="tab-pane fade" id="aba2"><h4>Endereços</h4>
               <form id="tela_endereco" name="tela_endereco"  role="form" method="POST">
           <div class="row">
         </div></div>';

    return $tela;
}
*/
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

    if (!$dados['nome_entidade']) {
        $resp->alert('Nome da Entidade deve estar preenchido!');

        return $resp;
    }
    if (!$dados['resp1']) {
        $resp->alert('Nome do Primeiro Responsável!');

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
function limpaCPF_CNPJ($valor)
{
    $valor = trim($valor);
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '', $valor);
    $valor = str_replace('-', '', $valor);
    $valor = str_replace('/', '', $valor);

    return $valor;
}
 function busca_cep($dados)
 {
     $resp = new xajaxResponse();
     $cep = $dados['cep'];
     $resul = file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');
     if (!$resul) {
         $resp->alert('Falha ao buscar o CEP');

         return $resp;
     }
     $ret = utf8_decode(urldecode($resul));
     parse_str($ret, $retx);
//    $ret = explode('&', (urldecode($resul)));
//    $cct = array();
     if (substr($retx['resultado_txt'], 0, 7) == 'sucesso') {
         $uf = $retx['uf'];
         $bairro = $retx['bairro'];
         $logradouro = $retx['tipo_logradouro'].' '.$retx['logradouro'];
         $cidade = $retx['cidade'];
     } else {
         $resp->alert('Cep inválido, verifique');

         return $resp;
     }
     $resp->assign('uf', 'value', $uf);
     $resp->assign('bairro', 'value', $bairro);
     $resp->assign('logradouro', 'value', $logradouro);
     $resp->assign('cidade', 'value', $cidade);
//     $resp->alert(print_r($dados, true).' aqui - ');
     return $resp;
 }
 function valida_cnpj($dados)
 {
     $resp = new xajaxResponse();
     $xcodigo = $dados['cnpj'];
     if (!$xcodigo) {
         $resp->alert('Digite o código, por facor!');

         return $resp;
     }
     if ($xcodigo > 0) {
         $retorna = shell_exec('curl -X GET https://www.receitaws.com.br/v1/cnpj/'.$xcodigo);
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
