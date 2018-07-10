
<div id="main" class="wrapper style1">
				<div class="container">
					<h3><?php echo "Are you sure you want to delete <i>".$post_title."</i> post?";?></h3>
                    <a href="<?php echo base_url(); ?>index.php/poster/delete_post/f/<?php echo $post_id; ?>" class="button special">Yes</a>
                    <a href="<?php echo base_url(); ?>index.php/poster/post_manager" class="button special">No</a>
</div>
</div>