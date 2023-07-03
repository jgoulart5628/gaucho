<?php
/**
* @name simple_people.php
* Using class.randomdata.php example (make random people list with birthdays)
* @Author Alexander Selifonov, <alex [at] selifan {dot} ru>
* To generate randomized russian people, use parameter "lang" :
* example.php?lang=ru
*
**/
include('../src/class.randomdata.php');
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';
include_once("../src/class.randomdata.lang-$lang.php");

$sex_arr = array('m', 'f');
for($kk=1; $kk<=50; $kk++) {
    $sex = $sex_arr[rand(0,1)];
    $ln = RandomData::getLastName($sex);
    $fn = RandomData::getFirstName($sex);
    $pn = RandomData::getMiddleName($sex);
    $birth = RandomData::getRandomDate(4,50, 'm/d/Y');
    echo "$kk: $ln, $fn $pn, ".decodeSex($sex). ", born: $birth<br>";
}
function decodeSex($sx) {
    return ( ($sx === 'f') ? 'female' : 'male');
}
?>
<hr>
