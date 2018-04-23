<?php
require_once('_config.php');
session_start();
include_once 'inc/langue.inc.php';
$page = "user_pro_club";

	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["type"]) ) {
		header("Location: login.php");
	};

$id = $_GET["id"];


$query = 'SELECT * FROM club WHERE id='.$id.';';
$result = $pdo->prepare($query);
$result->execute();
$club = $result->fetchAll();

$query = "SELECT id, url FROM images WHERE club_id =".$id.";";
$r = $pdo->prepare($query);
$r->execute();
$imgs = $r->fetchAll();
$count = $r->rowCount();
$count_freespace = 3 - $count;



/*________filtres_______________*/

$query1 = 'SELECT DISTINCT tag.id FROM tag 
LEFT JOIN club_tag ON tag.id=club_tag.tag_id
WHERE club_tag.club_id='.$id.';';

	$result = $pdo->prepare($query1);
	$result->execute();
	$checked = $result->fetchAll();

	$checked_array = []; /*resultats de tous les tags sélectionnés*/
	foreach ($checked as $key => $value) {
		array_push($checked_array, $value["id"]);
	};


function filtre($pdo, $x, $array, $lang)
  {
    $stmt = $pdo->prepare("SELECT id, name_".$lang." FROM tag WHERE type = $x;");
    $stmt->execute();  
    $filtres = $stmt->fetchAll();

				foreach ($filtres as $key => $value) {?>

<input type="checkbox" name="filtre[]" value="<?php echo $value["id"]; ?>"
<?php if (in_array($value["id"], $array)) {
	echo "checked";
} ?>
>
<label for="filtre[]"><?php echo $value["name_".$lang]; ?></label>
<?php echo "<br>";
				}};



/* start of HTML _________*/

include '_head.php';
?>
<!-- pour l'adresse -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDd9slKoG41gF1xM8xr_LoEGCxnWrZejoY&libraries=places&callback=initAutocomplete"
        async defer></script>
 <script src="pages/BackOffice/autocomplete.js"></script>
</head>
<body>

<?php include("header.php"); ?>

	<section class="forme">		
		<a href="user_pro_club.php"><?php echo $content["revenir_page"]; ?></a>
		<h1><?php echo $content['editer']." ".$club[0]['name']?></h1>
			<form id="formulaire" class="edit_club" action="pages/BackOffice/edit_club_action.php" method="POST" enctype="multipart/form-data">
			<div>
				<div class="hide active">
						<div class="submenu">
							<span class="current"><?php echo $content["desc_fr"]; ?></span>
							<div class="arrow-right"></div>
							<span><?php echo $content["desc_en"]; ?></span>
							<div class="arrow-right"></div>
							<span><?php echo $content["filtres"]; ?></span>
							<div class="arrow-right"></div>
							<span>Info</span>
							<div class="arrow-right"></div>
							<span>Images</span>
						</div>
					<div class="error_msg"><?php echo $content["error_titre"]; ?><div></div></div>
					<input type="text" name="name" id="name" value="<?php echo $club[0]['name']?>">
					<br>
					<label for="name">* <?php echo $content["titre_en_fr"]; ?></label>
					<br>
					<textarea rows="4" cols="50" id="description_FR" name="description_FR" ><?php echo $club[0]['description_fr']?></textarea>
					<br>
					<label for="description_FR"><?php echo $content["desc_en_fr"]; ?></label>
					<br><br>
					<span><em><?php echo $content["champs"]; ?></em></span>
				</div>

				<div class="hide">
					<div class="submenu">
							<span><?php echo $content["desc_fr"]; ?></span>
							<div class="arrow-right"></div>
							<span class="current"><?php echo $content["desc_en"]; ?></span>
							<div class="arrow-right"></div>
							<span><?php echo $content["filtres"]; ?></span>
							<div class="arrow-right"></div>
							<span>Info</span>
							<div class="arrow-right"></div>
							<span>Images</span>
						</div>
					<div class="error_msg"><?php echo $content["error_titre"]; ?><div></div></div>
					<input type="text" name="name_en" id="name_en" value="<?php echo $club[0]['name_en']?>">
					<br>
					<label for="name_en">* <?php echo $content["titre_en_en"]; ?></label>
					<textarea name="description_EN" id="description_EN"><?php echo $club[0]['description_en']?></textarea>
					<br>
					<label for="description_EN" id="EN"><?php echo $content["desc_en_en"]; ?></label>
					<br><br>
				</div>

				<div class="hide">
					<div class="submenu">
							<span><?php echo $content["desc_fr"]; ?></span>
							<div class="arrow-right"></div>
							<span><?php echo $content["desc_en"]; ?></span>
							<div class="arrow-right"></div>
							<span class="current"><?php echo $content["filtres"]; ?></span>
							<div class="arrow-right"></div>
							<span>Info</span>
							<div class="arrow-right"></div>
							<span>Images</span>
						</div>
					<div class="filtres">
						<h4><?php echo $content["activite"]; ?></h4>
						<?php filtre($pdo, 1, $checked_array, $lang); ?>
					</div>
					<div>
						<h4><?php echo $content["type"]; ?></h4>
						<?php filtre($pdo, 2, $checked_array, $lang); ?>
					</div>
					<div>
						<h4><?php echo $content["autre"]; ?></h4>
						<?php filtre($pdo, 3, $checked_array, $lang); ?>
					</div>
				</div>


