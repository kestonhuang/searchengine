<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
	<link rel="stylesheet" type = "text/css" href = "<?php echo base_url(); ?>css/style.css">
</head>
<body class="body">
	<div class="top-header">
		<img src="<?php echo base_url(); ?>images/header.jpg" alt="Header">
	</div>

	<nav id="main-menu">

		<ul class="links">
			<li class="dropdown">
				<button class="dropbtn">
					<a href="<?php echo base_url(); ?>private_area" class="homebtn">Home</a>
				</button>
			</li>
			<li class="dropdown">
				<button class="dropbtn"><i><a href="<?php echo base_url(); ?>private_area/search" class="homebtn">Browse</a></i></button>
			</li>
			<li class="dropdown">
				<button class="dropbtn"><i>Categories</i></button>
				<!--				<ul class="dropdown-content">-->
				<!--					<li>-->
				<!--						<a href="characters/pooh.html">Winnie the Pooh</a>-->
				<!--					</li>-->
				<!--					<li>-->
				<!--						<a href="characters/crobin.html">Christopher Robin</a>-->
				<!--					</li>-->
				<!--					<li>-->
				<!--						<a href="characters/tigger.html">Tigger</a>-->
				<!--					</li>-->
				<!--					<li>-->
				<!--						<a href="characters/piglet.html">Piglet</a>-->
				<!--					</li>-->
				<!--					<li>-->
				<!--						<a href="characters/eeyore.html">Eeyore</a>-->
				<!--					</li>-->
				<!--					<li>-->
				<!--						<a href="characters/kanga.html">Kanga</a>-->
				<!--					</li>-->
				<!--					<li>-->
				<!--						<a href="characters/roo.html">Roo</a>-->
				<!--					</li>-->
				<!--					<li>-->
				<!--						<a href="characters/owl.html">Owl</a>-->
				<!--					</li>-->
				<!---->
				<!--				</ul>-->
			</li>
			<li class="dropdown">
				<button class="dropbtn"><i>My Account</i></button>
				<ul class="dropdown-content">
					<li>
						<a href="<?php echo base_url(); ?>private_area/profile">My Profile</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>private_area/image_manipulation">Edit photos for Listings</a>
					</li>
					<li>
						<a href="">Sales Listings</a>
					</li>
					<li>
						<a href="">Wishlist</a>
					</li>
					<li>
						<a href="">Purchases</a>
					</li>
					<li>
						<a href="">Cart</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>private_area/logout">SIGN OUT</a>
					</li>

				</ul>
			</li>
		</ul>

	</nav>
</body>
</html>
