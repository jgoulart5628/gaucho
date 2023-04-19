<?php
session_start();
$login  = $_SESSION['login_conectado'];
$id     = $_SESSION['Deal_id'];
$usu    = $_SESSION['Deal_usuario'];
$origem = substr($_SERVER['SCRIPT_NAME'],6);
$niveis = substr_count($origem, "/") - 2;
$log    = str_pad("", (3 * $niveis), "../", STR_PAD_LEFT);
//em caso de logout...voltar para o menu
 if ($login !== '1' ){
    //não conectado
      print_r($_SESSION); 
      echo('<h1>Sessao expirou! Tecle F5 para recarregar. '.$login.'-'.$id.'-'.$usu);
    exit;
 }
 if ($login == 1){
      //conectado
      if (($origem == '/menu.php') || ($origem == '/login.php') || ($origem == '/index.php') ||  (strpos($origem, 'senha') == true) ) {
          $x = 0;
      } else {
          //usuario e empresa

          $query = " select distinct aa.id_usuario, aa.id_menu, aa.permissao, aa.parametro,
                       bb.arquivo, bb.nome_menu,  bb.classificacao
                     from menus_usuario aa, menus bb
                    where aa.id_menu = bb.id 
                and  aa.id_usuario = $id
                and  bb.arquivo like '%$origem%' ";
//          echo $query;
          $prg = $db->Executa_Query_Nrows($query);
   
          if ( $prg  == 0)  { echo('<h1>Programa não autorizado para o usuário. Consulte o Suporte.</h1> '.$origem);
              exit;
          }
      }
 }
