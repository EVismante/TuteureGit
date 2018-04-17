<?php
require_once('_config.php');

session_start();

include_once 'inc/langue.inc.php';

include '_head.php';
$page = "club";
$id = $_GET["id"]; /*id de la page*/

/*---fil d'Ariane--*/
if (isset($_GET["p"])) {

	if ($_GET["p"] == "clubs") {
		$retour = "clubs.php";
		$retour_text = $content['revenir_liste'];
	}
	else if($_GET["p"] == "recherche") {
		$retour = "recherche.php";
		$retour_text = $content['revenir_recherche'];
	} else {
		$retour = "index.php";
		$retour_text = $content['revenir_index'];
	}
} else {
	$retour = "index.php";
	$retour_text = $content['revenir_index'];
}
/*-----*/
$clubQuery = 'SELECT * FROM club WHERE id = '.$id.';';
$result = $pdo->prepare($clubQuery);
$result->execute();
$clubInfo = $result->fetchAll();

/*ACTIVITE TAGS*/
$tagQuery1 = 'SELECT name_'.$lang.' FROM tag 
LEFT JOIN club_tag ON tag.id=club_tag.tag_id
WHERE club_tag.club_id='.$id.'
AND tag.type=1;';

$result = $pdo->prepare($tagQuery1);
$result->execute();
$tagInfo = $result->fetchAll();

/*TYPE TAGS*/
$tagQuery2 = 'SELECT name_'.$lang.' FROM tag 
LEFT JOIN club_tag ON tag.id=club_tag.tag_id
WHERE club_tag.club_id='.$id.'
AND tag.type=2;';

$result = $pdo->prepare($tagQuery2);
$result->execute();
$tag2 = $result->fetchAll();

/*IMAGES*/
$imgQuery = 'SELECT url FROM images 
			WHERE club_id='.$id.';';

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
			<h1><?php echo $clubInfo[0]['name']; ?></h1>
		<!-- les tags / type de prestation -->
			<h4>
<?php
			foreach ($tag2 as $key => $value) {
				if ($key > 0) { echo " / ";};
				echo $tag2[$key]['name_'.$lang];
			}
?>
			</h4>
		<div class="left">
			<hr/>
			<span>
<?php include "inc/evaluation.inc.php"; /*évaluation de préstataire*/?>
			</span>
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
		<hr>
<!--- ACTIVITES-->
			<div class="bordered">
				<h3><?php echo $content["activites"]; ?></h3>
				<ul><?php
				foreach ($tagInfo as $key => $value) {
					echo '<li>'; 
					echo $tagInfo[$key]['name_'.$lang];
					echo '</li>';
				}
				?>
				</ul>
			</div>
			<hr>
<!--- CONTACTS-->
			<div class="bordered">

				<h4><?php echo $content["contacter"]; ?></h4>

				<span>Adresse: <?php echo $clubInfo[0]['address']; ?></span><br/>
				<span>Site web: <a href="<?php echo $clubInfo[0]['website']; ?>"><?php echo $clubInfo[0]['website']; ?></a></span><br/>
				<span>Telephone: <?php echo $clubInfo[0]['telephone']; ?></span><br/>
				<span>Mail: <?php echo $clubInfo[0]['mail']; ?></span><br/>
			</div>
			<hr>
<!--- COMMENTAIRES-->
			<div class="comments">
				<h4><?php echo $content["commentaires"]; ?></h4>
				<?php include("pages/comments/comment_club.php"); ?>
			</div>
		</div>
<!--- DIAPORAMA GALERIE DES IMAGES-->
		<div class="right" id="diapo">
			<div>
				<img src="images/clubs/<?php echo $img[0]["url"]; ?>" alt="<?php echo $clubInfo[0]['name']; ?>">
				<span class="btn_blue"><?php echo $content["voir_photos"]; ?></span>	
			</div>
		</div>

	</section>
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
			echo '<img class="slideshowactive" src="images/clubs/'.$value["url"].'" alt="'.$clubInfo[0]['name'].'">';
			echo "\n";
		} else {
			echo '<img src="images/clubs/'.$value["url"].'" alt="'.$clubInfo[0]['name'].'">';
			echo "\n";
		}}?>
		</div>
	</div>
	<?php include("pages/footer.php"); ?>
</body>
</html>