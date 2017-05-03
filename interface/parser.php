<?php


$file = str_replace(".csv", "", $_GET['p']);
$files = array_diff(scandir("comics/".$file."/"), array('.', '..'));

sort($files);

for($i = 0; $i < count($files); $i++) {
	echo '<a href="parser.php?p='.$_GET['p']."&chunk=".$files[$i]."\">".$files[$i]."</a><br>";
}
echo '<a href="parser.php?p='.$_GET['p']."&chunk=all\">All chunks</a><br>";
echo '<br>';

if(isset($_GET['chunk'])) {

require_once('class/db.class.php');

$db = ($_SERVER['HTTP_HOST']=="localhost") ?
		new db('localhost', 'comics', 'root', '') : new db();

		
$csv = "comics/".$file."/".$_GET['chunk'];
$table = $file;
$filename = $csv;
$handle = fopen($filename, "r");

$row = 0;
$rows = array();

if($file == "story") {
	$colToDiscard = array(2, 4, 5, 6, 7, 8, 9, 10, 11);
} else if($file == "series") {
	$colToDiscard = array(3,4,5);	
} else if($file == "issue") {
	$colToDiscard = array(5,8);
} else {
	$colToDiscard = array();
}


$line = "INSERT INTO ".$table." VALUES ";
while( ($data = fgetcsv($handle, 0, ",")) != false ) {
	/*
	if($row == 0) {
		$rows = $data;
	} else {
		*/
		$line .= "(";
		
		for($c = 0; $c < count($data); $c++) {
			
			if(count($colToDiscard) == 0 || !in_array($c, $colToDiscard)) {
				$isnull = empty($data[$c]) || $data[$c] == "NULL";
				$text = !is_numeric($data[$c]) && !$isnull;
				$textDel = ($text ? "'" : "");
			
			
				$donnee = $db->quote($data[$c]);
				//$donnee = str_replace("'", "'", $data[$c]);
				
				$line .= $donnee == "?" || $isnull ? "NULL" : $donnee;
				if($c < count($data) -1) 
					$line .= ", ";
			}
		}
		
		if($row % 1  == 0) {
			$line .= ");";
			
			//echo $line."<br><br><br>";
			try {
				$db->exec($line);
			} catch(PDOException $e) {
				echo "<p style='color:red'>".$e->getMessage()."</p>";
				echo "<br><br>".$line;
			}
			
			
			
			//$line .= "<br><br><br><br><br><br>";
			$line = "INSERT INTO ".$table." VALUES ";
		} else {
			$line .= "), ";
			//$line .= "<br>";
		}
	
	//}
	
	$row++;
	if($row > 150000) {
		break;
	}
}

$db->exec(substr($line, 0, -2));

}
?>