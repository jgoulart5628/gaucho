<?php
// cadastro e manutenção de Pessoas
//error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT));
error_reporting(E_ALL & ~(E_NOTICE));
ini_set('log_errors', true);
ini_set('date.timezone', 'America/Sao_Paulo');
ini_set('default_charset', 'UTF-8');
require_once '../inc/sessao.php';
$sessao = new Session();
// include("../inc/Classes_Dados.php");
include 'ClassePessoa.php';
$db = new ClassePessoa();
require_once '../xajax/xajax_core/xajax.inc.php';
$xajax = new xajax();
// $xajax->configure('debug',true);
$xajax->configure('errorHandler', true);
$xajax->configure('logFile', 'xajax_error_log.log');
$xajax->register(XAJAX_FUNCTION, 'Tela');
$xajax->register(XAJAX_FUNCTION, 'Manut_Pessoa');
$xajax->register(XAJAX_FUNCTION, 'Exclui_Pessoa');
$xajax->register(XAJAX_FUNCTION, 'Manut_Endereco');
$xajax->register(XAJAX_FUNCTION, 'Grava_Dados');
$xajax->register(XAJAX_FUNCTION, 'Grava_Dados_Endereco');
$xajax->register(XAJAX_FUNCTION, 'dados_cnpj_cpf');
$xajax->register(XAJAX_FUNCTION, 'Carrega_Arquivo');
$xajax->register(XAJAX_FUNCTION, 'Grava_Imagem');
$xajax->register(XAJAX_FUNCTION, 'Grava_Telefones');
$xajax->register(XAJAX_FUNCTION, 'Visualiza_Arquivo');
$xajax->register(XAJAX_FUNCTION, 'busca_cep');
$xajax->register(XAJAX_FUNCTION, 'Retorna');
$xajax->processRequest();
$xajax->configure('javascript URI', '../xajax/');
// <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
//    <script type="text/javaScript" src="../js/jquery-1.11.1.min.js" ></script>
//    <script type="text/javascript" src="../js/jquery.magnifier.js"></script>
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
    <title> Cadastro - Pessoas </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="DEAL Software">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Vendor: Bootstrap Stylesheets http://getbootstrap.com -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <style>
         .mostrar  { display: visible; } 
         .esconder { display: none;  }
    </style>
    <!-- Our Website CSS Styles -->
    <link rel="stylesheet" href="../css/main.css">
   <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script type="text/javaScript" src="../js/bootstrap.min.js" ></script> 
    <script type="text/javaScript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" ></script>
    <script type="text/javaScript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js" ></script> 
    <script type="text/javascript" src="../js/micoxUpload.js"></script>
    <script type="text/javascript" src="../js/typeahead.js"></script>
    <script type="text/javascript" src="../js/deal.js"></script>
    <script type="text/javascript">
      function tabela() {   
       $('#clicli').dataTable();
      }
     </script>
   <?php $xajax->printJavascript(); ?>
</head>

<body style="padding-top: 10px;">
    <div class="container-fluid   fundo" style="width: 99%;" >  
          <div class="page-header">
             <h3 class="text-muted centro">DEAL Software <small> Cadastro Pessoas </small></h3>
          </div>
         <div id="tela_manut" class="col-sm-12 mostrar" align="center"></div> 
         <div id="tela_carga"></div> 
         <did id="tela_alt"   class="esconder"></did>
    </div>
    <div class="footer">
        <span class="glyphicon glyphicon-thumbs-up"></span>&#174; DealSw Web
    </div>
</body>
   <script type="text/javaScript">xajax_Tela() </script>
</html>

<?php
function Tela()
{
    $resp = new xajaxResponse();
    global $sessao;
    global $db;
    $usuario_id = $sessao->get('usuario_id');
    $nome_resp = $sessao->get('usuario_nome');
    $empres = $sessao->get('usuario_empresa');
    $tela = $db->Monta_Lista_Pessoa($resp);
    $resp->assign('tela_manut', 'className', 'mostrar');
    $resp->assign('tela_manut', 'innerHTML', $tela);
    $resp->script('tabela()');

    return $resp;
}

