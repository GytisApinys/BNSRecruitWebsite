    
<div id="main" class="wrapper style1">
				<div class="container">
					<header><h4>Invitation management for</h4>
                    
                    </header>

<div class="row">
<div class="8u 6u$(medium)">
         <section id="content">
        <div class="table-wrapper">
        <table>
        <thead><h3> <?php echo $title;?></h3>
        <tr>
        <th></th>
        <th></th>
        <th></th>
</tr><thead>
<tbody>



        <?php
        foreach($inv as $entry)
        {
            echo "</tr>
            <td><a href='".base_url()."index.php/user/display/$entry->char_id'><b>$entry->character_name</b></td>     
            <td><a href='".base_url()."index.php/poster/invite/$entry->room_id/$entry->id'class='button small' >Accept</a></td>
            <td><a href='".base_url()."index.php/poster/delete_inv/$entry->room_id/$entry->id'class='button small' >Deny</a></td>
            </tr>";
        }

?>
</tbody>
</table>



</div></div></div></section>

                    <a href="<?php echo base_url(); ?>index.php/poster/post_manager" class="button special">Back</a>

					
				
</div>
</div>