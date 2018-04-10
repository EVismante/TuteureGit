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

$query = 'SELECT event.id, event.titre_FR, images.url, event.date FROM event
LEFT JOIN images ON event.id=images.event_id
WHERE event.user_id='.$_SESSION["id"].'
GROUP BY event.id;';

$result = $pdo->prepare($query);
$result->execute();
$events = $result->fetchAll();
$count = $result->rowCount();

?>


	<section class="office clearfix">
		<h1>Vos évènements</h1>
		<br><br>
		<a class = "btn" href="user_new_event.php">Nouveau évènement</a>

<?php
if ($count == 0) {
	echo "<p> Vous n'avez pas d'évènements. Créez un nouveau !</p>";
}

	foreach ($events as $key => $value) {
?>
	<div class="club_item" style="background-image: url('images/events/<?php echo $events[$key]['url'];?>');">
		<a href="event.php?id=<?php echo $events[$key]['id']; ?>&p=userevents">
		<div>
			<h3><?php echo $events[$key]['titre_FR']; ?></h3>
			<h4><?php echo $events[$key]['date']; ?></h4>

		<form action="user_edit_event.php" method="POST">
			<input type="hidden" name="id" value="<?php echo $events[$key]['id']; ?>">
			<input type="submit" value="Changer">
		</form>

		<form action="pages/Events/delete_event.php" method="POST">
			<input type="hidden" name="id" value="<?php echo $events[$key]['id']; ?>">
			<input type="hidden" name="page" value="user_events.php">
			<input type="submit" class="delete" value="Supprimer">
		</form>
		</div>
	</a>
	</div>
	
<?php
	}

?>

	</section>
<?php include("pages/footer.php"); ?>
</body>
</html>