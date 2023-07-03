<?php
include_once('src/RandomData.php');
include_once('src/class.randomdata.lang-br.php'); 
require_once('../classes/banco_Dados.php');
$db = new banco_Dados('MYSQL_gaucho');
//$sex_arr = array('M', 'F');

//$gender = $sex_arr[rand(0,1)];

//$ln = RandomData::getLastName($gender); // get random last name
//$fn = RandomData::getFirstName($gender); // get random first name
//$pn = RandomData::getMiddleName($gender); // and patronimnic/middle name
//$birth = RandomData::getRandomDate(12,60, 'Y-m-d'); // random birth date for 4 - 50 years old, 'YYYY-MM-DD'
// echo "$ln, $fn $pn, ". ($gender==='F'?'Mulher':'Homem') . ", Nascimento: $birth<br>";
$x = 0;
$options = array('birthdate'=>array(12,65));
while ($x < 101) {
   $pessoa = RandomData::getPerson($options);
   $ret = Incluir_Registro($pessoa);
//   $birth = RandomData::getRandomDate(12,60, 'Y-m-d');
//   $birth = $pessoa['birthdate'];
//   $nome  = $pessoa['firstname'].' '.$pessoa['lastname'];
//   $sexo  = strtoupper($pessoa['gender']);
   echo($ret.'<br>');
   $x++;
}

function busca_entidade()  {
  global $db; 
  $query = " select entidade_id from entidade order by rand() limit 1 "; 
  $res = $db->Executa_Query_Unico($query, '');
  return $res;
}  


function Incluir_Registro($pessoa)
{
    global $db; 
    /*
    `pessoa_id` `nome` `data_nascimento` `sexo` `entidade`
    `docto_mtg` `validade_docto_mtg`  `cpf`  `email`  `id_altera` `data_altera`
    */
    // $pessoa_id = $dados['pessoa_id'];
    $nome  = $pessoa['firstname'].' '.$pessoa['lastname'];
    $data_nascimento =  $pessoa['birthdate'];
    $sexo = strtoupper($pessoa['gender']);
    $entidade = busca_entidade();
    $cpf = 0;
    $id_altera = 1;
    $pessoa_id = $db->Executa_Query_Unico(" select (max(pessoa_id) + 1) id from pessoas ", '');
//    ('nome', 'data_nascimento','sexo', 'entidade', 'docto_mtg', 'validade_docto_mtg'. 'cpf', 'email','id_altera'. 'data_altera')
    $query = " insert into pessoas
               (pessoa_id, nome, data_nascimento, sexo, entidade, docto_mtg, validade_docto_mtg, cpf, email,id_altera, data_altera)
               values( 
                $pessoa_id,  
               '$nome', 
               '$data_nascimento', 
               '$sexo', 
               $entidade, 
               NULL, 
               NULL, 
               0,
               NULL, 
               1, 
               CURRENT_TIMESTAMP )";
    $e = $db->Executa_Query_SQL($query, '');
    return $e;
}
