
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