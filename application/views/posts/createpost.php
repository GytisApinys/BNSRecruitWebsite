<div id="main" class="page wrapper">
<div class="container">
   <h3 style="">Recruitment post</h3>
   <section>
      <form method="post" action="<?php echo base_url();?>index.php/poster/add_post">
         <div class="row uniform 25%">
            <div>
               <B>Date: </b>
               <div></div>
               <input type="date" min="2018-04-01" max="2099-00-00" name="start_date" style="background-color:#1c1d26; border:solid 1px #1c1d26" id="start_date"  value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="6u$ 12u$(xsmall)">
               <div>
                  <B>Time of raiding :</b> 
               </div>
               <input type="time" name="start_time" style="background-color:#1c1d26; border:solid 1px #1c1d26" id="start_time" placeholder=""value="19:00" required>GMT+0
               <div class="4u$ 12u$(xsmall)">
                  <div style="font-size:15px" class="select-wrapper">
                     <select style="font-size:15px" name="raid_name" id="raid_name">
                        <option value="BT" >Black Tower (BT)</option>
                        <option value="VT">Vortex Temple (VT)</option>
                        <option value="SK">Scion's Keep (SK)</option>
                     </select>
                  </div>
               </div>
            </div>
            <div>
               <h3>Requirements:</h3>
            </div>
            <div class="row uniform 25%">
               <div class="4u 12u$(xsmall)">
                  <ul>
                     <div><b>Attack power: </b><input type="number" style="background-color:#1c1d26; border:solid 1px #1c1d26" name="ap" id="ap" value="" placeholder="  Type here"></div>
                     <div><b>Accuracy: </b> <input type="number" style="background-color:#1c1d26; border:solid 1px #1c1d26" name="acc" id="acc" value="" placeholder="  Type here">%</div>
                     <div><b>Critical rate: </b> <input type="number" style="background-color:#1c1d26; border:solid 1px #1c1d26" name="c_rate" id="c_rate" value="" placeholder="  Type here">%</div>
                     <div><b>Critical damage:  </b><input type="number" style="background-color:#1c1d26; border:solid 1px #1c1d26" name="c_dmg" id="c_dmg" value="" placeholder="  Type here">%</div>
                     <div><b>Health:  </b><input type="number" style="background-color:#1c1d26; border:solid 1px #1c1d26" name="hp" id="hp" value="" placeholder="  Type here"></div>
                  </ul>
               </div>
               <div class="6u$ 12u$(xsmall)">
               </div>
               <div class="6u 12u$(xsmall)">
                  <input type="text" name="title" id="title" value="" placeholder="Enter title" required>
               </div>
               <div class="6u$ 12u$(xsmall)">
               </div>
               <div class="6u 12u$(medium)">
                  <input type="checkbox" id="copy" name="copy">
                  <label for="copy">Notify applications by email</label>
               </div>
               <div class="12u$">
                  <textarea required name="message" id="message" placeholder="Enter your message" rows="6" style="margin: 0px 52px 0px 0px; width: 1347px; height: 261px;"></textarea>
               </div>
               <div class="12u$">
                  <ul class="actions">
                     <li><input type="submit" value="Create post" class="special"></li>
                     <li><input type="reset" value="Reset"></li>
                  </ul>
               </div>
            </div>
      </form>
   </section>
   </div>
</div>