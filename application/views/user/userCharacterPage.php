

<script type="text/javascript">(function(d, t, e, m){
    
    // Async Rating-Widget initialization.
    window.RW_Async_Init = function(){
                
        RW.init({
            huid: "401730",
            uid: "85e87243a2177c1b0811a039733e9f54",
            source: "website",
            options: {
                "advanced": {
                    "font": {
                        "hover": {
                            "color": "#E17000"
                        },
                        "color": "#E17000"
                    },
                    "text": {
                        "ratePoor": "Needs Improvement",
                        "rateAverage": "Some Mistakes",
                        "rateGood": "Did Really Well",
                        "rateExcellent": "Excellent Performace",
                        "rateThis": "Rate this"
                    }
                },
                "size": "large",
                "label": {
                    "background": "#FACDAA"
                },
                "style": "christmas",
                "isDummy": false
            } 
        });
        RW.render();
    };
        // Append Rating-Widget JavaScript library.
    var rw, s = d.getElementsByTagName(e)[0], id = "rw-js",
        l = d.location, ck = "Y" + t.getFullYear() + 
        "M" + t.getMonth() + "D" + t.getDate(), p = l.protocol,
        f = ((l.search.indexOf("DBG=") > -1) ? "" : ".min"),
        a = ("https:" == p ? "secure." + m + "js/" : "js." + m);
    if (d.getElementById(id)) return;              
    rw = d.createElement(e);
    rw.id = id; rw.async = true; rw.type = "text/javascript";
    rw.src = p + "//" + a + "external" + f + ".js?ck=" + ck;
    s.parentNode.insertBefore(rw, s);
    }(document, new Date(), "script", "rating-widget.com/"));</script>




<div id="main" class="wrapper style1">
   <div class="container">
      <header >
         <?php 
         
        //  if(empty($this->session->userdata('character_name')))
        //     {
        //         echo "<h3> You don't have an active character selected </h3>";
        //     }else {
        //         $temp_display = $CharData[0]->user_character;
            echo "
            <h4><i>".$CharData[0]->class."</i></h4>
            <h3>".$CharData[0]->user_character."</h3>
            
            <h4><i>Level " .$CharData[0]->charac_level." HM Level ".$CharData[0]->charac_hmlevel."</i></h4>
            ";
            
            
            //}
            ;
                ?>
      </header>
      <div class="row 150%">
      <div class="4u 12u$(medium)">
  <?php 
      $size = @getimagesize($CharData[0]->image);
      if (is_array($size)){
      echo   '<img src="'.$CharData[0]->image.'"width="378" height="620"
       alt="http://eu-gamepic.ncsoft.com/images/0201/19/Bx0hAAAAAAA=.jpg">';
      } else {
        echo '<img src="'.base_url().'images/no-image.png" width="378" height="620"
        alt=""/>';
      }

?>
<div class='rw-ui-container'></div>
        </div>
         <div class="4u 6u$(medium)">
         <section id="content">
         <div >
         <?php 
                  echo "<div><b>Health</b>            : ".$CharData[0]->charac_hp."</div>
                  <div><b>Attack power</b>      : ".$CharData[0]->charac_ap."     </div>
                  <div><b>Boss Attack power</b> : ".$CharData[0]->charac_boss_ap." </div>
                  <div><b>Accuracy</b>          : ".$CharData[0]->charac_acc."%</div>
                  <div><b>Critical</b>          : ".$CharData[0]->charac_crit."%</div>
                  <div><b>Critical Damage</b>   : ".$CharData[0]->charac_cdamage."%</div>
                  <div><b>Flame Damage</b>      : ".$CharData[0]->flame."</div>
                  <div><b>Frost Damage</b>      : ".$CharData[0]->frost."</div>
                  <div><b>Wind Damage</b>       : ".$CharData[0]->wind."</div>
                  <div><b>Earth Damage</b>      : ".$CharData[0]->earth."</div>
                  <div><b>Lighting Damage</b>   : ".$CharData[0]->lightning."</div>
                  <div><b>Shadow Damage</b>     : ".$CharData[0]->shadow."</div>";
                  ?>
         </div>
         </section>
      </div>
	  <div class="4u 6u$(medium)">
	 
	  <div class="row">
	  <div class="2u"><img src="<?php print_r($weapon['Image']); ?>" /></div>
	  <div class="10u">
	  <div><?php print_r($weapon['Name']); ?></div>
	  <div>
      <?php
        if(isset($gem1['Image'])) echo "<img src=".$gem1['Image']." style='width:30px;height:30px;' /> ";
        if(isset($gem2['Image'])) echo "<img src=".$gem2['Image']." style='width:30px;height:30px;' /> ";
        if(isset($gem3['Image'])) echo "<img src=".$gem3['Image']." style='width:30px;height:30px;' /> ";
        if(isset($gem4['Image'])) echo "<img src=".$gem4['Image']." style='width:30px;height:30px;' /> ";
        if(isset($gem5['Image'])) echo "<img src=".$gem5['Image']." style='width:30px;height:30px;' /> ";
        if(isset($gem6['Image'])) echo "<img src=".$gem6['Image']." style='width:30px;height:30px;' /> ";
      ?>
      </div>
	  </div>
	  </div>
	  <div class="row">
	  <div class="2u"><img src="<?php print_r($ring['Image']); ?>" style='width:40px;height:40px;'/></div>
	  <div class="10u"><?php print_r($ring['Name']); ?></div>
	  </div>
      <div class="row">
	  <div class="2u"><img src="<?php print_r($earing['Image']); ?>" style='width:40px;height:40px;'/></div>
	  <div class="10u"><?php print_r($earing['Name']); ?></div>
	  </div>
      <div class="row">
	  <div class="2u"><img src="<?php print_r($necklace['Image']); ?>" style='width:40px;height:40px;'/></div>
	  <div class="10u"><?php print_r($necklace['Name']); ?></div>
	  </div>
      <div class="row">
	  <div class="2u"><img src="<?php print_r($bracelet['Image']); ?>" style='width:40px;height:40px;'/></div>
	  <div class="10u"><?php print_r($bracelet['Name']); ?></div>
	  </div>
      <div class="row">
	  <div class="2u"><img src="<?php print_r($belt['Image']); ?>" style='width:40px;height:40px;'/></div>
	  <div class="10u"><?php print_r($belt['Name']); ?></div>
	  </div>
      <div class="row">
	  <div class="2u"><img src="<?php print_r($gloves['Image']); ?>" style='width:40px;height:40px;'/></div>
	  <div class="10u"><?php print_r($gloves['Name']); ?></div>
	  </div>
      <div class="row">
	  <div class="2u"><img src="<?php print_r($soul['Image']); ?>" style='width:40px;height:40px;'/></div>
	  <div class="10u"><?php print_r($soul['Name']); ?></div>
	  </div> <div class="row">
	  <div class="2u"><img src="<?php print_r($pet['Image']); ?>" style='width:40px;height:40px;'/></div>
	  <div class="10u"><?php print_r($pet['Name']); ?></div>
	  </div> <div class="row">
	  <div class="2u"><img src="<?php print_r($soul_badge['Image']); ?>" style='width:40px;height:40px;'/></div>
	  <div class="10u"><?php print_r($soul_badge['Name']); ?></div>
	  </div> <div class="row">
	  <div class="2u"><img src="<?php print_r($mystic_badge['Image']); ?>" style='width:40px;height:40px;'/></div>
	  <div class="10u"><?php print_r($mystic_badge['Name']); ?></div>
	  </div>
	     
	  </div>
      </li>
   </div>





         </div>
         </section></div>
         </div>
      </div>