function Manut_Pessoa($codigo)
{
    $resp = new xajaxResponse();
    global $db;
    if (!$codigo) {
        $oper = 'I';
    } else {
        $oper = 'A';
    }
    if ($oper === 'A') {
        $dados_pessoa = $db->Leitura_Pessoa($codigo, $resp);
//      $pessoa_41070   =  $db->Leitura_Endereco($codigo, $resp);
        $tela = monta_form_pessoa($dados_pessoa, '', '', $oper, $resp);
    } else {
        $tela = prepara_inclui_pessoa($resp);
    }
    $resp->assign('tela_alt', 'className', 'mostrar');
    $resp->assign('tela_manut', 'className', 'esconder');
    $resp->assign('tela_alt', 'innerHTML', $tela);
    $resp->script('pesquisa_pessoa()');

    return $resp;
}

function Grava_Imagem($dados)
{
    $resp = new xajaxResponse();
    global $db;
    $arq = $dados['imagem_carga'];
    $arqx = explode('.', $arq);
    $tipo = $arqx[1];
    $xcodigo = $dados['xcodigo'];
    $xtabela = $dados['xtabela'];
    $xcoluna = $dados['xcoluna'];
    /*
       CREATE TABLE `pessoa_41050` (
      `xcodigo` varchar(20) NOT NULL COMMENT 'Código',
      `xtabela` varchar(20) NOT NULL COMMENT 'Tabela Origem',
      `xcoluna` varchar(45) NOT NULL COMMENT 'Coluna Imagem',
      `xseqimg` int(3) NOT NULL COMMENT 'Seq',
      `tipoarquivo` varchar(4) DEFAULT NULL COMMENT 'Tipo Arquivo',
      `arquivo` mediumblob DEFAULT NULL COMMENT 'Arquivo ',
      */
    //   $resp->alert(' Aqui! '.$tipo.' - '.print_r($dados, true));  return $resp;
    $arquivo = __DIR__.'/tmp/'.$xcoluna;
    //   $arquivo = 'tmp/'.$xcoluna;
    $query = " select max(xseqimg) from pessoa_41050 where xcodigo = '$xcodigo' and xtabela = '$xtabela' and xcoluna = '$xcoluna' ;";
    $index = $db->Proximo_Indice_Imagem($query, $resp);
    ++$index;
    $query = " insert into pessoa_41050 (xcodigo, xtabela, xcoluna, xseqimg, tipoarquivo , arquivo) values('$xcodigo', '$xtabela','$xcoluna', $index, '$tipo',  LOAD_FILE('$arquivo'));";
    //   $resp->alert($query); return $resp;
    $e = $db->Insere_Imagem($query, $resp);
    if ($e == 2) {
        $resp->alert('Erro na inclusão da imagem!');

        return $resp;
    }
    $query = " update pessoa_41010 set $xcoluna = true where xcodigo = '$xcodigo' ";
    $e = $db->Atualiza_Flag_Pessoa($query, $resp);
    //   unlink($arquivo);
    $resp->assign('tela_carga', 'className', 'esconder');
    $resp->assign('tela_alt', 'className', 'mostrar');

    return $resp;
}

function Grava_Telefones($dados)
{
    $resp = new xajaxResponse();
    global $db;
    $codigo = limpaCPF_CNPJ($dados['xcodigo']);
    if (!$dados['xsequenciafone']) {
        $seq = 1;
    } else {
        $seq = $dados['xsequenciafone'];
    }
    $dados_telefone = $db->Leitura_Telefones($codigo, $seq, $resp);
    if (!empty($dados_telefone)) {
        $query = monta_update($dados, $dados_telefone, 'pessoa_41090');
    } else {
        $query = monta_insert($dados, 'pessoa_41090');
    }
    $e = $db->Atualiza_Pessoa($query, $resp);
    if ($e == 2) {
        $resp->alert('Erro na atualização do telefone.'.$query);
    } else {
        $resp->alert('Telefone gravado!');
    }

    return $resp;
}

