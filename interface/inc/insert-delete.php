<?php 
$tbl_lst = array(
	array("Story", "story"), 
	array("Story reprint", "story_reprint"),
	array("Series", "series"),
	array("Issue", "issue"),
	array("Issue reprint", "issue_reprint"),
	array("Publisher", "publisher"), 
	array("Indicia publisher", "indicia_publisher"),
	array("Brand group", "brand_group"),
	array("Country", "country"),
	array("Language", "language")
);

$slct_table = (!isset($_GET['t'])) ? 0 : $_GET['t'];
if($slct_table < 0 || $slct_table >= count($tbl_lst) || !is_numeric($slct_table)) 
	$slct_table = 0;
?>
				
<section class="page-width-80 boxed-style intro" id="page">
	<div class="page type-page status-publish hentry page-content text-format">
    	<div class="in" id="page-title" style="padding-bottom: 30px">
            <h1>Insert into table ...</h1>
            <h4>
				<div class="table-select-trigger gradient"><?php echo $tbl_lst[$slct_table][0]; ?></div>
				
				<div class="table-select" style="display:none">
				<?php $i = 0; foreach($tbl_lst as $table) { ?>
					<div class="table-entry <?php if($i == $slct_table) {?>slct<?php } ?>" index="<?php echo $i; ?>"><?php echo $table[0]; ?></div>
				<?php ++$i; } ?>
				</div>
			</h4>
        </div>
        
        <div class="in" id="page-content">
			<?php 
			$oTable = new Table($db, $tbl_lst[$slct_table][1]);
			
			$to_inc = 'inc/tables/'.$tbl_lst[$slct_table][1].'.php';
			$inc = (@file_exists($to_inc)) ? $to_inc : 'inc/tables/'.$tbl_lst[0][1].".php";
			?>
			
			<form method="post" action="#" enctype="multipart/form-data">
				<table width="100%">
					<?php @include_once($inc); ?>
					<tr><td colspan="2">&nbsp;</td></tr>
			
					<tr> <td colspan="2" align="center"><input type="submit" value="Insert" /></td></tr>
				</table>
			</form>
			
			<br>
			
			<div style="padding: 6px 10px; border: 1px solid #ccc; border-radius: 8px; background: white">
			<?php
			if(count($_POST) > 1) { $oTable->insert($_POST); }
			$oTable->displayTable();
			?>
			</div>
		</div>
    </div>
</section>

<div id="dialog-confirm" title="Delete this record ?">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>This item will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>


<script>
$(function(){
	$('.table-select-trigger').click(function(){
		$(this).slideUp("fast");
		$('.table-select').slideDown("fast");
	});
	
	$('.table-entry:not(.slct)').click(function(){
		var add = "&t=" + $(this).attr("index");
		window.location.href = "<?php echo $_SERVER['SCRIPT_NAME'] . "?p=".$_GET['p']; ?>" + add;
	});
	
	$('.table-entry.slct').click(function(){
		$('.table-select').slideUp("fast");
		$('.table-select-trigger').slideDown("fast");
	});
	
	$( "#dialog-confirm" ).dialog({
	  autoOpen: false,
      resizable: false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Delete": function() {
          $( this ).dialog( "close" );
		  var row = $(".delete[slct=on]").parent('td').parent('tr');
			var t = $(".delete[slct=on]").attr("table");
			var i = $(".delete[slct=on]").attr("idx");
			$.post('inc/delete.php', { table : t, id : i }, function(html){
				row.hide("explode", "medium");
				setTimeout(function(){ row.remove(); }, 500);
			});
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });
	
	$('.delete').live('click', function(){
		$(this).attr("slct","on");
		$( "#dialog-confirm" ).dialog( "open" );
	});
});
</script>

<style>
.gradient {
	background-image: linear-gradient(bottom, #E0DDE0 33%, #F5F5F5 67%);
	background-image: -o-linear-gradient(bottom, #E0DDE0 33%, #F5F5F5 67%);
	background-image: -moz-linear-gradient(bottom, #E0DDE0 33%, #F5F5F5 67%);
	background-image: -webkit-linear-gradient(bottom, #E0DDE0 33%, #F5F5F5 67%);
	background-image: -ms-linear-gradient(bottom, #E0DDE0 33%, #F5F5F5 67%);
	
	background-image: -webkit-gradient(
		linear,
		left bottom,
		left top,
		color-stop(0.33, #E0DDE0),
		color-stop(0.67, #F5F5F5)
	);
}
.table-select-trigger {
	width: 100%;
	border: 1px solid #bbb;
	border-radius: 8px;
	text-align: center;
	color: black;
	cursor: pointer;
	opacity: 0.9;
}
.table-select-trigger:hover { opacity: 1; }

.table-select {
	border-radius: 8px;
	border: 1px solid #bbb;
}
.table-entry {
	color: black;
	padding: 4px;
	text-align: center;
	cursor: pointer;
}
.table-entry.slct { cursor: default; }
.table-entry:hover, .table-entry.slct {
	background-image: linear-gradient(bottom, #E0DDE0 33%, #F5F5F5 67%);
	background-image: -o-linear-gradient(bottom, #E0DDE0 33%, #F5F5F5 67%);
	background-image: -moz-linear-gradient(bottom, #E0DDE0 33%, #F5F5F5 67%);
	background-image: -webkit-linear-gradient(bottom, #E0DDE0 33%, #F5F5F5 67%);
	background-image: -ms-linear-gradient(bottom, #E0DDE0 33%, #F5F5F5 67%);
	
	background-image: -webkit-gradient(
		linear,
		left bottom,
		left top,
		color-stop(0.33, #E0DDE0),
		color-stop(0.67, #F5F5F5)
	);
}
.delete {
	transition: all 0.1s linear;
	cursor: pointer;
}
.delete:hover {
	opacity: 0.8;
}
.search-del {
	cursor: pointer;
	background: rgba(0, 34, 51, 0.25);
	text-align: center;
	border-radius: 5px;
	padding: 6px;
	color: black;
	transition: all 0.1s linear;
}
.search-del:hover {
	background: rgba(0, 34, 51, 0.35);
}
</style>
