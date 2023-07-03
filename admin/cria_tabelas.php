<?php
   Header("Cache-control: private, no-cache");
   Header("Expires: Mon, 26 Jun 1997 05:00:00 GMT");
   ini_set('date.timezone', 'America/Sao_Paulo');
   ini_set("memory_limit", -1);
   ini_set('default_charset', 'UTF-8');
   ini_set('display_errors', true);
// $header = Header("Pragma: no-cache");
//   select prdbascodint, prdbastpcodint, prdbasnomcoml, prdregnomtec, prdregnroreg, prdbasrestrito from produto;
   error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
//   error_reporting(E_ALL & ~(E_NOTICE));
   require "../inc/Classes_Dados.php";
   $db  = new getDados_model('MYSQL_deal');
   require_once "../xajax/xajax_core/xajax.inc.php";
   $lista_csv    = array();
   $lista_json   = array();
foreach(new DirectoryIterator('./') as $file)  {
    if (substr($file, 0, 1) <> '.') {
          $arqx = explode('.', $file);
        if ($arqx[1] === 'csv') {
            if(substr($arqx[0], 0, 4) === 'json') {
                $lista_json[] .= $file; 
            } else { $lista_csv[] .= $file; 
            }
        }
    }
}
//   $query = 'select nada from produto';
//   $e = $db->Executa_Query_Array($query);
//   print_r($e);
   $xajax = new xajax();
   // $xajax->configure('debug',true);
   $xajax->configure('errorHandler', true);
   $xajax->configure('logFile', 'xajax_error_log.log');  
   $xajax->register(XAJAX_FUNCTION, "Tela");
   $xajax->register(XAJAX_FUNCTION, "Gera_DDL");
   $xajax->register(XAJAX_FUNCTION, "Gera_DDL_GERAL");
   $xajax->register(XAJAX_FUNCTION, "Gera_JSON");
   $xajax->register(XAJAX_FUNCTION, "Gera_Insert");
   $xajax->register(XAJAX_FUNCTION, "Exclui_Insert");
   $xajax->register(XAJAX_FUNCTION, "Gera_Insert_Geral");
   $xajax->register(XAJAX_FUNCTION, "Executa_SQL_DDL");
   $xajax->register(XAJAX_FUNCTION, "Executa_SQL_Insert");
   $xajax->register(XAJAX_FUNCTION, "Arquiva_CSV");
   $xajax->register(XAJAX_FUNCTION, "Drop_Tab");
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
            <div><button type="submit" class="btn btn-success"  onclick="xajax_Gera_DDL_GERAL(); return false;">Gerar DDL GERAL</button><button type="submit" class="btn btn-danger"  onclick="xajax_Gera_Insert_Geral(); return false;">Gerar Insert Geral</button></div>
          <div class="col-sm-12"> 
           <div class="row">
             <div class="col-sm-4">
               <div id="tela_csv" class="fundo"></div> 
             </div> <?php if(count($lista_json) > 0) { echo 
                    '<div class="col-sm-3">
               <div id="tela_json" class="fundo"></div> 
             </div> ';
                    } ?>
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
    global $lista_json;
    $lista_sql    = array();
    $lista_insert = array();
    //    $xx = $db->select('pessoa_49010', '*','','', $resp); 
    //    $resp->alert('Aqui '.print_r($lista_csv, true));  return $resp;

    foreach(new DirectoryIterator('DDL/') as $file)  {
        if (substr($file, 0, 1) <> '.') {
            $arqx = explode('.', $file);
            if ($arqx[1] === 'sql') {
                $lista_sql[] .= $file;
            }   
        }
    }

    foreach(new DirectoryIterator('Inserts/') as $file)  {
        if (substr($file, 0, 1) <> '.') {
            $arqx = explode('.', $file);
            if ($arqx[1] === 'sql') {
                $lista_insert[] .= $file;
            }   
        }
    }

      sort($lista_json);
      sort($lista_csv);
      sort($lista_sql);
      sort($lista_insert);
    //      $resp->alert(count($lista_csv).' Teste'); return $resp;
      $dir =  __DIR__;
      // lista _CSV
      $tela  = '<div><h5>Arquivos - CSV #'.count($lista_csv).'</h5><table width="100%">';
    for ($i = 0; $i < count($lista_csv); $i++) {
        $disab  = '';
        $disab1 = '';
        $arq    =  $lista_csv[$i];
        $contar =  0;
        $file   =  file($arq);
        for ($x = 7; $x < count($file); $x++)  {
            if (substr($file[$x], 0, 3) !== ';;;') {  
                  $contar++;
            }   
        }        
        if ($contar > 0) {  $disab1 = ''; 
        } else { $disab1 = "disabled"; 
        }
        $nom    = explode('.', $arq);
        $tabela = $nom[0];
        //            $tabela = str_replace(' (vazia)', '',strtolower($nom[0]) );
        //            $resp->alert($tabela.' - '); return $resp;
        $query = " SELECT count(*) conta  FROM information_schema.TABLES where TABLE_SCHEMA = 'deal' and table_name = '$tabela' ";
        $nr    = $db->Executa_Query_Unico($query, $resp); 
        if ($nr > 0) { $disab = "disabled"; 
        } else { $disab = ''; 
        }
        if ($nr > 0) { 
            $num = $db->Executa_Query_Unico(" select count(*) conta from $tabela ", $resp);
            if ($num > 1) { $disab1 = "disabled"; 
            } else { $disab1 = '';
            }
        }
        $tela .= '<tr><td align="left" class="form-control"><h5>'.$arq.'</h5></td>';
        $tela .= '<td><button type="submit" class="btn btn-primary" '.$disab.' onclick="xajax_Gera_DDL(\''.$arq.'\'); return false;">Gerar DDL</button></td><td><button type="submit" class="btn btn-primary" '.$disab1.' onclick="xajax_Gera_Insert(\''.$arq.'\'); return false;">Gerar Insert</button></td>';
        if ($disab) {
            $tela .= '<td><button type="submit" class="btn btn-primary" onclick="xajax_Drop_Tab(\''.$tabela.'\'); return false;">Apagar Tabela</button></td>';
        }  
        if ($disab) {
            $tela .= '<td><button type="submit" class="btn btn-primary" onclick="xajax_Arquiva_CSV(\''.$arq.'\'); return false;">Arquivar CSV</button></td>';
        }   
        $tela .= '</tr>';
    }
        $tela .= '</table></div>';

        $resp->assign("tela_csv", "innerHTML", $tela);

        // Tela Json
    if (count($lista_json) > 0) {
        $telaj = '<div>
                 <h5>Arquivos - JSON #'.count($lista_json).'</h5>
                 <div id="GeradoJ"></div><table width="100%">';
        for ($i = 0; $i < count($lista_json); $i++) {
            $disab  = '';
            $disab1 = '';
            $arq    =  $lista_json[$i];
            $contar =  0;
            $file   =  file($arq);
            for ($x = 3; $x < count($file); $x++)  {
                if (substr($file[$x], 0, 3) !== ';;;') {  
                    $contar++;
                }   
            }        
            if ($contar > 0) {  $disab1 = ''; 
            } else { $disab1 = "disabled"; 
            }
            $nom    = explode('.', $arq);
            $tabela = $nom[0];
            //            $tabela = str_replace(' (vazia)', '',strtolower($nom[0]) );
            $telaj .= '<tr><td align="left" class="form-control"><h5>'.$arq.'</h5></td>';
            $telaj .= '<td align="right"><button type="submit" class="btn btn-primary" '.$disab.' onclick="xajax_Gera_JSON(\''.$arq.'\'); return false;">Gerar JSON</button></td>';
            $telaj .= '<td><button type="submit" class="btn btn-primary" '.$disab1.' onclick="xajax_Arquiva_CSV(\''.$arq.'\'); return false;">Arquivar CSV</button></td>';
            $telaj .= '</tr>';
        }
            $telaj .= '</table></div>';

            $resp->assign("tela_json", "innerHTML", $telaj);
    }
        // sql 

        $telax = '<div><h5>Arquivos - DDL/SQL</h5><div id="Gerado"></div><table width="100%">';
    for ($i = 0; $i < count($lista_sql); $i++) {
        $arqx = explode('.', $lista_sql[$i]);
        if ($arqx[1] === 'sql') {
            $arq  =  $lista_sql[$i];
            $tabela  = $arqx[0];
            $query = " SELECT 1  FROM information_schema.TABLES WHERE table_schema = 'deal' and table_name = '$tabela' ";
            $nr    = $db->Executa_Query_NRows($query, $resp); 
            if ($nr > 0) { $disab = "disabled"; 
            } else { $disab = ''; 
            }
            // pesquisar se existe tabela  aqui *******************************************
            // $link =  "'".$arq."'";
            $arq1 = 'DDL/'.$arq;
            $telax .= '<tr><td align="left" class="form-control"><h5>'.$arq.'</h5></td>
                         <td align="right"><button type="submit" class="btn btn-primary" '.$disab.' onclick="xajax_Executa_SQL_DDL(\''.$arq1.'\'); return false;">Executar SQL</button></td>
                         <td align="center"><button type="submit" class="btn btn-danger"  onclick="xajax_Exclui_Insert(\''.$arq1.'\'); return false;">Excluir</button></td>';
        }
        $telax .= '</tr>';
    }
        $telax .= '</table></div';
        $resp->assign("tela_sql", "innerHTML", $telax);
        // inserts 
        $disab = '';
        $telai = '<div><h5>Arquivos Insert - SQL </h5><div id="Dados"></div></div><table width="100%">';
    //        $resp->alert(print_r($lista_insert, true)); return $resp;
    for ($i = 0; $i < count($lista_insert); $i++) {
        $arqx = explode('.', $lista_insert[$i]);
        if ($arqx[1] === 'sql') {
            $arq    =  $lista_insert[$i];
            $tabela =  $arqx[0];
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
        $resp->assign("tela_insert", "innerHTML", $telai);
       return $resp;
}


function Gera_Insert($arqx)
{
    $resp   = new xajaxResponse();
    $nom = explode('.', $arqx);
    $tabela = $nom[0];
    //  $tabela = str_replace(' (vazia)', '',strtolower($nom[0]) );
    //  $tabela = strtolower($nom1[1]).'_'.$num;
    //  $resp->alert($arqx.' - '.$nom1.' - '.$num.' - '.$tabela.' - '.$insert); return $resp;
    global $db;
    $query = " select column_name as coluna, is_nullable as nulo , data_type tipo , character_maximum_length as tam from information_schema.COLUMNS where table_schema = 'deal' and table_name = '$tabela' ";
    $tabs = $db->Executa_Query_Array($query, $resp);
    //  $resp->alert(' Total: '.count($tabs).' - '.$query); return $resp;
    // loop leitura aquivo
    $i = 0;
    $insert =  'Inserts/'.$tabela.'.sql';
    if (file_exists($insert)) { @unlink($insert); 
    }
    $fh     =  fopen($insert, "w");
    $arq    =  array();
    $arqz   =  file($arqx);
    for($a=0; $a < count($arqz); $a++)  {
        $arq[$a] = str_replace(";\r\n", "\r\n", $arqz[$a]);
    }
    for ($x = 0; $x < count($arq); $x++)  {
        //     $dad = str_replace("\r\n","",$dad);   
        //     $dad = str_replace("x0d", "",$dad);
        //     $dad = str_replace("x0a", "",$dad);
        //   $dad = str_replace('"', "",$dad);
        //   $ins = "insert into $tabela values(";
        if (substr($arq[$x], 0, 2) !== ';;') {  
            if (substr($arq[$x], 0, 1) == ';') {  
                $data = explode(";", $arq[$x]);
                $z = count($tabs) + 1;  
                //        reset($data);
                $b = 0;
                // loop linha
                $ins = "insert into $tabela  values(";
                //        $resp->alert(print_r($data,true).' passei aqui'.$z); return $resp; 
                if(($data[1]) &&  ($data[1] <> 0)) {
                    for ($a = 1; $a < $z; $a++)   {
                        //         $col  = $tabs[$b]['coluna'];
                        $tipo = $tabs[$b]['tipo'];
                        $nulo = $tabs[$b]['nulo'];
                        $tam  = $tabs[$b]['tam'];
                        //      echo $coluna.'-'.$tipo.'-'.$campo.'</br>';
                        $dado = trim($data[$a]);
                        $dado = str_replace('"', '', $dado); 
                        $dado = str_replace("'", '', $dado);
                        $dado = str_replace(",", '.', $dado);
                        if ($b > 0) { $ins .=  ', '; 
                        }
                        switch (substr($tipo, 0, 3))  {
                        case 'cha':
                        case 'var':
                        case 'tex':  if (substr($dado, 0, 4) === 'Null') { $ins .= $dado; break; 
                        }
                        if(is_null($dado) && $nulo === 'Y') { $dado =  'Null';   $ins .= $dado;  break; 
                        }
                        if (is_numeric($dado)) { $ins .= '"'.ltrim($dado, '0').'"';  break; 
                        }
                          $dadx = trim($dado, "'");  
                        if($tam > 0 && strlen($dadx) > $tam) { $dado = substr($dadx, 0, $tam); 
                        }  
                          $ins .= '"'.$dado.'"'; 
                            break;
                        case 'tin': if($dado === 'S') { $dado = 1; 
                        } else { $dado = 0;
                        }  $ins .= $dado; 
                            break;
                        case 'num':
                        case 'int':
                        case 'dec': if (!$dado) {  $dado = 0;  
                        } 
                        //                             if (!is_numeric($dado))   {  $dado = 0;  } 
                        $ins .= $dado; 
                            break;
                        case 'dat':
                        case 'tim': if (substr($dado, 0, 4) === 'Null') { $ins .= $dado; break; 
                        }
                        $ins .= '"'.$dado.'"'; 
                            break; 
                        default:  $ins .= '"'.$dado.'"'; 
                            break;
                        }
                        $b++;
                    }   
                    //loop dados
                    $ins .= ');'.PHP_EOL;
                    fwrite($fh, $ins);
                    $i++;
                }
            }
        }
        //       $e = $db->Executa_Query_SQL($ins, $resp);
    }

    fclose($fh);
    if ($i > 0) { $resp->alert('Arquivo '.$insert.' Gerado. '.$i.' Registros'); 
    } else { unlink($insert); 
    }
    $resp->redirect($_SERVER['PHP_SELF']);
    return $resp;
}

function Gera_JSON($arqx)
{
    $resp = new xajaxResponse();
    $arq  = file($arqx);
    $nom = explode('.', $arqx);
    $tabela = $nom[0];

    //else {
    //  $resp->alert('Arquivo '.$arquivo); return $resp; 
    // }
    $json = array();
    for ($a = 3; $a < count($arq); $a++)  {
        $cols = explode(';', $arq[$a]);
        $cod  = $cols[1];
        $var  = $cols[2];
        $json[$cod] = $var; 
    }
    //  $json .= PHP_EOL;  
    $jas = json_encode($json);
    //  $resp->alert('Arquivo '.print_r($json,true)); return $resp;
    $arq   = '../tabsjson/'.$tabela.'.json'; 
    //  $tmp = 'temp/'.$tabela.'.json';
    $handle = fopen($arq, "w");
    fwrite($handle, ($jas));
    fclose($handle);
    /*
    $tela = '</p>
             <input type="hidden" name="tabela"  value="">
             <button type="submit" class="btn btn-primary" onclick="xajax_Grava_JSON(\''.$tabela.'\'); return false;">Gravar JSON </button>';
    $resp->assign("GeradoJ", "innerHTML", $tela);
    */
    $resp->redirect($_SERVER['PHP_SELF']);
    return $resp;
}

function Gera_DDL_GERAL()
{
    $resp = new xajaxResponse();
    global $lista_csv;
    //  $resp->alert(print_r($lista_csv,true)); return $resp;
    for ($i = 0; $i < count($lista_csv); $i++) {
        $arq =  $lista_csv[$i];
        $x = GERA_DDL($arq);
    } 
    $resp->redirect($_SERVER['PHP_SELF']);
    return $resp;
}

function Gera_Insert_Geral()
{
    $resp = new xajaxResponse();
    global $lista_csv;
    for ($i = 0; $i < count($lista_csv); $i++) {
        $arq =  $lista_csv[$i];
        $x = Gera_insert($arq);
    } 
    $resp->redirect($_SERVER['PHP_SELF']);
    return $resp;
}


function Gera_DDL($arqx)
{
    $resp = new xajaxResponse();
    $arq  = file($arqx);
    // $char = 
    //  $arqx   = array();
    for($a=0; $a < count($arq); $a++)  {
        $x =  strlen(trim($arq[$a])) - 1;
        // echo $x.' - '.$str.'</p>';
        while($x > 0) {
            if(substr($arq[$a], $x, 1) != ';') { break;
            }
            if(substr($arq[$a], $x, 1) ===  ';') { $arq[$a][$x] = ' '; 
            }
            $x--;
        }
        //echo $str.'-'.$x;
    }
    //  $resp->alert($x.'-'.$a.' - '.print_r($arq,true)); return $resp;
    $nom = explode('.', $arqx);
    $tabela = $nom[0];

    //  Nro;1;2
    //Variável;xcodigo;atividadeprincipal
    //Coluna;Código da Atividade;Atividade 
    //Tipo;Inteiro;Varchar
    //Larg;3;50
    //Dec;Null;Null
    //Validação;Null;Null
    for($a=0; $a < count($arq); $a++)  {
        if (substr($arq[$a], 0, 1) == ';') { break; 
        } 
        $dd = explode(";", $arq[$a]);
        $xy = $dd[0];
        if ($a == 0) { $numer = $dd; 
        }
        switch ($xy)  { 
        //      case 'Nro'       :  $numer    = $dd; break; 
        case 'Variável'  :  $coluna   = $dd; 
            break;
        case 'Label'     :  $descol   = $dd; 
            break; 
        case 'Tipo'      :  $tipo     = $dd; 
            break;
        case 'Larg'      :  $tam      = $dd; 
            break;
        case 'Dec'       :  $dec      = $dd; 
            break;
        case 'Validação' :  $valida   = $dd; 
            break;
        case 'Not Null'  :  $notnull  = $dd; 
            break;
        case 'Default'   :  $default  = $dd; 
            break;
        case 'A/B'       :  $AB       = $dd; 
            break;
        } 
    }
    // $resp->alert(print_r($numer, true).' - aqui -'.$xy); return $resp; 
    // print_r($tipo);
    $sql = ' DROP TABLE IF EXISTS '.$tabela.'; create table  '.$tabela.'  (';
    $col = '';
    $chp = '';
    //  $pk  = '';
    for ($a = 1; $a < count($numer); $a++)  {
        if ($tipo[$a] !== 'Null') {  
            $col  .=  $coluna[$a].' ';
            $tp    =  substr($tipo[$a], 0, 3); 
            $tamx  =  $tam[$a]; 
            $decx  =  $dec[$a]; 
            $nnull =  $notnull[$a]; 
            $def   =  $default[$a]; 
            $desc  =  $descol[$a];
            //      $valid =  $valida[$a];
            $colch =  '';
            if (substr($coluna[$a], 0, 3) !== 'xml') {
                if (substr($coluna[$a], 0, 1) === 'x') {
                      $colch =  'S';        
                      $pk[] .=  $coluna[$a].' '; 
                }
            }  
            $df = '';
            switch ($tp) {
            case 'Var'    :
            case 'Alf'    : 
            case 'Cha'    : if ($tamx === 'Null') { $tamx = 20; 
            }
                  $col .= 'varchar'.'('.$tamx.') '; $df = 'x';  
                break;
            case 'Blo'    : $col .= 'blob ';  
                break;
            case 'Tex'    : $col .= 'text '; 
                break;
            case 'Boo'    : $col .= 'boolean '; 
                break;
            case 'Hor'    : $col .= 'time '; 
                break;
            case 'Tin'    : $col .= 'tinyint(1) '; 
                break;
            case 'Dat'    : $col .= 'date '; 
                break;
            case 'Int'    : $col .= 'int'.'('.$tamx.') '; 
                break;
            case 'Num'    : if ($decx === 'Null') { 
                          $col .= 'Numeric'.'('.$tamx.') '; 
            } else {
                          $col .= 'Decimal'.'('.$tamx.','.$decx.') '; 
            }
                break;
            case 'Jso'    : $col .= 'int(3) '; 
                break;
            }                  
            if (($nnull == 'S') || ($colch == 'S')) { $col .= ' not null '; 
            } 
            if ($def) {
                if ($def !== 'Null') {
                    if ($df ==  'x') { $col .= ' default \''.$def.'\' '; 
                    } else { $col .= ' default '.$def.' '; 
                    } 
                }   
            }
             // adiciona comentario da coluna 
            //       if ($valid) { $val = '&&'.$valid; } else { $val = ''; }
            if (strlen(trim($desc)) > 0) {  $col .= ' comment \''.trim($desc).'\' '; 
            }
            //  elimina a virgula da ultima coluna   
            if ($a === (count($numer) - 1)) { $col .= ' '; 
            } else { $col .= ', '; 
            }
        }   
    }
    if (count($pk) > 0) {
        $chp .= ',  PRIMARY KEY (';
        for ($b = 0; $b < count($pk); $b++)  {
            if ($b > 0) { $chp .= ','; 
            }
            $chp  .= $pk[$b]; 
        }
        $chp .=  ')';
    }      
    $sql .= $col.' '.$chp.') ENGINE=InnoDB ;';

    $ddl  = 'DDL/'.$tabela.'.sql';
    //apaga arquivo
    if (file_exists($ddl)) { @unlink($ddl); 
    }
    $fr = fopen($ddl, "w");
    fwrite($fr, $sql);
    fclose($fr);
    $resp->alert($sql);
    //  $tmp = 'temp/'.$tabela;
    //  $handle = fopen($tmp, "w");
    //  fwrite($handle, $sql);
    //  fclose($handle);
    //  $tela = $sql.'</p>
    //             <input type="hidden" name="tabela"  value="">
    //             <button type="submit" class="btn btn-primary" onclick="xajax_Grava_DDL(\''.$tabela.'\'); return false;">Gravar DDL </button>';
    //  $resp->assign("Gerado", "innerHTML", $tela);
    $resp->redirect($_SERVER['PHP_SELF']);
    return $resp;
}

function Executa_SQL_DDL($arq)
{
    $resp = new xajaxResponse();
    //  $resp->alert($arq);  return $resp;
    global $db;
    $sq  = file($arq); 
    $query = '';
    for($a=0; $a < count($sq); $a++) {
        $query .= $sq[$a];
    }
    $e = $db->Executa_Query_SQL($query, $resp);
    $resp->redirect($_SERVER['PHP_SELF']);
    return $resp;
}

function Executa_SQL_Insert($arq)
{
    $resp = new xajaxResponse();
    //  $resp->alert($arq);  return $resp;
    $script = 'sudo -i echo `cat '.$arq.' | mysql -u root -pjogola01 --default-character-set=utf8 --force deal 2>&1` > erro';
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
    $resp->redirect($_SERVER['PHP_SELF']);
    return $resp;
}

function Arquiva_CSV($arq)
{
    $resp = new xajaxResponse();
    $script = 'sudo cp -f '.$arq.' CSV/'.$arq;
    $x = shell_exec($script);
    unlink($arq);
    //  $resp->alert($arq.' - '.$x.' - '.$script);
    //  rename($arq, 'CSV/'.$arq); 
    $resp->redirect($_SERVER['PHP_SELF']);
    return $resp;
}

function Exclui_Insert($arq)
{
    $resp = new xajaxResponse();
    unlink($arq);
    $resp->redirect($_SERVER['PHP_SELF']);
    return $resp;
}
 
function Drop_Tab($tabela)
{
    $resp = new xajaxResponse();
    global $db;
    $query = 'drop table '.$tabela.';';
    $e = $db->Executa_Query_SQL($query, $resp);
    $resp->redirect($_SERVER['PHP_SELF']);
    return $resp;
}

function array2json($arr)
{ 
    if(function_exists('json_encode')) { return json_encode($arr); //Lastest versions of PHP already has this functionality. 
    }
    $parts = array(); 
    $is_list = false; 

    //Find out if the given array is a numerical array 
    $keys = array_keys($arr); 
    $max_length = count($arr)-1; 
    if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1 
        $is_list = true; 
        for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position 
            if($i != $keys[$i]) { //A key fails at position check. 
                $is_list = false; //It is an associative array. 
                break; 
            } 
        } 
    } 

    foreach($arr as $key=>$value) { 
        if(is_array($value)) { //Custom handling for arrays 
            if($is_list) { $parts[] = array2json($value); /* :RECURSION: */ 
            } else { $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */ 
            }        
        } else { 
            $str = ''; 
            if(!$is_list) { $str = '"' . $key . '":';
            } 

            //Custom handling for multiple data types 
            if(is_numeric($value)) { $str .= $value; //Numbers 
            } elseif($value === false) { $str .= 'false'; //The booleans 
            } elseif($value === true) { $str .= 'true'; 
            } else { $str .= '"' . addslashes($value) . '"'; //All other things 
            }
            $parts[] = $str; 
        } 
    } 
    $json = implode(',', $parts); 
     
    if($is_list) { return '[' . $json . ']';//Return numerical JSON 
    }
    return '{' . $json . '}';//Return associative JSON 
} 
