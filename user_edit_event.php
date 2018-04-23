<?php
require_once('_config.php');
session_start();
include_once 'inc/langue.inc.php';

	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["type"]) ) {
		header("Location: login.php");
	};

$page ="user_events";
$id = $_POST["id"];


$query = 'SELECT * FROM event WHERE id='.$id.';';
$result = $pdo->prepare($query);
$result->execute();
$event = $result->fetchAll();

$query = "SELECT id, url FROM images WHERE event_id =".$id.";";
$r = $pdo->prepare($query);
$r->execute();
$imgs = $r->fetchAll();
$count = $r->rowCount();
$count_freespace = 3 - $count;
/**************************************************************/

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
		<a href="user_events.php"><?php echo $content["revenir_evenements"]; ?></a>
		<h1>Éditer <?php echo $event[0]['titre_fr']?></h1>
		<form id="formulaire" class="edit_club" action="pages/Events/edit_event_action.php" method="POST" enctype="multipart/form-data">
			<div>
				<div class="hide active">
						<div class="submenu">
							<span class="current"><?php echo $content["desc_fr"]; ?></span>
							<div class="arrow-right"></div>
							<span><?php echo $content["desc_en"]; ?></span>
							<div class="arrow-right"></div>
							<span>Info</span>
							<div class="arrow-right"></div>
							<span>Images</span>
						</div>
					<div class="error_msg"><?php echo $content["error_titre"]; ?><div></div></div>
					<input type="text" name="name_fr" id="name_fr" value="<?php echo $event[0]['titre_fr']?>">
					<br>
					<label for="name_fr">* <?php echo $content["titre_en_fr"]; ?></label>
					<br>
					<textarea rows="4" cols="50" id="description_FR" name="description_FR" >
						<?php echo $event[0]['description_fr']?>
					</textarea>
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
							<span>Info</span>
							<div class="arrow-right"></div>
							<span>Images</span>
						</div>
					<div class="error_msg"><?php echo $content["error_titre"]; ?><div></div></div>
					<input type="text" name="name_en" id="name_en" value="<?php echo $event[0]['titre_en']?>">
					<br>
					<label for="name_en">* <?php echo $content["titre_en_en"]; ?></label>
					<br>
					<textarea name="description_EN" id="description_EN"><?php echo $event[0]['description_en']?></textarea>
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
							<span class="current">Info</span>
							<div class="arrow-right"></div>
							<span>Images</span>
						</div>
					<div class="error_msg"><?php echo $content["error_date"]; ?><div></div></div>
					<input type="text" name="date" id="datepicker" value="<?php echo $event[0]['date']?>">
					<br>
					<label for="datepicker">* <?php echo $content["date_debut"]; ?></label>
					<br>
					<input type="text" name="site_web" id="site_web" value="<?php echo $event[0]['website']?>">
					<br>
					<label for="site_web"><?php echo $content["website"]; ?></label>
					<br>
					<input type="text" name="mail" id="mail" value="<?php echo $event[0]['mail']?>">
					<br>
					<label for="mail"><?php echo $content["mail"]; ?></label>
					<br>
					<div class="error_msg"><?php echo $content["error_adresse"]; ?><div></div></div>
					<input type="text" name="address" id="autocomplete" value="<?php echo $event[0]['address']?>">
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
	?>					<div>
							<input name="files[]" id="file<?php echo $key; ?>" type="file" accept="image/*"/> 
							<input class = "image_checkbox" type="checkbox" name="delete_img[]" value="<?php echo $value['id']; ?>">
	           				<label for="file<?php echo $key; ?>" class="on_delete"  style="background-image: url('images/events/<?php echo $value['url']; ?>'); ">
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
					<a class ="btn_float_empty" href="user_events.php"><?php echo $content["annuler"]; ?></a>
					<span class="btn_float inactive" id="previous"><?php echo $content["precedent"]; ?></span>
					<span class="btn_float" id="next"><?php echo $content["suivant"]; ?></span>
			
					<p id="error_msg"><?php echo $content["error_form"]; ?></p>
					<input type="hidden" name="id" value="<?php echo $_POST['id']?>">
					<input type="submit" name="submit" id="submit_new_event" class= "btn_float" value="<?php echo $content["envoyer"]; ?>">
					</div>
				</div>
			</form>
			
	</section>
	<?php include("pages/footer.php"); ?>
</body>
</html>