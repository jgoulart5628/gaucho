<?php

   /*
CREATE TABLE `pessoas` (
  `pessoa_id` int(5) NOT NULL COMMENT 'Chave Primária',
  `nome` varchar(50) DEFAULT NULL COMMENT 'Nome Completo',
  `data_nascimento` date DEFAULT NULL COMMENT 'Data Nascimento',
  `sexo` enum('F','M') DEFAULT NULL COMMENT 'Sexo',
  `entidade` int(5) DEFAULT NULL COMMENT 'Entidade a que Pertence',
  `docto_mtg` varchar(30) DEFAULT NULL COMMENT 'Documento  MTG',
  `validade_docto_mtg` date DEFAULT NULL,
  `cpf` int(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `id_altera` int(5) DEFAULT NULL,
  `data_altera` datetime DEFAULT NULL,
  PRIMARY KEY (`pessoa_id`),
    */
   error_reporting(E_ALL);

class classe_pessoa extends acesso_db
{
    private $tabela = 'pessoas';
    private $key = 'pessoa_id';
    private $pessoa_id;
    private $nome;
    private $data_nascimento;
    private $sexo;
    private $entidade;
    private $docto_mtg;
    private $validade_docto_mtg;
    private $cpf;
    private $email;
    private $id_altera;
    private $data_altera;
    public $db;

    public function __construct($nome)
    {
        $this->db = new acesso_db($nome);
    }

    public function Monta_lista($resp = '')
    {
        $query = ' select *  from '.$this->tabela.' order by 1 ';
        $res = $this->db->Executa_Query_Array($query, $resp);

        return $res;
    }

    public function Ler_Registro($id, $tela = '')
    {
        $query = ' select * from '.$this->tabela.' where '.$this->key." = $id ";
        $res = $this->db->Executa_Query_Single($query, $tela);

        return $res;
    }

    public function Busca_Entidade($entidade, $resp)
    {
        $query = " select nome_entidade from entidade where entidade_id = $entidade ";
        $res = $this->db->Executa_Query_Unico($query, $resp);

        return $res;
    }

    public function Monta_lista_Entidades($entidade, $resp = '')
    {
        $query = " select entidade_id, nome_entidade,  case when entidade_id = $entidade then 'SELECTED' else ' ' end sel from entidade 
        order by nome_entidade";
        $res = $this->db->Executa_Query_Array($query, $resp);

        return $res;
    }

    public function Busca_Proximo_ID($tela = '')
    {
        $query = ' select nvl(max('.$this->key.' + 1),1) as id from '.$this->tabela;
        $res = $this->db->Executa_Query_Unico($query, $tela);

        return $res;
    }

    public function Excluir_Registro($id, $tela = '')
    {
        $query = ' delete  from '.$this->tabela.' where '.$this->key." = $id  ";
        $e = $this->db->Executa_Query_SQL($query, $tela);

        return $e;
    }

    public function Alterar_Registro($dados_tela, $tela = '')
    {
        /*
        `pessoa_id` `nome` `data_nascimento` `sexo` `entidade`
        `docto_mtg` `validade_docto_mtg`  `cpf`  `email`  `id_altera` `data_altera`
        */
        $pessoa_id = $dados_tela['pessoa_id'];
        $query = 'update pessoas set ';
        $dados_tabela = $this->Ler_Registro($pessoa_id, $tela);
        $nome = $dados_tela['nome'];
        $data_nascimento = $dados_tela['data_nascimento'];
        $sexo = $dados_tela['sexo'];
        $entidade = $dados_tela['entidade'];
        $docto_mtg = $dados_tela['docto_mtg'];
        $validade_docto_mtg = $dados_tela['validade_docto_mtg'];
        if (!$validade_docto_mtg) {
            $validade_docto_mtg = '0000-00-00';
        }
        $cpf = limpaCPF($dados_tela['cpf']);
        $email = $dados_tela['email'];
        $id_altera = $dados_tela['id_altera'];
        $flag = 0;
        if ($nome !== $dados_tabela['nome']) {
            $query .= " nome =  '$nome' ,";
            ++$flag;
        }
        if ($data_nascimento !== $dados_tabela['data_nascimento']) {
            $query .= " data_nascimento =  '.$data_nascimento.' ,";
            ++$flag;
        }
        if ($sexo !== $dados_tabela['sexo']) {
            $query .= " sexo =  '$sexo' ,";
            ++$flag;
        }
        if ($entidade !== $dados_tabela['entidade']) {
            $query .= " entidade =  $entidade ,";
            ++$flag;
        }
        if ($docto_mtg !== $dados_tabela['docto_mtg']) {
            $query .= " docto_mtg =  '$docto_mtg' ,";
            ++$flag;
        }
        if ($validade_docto_mtg !== $dados_tabela['validade_docto_mtg']) {
            $query .= " validade_docto_mtg =  '$validade_docto_mtg' ,";
            ++$flag;
        }
        if ($cpf !== $dados_tabela['cpf']) {
            $query .= " cpf =  $cpf ,";
            ++$flag;
        }
        if ($email !== $dados_tabela['email']) {
            $query .= " email =  '$email' ,";
            ++$flag;
        }
        $query .= " id_altera = $id_altera, data_altera = CURRENT_TIMESTAMP ";
        if ($flag > 0) {
            $queryx = rtrim($query, ' , ');
            $queryx .= " where pessoa_id = $pessoa_id ";
            $e = $this->db->Executa_Query_SQL($queryx, $tela);
        }

        return $e;
    }

    public function Incluir_Registro($dados, $tela = '')
    {
        /*
        `pessoa_id` `nome` `data_nascimento` `sexo` `entidade`
        `docto_mtg` `validade_docto_mtg`  `cpf`  `email`  `id_altera` `data_altera`
        */
        $pessoa_id = $dados['pessoa_id'];
        $nome = $dados['nome'];
        $data_nascimento = $dados['data_nascimento'];
        $sexo = $dados['sexo'];
        $entidade = $dados['entidade'];
        $docto_mtg = $dados['docto_mtg'];
        $validade_docto_mtg = $dados['validade_docto_mtg'];
        if (!$validade_docto_mtg) {
            $validade_docto_mtg = '0000-00-00';
        }
        $cpf = limpaCPF($dados['cpf']);
        if (!$cpf) {
            $cpf = 0;
        }
        $email = $dados['email'];
        $id_altera = $dados['id_altera'];
        $query = " insert into pessoas values( 
                   $pessoa_id,
                   '$nome', 
                   '$data_nascimento', 
                   '$sexo', 
                   $entidade, 
                   '$docto_mtg', 
                   '$validade_docto_mtg', 
                   $cpf,
                   '$email', 
                   $id_altera, 
                   CURRENT_TIMESTAMP )";
        $e = $this->db->Executa_Query_SQL($query, $tela);

        return $e;
    }
}
