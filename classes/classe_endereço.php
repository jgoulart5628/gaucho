<?php

   /*
   CREATE TABLE `endereço` (
  `end_id` int(5) NOT NULL,
  `tipo_end` int(2) NOT NULL COMMENT 'Tipo Endereço',
  `logradouro` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Logradouro',
  `numero` int(10) DEFAULT NULL COMMENT 'Nro',
  `complemento` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Complemento',
  `bairro` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Bairro',
  `distrito` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'Distrito',
  `cep` int(8) DEFAULT NULL COMMENT 'CEP',
  `uf` int(2) DEFAULT NULL COMMENT 'UF',
  PRIMARY KEY (`end_id`,`tipo_end`),
  KEY `endereço_FK` (`tipo_end`),
  KEY `endereço_uf_IDX` (`uf`) USING BTREE,

  CREATE TABLE `tipo_ender` (
  `tipo_id` int(3) NOT NULL,
  `descri_tipo` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`tipo_id`)
    */
   error_reporting(E_ALL);

class classe_endereço extends acesso_db
{
    private $tabela = 'endereço';
    private $end_id;
    private $tipo_end;
    private $logradouro;
    private $numero;
    private $bairro;
    private $distrito;
    private $cep;
    private $uf;
    private $tipo_id;
    private $descri_tipo;
    public $db;

    public function __construct($nome)
    {
        $this->db = new acesso_db($nome);
    }

    public function Monta_lista($entidade_id, $resp = '')
    {
        $query = ' select  *  from '.$this->tabela.' where end_id = '.$entidade_id.' order by 1, 2 ';
        $res = $this->db->Executa_Query_Array($query, $resp);

        return $res;
    }

    public function Ler_Registro($end_id = 0, $tipo_end = 0, $tela = '')
    {
        $query = ' select * from '.$this->tabela.' where end_id = '.$end_id.' and tipo_end = '.$tipo_end;
        $res = $this->db->Executa_Query_Single($query, $tela);

        return $res;
    }

    public function Excluir_Registro($end_id, $tipo_end, $tela = '')
    {
        $query = " delete  from '.$this->tabela.'  where end_id = '.$end_id.' and tipo_end = '.$tipo_end.' ";
        $e = $this->db->Executa_Query_SQL($query, $tela);

        return $e;
    }

    public function Alterar_Registro($dados_tela, $dados_tabela, $tela = '')
    {
        $query = 'update endereco set ';
        $end_id = $dados_tela['end_id'];
        $tipo_end = $dados_tela['tipo_end'];
        $logradouro = $dados_tela['logradouro'];
        $numero = $dados_tela['numero'];
        $complemento = $dados_tela['complemento'];
        $bairro = $dados_tela['bairro'];
        $distrito = $dados_tela['distrito'];
        $cidade = $dados_tela['cidade'];
        $cep = $dados_tela['cep'];
        $uf = $dados_tela['uf'];
        $flag = 0;
        if ($logradouro !== $dados_tabela['logradouro']) {
            $query .= " logradouro =  \''.$logradouro.'\' ,";
            ++$flag;
        }
        if ($cep !== $dados_tabela['cep']) {
            $query .= " cep =  '.$cep.' ,";
            ++$flag;
        }
        if ($numero !== $dados_tabela['numero']) {
            $query .= " numero =  '.$numero.' ,";
            ++$flag;
        }
        if ($complemento !== $dados_tabela['complemento']) {
            $query .= " complemento =  \''.$complemento.'\' ,";
            ++$flag;
        }
        if ($bairro !== $dados_tabela['bairro']) {
            $query .= " bairro =  \''.$bairro.'\' ,";
            ++$flag;
        }
        if ($distrito !== $dados_tabela['distrito']) {
            $query .= " distrito =  \''.$distrito.'\' ,";
            ++$flag;
        }
        if ($cidade !== $dados_tabela['cidade']) {
            $query .= " cidade =  \''.$cidade.'\' ,";
            ++$flag;
        }
        if ($uf !== $dados_tabela['uf']) {
            $query .= " uf =  \''.$uf.'\' ,";
            ++$flag;
        }

        if ($flag > 0) {
            $queryx = rtrim($query, ' , ');
            $queryx .= " where end_id = $end_id and tipo_end = $tipo_end ";
            $e = $this->db->Executa_Query_SQL($queryx, $tela);

            return $e;
        }
    }

    public function Incluir_Registro($dados_tela, $tela = '')
    {
        $end_id = $dados_tela['end_id'];
        $tipo_end = $dados_tela['tipo_end'];
        $logradouro = $dados_tela['logradouro'];
        $numero = $dados_tela['numero'];
        $complemento = $dados_tela['complemento'];
        $bairro = $dados_tela['bairro'];
        $distrito = $dados_tela['distrito'];
        $cidade = $dados_tela['cidade'];
        $cep = $dados_tela['cep'];
        $uf = $dados_tela['uf'];
        $query = " insert into endereço values( 
                   $end_id,
                   $tipo_end, 
                   '$logradouro', 
                   $numero, 
                   '$complemento', 
                   '$bairro', 
                   '$distrito', 
                   $cep, 
                   '$uf', '$cidade' )";
        $e = $this->db->Executa_Query_SQL($query, $tela);

        return $e;
    }

    public function Tipo_Endereco($resp = '')
    {
        $query = ' select tipo_id, descri_tipo from tipo_ender ';
        $res = $this->db->Executa_Query_Array($query, $resp);

        return $res;
    }
}
