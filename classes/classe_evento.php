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

class classe_evento extends acesso_db
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
        $this->db = new acesso_db($nome);
    }

    public function Monta_lista($resp = '')
    {
        $query = " select *  from $this->tabela order by 1, 2 ";
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
        $query = " select nvl(max($this->key + 1) ,1) as num  from $this->tabela ";
        $res = $this->db->Executa_Query_Unico($query, $tela);

        return $res;
    }

    public function Monta_lista_Entidades($entidade, $resp = '')
    {
        $query = " select entidade_id, nome_entidade,  case when entidade_id = $entidade then 'SELECTED' else ' ' end sel from entidade ";
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
        if (!$data_evento) { $data_evento = '0000-00-00';};
        $data_inicio_inscri = $dados['data_inicio_inscri'];
        if (!$data_inicio_inscri) { $data_inicio_inscri = '0000-00-00';};
        $data_final_inscri = $dados['data_final_inscri'];
        if (!$data_final_inscri) { $data_final_inscri = '0000-00-00';};
        $data_base_calculo_idade = $dados['data_base_calculo_idade'];
        if (!$data_base_calculo_idade) { $data_base_calculo_idade = '0000-00-00';};
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


}
