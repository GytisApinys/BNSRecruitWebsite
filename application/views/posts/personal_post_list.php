<div id="main" class="wrapper style1">
   <div class="container">
      <header >
      <div class="row 50%">
      <div class="2u 12u$(medium)">
         <h3><a href='<?php echo base_url(); ?>index.php/poster/post_manager/created' class = 'button <?php if($view_mode == 'created')echo 'special';?> small'>Created</a></h3>
         </div>
         <div class="2u 12u$(medium)">
         <h3><a href='<?php echo base_url(); ?>index.php/poster/post_manager/joined' class = 'button <?php if($view_mode == 'joined')echo 'special';?> small'>Joined</a></h3>
         </div></div>
      </header>
      <section id="content">
         <div class="table-wrapper">
         <table> 
         <thead>
         <tr>
         <?php
          if($view_mode=='created'){
                    echo   "<th>Creater</th>
                            <th>Raid</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Players</th>
                            <th> </th>
                            <th> </th>
                            <th> </th>";
          }else if ($view_mode=='joined'){
                    echo   "<th>Creater</th>
                            <th>Joined with</th>
                            <th>Raid</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Players</th>
                            <th>Status</th>
                            <th> </th>";
         }
         ?>
         </tr>
         </thead>
         <tbody>
         <?php
         if($view_mode=='created'){ 
            foreach($users_posts as $entry){
                $cor_time = substr($entry->start_time,0,-3);
                $status[$entry->post_id]['invited']++; //creater already included
                if($status[$entry->post_id]['waiting'] != 0) {$waiting = 'color:Orange';}
                else $waiting = 'color:White;';
                echo "<tr>
                        <td><b>".$entry->creater_name."</b></a></td>    
                        <td>".$entry->raid_name."</td>
                        <td><a href='".base_url()."index.php/poster/post_review/$entry->post_id'>".$entry->title."</td> 
                        <td>".$entry->start_date."</td> 
                        <td>".$cor_time."</td> 
                        <td>".$status[$entry->post_id]['invited']."/12</td> 
                        <td><a href='#' class='button special small'>Edit</td>
                        <td><a href='".base_url()."index.php/poster/delete_post/t/$entry->post_id' class='button  small'>Delete</td>
                        <td><a href='".base_url()."index.php/poster/raid_apply/$entry->post_id'  class='button small'><p style='$waiting'>Want to join(".$status[$entry->post_id]['waiting'].")</p></td>
                    </tr>                                            
                ";
            }
         }else if ($view_mode=='joined'){
            foreach($users_posts as $entry)
            {
                $status_of_invite[$entry->post_id]['invited']++; //creater already included
                $cor_time = substr($entry->start_time,0,-3);
                if($entry->status == 1) 
                    {$status='In the raid';$waiting = 'Green'; }
                else if($entry->status == 2)
                    {$status='Waiting approval';$waiting = 'red';}
                echo "<tr>
                        <td><b>".$entry->creater_name."</b></a></td>    
                        <td>".$entry->character_name."</td>
                        <td>".$entry->raid_name."</td>
                        <td><a href='".base_url()."index.php/poster/post_review/$entry->post_id'>".$entry->title."</td> 
                        <td>".$entry->start_date."</td> 
                        <td>".$cor_time."</td> 
                        <td>".$status_of_invite[$entry->post_id]['invited']."/12</td> 
                        <td><b><font color='$waiting'>$status</font></b></td>
                        <td><a href='".base_url()."index.php/poster/delete_invitation/$entry->id' class='button  small'>Delete</td>
                     </tr>                                            
        ";
                    
            }


         }

            ?>
         </tbody>
         </table>
         </div>
         </section></div>








</div>
</div>