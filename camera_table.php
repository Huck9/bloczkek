<?php
session_start();
require_once("config.php");
global $config;

$pdo = new PDO($config['dsn'], $config['username'], $config['password']);

$stm = $pdo->query("SELECT * FROM cameras");
$cameras= $stm->fetchAll();

$stm2 = $pdo->query("SELECT * FROM users");
$users= $stm2->fetchAll();
$buildingId = 0;
foreach ($users as $u) {
    if(strval($u['login'])==$_SESSION['name'] ){
        $buildingId=$u['building_id'];
    }
}
echo "<table border='1'>
<tr>
<th>Kamery</th>
</tr>";


foreach ($cameras as $c) {
    if($buildingId == $c['building_id']) {
        echo "<tr>";
        echo "<td>" . "<a href=" . $c['link'] . ">" . "Camera " . $c['id'] . "</a>" . "</td>";
        echo "</tr>";
    }
}
echo "</table>";
?>