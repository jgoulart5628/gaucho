<?php
    header('Cache-control: private, no-cache');
    header('Expires: Mon, 26 Jun 1997 05:00:00 GMT');
    ini_set('date.timezone', 'America/Sao_Paulo');
    ini_set('memory_limit', -1);
    ini_set('default_charset', 'UTF-8');
    ini_set('display_errors', true);
    error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
    // error_reporting(E_ALL);
    $amb = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT');
    $and = strpos($amb, 'Android');
    if($and > 0) { $an = 'Android';} else { $an = ''; }
    define('AN', $an);
    define('ROOT', dirname(__DIR__));
    define('DS', DIRECTORY_SEPARATOR);
    require ROOT.DS.'autoload.php';
        // Session;
    $sessao = new sessao();
    define('ID', $sessao->get('Gaucho_id'));
    // Banco de dados
    $db = new banco_Dados(DB);
    //    ****
    // Xajax **
    require_once '../xajax/xajax_core/xajax.inc.php';
    $xajax = new xajax();
//    $xajax->configure('debug',true);
    $xajax->configure('errorHandler', true);
    $xajax->configure('logFile', 'xajax_error.log');
    $xajax->register(XAJAX_FUNCTION, 'Tela_Inicial');
    $xajax->register(XAJAX_FUNCTION, 'Tela_Modal');
    $xajax->register(XAJAX_FUNCTION, 'Tela_Inscritos');
    $xajax->register(XAJAX_FUNCTION, 'Novo_Inscrito');
    $xajax->register(XAJAX_FUNCTION, 'Dados_Pessoa');
    $xajax->register(XAJAX_FUNCTION, 'Gravar_Inscri');
    $xajax->register(XAJAX_FUNCTION, 'Exclui_Inscri');
    $xajax->register(XAJAX_FUNCTION, 'Desiste');
