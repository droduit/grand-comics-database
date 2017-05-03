<?php
$files = array_diff(scandir("comics/merge_story/"), array('.', '..'));

$fp_out = fopen("comics/story_merge.csv", "w+"); 

foreach($files as $f) {
	
	$handle = fopen("comics/merge_story/".$f, "rb");

	/*
	$contents = stream_get_contents($handle);
	fwrite($handle, $contents);
	*/

	while (!feof($handle)) {
		$c = fread($handle, 8192);
		fwrite($handle, $c);
	}
	
	fclose($handle);
	
}

fclose($fp_out);
?>