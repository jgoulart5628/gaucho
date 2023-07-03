<?php
   /*
CREATE TABLE `evento` (
  `evento_id` int(5) NOT NULL COMMENT 'Chave Primária',
  `entidade_id` int(5) NOT NULL COMMENT 'Entidade Promotora',
  `titulo_evento` varchar(100) NOT NULL COMMENT 'Nome d0 Evento',
  `info_complementar` text DEFAULT NULL COMMENT 'Informações Complementares do Evento',
  `data_evento` date NOT NULL COMMENT 'Data Oficial do Evento',
  `data_inicio_inscri` datetime DEFAULT NULL COMMENT 'Data Inicial Inscrições',
  `data_final_inscri` datetime DEFAULT NULL COMMENT 'Data Final para Inscrições',
  `data_base_calculo_idade` date DEFAULT NULL COMMENT 'Data base para cálculo idade inscritos',
  PRIMARY KEY (`evento_id`),
  KEY `evento_FK` (`entidade_id`)
   */ 
   error_reporting(E_ALL);

class classe_evento extends banco_Dados
{
    private $tabela = 'evento';
    private $evento_id;
    private $key  = 'evento_id';
    private $entidade_id;
    private $titulo_evento;
    private $info_complementar;
    private $data_evento;
    private $data_inicio_inscri;
    private $data_final_inscri;
    private $data_base_calculo_idade;
    public $db;

    public function __construct($nome)
    {
        $this->db = new banco_Dados($nome);
    }

    public function Monta_lista($resp = '')
    {
        $query = " select * from evento e order by e.data_evento ";
        $res = $this->db->Executa_Query_Array($query, $resp);

        return $res;
    }

    public function Ler_Registro($id, $tela = '')
    {
        $query = " select * from $this->tabela where $this->key  = $id ";
        $res = $this->db->Executa_Query_Single($query, $tela);

        return $res;
    }

    public function Busca_Proximo_ID($tela = '')
    {
        $query = " select coalesce(max($this->key + 1) ,1) as num  from $this->tabela ";
        $res = $this->db->Executa_Query_Unico($query, $tela);

        return $res;
    }

    public function Monta_lista_Entidades($entidade, $resp = '')
    {
        $query = " select entidade_id, nome_entidade,  case when entidade_id = $entidade then 'SELECTED' else ' ' end sel from entidade ";
        $res = $this->db->Executa_Query_Array($query, $resp);

        return $res;
    }
    public function Monta_lista_Modalidades_Evento($evento_id, $resp = '')
    {
        $query = " select me.evento_id, me.modal_id, me.limite_inscritos
                   ,(select m.descri from modalidades m where m.mod_id = me.modal_id) as nome_modal
                   from modal_evento me where me.evento_id = $evento_id order by nome_modal ";
        $res = $this->db->Executa_Query_Array($query, $resp);
        return $res;
    }

    public function Atualiza_modal_evento($evento_id, $dados, $resp) {
       $query = " delete from modal_evento where evento_id = $evento_id ";
       $e = $this->db->Executa_Query_SQL($query, $resp);
       for ($a = 0; $a < count($dados['modal']); $a++) {
         $modal_id = $dados['modal'][$a];
         $query = " insert into modal_evento values($evento_id, $modal_id, 0 )";
         $e = $this->db->Executa_Query_SQL($query, $resp);
        }
       return $e;
    }
    public function Lista_Modalidades($evento_id=0, $resp = '')
    {
        $query = " select m.mod_id, m.descri ,(select 'selected' from modal_evento me where me.evento_id = $evento_id and me.modal_id = m.mod_id) selected
        from modalidades m     order by m.descri ";
        $res = $this->db->Executa_Query_Array($query, $resp);
        return $res;
    }


    public function Excluir_Registro($id, $tela = '')
    {
        $query = " delete  from $this->tabela where $this->key = $id ";
        $e = $this->db->Executa_Query_SQL($query, $tela);

        return $e;
    }

    public function Alterar_Registro($dados_tela, $tela = '')
    {
        /*
        `evento_id` `entidade_id` `titulo_evento` `info_complementar` `data_evento`
          `data_inicio_inscri`  `data_final_inscri`  `data_base_calculo_idade`
        */
        $evento_id = $dados_tela['evento_id'];
        $entidade_id = $dados_tela['entidade'];
        $query = " update $this->tabela set ";
        $dados_tabela = $this->Ler_Registro($evento_id, $tela);
        $titulo_evento = $dados_tela['titulo_evento'];
        $info_complementar = $dados_tela['info_complementar'];
        $data_evento = $dados_tela['data_evento'];
        $data_inicio_inscri = $dados_tela['data_inicio_inscri'];
        $data_final_inscri = $dados_tela['data_final_inscri'];
        $data_base_calculo_idade = $dados_tela['data_base_calculo_idade'];
        $flag = 0;
        if ($titulo_evento !== $dados_tabela['titulo_evento']) {
            $query .= " titulo_evento  =  '$titulo_evento' ,";
            ++$flag;
        }
        if ($info_complementar !== $dados_tabela['info_complementar']) {
            $query .= " info_complementar =  '$info_complementar' ,";
            ++$flag;
        }
        if ($entidade_id !== $dados_tabela['entidade_id']) {
            $query .= " entidade_id =  $entidade_id ,";
            ++$flag;
        }
        if ($data_evento !== $dados_tabela['data_evento']) {
            $query .= " data_evento =  '$data_evento' ,";
            ++$flag;
        }
        if ($data_inicio_inscri !== $dados_tabela['data_inicio_inscri']) {
            $query .= " data_inicio_inscri =  '$data_inicio_inscri' ,";
            ++$flag;
        }
        if ($data_final_inscri !== $dados_tabela['data_final_inscri']) {
            $query .= " data_final_inscri =  '$data_final_inscri' ,";
            ++$flag;
        }
        if ($data_base_calculo_idade !== $dados_tabela['data_base_calculo_idade']) {
            $query .= " data_base_calculo_idade =  '$data_base_calculo_idade' ,";
            ++$flag;
        }
        if ($flag > 0) {
            $queryx = rtrim($query, ' , ');
            $queryx .= " where $this->key = $evento_id ";
            $e = $this->db->Executa_Query_SQL($queryx, $tela);
        }
 
        return $e;
    }