//    $xajax->register(XAJAX_FUNCTION, 'Escolhe_Modalidade');
    $xajax->processRequest();
    $xajax->configure('javascript URI', '../xajax/');
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Inscrições Evento</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style4.css">
    <link rel="stylesheet" href="../css/tela_nova.css">
    <style>
      .typeahead {
           border: 2px solid #FFF;
           border-radius: 4px;
           padding: 8px 12px;
           max-width: 300px;
           min-width: 290px;
           /* background: rgba(66, 52, 52, 0); */
           background-color: #7c7575;
           color: #FFF;}
    </style>
    <?php
       $xajax->printJavascript('../xajax');
    ?>
  </head>
  <body class="opaco">
    <form name="tela_mod" id="tela_mod" method="POST">
       <div class="container-fluid" style="padding-top: 10px;" >
         <div id="tela_evento" class="col-xs-12" style="padding: 5px 0;"></div>
      </div>
      <div class="footer">
        <span class="glyphicon glyphicon-thumbs-up"></span>&#174; JGWeb
      </div>
   </form>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../js/typeahead.js"></script>
    <script type="text/javascript">
      function pesquisa_pessoa()  {
        $('.typeahead').typeahead({
            source: function (query, result) {
                $.ajax({
                    url: "pesquisa_pessoa.php",
          data: 'query=' + query,            
                    dataType: "json",
                    type: "POST",
                    success: function (data) {
            result($.map(data, function (item) {
              return item;
                        }));
                    }
                });
            }
        });
    }
   </script>
    <?php 
      if (isset($_GET["evento_id"]))  {
         $evento_id =  $_GET['evento_id'];
         echo '<script type="text/javaScript">xajax_Tela_Inicial('.$evento_id.');</script>';
      } else { 
         echo '<script type="text/javaScript">xajax_Tela_Inicial();</script>';
      }
    ?>
 </body>
 </html>
<?php
function Tela_Inicial($evento_id='') 
{
   $resp = new xajaxResponse();
   global $sessao;
   $tela = '<div class="container-fluid tela_nova">
              <h3 class="text-muted centro">Inscrições Eventos</h3>
              <div class="col-xs-12">
                 <div class="row">
                    <div class="col-md-4">
                     '.combo_evento($evento_id, $resp).'
                    </div>  
                    <div class="col-md-4">
                      <div id="modalidades"></div>
                    </div>  
                 </div>  
                 <br>
                 <div class="row">
                    <div class="col-md-12">
                      <div id="inscrever"></div>
                    </div>  
                 </div>  
                 <div class="row">
                    <div class="col-md-12">
                      <div id="inscritos"></div>
                    </div>  
                 </div>  
               </div>    
            </div>';
   $resp->assign("tela_evento", "innerHTML", $tela);
   if ($evento_id) { $resp->script("xajax_Tela_Modal(xajax.getFormValues('tela_mod'));"); }
   return $resp;   
}

function Tela_Modal($dados)  {
   $resp = new xajaxResponse();
   $evento_id = $dados['evento_id'];
   global $db;
   $query = "select modal_id, (select m.descri from modalidades m where mod_id = modal_id) descri, limite_inscritos
   from modal_evento  where evento_id = $evento_id ";
   $res = $db->Executa_Query_Array($query, $resp);
   if (count($res) > 0) {
     // $ret = print_r($res, true);    return $ret;
      $ret = '<select class="form-control" name="modal_id" id="modal_id" onchange="xajax_Tela_Inscritos(xajax.getFormValues(\'tela_mod\')); return false;">
            <option value="0" class="form-control">Escolha a Modalidade: </option>';
       for ($i = 0; $i < count($res); ++$i) {
         $modal_id = $res[$i]['modal_id'];
         $descri   = $res[$i]['descri'];
         $lim_insc = $res[$i]['limite_inscritos'];
         $ret .= '<option value="'.$modal_id.'" class="form-control">'.$descri.'</option>';       
       }
      $ret .= '</select>';
   } else { 
      $resp->confirmCommands(1, " Evento sem modalidades cadastradas. Deseja cadastrar?");
      $url = 'eventos.php?evento_id='.$evento_id;
      $resp->redirect($url);
//      $resp->alert('Evento sem modalidades cadastradas. Corrija!');
      return $resp; 
    }   
   $resp->assign('modalidades', 'innerHTML', $ret);
   return $resp;
}

function Tela_Inscritos($dados, $ll='')  {
   $resp = new xajaxResponse();
//   $resp->alert('Aqui  Tela_Inscritos: '.print_r($dados, true).' - '.ID);
   global $db;
   if (is_array($dados)) {
       $evento_id = $dados['evento_id'];
       $modal_id  = $dados['modal_id'];
   } else { 
      $evento_id = $dados;
      $modal_id  = $ll;
  }    
//  $resp->alert('Aqui  Tela_Inscritos: '.$evento_id.' - '.$modal_id.'- '.$dados.'-'.$ll);
  $query     = " select ie.insc_id, ie.pessoa_id, p.nome, p.data_nascimento, p.docto_mtg,  p.validade_docto_mtg,	" 
           . " ie.data_hora_inscri from inscritos_evento ie, pessoas p  where evento_id = $evento_id and "
           . " modal_id = $modal_id and p.pessoa_id = ie.pessoa_id ";
   $tela = '<br><button class="btn btn-primary" onclick="xajax_Novo_Inscrito('.$evento_id.','.$modal_id.'); return false;">Nova Inscrição</button>
            <div class="content">
            <table class="table table-borderd table-stripped">
              <thead><tr><th>Ordem</th><th>Nome</th><th>Data Nascimento</th><th>Docto MTG</th><th>'
              . 'Validade Docto.</th><th>Data/Hora Inscrição</th></tr></thead><tbody>';
   $res =  $db->Executa_Query_Array($query, $resp);
   if (count($res) > 0)  {
      for ($a = 0; $a < count($res); $a++) {
         $insc_id = $res[$a]['insc_id'];
         $pessoa_id = $res[$a]['pessoa_id'];
         $nome      = $res[$a]['nome'];
         $data_nascimento = date('d/m/Y', strtotime($res[$a]['data_nascimento']));
         $docto_mtg = $res[$a]['docto_mtg'];
         $validade_docto_mtg = $res[$a]['validade_docto_mtg'];
         $data_hora_inscri = date('d/m/Y G:i', strtotime($res[$a]['data_hora_inscri']));
         $tela .= '<tr><td>'.$insc_id.'</td><td>'.$pessoa_id.'-'.$nome.'</td><td>'.$data_nascimento.'</td>'
               . '<td>'.$docto_mtg.'</td><td>'.$validade_docto_mtg.'</td><td>'.$data_hora_inscri.'</td></tr>';
      }
      $tela .= '</tbody></table>';
   } 
   // $resp->alert('Aqui : '.print_r($dados,true).print_r($res,true));
   $resp->assign('inscritos', 'innerHTML', $tela);
   if (count($res) ==  0) { $resp->script("xajax_Novo_Inscrito($evento_id, $modal_id);"); }
   return $resp;
}

function Novo_Inscrito($evento_id, $modal_id)  {
   $resp = new xajaxResponse();
 //  $resp->alert('Aqui : '.print_r($dados, true).' - '.ID);
   $tela = '<input type="hidden" name="oper"  value="I">
            <h4>Evento: '.$evento_id.' - Modalidade: '.$modal_id.'</h3>
            <div class="row">
              <div class="col-md-6">
                <label for="pessoa">Peão/Prenda</label>
                <input type="text" name="pessoa_id" class="typeahead form-control" id="pessoa_id" placeholder="Pesquisa nome/código">
               </div>
               <button class="btn btn-primary" onclick="xajax_Dados_Pessoa(xajax.getFormValues(\'tela_mod\')); return false;">Buscar dados Pessoa</button>';
   $tela .= '</div><div id="dados_pessoa"></div></div>';  
   $resp->assign("inscrever", 'innerHTML', $tela);
   $resp->assign("inscritos", 'className','esconder');
   $resp->script('pesquisa_pessoa();');
   return $resp;
}

function Dados_Pessoa($dados)  {
   $resp = new xajaxResponse();
   $pes = explode('-', $dados['pessoa_id']);
   $pessoa_id = $pes[0];
   $evento_id = $dados['evento_id'];
   $modal_id  = $dados['modal_id'];
   global $db;
   // ler dados pessoa
   $query = " select pessoa_id, nome, data_nascimento, sexo, "
         .  " (select nome_entidade from entidade where entidade_id = entidade) nome_entidade, "
         .  " docto_mtg, validade_docto_mtg "
      .     " from pessoas where pessoa_id = $pessoa_id ";
   $pes = $db->Executa_Query_Single($query, $resp);
//   $data_nascimento = date('d-m-Y', strtotime($pes['data_nascimento']));
   $tela = '<input type="hidden" name="pessoa_id" value="'.$pessoa_id.'">
            <div class="row">
            <div class="form-group col-md-4">
             <label for="data_nasc">Data Nascimento</label>
             <input type="date" class="form-control" name="data_nascimento" value="'.$pes['data_nascimento'].'">
            </div>
            <div class="col-md-2">
              <label for="sexo">Sexo: </label>
              <input type="text" name="sexo" class="form-control" value="'.$pes['sexo'].'">
            </div>
           </div>
           <div class="row"> 
            <div class="col-md-4">
             <label for="entidade">Entidade</label>
             <input type="text" class="form-control"name="entidade" value="'.$pes['nome_entidade'].'">
            </div>
            <div class="col-md-4">
             <label for="docto_mtg">Docto MTG</label> 
             <input type="text" name="docto_mtg" class="form-control" value="'.$pes['docto_mtg'].'">
            </div>
            <div class="col-md-4">
             <label for="validade_docto_mtg">Validade Docto MTG </label> 
             <input type="text" name="validade_docto_mtg" class="form-control" value="'.$pes['validade_docto_mtg'].'">
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-6">
              <button class="btn btn-primary btn-lg" onclick="xajax_Gravar_Inscri(xajax.getFormValues(\'tela_mod\')); return false;">Gravar Inscrição</buton>
              <button class="btn btn-danger  btn-lg" onclick="xajax_xajax_Exclui_Inscri(xajax.getFormValues(\'tela_mod\')); return false;">Exclui Inscrição</buton>
              <button class="btn btn-warning btn-lg" onclick="xajax_Desiste(xajax.getFormValues(\'tela_mod\')); return false;">Cancela</buton>
            </div>
          </div>';   
   $resp->assign('dados_pessoa', 'innerHTML', $tela);        
//   $resp->alert('Aqui : '.print_r($pes,true).' - '.ID);
   return $resp;
}

function Calcular_datas($d1='', $d2)
{
   $d22 = new DateTime($d2);
   if (!$d1) {  $d11 = new DateTime('now'); 
   } else { $d11 = new DateTime($d1); }
   $intervalo = $d11->diff( $d22 );
//   return $intervalo->y.'-'.$intervalo->m.'-'.$intervalo->d;
   return $intervalo->y;
}

function Gravar_Inscri($dados)  {
   $resp = new xajaxResponse();
   global $db;
   //dados evento
   $evento_id = $dados['evento_id'];
   $modal_id = $dados['modal_id'];
   $pessoa_id = $dados['pessoa_id'];
   if (!$evento_id) { $resp->alert('Evento não Informado'); return $resp; }
   $query = " select data_inicio_inscri, data_final_inscri, data_base_calculo_idade from evento where evento_id = $evento_id ";
   $ev = $db->executa_Query_Single($query, $resp);
   // validar periodo de inscrição
   $hoje = date('Y-m-d');
   $data_inicio_inscri = date('Y-m-d', strtotime($ev['data_inicio_inscri']));
   $data_final_inscri  = date('Y-m-d', strtotime($ev['data_final_inscri']));
   $data_base_calculo_idade = $ev['data_base_calculo_idade'];
   if ($hoje < $data_inicio_inscri) {
      $resp->alert('Data para inscrições ainda não estão abertas, confira! '.$hoje.'-'.$data_inicio_inscri);
      return $resp;
   }
   if ($hoje > $data_final_inscri) {
      $resp->alert('Prazo para inscrições já encerrou, confira! '.$hoje.'-'.$data_final_inscri);
      return $resp;
   }
   // validar idades limites para modalidade.
   $valido = 1;
   $data_nascimento = $dados['data_nascimento'];   
   $idade = Calcular_datas($data_base_calculo_idade, $data_nascimento);
//   $resp->alert('Aqui : '.$data_base_calculo_idade.' - '.$data_nascimento.' - '.$idade); return $resp;
   $query = "select idade_minima, idade_maxima from modalidades where mod_id = $modal_id ";
   $mod   = $db->executa_Query_Single($query, $resp);
   $idade_minima = $mod['idade_minima'];
   $idade_maxima = $mod['idade_maxima'];
   if ($idade_minima > 0) {
      if ($idade < $idade_minima) {
         $resp->alert('Idade do competidor abaixo da idade minima da modalidade! '.$idade.'-'.$idade_minima);
         return $resp;
      }
   }
   if ($idade_maxima > 0) {
      if ($idade > $idade_maxima) {
         $resp->alert('Idade do competidor acima da idade máxima da modalidade! '.$idade.'-'.$idade_maxima);
         return $resp;
      }
   }
   if (!$dados['entidade']) {
      $resp->alert('Competidor não vinculado a nehuma entidade, verifique! '.$dados['entidade']);
      return $resp;
   }
   if (!$dados['docto_mtg']) {
      $valido = 0;
   }
   $validade_docto_mtg =  $dados['validade_docto_mtg'];
   if (!$validade_docto_mtg) {
      $valido = 0;
   }
   if ($hoje > $validade_docto_mtg) {
      $valido = 0;
   }
   $query = " select coalesce(max(insc_id + 1) ,1) as num  from inscritos_evento where evento_id = $evento_id and modal_id = $modal_id ";
   $insc_id = $db->Executa_Query_Unico($query, $tela);

   $query = " insert into inscritos_evento (evento_id, modal_id, insc_id, pessoa_id, data_hora_inscri, ordem_sorteio, "
     .  " situ_inscri, id_altera, data_altera)  values("
     . " $evento_id, $modal_id, $insc_id, $pessoa_id, CURRENT_TIMESTAMP, NULL, $valido, 1, CURRENT_TIMESTAMP)";
   $db->Executa_Query_SQL($query, $resp);  
   $resp->script("xajax_Tela_Inscritos($evento_id, $modal_id);"); 
   return $resp;
}

function Desiste($dados)  {
   $resp = new xajaxResponse();
//   $resp->assign("inscrever", 'className', 'esconder');
   $resp->assign("inscritos", 'className','mostrar');
   $resp->assign("inscrever", 'innerHTML', '');
   $evento_id = $dados['evento_id'];
   $modal_id  = $dados['modal_id'];
//   $resp->alert('Aqui Desiste : '.print_r($dados,true).' - '.ID);
//   $resp->script("xajax_Tela_Inicial();"); 
   $resp->script("xajax_Tela_Inscritos($evento_id, $modal_id);"); 
   return $resp;
}

   /*
   CREATE TABLE `inscritos_evento` (
      `evento_id` int(5) NOT NULL,
      `modal_id` int(3) NOT NULL,
      `insc_id` int(3) NOT NULL,
      `pessoa_id` int(5) NOT NULL,
      `data_hora_inscri` datetime NOT NULL,
      `ordem_sorteio` int(3) DEFAULT NULL,
      `situ_inscri` tinyint(1) DEFAULT 0 COMMENT 'Situação Inscrição: 0 pendente, 1-Confirmada',
      `id_altera` int(5) DEFAULT NULL COMMENT 'Id do Operador',
      `data_altera` datetime DEFAULT NULL COMMENT 'Data Hora Alteração',
      PRIMARY KEY (`evento_id`,`modal_id`,`insc_id`,`pessoa_id`),

      Validar data_nascimento, entidade, docto_mtg, validade_docto_mtg
   */   


function combo_evento($evento='', $resp)  {
    global $db;
    $query = "select evento_id, titulo_evento  from lista_eventos ";
    $res = $db->Executa_Query_Array($query, $resp);
    // $ret = print_r($res, true);    return $ret;
    $ret = '<select class="form-control" name="evento_id" id="evento_id" onchange="xajax_Tela_Modal(xajax.getFormValues(\'tela_mod\')); return false;">
             <option value="0" class="form-control">Escolha o Evento: </option>';
    for ($i = 0; $i < count($res); ++$i) {
        $evento_id = $res[$i]['evento_id'];
        $titulo_evento = $res[$i]['titulo_evento'];
        if ($evento_id == $evento) { $sel = ' selected '; } else { $sel = ''; }
        $ret .= '<option value="'.$evento_id.'" '.$sel.' class="form-control"> '.$titulo_evento.' </option> ';
    }
    $ret .= '</select> ';
    return $ret;
 }
