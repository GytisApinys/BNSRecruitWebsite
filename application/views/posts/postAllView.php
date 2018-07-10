<div id="main" class="wrapper style1">
   <div class="container">
      <header >
         <h3 align="center" >Recruitment posts</h3>
      </header>
      <div >
      <div class="row 150%">
      <div class="5u 12u$(medium)">
         <section id="sidebar">
         <ul class="actions small">
                          <li><a href="<?php echo base_url(); ?>index.php/poster/index/all" class="<?php if($type=='all') echo "special";?> button">All posts</a></li>
                        <li><a href="<?php
                        if (empty($this->session->userdata("character_name")))
                        {
                            echo '#';

                        }else{
                            echo base_url();
                            echo "index.php/poster/index/specific";
                        } 
                        ?>
                        " class="<?php if($type=='specific') echo "special";?> button"><?php if(empty($this->session->userdata("character_name"))) echo "Need to set character"; else echo "Post available for me"?></a></li>
		</ul>
         </div>



        </div class = "4u 12u"> <section id="content">
            <div  class="table-wrapper">
               <table >
                  <thead>
                     <tr>
                        <th>Raid</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Creater</th>
                        <th>Title</th>
                        <!--    <th>Accuracy</th>
                           <th>Critical rate</th>
                           <th>Critical damage</th> --> 
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        foreach($poster_list as $entry){

                            $cor_time = substr($entry->start_time,0,-3);
                           echo "<tr>
                                    <td><a href='".base_url()."index.php/poster/post_review/$entry->post_id' style='text-decoration:none' ><b>".$entry->raid_name."</b></a></td>    
                                    <td>".$entry->start_date."</td>
                                    <td>".$cor_time."</td> 
                                    <td><b>".$entry->creater_name."</b></td> 
                                    <td>".$entry->title."</td> 
                                </tr>                                            
                            ";
                        }
                        ?>
                  </tbody>
               </table>
            </div></div>
      </div>
      </section>
   </div>
</div>