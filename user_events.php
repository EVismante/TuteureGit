<?php
require_once('_config.php');
session_start();
include_once 'inc/langue.inc.php';

$page = "user_events";
	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["type"]) ) {
		header("Location: login.php");
	};
/**************************************************************/

include '_head.php';

$query = 'SELECT event.id, event.titre_'.$lang.', images.url, event.date FROM event
LEFT JOIN images ON event.id=images.event_id
WHERE event.user_id='.$_SESSION["id"].'
GROUP BY event.id;';

$result = $pdo->prepare($query);
$result->execute();
$events = $result->fetchAll();
$count = $result->rowCount();

if ($count == 0) { /* s'il n'y a pas encore des évènements*/?> 
<body class="bcg">
<?php include("header.php"); ?>

	<section class="fenetre" id="filter">
		<div class="row1">
			<h1><?php echo $content["vos_evenements"]; ?></h1>
			<p><?php echo $content["pas_d_evenement"]; ?></p>
			<a class = "btn center" href="user_new_event.php"><?php echo $content["nouveau_evenement"]; ?></a>
		</div>
<?php /* --------------------- S'il y a déjà des évènements*/
} else { ?>
	<body>
<?php include("header.php"); ?>
		<section class="content">
		<h1><?php echo $content["vos_evenements"]; ?></h1>
		<div>
			<a class = "btn" href="user_new_event.php"><?php echo $content["nouveau_evenement"]; ?></a>
		</div>

<?php }

	foreach ($events as $key => $value) {
?>
	<div class="club_item" style="background-image: url('images/events/<?php echo $events[$key]['url'];?>');">
		<a href="event.php?id=<?php echo $events[$key]['id']; ?>&p=userevents">
		<div>
			<h3><?php echo $events[$key]['titre_'.$lang]; ?></h3>
			<span><?php echo $events[$key]['date']; ?></span><br><br>

			<form action="user_edit_event.php" method="POST">
				<input type="hidden" name="id" value="<?php echo $events[$key]['id']; ?>">
				<input type="submit" value="<?php echo $content["changer"]; ?>">
			</form>

			<form action="pages/Events/delete_event.php" method="POST">
				<input type="hidden" name="id" value="<?php echo $events[$key]['id']; ?>">
				<input type="hidden" name="page" value="user_events.php">
				<input type="submit" class="delete" value="<?php echo $content["supprimer"]; ?>">
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