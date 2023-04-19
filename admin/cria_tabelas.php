<?php
   header('Cache-control: private, no-cache');
   header('Expires: Mon, 26 Jun 1997 05:00:00 GMT');
   ini_set('date.timezone', 'America/Sao_Paulo');
   ini_set('memory_limit', -1);
   ini_set('default_charset', 'UTF-8');
   ini_set('display_errors', true);
// $header = Header("Pragma: no-cache");
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
// error_reporting(E_ALL & ~(E_NOTICE));
define('ROOT', dirname(__DIR__));
define('DS', DIRECTORY_SEPARATOR);
require ROOT.DS.'autoload.php';
   $db = new acesso_db('MYSQL_gaucho');
   $lista_csv = [];
   foreach (new DirectoryIterator('./') as $file) {
       if (substr($file, 0, 1) != '.') {
           $arqx = explode('.', $file);
           if ($arqx[1] === 'csv') {
               $lista_csv[] .= $file;
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
   $xajax->processRequest();
   $xajax->configure('javascript URI', '../xajax/');
?>
<html>
<head>
    <title>Criação de Scripts SQL via CSV</title>
    <style type="text/css">
     html { font: small/1.4 "Lucida Grande", Tahoma, sans-serif;    }
    </style>
    <link href="../css/style_menu.css" rel="stylesheet" type="text/css" />
    <link href="../css/main.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    <link href="../css/style_menu.css" rel="stylesheet" type="text/css" />
    <link href="../css/main.css" rel="stylesheet" type="text/css" />
    <script src="https://use.fontawesome.com/b2f0b70c9f.js"></script>
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
               <div id="tela_csv" class="fundo"></div> 
             </div>
             <div class="col-sm-3">
               <div id="tela_sql" class="fundox"></div> 
             </div> 
             <div class="col-sm-3">
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
    global $lista_csv;
    $lista_insert = [];
    sort($lista_csv);
//      $resp->alert(count($lista_csv).' Teste'); return $resp;
    $dir = __DIR__;
    // lista _CSV
    $tela = '<div><h5>Arquivos - CSV #'.count($lista_csv).'</h5><table width="100%">';
    for ($i = 0; $i < count($lista_csv); ++$i) {
        $disab1 = '';
        $arq = $lista_csv[$i];
        $contar = 0;
        $file = file($arq);
        for ($x = 7; $x < count($file); ++$x) {
            if (substr($file[$x], 0, 3) !== ';;;') {
                ++$contar;
            }
        }
        if ($contar > 0) {
            $disab1 = '';
        } else {
            $disab1 = 'disabled';
        }
        $nom = explode('.', $arq);
        $tabela = $nom[0];
//            $tabela = str_replace(' (vazia)', '',strtolower($nom[0]) );
//            $resp->alert($tabela.' - '); return $resp;
        $query = " SELECT count(*) conta  FROM information_schema.TABLES where TABLE_SCHEMA = 'gaucho' and table_name = '$tabela' ";
        $nr = $db->Executa_Query_Unico($query, $resp);
        if ($nr > 0) {
            $disab = 'disabled';
        } else {
            $disab = '';
        }
        $tela .= '<tr><td align="left" class="form-control"><h5>'.$arq.'</h5></td>';
        $tela .= '<td><button type="submit" class="btn btn-primary" onclick="xajax_Gera_Insert(\''.$arq.'\'); return false;">Gerar Insert</button></td>';
        $tela .= '</tr>';
    }
    $tela .= '</table></div>';

    $resp->assign('tela_csv', 'innerHTML', $tela);

    // sql
    $resp->assign('tela_sql', 'innerHTML', $telax);
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
        $telax .= '</tr>';
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
    $tabela = $nom[0];
    //  $tabela = str_replace(' (vazia)', '',strtolower($nom[0]) );
    //  $tabela = strtolower($nom1[1]).'_'.$num;
    // $resp->alert($arqx.' - '.$nom.' - '.$tabela); return $resp;
    //global $db;
    //$query = " select column_name as coluna, is_nullable as nulo , data_type tipo , character_maximum_length as tam from information_schema.COLUMNS where table_schema = 'gaucho' and table_name = '$tabela' ";
    // $tabs = $db->Executa_Query_Array($query, $resp);
    // $resp->alert(' Total: '.count($tabs).' - '.$query);   return $resp;
    // loop leitura aquivo
    $insert = 'Inserts/'.$tabela.'.sql';
    if (file_exists($insert)) {
        @unlink($insert);
    }
    $fh = fopen($insert, 'w');
    $arq = [];
    $arqz = file($arqx);
    for ($a = 0; $a < count($arqz); ++$a) {
        $arq[$a] = str_replace(";\r\n", "\r\n", $arqz[$a]);
    }
//    $resp->alert('Aqui  - '.count($arq));    return $resp;

    for ($x = 1; $x < count($arq); ++$x) {
        $data = explode(';', $arq[$x]);
//        $resp->alert('Aqui  - '.print_r($data, true));  return $resp;
        $email_resp1 = $data[11];

        if (!$email_resp1) {
            $email_resp1 = '""';
        }
        $cnpj = limpa_CNPJ($data[4]);
        if (!$cnpj || $cnpj == 'NÃO TEM') {
            $cnpj = 0;
        }
        $data_fundação = date('Y-m-d', strtotime($data[5]));
        //       $resp->alert(print_r($data, true).' passei aqui'.$cnpj.'-'.$data_fundação.'-'.$email_resp1);       return $resp;

        $ins = "insert into $tabela  (entidade_id, sigla, nome_entidade, RT, cnpj, data_fundação, telefone_resp1, email_resp1, resp1, matricula) 
                 values($data[0],$data[1],$data[2],$data[3],$cnpj, '$data_fundação',$data[10],$email_resp1,$data[12],$data[0]) ;".PHP_EOL;
        fwrite($fh, $ins);
    }

    fclose($fh);
    $resp->alert('Arquivo '.$insert.' Gerado. '.$x.' Registros');

    $ender = 'Inserts/endereço.sql';
    if (file_exists($ender)) {
        @unlink($ender);
    }
    $fh = fopen($ender, 'w');
//    $arq = [];
//    $arqz = file($arqx);
//    for ($a = 0; $a < count($arqz); ++$a) {
//        $arq[$a] = str_replace(";\r\n", "\r\n", $arqz[$a]);
//    }

//    $resp->alert('Aqui  - '.count($arq));    return $resp;

    for ($x = 1; $x < count($arq); ++$x) {
        $data = explode(';', $arq[$x]);
        /*
        `end_id` int(5) NOT NULL,
        `tipo_end` int(2) NOT NULL COMMENT 'Tipo Endereço',
        `logradouro` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Logradouro',
        `numero` int(10) DEFAULT NULL COMMENT 'Nro',
        `complemento` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Complemento',
        `bairro` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Bairro',
        `distrito` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Distrito',
        `cep` int(8) DEFAULT NULL COMMENT 'CEP',
        `uf` char(2) DEFAULT NULL COMMENT 'UF',
        `cidade` varchar(40) DEFAULT NULL COMMENT 'Cidade',
      */
//        $resp->alert('Aqui  - '.print_r($data, true));  return $resp;
        $end_id = $data[0];
        $tipo_end = 1;

        $logradouro = $data[6];

        if (!$logradouro) {
            $logradouro = '""';
        }

        //       $resp->alert(print_r($data, true).' passei aqui'.$cnpj.'-'.$data_fundação.'-'.$email_resp1);       return $resp;

        $ins = "insert into endereço (end_id, tipo_end, logradouro, cep, uf, cidade) 
                 values($end_id, $tipo_end, $logradouro, $data[7], $data[9], $data[8]) ;".PHP_EOL;
        fwrite($fh, $ins);
    }

    fclose($fh);
    $resp->alert('Arquivo endereço Gerado. '.$x.' Registros');

    $resp->redirect($_SERVER['PHP_SELF']);

    return $resp;
}

function limpa_CNPJ($valor)
{
    $valor = trim($valor);
    $valor = str_replace('.', '', $valor);
    $valor = str_replace(',', '', $valor);
    $valor = str_replace('-', '', $valor);
    $valor = str_replace('/', '', $valor);
    $valor = str_replace('"', '', $valor);

    return $valor;
}
