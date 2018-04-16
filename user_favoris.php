<?php
require_once('_config.php');
session_start();
include_once 'inc/langue.inc.php';
$page = "favoris";
	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["type"]) ) {
		header("Location: login.php");
	};
/*-----------------------CLUBS------------------------------*/
$query="SELECT club.id, club.name, images.url, favoris.page_id FROM favoris
LEFT JOIN club ON favoris.page_id=club.id
LEFT JOIN images ON images.club_id=club.id
WHERE favoris.user_id=".$_SESSION['id']."
AND favoris.page_type='club'
GROUP BY club.id
;";
$result = $pdo->prepare($query);
$result->execute();
$clubs = $result->fetchAll();
$count = $result->rowCount();

/*--------------------EVENTS---------------------------------*/
$query="SELECT event.id, event.titre_".$lang.", event.date, images.url, favoris.page_id FROM favoris
LEFT JOIN event ON favoris.page_id=event.id
LEFT JOIN images ON images.event_id=event.id
WHERE favoris.user_id=".$_SESSION['id']."
AND favoris.page_type='event'
GROUP BY event.id
ORDER BY event.date
;";
$result = $pdo->prepare($query);
$result->execute();
$events = $result->fetchAll();
$count1 = $result->rowCount();

/**************************************************************/

include '_head.php';

if ($count == 0 && $count1 == 0) { /* s'il n'y a pas encore des favoris*/?> 
<body class="bcg">
<?php include("header.php"); ?>

	<section class="fenetre" id="filter">
		<div class="row1">
			<h1><?php echo $content["menu3"]; ?></h1>
			<img class="heart" src="images/website/icons/heart-pleine.svg">
			<p><?php echo $content["pas_favoris"]; ?></p>
		</div>
<?php /* -------------------------------------- S'il y a déjà des favoris*/
} else { ?>
	<body>
		<?php include("header.php"); ?>

<section class="content clearfix">
	<h1><?php echo $content["menu3"]; ?></h1>
<?php
	foreach ($clubs as $key => $value) {
?>
	<div class="club_item" style="background-image: url('images/clubs/<?php echo $clubs[$key]['url'];?>');">
		<a href="club.php?id=<?php echo $clubs[$key]['page_id']; ?>">
			<div>
				<h3><?php echo $clubs[$key]['name']; ?></h3>
			</div>
		</a>
		<input type="checkbox" name="favori" value="favori" id="favori_club<?php echo $clubs[$key]['id']; ?>" checked onclick="addFavori(<?php echo $clubs[$key]['id']; ?>, 'club', true)">
		<label for="favori_club<?php echo $clubs[$key]['id']; ?>">
            <img src="images/website/icons/heart-pleine.svg" class="heart_icon" alt="supprimer le favori">          
        </label>
	</div>
<?php
	}

?>
</section>
<br>
<section class="content clearfix">
	<h2><?php echo $content["evenements"]; ?></h2>
<?php
	foreach ($events as $key => $value) {
?>
	<div class="club_item" style="background-image: url('images/events/<?php echo $events[$key]['url'];?>');">
		<a href="event.php?id=<?php echo $events[$key]['page_id']; ?>">
		<div>
			<h3><?php echo $events[$key]['titre_'.$lang]; ?></h3>
			<h4><?php echo $events[$key]['date']; ?></h4>
		</div>
	</a>
		<input type="checkbox" name="favori" value="favori" id="favori_event<?php echo $events[$key]['id']; ?>" checked onclick="addFavori(<?php echo $events[$key]['id']; ?>, 'event', true)">
		<label for="favori_event<?php echo $events[$key]['id']; ?>">
           	<img src="images/website/icons/heart-pleine.svg" class="heart_icon" alt="supprimer le favori">          
        </label>
	</div>
	
<?php
	}}

?>
	
</section>

	<?php include("pages/footer.php"); ?>


</body>
</html>