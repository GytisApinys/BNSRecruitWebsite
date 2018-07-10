			<div id="main" class="wrapper style1">
				<div class="container">
					<h3>Cia bus kitokia info, o kol kas kaip pvz tokie duomenys</h3>
					<div>Dabar prisijunges <b><?php echo $prisijunges; ?></b> vartotojas</div>
					Visi uzsiregistrave vartotojai:
					<ol>
					<?php
						foreach($sarasas as $irasas){
							echo "<li>".$irasas->user_nickname." (".$irasas->user_email.")</li>";
						}
					?>
					</ol>
<?php 		
					if(!empty($this->session->userdata('character_name'))){

						echo "<h5>You're curretly looking for parties with your <b>".$characteris[0]->class." ".$this->session->userdata('character_name')." </b> </h54>";
						echo "<a style='text-align: center' href=".base_url()."index.php/user/characters class='button'>Change</a>";
					}else{
						echo "<h5>You haven't chosen character you'd like to look raids with.This would help you into finding raids for you faster.</h5>";
						echo "<a style='text-align: center' href=".base_url()."index.php/user/characters class='button'>Register Character</a>";
				
					}; ?>
					
				</div>
			</div>