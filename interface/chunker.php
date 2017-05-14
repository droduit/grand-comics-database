<?php
$csv = $file = str_replace(".csv", "", $_GET['p']);
$filename_in = "comics/".$_GET['p']; //$csv.".csv";
$handle = fopen($filename_in, "r");

$errors = array();
$row = 0;
$i = 0;

$fp_chunk = fopen(getFilenameOut($csv, $i), "w+"); 

$nbCol = 0;
while( ($data = fgetcsv($handle, 0, ",")) != false ) {
	
	if($row == 0) {
		$nbCol = count($data);
	} else {
		if(count($data) != $nbCol)
			$errors[] = $data;
	}

	fputcsv($fp_chunk, $data);
	
	$row++;
	if($row == 100000) {
		$row = 0;
		fclose($fp_chunk);
		$i++;
		$fp_chunk = fopen(getFilenameOut($csv, $i), "w+");
	}
}

function getFilenameOut($csv, $i) {
	return "comics/".$csv."/chunk_".$i.".csv";
}
?>


<?php
echo '<h1>'.$_GET['p'].'</h1>';

if(count($errors) > 0) {
	echo '<h2>Chunked with '.count($errors).' errors</h2>';
	foreach($errors as $e) {
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

<p><a href="parser.php?p=<?php echo $_GET['p']; ?>">Parse chunks and do insertions</a></p>