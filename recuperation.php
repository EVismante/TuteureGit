<?php
session_start();

require_once('_config.php');
include 'inc/login.inc.php';
include_once 'inc/langue.inc.php';
include '_head.php';
$page = "login";
 
?>
</head>
<body>
	<?php include("header.php"); ?>
<section class="forme">
	<h1>Récuperation des données</h1>
    <img class ="in_middle" src="images/website/1.svg" alt="">
    	<form class="edit_club" action="" method="POST">
            <div>
                <div>
                	<p>Renseignez votre nom d'utilisateur et le mot de passe sera envoyé à l'adresse mail associée</p>
            		<input type="text" id="name" name="name">
                    <br/>
            		<label for="name">Nom d'utilisateur</label>
                    <br/>
                    <input type="submit" value="Envoyer" id="submit_nom">
                    <a class="btn-empty center" href="index.php"><?php echo $content['annuler']; ?></a>
                 </div>
 
        		 
            </div>         
              
    	</form>

</section>
	<?php include("pages/footer.php"); ?>
</body>
</html>