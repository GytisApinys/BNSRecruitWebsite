				<div id="main" class="wrapper style1">
					<div class="container">
						<header>
							<h2>Registration form</h2>
						</header>
                        <form id='register' action='<?php echo base_url()?>index.php/user/register' method='post' >
							<?php if(isset($klaida) && $klaida!=""){ echo "<div class='error'>".$klaida."</div>";} ?>
							<?php echo "<div>".validation_errors()."</div>"; ?>
                            <fieldset >
								<input type="text" placeholder="User Name" name="username" required <?php if(isset($login)){ echo "value='".$login."'";} ?>/><br>
								<input type="email" placeholder="Email" name="email" required <?php if(isset($pastas)){ echo "value='".$pastas."'";} ?>/><br>
								<input type="password" placeholder="Password" name="password" autocomplete="new-password" required /><br>
								<input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required /><br>
								<input type='submit' name='Submit' value='Register' />
                            </fieldset>
                        </form>
					</div>
				</div>