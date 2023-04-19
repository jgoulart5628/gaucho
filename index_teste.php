<?php
   header('Cache-control: private, no-cache');
   header('Expires: Mon, 26 Jun 1997 05:00:00 GMT');
   ini_set('date.timezone', 'America/Sao_Paulo');
   ini_set('memory_limit', -1);
   ini_set('default_charset', 'UTF-8');
   ini_set('display_errors', true);
// $header = Header("Pragma: no-cache");
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
// error_reporting(E_ALL);
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__.DS);
require 'autoload.php';
// Session;
$sessao = new sessao();
// Banco de dados
$db = new acesso_db('MYSQL_gaucho');
//    ****
$usuario = $sessao->get('Gaucho_usuario');
$id_usuario = $sessao->get('Gaucho_id');
// echo 'Aqui : '.$login.'-'.$id_usuario.'-'.$usuario;
if (!$sessao->get('Gaucho_usuario')) {
    $sessao->del('login_conectado');
    $sessao->set('login_conectado', '');
}
$origem = $_SERVER['REQUEST_URI'];
$login = $sessao->get('login_conectado');
// $teste = monta_menu($id_usuario, $resp);
//    $resp->alert('Aqui :'.$teste);   return $resp;


require_once 'xajax/xajax_core/xajax.inc.php';
$xajax = new xajax();
//  $xajax->setCharEncoding('UTF-8');
// $xajax->configure('debug',true);
$xajax->configure('errorHandler', true);
$xajax->configure('logFile', 'xajax_error_log.log');
$xajax->register(XAJAX_FUNCTION, 'Login');
$xajax->register(XAJAX_FUNCTION, 'Valida');
$xajax->register(XAJAX_FUNCTION, 'Logout');
$xajax->register(XAJAX_FUNCTION, 'JS');
$xajax->register(XAJAX_FUNCTION, 'Muda_Senha');
$xajax->register(XAJAX_FUNCTION, 'Altera_Senha');
$xajax->register(XAJAX_FUNCTION, 'Cancela');
//$xajax->configure('decodeUTF8Input',true);
$xajax->processRequest();
$xajax->configure('javascript URI', 'xajax/');

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>JGWeb SW</title>
    <!-- SmartMenus core CSS (required) -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/menu1.css">
    <link rel="stylesheet" href="css/style4.css">
    <style>
        .mostrar  { display: visible; } 
        .esconder { display: none;  }
    </style>
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <!--script type="text/javascript" src="js/deal.js"></script -->
    <!-- "sm-blue" menu theme (optional, you can use your own CSS, too) -->
     <script type="text/javascript">
       function Saida(url) {
        var form = document.createElement("form");
        form.setAttribute("action",url);
        form.setAttribute("method","GET");
        form.setAttribute("target","conteudo");
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
    </script>
    <?php $xajax->printJavascript('xajax'); ?>
  </head>

  <body class="opaco">
    <?php if (!$login) {
      echo('<div id="div_login" class="mostrar"></div>');
      $classe_content = 'class="esconder"';
    } else { $classe_content = 'class="mostrar"'; }  ?>
    <div id="div_content" <?php echo $classe_content; ?> style="margin-left: 1px;">
        <nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a href="templates/about.html" target="conteudo" class="col-sm-2">
                  <img src="img/bandeira_rs.gif" class="img-fluid flex-left">
                  <span style="color: rgba(255,255,255,.5);">&copy;2023 JGWeb</span></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                       <span class="navbar-toggler-icon"></span>
                  </button>             
                <div><h6 class="form-signin-heading"><input type="button" value="Bem vindo <?php echo $sessao->get('Gaucho_usuario'); ?>"></h6></div>
                <div class="col-sm-2"></div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                     <ul class="navbar-nav  mr-auto">
                     '.monta_menu($id_usuario, $resp).'
                     </ul>
                     <ul class="navbar-nav ">
                        <li class="nav-item">
                           <a class="nav-link" href="templates/contato.php" target="conteudo">
                              <i class="fa fa-address-card"></i></i>&nbsp;Contato</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" onclick="xajax_Logout(); return false;">
                             <i class="fas fa-door-open"></i>&nbsp;Sair</a>
                        </li>
                     </ul>
                </div>   
            </div>
        </nav>
        <iframe  name="conteudo" id="conteudo" src="templates/about.html" frameborder="0" border="0" cellspacing="0">
               <p>iframes are not supported by your browser.</p>
        </iframe>
    </div>
<!-- GetButton.io widget -->
    <script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+55(54)99947-5408", // WhatsApp number
            call_to_action: "Envie uma mensagem", // Call to action
            button_color: "#FF6550", // Color of button
            position: "right", // Position may be 'right' or 'left'
        };
        var proto = 'https:', host = "getbutton.io", url = proto + '//static.' + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
  </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <?php if (!$login) {
          echo('<script type="text/javaScript">xajax_Login()</script>');
     } ?>
  </body>
 </html>

