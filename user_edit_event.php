<?php
require_once('_config.php');
session_start();
$page = "evenements";
	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["type"]) ) {
		header("Location: login.php");
	};

$page ="evenements";
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
		<h1>Éditer <?php echo $event[0]['titre_FR']?></h1>
			<form class="edit_club" action="pages/Events/edit_event_action.php" method="POST" enctype="multipart/form-data">
				<div>
					<input type="text" name="name_FR" id="name_FR" value="<?php echo $event[0]['titre_FR']?>">
					<br>
					<label for="name_FR">* Nom en français</label>
					<br>
					<input type="text" name="name_EN" id="name_EN" value="<?php echo $event[0]['titre_EN']?>">
					<br>
					<label for="name_EN">* Nom en anglais</label>
				</div>
				<span class="arrow"></span>
				<div>
					<textarea rows="4" cols="50" id="description_FR" name="description_FR" ><?php echo $event[0]['description_FR']?></textarea>
					<br>
					<label for="description_FR">* Description en français</label>
					<br><br><br>
					<textarea name="description_EN" id="description_EN"><?php echo $event[0]['description_EN']?></textarea>
					<br>
					<label for="description_EN" id="EN">Description in English</label>
					<br><br>
				</div>
				<span class="arrow"></span>

				<div id="edit_contacts">
					<input type="text" name="date" id="datepicker" value="<?php echo $event[0]['date']?>">
					<br>
					<label for="datepicker">* Date du début</label>
					<br>
					<input type="text" name="site_web" id="site_web" value="<?php echo $event[0]['website']?>">
					<br>
					<label for="site_web">Site web</label>
					<br>
					<input type="text" name="mail" id="mail" value="<?php echo $event[0]['mail']?>">
					<br>
					<label for="mail">Mail</label>
					<br>
					<input type="text" name="address" id="autocomplete" value="<?php echo $event[0]['address']?>">
					<br>
					<label for="autocomplete">* Adresse</label>

					<input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
					<input type="hidden" name="retour" value="user">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
				</div>

			<span class="arrow"></span>
			<div id="clearfix">
				<h4>Images</h4>
					<input type="hidden" name="MAX_FILE_SIZE" value="300000000" /> 
<?php
	foreach ($imgs as $key => $value) {
	?>				<div class="input_images">
						<input name="files[]" id="file<?php echo $key; ?>" type="file" accept="image/*"/> 
						<input class = "image_checkbox" type="checkbox" name="delete_img[]" value="<?php echo $value['id']; ?>">
	           			<label for="file<?php echo $key; ?>" class="on_delete"  style="background-image: url('images/events/<?php echo $value['url']; ?>'); ">
	           			 	<span>
	           			 	</span>
	           			</label>
	           		</div>

	<?php
	}

	for ($i=3; $i > $count ; $i--) { 
	?>	<div class="input_images">
				<input name="files[]" id="file<?php echo $i; ?>" type="file" accept="image/*" />
				<label for="file<?php echo $i; ?>"><span class="arrow_up"></span></label>
			</div>
	<?php
	}
	?>
			</div>
				<span class="arrow"></span>
				<div id="edit_btn">
					<p id="error_msg">Veuillez bien remplir le formulaire</p>
					<input type="submit" name="submit" id="submit_new_event" value="Envoyer">
					<a class ="btn_forme" href="user_events.php">Annuler</a>
				</div>
			</form>
	</section>
	<?php include("pages/footer.php"); ?>


</body>
</html>