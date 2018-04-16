<?php
session_start();
require_once('_config.php');
include_once 'inc/langue.inc.php';
include '_head.php';
$page = "contact";
?>

</head>
<body>
    <?php include("header.php"); ?>
	<section class="forme">
    <h1>Contactez nous</h1>
					<form class="edit_club" action="pages/BackOffice/post.php" method="POST">
						<div>
    						<div>
							<div id="msg_name" class="error_msg"><?php echo $content['nom_vide']; ?><div></div></div>
		    				<input type="text" id="name" name="name"><br>
		    				<label for="name">* <?php echo $content['nom']; ?></label><br>

		    				<div id="msg_mail" class="error_msg"><?php echo $content['mail_non_valide']; ?><div></div></div>
		    				<input type="text" id="mail" name="mail"><br>
		    				<label for="mail">* <?php echo $content['mail']; ?></label><br>

		    				<div id="msg_subject" class="error_msg"><?php echo $content['message_vide']; ?><div></div></div>
		    				<textarea id="subject" name="subject" ></textarea><br>
		    				<label for="subject">* Message</label>
		    					<br/>
		    				<p><?php echo $content["champs"]; ?></p>
		    				<input type="submit" id="submit_contact" value="<?php echo $content['envoyer']; ?>">
		    				<a class="btn-empty center" href="index.php"><?php echo $content['annuler']; ?></a>
	    				</div>
					</div>
			</form>
<?php if (isset($_GET["msg"])) { ?>
	
			<div id="msg_success">
				<div>
				Merci ! Votre message a bien été envoyé ! 
				<br><br>
				Fermer
				</div>
			</div>
<?php } ?>
   </section>
    <?php include("pages/footer.php"); ?>
</body>
</html>

