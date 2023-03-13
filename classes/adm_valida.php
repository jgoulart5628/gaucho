<?php
//   use acesso_db;
   error_reporting(E_ALL);

class adm_valida extends acesso_db
{
    private $tab_val  = 'adm_valida';
    private $tab_tab  = 'adm_tabelas';
    private $tab_col  = 'adm_colunas';
    public $tabela;
    public $coluna;
    public $valida;
    public $db;
    private $nome;

    public function __construct($nome)
    {
        $this->db  = new acesso_db($nome);
    }

    public function Monta_lista($resp = '')
    {
        $query = " select tabela, titulo  from adm_tabelas  where titulo !=  'VIEW' order by 1 ";
        $res    = $this->db->Executa_Query_Array($query, $resp);
        return $res;
    }

    public function Monta_Colunas($tabela, $resp = '')
    {
        $query = " select ordem, coluna, label, tipo, definido, valida, filtro  from adm_colunas  where tabela =  '$tabela' order by 1 ";
        $res    = $this->db->Executa_Query_Array($query, $resp);
        return $res;
    }

    public function Busca_Dados_Coluna($tabela, $coluna, $resp = '')
    {
        $query = " select ordem, label, tipo, definido, valida, filtro  from adm_colunas "
             . "   where tabela =  '$tabela' and coluna = '$coluna' order by 1 ";
        $res    = $this->db->Executa_Query_Single($query, $resp);
        return $res;
    }
     
    public function Ler_Registro($id, $tela = '')
    {
        $query = " select id, estab from ".$this->tabela." where id = ".$id ;
        $res    = $this->db->Executa_Query_Single($query, $tela);
        return $res;
    }

    public function Ler_Nome($id, $tela = '')
    {
        $query = " select nomepessoa from pessoa_41010 x where x.xcodigo = (select estab from adm_empresa where id = $id)";
        $res    = $this->db->Executa_Query_Unico($query, $tela);
        return $res;
    }

    public function Excluir_Registro($id, $tela = '')
    {
        $query = " delete  from adm_empresa where id = $id ";
        $e = $this->db->Executa_Query_SQL($query, $tela);
        return $e;
    }

    public function Alterar_Registro($dados, $tela = '')
    {
        $id         = $dados['id'];
        $cod_emp    = $dados['estab'];
        $res = $this->Ler_Registro($id, $tela);
        if ($cod_emp !== $res['estab']) {
            $e = $this->db->Executa_Query_SQL(" update adm_empresa set estab = $cod_emp where id = $id ", $tela);
            return $e;
        }
    }

    public function Incluir_Registro($dados, $tela = '')
    {
        $cod_emp    = $dados['estab'];
        $e = $this->db->Executa_Query_SQL(" insert into adm_empresa values(null, $cod_emp) ", $tela);
        return $e;
    }

    public function Busca_Combo($taborigem, $coluna, $param, $tela = '')
    {
        return $this->db->combo_geral($taborigem, $coluna, $param, $tela);
    }

    public function Altera_Comment($query, $tela = '')
    {
        $e = $this->db->Executa_Query_SQL($query, $tela);
        return $e;
    }
    public function Busca_DDL($query, $tela = '')
    {
        $res = $this->db->Executa_Query_Array($query, $tela);
        $sql = $res[0]['altera'];
        $e = $this->db->Executa_Query_SQL($sql, $tela);
        return $e;
    }
    public function Leitura_Valida($query, $tela = '')
    {
        $res = $this->db->Executa_Query_Unico($query, $tela);
        return $res;
    }
    public function Atualiza_Valida($query, $tela = '')
    {
        $e = $this->db->Executa_Query_SQL($query, $tela);
        return $e;
    }   
}

