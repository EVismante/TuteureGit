<?php
// pour rendre le menu navigation invisible en page Index
	if($page == "index") {
		echo '<div class="nav nav-scroll">';
	} else {
		echo '<div class="nav">';
	}
?>

		<a href="index.php" id="logo">Equo Vadis</a>

		<div id="mobile_menu">	
			<span></span>	
			<span></span>
			<span></span> 
		</div>
			<!-- le contenu du mobile menu -->
		<div>
			<div id="lang">
				<span>FR</span>
				<span>|</span>
				<span>EN</span>
			</div>
			<div class="menu">
				<?php include 'inc/header.inc.php';?>
			</div>
			<div class="menu">		
					<ul>
						<li <?php if($page=='evenements'){echo 'class="active"';}?>><a href="evenements.php">Evènements</a></li>
						<li <?php if($page=='decouvrir'){echo 'class="active"';}?>><a href="decouvrir.php">Découvrir</a></li>
						<li <?php if($page=='recherche'){echo 'class="active"';}?>><a href="recherche.php">Recherche</a></li>
					</ul>
			</div>

		</div>
</div>