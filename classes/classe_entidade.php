<?php

   /*
   CREATE TABLE `entidade` (
    `entidade_id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Chave primária',
    `sigla` varchar(3) DEFAULT NULL COMMENT 'Sigla da Entidade.',
    `nome_entidade` varchar(100) NOT NULL COMMENT 'Nome Entidade',
    `cnpj` decimal(14,0) DEFAULT NULL COMMENT 'CNPJ',
    `resp1` varchar(100) NOT NULL COMMENT 'Nome Primeiro Responsável',
    `email_resp1` varchar(50) DEFAULT NULL COMMENT 'Email do Primeiro responsável',
    `telefone_resp1` varchar(50) DEFAULT NULL COMMENT 'Telefone do Primeiro responsável',
    `resp2` varchar(100) DEFAULT NULL COMMENT 'Nome Segundo Responsável',
    `email_resp2` varchar(50) DEFAULT NULL COMMENT 'Email do Segundo responsável',
    `telefone_resp2` varchar(50) DEFAULT NULL COMMENT 'Telefone do Segundo responsável',
    `data_funda` date DEFAULT NULL COMMENT 'Data de Fundação da Entidade',
    `RT` varchar(3) DEFAULT NULL COMMENT 'Região Tradicionalista',
    `matricula` int(5) DEFAULT NULL COMMENT 'Matricula MTG',
    PRIMARY KEY (`entidade_id`);
    */
   error_reporting(E_ALL);

class classe_entidade extends banco_Dados
{
    private $tabela = 'entidade';
    private $entidade_id;
    private $sigla;
    private $nome_entidade;
    private $cnpj;
    private $resp1;
    private $email_resp1;
    private $telefone_resp1;
    private $resp2;
    private $email_resp2;
    private $telefone_resp2;
    private $data_funda;
    private $RT;
    private $matricula;
    public $db;

    public function __construct($nome)
    {
        $this->db = new banco_Dados($nome);
    }

    public function Monta_lista($resp = '')
    {
        $query = ' select *  from '.$this->tabela.' order by nome_entidade ';
        $res = $this->db->Executa_Query_Array($query, $resp);

        return $res;
    }

    public function Ler_Registro($id, $tela = '')
    {
        $query = ' select * from '.$this->tabela.' where entidade_id = '.$id;
        $res = $this->db->Executa_Query_Single($query, $tela);

        return $res;
    }

    public function Busca_Proximo_ID($tela = '')
    {
        $query = ' select (max(entidade_id) + 1) as num  from entidade ';
        $res = $this->db->Executa_Query_Unico($query, $tela);

        return $res;
    }

    public function Excluir_Registro($id, $tela = '')
    {
        $query = " delete  from entidade where entidade_id = $id ";
        $e = $this->db->Executa_Query_SQL($query, $tela);

        return $e;
    }

