<?php
$csv = $file = str_replace(".csv", "", $_GET['p']);
$filename_in = "comics/".$_GET['p']; //$csv.".csv";
$handle = fopen($filename_in, "r");

$errors = array();
$row = 0;

$fp_no_errors = fopen(getFilenameOut($csv), "w+"); 
$fp_errors = fopen(getFilenameErrors($csv), "w+");

$nbCol = 0;
while( ($data = fgetcsv($handle, 0, ",")) != false ) {
	
	$error = false;
	
	for($i = 0; $i < count($data); ++$i) {
		if($data[$i] == "?" || strlen($data[$i]) == 0) 
			$data[$i] = "NULL"; 
		
		
		$isnull = empty($data[$i]) || $data[$i] == "NULL";
		$text = !is_numeric($data[$i]) && !$isnull;
		
		if($text) {
			$followComma = strstr($data[$i], ",", true);
			
			if(strlen($followComma) >= 3) {
				$data[$i] = '"'.$followComma.'"'.strstr($data[$i], ",");
			}
		}
		
	}
	
	if($row == 0) {
		$nbCol = count($data);
	} else {
		if(count($data) != $nbCol) {
			$errors[] = $data;
			$error = true;
		}
	}

	if(!$error)
		fputcsv($fp_no_errors, $data);
	
	$row++;
}

fclose($fp_no_errors);

function getFilenameOut($csv) {
	return "comics/".$csv."_without_errors.csv";
}
function getFilenameErrors($csv) {
	return "comics/".$csv."_errors.csv";
}
?>


<?php
echo '<h1>'.$_GET['p'].'</h1>';

if(count($errors) > 0) {
	echo '<h2>Chunked with '.count($errors).' errors</h2>';
	foreach($errors as $e) {
		echo implode(",", $e);
		fwrite($fp_errors, implode(",", $e)."\n");
		
		echo '<hr>';
		echo '<b>'.count($e)." values instead of ".$nbCol."</b><br>";
		$i = 0;
		foreach($e as $c) {
			$i++;
			echo $i.".  ".$c."<br>";
		}
		echo '<hr><br>';
	}
} else {
	echo '<h2>Chunked without errors<h2>';
}
?>
<!--
<p><a href="parser.php?p=<?php echo $_GET['p']; ?>">Parse chunks and do insertions</a></p>
-->