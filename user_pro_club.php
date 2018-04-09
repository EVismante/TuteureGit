<?php
require_once('_config.php');
session_start();
$page = "favoris";
	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["type"]) ) {
		header("Location: login.php");
	};
/**************************************************************/

include '_head.php';?>
<body>
<?php include("header.php"); ?>
/*-------------------------------*/
<?php

$query = 'SELECT club.id, club.name, images.url FROM club
LEFT JOIN images ON club.id=images.club_id
WHERE club.user_id='.$_SESSION["id"].'
GROUP BY club.id;';

$result = $pdo->prepare($query);
$result->execute();
$club = $result->fetchAll();
$count = $result->rowCount();

?>

	<section class="office">
		<h1>Votre préstation</h1>
		<br><br>

<?php
if ($count == 0) {
		echo "<p> Vous n'avez pas encore défini votre préstation !</p>";
		echo '<a class = "btn" href="user_new_club.php">Créer</a>';
		echo 'Si votre préstation existe déjà dans <a href="recherche.php">la liste</a>, écrivez nous un message.';
} else {
?>
		<div class="club_item" style="background-image: url('images/clubs/<?php echo $club['url'];?>');">
			<a href="club.php?id=<?php echo $club[0]['id']; ?>">
			<div>
				<h3><?php echo $club[0]['name']; ?></h3>
			</div>
		</a>
		</div>

<?php } ?>

	</section>
<?php include("pages/footer.php"); ?>
</body>
</html>
