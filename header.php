<?php
// pour rendre le menu navigation invisible en page Index
	if($page == "index") {
		echo '<div class="nav nav-scroll">';
	} else {
		echo '<div class="nav">';
	}
?>

		<a tabindex="0" href="index.php" id="logo">Equo Vadis</a>

		<div id="mobile_menu" tabindex="0">	
			<span></span>	
			<span></span>
			<span></span> 
		</div>
			<!-- le contenu du mobile menu -->
		<div>
			<div id="lang">
				<span tabindex="0">FR</span>
				<span>|</span>
				<span tabindex="0">EN</span>
			</div>
			<div class="menu">
				<!-- USER MENU DEBUT-->
				<div>

				<?php 
									if ( isset($_SESSION["name"])) {
										$avatar = "images/avatars/".$_SESSION["avatar"];
				?>

					<img src="<?php echo $avatar; ?>" alt="avatar" id='user_icon' tabindex="0">					
				<div class="user_menu">
				<div class="menu_deco"></div> <!-- petite fleche déco-->
				<span id='username'><?php echo $_SESSION['name']; ?></span>


				<?php
										if ($_SESSION["type"] == "pro") {
				?>
					<a class="m_hover" href="user_pro_club.php">MON CLUB</a>
				<?php
											}
				?>	<a class="m_hover" href="user_events.php">+Evenement</a>
					<a class="m_hover" href="user_favoris.php">FAVORIS</a>
					<a class="m_hover" href="user_compte.php">MON COMPTE</a>
				<?php
										if ($_SESSION["type"] == "admin") {
				?>
					<a class="m_hover" href="pages/admin_office.php">BACK OFFICE</a>
				<?php
											} ?>
					<a class="m_hover" href="pages/logout.php">Déconnecter</a>
				</div>
				<?php
									} else {
										?>
				<a tabindex="0" id="connexion" <?php if($page=='login'){echo 'class="active"';}?> href="login.php">Connexion</a>

										<?php
									};
				?>
				</div>
<!-- USER MENU FIN -->
			</div>
			<div class="menu">		
					<ul>
						<li tabindex="0">
							<a <?php if($page=='evenements'){echo 'class="active"';}?> href="evenements.php">Evènements</a>
						</li>
						<li tabindex="0">
							<a <?php if($page=='decouvrir'){echo 'class="active"';}?> href="decouvrir.php">Découvrir</a>
						</li>
						<li tabindex="0">
							<a <?php if($page=='recherche'){echo 'class="active"';}?> href="recherche.php">Recherche</a>
						</li>
					</ul>
			</div>

		</div>
</div>