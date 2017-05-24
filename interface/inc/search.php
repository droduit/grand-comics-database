
<section class="page-width-70 boxed-style intro" id="page">
	<div class="page type-page status-publish hentry page-content text-format">
    	<div class="in" id="page-title" style="padding-bottom: 30px">
            <h1>Search</h1>
            <h4><span class="quote">Into our huge database of comics</span></h4>
        </div>
        
        <div class="in" id="page-content">
		
			<div class="advanced-options" style="<?php if(!isset($_GET['table'])) { ?>display:none;<?php }?> margin-bottom: 10px;">
				<form action="#">
				  <fieldset>
					<legend align="center">Tables to search</legend>
					
					<?php
					$toAvoid = array("characters", "editing", "feature", "issue_reprint", "participate", "story_genre", "story_reprint", "issue_orig", "story_orig");
					foreach($db->query("SHOW TABLES") as $row) {
						
						if(!in_array($row[0], $toAvoid)) {
							if(!isset($_GET['table']) || (isset($_GET['table']) && $row[0] == $_GET['table'])) {?>
								<div class="option">
								<input 	type="checkbox"
										checked="checked"
										id="<?php echo $row[0]; ?>"
										name="<?php echo $row[0]; ?>"
										value="<?php echo $row[0]; ?>">
								<label for="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></label>
								</div>
						
								<?php 
							}
						}
					} ?>
				  </fieldset>
				</form>
			</div>
		
			<div style="">
				<form action="#" method="post" class="searchable">
					<input id="search" name="search" placeholder="Type here to search..." type="search" style="text-align: center; font-size: 20px;">
					<?php if(!isset($_GET['table'])) { ?><input value="Show advanced options" type="button" id="show-advanced"><?php } ?>
				</form>
				
				<div style="display:none; position: relative; width: 100%; height: 18px; border: 1px solid #bbb; border-radius: 9px; margin-top: 10px" class="progressbar">
					<div style="" class="fill"></div>
					<div class="text" style="color: #026; text-align: center; position: absolute; margin-left: 47%; font-size: 12px"></div>
				</div>
				
				<div class="results" style="margin-top: 10px; min-height: 260px; background: white; border-radius: 6px;; padding: 8px; position: relative">
					<div class="loader" style="display: none; position: absolute; left: 0; top: 0; width: 100%; height: 100%; background: rgba(255,255,255,0.8); border-radius: 6px; text-align:center; box-sizing: border-box;  padding-top: 100px; color: #888">
						<img src="img/loader.gif" /><br>
						Loading ...
					</div>
					<div class="content">
						<div class="no-result">Search something...</div>
					</div>
				</div>
			</div>

			<input type="hidden" class="search-done" value="0" />
			
			
			<div style="clear: both"></div>
			
		</div>
    </div>
</section>

<div id="fullwin" style="display:none">
	<div class="toolbar">Close</div>
	<div class="content"></div>
</div>

<div id="dialog-confirm" title="Delete this record ?">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>This item will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>

