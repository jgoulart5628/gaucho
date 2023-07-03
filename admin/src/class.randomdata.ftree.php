<?php
/**
* @package: randomdata - generating random "Family Tree"
* @name class.randomdata.ftree.php
*
* @Author Alexander Selifonov, <alex [at] selifan {dot} ru>
* @copyright Alexander Selifonov, <alex [at] selifan {dot} ru>
* @version 0.10 (started 2014-05-06)
* @Link http://www.selifan.ru
* @license http://opensource.org/licenses/BSD-3-Clause    BSD
*/

class RandomFtree extends RandomData {
    /**
    * generates family tree, starting with "root" person and going to N generations back
    *
    * @param mixed $options if integer value - number of generations to create
    * If array, items 'generations' and 'dateformat' supported.
    */
    private $generations = 5;
    private $birthrange = array(3,50); // age old range for start person in tree
    private $result = array();
    private $dtfmt = 'Y-m-d';
    private $death = false;
    /**
    * Generates family tree
    *
    * @param mixed $options: 'generations' - how many generations to create
    * 'death' = true|1 - to create death date for each person, if more than 1 - will be used as "MAX" age before death (default 75)
    */
    public function familyTree($options = false) {
        if (is_array($options)) {
            if (isset($options['generations'])) $this->generations = intval($options['generations']);
            if (isset($options['death'])) $this->death = $options['death'];
        }
        elseif (is_scalar($options)) $this->generations = intval($options);

        $pparams = array(
            'birthdate'=> $this->birthrange
        );
        if (isset($options['dateformat'])) $this->dtfmt = $pparams['dateformat'] = $options['dateformat'];
        $core = $this->result[0] = array($this->getPerson($pparams));
        for($level = 1; $level <= $this->generations; $level++) {
            $this->createParents($level-1);
        }
        return $this->result;

    }

    private function createParents($curlevel) {
        $newlvl = $curlevel+1;
        $this->result[$newlvl] = array();
        foreach($this->result[$curlevel] as $id => $person) {

            // create father
            $nno = count($this->result[$newlvl]);
            $this->result[$newlvl][$nno] = array(
                'lastname'  => $person['lastname']
               ,'firstname' => self::getFirstName('m')
               ,'birthdate'=>self::getRandomDate( 20, 38, $this->dtfmt, $person['birthdate'] )
               ,'gender' => 'm'
            );
            if ($this->death) { # create death date
                $maxage = ($this->death>40? $this->death : 75);
                $datedeath = self::getRandomDate(-$maxage, -40, $this->dtfmt,$this->result[$newlvl][$nno]['birthdate']);
                $deathyear = ($this->dtfmt[0]==='Y') ? intval($datedeath) : intval(substr($datedeath,6));
                if ($deathyear < date('Y')) $this->result[$newlvl][$nno]['deathdate'] = $datedeath;
            }
            // Create reference to parent from current "node"
            $this->result[$curlevel][$id]['father'] = $nno;

            $nno++;
            // create mother
            $this->result[$newlvl][$nno] = array(
                'lastname'  => self::getLastName('f')
               ,'firstname' => self::getFirstName('f')
               ,'birthdate'=>self::getRandomDate( 18, 35, $this->dtfmt, $person['birthdate'] )
               ,'gender' => 'f'
            );
            if ($this->death) { # create death date for mother
                $maxage = ($this->death>40? $this->death : 80);
                $datedeath = self::getRandomDate(-$maxage, -40, $this->dtfmt,$this->result[$newlvl][$nno]['birthdate']);
                $deathyear = ($this->dtfmt==='Y-m-d') ? intval($datedeath) : intval(substr($datedeath,6));
                if ($deathyear < date('Y')) $this->result[$newlvl][$nno]['deathdate'] = $datedeath;
            }
            $this->result[$curlevel][$id]['mother'] = $nno;
        }
    }
}