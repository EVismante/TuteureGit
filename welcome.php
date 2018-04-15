<?php
session_start();
require_once('_config.php');
include '_head.php';
include_once 'inc/langue.inc.php';
$page = "login";

	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["type"]) ) {
		header("Location: login.php");
	};

?>
<script type="text/javascript" src="../js/inscription.js"></script>
</head>
<body>
    <?php include("header.php"); ?>
	<section class="forme">
    <h1>Bonjour !</h1>
    			<div class="edit_club clearfix">
    				<div class="larger">
    					<img src="images/website/3.png" alt="">
					<p>Congratulations for your first connection !</p>
					<div class="column3">
						Vous pouvez commencer par regarder des clubs. Et les mettre en favoris
						<a class= "btn" href="">Clubs</a>
					</div>
					<div class="column3">
						Organisez un évènement !
						<a class= "btn" href="">Organizer</a>
					</div>
					<div class="column3">
<?php if ($_SESSION["type"] == "pro") {
?>
						Créez une page pour votre préstation !
						<a class= "btn" href="">Créer</a>

<?php
} else {
?>
						else

<?php
}?>
					</div>
				</div>
			</div>

   </section>
    <?php include("pages/footer.php"); ?>
</body>
</html>