/**
 * Grava_Dados_endereco
 *
 * @param mixed dados
 *
 * @return void
 */
function Grava_Dados_endereco($dados)
{
    $resp = new xajaxResponse();
    global $db;
    $codigo = limpaCPF_CNPJ($dados['xcodigo']);
    if (!$dados['xsequenciaendereco']) {
        $seq = 1;
    } else {
        $seq = $dados['xsequenciaendereco'];
    }
    $dados_endereco = $db->Leitura_Endereco($codigo, $xseq, $resp);
    if (!empty($dados_endereco)) {
        $query = monta_update($dados, $dados_endereco, 'pessoa_41070');
    } else {
        $query = monta_insert($dados, 'pessoa_41070');
    }
    $e = $db->Atualiza_Pessoa($query, $resp);
    if ($e == 2) {
        $resp->alert('Erro na atualização do endereço.'.$query);
    } else {
        $resp->alert('Endereço gravado!');
    }

    return $resp;
}

function Grava_Dados($dados, $oper)
{
    $resp = new xajaxResponse();
    global $db;
    //   array_shift($dados);
    if ($dados['representante']) {
        $xx = explode('-', $dados['representante']);
        $dados['representante'] = $xx[0];
    }
    if ($dados['creditoresponsavelavaliacao']) {
        $xx = explode('-', $dados['creditoresponsavelavaliacao']);
        $dados['creditoresponsavelavaliacao'] = $xx[0];
    }
    if ($dados['creditoresponsavelvenda']) {
        $xx = explode('-', $dados['creditoresponsavelvenda']);
        $dados['creditoresponsavelvenda'] = $xx[0];
    }
    if ($dados['semvencimentoate']) {
        if (($dados['semvencimentoate'] < 1) || ($dados['semvencimentoate'] > 31)) {
            $resp->alert('Vencimento deve estar entre o primeiro e ultimo  dia do mes.');

            return $resp;
        }
    }
    if ($dados['semvencimentodesde']) {
        if (($dados['semvencimentodesde'] < 1) || ($dados['semvencimentodesde'] > 31)) {
            $resp->alert('Vencimento deve estar entre o primeiro e ultimo  dia do mes.');

            return $resp;
        }
    }
    //   $tabs           =  $db->Meta_Tabela('pessoa_41010', $resp);
    if ($oper === 'A') {
        $codigo = limpaCPF_CNPJ($dados['xcodigo']);
        $dados_pessoa = $db->Leitura_Pessoa($codigo, $resp);
        $query = monta_update($dados, $dados_pessoa, 'pessoa_41010');
//      $resp->alert($query.'  aqui'); return $resp;
        $e = $db->Atualiza_Pessoa($query, $resp);
    } else {
        $query = monta_insert($dados, 'pessoa_41010');
        $e = $db->Atualiza_Pessoa($query, $resp);
    }
    if ($e == 2) {
        $resp->alert('Verifique os dados! '.$e);

        return $resp;
    }
    $resp->assign('tela_carga', 'className', 'esconder');
    $resp->assign('tela_alt', 'className', 'esconder');
    $resp->script('xajax_Tela()');

    return $resp;
}

function monta_insert($dados, $tabela)
{
    $coluna = [];
    $contem = [];
    $dados['xcodigo'] = limpaCPF_CNPJ($dados['xcodigo']);
    $query = ' insert into  '.$tabela.'  (';
    foreach ($dados as $tit => $cont) {
        if ($cont) {
            $coluna[] .= $tit;
            $contem[] .= $cont;
        }
    }
    for ($a = 0; $a < count($coluna); ++$a) {
        $query .= $coluna[$a].' , ';
    }
    $query = rtrim($query, ' , ');
    $query .= ')  values(';

    for ($a = 0; $a < count($coluna); ++$a) {
        $query .= "'$contem[$a]' , ";
    }
    $query = rtrim($query, ' , ');
    $query .= ');';

    return $query;
}

