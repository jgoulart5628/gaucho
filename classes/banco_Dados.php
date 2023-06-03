<?php
/*  Classe Geral para acesso ao Banco de dados, com query  e tratamento de erro
 *  DBMS tratdos: Oracle, Mysql, Postgresql, Firebird, SQLserver
 *  Necessita db sqlite para definir o banco: pasta admin/config/parametro.sqlite
 *  programa para manutenção: /admin/empresa_banco.php
    CREATE TABLE "ERRO_SQL"
        ("key" INTEGER PRIMARY KEY  AUTOINCREMENT  NOT NULL ,
         "data" DATETIME,
         "erro" INTEGER,
         "msg" VARCHAR,
         "sql" VARCHAR);
    /**
    * @classe    banco_dados
    * @descr     Classe de acesso ao banco de dados via PDO
    * @autor     Joao Goulart
    * @email     goulart.joao@gmail.com
    * @data      Agosto/2014
    * @copyright (c) 2014 by Joao Goulart
 */
   ini_set('display_errors', true);
   ini_set('date.timezone', 'America/Sao_Paulo');
class banco_Dados
{
       //parâmetros de conexão
       public $cfg;
       public $db;
       public $dbhost;
       public $dbuser;
       public $dbpasswd;
         
       //handle da conexão
       public $conn;

       //variaveos ODBC
       public $dsn;
       public $driver;
       public $log_erros;
       public $log_trans;
       public $uid;
       public $pwd;
       //resultado das Queries
       public $sql;
       public $arr;
       public $banco;
       public $cliente;
       public $tipo;
       public $options;
       public $erro;
       public $info;
    // construtor da classe
    public function __construct($banco)
    {
        $bb = explode('_', $banco);
        $this->tipo    = $bb[0];
        $this->cliente = $bb[1];
        if (count($bb) > 2) {
            $this->cliente = $bb[1].'_'.$bb[2];
        }
        $this->cfg = $this->busca_param($this->tipo, $this->cliente);
        if (is_array($this->cfg)) {
           $this->dsn        = trim($this->cfg['dsn']);
           $this->dbhost     = trim($this->cfg['host']);
           $this->dbpasswd   = trim($this->cfg['pwd']);
           $this->dbuser     = trim($this->cfg['user']);
           $this->db         = trim($this->cfg['dbname']);
           $this->driver     = trim($this->cfg['driver']);
           $this->log_erros  = trim($this->cfg['log_erros']);
           $this->log_trans  = trim($this->cfg['log_trans']);
        }

        $this->options = array(PDO::NULL_NATURAL => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => true);
        try {
            switch ($this->tipo) {
                case 'ORACLE':
                    $tns = " (DESCRIPTION =(ADDRESS_LIST =(ADDRESS = (PROTOCOL = TCP) (HOST = ".$this->dbhost.")(PORT = 1521)))(CONNECT_DATA = (SID = ".$this->db.")))";
//                    $dns = "oci:dbname=$this->dbhost";
//                    $this->conn = new PDO("oci:dbname=$this->db", $this->dbuser, $this->dbpasswd, $this->options);
                    $this->conn = new PDO("oci:dbname=".$tns, $this->dbuser, $this->dbpasswd, $this->options);
                    break;
                case 'ODBC':
                case 'SQLSERVER':
                    //            $dns = "odbc:Driver=".$this->driver.";Dsn=".$this->dsn.";uid=".$this->dbuser.";PWD=".$this->dbpasswd;
                    $dns = "odbc:Dsn=".$this->dsn.";uid=".$this->dbuser.";PWD=".$this->dbpasswd;
                    $this->conn = new PDO($dns);
                    break;
                case 'SYBASE':
                    //             $dns = "odbc:Driver=".$this->driver.";Dsn=".$this->dsn.";uid=".$this->dbuser.";PWD=".$this->dbpasswd;
                    //             $dns = "odbc:Dsn=".$this->dsn.";uid=".$this->dbuser.";PWD=".$this->dbpasswd;
                    //             $dns = "dblib:host=FOSCA;dbname=FOSCA";
                    //               $this->conn = new PDO("sqlanywhere:host=casa;dbname=Fosca; uid=dba; pwd=sql");
                     $this->conn = new PDO("sqlanywhere:Dsn=Foscarini; uid=dba; pwd=sql ");
                    //             $this->conn = new PDO($dns);
                    break;
                case 'POSTGRESQL':
                    //             $this->conn = new PDO("pgsql:host=nuc-04;port=5432;dbname=familia;user=joao;password=jogola01", $this->options);
                    $this->conn = new PDO("pgsql:host=$this->dbhost;port=5432;dbname=$this->db;user=$this->dbuser;password=$this->dbpasswd");
                    break;
                case 'MYSQL':
                    $this->options =  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
                    $this->conn = new PDO("mysql:host=$this->dbhost;dbname=$this->db", $this->dbuser, $this->dbpasswd, $this->options);
                    break;
                case 'FIREBIRD':
                    $dns = "firebird:dbname=$this->db";
                    $this->conn = new PDO("firebird:dbname=$this->db; charset=ISO8859_1;", $this->dbuser, $this->dbpasswd);
                    // charset=ISO8859_1
                    break;
                case 'SQLITE':
                    $this->conn = new PDO("sqlite:".$this->db);
                    break;
                default:
                     break;
            }
        } catch (Exception $e) {
            $er = $e->getMessage();
            $info = $e->getTrace();
            die($this->erro_sql($er, $banco.'-'.$this->dbhost.'-'.$this->db, $info));
        }
    }
  
