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
<?php include("header.php"); 
include 'inc/barre_admin.inc.php';
?>
	<section class="content_club clearfix">

		<div id="diapo">
			<div id="diapo0">
				<div class="head_img_club" style="background-image: url('images/events/<?php echo $img[0]["url"]; ?>');"></div>
				<span><?php echo $content["voir_photos"]; ?></span>
			</div>
		</div>
		<div class="left">
	<!-- fil d'ariane -->
			<a class="revenir" href="<?php echo $retour; ?>">
				<?php echo $retour_text; ?>
			</a>
	<!-- fil d'ariane -->
		
			<h1><?php echo $clubInfo[0]['titre_'.$lang]; ?></h1>
			<hr/>
			<div>
				<span class="bigger">Date: <?php echo $clubInfo[0]['date']; ?></span>

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
?> </div>


<!--- CONTACTS-->
		<div>
			<p><?php echo $clubInfo[0]['description_'.$lang]; ?></p>
		</div>
		<hr/>
		<div class="bordered">
				<div>
					<h4>Lieu</h4> 
					<?php echo $clubInfo[0]['address']; ?>
				</div>

<?php if (strlen($clubInfo[0]['mail']) > 0 ) { ?>

					<div>
					<h4>Mail</h4> 
					<a href="mailto: <?php echo $clubInfo[0]['mail']; ?>"><?php echo $clubInfo[0]['mail']; ?></a>
					</div>

<?php } 
if (strlen($clubInfo[0]['website']) > 0 ) {?>

				<div>
					<h4>Site Web</h4>
					<a href="<?php echo $clubInfo[0]['website']; ?>"><?php echo $clubInfo[0]['website']; ?></a>
				</div>

<?php } ?>

		</div>
		<div class="bordered" id="map_small"></div>
		<span id="lat" class="<?php echo $clubInfo[0]['lat']; ?>">
		<span id="longt" class="<?php echo $clubInfo[0]['longt']; ?>">
		<hr>
<!--- COMMENTAIRES-->
		<div class="comments">
<?php include("pages/comments/comment_event.php"); ?>
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