<?php
ini_set('default_charset', 'UTF-8');
ini_set('display_errors', true);
// cadastro e manutenção de usuarios
error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT));
// error_reporting(E_ALL);
require '../autoload.php';
// Session;
$sessao = new sessao();
// Banco de dados
$db = new acesso_db('MYSQL_gaucho');
// XAJAX
require_once '../xajax/xajax_core/xajax.inc.php';
$xajax = new xajax();
// $xajax->configure('debug',true);
$xajax->configure('errorHandler', true);
$xajax->configure('logFile', 'xajax_error.log');
$xajax->register(XAJAX_FUNCTION, 'Manut_Usuario');
$xajax->register(XAJAX_FUNCTION, 'Altera_Senha');
$xajax->register(XAJAX_FUNCTION, 'Gravar_Senha');
$xajax->register(XAJAX_FUNCTION, 'Exclui_Usuario');
$xajax->register(XAJAX_FUNCTION, 'Eliminar_Usuario');
$xajax->register(XAJAX_FUNCTION, 'Altera_Usuario');
$xajax->register(XAJAX_FUNCTION, 'Gravar_Usuario');
$xajax->processRequest();
$xajax->configure('javascript URI', '../xajax/');
// <!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd">
?>
<!DOCTYPE html>
<html>
    <!-- Meta-Information -->
    <title> Cadastro - Usuários </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="JGWeb Software">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Vendor: Bootstrap Stylesheets http://getbootstrap.com -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Our Website CSS Styles -->
    <link rel="stylesheet" href="../css/style4.css">
    <link rel="stylesheet" href="../css/main.css">
    <script type="text/javascript" src="../js/modernizr.js"></script>
    <script type="text/javaScript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javaScript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javaScript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.min.js"></script>
    <script type="text/javaScript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular-route.min.js"></script> 
    <!-- Our Website CSS Styles -->
    <?php $xajax->printJavascript('../xajax'); ?>
</head>

<body class="opaco">
   <form id="dados_tela" name="dados_tela" role="form" method="post">
     <div class="container-fluid  fundo" style="width: 80%;" >  
          <div class="page-header">
             <h3 class="text-muted centro"> Cadastro Usuários</h3>
          </div>
         <div id="tela_manut"></div> 
         <div class="footer fundo"><span class="glyphicon glyphicon-thumbs-up"></span>&#174; JGWeb
         </div>
      </div>
   </form>
   <script type="text/javaScript" src="../js/jquery-1.11.1.min.js" ></script>
   <script type="text/javaScript" src="../js/jquery.dataTables.min.js" ></script>
   <script type="text/javaScript" src="../js/bootstrap.min.js" ></script> 
   <script type="text/javaScript" src="../js/dataTables.bootstrap.js" ></script> 
   <script type="text/javaScript">xajax_Manut_Usuario() </script>
 </body>
</html>

<?php
function Manut_Usuario()
{
    $resp = new xajaxResponse();
    global $db;
    global $sessao;
    $usuario_id = $sessao->get('usuario_id');
    $nome_resp = $sessao->get('usuario_nome');
    $entidade = $sessao->get('usuario_entidade');
    $query = ' Select * from adm_usuario ';
    $res = $db->Executa_Query_Array($query);
    //   $resp->alert('Estou Aqui '.print_r($res,true));   return $resp;
    //   $res = $db->Dados_Resp($unidade);
    //   $resp->alert('Estou Aqui '.$teste);   return $resp;
    $tela = '<div class="container-fluid table-responsive">
               <button type="submit" class="btn btn-primary" onclick="xajax_Altera_Usuario(xajax.getFormValues(\'dados_tela\'),\''.'0'.'\'); return false;">Inclui Novo Usuário</button>
                            <h3>  Usuários Cadastrados</h3>           
               <table  id="tabclas" data-toggle="table" class="table table-striped table-bordered">
                   <thead>  
                     <tr align="center">
                      <th> Alterar </th> 
                      <th> Cod.Usuário </th>
                      <th> Nome Usuário </th>
                      <th> Entidade </th>
                      <th><img src="../img/mail.gif">Email</th>
                      <th><img src="../img/telefone.png">Fones</th>
                      <th> Nivel </th>
                      <th> Senha </th>
                      <th> Excluir </th>
                   </tr></thead><tbody>';

    if ($res) {
        $a = 0;
        foreach ($res as $pes) {
            $id = $pes['id'];
            $nome = $pes['nome_usuario'];
            $email = $pes['email'];
            $fone = $pes['fone'];
            $senha = $pes['senha'];
            $nivel = $pes['nivel'];
            if ($nivel == 0) {
                $descr_nivel = 'Administrador';
            }
            if ($nivel == 5) {
                $descr_nivel = 'Usuário Normal';
            }
            $codigo = $pes['codigo'];
            $entidade = $pes['entidade'];

            $tela .= '<tr>
                        <td><input type="image" src="../img/edit-icon.png" border="0" width="48" height="48" onclick="xajax_Altera_Usuario(xajax.getFormValues(\'dados_tela\'),\''.$id.'\'); return false;"></td>
                        <td>'.$codigo.'</td>
                        <td>'.$nome.'</td>
                        <td>'.Combo_Entidade($entidade, $db).'</td>
                        <td>'.$email.'</td>
                        <td>'.$fone.'</td>
                        <td>'.$descr_nivel.'</td>
                        <td><input type="image" src="../img/lock1.png" onclick="xajax_Altera_Senha('.$id.',\''.$a.'\'); return false;"><div id="div_senha_'.$a.'"></div></td>
                        <td><input type="image" src="../img/lixeira1.png" onclick="xajax_Exclui_Usuario('.$id.'); return false;"></td>
                     </tr>';
            ++$a;
        }
    }
    $tela .= '</tbody></table></div>';
    $resp->assign('tela_manut', 'innerHTML', $tela);

    return $resp;
}

