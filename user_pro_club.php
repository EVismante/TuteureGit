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

<?php
if ($count == 0) { ?>
		<section class="edit_club">
			<h1>Votre préstation</h1>
			<div>
				<p> Vous n'avez pas encore défini votre préstation ! <br> Si votre préstation existe déjà dans <a href="recherche.php">la liste</a>, écrivez nous un message. Sinon, créez une nouvelle page: </p>
					<a class = "btn" href="user_new_club.php">Créer</a>
			</div>
<?php
} else {

	$id = $club[0]['id'];

if ($club[0]['url'] == "") {
	$url="default.jpg";
} else { $url = $club[0]['url']; }



$query1 = "SELECT COUNT(*) FROM comment WHERE
page_type='club'
AND 
page_id=".$id.";";

$result1 = $pdo->prepare($query1);
$result1->execute();
$comments = $result1->fetchAll();

$query2 = "SELECT COUNT(*) FROM favoris WHERE
page_id=".$id.";";

$result2 = $pdo->prepare($query2);
$result2->execute();
$favoris = $result2->fetchAll();

?>		
		<div class="head_img" style="background-image: url('images/clubs/<?php echo $url;?>');"></div>
		<section class="edit_club">
			<div>
				<h2><?php echo $club[0]['name']; ?></h2>
				<a href="club.php?id=<?php echo $club[0]['id']; ?>">Visiter la page de <?php echo $club[0]['name']; ?></a>
				<br>
<?php include "inc/evaluation.inc.php"; /*évaluation de préstataire*/?>
				<br>
				<span>Commentaires (<?php echo $comments[0][0]; ?>)</span>
				<br>
				<span>Dans les favoris de <?php echo $favoris[0][0]; ?> personne(s)</span>
				<form action="user_edit_club.php" method="POST">
					<input type="hidden" name="id" value="<?php echo $club[0]['id']; ?>">
					<input type="submit" value="Changer">
				</form>
			</div>
			<div>
				<div>
					Supprimer la page de <?php echo $club[0]['name']; ?>
				</div>
				<form action="pages/BackOffice/delete_club.php" method="POST">
					<input type="hidden" name="id" value="<?php echo $club[0]['id']; ?>">
					<input type="hidden" name="page" value="user_pro_club.php">
					<input type="hidden" name="retour" value="user">
					<input type="submit" class="delete" value="Supprimer">
				</form>
			</div>


<?php } ?>

	</section>
<?php include("pages/footer.php"); ?>
</body>
</html>
