<?php
session_start();
require_once('_config.php');
include_once 'inc/langue.inc.php';
include '_head.php';
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
<section class="content">
        <h1>Bonjour !</h1>
	<div class="row">
		<div class="col-3">
			<a href="recherche.php">
				<img src="images/website/2.svg" alt="">
				<span>Cherchez les clubs et prestations et ajoutez-les dans vos favoris</span>
			</a>
		</div>
		<div class="col-3">
			<a href="user_events.php">
				<img src="images/website/1.svg" alt="">
				<span>Organisez votre premier évènement</span>
			</a>
		</div>
		<div class="col-3">
<?php if ($_SESSION["type"] == "pro") {
?>
				<a href="user_pro_club.php">
				<img src="images/website/3.svg" alt="">
				<span>Créez une page pour votre prestation</span>

<?php
} else {
?>
				<a href="user_compte.php">
				<img src="images/website/1.svg" alt="">
				<span>Choisissez un avatar qui vous représente !</span>

<?php
}?>

			</a>
		</div>
	</div>
</section>
    <?php include("pages/footer.php"); ?>
</body>
</html>