<?php
function Login()
{
    $resp = new xajaxResponse();
    global $sessao;
    global $db;
    $sessao->nova();
    $sessao->set('Gaucho_usuario', '');
    $sessao->set('Gaucho_id', '');
    $sessao->set('Gaucho_nivel', '');
    $sessao->set('Gaucho_entidade', '');
    $sessao->set('login_conectado', '');
    setcookie('GAUCHO', '', time() - 7200);
    $query = " select id, codigo from adm_usuario where email like '%@%' order by 1 ";
    $res = $db->Executa_Query_Array($query);
    $telax = '<select name="usuario" class="form-control"><option selected value="eu" selected ></option>';
    foreach ($res as $pes) {
        $telax .= '<option  value="'.$pes['codigo'].'" >'.$pes['codigo'].'</option>';
    }
    $telax .= '</select>';
    $tela = '<form id="geral"  name="geral" class="opaco" method="post"> 
             <div id="modal">
              <div class="modal-dialog modal-login">
	         <div class="modal-content caixa-sombra">
                    <div class="modal-header">				
		        <h4 class="modal-title">Gaucho Login</h4>
                    </div>
		    <div class="modal-body">
		        <div class="form-group"><i class="fa fa-user"></i>'.$telax.'</div>
                        <div class="form-group">
	                  <i class="fa fa-lock"></i>
	                  <input type="password" name="senha" class="form-control" placeholder="Senha" required="required">			
                        </div>
		        <div class="form-group">
    		          <input type="submit" class="btn btn-primary btn-block btn-lg" value="Entrar" onclick="xajax_Valida(xajax.getFormValues(\'geral\')); return false;">
            	        </div>
            	    </div>
            	    <div class="modal-footer">
                        <span class="glyphicon glyphicon-thumbs-up"></span>&#174; JGWeb
                    </div>
              </div>
             </div>
            </div> 
          </form>';
    //      $resp->alert('não funcionou');
    //    $resp->alert($tela); return $resp;
    $resp->assign('div_login', 'innerHTML', $tela);
    return $resp;
}
function Valida($dados)
{
    $resp = new xajaxResponse();
    $usuario = $dados['usuario'];
    $senha = $dados['senha'];
    if (!$usuario) {
        $resp->alert(' Escolha um usuário para autenticar');

        return $resp;
    }
    if (!$senha) {
        $resp->alert(' Preencha a senha! ');

        return $resp;
    }
    global $sessao;
    global $db;
    $query = " select * from adm_usuario where codigo = '$usuario' ";
    $resul = $db->Executa_Query_Single($query);
    $id = $resul['id'];
//    $usuario = $resul['usuario'];
    $nivel = $resul['nivel'];
    $entidade = $resul['entidade'];
    $pass = trim($resul['senha']);
    $passx = trim(sha1($senha));
    if ($pass !== sha1($senha)) {
        $resp->alert(' Senha incorreta! ');

        return $resp;
    }

    $sessao->nova();
    setcookie('Gaucho', $usuario, date('Ymd'), time() + (60 * 60 * 24 * 30));  /* expira em 10 horas */ 
//    setcookie('Gaucho', $usuario, date('Ymd'), time() + (60 * 60 * 4));  /* expira em 10 horas 
    $sessao->set('Gaucho_usuario', $usuario);
    $sessao->set('Gaucho_id', $id);
    $sessao->set('Gaucho_nivel', $nivel);
    $sessao->set('Gaucho_entidade', $entidade);
    $sessao->set('login_conectado', '1');
    $sessid = session_id();
    $sessidx = "'".$sessid."'";
    $sessao->set('sessao', $sessid);
    $usuario = $sessao->get('Gaucho_usuario');
    $usuario_id = $sessao->get('Gaucho_id');
    $query = " delete from adm_sess_login  where usuario_id = $usuario_id ";
    $e = $db->Executa_Query_SQL($query);
    if ($e == 2) {
        $resp->alert('Erro limpando login : '.$query);

        return $resp;
    }
    $data = date('Y-m-d G:i');
    $unico = mt_rand();
    $query = " insert into adm_sess_login values ($usuario_id, '$sessid', '$data', $unico) ";
    $e = $db->Executa_Query_SQL($query, $resp);
    if ($e == 2) {
        $resp->alert('Erro inserindo login : '.$query);

        return $resp;
    }
    //    $resp->redirect($_SERVER['PHP_SELF']);
    $resp->alert(print_r($_SESSION, true).' - '.print_r($dados,true));
    $resp->assign("div_login","className",'esconder');
    $resp->assign("div_content","className",'mostrar');
    //    $resp->alert($sessid.'-'.$usuario.' - '.$query.'-'.$e);
//    $resp->script('xajax_Menu();');

    return $resp;
}

