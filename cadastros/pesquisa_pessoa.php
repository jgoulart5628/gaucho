<?php
 error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT));
 ini_set('log_errors', 1);
 error_log("php_errors.log");
 ini_set('date.timezone', 'America/Sao_Paulo');
 ini_set('default_charset','UTF-8');
 $keyword = strval($_POST['query']);
//    if (isset($_GET['q']))  {  $qq = " where tabela like '%$q%' "; }  else { $qq = ''; }    
 $q = "{$keyword}%";
 $q1 = "%{$keyword}%";
 define('ROOT', dirname(__DIR__));
 define('DS', DIRECTORY_SEPARATOR);
 require ROOT.DS.'autoload.php';
 // Banco de dados
 $db = new banco_Dados(DB);
// if (strlen($q)  > 2 )  {
   if ($q)  {
      if (is_numeric($q))  {  $qq = " where pessoa_id like '$q' "; }
      else { $qq = " where  nome  like  '$q1' ";  }  
      } else { $qq = ''; }    
 $query =  " select pessoa_id, nome from pessoas  $qq   ORDER BY 2 ";
 $resul = $db->Executa_Query_Array($query);
 if (is_array($resul))  {
       if (count($resul) > 0) {
          foreach ($resul as $res) {
              $pess[] = $res['pessoa_id'].' - '.$res['nome'];
          }
		  echo json_encode($pess);
	   }
  }
//$fs = fopen('tela','w');
//fwrite($fs, $query);
//fclose($fs);
