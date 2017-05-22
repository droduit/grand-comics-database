<?php require_once("queries.inc.php"); ?>

<section class="page-width-70 boxed-style intro" id="page">
	<div class="page type-page status-publish hentry page-content text-format">
    	<div class="in" id="page-title" style="padding-bottom: 30px">
            <h1>Predefined queries</h1>
            <h4 style="display: none"><span class="quote">...</span></h4>
        </div>
        
        <div class="in" id="page-content">

			<?php
			// tableaux de tableaux de queries pour chaque deliverable
			$i = 1;
			foreach($q as $q_d) {
				echo "<h4>Deliverable ".(++$i)."</h4>";
				
				// tableaux de queries pour le deliverable courant 
				foreach($q_d as $k => $q_a) {
					// $q_a[0] : description de la query
					// $q_a[1] : code sql de la query
					?>
					
					<div class="query" array_idx="<?= ($i-1) ?>" key="<?= $k; ?>">
						<div class="num">Query <?= $k ?></div>
						<div class="desc"><?= $q_a[0] ?></div>
						<div class="exec">Execute query</div>
						<div class="res table-res" style="display:none"><div style="text-align: center; padding: 8px"><img align="center" src="img/loader.gif" /></div></div>
					</div>

					<?php 
				}
				
				echo "<br><br>";
			}
			?>
			
		</div>
    </div>
</section>

<script>
$(function(){
	$('.query .exec').click(function(){
		var parent = $(this).parent();
		var a_idx = parent.attr("array_idx");
		var k = parent.attr("key");
		
		if(parent.attr("executed") == undefined) {
			parent.find(".res").slideDown("fast");
			
			var before = (new Date()).getTime();
			$.post('inc/query.exec.php', {
				key : k, 
				array_idx : a_idx
			}, function(html) {
				var after = (new Date()).getTime();
				var diff = (after - before) / 1000;
				

				parent.find(".exec").slideUp("fast");
				parent.find(".res").html(html);
				parent.attr("executed","on");
				
				parent.find('.res').prepend('<div class="time">Execution time : '+diff+' seconds</div>');
			});
		}
	});
});
</script>

<style>
.query {
	margin-bottom: 20px;
	border: 3px solid #222;
	padding: 4px;
	border-left: none;
	border-right: none;
	background: white;
}
.query .exec {
	background: #bb1300;
    padding: 6px 0;
    text-align: center;
    display: block;
    color: white;
    border-radius: 8px;
    margin-bottom: 8px;
	cursor: pointer;
}
.query .exec:hover {
	background: #f65;
}
.query .num {
	font-weight: bold;
	color: black;
	font-size: 14px;
}
.query .desc {
	font-style: italic;
	padding: 4px 0;
	margin-bottom: 4px;
}
.query .time {
	color: #bb1300;
}

.query-txt {
	background: rgb(0, 0, 25);
	color: white;
	font-family: Consolas;
	font-size: 11px;
	margin: 10px 0;
	padding: 8px;
	border-radius: 5px;
}

.res {
	overflow-y : auto;
}
.table-res table {
	border-collapse : collapse;
}
.table-res table tr:nth-child(2n+1) td {
	background: rgba(0, 34, 51, 0.08);
}
.table-res table td, .table-res table th {
	border-right: 1px solid rgba(0, 34, 51, 0.08);
	padding: 2px 6px;
}
.table-res table td:last-child, .table-res table th:last-child {
	border-right: none;
}
.table-res table th {
	background: #fefefe;
}
</style>