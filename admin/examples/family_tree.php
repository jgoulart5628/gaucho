<?php
/**
* @name family_tree.php
* Creating family tree example
* @Author Alexander Selifonov, <alex [at] selifan {dot} ru>
*
**/

include('../src/class.randomdata.php');
include('../src/class.randomdata.ftree.php');
include_once("../src/class.randomdata.lang-en.php");

$randtree = new RandomFtree;

$opts = array('generations' => 2, 'death'=>80);
$tree = $randtree->familyTree($opts);

# Visualize family tree
?>
<!DOCTYPE html><html lang="en">
<head>
<meta charset="utf-8">
<title>Random generated Family Tree example</title>

<style>  /** Tree CSS3 formatting from http://codepen.io/Pestov/pen/BLpgm **/

* {margin: 0; padding: 0;}

.tree ul {
    padding-top: 20px; position: relative;

    transition: all 0.5s;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
}

.tree li {
    float: left; text-align: center;
    list-style-type: none;
    position: relative;
    padding: 20px 5px 0 5px;

    transition: all 0.5s;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
}

/*We will use ::before and ::after to draw the connectors*/

.tree li::before, .tree li::after{
    content: '';
    position: absolute; top: 0; right: 50%;
    border-top: 1px solid #ccc;
    width: 50%; height: 20px;
}
.tree li::after{
    right: auto; left: 50%;
    border-left: 1px solid #ccc;
}

/*We need to remove left-right connectors from elements without
any siblings*/
.tree li:only-child::after, .tree li:only-child::before {
    display: none;
}

/*Remove space from the top of single children*/
.tree li:only-child{ padding-top: 0;}

/*Remove left connector from first child and
right connector from last child*/
.tree li:first-child::before, .tree li:last-child::after{
    border: 0 none;
}
/*Adding back the vertical connector to the last nodes*/
.tree li:last-child::before{
    border-right: 1px solid #ccc;
    border-radius: 0 5px 0 0;
    -webkit-border-radius: 0 5px 0 0;
    -moz-border-radius: 0 5px 0 0;
}
.tree li:first-child::after{
    border-radius: 5px 0 0 0;
    -webkit-border-radius: 5px 0 0 0;
    -moz-border-radius: 5px 0 0 0;
}

/*Time to add downward connectors from parents*/
.tree ul ul::before{
    content: '';
    position: absolute; top: 0; left: 50%;
    border-left: 1px solid #ccc;
    width: 0; height: 20px;
}

.tree li a{
    border: 1px solid #ccc;
    padding: 5px 10px;
    text-decoration: none;
    color: #666;
    font-family: arial, verdana, tahoma;
    font-size: 11px;
    display: inline-block;

    border-radius: 5px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;

    transition: all 0.5s;
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
}

/*Time for some hover effects*/
/*We will apply the hover effect the the lineage of the element also*/
.tree li a:hover, .tree li a:hover+ul li a {
    background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
}
/*Connector styles on hover*/
.tree li a:hover+ul li::after,
.tree li a:hover+ul li::before,
.tree li a:hover+ul::before,
.tree li a:hover+ul ul::before{
    border-color:  #94a0b4;
}

</style>
</head>
<body>

<h1>Random generated Family Tree example</h1>

<div class="tree">
<ul>
<?php

// echo '<pre style="border:1px solid #999">' . print_r($tree,1) .'</pre>';

visualizeNode($tree, 0,0);

?>
</ul>
</div>
</body>
</html>
<?php

// recursive function to render one person and his/her parents and parents ...
function visualizeNode($obj, $row,$col) {
    $p = $obj[$row][$col];
    echo "\n<li><a href='#'>$p[firstname] $p[lastname],<br>";

    if(!empty($p['deathdate'])) echo "$p[birthdate] - $p[deathdate]";
    else echo "birth: $p[birthdate]";

    echo "</a>\n";
    if (isset($p['father'])) {
        echo "\n<ul>\n";
        visualizeNode($obj, ($row+1),$p['father']);
        visualizeNode($obj, ($row+1),$p['mother']);
        echo "\n</ul>\n";
    }
    echo "\n</li>\n";
}