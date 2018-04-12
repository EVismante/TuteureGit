<?php
require_once('_config.php');

session_start();

include_once 'inc/langue.inc.php';

include '_head.php';
$page = "event";
$id = $_GET["id"];

/*---fil d'Ariane--*/
if (isset($_GET["p"])) {

	if ($_GET["p"] == "events") {
		$retour = "evenements.php";
		$retour_text = $content['revenir_evenements']; 
	}
	else if($_GET["p"] == "recherche") {
		$retour = "recherche.php";
		$retour_text = $content['revenir_recherche'];
	} else if($_GET["p"] == "userevents") {
		$retour = "user_events.php";
		$retour_text = $content['revenir_evenements'];
	}
} else {
	$retour = "index.php";
	$retour_text = $content['revenir_index'];
}
/*-----*/

$clubQuery = 'SELECT * FROM event WHERE id = '.$id.';';
$result = $pdo->prepare($clubQuery);
$result->execute();
$clubInfo = $result->fetchAll();


/*IMAGES*/
$imgQuery = 'SELECT url FROM images 
			WHERE event_id='.$id.';';

$result = $pdo->prepare($imgQuery);
$result->execute();
$img = $result->fetchAll();

/*----------favoris--------------*/
if (isset($_SESSION["id"])) {

/*FAVORIS*/
$favquery = 'SELECT * FROM favoris
WHERE user_id= '.$_SESSION["id"].'
AND page_id= '.$id.'
AND page_type="'.$page.'"
;';

$result1 = $pdo->prepare($favquery);
$result1->execute();
$result1->fetchAll();
$fav = $result1->rowCount();

}
?>
</head>
<body>
<?php include("header.php"); ?>
	<section class="content">
		
	<!-- fil d'ariane -->
		<a class="revenir" href="<?php echo $retour; ?>">
		<?php echo $retour_text; ?>
		</a>
	<!-- fil d'ariane -->
		<div>
			<h1><?php echo $clubInfo[0]['titre_'.$lang]; ?></h1>
			<h4><?php echo $clubInfo[0]['date']; ?></h4>
			<div class="left">
			<hr/>
<?php 
/*--------FAVORI CHECKBOX-------------*/
	if (isset($_SESSION["id"])) { ?>
			<span>
				<input type="checkbox" name="favori" value="favori" id="favori_club<?php echo $id; ?>" <?php if($fav > 0) {echo "checked";} ?> onclick="addFavori(<?php echo $id; ?>, 'club', false)">
				<label for="favori_club<?php echo $id; ?>">
					<?php if($fav > 0) { ?>
				<img src="images/website/icons/heart-pleine.svg" class="heart_icon" alt="supprimer le favori">
<?php					} else { ?>
						<img src="images/website/icons/heart-vide.svg" class="heart_icon" alt="ajouter aux favoris">
<?php }?>
				</label>
			</span>
<?php
} /*----------FIN DE CHECKBOX-------------*/			
?>

		<div>
			<p><?php echo $clubInfo[0]['description_'.$lang]; ?></p>
		</div>
		<hr/>
		<div>
			<div><?php echo $clubInfo[0]['address']; ?></div>
			<div><?php echo $clubInfo[0]['mail']; ?></div>
			<div><?php echo $clubInfo[0]['website']; ?></div>
		</div>
		<hr>
		<div class="comments">
<?php include("pages/comments/comment_event.php"); ?>
		</div>
	</div>

	<div class="right">

<?php
foreach ($img as $key => $value) {
?>
		<img src="images/events/<?php echo $value["url"]; ?>" alt="<?php echo $clubInfo[0]['name']; ?>">
<?php
}

?>	
	</div>
	</section>
	<?php include("pages/footer.php"); ?>
</body>
</html>