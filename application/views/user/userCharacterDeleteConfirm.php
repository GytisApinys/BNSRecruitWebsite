
<div id="main" class="wrapper style1">
				<div class="container">
					<h3><?php echo "Are you sure you want to delete ".$char_name." character?";?></h3>
                    <a href="<?php echo base_url(); ?>index.php/user/delete_character/f/<?php echo $char_id; ?>" class="button special">Yes</a>
                    <a href="<?php echo base_url(); ?>index.php/user/characters" class="button special">No</a>
</div>
</div>