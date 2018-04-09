<?php
require_once('_config.php');
session_start();
$page = "favoris";
	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["type"]) ) {
		header("Location: login.php");
	};
/**************************************************************/
function filtre($pdo, $x)
  {
    $stmt = $pdo->prepare("SELECT id, name_FR FROM tag WHERE type = $x;");
    $stmt->execute();  
    $filtres = $stmt->fetchAll();

				foreach ($filtres as $key => $value) {?>

<input type="checkbox" name="filtre[]" value="<?php echo $value["id"]; ?>">
<label for="filtre[]"><?php echo $value["name_FR"]; ?></label>
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
		<h1 id="changejs" >Nouveau préstataire</h1>
			<form class="edit_club" action="pages/BackOffice/new_club_action.php" method="POST" enctype="multipart/form-data">
				<div>
					<input type="text" name="name" id="name">
					<br>
					<label for="name">* Nom </label>
				</div>
				<span class="arrow"></span>
				<div>
					<textarea rows="4" cols="50" id="description_FR" name="description_FR"></textarea>
					<br>
					<label for="description_FR">* Description en français</label>
					<br><br><br>
					<textarea name="description_EN" id="description_EN"></textarea>
					<br>
					<label for="description_EN" id="EN">Description in English</label>
					<br><br>
				</div>
				<span class="arrow"></span>
		
				<div class="filtres">
					<div>
						<span>ACTIVITE</span><br>
						<?php filtre($pdo, 1); ?>
					</div>
					<div>
						<span>TYPE</span><br>
						<?php filtre($pdo, 2); ?>
					</div>
					<div>
						<span>AUTRE</span><br>
						<?php filtre($pdo, 3); ?>
					</div>
				</div>
				<div>
					<input type="text" name="site_web" id="site_web">
					<br>
					<label for="site_web">site web</label>
					<br>
					<input type="text" name="mail" id="mail">
					<br>
					<label for="mail">mail</label>
					<br>
					<input type="text" name="telephone" id="telephone">
					<br>
					<label for="telephone">* Date du début</label>
					<br>
					<input type="text" name="address" id="autocomplete">
					<br>
					<label for="autocomplete">* Adresse</label>
					<br>
					<input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
					<input type="hidden" name="retour" value="user">
				</div>
				<span class="arrow"></span>


				<div id="input_images">
					<h4>Images</h4>
					<input type="hidden" name="MAX_FILE_SIZE" value="300000000" /> 
           			 <input name="files[]" id="file1" type="file" accept="image/*"/> 
           			 <label for="file1"><span class="arrow_up"></span></label>
           			 <input name="files[]" id="file2" type="file" accept="image/*"/> 
           			 <label for="file2"><span class="arrow_up"></span></label>
           			 <input name="files[]" id="file3" type="file" accept="image/*"/> 
           			 <label for="file3"><span class="arrow_up"></span></label>
				</div>

				<div id="edit_btn">
					<p id="error_msg">Veuillez bien remplir le formulaire</p>
					<input type="submit" name="submit" id="submit_new_club" value="Envoyer">
					<input type="button" name="Annuler" value="Annuler">
				</div>
			</form>
	</section>

<?php include("pages/footer.php"); ?>
</body>
</html>