<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include("../inc/Classes_Dados.php");
/**
 * Description of ClassePessoa
 *
 * @author joao
 */
class ClassePessoa  extends getDados_model {
    public  $db; 
//    public  $dbi;
   public function __construct() {
       $this->db  = new getDados_model('MYSQL_deal');
//       $this->db  = new getDados_model('POSTGRESQL_deal');
 //      $this->dbi = new getDados_model('MYSQL_information_schema');
   }

   public function Monta_Lista_Pessoa($tela='')  {
       $query = " SELECT  a.xcodigo,
                          concat(a.tipopessoa, '-', (select b.tipo  FROM auxiliar_52510 b where  b.xcodigo = a.tipopessoa)) as descri_tipo,
                          a.tipoidentificacao as tipo, 
                          a.nomepessoa,
                          a.fantasia
             FROM  pessoa_41010 a ";
       $dados = $this->db->Executa_Query_Array($query, $tela); 
       $telax   = '<form name="lista_pes" id="lista_pes"><table id="clicli" data-toggle="table" class="table table-striped table-bordered"  data-sort-name="Tabela" data-sort-order="desc">
               <caption><div class="text-left"><button tyoe="submit" class="btn btn-primary" style="margin-top: 20px;" onclick="xajax_Manut_Pessoa(\'\'); return false;">Incluir Nova Pessoa</button>&nbsp;&nbsp;&nbsp;Total Registros : '.count($dados).' </div></caption>
               <thead>                  
                  <tr>
                    <th data-field="botoes"            data-sortable="false">Operação</th>
                    <th data-field="codigo"            data-sortable="true">Codigo</th>
                    <th data-field="tipo_pessoa "      data-sortable="true">Tipo Pessoa</th>
                    <th data-field="tipo_ident"        data-sortable="true">Tipo Ident.</th>
                    <th data-field="nome_pessoa        data-sortable="true">Nome Pessoa </th>
                    <th data-field="fantasia"          data-sortable="true">Nome Fantasia</th>
                 </tr>
                </thead>';
     $b = 0;
     $res = $this->busca_json('json_50130.json');
     if (count($dados) > 0)  {
        for($a = 0; $a < count($dados); $a++)  {
//           if ($b === 0 || fmod($b, 2) === 0) { $classe =  'class="t_line1"'; } else { $classe =  'class="t_line2"'; } 
           $xcodigo = $dados[$a]['xcodigo'];
           $tipo    = $dados[$a]['tipo'];
           $descri  = $res[$tipo]; 
           $nome    = $dados[$a]['nomepessoa'];
/*
  //         $telax .= '<tr '.$classe.'>
//           <input type="image" src="../img/lixeira1.png" width="32" height="24" data-toggle="tooltip" data-placement="bottom" title="Excluir Pessoa. (Exige senha)" onclick="xajax_Exclui_Pessoa('.$xcodigo.'); return false;">
                <input type="image" src="../img/ender.png" border="0" width="32" height="24" data-toggle="tooltip" data-placement="bottom" title="Manutençao de Endereços" onclick="xajax_Manut_Endereco(\''.$xcodigo.'\',\''.$nome.'\'); return false;">
  */              
           $telax .= '<tr>
               <td data-field="botoes"  style="text-align: center;" data-sortable="false">
              <input type="image" src="../img/edit-icon.png" border="0" width="32" height="24" data-toggle="tooltip" data-placement="bottom" title="Altera dados da Pessoa" onclick="xajax_Manut_Pessoa(\''.$xcodigo.'\'); return false;"></td>
               <td data-field="codigo"  style="text-align: center;" data-sortable="true"><b>'.$xcodigo.'</b></td>
               <td data-field="tipo_pessoa" style="text-align: left;" data-sortable="true">'.$dados[$a]['descri_tipo'].'</td>      
               <td data-field="tipo_ident"  style="text-align: left;" data-sortable="true">'.$tipo.'-'.$descri.'</td>
               <td data-field="nome_pessoa" style="text-align: left;"   data-sortable="true">'.$dados[$a]['nomepessoa'].'</td>
               <td data-field="fantasia"    style="text-align: left;"   data-sortable="true">'.$dados[$a]['fantasia'].'</td>
             </tr>';
            $b++;               
        }  
     }
     $telax .= '</table></form>';
     return $telax; 
   }
   
   public function Leitura_Pessoa($codigo, $tela='')  {
       $query  = " select * from pessoa_41010 where xcodigo = '$codigo' ";
       $dados = $this->db->Executa_Query_Single($query, $tela); 
       return $dados;            
   }

   public function Leitura_Endereco($codigo, $xseq ='', $tela='')  {
       if ($xseq) { $seq = " and xsequenciaendereco = $xseq "; } else { $seq = ''; } 
       $query  = " select * from pessoa_41070 where xcodigo = '$codigo' ".$seq.";";
       $dados = $this->db->Executa_Query_Single($query, $tela); 
       return $dados;            
   }

   public function Leitura_Telefones($codigo, $xseq ='', $tela='')  {
       if ($xseq) { $seq = " and xsequenciafone = $xseq "; } else { $seq = ''; } 
       $query  = " select * from pessoa_41090 where xcodigo = '$codigo' ".$seq.";";
       $dados = $this->db->Executa_Query_Array($query, $tela); 
       return $dados;            
   }

   public function Atualiza_Pessoa($query, $tela='')  {
       $e = $this->db->Executa_Query_SQL($query, $tela);
       return $e;       
   }
   
   public function Insere_Imagem($query, $tela='')  {
       $e   = $this->db->Executa_Query_SQL($query, $tela);
       return $e;       
   }

   public function Busca_Imagem($query, $tela='')  {
       $img  = $this->db->Executa_Query_Unico($query, $tela);
       return $img;       
   }
 
  public function Busca_Dados_Imagem($query, $tela='')  {
       $img  = $this->db->Executa_Query_Single($query, $tela);
       return $img;       
   }

   public function Proximo_Indice_Imagem($query, $tela='')  {
       $index   = $this->db->Executa_Query_Unico($query, $tela);
       if(!$index) { $index = 0; }
       return $index;       
   }

   public function Atualiza_Flag_Pessoa($query, $tela='')  {
       $e   = $this->db->Executa_Query_SQL($query, $tela);
       return $e;       
   }

   public function Meta_Tabela($tabela, $resp='')  {
       $query = " select coluna, tipo , label from adm_colunas where tabela =  '$tabela' ";
       $tabs = $this->db->Executa_Query_Array($query, $resp);
q       return $tabs;
   }


  public function combo_pessoa_41010($ret , $coluna, $tela = '') {  
      $ret = '<select class="form-control" name="'.$coluna.'" id="'.$coluna.'"><option value="" selected >Falta Fazer!</option></select>';
//      $query = " select xcodigo, atividadeprincipal from auxiliar_52010  order by 1"; 
//      $res = $this->db->Executa_Query_Array($query, $tela);   
 //     $ret .= '<select class="form-control" name="atividadeprincipal" id="atividadeprincipal"> <option value ="" //class="f_texto" ></option> ';
 //     $sel = '';
 //     for ($i=0; $i < count($res); $i++) {
 //         $xcodigo     = $res[$i]['xcodigo'];        
 //         $atividadeprincipal = $res[$i]['atividadeprincipal'];        
 //         if ($xcodigo == $atividadeprincipal) { $sel = ' selected '; } else { $sel = ''; }
 //         $ret .= '<option value="'.$xcodigo.'" '.$sel.' class="f_texto"> '.$xcodigo.' - '.$atividadeprincipal.' </option> '; 
//      }
//      $ret .= '</select> ';
     return $ret;
   }