function Logout()
{
    $resp = new xajaxResponse();
    global $db;
    global $sessao;
    $usuario = $sessao->get('Gaucho_usuario');
    //    $resp->addAlert($id); return $resp;
    $sessao->set('login_conectado', 0);
    $sessao->set('Gaucho_usuario', '');
    $sessao->set('Gaucho_id', '');
    session_destroy();
    //   if ($unico)  {
    if ($usuario) {
        $query = " delete from adm_sess_login  where usuario = '$usuario' ";
        $e = $db->Executa_Query_SQL($query);
        if ($e == 2) {
            $resp->alert('Erro limpando login : '.$query);

            return $resp;
        }
    }
    //   $usuario =  $sessao->get("Deal_usuario");
    //   $resp->alert($usuario.' - Alerta vermelho!');
    //   $resp->script("xajax_Menu();");
    $resp->redirect($_SERVER['PHP_SELF']);
    return $resp;
}
/*
function Menu()
{
    $resp = new xajaxResponse();
    global $sessao;
    global $db;
    $usuario = $sessao->get('Gaucho_usuario');
    $id_usuario = $sessao->get('Gaucho_id');
    $login = $sessao->get('login_conectado');
    if (!$sessao->get('Gaucho_usuario')) {
        $sessao->del('login_conectado');
        $sessao->set('login_conectado', 0);
        //       return $resp;
    }
    $origem = $_SERVER['REQUEST_URI'];
    $niveis = substr_count($origem, '/') - 2;
    $log = str_pad('', (3 * $niveis), '../', STR_PAD_LEFT);
//    $resp->alert('Aqui :'.$login.' ** '.$id_usuario.' - '.$usuario);    return $resp;

    if ($login < 1) {
        $resp->script('xajax_Login();');
        //        $resp->alert('Aqui :'. $login.' ** '.ROOT);
        //      header('location: ../login.php?origem='.$origem);
        return $resp;
    }
    $teste = monta_menu($id_usuario, $resp);
//    $resp->alert('Aqui :'.$teste);   return $resp;

    $tela = monta_cabec($id_usuario, $usuario, $resp);
    $resp->assign('saida_geral', 'innerHTML', $tela);
    //   $dados = '';
    // $resp->script("xajax_Telax($dados)");
    return $resp;
}


function monta_menu($id_usuario, $resp)
{
    global $db;
    $query = " select distinct aa.id_usuario, aa.id_menu, aa.db_insert, aa.db_update, aa.db_delete,
               bb.id_rotina, bb.arquivo, bb.nome_menu, bb.id, bb.funcionalidade,  bb.classificacao, cc.rotina, bb.id
               from adm_menus_usuario aa, adm_menus bb, adm_rotinas cc
              where aa.id_menu = bb.id 
                and  bb.id_rotina = cc.id
                and  id_usuario = $id_usuario
                order by cc.rotina, bb.nome_menu ";
    $result = $db->Executa_Query_Array($query, $resp);

    $ret = '';
    $ret .= '<li class="nav-item dropdown">';
//    list-unstyled components
    $sis_ant = '';
    $vez = 0;
    for ($i = 0; $i < count($result); ++$i) {
        $sis = $result[$i]['rotina'];
        $sistema = $result[$i]['id_rotina'];
        $nome_menu = $result[$i]['nome_menu'];
        $arq = $result[$i]['arquivo'];
        //  if (strpos($arq,'.php')) { $path = '../'; } else { $path = ''; }
        //  $arq = $path.$arq;
        $arq1 = strpos($arq, 'php');
        $tip = $result[$i]['nome_menu'];
        $tip_inf = $result[$i]['funcionalidade'];
        $tip_inf = str_replace(chr(10), '<br />', $tip_inf);

        //       }
        if (!$arq1) {
            if ($result[$i]['caminho_http']) {
                $arq = $result[$i]['caminho_http'].$arq;
            }
        }
        if ($sistema < 99) {
            if ($sis != $sis_ant) {
                if ($i > 0) {
                    $ret .= '</div></li><li class="nav-item dropdown">';
                }

                //item da lista do menu (sistema).
                $ret .= '<a class="nav-link dropdown-toggle mx-auto" href="#" id="'.$sis.'" role="button" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                <i class="fa fa-folder-open"></i>
                 &nbsp;'.$sis.'
                </a>
                <div class="dropdown-menu" aria-labelledby="'.$sis.'">';
                $sis_ant = $sis;
            }
            $arq = "'$arq'";
            //$ret .= '<li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-'.$i.'

            //          current_page_item>
            $ret .= '<a class="dropdown-item" href="javascript:void()" onclick="Saida('.$arq.'); return false;"><i class="fa fa-edit"></i>'.$nome_menu.'</a>';
        }
    }
    $ret .= '</div></li>';
    //   $ret .= '<div>sessao: '.$sess.'</div>';
    return $ret;
}



function Muda_senha($usuario)
{
    $resp = new xajaxResponse();
    $vazio = '&nbsp;';
    $tela = '<form id="dados_pag" class="fundo" name="altpag">
              <div id="modal">
               <div class="modal-dialog modal-login">
                 <div class="modal-content caixa-sombra">
                    <div class="modal-header">        
                       <h4> Troca de Senha do  Usuário '.$usuario.'</h4>
                    </div>   
                    <div class="modal-body">
                       <div class="form-group">
                           <i class="fa fa-lock"></i>
                           <label for="senha_ant" class="control-label">Senha Anterior : </label>
                            <input type="password"  class="form-control" id="senha_ant"  name="senha_ant"  value="">
                       </div>
                       <div class="form-group">
                           <i class="fa fa-lock"></i>
                           <label for="senha" class="control-label">Nova Senha :</label>
                         <input type="password" class="form-control" id="senha"  name="senha"  value="">
                       </div>    
                       <div class="form-group">
                           <i class="fa fa-lock"></i>
                           <label for="senhax" class="control-label">Repetir :</label>
                           <input type="password" class="form-control" id="senhax"  name="senhax">
                       </div>   
                       <div class="form-group">
                         <input type="hidden" name="usuario" value="'.$usuario.'">
                         <input type="submit"   class="btn btn-danger btn-block btn-lg" value="Altera" onclick="xajax_Altera_Senha(xajax.getFormValues(\'dados_pag\')); return false;">
                        <input type="submit"   class="btn btn-primary btn-block btn-lg" name="Cancela" value="Cancela" onclick="xajax_Cancela(); return false;">
                       </div>
                    </div>     
                    <div class="modal-footer"></div>
                </div>
               </div>
              </div>  
           </form>';
    $resp->assign('saida_geral', 'innerHTML', $tela);
    $script = "document.getElementById('senha_ant').focus()";
    $resp->script($script);

    return $resp;
}

function Cancela()
{
    $resp = new xajaxResponse();
    $resp->script('xajax_Menu()');

    return $resp;
}

function Altera_Senha($dados)
{
    $resp = new xajaxResponse();
    global  $sessao;
    global  $db;
    $usuario = $dados['usuario'];
    $senha_ant = $dados['senha_ant'];
    $senha = $dados['senha'];
    $senhax = $dados['senhax'];
    if ($senha_ant) {
        if (!$senha || !$senhax) {
            $resp->alert('É necessário preencher a senha e repetí-la');

            return $resp;
        }
        if ($senha !== $senhax) {
            $resp->alert('As duas senha devem ser iguais, digite novamente.');

            return $resp;
        }
    }
    if ($usuario) {
        $query = " select senha from adm_usuario where codigo = '$usuario' ";
        $resul = $db->Executa_Query_Single($query, $resp);
    }
    //     $resp->alert(print_r($resul,true).'-'.$query); return $resp;
    if ($senha) {
        if (sha1($senha_ant) == $resul['senha']) {
            $senha_nova = sha1($senha);
        } else {
            $resp->alert('Senha anterior incorreta!');

            return $resp;
        }
        //        $resp->addAlert(strtoupper($senha_ant).'-'.decode5t($resul['SENHA'])); return $resp;
    }
    $query = " update adm_usuario set senha = '$senha_nova'  where codigo = '$usuario' ";
    //     $resp->addAlert($query); return $resp;
    $e = $db->Executa_Query_SQL($query, $resp);
    if ($e == 2) {
        $resp->alert('Senha nao alterada! '.$query);
    } else {
        $resp->alert('Senha Alterada! Fazer novo Login.');
        session_destroy();
        $db->Executa_Query_SQL(" delete from adm_sess_login where usuario = '$usuario' ", $resp);
        $resp->script('xajax_Logout()');
    }

    return $resp;
}
*/
