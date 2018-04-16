<?php
include_once 'inc/langue.inc.php';

//controle d'URL pour les pages des evenements et des clubs

 if($page == "club" OR $page == "event" OR $page == "decouvrir") {
 	$uri = $_SERVER['REQUEST_URI']."&lang=";
 } else {
 	$uri = $_SERVER['PHP_SELF']."?lang=";
 }


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
				<a href="<?php echo $uri.'fr'; ?>" tabindex="0"
					<?php if ($lang == "fr") { echo "class='sousligne'"; }?>
					>FR</a>
				<span>|</span>
				<a href="<?php echo $uri.'en'; ?>" tabindex="0"
					<?php if ($lang == "en") { echo "class='sousligne'"; }?>
					>EN</a>
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
					<a class="m_hover" href="user_pro_club.php"><?php echo $content["menu1"]; ?></a>
				<?php
											}
				?>	<a class="m_hover" href="user_events.php"><?php echo $content["menu2"]; ?></a>
					<a class="m_hover" href="user_favoris.php"><?php echo $content["menu3"]; ?></a>
					<a class="m_hover" href="user_compte.php"><?php echo $content["menu4"]; ?></a>
				<?php
										if ($_SESSION["type"] == "admin") {
				?>
					<a class="m_hover" href="pages/admin_office.php">BACK OFFICE</a>
				<?php
											} ?>
					<a class="m_hover" href="pages/logout.php"><?php echo $content["menu5"]; ?></a>
				</div>
				<?php
									} else {
										?>
				<a tabindex="0" id="connexion" <?php if($page=='login'){echo 'class="active"';}?> href="login.php"><?php echo $content["menu6"]; ?></a>

										<?php
									};
				?>
				</div>
<!-- USER MENU FIN -->
			</div>
			<div class="menu">		
					<ul>
						<li tabindex="0">
							<a <?php if($page=='evenements'){echo 'class="active"';}?> href="evenements.php"><?php echo $content["evenements"]; ?></a>
						</li>
						<li tabindex="0">
							<a <?php if($page=='clubs'){echo 'class="active"';}?> href="clubs.php"><?php echo $content["agenda"]; ?></a>
						</li>
						<li tabindex="0">
							<a <?php if($page=='decouvrir'){echo 'class="active"';}?> href="decouvrir.php"><?php echo $content["decouvrir"]; ?></a>
						</li>
						<li tabindex="0">
							<a <?php if($page=='recherche'){echo 'class="active"';}?> href="recherche.php"><?php echo $content["recherche"]; ?></a>
						</li>
					</ul>
			</div>

		</div>
</div>