    public function Incluir_Registro($dados, $tela = '')
    {/*
        `evento_id` `entidade_id` `titulo_evento` `info_complementar` `data_evento`
          `data_inicio_inscri`  `data_final_inscri`  `data_base_calculo_idade`
        */
        $evento_id = $dados['evento_id'];
        $entidade_id = $dados['entidade'];
        $titulo_evento = $dados['titulo_evento'];
        $info_complementar = $dados['info_complementar'];
        $data_evento = $dados['data_evento'];
//        if (!$data_evento) { $data_evento = '0000-00-00';};
        $data_inicio_inscri = $dados['data_inicio_inscri'];
//        if (!$data_inicio_inscri) { $data_inicio_inscri = '0000-00-00';};
        $data_final_inscri = $dados['data_final_inscri'];
//        if (!$data_final_inscri) { $data_final_inscri = '0000-00-00';};
        $data_base_calculo_idade = $dados['data_base_calculo_idade'];
//        if (!$data_base_calculo_idade) { $data_base_calculo_idade = '0000-00-00';};
        $query = " insert into $this->tabela values( 
                    $evento_id,
                    $entidade_id,
                   '$titulo_evento', 
                   '$info_complementar', 
                   '$data_evento', 
                   '$data_inicio_inscri', 
                   '$data_final_inscri', 
                   '$data_base_calculo_idade'  )";
        $e = $this->db->Executa_Query_SQL($query, $tela);
 
        return $e;
    }
    public function Insere_Imagem($query, $tela='')  {
        $e   = $this->db->Executa_Query_SQL($query, $tela);
        return $e;       
    }
    public function BLOB_IMAGEM($query, $arquivo, $resp = '')
    {
        $column = ':imagem';
        $resul = $this->db->Executa_Query_BLOB($query, $column, $arquivo, $resp);
        return $resul;
    }

    public function Lista_Links($evento_id, $resp) {
       $query = " select * from links_evento where evento_id = $evento_id ";
       $links = $this->db->Executa_Query_Array($query, $resp);
       return $links;
    }
    public function Leitura_Link($evento_id, $link_seq, $resp) {
        $query = " select * from links_evento where evento_id = $evento_id and link_seq = $link_seq ";
        $link = $this->db->Executa_Query_Single($query, $resp);
        return $link;
     }
    public function Elimina_Link($evento_id, $link_seq, $resp)
    {
        $query = " delete from links_evento  where evento_id = $evento_id and link_seq = $link_seq  ";
        $e  = $this->db->Executa_Query_SQL($query, $resp);
        return $e;       
    }
    public function Atualiza_Link($dados, $resp) {
        $evento_id   = $dados['evento_id'];
        $link_seq    = $dados['link_seq'];
        $link_titulo = $dados['link_titulo'];
        $link_url    = $dados['link_url'];
        $oper        = $dados['oper'];
        if ($oper == "Incluir") {
            $query = " insert into links_evento values($evento_id, $link_seq, '$link_titulo', '$link_url' )";
        } else {
          $query = " update links_evento set link_titulo = '$link_titulo', link_url = '$link_url' where evento_id = $evento_id and link_seq = $link_seq ";  
        }         
        $e = $this->db->Executa_Query_SQL($query, $resp);
        return $e;
    }
     public function Busca_Imagem($evento_id, $tela='')  {
        $query = " select * from img_evento  where evento_id = $evento_id  ";
        $img  = $this->db->Executa_Query_Array($query, $tela);
        return $img;       
    }
    public function Elimina_Imagem($evento_id, $img_seq, $resp)
    {
        $query = " delete from img_evento  where evento_id = $evento_id and img_seq = $img_seq  ";
        $e  = $this->db->Executa_Query_SQL($query, $resp);
        return $e;       
    }

    public function Proximo_Indice_Imagem($evento_id, $tela='')  {
        $query   = " select coalesce(max(img_seq + 1),1) from img_evento where evento_id= $evento_id ";
        $index   = $this->db->Executa_Query_Unico($query, $tela);
        return $index;       
    }

    public function Proximo_Indice_Link($evento_id, $tela='')  {
        $query   = " select coalesce(max(link_seq + 1),1) from links_evento where evento_id= $evento_id ";
        $index   = $this->db->Executa_Query_Unico($query, $tela);
        return $index;
    }

}
