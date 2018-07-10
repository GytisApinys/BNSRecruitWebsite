<div id="main" class="wrapper style1">
<div class="container">
   <header >
     <?php 
       
        if($raid_info[0]->raid_name == 'BT'){echo "<h3 align='center' >Black tower raid</h3>";}
        else if($raid_info[0]->raid_name == 'VT'){echo "<h3 align='center'>Vortex temple raid</h3>";}
        else if($raid_info[0]->raid_name == 'SK'){echo "<h3 align='center'>Scion's keep raid</h3>";}

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
                  
                  <div><b>Raid starts:</b>: ".$raid_info[0]->start_date."</div>
                  <div><b>Time</b>      : ".$raid_info[0]->start_time."     </div>
                  <div><b>Title</b>   : ".$raid_info[0]->title."</div>
                  <div><b>Message:</b>     : ".$raid_info[0]->text."</div>
                  ";
                  ?>
         </div>
         </section> 
         </div>


   <div class="4u 12u$(medium)">
     

    <form method="post" action='<?php echo base_url()?>index.php/poster/message/<?php echo $raid_info[0]->post_id; ?>'>
               <div class="row uniform 50%">
                  <div class="6u 12u$(xsmall)">
                     <input type="Text" name="text" id="message_text" value placeholder ="Your message..." required onKeyPress="return keyPressed(event)" maxlength="25">
                  </div>
                     <div>
                        <input type="button" value = "post" class="special" id="mygtukas_zinutes_submitinimui" onKeyPress="return keyPressed(event)">
                     </div>
         </form>

         <script>
         
$( document ).ready(function() {



setInterval(function(){
    gauti_zinutes();
}, 1000);//5000 reiskia 5 sekundes, paskui pasikeisi kiek reikes

    $("#mygtukas_zinutes_submitinimui").click(function(){
        $.ajax({
        method: "POST",
        url: '<?php echo base_url()?>index.php/poster/message/<?php echo $raid_info[0]->post_id; ?>',
        data: { zinute: $("#message_text").val()}
    })
    .done(function( msg ) {
        //alert( "Data Saved: " + msg );
      //  $('#visos_zinutes').append("<div>"+$("#message_text").val()+"</div>");
       $("#message_text").val("");
      gauti_zinutes();

    });

    });

});

function gauti_zinutes(){
        $.ajax({
        url: '<?php echo base_url()?>index.php/poster/chat_display/<?php echo $raid_info[0]->post_id; ?>',
    })
    .done(function( msg ) {
        //alert( "Data Saved: " + msg );
        $('#visos_zinutes').html(msg);
        //$("#message_text").val("");


    });

}
function keyPressed(e)
{
     var key;      
     if(window.event)
          key = window.event.keyCode; //IE
     else
          key = e.which; //firefox      

     return (key != 13);
}
         
         </script>



      </div>
      <div id="visos_zinutes">

<?php 
    foreach($messages as $message)
        {
            $who = $message->character_name;
            $who_id = $message->char_id;
            $said = $message->msg;
            if ($raid_info[0]->creater_name == $who) {$color = 'red';} else $color = 'orange';
            echo "<div style='color:$color;'><b><a href='".base_url()."index.php/user/display/$who_id'>$who</b></a> : $said</div>";
        }
?>
</div><div></div>
         