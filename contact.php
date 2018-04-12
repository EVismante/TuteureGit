<?php
session_start();
require_once('_config.php');
include '_head.php';
include_once 'inc/langue.inc.php';
$page = "inscription";
?>
<script type="text/javascript" src="../js/inscription.js"></script>
</head>
<body>
    <?php include("header.php"); ?>
	<section class="forme">
    <h1>Contactez nous</h1>
    			<div class="edit_club" id="contact_form">
    				<div>
					<form action="pages/BackOffice/post.php" method="POST" id=contact_form>
	    				<input type="text" id="name" name="name"><br>
	    					<label for="name" id="namelabel">Nom</label>
	    					<span class='msg'>Nom non renseigné</span>
	    				<input type="text" id="mail" name="mail"><br>
	    					<label for="mail" id="maillabel">Adresse mail</label>
	    					<span class='msg'>Mail non valide</span>
	    				<textarea id="subject" name="subject" ></textarea><br>
	    					<label for="subject" id="subjectlabel">Message</label>
	    					<span class='msg'>Message est vide</span>
	    					<br/>
	    				<input type="submit" id="submit_contact" value="Envoyer">
	    				<input type="button" value="Annuler" id="annuler">
					</form>
				</div>
			</div>

   </section>
    <?php include("pages/footer.php"); ?>
</body>
</html>