    public function Alterar_Registro($dados_tela, $tela = '')
    {
        $entidade_id = $dados_tela['entidade_id'];
        $query = 'update entidade set ';
        $dados_tabela = $this->Ler_Registro($entidade_id, $tela);
        $sigla = $dados_tela['sigla'];
        $nome_entidade = $dados_tela['nome_entidade'];
        $cnpj = limpaCPF_CNPJ($dados_tela['cnpj']);
        $resp1 = $dados_tela['resp1'];
        $email_resp1 = $dados_tela['email_resp1'];
        $telefone_resp1 = $dados_tela['telefone_resp1'];
        $resp2 = $dados_tela['resp2'];
        $email_resp2 = $dados_tela['email_resp2'];
        $telefone_resp2 = $dados_tela['telefone_resp2'];
        $data_funda = $dados_tela['data_funda'];
        $RT = $dados_tela['RT'];
        $matricula = $dados_tela['matricula'];
        $flag = 0;
        if ($sigla !== $dados_tabela['sigla']) {
            $query .= " sigla =  '$sigla' ,";
            ++$flag;
        }
        if ($nome_entidade !== $dados_tabela['nome_entidade']) {
            $query .= " nome_entidade =  '$nome_entidade' ,";
            ++$flag;
        }
        if ($cnpj !== $dados_tabela['cnpj']) {
            $query .= " cnpj =  '.$cnpj.' ,";
            ++$flag;
        }
        if ($resp1 !== $dados_tabela['resp1']) {
            $query .= " resp1 =  '$resp1' ,";
            ++$flag;
        }
        if ($email_resp1 !== $dados_tabela['email_resp1']) {
            $query .= " email_resp1 =  '$email_resp1' ,";
            ++$flag;
        }
        if ($telefone_resp1 !== $dados_tabela['telefone_resp1']) {
            $query .= " telefone_resp1 =  '$telefone_resp1' ,";
            ++$flag;
        }
        if ($resp2 !== $dados_tabela['resp2']) {
            $query .= " resp2 =  '$resp2' ,";
            ++$flag;
        }
        if ($email_resp2 !== $dados_tabela['email_resp2']) {
            $query .= " email_resp2 =  '$email_resp2' ,";
            ++$flag;
        }
        if ($telefone_resp2 !== $dados_tabela['telefone_resp2']) {
            $query .= " telefone_resp2 =  '$telefone_resp2' ,";
            ++$flag;
        }
        if ($data_funda !== $dados_tabela['data_funda']) {
            $query .= " data_funda =  '$data_funda' ,";
            ++$flag;
        }
        if ($RT !== $dados_tabela['RT']) {
            $query .= " RT =  '$rt' ,";
            ++$flag;
        }
        if ($matricula !== $dados_tabela['matricula']) {
            $query .= " matricula =  $matricula ,";
            ++$flag;
        }
        if ($flag > 0) {
            $queryx = rtrim($query, ' , ');
            $queryx .= " where entidade_id = $entidade_id ";
            $e = $this->db->Executa_Query_SQL($queryx, $tela);
        }
        $res = $this->Tipo_Invernada($tela);
        $e = $this->Limpa_Invernadas($entidade_id, $tela);
        for ($i = 0; $i < count($res); ++$i) {
            $inver_tela = $dados_tela['invern'.$i];
            if ($inver_tela) {
                $query_inver = " insert into invernadas values( $entidade_id, $inver_tela )";
                $e = $this->db->Executa_Query_SQL($query_inver, $tela);
            }
        }

        return $e;
    }

    public function Incluir_Registro($dados, $tela = '')
    {
        $entidade_id = $dados['entidade_id'];
        $sigla = $dados['sigla'];
        $nome_entidade = $dados['nome_entidade'];
        if (!$dados['cnpj']) {
            $cnpj = 0;
        } else {
            $cnpj = limpaCPF_CNPJ($dados['cnpj']);
        }
        $resp1 = $dados['resp1'];
        $resp2 = $dados['resp2'];
        $email_resp1 = $dados['email_resp1'];
        $email_resp2 = $dados['email_resp2'];
        $telefone_resp1 = $dados['telefone_resp1'];
        $telefone_resp2 = $dados['telefone_resp2'];
        $data_funda = $dados['data_funda'];
        $RT = $dados['RT'];
        $matricula = $dados['matricula'];
        $query = " insert into entidade values( 
                   '$sigla',
                   $entidade_id,
                   '$nome_entidade', 
                   $cnpj, 
                   '$resp1', 
                   '$email_resp1', 
                   '$telefone_resp1', 
                   '$resp2', 
                   '$email_resp2', 
                   '$telefone_resp2',
                   '$data_funda',
                   '$RT',
                   $matricula   )";
        $e = $this->db->Executa_Query_SQL($query, $tela);
        $res = $this->Tipo_Invernada($tela);
        for ($i = 0; $i < count($res); ++$i) {
            $inver = $dados['invern'.$i];
            if ($inver) {
                $query_inver = " insert into invernadas values( $entidade_id, $inver )";
                $e = $this->db->Executa_Query_SQL($query_inver, $tela);
            }
        }

        return $e;
    }

    public function Busca_Invernadas($id = 0, $resp = '')
    {
        $query = " select entidade_id, tipo_invernada from invernadas where entidade_id = $id ";
        $res = $this->db->Executa_Query_Array($query, $resp);

        return $res;
    }

    public function Tipo_Invernada($resp = '')
    {
        $query = ' select tipo, titulo from tipo_invernada ';
        $res = $this->db->Executa_Query_Array($query, $resp);

        return $res;
    }

    public function Limpa_Invernadas($id, $resp = '')
    {
        $query = " delete from invernadas where entidade_id = $id ";
        $e = $this->db->Executa_Query_Array($query, $resp);

        return $e;
    }
}
