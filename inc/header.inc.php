<div>

<?php 
					if ( isset($_SESSION["name"])) {
						$avatar = "images/avatars/".$_SESSION["avatar"];
?>

	<img src="<?php echo $avatar; ?>" alt="avatar" id='user_icon' tabindex="5">					
<div class="user_menu">
<div class="menu_deco"></div> <!-- petite fleche déco-->
<div id='username'><?php echo $_SESSION['name']; ?></div>

<?php
						if ($_SESSION["type"] == "normal") {
							}
						if ($_SESSION["type"] == "admin") {
?>
	<a tabindex="6" href="pages/admin_office.php">BACK OFFICE</a>
<?php
							}
						if ($_SESSION["type"] == "pro") {
?>
	<a tabindex="7" href="user_pro_club.php">MON CLUB</a>
<?php
							}
?>
	<a tabindex="8" href="user_favoris.php">FAVORIS</a>
	<a tabindex="9" href="user_compte.php">MON COMPTE</a>
	<a tabindex="10" href="pages/logout.php">Déconnecter</a>
</div>
<?php
					} else {
						?>
<a tabindex="11" id="connexion" <?php if($page=='login'){echo 'class="active"';}?> href="login.php">Connexion</a>

						<?php
					};
?>
</div>