function Altera_Senha($id, $a)
{
    $resp = new xajaxResponse();
    if (!$id) {
        $resp->alert('Usuário não informado!');

        return $resp;
    }
    $tela = 'Informe a nova senha e confirme: <input type="text" name="senha" id="senha" value="">
                <input type="button" value="Confirmar" onclick="xajax_Gravar_Senha(xajax.getFormValues(\'dados_tela\'),\''.$id.'\',\''.$a.'\'); return false;">';
    $resp->assign("div_senha_$a", 'innerHTML', $tela);

    return $resp;
}

function Gravar_Senha($dados, $id, $a)
{
    $resp = new xajaxResponse();
    global $db;
    $senha = $dados['senha'];
    if ($senha) {
        $senha1 = sha1($senha);
        $query = " update adm_usuario set senha = '$senha1' where id = $id ";
        $e = $db->Executa_Query_SQL($query);
        if ($e == 2) {
            $resp->alert('Senha não alterada');
        } else {
            $resp->alert('Senha Alterada!');
        }
    }
    $resp->assign("div_senha_$a", 'innerHTML', '');
    $resp->script("xajax_Manut_Usuario($dados)");

    return $resp;
}

function Exclui_Usuario($id)
{
    $resp = new xajaxResponse();
    global $db;
    if (!$id) {
        $resp->alert('Usuário não informado!');

        return $resp;
    }
    $dados = '';
    $query = " select codigo from adm_usuario ehere id = $id ";
    $codigo = $db->Executa_Query_Unico($query);
    $resp->confirmCommands(1, " Confirma exclusão deste usuario  ($codigo) ? ");
    $resp->call("xajax_Eliminar_Usuario($id)");
    $resp->script("xajax_Manut_Usuario($dados)");

    return $resp;
}

function Eliminar_Usuario($id)
{
    $resp = new xajaxResponse();
    global $db;
    $query = " delete from adm_usuario where id = $id ";
    $e = $db->Executa_Query_SQL($query);
    if ($e == 2) {
        $resp->alert('Usuário '.$id.' não foi excluido!');
    }

    return $resp;
}

function Altera_Usuario($dados, $id)
{
    $resp = new xajaxResponse();
    global $db;
    if ($id == 0) {
        $oper = 'I';
    } else {
        $oper = 'A';
    }
    if ($oper == 'A') {
        $query = " select * from adm_usuario where id = $id ";
        $pes = $db->Executa_Query_Single($query);
        $codigo = $pes['codigo'];
        $nome = $pes['nome_usuario'];
        $email = $pes['email'];
        $fones = $pes['fone'];
        $senha = $pes['senha'];
        $nivel = $pes['nivel'];
        $entidade = $pes['entidade'];
        $titulo = 'Alteração';
    } else {
        $id = '';
        $codigo = '';
        $nome = '';
        $email = '';
        $fones = '';
        $senha = '';
        $nivel = '';
        $entidade = '';
        $titulo = 'Inclusão';
    }
    $check0 = '';
    $check5 = '';
    if ($nivel == '5') {
        $check5 = 'checked="true"';
    }
    if ($nivel == '0') {
        $check0 = 'checked="true"';
    }

    $tela = '<div class="row">
               <div class="col-sm-12">
                  <h3>'.$titulo.'</h3>
                  <div class="row">
                    <div class="form-group col-sm-2">
                         <label for="usuario">Cod. Usuário : </label>
                         <input type="txt"  class="form-control" id="codigo" name="codigo" size="30" maxlength="30" value="'.$codigo.'">
                    </div>
                    <div class="form-group col-sm-3">
                         <label for="nome_resp">Nome do Usuário : </label>
                         <input type="txt"  class="form-control" id="nome_usuario" name="nome_usuario" size="40" maxlength="40" value="'.$nome.'">
                    </div>
                    <div class="form-group col-sm-3">
                         <label for="email_resp">Email : </label>
                         <input type="email"  class="form-control" id="email" name="email" size="40" maxlength="40" value="'.$email.'">
                    </div>
                   </div>
                   <div class="row">
                     <div class="form-group col-sm-3">
                        <label for="fones_resp">Telefones : </label>
                         <input type="phone"  class="form-control" id="fones" name="fones" size="40" maxlength="40" value="'.$fones.'">
                     </div>
                     <div class="form-group col-sm-4">
                         <label for="nivel">Tipo Usuário : </label>
                           <div class="form-control">
                              <input type=radio name="nivel"  value="5" '.$check5.'> Usuário
                              &nbsp;&nbsp;<input type=radio name="nivel"  value="0" '.$check0.'> Administrador
                           </div>       
                     </div>
                     <div class="form-group col-sm-3">
                         <label for="entidade">Entidade do Usuário : </label>
                         <div>'.Combo_Entidade($entidade, $db).'</div>
                      </div>
                     <div class="form-group col-sm-3">
                         <label for="senha">Senha do Usuário : </label>
                         <input type="text"  class="form-control" id="senha" name="senha" size="40" maxlength="40" value="Alterar">
                      </div>
                    </div> 
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12">
                        <input type="hidden" name="oper" value='.$oper.'>
                        <input type="hidden" name="id" value='.$id.'>
                        <button type="submit" class="btn btn-primary" onclick="xajax_Gravar_Usuario(xajax.getFormValues(\'dados_tela\')); return false;">Gravar os Dados</button>
                        <button type="submit" class="btn btn-primary" onclick="xajax_Manut_Usuario(xajax.getFormValues(\'dados_tela\')); return false;">Desiste e Retorna</button>
                    </div>
                  </div> ';
    // $resp->assign("tela_manut", "innerHTML", '');
    $resp->assign('tela_manut', 'innerHTML', $tela);

    return $resp;
}

