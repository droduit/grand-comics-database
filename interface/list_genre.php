<?php
require_once('class/db.class.php');

$db = ($_SERVER['HTTP_HOST']=="localhost") ?
		new db('localhost', 'comics', 'root', '') : new db();

$i = 0;

$query = "";
foreach($db->query("SELECT DISTINCT name FROM hero WHERE name IS NOT NULL and name <> ''") as $r) {
	//$parts = explode(";", $r['name']);
	
	//foreach($parts as $p) {
		$query .= "INSERT INTO hero (name) VALUES (". $db->quote($r['name']).");<br>";
	//}
}

echo $query;
?>