<script>
$(function(){
	$('#background-overlay').css({background:"#000",opacity:"0.46"<?php if(!isset($_GET['p'])) { ?>,display:"none"<?php } ?>});
	
	<?php if(!isset($_GET['p'])) { ?>
	$('aside').css({marginLeft:"-218px",opacity:"0"});
	$('.background-image:not(.init)').css('display', "none");
	$('#loader').css("display","block");
	$('#loader-content').css("opacity","1");
	$('#loader').animate({rotate:"360deg"}, 500);
	$('.intro').css("display","none");

	$('#background-overlay').fadeIn(1400);
	
	setTimeout(function(){
		$('.background-image[current]').fadeIn(1400);
		$('.background-image.init').fadeOut(1400);
		$('#loader').hide('puff', 'medium');
		setTimeout(function(){
			$('.intro').show("puff",1500);
			setTimeout(function(){
				setTimeout(function(){ $('.background-image.init').remove(); }, 3500);
				$('aside').animate({marginLeft:"0",opacity:"1"}, 600);
			}, 600);
		}, 250);
	}, 750);
	<?php } else { ?>
	
	<?php } ?>
	
	$('#search').focus();
	
	// Click sur les options avancées
	$(".option:not(input[type=checkbox])").click(function(){
		var child = $(this).find("input[type=checkbox]");
		if(child.is(":checked")) {
			child.removeAttr("checked");
		} else {
			child.attr("checked", "checked");
		}
		child.trigger('change');
	});
	
	// Click on show advanced options
	$('#show-advanced').click(function(){
		$(this).slideUp("fast");
		$('.advanced-options').slideToggle("medium");
		return false;
	});
	
	$('form.searchable').submit(function(){ 
		execSearch();
		return false;
	});
	$('.advanced-options input[type=checkbox]').change(function(){
		execSearch();
	});
	
	$('.show-more').live('click', function(){
		var t = $(this).attr("table");
		var q = $('.input-query[table="'+t+'"]').val();
		var k = $('#search').val();
		
		$.post('inc/search-engine-res.php', { existArea : 0, key: k, table: t, query: q, showAll: 1}, function(html) {	
			$('#fullwin').fadeIn("fast");
			$('#fullwin .content').html(html);
		});
	});
	
	$('#fullwin .toolbar').click(function(){
		$('#fullwin').fadeOut("medium");
		$('#fullwin .content').html("");
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

function getActiveTables() {
	var cont = "";
	$('.advanced-options input[type=checkbox]').each(function(){
		cont = cont + $(this).val()+"="+$(this).is(":checked")+"|";
	});
	return cont;
}

function execSearch() {
	if($("#search").val() != "") {
		$('.progressbar').slideDown("fast");
		$('.results .loader').fadeIn("fast");
		$.post('inc/search-engine.php', {
			key : $("#search").val(),
			options : getActiveTables()
		}, function(html) {
			$(".results .content").html("");
			$('.results .loader').fadeOut("fast");
			$(".results .content").html(html);
		});
	}
}


</script>

<style>
.no-result {
	text-align: center; color: #999; font-size: 18px; padding-top: 100px
}
.table-res {
	margin-bottom: 10px;
	border: 1px solid #ddd;
	border-radius: 4px;
	overflow-x: auto;
}
.table-title {
	background: #eee;
	border-radius: 4px;
	padding: 4px 8px;
	font-weight: bold;
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

span.highlight {
	font-weight: bold;
	color: #900;
}

.show-more {
	background:#eee;
	padding: 5px 8px; 
	color: #777;
	cursor: pointer;
}
.show-more:hover { background: #ddd; }

#fullwin .content {
	overflow-y: auto;
}
#fullwin {
	position: fixed;
	left: 0;
	top: 0;
	width : 100%;
	height: 100%;
	background: rgba(255,255,255,0.99);
	padding: 15px;
	padding-left: 230px;
	box-sizing: border-box;
	overflow-y: auto;
}
#fullwin .toolbar {
	padding: 15px;
	text-align: center;
	cursor: pointer;
	font-weight: bold; 
	font-size: 18px;
	border-radius: 5px;
	background: rgba(0, 34, 51, 0.95);
	margin-bottom: 20px;
	color: white;
}
#fullwin .toolbar:hover {
	background: rgba(0, 34, 51, 0.8);
}
.progressbar .fill {
	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#b8e1fc+0,a9d2f3+10,90bae4+25,90bcea+37,90bff0+50,6ba8e5+51,a2daf5+83,bdf3fd+100;Blue+Gloss+%231 */
	background: #b8e1fc; /* Old browsers */
	background: -moz-linear-gradient(top,  #b8e1fc 0%, #a9d2f3 10%, #90bae4 25%, #90bcea 37%, #90bff0 50%, #6ba8e5 51%, #a2daf5 83%, #bdf3fd 100%); /* FF3.6-15 */
	background: -webkit-linear-gradient(top,  #b8e1fc 0%,#a9d2f3 10%,#90bae4 25%,#90bcea 37%,#90bff0 50%,#6ba8e5 51%,#a2daf5 83%,#bdf3fd 100%); /* Chrome10-25,Safari5.1-6 */
	background: linear-gradient(to bottom,  #b8e1fc 0%,#a9d2f3 10%,#90bae4 25%,#90bcea 37%,#90bff0 50%,#6ba8e5 51%,#a2daf5 83%,#bdf3fd 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b8e1fc', endColorstr='#bdf3fd',GradientType=0 ); /* IE6-9 */

	position:  absolute; top: 0; left: 0; z-index: 0; height: 100%; border-radius: 9px; width: 0%
}
.delete {
	transition: all 0.1s linear;
	cursor: pointer;
}
.delete:hover {
	opacity: 0.8;
}
</style>


