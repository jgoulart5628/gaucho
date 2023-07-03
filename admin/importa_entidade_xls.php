<?php
   header('Cache-control: private, no-cache');
   header('Expires: Mon, 26 Jun 1997 05:00:00 GMT');
   ini_set('date.timezone', 'America/Sao_Paulo');
   ini_set('memory_limit', -1);
   ini_set('default_charset', 'UTF-8');
   ini_set('display_errors', true);
// $header = Header("Pragma: no-cache");
// error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
error_reporting(E_ALL);
require_once __DIR__.'/src/SimpleXLSX.php';
// error_reporting(E_ALL & ~(E_NOTICE));
define('ROOT', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
require ROOT.DS.'autoload.php';
   $db = new banco_Dados('MYSQL_gaucho');
   $lista_xls = [];
   foreach (new DirectoryIterator('./XLS') as $file) {
       if (substr($file, 0, 1) != '.') {
           $arqx = explode('.', $file);
           if (substr($arqx[1],0,3) === 'xls') {
               $lista_xls[] .= $file;
           }
       }
   }
//   $query = 'select nada from produto';
//   $e = $db->Executa_Query_Array($query);
//   print_r($e);
require_once '../xajax/xajax_core/xajax.inc.php';
$xajax = new xajax();
   // $xajax->configure('debug',true);
   $xajax->configure('errorHandler', true);
   $xajax->configure('logFile', 'xajax_error_log.log');
   $xajax->register(XAJAX_FUNCTION, 'Tela');
   $xajax->register(XAJAX_FUNCTION, 'Gera_Insert');
   $xajax->register(XAJAX_FUNCTION, "Exclui_Insert");
   $xajax->register(XAJAX_FUNCTION, "Executa_SQL_Insert");
   $xajax->processRequest();
   $xajax->configure('javascript URI', '../xajax/');
?>
<html>
<head>
    <title>Criação de Scripts SQL via XSLX</title>
    <style type="text/css">
     html { font: small/1.4 "Lucida Grande", Tahoma, sans-serif;    }
    </style>
    <link href="../css/style_menu.css" rel="stylesheet" type="text/css" />
    <link href="../css/main.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    <link href="../css/style_menu.css" rel="stylesheet" type="text/css" />
    <link href="../css/main.css" rel="stylesheet" type="text/css" />
    <script src="../js/fontawesome.min.js"></script>
    <script  type="text/javaScript" src="../js/jquery.min.js"></script>
    <script type="text/javaScript"  src="../js/bootstrap.min.js"></script>
 <?php $xajax->printJavascript('../xajax'); ?>
</head>
<body>
<body>
    <form id="tela" name="tela" method="POST">
       <div class="container-fluid">
         <h3>Escolha de Tabelas </h3>
          <div class="col-sm-12"> 
           <div class="row">
             <div class="col-sm-4">
               <div id="tela_xls" class="fundo"></div> 
             </div>
             <div class="col-sm-2">
               <div id="tela_sql"></div> 
             </div> 
             <div class="col-sm-6">
               <div id="tela_insert" class="fundo"></div> 
            </div> 
          </div>
       </div>
      </div> 
    </form>    
    <script type="text/javaScript">xajax_Tela();</script>
</body>
</html>

<?php
function Tela()
{
    $resp = new xajaxResponse();
    // metadados tabelas
    global $db;
    global $lista_xls;
    $lista_insert = [];
    foreach (new DirectoryIterator('./Inserts') as $file) {
        if (substr($file, 0, 1) != '.') {
            $arqx = explode('.', $file);
            if ($arqx[1] === 'sql') {
                $lista_insert[] .= $file;
            }
        }
    }
    sort($lista_insert);
    sort($lista_xls);
//    $resp->alert(count($lista_xls).' Teste'); return $resp;
    $dir = __DIR__;
    // lista _XLS
    $tela = '<div><h5>Arquivos - XLSX #'.count($lista_xls).'</h5><table width="100%">';
    for ($i = 0; $i < count($lista_xls); ++$i) {
        $disab1 = '';
        $arq = $lista_xls[$i];
        $nom = explode('.', $arq);
        $rt = substr($nom[0],0,2);
        $query = " select count(*) ents from entidade ent  where ent.RT  =  '$rt'";
        $conta = $db->Executa_Query_Unico($query, $resp);
        $tela .= '<tr><td align="left" class="form-control"><h5>'.$arq.'  '.$conta.'</h5></td>';
        $tela .= '<td><button type="submit" class="btn btn-primary" onclick="xajax_Gera_Insert(\''.$arq.'\'); return false;">Gerar Insert</button></td>';
        $tela .= '</tr>';
    }
    $tela .= '</table></div>';

    $resp->assign('tela_xls', 'innerHTML', $tela);

    // sql
    // $resp->assign('tela_sql', 'innerHTML', $telax);
    // inserts
    $disab = '';
    $telai = '<div><h5>Arquivos Insert - SQL </h5><div id="Dados"></div></div><table width="100%">';
//        $resp->alert(print_r($lista_insert, true)); return $resp;
    for ($i = 0; $i < count($lista_insert); ++$i) {
        $arqx = explode('.', $lista_insert[$i]);
        if ($arqx[1] === 'sql') {
            $arq = $lista_insert[$i];
            $tabela = $arqx[0];
//                $num = $db->Executa_Query_Unico(" select count(*) conta from $tabela ", $resp);
//                $resp->alert($num.' aqui '.$tabela); return $resp;
//                if ($num > 0) { $disab = "disabled"; } else { $disab = '';
            $arq1 = 'Inserts/'.$arq;
            $telai .= '<tr><td align="left" class="form-control"><h5>'.$arq.'</h5></td>
                         <td align="right"><button type="submit" class="btn btn-primary"  onclick="xajax_Executa_SQL_Insert(\''.$arq1.'\'); return false;">Executar SQL</button></td>
                         <td align="center"><button type="submit" class="btn btn-danger"  onclick="xajax_Exclui_Insert(\''.$arq1.'\'); return false;">Excluir</button></td>';
        }
        $telai .= '</tr>';
    }
//        }
    $telai .= '</table></div>';
    $resp->assign('tela_insert', 'innerHTML', $telai);

    return $resp;
}

function Gera_Insert($arqx)
{
    $resp = new xajaxResponse();
    $nom = explode('.', $arqx);
    $rt = substr($nom[0],0,2);
    $plan = './XLS/'.$arqx;
    $entidade = 'Inserts/entidade_'.$rt.'.sql';
    $endere   = 'Inserts/endere_'.$rt.'.sql';
    if (file_exists($entidade)) {
        @unlink($entidade);
    }
    if (file_exists($endere)) {
        @unlink($endere);
    }
    $fent = fopen($entidade, 'w');
    $fend = fopen($endere, 'w');

    $ins = '';
    if ( $xlsx = SimpleXLSX::parse($plan) ) {
       $tab = $xlsx->rows();
       $tits = '';
       for ($a = 0; $a < count($tab); $a++)  {
           if (($tab[$a][0] === 'NÚMERO') || ($tab[$a][0] === 'MATRÍCULA')) {
              $tits = $tab[$a];
           } 
           if (is_numeric($tab[$a][0])) {
              $linha = $tab[$a]; 
              if (!is_array($tits)) {
                 $resp->alert('Erro montando titulos da planilha.'.$tits); return $resp; 
              }
              $ins = inclui_entidade($linha, $rt, $tits, $resp);
              fwrite($fent, $ins);
              $ins = inclui_endere($linha, $tits, $resp);
              fwrite($fend, $ins);
            }
       }
     
    } else {
      $resp->alert(SimpleXLSX::parseError()); return $resp;
    }
    fclose($fent);
    fclose($fend);
    $telat = '';
    for ($a = 0; $a < count($tits); $a++) {
        $telat .= '<p>'.$tits[$a].'</p>';
    }
    $resp->assign('tela_sql', 'innerHTML', $telat); 
  
    // loop leitura aquivo
    $resp->redirect($_SERVER['PHP_SELF']);
    return $resp;
}


function inclui_entidade($data, $rt, $tits, $resp)  {
//    global $db;
    $sigla = ' ';
    $telefone_resp1 = ' ';
    $email_resp1 = ' ';
    for ($a = 0; $a < count($tits); $a++) {
       switch ($tits[$a]) {
         case 'NÚMERO': break; 
         case 'MATRÍCULA':
         case 'MATRICULA':    $entidade_id = $data[$a]; break;
         case 'SIGLA': $sigla = $data[$a]; break;
         case 'ENTIDADE':
         case 'CTG': $nome_entidade = limpa_texto($data[$a]); break;
         case 'CNPJ': $cnpj = limpa_CNPJ($data[$a]); break;
         case 'FUNDAÇÃO': $data_funda = date('Y-m-d', strtotime($data[$a])); break;
         case 'FONE DO PATRÃO': $telefone_resp1 = $data[$a]; break;
         case 'PATRÃO': $resp1 = limpa_texto($data[$a]); break;
       }
    }
    if (!$cnpj || $cnpj == 'NÃO TEM') {
        $cnpj = 0;
    }
    $ins = " insert into entidade (entidade_id, sigla, nome_entidade, RT, cnpj, data_funda, telefone_resp1, email_resp1, resp1) "
  . " values($entidade_id, '$sigla', '$nome_entidade', '$rt', '$cnpj', '$data_funda', '$telefone_resp1','$email_resp1', '$resp1');".PHP_EOL;
    return $ins;
}

function inclui_endere($data, $tits, $resp) {
 //   global $db;
    $tipo_end = 1;
    for ($a = 0; $a < count($tits); $a++) {
      switch ($tits[$a]) {
        case 'MATRÍCULA': 
        case 'MATRICULA': $end_id = $data[$a]; break;
        case 'ENDEREÇO': $logradouro = $data[$a]; break;
        case 'NÚMERO': $numero = $data[$a]; break;
        case 'BAIRRO': $bairro = $data[$a]; break;
        case 'CEP': $cep = limpa_CNPJ($data[$a]); break;
        case 'ESTADO': $uf = $data[$a]; break;
        case 'CIDADE': $cidade = $data[$a]; break;
      }
    }
    if (!$cep) { $cep = 0; }
    $ins = 'insert into endereço (end_id, tipo_end, logradouro, numero, bairro, cep, uf, cidade) '
   . " values($end_id, $tipo_end, '$logradouro','$numero','$bairro', $cep, '$uf', '$cidade');".PHP_EOL;
    return $ins;
}
 
function limpa_CNPJ($valor)
{
    $valor = trim($valor);
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '', $valor);
    $valor = str_replace('-', '', $valor);
    $valor = str_replace('/', '', $valor);
    $valor = str_replace('"', '', $valor);
    $valor = preg_replace('/\s+/', '', $valor);
    $valor = preg_replace('/\xc2\xa0/', '', $valor);
    $valor = str_replace("\U00a0", "", $valor);
    return $valor;
}
function limpa_texto($text)
{
    $text = trim($text);
    $text  = str_replace("'", '', $text);
    return $text;
}
function Exclui_Insert($arq)
{
    $resp = new xajaxResponse();
    unlink($arq);
    $resp->redirect($_SERVER['PHP_SELF']);
    return $resp;
}
function Executa_SQL_Insert($arq)
{
    $resp = new xajaxResponse();
    //  $resp->alert($arq);  return $resp;
    $script = 'sudo -i echo `cat '.$arq.' | mysql -u root -pjogola01 --default-character-set=utf8 --force gaucho 2>&1` > erro';
    shell_exec($script);
    $erro   = file(erro);
    $tela = '';
    if (filesize(erro) > 10) {
        foreach($erro as $msg) {
            $tela .= $msg;
        }  
        $resp->alert($tela); 
        //  unlink(erro);
    }    
    $resp->script("xajax_Tela();");
    return $resp;
}
