<?php 
$key = trim($_POST['key']);

if(isset($_POST['key']) && strlen($key) > 0) {
require_once('../class/db.class.php');

$db = ($_SERVER['HTTP_HOST']=="localhost") ?
		new db('localhost', 'comics', 'root', '') : new db();

$key = addslashes(addslashes($key));

// parse des options
$options = explode("|", substr($_POST['options'], 0, -1));
$opt = array();

foreach($options as $op) {
	$vals = explode("=", $op);
	if($vals[1] == "true") {
		$opt[] = $vals[0];
	}
}

if(count($opt) <= 0) {
	echo '<div class="no-result">'."Search on no table doesn't make sens".'</div>';
} else {
	
	$resNum = 0;
	$numericCols = array("id", "began", "ended");
	$keyIsNumeric = is_numeric($key);
	
	foreach($opt as $o) {
				
		$colInfos = $db->query("SHOW columns FROM `".$o."`");
		
		
		// Construction de la requete
		$queryStr = "SELECT * FROM `".$o. "` ";
		$addedStr = "";
		foreach($colInfos as $c) {
			//print_r($c);
			$dataType = explode("(", $c['Type'])[0];
			
			if($keyIsNumeric) {
				if(in_array($c['Field'], $numericCols)) {
					$addedStr.= "`".$c['Field']."` = ".$db->quote($key)." OR ";
				}
			} else {
				if($dataType == "varchar" || $dataType == "text") {
					$addedStr.= "`".$c['Field']."` LIKE '%".$key."%' OR ";
				}
			}
		}
		$addedStr = substr($addedStr, 0, -4);
		$queryStr .= " WHERE ".$addedStr;
		
	
		// Execution de la requete
		if(strlen($addedStr) > 0) {?>
			<script>
			$(function(){
				var elm = $('.results .content .table-res[table="<?php echo $o; ?>"]');
				var size = elm.size();
				
				$.post('inc/search-engine-res.php', { existArea : size, key:"<?php echo $key; ?>", table:"<?php echo $o; ?>", query:"<?php echo $queryStr; ?>" }, function(html) {
					var elm = $('.results .content .table-res[table="<?php echo $o; ?>"]');
					var size = elm.size();
					if(size > 0) {
						elm.html(html);
					} else {
						$('.results .content').html($('.results .content').html() + html);
					}
					
					$('.search-done').val(parseInt($('.search-done').val()) + 1);
					var percent = parseInt($('.search-done').val()) / parseInt("<?php echo count($opt); ?>") * 100;
				
					$('.progressbar .text').text("<?php echo $o; ?> ("+$('.search-done').val()+" / <?php echo count($opt); ?>)");
					$('.progressbar .fill').animate({ width: percent.toString()+"%"}, 50);
					
					if(parseInt($('.search-done').val()) >= <?php echo count($opt); ?>) {
						if($(".results .content").text().trim().length < 2) {
							$(".results .content").html('<div class="no-result">No result found ...</div>');
						} else {
							$(".no-result").remove();
						}
						$('.progressbar .text').text("Completed");
						$('.search-done').val("0");
					}
				});
			});
			</script>
			<?php
		} 
	}
	

}
}
?>