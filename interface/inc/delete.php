<?php 
if(isset($_POST['id']) && isset($_POST['table'])) {
	$id = $_POST['id'];
	$table = $_POST['table'];
	
	require_once('../class/db.class.php');

	$db = ($_SERVER['HTTP_HOST']=="localhost") ?
			new db('localhost', 'comics', 'root', '') : new db();
		
	$db->exec("DELETE FROM `".$table."` WHERE id=".$id);		
}
?>