   public function busca_json($json)  {
      $url = '../tabsjson/'.$json;
      return  json_decode(file_get_contents($url),true);
   }
 

  public function combo_geral($taborigem, $coluna, $param, $resp='') {
      $query  = "select valida from adm_colunas where tabela = '$taborigem' and coluna = '$coluna' ";
      $valida = $this->db->Executa_Query_Unico($query, $resp);
      $sel = '';
      $ret = '<select class="form-control" name="'.$coluna.'" id="'.$coluna.'"> <option value =""></option> ';
      if (strtolower(substr($valida,0,6)) !== 'tabela')  {
         $lista  = explode('|', $valida);
         foreach($lista as $res) {
            if (trim($res) == trim($param)) { $sel = ' selected '; } else { $sel = ''; }
            $ret .= '<option value="'.$res.'" '.$sel.' class="f_texto"> '.$res.' </option> '; 
         }
      }  
      if (strtolower(substr($valida,0,6)) == 'tabela')  {
         $tab      = explode(' ', $valida);
         $tabelax  = trim($tab[1]); 
         if(substr($tabelax,0,4) == 'json') {
            $res = $this->busca_json($tabelax.'.json');
            foreach ($res as $cod=>$var) {
              if ($cod > 0) {
                if ($cod == $param)  { $sel = ' selected '; } else { $sel = ''; }
                $ret .= '<option value="'.$cod.'" '.$sel.' class="f_texto"> '.$cod.' - '.$var.' </option> '; 
              }  
            }
         } else {
         $query = "select * from $tabelax  order by 2 "; 
//         $ret .= '<option>'.$query.'</option>';
         $res = $this->db->Executa_Query_Array($query, $resp);   
         for ($i=0; $i < count($res); $i++) {
             $dad = array_values($res[$i]);
             $xcodigo     = $dad[0];        
             $descri      = $dad[1];        
             if ($xcodigo == $param) { $sel = ' selected '; } else { $sel = ''; }
             $ret .= '<option value="'.$xcodigo.'" '.$sel.' class="f_texto"> '.$xcodigo.' - '.$descri.'-'.$col.'</option> '; 
         }
       }
     }
     $ret .= '</select> ';
     return $ret;
   }

