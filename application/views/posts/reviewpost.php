<div id="main" class="wrapper style1">
<div class="container">
   <header >
     <?php 
       
        if($raid_info[0]->raid_name == 'BT'){echo "<h3 align='center' >Black tower raid</h3>";}
        else if($raid_info[0]->raid_name == 'VT'){echo "<h3 align='center'>Vortex temple raid</h3>";}
        else if($raid_info[0]->raid_name == 'SK'){echo "<h3 align='center'>Scion's keep raid</h3>";}

    $other_char = $raid_info[0]->creater_name;
        echo "<h4 align='center'>Leader -  ".$raid_info[0]->creater_name."</h4>";
     ?>
   </header>
   <div class="row 150%">
      <div class="4u 12u$(medium)">
         <!-- <section id="sidebar"> -->
         <img src="<?php echo base_url();?>images/raid_image/<?php echo $raid_info[0]->raid_name;?>.png" 
         width="378" height="620" alt="">

         
         <!-- </section> --></div>
         <!-- <div class="8u$ 12u$(medium) important(medium)"> -->
         <div class="4u 12u$(medium)">
         <section id="content">
         <div >
         <?php 
                  echo "
                  
                  <div><b><i>    ".$raid_info[0]->title."</b></i></div>
                  <div><b>Raid starts:</b>: ".$raid_info[0]->start_date."</div>
                  <div><b>Time</b>      : ".$raid_info[0]->start_time."     </div>
                  <div><b>Message:</b>     : ".$raid_info[0]->text."</div>
                  <div><i><b>Requirements</b></i></div>
                  <div><b>Attack power</b> : ".$raid_info[0]->req_ap." </div>
                  <div><b>Critical</b>          : ".$raid_info[0]->req_crit."%</div>
                  <div><b>Accuracy</b>          : ".$raid_info[0]->req_acc."%</div>
                  <div><b>Health</b>   : ".$raid_info[0]->req_hp."</div>
                  
                  ";
                  ?>




         </div>
         </section> 
         </div>
         <div class="4u 6u$(medium)">
	 
   <div class="row">
   <div class="2u"><img src="" /></div>
   <div class="10u">


   </div>
   </div>
<?php 
    $post_id = $raid_info[0]->post_id;
  if (empty($this->session->userdata("character_name")))
  {

  }else if ($raid_info[0]->user_id == $this->session->userdata("loggen_id") && $raid_info[0]->creater_name != $this->session->userdata("character_name"))
  {
    echo "<div><a class='button small'>This is your other character's raid</a></div>";
  }
  else if($raid_info[0]->user_id == $this->session->userdata("loggen_id") && $raid_info[0]->creater_name == $this->session->userdata("character_name"))
  {
   echo "<div><a href='".base_url()."index.php/poster/chatroom/$post_id' class='button special small'>Join your raids   chat room</a></div>";
  }
  else if ($viewer_status =='view')
  {
    
   echo "<div><a href='".base_url()."index.php/poster/apply/$post_id' class='button special small'>Ask for invite</a></div>";
  }  
  else if ($viewer_status == 'in the raid')
  {
   echo "<div><a href='".base_url()."index.php/poster/chatroom/$post_id' class='button special small'>Join chat room</a></div>";
  }
  else if ($viewer_status == 'waiting for approval')
  {
   echo "<div><a class='button small'>Please wait for raid leader to accept.</a></div>";
  }



?>



   </div>

      </div>
   </div>
  
  </div>





        </div>
        </section></div>
        </div>
     </div>













   </div></div>
      