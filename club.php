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
$tag2Count = $result->rowCount();

/*TYPE TAGS*/
$tagQuery2 = 'SELECT name_'.$lang.' FROM tag 
LEFT JOIN club_tag ON tag.id=club_tag.tag_id
WHERE club_tag.club_id='.$id.'
AND tag.type=2;';

$result = $pdo->prepare($tagQuery2);
$result->execute();
$tag2 = $result->fetchAll();


/*TYPE TAGS*/
$tagQuery3 = 'SELECT name_'.$lang.' FROM tag 
LEFT JOIN club_tag ON tag.id=club_tag.tag_id
WHERE club_tag.club_id='.$id.'
AND tag.type=3;';

$result = $pdo->prepare($tagQuery3);
$result->execute();
$tag3 = $result->fetchAll();
$tag3Count = $result->rowCount();

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

$query1 = "SELECT COUNT(*) FROM comment WHERE
page_type='club'
AND 
page_id=".$id.";";

$result1 = $pdo->prepare($query1);
$result1->execute();
$comments_count = $result1->fetchAll();

/*--- les images ---*/
if (isset($img[0]["url"])) {
	$img_url = $img[0]["url"];
	$diapo = true;
} else {
	$img_url = "default.jpg";
	$diapo = false;
}

?>
<!--metadata pour facebook -->
<meta property="og:url" content="https://www.equovadis.fr/club.php?id=<?php echo $id; ?>" />
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo $clubInfo[0]['name']; ?>" />
<meta property="og:description" content="<?php echo $clubInfo[0]['description_'.$lang]; ?>" />
<meta property="og:image" content="images/clubs/<?php echo $img_url; ?>" />

<script>
 function initMap() {
        
        var club_lat = document.getElementById("lat").getAttribute("class");
        var club_longt = document.getElementById("longt").getAttribute("class");
        var myLatLng = {lat: club_lat, lng: club_longt};

        var map = new google.maps.Map(document.getElementById('map_small'), {
          zoom: 12,
          mapTypeControl: false,
          streetViewControl: false,
          fullscreenControl: false,
          center: new google.maps.LatLng(club_lat, club_longt),

        });	

       var marker = new google.maps.Marker({
          position: new google.maps.LatLng(club_lat, club_longt),
          map: map,
          icon: 'images/website/icons/club.png',

        });

    }
</script>

</head>
<body>
<?php 

include("header.php"); 
include 'inc/barre_admin.inc.php';

?>
<div id="fb-root"></div>
<script>

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.12';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>

	<section class="content_club clearfix">
<!--- IMAGE de diaporama-->

		<div id="diapo">
			<div id="diapo0">
				<div class="head_img_club" style="background-image: url('images/clubs/<?php echo $img_url; ?>');"></div>
<?php if ($diapo) { ?>
				<span><?php echo $content["voir_photos"]; ?></span>	
<?php } ?>
			</div>
		</div>

<!--- LEFT-->

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
			<hr/>
			<div>

			<!-- bouton de facebook -->
			<div class="fb-share-button" data-href="https://equovadis.fr/club.php?id=<?php echo $id;?>" data-layout="button" data-size="large" data-mobile-iframe="true">
				<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fequovadis.fr%2Fclub.php?id=<?php echo $id;?>&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"><?php echo $content['partager']; ?></a>
			</div>				
<?php 
/*--------FAVORI CHECKBOX-------------*/
		if (isset($_SESSION["id"])) { ?>
				<span>
					<input type="checkbox" name="favori" value="favori" id="favori_club<?php echo $id; ?>" <?php if($fav > 0) {echo "checked";} ?> onclick="addFavori(<?php echo $id; ?>, 'club', false)">
					<label for="favori_club<?php echo $id; ?>">
						<?php if($fav > 0) { ?>
					<img src="images/website/icons/heart-pleine.svg" class="heart_icon" title="supprimer le favori" alt="supprimer le favori">
	<?php					} else { ?>
							<img src="images/website/icons/heart-vide.svg" class="heart_icon" title="ajouter aux favoris" alt="ajouter aux favoris">
	<?php }?>
					</label>
				</span>
			</div>
<?php
} /*----------FIN DE CHECKBOX-------------*/			
?>
			<!-- évaluation de préstataire -->
			<span>
				<?php include "inc/evaluation.inc.php";?>
			</span>
			<br>
			<!-- lien vers commentaires -->
			<a href="#comments"><?php echo $content['commentaires']." (".$comments_count[0][0]; ?>)</a>

		<div>
			<p><?php echo $clubInfo[0]['description_'.$lang]; ?></p>
		</div>
		<hr>
<!--- ACTIVITES-->
			<div class="bordered">
<?php if($tag2Count > 0) {echo "<h3>".$content['activites']."</h3>"; }  //affichage de titre ?>

				<ul><?php
				foreach ($tagInfo as $key => $value) {
					echo '<li>'; 
					echo $tagInfo[$key]['name_'.$lang];
					echo '</li>';
				}
				?>
				</ul>
			</div>
			<div class="bordered">
<?php if($tag3Count > 0) {echo "<h3> ".$content['bon_a_savoir']." </h3>"; }  //affichage de titre ?>

				<ul><?php
				foreach ($tag3 as $key => $value) {
					echo '<li>'; 
					echo $tag3[$key]['name_'.$lang];
					echo '</li>';
				}
				?>
				</ul>
			</div>
			<hr>
<!--- CONTACTS-->
			<div class="bordered">
				<div>
					<h3><?php echo $content["contacter"]; ?></h3>

					<div>
						<h4><?php echo $content["adresse"]; ?></h4> 
						<?php echo $clubInfo[0]['address']; ?>
					</div>

	<?php if (strlen($clubInfo[0]['website']) > 0 ) { ?>

						<div>
						<h4><?php echo $content["website"]; ?></h4> 
						<a href="<?php echo $clubInfo[0]['website']; ?>"><?php echo $clubInfo[0]['website']; ?></a>
						</div>

	<?php } 
	if (strlen($clubInfo[0]['telephone']) > 0 ) {?>

					<div>
						<h4><?php echo $content["phone"]; ?></h4>
						<?php echo $clubInfo[0]['telephone']; ?>
					</div>

	<?php }; if (strlen($clubInfo[0]['mail']) > 0 ) { ?>

					<div>
						<h4>Mail</h4>
						<a href="mailto: <?php echo $clubInfo[0]['mail']; ?>"><?php echo $clubInfo[0]['mail']; ?></a>
					</div>
	<?php } ?>
				</div>
			</div>
					<div class="bordered" id="map_small"></div>
				
			<hr>
<!--- COMMENTAIRES-->
			<div class="comments" id="comments">
				<h3><?php echo $content["commentaires"]; ?></h3>
				<?php include("pages/comments/comment_club.php"); ?>
			</div>


<!--- DIAPORAMA GALERIE DES IMAGES-->
	</section>

<?php if($diapo) { ?>

	<div id="diaporama">
		<span tabindex="0" id="fermer">&#x2716;</span>
		<div class="arrows">
}
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

<?php } ?>
<span id="lat" class="<?php echo $clubInfo[0]['lat']; ?>">
<span id="longt" class="<?php echo $clubInfo[0]['longt']; ?>">
	<?php include("pages/footer.php"); ?>
</body>
</html>