  public function tela_dados_principal($dados_41010, $rd, $resp) {
    // combo_json_50130($dados_41010['tipoidentificacao'], $resp).'
   // Pessoa_41010 tela dados    
    $tabela       = 'pessoa_41010';
    $xcodigo      =  $dados_41010['xcodigo'];
    $cod_form     =  $xcodigo;
    $checkcadincS = ''; $checkcadincN = '';
    $atuafarS     = ''; $atuafarN     = '';
    $bloqsnS      = ''; $bloqsnN      = '';
    $emailatrasoS  = ''; $emailatrasoN = '';
    $consufinalS = ''; $consufinalN = '';
    if ($dados_41010['consumidorfinalsn'] == 0) { $consufinalS = 'checked="true"'; }  
    if ($dados_41010['consumidorfinalsn'] == 1) { $consufinalN = 'checked="true"'; }  
    if ($dados_41010['emailatraso'] == 0) { $emailatrasoS = 'checked="true"'; }  
    if ($dados_41010['emailatraso'] == 1) { $emailatrasoN = 'checked="true"'; }  
    if ($dados_41010['bloqsn'] == 0) { $bloqsnS = 'checked="true"'; }  
    if ($dados_41010['bloqsn'] == 1) { $bloqsnN = 'checked="true"'; }  
    if ($dados_41010['cadastroincompleto'] == 0) { $checkcadincS = 'checked="true"'; }  
      if ($dados_41010['cadastroincompleto'] == 1) { $checkcadincN = 'checked="true"'; }  
    if ($dados_41010['atuacaofarmacia'] == 0)   { $atuafarS = 'checked="true"'; }  
    if ($dados_41010['atuacaofarmacia'] == 1)   { $atuafarN = 'checked="true"'; }  
    if ($dados_41010['tipoidentificacao'] == 3)  { $cod_form = mask($xcodigo, '##.###.###/####-##'); }
    if ($dados_41010['tipoidentificacao'] == 20) { $cod_form = mask($xcodigo, '###.###.###-##'); }
   $tela = '<div class="row">
   <div class="col-sm-12">
   <div class="form-group col-sm-2"> <label for="xcodigo">Código</label> <input type="text" class="form-control" name="xcodigo" id="xcodigo" value="'.$cod_form.'" '.$rd.'> </div>
   <div class="form-group col-sm-2"> <label for="tipopessoa">Tipo Pessoa</label>'.$this->combo_geral($tabela,'tipopessoa', $dados_41010['tipopessoa'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="tipoidentificacao">Tipo Id</label>
   '.$this->combo_geral($tabela, 'tipoidentificacao', $dados_41010['tipoidentificacao'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="nomepessoa">Nome/Razão</label> <input type="text" class="form-control" name="nomepessoa" id="nomepessoa" value="'.$dados_41010['nomepessoa'].'" > </div>
   <div class="form-group col-sm-2"> <label for="fantasia">Fantasia</label> <input type="text" class="form-control" name="fantasia" id="fantasia" value="'.$dados_41010['fantasia'].'" > </div>
   <div class="form-group col-sm-2"> <label for="mensagemalerta">Alerta</label> <textarea cols="45" rows="3" class="form-control" name="mensagemalerta" id="mensagemalerta" >'.$dados_41010['mensagemalerta'].'</textarea></div>
   <div class="form-group col-sm-2"> <label for="site">Web Site</label><input type="url" class="form-control" name="site" id="site" value="'.$dados_41010['site'].'"></div>
   <div class="form-group col-sm-2"> <label for="emailinstitucional">E-Mail</label><input type="email" class="form-control" name="emailinstitucional" id="emailinstitucional" value="'.$dados_41010['emailinstitucional'].'"></div>
   <div class="form-group col-sm-2"> <label for="obs">Observação</label> <textarea cols="45" rows="3" class="form-control" name="obs" id="obs" >'.$dados_41010['obs'].'</textarea></div>
   <div class="form-group col-sm-2">
     <label for="cadastroincompleto">Cad Incompleto</label>
     <div class="custom-control custom-radio custom-control-inline"> 
        <input type="radio" class="custom-control-input" name="cadastroincompleto" id="cadastroincompleto0" value="0" '.$checkcadincS.'>&nbsp;
          <label class="custom-control-label" for="cadastroincompleto0">Sim</label>&nbsp;&nbsp;
        <input type="radio" class="custom-control-input" name="cadastroincompleto" id="cadastroincompleto1" value="1" '.$checkcadincN.'>&nbsp;<label class="custom-control-label" for="cadastroincompleto1">Não</label>
     </div>   
   </div>
   <div class="form-group col-sm-2">
      <label for="atuacaofarmacia">Atua Farmácia</label>
      <div class="custom-control custom-radio custom-control-inline"> 
        <input type="radio" class="custom-control-input" name="atuacaofarmacia" id="atuacaofarmacia0" value="0" '.$atuafarS.'> &nbsp;
         <label class="custom-control-label" for="atuacaofarmacia0">Sim</label>&nbsp;&nbsp;
        <input type="radio" class="custom-control-input" name="atuacaofarmacia" id="atuacaofarmacia1" value="1" '.$atuafarN.'> &nbsp;<label class="custom-control-label" for="atuacaofarmacia1">Não</label>
      </div>
    </div>    
   <div class="form-group col-sm-2">
      <label for="atuacaoinstitucional">Atua Instit.</label>
      <div class="custom-control custom-radio custom-control-inline"> 
        <input type="radio" class="custom-control-input" name="atuacaoinstitucional" id="atuacaoinstitucional0" value="0" '.$atuainstS.'> &nbsp;
         <label class="custom-control-label" for="atuacaoinstitucional0">Sim</label>&nbsp;&nbsp;
        <input type="radio" class="custom-control-input" name="atuacaoinstitucional" id="atuacaoinstitucional1" value="1" '.$atuainstN.'> &nbsp;<label class="custom-control-label" for="atuacaoinstitucional">Não</label>
      </div>
    </div>    
    <div class="form-group col-sm-2"> <label for="atividadeprincipal">Atividade</label>'.$this->combo_geral($tabela, 'atividadeprincipal', $dados_41010['atividadeprincipal'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="conceito">Conceito</label>'.$this->combo_geral($tabela, 'conceito', $dados_41010['conceito'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="codigocontabil">Cód Contábil</label>'.$this->combo_geral($tabela, 'codigocontabil', $dados_41010['codigocontabil'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="regiao">Região</label>'.$this->combo_geral($tabela, 'regiao', $dados_41010['regiao'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="microregiao">Microrregião</label>'.$this->combo_geral($tabela, 'microregiao', $dados_41010['microregiao'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="segmento">Segmento</label>'.$this->combo_geral($tabela, 'segmento', $dados_41010['segmento'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="cfop">CFOP Usual</label>'.$this->combo_geral($tabela, 'cfop', $dados_41010['cfop'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="condicaopagamento">Condição Pagto</label>'.$this->combo_geral($tabela, 'condicaopagamento', $dados_41010['condicaopagamento'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="listadesconto">Lista Desconto</label>'.$this->combo_geral($tabela, 'listadesconto', $dados_41010['listadesconto'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="listapreco">Lista Preço</label>'.$this->combo_geral($tabela, 'listapreco',$dados_41010['listapreco'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="operacaobancaria">Operação Bancária</label>'.$this->combo_geral($tabela, 'operacaobancaria', $dados_41010['operacaobancaria'], $resp).'</div>';
//   onclick="xajax_Pesquisa_Pessoa(\''.$xcodigo.'\', \'representante\', '.$dados_41010['representante'].'); return false;"
   $tela .= '<div class="form-group col-sm-2">
      <label for="representante">Repres : </label>
       <input type="text" name="representante" class="typeahead form-control" id="pesq"   value="'.$dados_41010['representante'].'" placeholder="Pesquisa nome/código" >
   </div>
   <div class="form-group col-sm-2"> <label for="tipofrete">Tipo Frete</label>'.$this->combo_geral($tabela, 'tipofrete', $dados_41010['tipofrete'], $resp).'</div>
   <div class="form-group col-sm-2">
       <label for="transportadora">Transp</label> 
       <input type="text" name="transportadora" class="typeahead form-control" id="pesq"   value="'.$dados_41010['transportadora'].'" placeholder="Pesquisa nome/código" >
   </div>
   <div class="form-group col-sm-2">
       <label for="escritoriocontabil">Escritório Contábil</label>
       <input type="text" name="escritoriocontabil" class="typeahead form-control" id="pesq"   value="'.$dados_41010['escritoriocontabil'].'" placeholder="Pesquisa nome/código" >
   </div>
   <div class="form-group col-sm-2">
       <label for="contador">Contador</label>
       <input type="text" name="contador" class="typeahead form-control" id="pesq"   value="'.$dados_41010['contador'].'" placeholder="Pesquisa nome/código" >
   </div>
   <div class="form-group col-sm-2">
       <label for="codigosociosignatacio">Sócio Signatário</label>
       <input type="text" name="codigosociosignatacio" class="typeahead form-control" id="pesq"   value="'.$dados_41010['codigosociosignatacio'].'" placeholder="Pesquisa nome/código" >
   </div>
   <div class="form-group col-sm-2"> <label for="datacadastro">Data Cadastro</label> <input type="date" class="form-control" name="datacadastro" id="datacadastro" value="'.$dados_41010['datacadastro'].'" > </div>
   <div class="form-group col-sm-2">
       <label for="responsavel">Cód Responsável</label>
       <input type="text" name="responsavel" class="typeahead form-control" id="pesq"   value="'.$dados_41010['responsavel'].'" placeholder="Pesquisa nome/código">
   </div>
   <div class="form-group col-sm-2"> <label for="cnaeprincipal">CNAE Principal</label>'.$this->combo_geral($tabela, 'cnaeprincipal', $dados_41010['cnaeprincipal'], $resp).'</div>
   <div class="form-group col-sm-2">
     <label for="consumidorfinalsn">Consumidor Final</label>
          <div class="custom-control custom-radio custom-control-inline"> 
           <input type="radio" class="custom-control-input" name="consumidorfinalsn" id="consumidorfinalsn0" value="0" '.$consufinalS.'> &nbsp;
             <label class="custom-control-label" for="consumidorfinalsn0">Sim</label>&nbsp;&nbsp;
            <input type="radio" class="custom-control-input" name="consumidorfinalsn" id="consumidorfinalsn1" value="1" '.$consufinalN.'> &nbsp;<label class="custom-control-label" for="consumidorfinalsn">Não</label>
      </div>
    </div>  
   <div class="form-group col-sm-2"> <label for="regimetributario">Regime Tributário</label> 
   '.$this->combo_geral($tabela, 'regimetributario', $dados_41010['regimetributario'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="naturezajuridicapessoa">Nat Jurídica Pessoa</label>
   '.$this->combo_geral($tabela, 'naturezajuridicapessoa', $dados_41010['naturezajuridicapessoa'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="naturezajuridicarfb">Nat Jurídica RFB</label>'.$this->combo_geral($tabela, 'naturezajuridicarfb', $dados_41010['naturezajuridicarfb'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="situacaocadastralrfb">Sit Cadastral RFB</label>
   '.$this->combo_geral($tabela, 'situacaocadastralrfb', $dados_41010['situacaocadastralrfb'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="estadocivil">Estado Civil</label>
   '.$this->combo_geral($tabela, 'estadocivil', $dados_41010['estadocivil'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="aliquotasimples">Aliq Simples</label> <input type="number" class="form-control" name="aliquotasimples" id="aliquotasimples" value="'.$dados_41010['aliquotasimples'].'" > </div>
   <div class="form-group col-sm-2"> <label for="nfeobs">Observação</label> <textarea cols="45" rows="3" class="form-control" name="nfeobs" id="nfeobs" >'.$dados_41010['nfeobs'].'</textarea></div>
   <div class="form-group col-sm-2"> <label for="nfecopiaescritorio">Cópia Escr Contábil</label> <textarea cols="45" rows="3" class="form-control" name="nfecopiaescritorio" id="nfecopiaescritorio" >'.$dados_41010['nfecopiaescritorio'].'</textarea></div>
   <div class="form-group col-sm-2"> <label for="numerocnpjoucpf">Inscrição RFB</label> <input type="text" class="form-control" name="numerocnpjoucpf" id="numerocnpjoucpf" value="'.$dados_41010['numerocnpjoucpf'].'" > </div>
   <div class="form-group col-sm-2"> <label for="numeroinscricaoestadual">Inscrição Estadual</label> <input type="text" class="form-control" name="numeroinscricaoestadual" id="numeroinscricaoestadual" value="'.$dados_41010['numeroinscricaoestadual'].'" > </div>
   <div class="form-group col-sm-2"> <label for="inscricaosubstitutotributario">IE Subst Tributário</label> <input type="text" class="form-control" name="inscricaosubstitutotributario" id="inscricaosubstitutotributario" value="'.$dados_41010['inscricaosubstitutotributario'].'" > </div>
   <div class="form-group col-sm-2"> <label for="indicadorcontribuinte">Indicador Contrib</label>
   '.$this->combo_geral($tabela, 'indicadorcontribuinte', $dados_41010['indicadorcontribuinte'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="numeroinscricaomunicipal">Inscrição Municipal</label> <input type="text" class="form-control" name="numeroinscricaomunicipal" id="numeroinscricaomunicipal" value="'.$dados_41010['numeroinscricaomunicipal'].'" > </div>
   <div class="form-group col-sm-2"> <label for="inscricaosuframa">Inscrição Suframa</label> <input type="text" class="form-control" name="inscricaosuframa" id="inscricaosuframa" value="'.$dados_41010['inscricaosuframa'].'" > </div>
    <div class="form-group col-sm-2"> <label for="anvisaafesituacaocadastral">Situação Cadastral</label>
    '.$this->combo_geral($tabela, 'anvisaafesituacaocadastral', $dados_41010['anvisaafesituacaocadastral'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="anvisaafenumero">AFE Nro Registro</label> <input type="text" class="form-control" name="anvisaafenumero" id="anvisaafenumero" value="'.$dados_41010['anvisaafenumero'].'" > </div>
   <div class="form-group col-sm-2"> <label for="anvisaafevalidade">Data Validade</label> <input type="date" class="form-control" name="anvisaafevalidade" id="anvisaafevalidade" value="'.$dados_41010['anvisaafevalidade'].'" > </div>';

    if ($dados_41010['anvisaafeimagemdocto'] == 1) { $mostra = ""; } else { $mostra = "disabled"; }
    $campo = 'anvisaafeimagemdocto';
    $telaimg = '<div><button type="submit" class="btn btn-danger" onclick="xajax_Carrega_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Carregar</button><button type="submit" class="btn btn-success" '.$mostra.' onclick="xajax_Visualiza_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Visualiza</button></div>';
   $tela .= '<div class="form-group col-sm-2"> <label for="anvisaafeimagemdocto">Imagem Docto</label>'.$telaimg.'
   <div id="div_anvisaafeimagemdocto"></div>
   </div>
   <div class="form-group col-sm-2"> <label for="anvisaaesituacaocadastral">Situação Cadastral</label>
    '.$this->combo_geral($tabela, 'anvisaaesituacaocadastral', $dados_41010['anvisaaesituacaocadastral'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="anvisaaenumero">Nro Registro</label> <input type="text" class="form-control" name="anvisaaenumero" id="anvisaaenumero" value="'.$dados_41010['anvisaaenumero'].'" > </div>
   <div class="form-group col-sm-2"> <label for="anvisaaevalidade">Data Validade</label> <input type="date" class="form-control" name="anvisaaevalidade" id="anvisaaevalidade" value="'.$dados_41010['anvisaaevalidade'].'" > </div>';
    $campo = 'anvisaaeimagem';
    if ($dados_41010['anvisaaeimagem'] == 1) { $mostra = ""; } else { $mostra = "disabled"; }
    $telaimg = '<div><button type="submit" class="btn btn-danger" onclick="xajax_Carrega_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Carregar</button><button type="submit" class="btn btn-success" '.$mostra.' onclick="xajax_Visualiza_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Visualiza</button></div>';
    $tela .= '<div class="form-group col-sm-2"> <label for="anvisaaeimagem">Imagem Docto</label>'.$telaimg.'
     <div id="div_anvisaaeimagem"></div>
   </div>
   <div class="form-group col-sm-2">
       <label for="bloqsn">Bloq Compra Venda</label>
      <div class="custom-control custom-radio custom-control-inline"> 
        <input type="radio" class="custom-control-input" name="bloqsn" id="bloqsn0" value="0" '.$bloqsnS.'> &nbsp;
         <label class="custom-control-label" for="bloqsn0">Sim</label>&nbsp;&nbsp;
        <input type="radio" class="custom-control-input" name="bloqsn" id="bloqsn1" value="1" '.$bloqsnN.'> &nbsp;<label class="custom-control-label" for="bloqsn">Não</label>
      </div>
    </div>    
   <div class="form-group col-sm-2"> <label for="bloqdata">Data</label> <input type="date" class="form-control" name="bloqdata" id="bloqdata" value="'.$dados_41010['bloqdata'].'" > </div>
   <div class="form-group col-sm-2"> <label for="bloqmotivo">Motivo</label>'.$this->combo_geral($tabela, 'bloqmotivo', $dados_41010['bloqmotivo'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="limitecredito">Limite Crédito</label> <input type="number" class="form-control" name="limitecredito" id="limitecredito" value="'.$dados_41010['limitecredito'].'" > </div>
    <div class="form-group col-sm-2">
      <label for="emailatraso">Envia E-Mail Atraso</label>
      <div class="custom-control custom-radio custom-control-inline"> 
        <input type="radio" class="custom-control-input" name="emailatraso" id="emailatraso0" value="0" '.$emailatrasoS.'> &nbsp;
         <label class="custom-control-label" for="emailatraso0">Sim</label>&nbsp;&nbsp;
        <input type="radio" class="custom-control-input" name="emailatraso" id="emailatraso1" value="1" '.$emailatrasoN.'> &nbsp;<label class="custom-control-label" for="emailatraso1">Não</label>
      </div>
    </div>    
   <div class="form-group col-sm-2"> <label for="valorminimotransacao">Vlr Mín Transação</label> <input type="number" class="form-control" name="valorminimotransacao" id="valorminimotransacao" value="'.$dados_41010['valorminimotransacao'].'" > </div>
   <div class="form-group col-sm-2"> <label for="riscocredito">Avaliação Créd Risco</label> <input type="text" class="form-control" name="riscocredito" id="riscocredito" value="'.$dados_41010['riscocredito'].'" > </div>
   <div class="form-group col-sm-2">
       <label for="rededefarmacias">Rede Farmácias</label>
       <input type="text" name="rededefarmacias" class="typeahead form-control" id="pesq"   value="'.$dados_41010['rededefarmacias'].'" placeholder="Pesquisa nome/código" >
   </div>
   <div class="form-group col-sm-2"> <label for="cnestipo">CNES Tipo</label>'.$this->combo_geral($tabela, 'cnestipo', $dados_41010['cnestipo'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="cnesnumero">Nro</label> <input type="text" class="form-control" name="cnesnumero" id="cnesnumero" value="'.$dados_41010['cnesnumero'].'" > </div>
   <div class="form-group col-sm-2"> <label for="cnesvalidade">Data Validade</label> <input type="date" class="form-control" name="cnesvalidade" id="cnesvalidade" value="'.$dados_41010['cnesvalidade'].'" > </div>';
    if ($dados_41010['cnesimagem'] == 1) { $mostra = ""; } else { $mostra = "disabled"; }
    $campo = 'cnesimagem';
    $telaimg = '<div><button type="submit" class="btn btn-danger" onclick="xajax_Carrega_Arquivo(\''.$xcodigo.'\',\''.$tabela.'\', \''.$campo.'\'); return false;">Carregar</button><button type="submit" class="btn btn-success" '.$mostra.' onclick="xajax_Visualiza_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Visualiza</button></div>';
     $tela .= '<div class="form-group col-sm-2"> <label for="cnesimagem">Imagem Docto</label>'.$telaimg.'
    <div id="div_cnesimagem"></div>
   </div>
   <div class="form-group col-sm-2">
       <label for="farmaceuticoresponsavel">Farmacêutico(a) Resp</label>
       <input type="text" name="farmaceuticoresponsavel" class="typeahead form-control" id="pesq"   value="'.$dados_41010['farmaceuticoresponsavel'].'" placeholder="Pesquisa nome/código" >
   </div>
   <div class="form-group col-sm-2"> <label for="codigosanitario">Cód Sanitário</label> <textarea cols="45" rows="3" class="form-control" name="codigosanitario" id="codigosanitario" >'.$dados_41010['codigosanitario'].'</textarea></div>
   <div class="form-group col-sm-2"> <label for="alvarafuncionamentonumero">Alvará Funcion</label> <input type="text" class="form-control" name="alvarafuncionamentonumero" id="alvarafuncionamentonumero" value="'.$dados_41010['alvarafuncionamentonumero'].'" > </div>
   <div class="form-group col-sm-2"> <label for="alvarafuncionamentovalidade">Data Validade</label> <input type="date" class="form-control" name="alvarafuncionamentovalidade" id="alvarafuncionamentovalidade" value="'.$dados_41010['alvarafuncionamentovalidade'].'" > </div>';
    if ($dados_41010['alvarafuncionamentoimagem'] == 1) { $mostra = ""; } else { $mostra = "disabled"; }
    $campo = 'alvarafuncionamentoimagem';
    $telaimg = '<div><button type="submit" class="btn btn-danger" onclick="xajax_Carrega_Arquivo(\''.$xcodigo.'\',\''.$tabela.'\', \''.$campo.'\'); return false;">Carregar</button><button type="submit" class="btn btn-success" '.$mostra.' onclick="xajax_Visualiza_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Visualiza</button></div>';
     $tela .= '<div class="form-group col-sm-2"> <label for="alvarafuncionamentoimagem">Imagem Docto</label>'.$telaimg.'
    <div id="div_alvarafuncionamentoimagem"></div>
   </div>
   <div class="form-group col-sm-2"> <label for="alvaralocalizacaonumero">Alvará Localização</label> <input type="text" class="form-control" name="alvaralocalizacaonumero" id="alvaralocalizacaonumero" value="'.$dados_41010['alvaralocalizacaonumero'].'" > </div>
   <div class="form-group col-sm-2"> <label for="alvaralocalizacaovalidade">Data Validade</label> <input type="date" class="form-control" name="alvaralocalizacaovalidade" id="alvaralocalizacaovalidade" value="'.$dados_41010['alvaralocalizacaovalidade'].'" > </div>';
    if ($dados_41010['alvaralocalizacaoimagem'] == 1) { $mostra = ""; } else { $mostra = "disabled"; }
    $campo = 'alvaralocalizacaoimagem';
    $telaimg = '<div><button type="submit" class="btn btn-danger" onclick="xajax_Carrega_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Carregar</button><button type="submit" class="btn btn-success" '.$mostra.' onclick="xajax_Visualiza_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Visualiza</button></div>';
     $tela .= '<div class="form-group col-sm-2"> <label for="alvaralocalizacaoimagem">Imagem Docto</label>'.$telaimg.'
    <div id="div_alvaralocalizacaoimagem"></div>
   </div>
   <div class="form-group col-sm-2"> <label for="alvarasanitarionumero">Alvará Sanit Medic</label> <input type="text" class="form-control" name="alvarasanitarionumero" id="alvarasanitarionumero" value="'.$dados_41010['alvarasanitarionumero'].'" > </div>
   <div class="form-group col-sm-2"> <label for="alvarasanitariovalidade">Data Validade</label> <input type="date" class="form-control" name="alvarasanitariovalidade" id="alvarasanitariovalidade" value="'.$dados_41010['alvarasanitariovalidade'].'" > </div>';
    if ($dados_41010['alvarasanitarioimagem'] == 1) { $mostra = ""; } else { $mostra = "disabled"; }
    $campo = 'alvarasanitarioimagem';
    $telaimg = '<div><button type="submit" class="btn btn-danger" onclick="xajax_Carrega_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Carregar</button><button type="submit" class="btn btn-success" '.$mostra.' onclick="xajax_Visualiza_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Visualiza</button></div>';
     $tela .= '<div class="form-group col-sm-2"> <label for="alvarasanitarioimagem">Imagem Docto</label>'.$telaimg.'
    <div id="div_alvarasanitarioimagem"></div>
   </div>
   <div class="form-group col-sm-2"> <label for="certidaoregularidadenumero">Certid Regularidade</label> <input type="text" class="form-control" name="certidaoregularidadenumero" id="certidaoregularidadenumero" value="'.$dados_41010['certidaoregularidadenumero'].'" > </div>
   <div class="form-group col-sm-2"> <label for="certidaoregularidadevalidade">Data Validade</label> <input type="date" class="form-control" name="certidaoregularidadevalidade" id="certidaoregularidadevalidade" value="'.$dados_41010['certidaoregularidadevalidade'].'" > </div>';
    if ($dados_41010['certidaoregularidadeimagem'] == 1) { $mostra = ""; } else { $mostra = "disabled"; }
    $campo = 'certidaoregularidadeimagem';
    $telaimg = '<div><button type="submit" class="btn btn-danger" onclick="xajax_Carrega_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Carregar</button><button type="submit" class="btn btn-success" '.$mostra.' onclick="xajax_Visualiza_Arquivo(\''.$xcodigo.'\',\''.$tabela.'\', \''.$campo.'\'); return false;">Visualiza</button></div>';
     $tela .= '<div class="form-group col-sm-2"> <label for="certidaoregularidadeimagem">Imagem Docto</label>'.$telaimg.'
    <div id="div_certidaoregularidadeimagem"></div>
   </div>
   <div class="form-group col-sm-2"> <label for="boaspraticasnumero">Certif Boas Práticas</label> <input type="text" class="form-control" name="boaspraticasnumero" id="boaspraticasnumero" value="'.$dados_41010['boaspraticasnumero'].'" > </div>
   <div class="form-group col-sm-2"> <label for="boaspraticasvalidade">Data Validade</label> <input type="date" class="form-control" name="boaspraticasvalidade" id="boaspraticasvalidade" value="'.$dados_41010['boaspraticasvalidade'].'" > </div>';
    if ($dados_41010['boaspraticasimagem'] == 1) { $mostra = ""; } else { $mostra = "disabled"; }
    $campo = 'boaspraticasimagem';
    $telaimg = '<div><button type="submit" class="btn btn-danger" onclick="xajax_Carrega_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Carregar</button><button type="submit" class="btn btn-success" '.$mostra.' onclick="xajax_Visualiza_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Visualiza</button></div>';
     $tela .= '<div class="form-group col-sm-2"> <label for="boaspraticasimagem">Imagem Docto</label>'.$telaimg.'
    <div id="div_boaspraticasimagem"></div>
   </div>
   <div class="form-group col-sm-2"> <label for="licencapolicianumero">Licença Polícia Fed</label> <input type="text" class="form-control" name="licencapolicianumero" id="licencapolicianumero" value="'.$dados_41010['licencapolicianumero'].'" > </div>
   <div class="form-group col-sm-2"> <label for="licencapoliciavalidade">Data Validade</label> <input type="date" class="form-control" name="licencapoliciavalidade" id="licencapoliciavalidade" value="'.$dados_41010['licencapoliciavalidade'].'" > </div>';
    if ($dados_41010['licencapoliciaimagem'] == 1) { $mostra = ""; } else { $mostra = "disabled"; }
    $campo = 'licencapoliciaimagem';
    $telaimg = '<div><button type="submit" class="btn btn-danger" onclick="xajax_Carrega_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Carregar</button><button type="submit" class="btn btn-success" '.$mostra.' onclick="xajax_Visualiza_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Visualiza</button></div>';
     $tela .= '<div class="form-group col-sm-2"> <label for="licencapoliciaimagem">Imagem Docto</label>'.$telaimg.'
    <div id="div_licencapoliciaimagem"></div>
   </div>

   <div class="form-group col-sm-2"> <label for="fepamnumero">LO Fepam</label> <input type="text" class="form-control" name="fepamnumero" id="fepamnumero" value="'.$dados_41010['fepamnumero'].'" > </div>
   <div class="form-group col-sm-2"> <label for="fepamvalidade">Data Validade</label> <input type="date" class="form-control" name="fepamvalidade" id="fepamvalidade" value="'.$dados_41010['fepamvalidade'].'" > </div>';
    if ($dados_41010['fepamimagem'] == 1) { $mostra = ""; } else { $mostra = "disabled"; }
    $campo = 'fepamimagem';
    $telaimg = '<div><button type="submit" class="btn btn-danger" onclick="xajax_Carrega_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Carregar</button><button type="submit" class="btn btn-success" '.$mostra.' onclick="xajax_Visualiza_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Visualiza</button></div>';
     $tela .= '<div class="form-group col-sm-2"> <label for="fepamimagem">Imagem Docto</label>'.$telaimg.'
    <div id="div_fepamimagem"></div>
   </div>

   <div class="form-group col-sm-2"> <label for="bombeirosppci">Alvará PPCI</label> <input type="text" class="form-control" name="bombeirosppci" id="bombeirosppci" value="'.$dados_41010['bombeirosppci'].'" > </div>
   <div class="form-group col-sm-2"> <label for="bombeirosppcivalidade">Data Validade</label> <input type="date" class="form-control" name="bombeirosppcivalidade" id="bombeirosppcivalidade" value="'.$dados_41010['bombeirosppcivalidade'].'" > </div>
   <div class="form-group col-sm-2"> <label for="bombeirosregistro">Nro Registro</label> <input type="text" class="form-control" name="bombeirosregistro" id="bombeirosregistro" value="'.$dados_41010['bombeirosregistro'].'" > </div>
   <div class="form-group col-sm-2"> <label for="bombeirosregistrovalidade">Data Validade</label> <input type="date" class="form-control" name="bombeirosregistrovalidade" id="bombeirosregistrovalidade" value="'.$dados_41010['bombeirosregistrovalidade'].'" > </div>';
    if ($dados_41010['bombeirosimagem'] == 1) { $mostra = ""; } else { $mostra = "disabled"; }
    $campo = 'bombeirosimagem';
    $telaimg = '<div><button type="submit" class="btn btn-danger" onclick="xajax_Carrega_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Carregar</button><button type="submit" class="btn btn-success" '.$mostra.' onclick="xajax_Visualiza_Arquivo(\''.$xcodigo.'\', \''.$tabela.'\',\''.$campo.'\'); return false;">Visualiza</button></div>';
     $tela .= '<div class="form-group col-sm-2"> <label for="bombeirosimagem">Imagem Docto</label>'.$telaimg.'
    <div id="div_bombeirosimagem"></div>
   </div>
   <div class="form-group col-sm-2"> <label for="semvencimentodesde">Não Aceita Vct Entre</label> <input type="number" class="form-control" name="semvencimentodesde" id="semvencimentodesde" value="'.$dados_41010['semvencimentodesde'].'" > </div>
   <div class="form-group col-sm-2"> <label for="semvencimentoate">Até Dia</label> <input type="number" class="form-control" name="semvencimentoate" id="semvencimentoate" value="'.$dados_41010['semvencimentoate'].'" > </div>
   <div class="form-group col-sm-2"> <label for="semvencimentodias">Dias Não Aceitos</label> <input type="text" class="form-control" name="semvencimentodias" id="semvencimentodias" value="'.$dados_41010['semvencimentodias'].'" > </div>
   <div class="form-group col-sm-2"> <label for="fornecedorprecosdownload">Site Download Prçs</label> <input type="url" class="form-control" name="fornecedorprecosdownload" id="fornecedorprecosdownload" value="'.$dados_41010['fornecedorprecosdownload'].'" > </div>
   <div class="form-group col-sm-2"> <label for="prefeiturasecretariacodigo">Cód Secr Municipal</label> <input type="text" class="form-control" name="prefeiturasecretariacodigo" id="prefeiturasecretariacodigo" value="'.$dados_41010['prefeiturasecretariacodigo'].'" > </div>
   <div class="form-group col-sm-2"> <label for="prefeiturasecretarianome">Secretaria</label> <input type="text" class="form-control" name="prefeiturasecretarianome" id="prefeiturasecretarianome" value="'.$dados_41010['prefeiturasecretarianome'].'" >
   </div>
   <div class="form-group col-sm-2"> <label for="dealclass">Deal Class</label>'.$this->combo_geral($tabela, 'dealclass', $dados_41010['dealclass'], $resp).'</div> 

  </div></div>';
      return $tela; 
   }

   
  public function tela_dados_CRM($dados_41010,  $resp) {
    $tabela       = 'pessoa_41010';
    $xcodigo      =  $dados_41010['xcodigo'];
    $cod_form     =  $xcodigo;
    $nome         =  $dados_41010['nomepessoa'];
    $instapropriaS = ''; $instapropriaN = '';
    $atuainstN    = ''; $atuainstS    = ''; 
    if ($dados_41010['atuacaoinstitucional'] == 0) { $atuainstS = 'checked="true"'; }  
    if ($dados_41010['atuacaoinstitucional'] == 1) { $atuainstN = 'checked="true"'; }  
    if ($dados_41010['instalacaopropria'] == 0) { $instapropriaS = 'checked="true"'; }  
    if ($dados_41010['instalacaopropria'] == 1) { $instapropriaN = 'checked="true"'; }  
    if ($dados_41010['tipoidentificacao'] == 3)  { $cod_form = mask($xcodigo, '##.###.###/####-##'); }
    if ($dados_41010['tipoidentificacao'] == 20) { $cod_form = mask($xcodigo, '###.###.###-##'); }

   $tela .= '<h4>'.$cod_form.' '.$nome.'</h4>
             <div class="row">
             <div class="col-sm-12">
               <div class="form-group col-sm-2">
              <label for="principalcontato">CRM Contato</label>
              <input type="text" name="principalcontato" class="typeahead form-control" id="principalcontato"   value="'.$dados_41010['principalcontato'].'" placeholder="Pesquisa nome/código" >
           </div>
 
             <div class="form-group col-sm-2"> <label for="datafundacao">Data Fundação</label> <input type="date" class="form-control" name="datafundacao" id="datafundacao" value="'.$dados_41010['datafundacao'].'" > </div>
        <div class="form-group col-sm-2">
      <label for="atuacaoinstitucional">Atua Instit.</label>
      <div class="custom-control custom-radio custom-control-inline"> 
        <input type="radio" class="custom-control-input" name="atuacaoinstitucional" id="atuacaoinstitucional0" value="0" '.$atuainstS.'> &nbsp;
         <label class="custom-control-label" for="atuacaoinstitucional0">Sim</label>&nbsp;&nbsp;
        <input type="radio" class="custom-control-input" name="atuacaoinstitucional" id="atuacaoinstitucional1" value="1" '.$atuainstN.'> &nbsp;<label class="custom-control-label" for="atuacaoinstitucional">Não</label>
      </div>
    </div>    
   <div class="form-group col-sm-2">
          <label for="instalacaopropria">Instalação Própria</label>
          <div class="custom-control custom-radio custom-control-inline"> 
           <input type="radio" class="custom-control-input" name="instalacaopropria" id="instalacaopropria0" value="0" '.$instapropriaS.'> &nbsp;
             <label class="custom-control-label" for="instalacaopropria">Sim</label>&nbsp;&nbsp;
            <input type="radio" class="custom-control-input" name="instalacaopropria" id="instalacaopropria1" value="1" '.$instapropriaN.'> &nbsp;<label class="custom-control-label" for="instalacaopropria">Não</label>
      </div>
    </div>  
   <div class="form-group col-sm-2"> <label for="valoraluguel">Valor Aluguel</label> <input type="number" class="form-control" name="valoraluguel" id="valoraluguel" value="'.$dados_41010['valoraluguel'].'" > </div>
   <div class="form-group col-sm-2"> <label for="caixapostal">Caixa Postal</label> <input type="text" class="form-control" name="caixapostal" id="caixapostal" value="'.$dados_41010['caixapostal'].'" > </div>
   <div class="form-group col-sm-2"> <label for="capitalsocial">Capital Social</label> <input type="number" class="form-control" name="capitalsocial" id="capitalsocial" value="'.$dados_41010['capitalsocial'].'" > </div>
   <div class="form-group col-sm-2"> <label for="melhorhorario">Melhor Horário</label> <textarea cols="45" rows="3" class="form-control" name="melhorhorario" id="melhorhorario" >'.$dados_41010['melhorhorario'].'</textarea></div>
   <div class="form-group col-sm-2"> <label for="prazomediopagamento">Prazo Médio Pagto</label> <input type="number" class="form-control" name="prazomediopagamento" id="prazomediopagamento" value="'.$dados_41010['prazomediopagamento'].'" > </div>
   <div class="form-group col-sm-2"> <label for="przmediorecebimento">Receb</label> <input type="number" class="form-control" name="przmediorecebimento" id="przmediorecebimento" value="'.$dados_41010['przmediorecebimento'].'" > </div>
   <div class="form-group col-sm-2"> <label for="volumemediovenda">Vol Médio Venda</label> <input type="number" class="form-control" name="volumemediovenda" id="volumemediovenda" value="'.$dados_41010['volumemediovenda'].'" > </div>
   <div class="form-group col-sm-2"> <label for="volumemediocompra">Compra</label> <input type="number" class="form-control" name="volumemediocompra" id="volumemediocompra" value="'.$dados_41010['volumemediocompra'].'" > </div>
   <div class="form-group col-sm-2"> <label for="creditoavaliacao">Avaliação Crédito</label>
   '.$this->combo_geral($dados_41010['creditoavaliacao'], 'creditoavaliacao', $resp).'
   </div>
   <div class="form-group col-sm-2"> <label for="creditocondicaopagamento">Condição Pagto</label>'.$this->combo_geral($tabela, 'creditocondicaopagamento', $dados_41010['creditocondicaopagamento'], $resp).'</div>
   <div class="form-group col-sm-2"> <label for="creditodataavaliacao">Data</label> <input type="date" class="form-control" name="creditodataavaliacao" id="creditodataavaliacao" value="'.$dados_41010['creditodataavaliacao'].'" > </div>
   <div class="form-group col-sm-2"> <label for="creditoestoquevisivel">Estoque Visível</label>
   '.$this->combo_geral($tabela, 'creditoestoquevisivel', $dados_41010['creditoestoquevisivel'], $resp).' </div>
   <div class="form-group col-sm-2"> <label for="creditoinstalacoesvisivel">Instalação Visível</label>
   '.$this->combo_geral($tabela, 'creditoinstalacoesvisivel', $dados_41010['creditoinstalacoesvisivel'], $resp).' </div>
   <div class="form-group col-sm-2"> <label for="creditomovtovisivel">Movto Visível</label>
   '.$this->combo_geral($tabela, 'creditomovtovisivel', $dados_41010['creditomovtovisivel'], $resp).'  </div>
   <div class="form-group col-sm-2">
       <label for="creditoresponsavelvenda">Resp Venda</label>
       <input type="text" name="creditoresponsavelvenda" class="typeahead form-control" id="creditoresponsavelvenda"   value="'.$dados_41010['creditoresponsavelvenda'].'" placeholder="Pesquisa nome/código" onchange="pesquisa_pessoa();">
   </div>
   <div class="form-group col-sm-2">
       <label for="creditoresponsavelavaliacao">Resp Avaliação</label>
       <input type="text" name="creditoresponsavelavaliacao" class="typeahead form-control" id="creditoresponsavelavaliacao"   value="'.$dados_41010['creditoresponsavelavaliacao'].'" placeholder="Pesquisa nome/código">
   </div>
   <div class="form-group col-sm-2"> <label for="creditolimitesugerido">Limite Sugerido</label> <input type="number" class="form-control" name="creditolimitesugerido" id="creditolimitesugerido" value="'.$dados_41010['creditolimitesugerido'].'" > </div>
   <div class="form-group col-sm-2"> <label for="creditoobs">Observação</label> <textarea cols="45" rows="3" class="form-control" name="creditoobs" id="creditoobs" >'.$dados_41010['creditoobs'].'</textarea></div>
   <div class="form-group col-sm-2"> <label for="nfeemail">E-Mail Principal</label><input type="email" class="form-control" name="nfeemail" id="nfeemail" >'.$dados_41010['nfeemail'].'</div>
   <div class="form-group col-sm-2"> <label for="nfecopiaemail">Cópia E-Mail</label><input type="email" class="form-control" name="nfecopiaemail" id="nfecopiaemail" >'.$dados_41010['nfecopiaemail'].'</div>  
   </div></div>';
     return $tela; 
}

   public function tela_dados_endereco($dados_41070, $xcodigo, $resp) {
       $tabela = 'pessoa_41070'; 
       $cod_form     =  $xcodigo;
       if (!$dados_41070['xsequenciaendereco']) { $dados_41070['xsequenciaendereco'] =  1; }
       $tela = '<div class="row">
           <div class="col-sm-12">
             <div class="form-group col-sm-2">
                <label for="xcodigo">Código</label>
                <input type="text" class="form-control" name="xcodigo" id="xcodigo" value="'.$xcodigo.'" readonly>
             </div>
             <div class="form-group col-sm-2">
                <label for="xsequenciaendereco">Seq</label>
                <input type="number" class="form-control" name="xsequenciaendereco" id="xsequenciaendereco" value="'.$dados_41070['xsequenciaendereco'].'" readonly>
             </div>
             <div class="form-group col-sm-2">
               <label for="tipo">Tipo</label>
              '.$this->combo_geral($tabela, 'tipo', $dados_41070['tipo'], $resp).' 
             </div>
             <div class="form-group col-sm-2">
                <label for="localizacaofisica">LocalizFísica</label>
                '. $this->combo_geral($tabela, 'localizacaofisica', $dados_41070['localizacaofisica'], $resp).'
             </div>
             <div class="form-group col-sm-2">
                <label for="cep">CEP</label>
                <input type="text" class="form-control" name="cep" id="cep" value="'.$dados_41070['cep'].'">
                <button type="submit" class="btn"  onclick="xajax_busca_cep(xajax.getFormValues(\'dados_tela_endereco\')); return false;">Buscar Cep</button> 
             </div>
             <div class="form-group col-sm-2">
                <label for="logradouro">Logradouro</label>
                <input type="text" class="form-control" name="logradouro" id="logradouro" value="'.$dados_41070['logradouro'].'" >
              </div>
              <div class="form-group col-sm-2">
                 <label for="numero">Nro</label>
                   <input type="number" class="form-control" name="numero" id="numero" value="'.$dados_41070['numero'].'" >
             </div>
             <div class="form-group col-sm-2">
                <label for="complmento">Complemento</label>
                <input type="text" class="form-control" name="complmento" id="complmento" value="'.$dados_41070['complmento'].'" >
             </div>
             <div class="form-group col-sm-2">
                <label for="bairro">Bairro</label>
                <input type="text" class="form-control" name="bairro" id="bairro" value="'.$dados_41070['bairro'].'" > 
             </div>
             <div class="form-group col-sm-2">
               <label for="distrito">Distrito</label>
                 <input type="text" class="form-control" name="distrito" id="distrito" value="'.$dados_41070['distrito'].'" >
             </div>
            <div class="form-group col-sm-2">
                <label for="codmunicipioibge">Cód Município</label>
                '.$this->combo_geral($tabela, 'codmunicipioibge', $dados_41070['codmunicipioibge'], $resp).' 
            </div>
            <div class="form-group col-sm-2">
                <label for="uf">UF</label>
                 <input type="text" class="form-control" name="uf" id="uf" value="'.$dados_41070['uf'].'" >
            </div>
            <div class="form-group col-sm-2">
                <label for="codigopaisibge">Cód País</label>
                '.$this->combo_geral($tabela, 'codigopaisibge', $dados_41070['codigopaisibge'], $resp).'
            </div>
            <div class="form-group col-sm-2">
                <label for="caixapostal">Caixa Postal</label>
                 <input type="text" class="form-control" name="caixapostal" id="caixapostal" value="'.$dados_41070['caixapostal'].'" >
            </div>
            <div class="form-group col-sm-4">
                <button type="submit" class="btn btn-primary" onclick="xajax_Grava_Dados_Endereco(xajax.getFormValues(\'dados_tela_endereco\')); return false;">Grava Endereço '.$label.'</button>
            </div>   
            </div></div>';
        return $tela;
   }

   public function tela_dados_telefones($dados_41090 = '', $xcodigo, $resp = '') {
       $tabela = 'pessoa_41090'; 
       $cod_form     =  $xcodigo;
       if (!$dados_41090['xsequenciafone']) { $dados_41090['xsequenciafone'] =  1; }
       $tela = '<div class="row">
       <div class="col-sm-12">
          <div class="form-group col-sm-2"> <label for="xcodigo">Código</label> <input type="text" class="form-control" name="xcodigo" id="xcodigo" value="'.$cod_form.'" readonly>
          </div>
          <div class="form-group col-sm-2"> <label for="xsequenciafone">Seq</label> <input type="number" class="form-control" name="xsequenciafone" id="xsequenciafone" value="'.$dados_41090['xsequenciafone'].'" ></div>
          <div class="form-group col-sm-2"> <label for="tipo">Tipo</label>
             '.$this->combo_geral($tabela, 'tipo', $dados_41090['tipo'], $resp).'
          </div>
         <div class="form-group col-sm-2"> <label for="codigooperadorafixa">Operadora Fixa</label>'.$this->combo_geral($tabela, 'codigooperadorafixa', $dados_41090['codigooperadorafixa'], $resp).'
         </div>
         <div class="form-group col-sm-2"> <label for="codigooperadoramovel">Operadora Móvel</label> 
          '.$this->combo_geral($tabela, 'codigooperadoramovel', $dados_41090['codigooperadoramovel'], $resp).' 
         </div>
         <div class="form-group col-sm-2"> <label for="codigoddi">DDI Cód País</label>'.$this->combo_geral($tabela, 'codigoddi', $dados_41090['codigoddi'], $resp).'
         </div>
         <div class="form-group col-sm-2"> <label for="codigoddd">DDD Cód Cidade</label>'.$this->combo_geral($tabela, 'codigoddd', $dados_41090['codigoddd'], $resp).'
         </div>
         <div class="form-group col-sm-2"> <label for="numerotelefone">Nro Telefone</label> <input type="text" class="form-control" name="numerotelefone" id="numerotelefone" value="'.$dados_41090['numerotelefone'].'" > </div>
         <div class="form-group col-sm-2"> <label for="ramal">Ramal</label> <input type="text" class="form-control" name="ramal" id="ramal" value="'.$dados_41090['ramal'].'" > </div>
        </div>
        <div class="form-group col-sm-4">
            <button type="submit" class="btn btn-primary" onclick="xajax_Grava_Telefones(xajax.getFormValues(\'dados_tela_telefones\')); return false;">Grava Telefone</button>
        </div>
    </div>';
        return $tela;
   }
}
