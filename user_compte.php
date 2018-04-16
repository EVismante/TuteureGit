<?php
require_once('_config.php');
session_start();
include_once 'inc/langue.inc.php';
	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["type"]) ) {
		header("Location: login.php");
	};

include '_head.php';
$page ="user_compte";
?>
<body>
		<?php include("header.php"); ?>

	
	<section>
		<h1><?php echo $_SESSION["name"]; ?></h1>
		<!-- l'image -->
		<div class="forme">
			<form action="pages/BackOffice/upload_action_avatar.php" method="POST" enctype="multipart/form-data">
				<label for="avatar" >
					<img class="user_icon_big" src="images/avatars/<?php echo $_SESSION["avatar"]; ?>">
				</label>
				<input id="avatar" name="userfile" type="file" />
            	<input type="hidden" name="MAX_FILE_SIZE" value="300000000" /> 
            	<input type="hidden" name="type" value="avatar" /> 
         
            	<input name ="envoi" type="submit" value="Envoyer le fichier" />
            
            <div id="error"><?php
	if(isset($_GET["msg"])) {
		if ($_GET["msg"] == "fail1") {
				echo "L'image est trop grande / mauvais format";
		} else { echo " Une erreur est survenue";}

} ?>
    		</form>
    	</div>
	</section>

	<section>
		<form class="edit_club" method="POST" action="pages/user/change_mdp.php">
			<div>
				<input type="hidden" name="id" value="<?php echo $_SESSION["id"]; ?>">
				<input type="password" id="mdp_old" name="mdp_old">
				<br>
	            <label for="mdp">L'ancien mot de passe</label>
	            <br>
				<input type="password" id="mdp" name="mdp">
				<br>
	            <label for="mdp">Changer le mot de passe</label>
	            <br>
	            <p id="msg_mdp">Le mot de passe doit avoir au moins 5 charactéres</p>
	            <br>
	            <input type="password" id="mdp1" name="mdp1">
	            <br>
	            <label for="mdp1">Mot de passe</label>
	            <br>
	            <p id="msg_mdp1">Les mots de passe ne sont pas identiques</p>
	            <br>
	            <input type="submit" value="Modifier" id="submit_mdp">
        	</div>
         </form>

        <form class="edit_club" method="POST" action="pages/user/change_mail.php">
        	<div>
	        	<input type="hidden" name="id" value="<?php echo $_SESSION["id"]; ?>">
	            <input type="text" id="mail" name="mail">
	            <label for="name">Mail</label>
	            <p id="msg_mail">L'addresse mail n'est pas valide</p>
	            <br>
	            <input type="text" id="mail1" name="mail1">
	            <label for="name">Mail</label>
	            <p id="msg_mail1">Les addresses mail ne sont pas identiques</p>
	            <input type="submit" value="Modifier" id="submit_mail">
        	</div>
		</form>
	</section>
	
</div>
<section>
	<form class="edit_club" action="pages/user/delete_user.php" method="POST">
		<div>
			Supprimer le compte
			<input type="hidden" name="id" value="<?php echo $_SESSION["id"];?>">
			<input type="submit" class="delete" value="Supprimer">
		</div>
	</form>
</section>

	<?php include("pages/footer.php"); ?>


</body>
</html>