<!DOCTYPE HTML>
<html>
	<head>
		<title>Blade and Soul recruitment</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css" />
	</head>
	
		<div id="page-wrapper">
				<header id="header">
					<h1 id="logo"><a href="<?php echo base_url()?>">Blade and Soul recruitment</a></h1>
					<nav id="nav">
						<ul>
							<!-- <li><a href="<?php echo base_url()?>index.php/bnsrecruit/homepage">Home</a></li> -->
							<li>
								<a href="#">List of recruitments</a>
								<ul>
									<li><a href="<?php echo base_url()?>index.php/poster/">Poster board</a></li>
									<li><a href="<?php echo base_url()?>index.php/poster/post_manager">My list</a></li>
									<li><a href="<?php echo base_url()?>index.php/poster/write_new">Create new poster</a></li>
									

								</ul>
							</li>
<?php
	if(isset($this->session) && $this->session->userdata('loggen_id')>0){
	//	echo '<li><a href="'.base_url().'index.php/user/profile" >'.$this->session->userdata('loggen_nickname').'</a></li>';
	if(!empty($this->session->userdata('character_name'))){
		echo '<li> <meta charset="UTF-8"> <a href="'.base_url().'index.php/user/characters" >'.$this->session->userdata('character_name').'</a></meta></li>';
	}else{
		echo '<li><a href="'.base_url().'index.php/user/characters" >Set character</a></li>';
	}

		//echo '<li><a href="'.base_url().'index.php/user/profile" >'.$this->session->userdata('loggen_nickname').'</a></li>';
		echo '<li><meta charset="UTF-8"><a  class="button">'.$this->session->userdata('loggen_nickname').'</a></meta>
		<ul>
			<li><a href="'.base_url().'index.php/user/profile">Profile</a></li>
			<li><a href="'.base_url().'index.php/user/logout">Logout</a></li>
			
		</ul>
	</li>		';
	}else{
		echo '<li><a href="'.base_url().'index.php/user" class="button special">Login</a></li>';
	}
?>							
						</ul>
					</nav>
				</header>				 
			</div>
            <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
			<script src="<?php echo base_url();?>assets/js/jquery.scrolly.min.js"></script>
			<script src="<?php echo base_url();?>assets/js/jquery.dropotron.min.js"></script>
			<script src="<?php echo base_url();?>assets/js/jquery.scrollex.min.js"></script>
			<script src="<?php echo base_url();?>assets/js/skel.min.js"></script>
			<script src="<?php echo base_url();?>assets/js/util.js"></script>
			<script src="<?php echo base_url();?>assets/js/main.js"></script>
<body>