function monta_update($dados, $dados_pessoa, $tabela)
{
    $dados['xcodigo'] = limpaCPF_CNPJ($dados['xcodigo']);
    $dados_pessoa['xcodigo'] = limpaCPF_CNPJ($dados_pessoa['xcodigo']);
    $query = ' update '.$tabela.'  set ';
    $coluna = [];
    $contem = [];
    $colunax = [];
    $contemx = [];
    $xx = 0;
    foreach ($dados as $tit => $cont) {
        $coluna[] .= $tit;
        $contem[] .= $cont;
    }

    foreach ($dados_pessoa as $tit => $cont) {
        $colunax[] .= $tit;
        $contemx[] .= $cont;
    }
    $queryw = ' where ';
    for ($a = 0; $a < count($coluna); ++$a) {
        if (substr($coluna[$a], 0, 1) == 'x') {
            $queryw .= $coluna[$a].'  =  \''.$contem[$a].'\' and ';
        }
        if ((substr($coluna[$a], 0, 1) !== 'x') && ($contem[$a])) {
            $z = array_search($coluna[$a], $colunax);
            //        if ($coluna[$a] == $colunax[$a]) {
            if ($z) {
                if (trim($contem[$a]) !== trim($contemx[$z])) {
                    $query .= $coluna[$a].'  =  \''.$contem[$a].'\' , ';
                    ++$xx;
                }
            }
        }
        //    }
    }
    $queryb .= rtrim($queryw, ' and ');
    $queryx .= rtrim($query, ' , ');
    $queryx .= $queryb;
    if ($xx == 0) {
        $queryx = '';
    }

    return $queryx;
}

function prepara_inclui_pessoa($resp)
{
    global $db;
    $tela = '<form id="prep_inclui" name="prep_inclui">
              <div class="row">
              <div class="col-sm-12">
                <div class="form-group col-sm-2">
                   <b>Tipo Id :</b>'.$db->combo_geral('pessoa_41010', 'tipoidentificacao', '', $resp).'
               </div>
               <div class="form-group col-sm-2"">
                  <b>Código :</b><input type="text" class="form-control" name="xcodigo" id="xcodigo" value="" >
               </div>
               <div id="retorno"></div>
            </div>
             <div class="row">
               <div class="form-group col-sm-12">
                 <div class="form-group col-sm-4">
                 <button type="submit" class="btn btn-primary" onclick="xajax_Retorna(); return false;">Desiste e Retorna</button>
                 <button type="submit" class="btn btn-primary" onclick="xajax_dados_cnpj_cpf(xajax.getFormValues(\'prep_inclui\')); return false;">Valida e Continua</button></div>
               </div>
            </div></div></form>';

    return $tela;
}