<!-- -->
				<div class="hide">
						<div class="submenu">
							<span><?php echo $content["desc_fr"]; ?></span>
							<div class="arrow-right"></div>
							<span><?php echo $content["desc_en"]; ?></span>
							<div class="arrow-right"></div>
							<span><?php echo $content["filtres"]; ?></span>
							<div class="arrow-right"></div>
							<span class="current">Info</span>
							<div class="arrow-right"></div>
							<span>Images</span>
						</div>
					<input type="text" name="telephone" id="telephone" value="<?php echo $club[0]['telephone']?>">
					<br>
					<label for="phone"><?php echo $content["phone"]; ?></label>
					<br>
					<input type="text" name="site_web" id="site_web" value="<?php echo $club[0]['website']?>">
					<br>
					<label for="site_web"><?php echo $content["website"]; ?></label>
					<br>
					<input type="text" name="mail" id="mail" value="<?php echo $club[0]['mail']?>">
					<br>
					<label for="mail"><?php echo $content["mail"]; ?></label>
					<br>
					<div class="error_msg"><?php echo $content["error_adresse"]; ?><div></div></div>
					<input type="text" name="address" id="autocomplete" value="<?php echo $club[0]['address']?>">
					<br>
					<label for="autocomplete">* <?php echo $content["adresse"]; ?></label>
					<br>
					<input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
					<input type="hidden" name="retour" value="user">
				</div>

				<div class="hide" id="input_images">
						<div class="submenu">
							<span><?php echo $content["desc_fr"]; ?></span>
							<div class="arrow-right"></div>
							<span><?php echo $content["desc_en"]; ?></span>
							<div class="arrow-right"></div>
							<span>Info</span>
							<div class="arrow-right"></div>
							<span class="current">Images</span>
						</div>
					<input type="hidden" name="MAX_FILE_SIZE" value="300000000" /> 
					<h4>Images</h4>
					<p>Les formats d'images acceptés: JPEG, PNG, GIF.</p>	
<?php
	foreach ($imgs as $key => $value) {
	?>				
					<div>
						<input name="files[]" id="file<?php echo $key; ?>" type="file" accept="image/*"/> 
						<input class = "image_checkbox" type="checkbox" name="delete_img[]" value="<?php echo $value['id']; ?>">
	           			<label for="file<?php echo $key; ?>" class="on_delete"  style="background-image: url('images/clubs/<?php echo $value['url']; ?>'); ">
	           			 	<span></span>
	           			</label>
	           		</div>

	<?php
	}

	for ($i=3; $i > $count ; $i--) { 
	?>
				<input name="files[]" id="file<?php echo $i; ?>" type="file" accept="image/*" />
				<label for="file<?php echo $i; ?>"><span class="arrow_up"></span></label>

	<?php
	}
	?>
				</div>
				<div class="clearfix">
					<a class ="btn_float_empty" href="user_pro_club.php"><?php echo $content["annuler"]; ?></a>
					<span class="btn_float inactive" id="previous"><?php echo $content["precedent"]; ?></span>
					<span class="btn_float" id="next"><?php echo $content["suivant"]; ?></span>

					<input type="hidden" name="id" value="<?php echo $_GET['id']?>">
					<input type="submit" name="submit" id="submit_new_event" class="btn_float" value="<?php echo $content["envoyer"]; ?>">
					<p id="error_msg"><?php echo $content["error_form"]; ?></p>
					</div>
				</div>
			</form>
			
	</section>
	<?php include("pages/footer.php"); ?>
</body>
</html>


