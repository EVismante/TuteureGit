<?php
require_once('_config.php');
session_start();
include_once 'inc/langue.inc.php';
	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["type"]) ) {
		header("Location: login.php");
	};


	if (isset($_GET["msg"]) && $_GET["msg"] =="failure_mdp" ) {
		$msg_mdp = "<div class='error_msg_show'>Le mot de passe n'est pas valide<div></div></div>";
	} else {
		$msg_mdp = NULL;
	};
include '_head.php';
$page ="user_compte";
?>
<body>
		<?php include("header.php"); ?>

	
	<section class="forme">
		<h1><?php echo $_SESSION["name"]; ?></h1>
		<img class="user_icon_big in_middle" src="images/avatars/<?php echo $_SESSION["avatar"]; ?>" alt="">

		<!-- l'image -->
		<div class="edit_club">

			<div id="input_images">
				<form action="pages/user/upload_action_avatar.php" method="POST" enctype="multipart/form-data">
					<h3>Modifier l'avatar</h3>

				<div id="msg_avatar" class="error_msg">Veuillez choisir une image à charger en cliquant sur l'icône<div></div></div>
<?php
if(isset($_GET["msg"])) {
	if ($_GET["msg"] == "fail1") {
				echo "<div class='error_msg_show'>L'image est trop grande ou de mauvais format<div></div></div>";
};} ?>	
            	<input type="hidden" name="MAX_FILE_SIZE" value="300000000" /> 
            	<input type="hidden" name="type" value="avatar" /> 
            	<input type="hidden" name="retour" value="user" />
            	<input id="file1" name="files[]" type="file" accept="image/*"/>


           		
<?php if ($_SESSION["avatar"] == "default.svg" OR $_SESSION["avatar"] == "default1.svg") { ?>
				
				<label for="file1" id="label_avatar" style="background-image: url('images/avatars/<?php echo $_SESSION["avatar"]; ?>')"></label> 
<?php } else { ?>
				<label for="file1" id="label_avatar"  style="background-image: url('images/avatars/<?php echo $_SESSION["avatar"]; ?>')"></label> 
<?php } ?>      		
            	<div>Les formats des images acceptés: JPEG, GIF, PNG. La taille maximale acceptée: 300 ko
            	</div>
            	<input name ="envoi" type="submit" id="changer_avatar" value="Envoyer" />	
    		</form>

    		<form action="pages/user/delete_avatar.php" method="GET">
				<input type="hidden" name="id" value="<?php echo $_SESSION["id"];?>">
				<input type="hidden" name="retour" value="user">
				<input type="submit" class="btn-empty" id="supprimer_avatar" value="<?php echo $content["supprimer"]; ?>">

			</form>
    	</div>
    </div>

		<form class="edit_club" method="POST" action="pages/user/change_mdp.php">
			<input type="hidden" name="retour" value="user">
			<div>
				<div>
					<h3>Changer le mot de passe</h3>
					<input type="hidden" name="id" value="<?php echo $_SESSION["id"]; ?>">
					<div><?php echo $msg_mdp; ?></div>
					<input type="password" id="mdp_old" name="mdp_old">
					<br>
		            <label for="mdp">L'ancien mot de passe</label>
		            <br>
		            <div id="msg_mdp" class="error_msg">Le mot de passe doit avoir au moins 5 charactéres<div></div></div>
					<input type="password" id="mdp" name="mdp">
					<br>
		            <label for="mdp">Changer le mot de passe</label>
		            <br>
		            <div id="msg_mdp1" class="error_msg">Les mots de passe ne sont pas identiques<div></div></div>
		            <input type="password" id="mdp1" name="mdp1">
		            <br>
		            <label for="mdp1">Mot de passe</label>
		            <br>
		            <input type="submit" value="Modifier" id="submit_mdp">
	        	</div>
	        </div>
         </form>

        <form class="edit_club" method="POST" action="pages/user/change_mail.php">
        	<div>
        		<div>
        			<h3>Changer l'adresse mail</h3>
        			<div id="msg_mail" class="error_msg">L'addresse mail n'est pas valide<div></div></div>
		            <input type="text" id="mail" name="mail">
		            <label for="mail">L'adresse mail</label>
		            <br>
		            <div id="msg_mail1" class="error_msg">Les addresses mail ne sont pas identiques<div></div></div>
		            <input type="text" id="mail1" name="mail1">
		            <br>
		            <input type="hidden" name="retour" value="user">
		            <input type="hidden" name="id" value="<?php echo $_SESSION["id"]; ?>">
		            <label for="mail">Repetez l'adresse mail</label>
		            <input type="submit" value="Modifier" id="submit_mail">
	        	</div>
	        </div>
		</form>

	<form class="edit_club" action="pages/user/delete_user.php" method="POST">
		<div>
			<div>
				<h3>Supprimer le compte</h3>
				<input type="hidden" name="id" value="<?php echo $_SESSION["id"];?>">
				<span class="btn center" id="del"><?php echo $content["supprimer"]; ?></span>
			</div>
		</div>
	</form>
</section>
				<div id="hide">
					<div>
							<p><?php echo $content["on_delete1"]." ".$content["votre_compte"]; ?> ?</p>
							<input type="submit" value="<?php echo $content["supprimer"]; ?>">
							<span class="btn-empty center" id="annuler"><?php echo $content["annuler"]; ?></span>
					</div>
				</div>

	<?php include("pages/footer.php"); ?>


</body>
</html>

