<?php
$csv = "indicia_publisher";
$filename = "comics/".$csv.".csv";
$handle = fopen($filename, "r");

$info = array();
$row = 0;
$rows = array();

$line = "INSERT INTO ".$csv." VALUES ";
while( ($data = fgetcsv($handle, 0, ",")) != false ) {
	if($row == 0) {
		$rows = $data;
	} else {
		
		$line .= "(";
		
		for($c = 0; $c < count($data); $c++) {
			
			$isnull = empty($data[$c]) || $data[$c] == "NULL";
			$text = !is_numeric($data[$c]) && !$isnull;
			$textDel = ($text ? "'" : "");
		
			$donnee = str_replace("'", "\\'", $data[$c]);
			
			$line .= $isnull ? "NULL" : $textDel . $donnee . $textDel;
			if($c < count($data) -1) 
				$line .= ", ";
		}
		
		
		$line .= $row % 500 == 0 ? ");<br> <br>INSERT INTO ".$csv." VALUES " : "), <br>";
	
	}
	
	$row++;
	if($row > 150000) {
		break;
	}
}

echo $line;