    public function busca_param($tp, $cli)
    {
        $cc = $_SERVER['DOCUMENT_ROOT'] . '/gaucho/admin/config/parametro.sqlite';
        if (file_exists($cc)) {
            $lite =  new PDO('sqlite:'.$cc);
            $sq   = " select dsn, host, dbname, user, pwd, driver, log_erros, log_trans from empresa_banco where id = '$cli' and dbms = '$tp' ";
            $sqx = $lite->query($sq);
            $res = $sqx->fetch(PDO::FETCH_ASSOC);
            if ($res)   { return $res; }
            else { return $this->erro_sql('Conexão '.$cli.' não existe, verifique (empresa_banco)!', '', ''); }
        } else {
            return $this->erro_sql('Arquivo Parametro.sqlite não encontrado', '', '');
        }
    }


    public function banco_query($query, $mode = 'sql', $tela = '')
    {
        if (is_object($this->conn)) {
            //      PDOException/ Throwable
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);
            try {
                $this->sql = $this->conn->query($query);
                //          $this->sql->execute();
            } catch (PDOException  $e) {
                $msg  = $e->getMessage();
                $info = $e->getCode();
                return $this->erro_sql($msg, $query, $info, $tela);
            }
            switch ($mode) {
                case "sql":
                    if ($this->log_trans) {
                        $this->Grava_Trans($query);
                    }
                    return 1;
                case "array":
                     $arr  = $this->sql->fetchAll(PDO::FETCH_ASSOC);
                    break;
            //          case "array"   :  $arr  = $sql->fetchAll();  break;
                case "single":
                    $arr  = $this->sql->fetch(PDO::FETCH_ASSOC);
                    break;
                case "nrows":
                      $arr  = $this->sql->rowCount();
                    break;
                case "unico":
                      $arr  = $this->sql->fetchColumn();
                    break;
                default:
                    break;
            }
            $this->arr = $arr;
            return $this->arr;
        } else {
            return $this->erro_sql('A Conexão falhou, verifique!', '', '');
        }
    }
    public function ContaRegs($tabela, $coluna = '', $tela = '')
    {
        $query = " select count(*) conta  from $tabela ";
        if ($coluna) {
            $query .= " where $coluna is not null ";
        }
        return $this->banco_query($query, 'unico', $tela);
    }

    public function Executa_Query_BLOB($query, $column1, $arquivo, $tela = '')
    {
        return $this->banco_query_blob($query, $column1, $arquivo, $tela = '');
    }

    public function Executa_Query_Single($query, $tela = '')
    {
        return $this->banco_query($query, 'single', $tela);
    }

    public function Executa_Query_Unico($query, $tela = '')
    {
        return $this->banco_query($query, 'unico', $tela);
    }

    public function Executa_Query_SQL($query, $tela = '')
    {
        return $this->banco_query($query, 'sql', $tela);
    }

    public function Executa_Query_Array($query, $tela = '')
    {
        return $this->banco_query($query, 'array', $tela);
    }

    public function Executa_Query_Nrows($query, $tela = '')
    {
        return $this->banco_query($query, 'nrows', $tela);
    }


    public function Grava_Trans($sql)
    {
        $timestamp = time();
        $hora = date("G:i:s", $timestamp);
        $data = date("Ymd", $timestamp);
        $arq = '../log_trans/log_'.$data.'.txt';
        error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
        $fs = (file_exists($arq)) ? @fopen($arq, 'a') : @fopen($arq, 'w+');
        //parametros do erro
        $ori   = $_SERVER["HTTP_REFERER"];
        //    $brw   = $_SERVER["HTTP_USER_AGENT"];
        $ip    = $_SERVER["REMOTE_ADDR"];
        // montando o texto
        $txt    = $hora.'|'.$ori.'|'.$ip.'|'.$sql.PHP_EOL;
        @fwrite($fs, $txt);
        @fclose($fs);
    }


    public function banco_query_blob($query, $column1, $arquivo, $tela = '')
    {
        if (is_object($this->conn)) {
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);
            $blob = fopen($arquivo, 'rb');
            try {
                $this->sql = $this->conn->prepare($query);
                $this->sql->bindValue($column1, $blob, PDO::PARAM_LOB);
                $this->sql->execute();
            } catch (PDOException $e) {
                $msg = $e->getMessage();
                $info = $e->getCode();
                return $this->erro_sql($msg, $query, $info, $tela);
            }
            return 1;
        }
    }

    public function erro_sql($msg, $query, $info, $tela = '')
    {
        if ($this->log_erros) {
            $this->Grava_Erro_SQL($msg, $query);
        }
        $msgx = urlencode($msg);
        $sql  = urlencode($query);
        if ($_SERVER['SCRIPT_NAME'] == '/gaucho/index.php') {
            $arq = '/gaucho/admin/erro.php'; } else {
         $arq = '../admin/erro.php'; }
        if (is_object($tela)) {
            $tela->script(
                ' var myWin  = window.open("'.$arq.'?tipo=Erro de SQL.&msg='.$msgx.'&sql='.$sql.'", "Erro.", "status = 1, height = 400, width = 500, resizable = 0, scrollbars=1" ); '
            );
            return $tela;
        } else {
            echo  '<script>
               var myWin  = window.open("'.$arq.'?tipo=Erro de SQL.&msg='.$msgx.'&sql='.$sql.'", "Erro.", "status = 1, height = 400, width = 500, resizable = 0, scrollbars=1" );
                </script>';
        }
//        return  $info;
        exit;
    }

    public function Grava_Erro_SQL($msg, $sql)
    {
//        global $programa;
//        $prog = explode('.', $programa);
        $timestamp = time();
        $hora = date("G:i:s", $timestamp);
        $data = date("Ymd", $timestamp);
        $arq =  '../log_erros/erro_'.$data.'.txt';
        ini_set('default_charset', 'iso-8859-1');
        error_reporting(E_ALL & ~(E_NOTICE | E_DEPRECATED | E_STRICT | E_WARNING));
        if (file_exists($arq)) {
            $fs = @fopen($arq, 'a');
        } else {
            $fs = @fopen($arq, 'w+');
        }
        //parametros do erro
        $ori   = $_SERVER["HTTP_REFERER"];
        //    $brw   = $_SERVER["HTTP_USER_AGENT"];
        $ip    = $_SERVER["REMOTE_ADDR"];
        // montando o texto
        $txt    = $hora.'|'.$ori.'|'.$ip.'|'.$msg.'|'.$sql.PHP_EOL;
        @fwrite($fs, $txt);
        @fclose($fs);
    }
}
