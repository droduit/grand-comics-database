<?php 
require_once('../class/db.class.php');
require_once("queries.inc.php"); 

$db = ($_SERVER['HTTP_HOST']=="localhost") ?
		new db('localhost', 'comics', 'root', '') : new db();
		
$key = $_POST['key'];
$array_idx = $_POST['array_idx'];


$query_str = $q[$array_idx-1][$key][1];

if($query_str == "") {
	echo 'This query doesn\'t exist';
} else {
	//echo $query_str;
	
	$stmt = $db->query($query_str);
	$result = $stmt->setFetchMode(PDO::FETCH_NAMED);
	
	
	echo '<div class="query-txt">'.nl2br($query_str).'</div>';
	
	$i = 0;
	echo '<table width="100%">';
	while($row = $stmt->fetch()) {
		
		if($i == 0) {
			echo '<tr>';
			foreach($row as $k => $v) {
				echo '<th>'.$k.'</th>';
			}
			echo '</tr>';
		} 
	
		echo '<tr>';
		foreach($row as $r) {
			echo '<td>'.(is_array($r) ? $r[0] : $r).'</td>';
		}
		echo '</tr>';
		
		$i++;
		// print_r($row); echo '<br>';
		//print $row['name'];
	}
	echo '</table>';
	
}
?>