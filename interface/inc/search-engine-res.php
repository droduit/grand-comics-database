<?php 
$table = $_POST['table'];
$query = $_POST['query'];
$key = strtolower($_POST['key']);
$existArea = $_POST['existArea'];

$limit = 5;

if(isset($_POST['table'])) {
	require_once('../class/db.class.php');

	$db = ($_SERVER['HTTP_HOST']=="localhost") ?
			new db('localhost', 'comics', 'root', '') : new db();
			
					
	$colInfos = $db->query("SHOW columns FROM `".$table."`");
	$cols = array();
	
	foreach($colInfos as $c) {
		$cols[] = $c[0];
	}
	
	
	$res = $db->query($query);
	if($res->rowCount() > 0) {
		if($existArea <= 0) {
			echo '<div class="table-res" table="'.$table.'">';
		}
		echo "<div class=\"table-title\">".$table." (".$res->rowCount()." results";
		
		if($res->rowCount() > $limit && !isset($_POST['showAll'])) {
			echo ' - display '.$limit.' first only';
		}
		
		echo ")</div>";
		echo '<table width="100%">';
		
		echo '<tr>';
		foreach($cols as $c) { echo '<th>'.$c.'</th>'; }
		echo '<th></th>';
		echo '</tr>';
		
		$i = 0;
		foreach($res as $row) {
			$i++;
			echo '<tr>';
			foreach($cols as $c) {
				$text = mb_strtolower($row[$c]);
				if(!isset($_POST['showAll'])) $text = mb_strimwidth($text, 0, 50, "...");
				
				echo '<td>'.str_replace($key, '<span class="highlight">'.$key.'</span>', $text)."</td>";
			}
			echo '<td align="center" width="24px"><img class="delete" src="img/delete.png" table="'.$table.'" idx="'.$row['id'].'" /></td>';
			echo '</tr>';
			
			if($i == $limit && !isset($_POST['showAll'])) break;
		}
		echo '</table>';
		
		if(!isset($_POST['showAll'])) {
			echo '<input type="hidden" class="input-query" table="'.$table.'" value="'.$query.'" />';
			echo '<div class="show-more" table="'.$table.'">Display all results</div>';
		}
		
		if($existArea <= 0) {
			echo '</div>';
		}
		
	}
	
}
?>