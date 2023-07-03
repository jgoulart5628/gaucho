<?php
/**
* @name employees.php
* Using class.randomdata.php example
* (make random employee list with birthdays, start-working dates, dept ID's)
* @Author Alexander Selifonov, <alex [at] selifan {dot} ru>
* To generate randomized russian people, use parameter "lang" :
* example.php?lang=ru
*
**/

include('../src/class.randomdata.php');
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';
include_once("../src/class.randomdata.lang-$lang.php");

$sex_arr = array('m', 'f');

// add my attribs for employee person: "Start working date" and "Dept name"
#RandomData::registerAttribute('startwork', 'randStartWork');
RandomData::registerAttribute('startwork', function($par) {
   return RandomData::getRandomDate(1,15);
});

RandomData::registerAttribute('dept', 'randDeptName');
RandomData::setConfig('birthdate', array('min'=>21,'max'=>70));

echo "Generated employees : <table border='1'><tr><th>No</th><th>Name</th>"
   . "<th>gender</th><th>birth date</th><th>Start work</th><th>Department</th></tr>";

$options = array('birthdate'=>true /*array(19,20)*/, 'dateformat'=>'Y-m-d','middlename'=>true);

/** if you need multiple language in your list (english and russian in my case), uncomment this line:
* $options['lang'] = array('en','ru');
* In that case lnguage will be randomly selected from that list for each person.
**/

for($kk=1; $kk<=50; $kk++) {

    $person = RandomData::getPerson($options);
    echo "<tr><td>$kk<M/td><td> $person[lastname], $person[firstname] $person[middlename] </td>"
       . "<td>$person[gender]</td><td>$person[birthdate]</td>"
       . "<td>$person[startwork]</td><td>$person[dept]</td></tr>";
}

echo "</table>";

exit;

function decodeSex($sx) {
    return ( ($sx === 'f') ? 'female' : 'male');
}

# creates random "started working" date for employee
function randStartWork($par=0) {
    $ret = RandomData::getRandomDate(1,15); // random from 1 to 15 years from current date
    return $ret;
}

/**
* Random Department creator
*
* @param mixed $par not used yet!
*/
function randDeptName($par=0) {
    $dept_arr = array( // List all your departments (names or ID's) here !
       'Head department'
      ,'Accounting department'
      ,'Security department'
      ,'Sales department'
      ,'Marketing dept'
      ,'HR'
      ,'IT'
    );
    $deptid = rand (0, count($dept_arr)-1);
    return $dept_arr[$deptid];
}
