<section class="page-width-70 boxed-style intro" id="page">
	<div class="page type-page status-publish hentry page-content text-format">
    	<div class="in" id="page-title" style="padding-bottom: 30px">
            <h1>Search</h1>
            <h4><span class="quote">Into our huge database of comics</span></h4>
        </div>
        
        <div class="in" id="page-content">
			<form action="#" method="post">
				<input id="name" name="name" placeholder="Type here to search..." required="required" type="search">
				<input value="Show advanced options" type="button" id="show-advanced">
			</form>
			<br>
			
			<div class="advanced-options" style="display:none">
				<form action="#">
				  <fieldset>
					<legend align="center">Tables to search</legend>
					
					<?php
					foreach($db->query("SHOW TABLES") as $row) { ?>
						<div class="option">
						<input 	type="checkbox"
								checked="checked"
								id="<?php echo $row[0]; ?>"
								name="<?php echo $row[0]; ?>"
								value="<?php echo $row[0]; ?>">
						<label for="<?php echo $row[0]; ?>"><?php echo $row[0]; ?></label>
						</div>
				
					<?php 
					} ?>
				  </fieldset>
				</form>
			</div>
			
		</div>
    </div>
</section>

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
	
	
	// Click sur les options avancées
	$(".option").click(function(){
		var child = $(this).find("input[type=checkbox]");
		if(child.is(":checked")) {
			child.removeAttr("checked");
		} else {
			child.attr("checked", "checked");
		}
	});
	
	// Click on show advanced options
	$('#show-advanced').click(function(){
		$('.advanced-options').slideToggle("medium");
		return false;
	});
});
</script>