function monta_form_pessoa($dados_pessoa = '', $xcodigo = '', $tipo = '', $oper, $resp)
{
    global $db;
    //   $resp->alert(print_r($dados_pessoa,true).' Aqui'); return $resp;
    if ($oper === 'A') {
        $label = 'Altera';
        $rd = 'readonly';
    } else {
        $label = 'Inclusão';
//      $chars             = array(".","/","-");
//      $xcodigo            = str_replace($chars,"",$dados_pessoa['cnpj']);
        $dados_pessoa['xcodigo'] = $xcodigo;
        $dados_pessoa['tipoidentificacao'] = $tipo;

        $dados_pessoa['nomepessoa'] = $dados_pessoa['nome'];
//        $dados_pessoa['fantasia']           =  $dados_pessoa['fantasia'];
        $dados_pessoa['naturezajuridicapessoa'] = $dados_pessoa['natureza_juridica'];
        $dados_pessoa['emailinstitucional'] = $dados_pessoa['email'];
        $rd = '';
    }

    // TODO:  Criar funções para as abas em function separadas
//    enctype="multipart/form-data"
    $tela .= '<div class="col-md-12">
               <div class="panel with-nav-tabs panel-secondary">
                 <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#aba1" data-toggle="tab">Dados Básicos</a></li>
                            <li><a href="#aba2" data-toggle="tab">Dados CRM </a></li>
                            <li><a href="#aba3" data-toggle="tab">Endereços </a></li>
                            <li><a href="#aba4" data-toggle="tab">Telefones </a></li>
                            <li><a href="#aba5" data-toggle="tab">Outros</a></li>
                        </ul>
                       <button type="submit" class="btn btn-primary" onclick="xajax_Grava_Dados(xajax.getFormValues(\'dados_tela_pessoa\'),\''.$oper.'\'); return false;">Gravar os Dados '.$label.'</button>
                       <button type="submit" class="btn btn-warning" onclick="xajax_Retorna(); return false;">Desiste e Retorna</button>
                 </div>
                 <div class="panel-body" style="background-color: #7FDBFF;">
                     <div class="tab-content">
                        <div class="tab-pane fade in active"  id="aba1"><h4>Dados Básicos</h4>
                        <form id="dados_tela_pessoa" name="dados_tela_pessoa"  role="form" method="post">';
    // painel dados básicos
    $tela .= $db->tela_dados_principal($dados_pessoa, $rd, $resp);
    $tela .= '</div>
                      <div class="tab-pane fade" id="aba2"><h4>Dados CRM</h4>';
    $tela .= $db->tela_dados_CRM($dados_pessoa, $resp);
    $tela .= '</form></div>
                       <div class="tab-pane fade" id="aba3"><h4>Endereços</h4>
                        <form id="dados_tela_endereco" name="dados_tela_endereco"  role="form" method="post">';
    $xcodigo = $dados_pessoa['xcodigo'];
    $pessoa_41070 = $db->Leitura_Endereco($xcodigo, '', $resp);
//                        $resp->alert(print_r($pessoa_41070,true).'aqui'); return $resp;
    $tela .= $db->tela_dados_endereco($pessoa_41070, $xcodigo, $resp);
    $tela .= '</form></div>
                      <div class="tab-pane fade" id="aba4"><h4>Telefones</h4>
                        <form id="dados_tela_telefones" name="dados_tela_telefones"  role="form" method="post">';
    $xcodigo = $dados_pessoa['xcodigo'];
    $pessoa_41090 = $db->Leitura_Telefones($xcodigo, '', $resp);
    $tela .= $db->tela_dados_telefones($pessoa_41090, $xcodigo, $resp);
    $tela .= '</form></div>
                      <div class="tab-pane fade" id="aba5"><h4>Dados Adicionais</h4></div>
                     </div>
                 </div>
               </div>
            </div>';

    return $tela;
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

function Carrega_Arquivo($xcodigo, $xtabela, $xcoluna)
{
    $resp = new xajaxResponse();
    $arq_imagem = 'tmp/'.$xcoluna;
    $tela = '<form id="carga_img" name="carga_img" enctype="multipart/form-data" role="form" method="post">
              <fieldset style="border: 2px outset">
             <input type="hidden" name="xcodigo" id="xcodigo" value="'.$xcodigo.'">
             <input type="hidden" name="xtabela" id="xcoluna" value="'.$xtabela.'">
             <input type="hidden" name="xcoluna" id="xcoluna" value="'.$xcoluna.'">
             <div class="row">
               <div class="col-sm-12">
                 <div class="form-group col-sm-4">
                   <label for="arquivo">Escolha o arquivo de imagem:<label><input type="file" class="form-control"  id="imagem_carga" name="imagem_carga" onchange="micoxUpload(this.form,\'carga_arq.php?name='.$arq_imagem.'\',\'recebe_up_3\',\'Carregando...\',\'Erro ao carregar\')" >
                   <div id="recebe_up_3" class="recebe"></div>
                 </div>  
                 <div class="form-group col-sm-3">
                   <button type="submit" class="btn btn-primary" onclick="xajax_GraFGrava_Imagem(xajax.getFormValues(\'carga_img\')); return false;">Carregar!</button>
                   <button type="submit" class="btn btn-primary" onclick="xajax_Rotorna(); return false;">Desiste e  Retorna</button>
                </div>   
               </div>
              </div>  
           </fieldset>
          </form>';

    //   global $db;
    $resp->assign('tela_alt', 'className', 'esconder');
    $resp->assign('tela_carga', 'className', 'mostrar');
    $resp->assign('tela_carga', 'innerHTML', $tela);
    //   $resp->alert('Por enquanto, está em teste '.$xcodigo.' - '.$xcoluna);
    return $resp;
}
/*
CREATE TABLE `pessoa_41050` (
  `xcodigo` varchar(20) NOT NULL COMMENT 'Código',
  `xtabela` varchar(20) NOT NULL COMMENT 'Tabela Origem',
  `xcoluna` varchar(45) NOT NULL COMMENT 'Coluna Imagem',
  `xseqimg` int(3) NOT NULL COMMENT 'Seq',
  `tipoarquivo` varchar(4) DEFAULT NULL COMMENT 'Tipo Arquivo',
  `arquivo` mediumblob DEFAULT NULL COMMENT 'Arquivo ',
  PRIMARY KEY (`xcodigo`,`xtabela`,`xcoluna`,`xseqimg`)
*/
function Visualiza_Arquivo($xcodigo, $xtabela, $xcoluna)
{
    $resp = new xajaxResponse();
    //   if (is_file($temp)) { $resp->assign("div_$xcoluna", "innerHTML", ''); unlink($temp); return $resp; }
    global $db;
    $query = " select max(xseqimg) ind, tipoarquivo from pessoa_41050  where xcodigo = '$xcodigo'  and xtabela = '$xtabela' and xcoluna = '$xcoluna' group by tipoarquivo ";
    $dados_imagem = $db->Busca_Dados_Imagem($query, $resp);
    $tipo = $dados_imagem['tipoarquivo'];
    $temp = 'tmp/'.$xcoluna.'.'.$tipo;
    $query = " select arquivo from pessoa_41050  where xcodigo = '$xcodigo' and xtabela = '$xtabela' and xcoluna = '$xcoluna' ";
    //   $query = " select imagem, max(indice) ind, tipo from pessoa_41010_img  where xcodigo = '$xcodigo' and xcoluna = '$xcoluna' ";
    $imagem = $db->Busca_Imagem($query, $resp);
    //   $resp->alert('Aqui '.$query.'-'.print_r($img, true)); return $resp;
    //   $tipo  = trim($img['tipo']);
    if ($imagem) {
        $fh = fopen($temp, 'w');
        fwrite($fh, $imagem);
        fclose($fh);
//       $tipo  = shell_exec('sudo file '.$temp);
//       $resp->alert($tipo);  return $resp;
        list($larg, $alt) = getimagesize($temp);
        if ($larg > 128) {
            $larg = 128;
        }
        if ($alt > 128) {
            $alt = 128;
        }
        switch ($tipo) {
          case 'gif':
          case 'jpg':
          case 'jpeg':
          case 'png':  $tela_imagem = '<img src="'.$temp.'" id="'.$xcoluna.'" class="magnify" width="'.$larg.'"  height="'.$alt.'">'; break;
          default: $tela_imagem = '<a href="'.$temp.'" id="'.$xcoluna.'" >Abrir Arquivo</a>';
       }
    } else {
        $tela_imagem = 'Deu pobrema';
    }
    //   $resp->alert("Aqui ".$tela_imagem." div_$coluna");
    $resp->assign("div_$xcoluna", 'innerHTML', $tela_imagem);
    //   $resp->script("jQuery($xcoluna).imageMagnify({ magnifyby: 3 })");
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

function dados_cnpj_cpf($dados)
{
    $resp = new xajaxResponse();
    $xcodigo = $dados['xcodigo'];
    $tipo = $dados['tipoidentificacao'];
    if (!$xcodigo) {
        $resp->alert('Digite o código, por facor!');

        return $resp;
    }
    if (!$tipo) {
        $resp->alert('Escolha um tipo de Identificação.');

        return $resp;
    }
    if ($tipo == 3) {
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
    }
    if ($tipo == 20) {
        if ($xcodigo > 0) {
            $teste = validaCPF($xcodigo);
//          $saida   =  array(tipo => $tipo, codigo => $xcodigo);
            if (!$teste) {
                $resp->alert('Número de CPF inválido. Verifique!');

                return $resp;
            }
        }
    }
    //   $resp->alert(print_r($saida, true)); return $resp;
    $tela = monta_form_pessoa($saida, $xcodigo, $tipo, 'I', $resp);
    $resp->assign('tela_alt', 'className', 'mostrar');
    $resp->assign('tela_manut', 'className', 'esconder');
    $resp->assign('tela_alt', 'innerHTML', $tela);
    $resp->script('pesquisa_pessoa()');

    return $resp;
}

 function validaCPF($cpf = null)
 {
     // Verifica se um número foi informado
     if (empty($cpf)) {
         return false;
     }

     // Elimina possivel mascara
     $cpf = preg_replace('/[^0-9]/', '', $cpf);
     $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

     // Verifica se o numero de digitos informados é igual a 11
     if (strlen($cpf) != 11) {
         return false;
     }
     // Verifica se nenhuma das sequências invalidas abaixo
     // foi digitada. Caso afirmativo, retorna falso
     elseif ($cpf == '00000000000' ||
    $cpf == '11111111111' ||
    $cpf == '22222222222' ||
    $cpf == '33333333333' ||
    $cpf == '44444444444' ||
    $cpf == '55555555555' ||
    $cpf == '66666666666' ||
    $cpf == '77777777777' ||
    $cpf == '88888888888' ||
    $cpf == '99999999999') {
         return false;
     // Calcula os digitos verificadores para verificar se o
   // CPF é válido
     } else {
         for ($t = 9; $t < 11; ++$t) {
             for ($d = 0, $c = 0; $c < $t; ++$c) {
                 $d += $cpf[$c] * (($t + 1) - $c);
             }
             $d = ((10 * $d) % 11) % 10;
             if ($cpf[$c] != $d) {
                 return false;
             }
         }

         return true;
     }
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
        $dados['uf'] = $retx['uf'];
        $dados['bairro'] = $retx['bairro'];
        $dados['logradouro'] = $retx['logradouro'];
    } else {
        $resp->alert('Cep inválido, verifique');
    }
    $resp->assign('uf', 'value', $retx['uf']);
    $resp->assign('bairro', 'value', $retx['bairro']);
    $resp->assign('logradouro', 'value', $retx['logradouro']);
//     $resp->alert(print_r($dados, true).' aqui - ');
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

function Retorna()
{
    $resp = new xajaxResponse();
    $resp->assign('tela_carga', 'className', 'esconder');
    $resp->assign('tela_alt', 'className', 'esconder');
    $resp->assign('tela_manut', 'className', 'mostrar');
    $resp->script('tabela()');

    return $resp;
}
function Exclui_Pessoa($codigo)
{
    $resp = new xajaxResponse();
    //   global $db;
    $resp->alert('Por enquanto, nao estaremos excluindo nenhum registro deste cadastro.');

    return $resp;
}
