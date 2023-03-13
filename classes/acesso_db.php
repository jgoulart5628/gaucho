<?php
// error_reporting(E_ALL);
// ini_set('display_errors', true);
// echo '<script type="text/javascript">alert(\'Teste!\'); </script>';

// use banco_dados;

class acesso_db extends banco_dados
{
    protected $IO;
    public $error;
    private $result = array();
    //   public  $cliente;
    //   private $id;
    //   private $tabela;

    public function __construct($in_out)
    {
        $this->IO           = new banco_dados($in_out);
        $vars               = get_object_vars($this->IO);
        $bb                 = explode('_', $in_out);
        $this->banco        = $vars['db'];
        $this->cliente      = $bb[1];
        return $this->error = $vars['erro'];
    }

    private function tableExists($table, $tela = '')
    {
        $query  = 'SHOW TABLES FROM '.$this->banco.' LIKE "'.$table.'" ';
        $tables = $this->IO->banco_query($query, 'sql', $tela);
        if ($tables) {
            if ($tables) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function __toString()
    {
        return $this->IO;
    }

    public function ContaRegs($tabela, $coluna = '', $tela = '')
    {
        $query = " select count(*) conta  from $tabela ";
        if ($coluna) {
            $query .= " where $coluna is not null ";
        }
        return $this->IO->banco_query($query, 'unico', $tela);
    }

    public function Executa_Query_Single($query, $tela = '')
    {
        return $this->IO->banco_query($query, 'single', $tela);
    }

    public function Executa_Query_Unico($query, $tela = '')
    {
        return $this->IO->banco_query($query, 'unico', $tela);
    }

    public function Executa_Query_SQL($query, $tela = '')
    {
        return $this->IO->banco_query($query, 'sql', $tela);
    }

    public function Executa_Query_Array($query, $tela = '')
    {
        return $this->IO->banco_query($query, 'array', $tela);
    }

    public function Executa_Query_Nrows($query, $tela = '')
    {
        return $this->IO->banco_query($query, 'nrows', $tela);
    }

    public function select($table, $rows = '*', $where = null, $order = null, $tela = '')
    {
        $q = ' SELECT '.$rows.' FROM '.$table;
        if ($where != null) {
            $q .= ' WHERE '.$where;
        }
        if ($order != null) {
            $q .= ' ORDER BY '.$order;
        }
        if ($this->tableExists($table, $tela)) {
            return $this->IO->banco_query($q, 'array', $tela);
        } else {
            return 2;
        }
    }

    public function insert($table, $values, $rows = null, $tela = '')
    {
        if ($this->tableExists($table, $tela)) {
            $insert = 'INSERT INTO '.$table;
            if ($rows != null) {
                $insert .= ' ('.$rows.')';
            }
 
            for ($i = 0; $i < count($values); $i++) {
                if (is_string($values[$i])) {
                    $values[$i] = '"'.$values[$i].'"';
                }
            }
            $values = implode(',', $values);
            $insert .= ' VALUES ('.$values.')';
            return $this->IO->banco_query($insert, 'sql', $tela);
        }
    }
    public function delete($table, $where = null, $tela = '')
    {
        if ($this->tableExists($table, $tela)) {
            if ($where == null) {
                $delete = 'DELETE '.$table;
            } else {
                $delete = 'DELETE FROM '.$table.' WHERE '.$where;
            }
            return $this->IO->banco_query($delete, 'sql', $tela);
        }
    }


    public function update($table, $rows, $where, $tela = '')
    {
        if ($this->tableExists($table, $tela)) {
            // Parse the where values
            // even values (including 0) contain the where rows
            // odd values contain the clauses for the row
            for ($i = 0; $i < count($where); $i++) {
                if ($i%2 != 0) {
                    if (is_string($where[$i])) {
                        if (($i+1) != null) {
                            $where[$i] = '"'.$where[$i].'" AND ';
                        } else {
                            $where[$i] = '"'.$where[$i].'"';
                        }
                    }
                }
            }
            $where = implode('=', $where);
            $update = 'UPDATE '.$table.' SET ';
            $keys = array_keys($rows);
            for ($i = 0; $i < count($rows); $i++) {
                if (is_string($rows[$keys[$i]])) {
                    $update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
                } else {
                    $update .= $keys[$i].'='.$rows[$keys[$i]];
                }
                 
                // Parse to add commas
                if ($i != count($rows)-1) {
                    $update .= ',';
                }
            }
            $update .= ' WHERE '.$where;
            return $this->IO->banco_query($update, 'sql', $tela);
        }
    }

    public function busca_json($json)
    {
        $url = '../tabsjson/'.$json;
        return  json_decode(file_get_contents($url), true);
    }

    
    public function busca_obrigatorios($tabela, $resp = '')
    {
        $query = " select coluna  from adm_colunas where tabela = '$tabela' and  definido is NULL ";
        $resul  = $this->Executa_Query_Array($query, $resp);
        return $resul;
    }
    
 

    public function combo_geral($taborigem, $coluna, $param = '', $resp = '', $oper = '')
    {
        $query  = "select valida, filtro from adm_colunas where tabela = '$taborigem' and coluna = '$coluna' ";
        $resul  = $this->Executa_Query_Single($query, $resp);
        $valida = $resul['valida'];
        $filtro = $resul['filtro'];
        if (substr($coluna, 0, 1) ==  'x') {
            $class = 'class="form-control is-valid"';
            if ($oper == 'A') {
                $rd ="disabled";
            } else {
                $rd='';
            }
        } else {
            $class = 'class="form-control"';
        }
        
        $sel = '';
        $ret = '<select '.$class.' name="'.$coluna.'" id="'.$coluna.'" '.$rd.'> <option value =""></option> ';
        if (strtolower(substr($valida, 0, 6)) !== 'tabela') {
            $lista  = explode('|', $valida);
            foreach ($lista as $res) {
                if (trim($res) == trim($param)) {
                    $sel = ' selected ';
                } else {
                            $sel = '';
                }
                $ret .= '<option value="'.$res.'" '.$sel.' class="form-control"> '.$res.' </option> ';
            }
        }
        if (strtolower(substr($valida, 0, 6)) == 'tabela') {
            $ind = 2;
            $tab      = explode(' ', $valida);
            $tabelax  = trim($tab[1]);
            if (substr($tabelax, 0, 4) == 'json') {
                $res = $this->busca_json($tabelax.'.json');
                foreach ($res as $cod => $var) {
                    if ($cod > 0) {
                        if ($cod == $param) {
                            $sel = ' selected ';
                        } else {
                                        $sel = '';
                        }
                        $ret .= '<option value="'.$cod.'" '.$sel.' class="form-control"> '.$cod.' - '.$var.' </option> ';
                    }
                }
            } else {
                /*
                if ($param) {
                    $where = " where  xcodigo = '".$param."'";
                    if($filtro) { $where .= " and ".$filtro; }
                } else {
                    $where = '';
                    if($filtro) { $where = " where ".$filtro; }
                }
                */
                $where = '';
                if ($filtro) {
                    $where = " where ".$filtro;
                }
                $order = " order by 2 ";
                $ind = 1;
                if (($tabelax == 'pessoa_41010') || ($tabelax == 'produto_42010')) {
                    $order = " order by 3 ";
                    $ind = 3;
                }
                $query = "select * from $tabelax  ".$where.$order;
                //         $ret .= '<option>'.$query.'</option>';
                $res = $this->Executa_Query_Array($query, $resp);
                if (count($res) > 0) {
                    for ($i=0; $i < count($res); $i++) {
                        $dad = array_values($res[$i]);
                        $xcodigo     = $dad[0];
                        $descri      = $dad[$ind];
                        if ($xcodigo == $param) {
                            $sel = ' selected ';
                        } else {
                            $sel = '';
                        }
                        $ret .= '<option value="'.$xcodigo.'" '.$sel.' class="form-control"> '.$xcodigo.' - '.$descri.'</option> ';
                    }
                } else {
                    $ret .= '<option value="'.$query.'" classs="form-control">'.$query.'</option> ';
                }
            }
        }
        $ret .= '</select> ';
        return $ret;
    }

    // fecha a classe
}
