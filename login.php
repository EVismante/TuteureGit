<?php
session_start();

require_once('_config.php');
include 'inc/login.inc.php';
include '_head.php';
$page = "login";

?>
</head>
<body>
	<?php include("header.php"); ?>
<section class="forme">
	<h1>Connexion</h1>
    <img class ="in_middle" src="images/website/1.svg" alt="">
    	<form class="edit_club" action="login-action.php" method="POST">
            <div>
                <div>
            		<input type="text" id="name" name="name">
                    <br/>
            		<label for="name">Nom</label>
                    <br/>
            		<input type="password" id="mdp" name="mdp">
                    <br/>
            		<label for="mdp">Mot de passe</label>
            		<br/>
                </div>
                <div class='msg1'>
                    Le mot de passe et/ou login sont pas valides.
                </div>
  <?php 
            if (isset($_GET["msg"]) && $_GET["msg"] == 'failed') {
                echo "<div class='msg'>Le mot de passe et/ou login sont pas valides.</div>";}; ?>
                
            		<input type="submit" value="LOGIN" id="submit_login">
            		<input type="button" onclick="location.href='../propos.php'" value="ANNULER">

 
        		 
            </div>         
                <a href="inscription.php">Pas encore membre?</a>
    	</form>

</section>
	<?php include("pages/footer.php"); ?>
</body>
</html>