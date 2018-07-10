

<div id="main" class="wrapper style1">
<div class="container">
   <header class="major">
      <?php if(empty($this->session->userdata('character_name')))
         {
             echo "<h4> You don't have an active character selected.</h4>";
             echo  "<h4>Add one and click CHANGE to set as your main character. </h4>";
         }else {
             $temp_display = $this->session->userdata('character_name');
             echo "<h3>Current character </h3>
                     <h2>".$temp_display."</h2>";
          
         };
             ?>
   </header>
   <div class="row 150%">
      <div class="4u 12u$(medium)">
         <section id="sidebar">
            <h4>Add new character to your list</h4>
            <form method="post" action='<?php echo base_url()?>index.php/user/addcharacter'>
               <div class="row uniform 50%">
                  <div class="6u 12u$(xsmall)">
                     <input type="Text" name="name" id="name" value placeholder ="Character name" required>
                  </div>
                  <div class="12u$">
                     <div class="select-wrapper">
                        <select name="region" id="region" required>
                           <option value="EU">EU</option>
                           <option value="EU">NA</option>
                        </select>
                     </div>
                  </div>
                  <div class="12u$">
                     <div>
                        <input type="submit" value = "Add character" class="special">
                     </div>
         </section>
         </form>
         <hr>
         <a style="text-align: center" href="<?php echo base_url()?>index.php/user/update" class="special button">Update character stats</a>
         <div> <b><?php echo ""; ?> </b></div>
         </section></div>
         <div class="8u$ 12u$(medium) important(medium)">
         <section id="content">
         <div class="table-wrapper">
         <table> 
         <thead>
         <tr>
         <th>Name</th>
         <th>Region</th>
         <th>Class</th>
         <th>Level</th>
         <th>HM Level</th>
         <th> </th>
         <th> </th>
         <!--    <th>Accuracy</th>
            <th>Critical rate</th>
            <th>Critical damage</th> -->
         </tr>
         </thead>
         <tbody>
         <?php
            foreach($sarasas as $irasas){
                echo "<tr>
                        <td><a href='".base_url()."index.php/user/display/$irasas->id'><b>".$irasas->user_character."</b></a></td>    
                        <td>".$irasas->region."</td>
                        <td>".$irasas->class."</td> 
                        <td>".$irasas->charac_level."</td> 
                        <td>".$irasas->charac_hmlevel."</td> 
                        <td><a href='".base_url()."index.php/user/change/$irasas->id' class='button special small'>Change</td>
                        <td><a href='".base_url()."index.php/user/delete_character/t/$irasas->id' class='button  small'>Delete</td>
                    </tr>                                            
                ";
            }
            ?>
         </tbody>
         </table>
         </div>
         </section></div>
         </div>
      </div>
      <!--
         <td>".$irasas->charac_ap."</td> 
         <td>".$irasas->charac_hp."</td> 
         <td>".$irasas->charac_acc."%</td> 
         <td>".$irasas->charac_crit."%</td> 
         <td>".$irasas->charac_cdamage."%</td> 
         -->
   </div>
</div>