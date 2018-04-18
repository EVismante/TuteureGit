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

<!--- CONTACTS-->
		<div>
			<p><?php echo $clubInfo[0]['description_'.$lang]; ?></p>
		</div>
		<hr/>
		<div>
			<div>Lieu:  <?php echo $clubInfo[0]['address']; ?></div>
			<div>Mail: <?php echo $clubInfo[0]['mail']; ?></div>
			<div>Site web: <a href="<?php echo $clubInfo[0]['website']; ?>"><?php echo $clubInfo[0]['website']; ?></a></div>
		</div>
		<hr>
<!--- COMMENTAIRES-->
		<div class="comments">
<?php include("pages/comments/comment_event.php"); ?>
		</div>
	</div>

	<div class="right" id="diapo">
		<div>
			<img src="images/events/<?php echo $img[0]["url"]; ?>" alt="<?php echo $clubInfo[0]['titre_'.$lang]; ?>">
			<span class="btn_blue"><?php echo $content["voir_photos"]; ?></span>
		</div>
	</div>
</section>
<!-- diaporama modal -->
	<div id="diaporama">
		<span tabindex="0" id="fermer">&#x2716;</span>
		<div class="arrows">

<?php /*---fleches de la galerie ---*/
	if (count($img) > 1) { ?>
			<div tabindex="0" class="arrow_left"></div>	
			<div tabindex="0" class="arrow_right"></div>	
<?php	
	}
?>		</div>
		<div> <!-- galerie -->
			<?php
	foreach ($img as $key => $value) {
		if ($key == 0) {
			echo '<img class="slideshowactive" src="images/events/'.$value["url"].'" alt="'.$clubInfo[0]['titre_fr'].'">';
			echo "\n";
		} else {
			echo '<img src="images/events/'.$value["url"].'" alt="'.$clubInfo[0]['titre_fr'].'">';
			echo "\n";
		}}?>
		</div>
	</div>
<!-- fin de diaporama -->	
	<?php include("pages/footer.php"); ?>
</body>
</html>