function Gravar_Usuario($dados)
{
    $resp = new xajaxResponse();
    global $db;
//    $resp->alert('Aqui : '.print_r($dados,true)); return $resp;
    $id = $dados['id'];
    $oper = $dados['oper'];
    $codigo = $dados['codigo'];
    $nome_usuario = $dados['nome_usuario'];
    $email = $dados['email'];
    $fones = $dados['fones'];
    $senha = $dados['senha'];
    $nivel = $dados['nivel'];
    $entidade = $dados['entidade'];
    if (!$codigo) {
        $resp->alert('Codigo não pode estar em branco!');

        return $resp;
    }
    if (!$nome_usuario) {
        $resp->alert('Nome deve  ser preenchido!');

        return $resp;
    }
    if (!$senha) {
        $resp->alert('Cadastar uma senha!');

        return $resp;
    }
    if (is_null($nivel)) {
        $nivel = 5;
    }
    if (!$entidade) {
        $entidade = 0;
    }

    if ($oper == 'A') {
        $query = " update adm_usuario  set codigo = '$codigo', nome_usuario = '$nome_usuario',
                     email  = '$email',  fone = '$fones', nivel  = $nivel,  entidade  = $entidade     
                       where id = $id  ";
    } else {
        $id = $db->Executa_Query_Unico(' select  ifnull((max(id) + 1),1) from adm_usuario ');
        $query = " insert into adm_usuario ( codigo, id,  nome_usuario, email, fone, nivel, senha, entidade)
                        values ('$codigo',$id, '$nome_usuario', '$email','$fones',$nivel, '$senha', $entidade)    
                 ";
    }
    $e = $db->Executa_Query_SQL($query);
    if ($e == 2) {
        $resp->alert('Dados não alterados, verifique '.$e.' - '.$query);
    }
    if ($e !== 2) {
        if ($senha !== 'Alterar') {
            $senha = sha1($senha);
            $e = $db->Executa_Query_SQL(" update adm_usuario set senha = '$senha'  where id = $id ");
            if ($e == 2) {
                $resp->alert('Senha não alterada, verifique');
            }
        }
    }
    //   $resp->assign("tela_usuario", "innerHTML", '');
    $resp->script("xajax_Manut_Usuario($dados)");

    return $resp;
}

function Combo_Entidade($entidade = 0, $db)
{
    if (!$entidade) {
        $entidade = 0;
    }
    $query = " select entidade_id, nome_entidade,  case when entidade_id = '$entidade' then 'SELECTED' else ' ' end sel 
               from entidade ";
    $res = $db->Executa_Query_Array($query);
    $ret = '<select class="form-control" name="entidade" id="entidade"> 
                   <option value ="" class="f_texto" ></option> ';
    for ($i = 0; $i < count($res); ++$i) {
        $id = $res[$i]['entidade_id'];
        $nome_entidade = $res[$i]['nome_entidade'];
        $sel = $res[$i]['sel'];
        $ret .= '<option value="'.$id.'" '.$sel.' class="f_texto"> '.$nome_entidade.' </option> ';
    }
    $ret .= '</select> ';

    return $ret;
}
