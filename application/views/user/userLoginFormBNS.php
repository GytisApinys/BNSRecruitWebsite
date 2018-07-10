			<div id="main" class="wrapper style1">
				<div class="container">
					<header>
						<h2>Login</h2>
					</header>
						<form id='login' action='<?php echo base_url()?>index.php/user' method='post'  accept-charset='UTF-8'>
						<?php if(isset($klaida) && $klaida!=""){ echo "<div class='error'>".$klaida."</div>";} ?>
							<fieldset >
								<input type="text" placeholder="User Name" name="username" required <?php if(isset($login)){ echo "value='".$login."'";} ?>/><br>
								<input type="password" placeholder="Password" name="password" autocomplete="new-password" required /><br>
								<input type='submit' name='Submit' value='Login'  /> &nbsp;&nbsp;
								<a style="text-align: center" href="<?php echo base_url()?>index.php/user/register" class="button">Register here</a>
                            </fieldset>
						</form>	
					</div>
				</div>