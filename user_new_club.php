<?php
require_once('_config.php');
session_start();
include_once 'inc/langue.inc.php';
$page = "club1";


	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["type"]) ) {
		header("Location: login.php");
	};


/**************************************************************/

/*________filtres_______________*/

function filtre($pdo, $x, $lang)
  {
    $stmt = $pdo->prepare("SELECT id, name_".$lang." FROM tag WHERE type = $x;");
    $stmt->execute();  
    $filtres = $stmt->fetchAll();

				foreach ($filtres as $key => $value) {?>

<input type="checkbox" name="filtre[]" value="<?php echo $value["id"]; ?>">
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
		<h1 id="changejs"><?php echo $content["nouveau_club"]; ?></h1>
		<h4 id="changeh4"><?php echo $content["nouveau_club"]; ?></h4>
			<form id="formulaire" class="edit_club" action="pages/BackOffice/edit_club_action.php" method="POST" enctype="multipart/form-data">

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
					<input type="text" name="name" id="name_fr">
					<br>
					<label for="name_fr">* <?php echo $content["titre_en_fr"]; ?></label>
					<br>
					<textarea rows="4" cols="50" id="description_FR" name="description_FR" ></textarea>
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
					<input type="text" name="name_en" id="name_en">
					<br>
					<label for="name_en">* <?php echo $content["titre_en_en"]; ?></label>
					<textarea name="description_EN" id="description_EN"></textarea>
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
						<?php filtre($pdo, 1, $lang); ?>
					</div>
					<div>
						<h4><?php echo $content["type"]; ?></h4>
						<?php filtre($pdo, 2, $lang); ?>
					</div>
					<div>
						<h4><?php echo $content["autre"]; ?></h4>
						<?php filtre($pdo, 3, $lang); ?>
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
					<input type="text" name="telephone" id="telephone">
					<br>
					<label for="phone"><?php echo $content["phone"]; ?></label>
					<br>
					<input type="text" name="site_web" id="site_web">
					<br>
					<label for="site_web"><?php echo $content["website"]; ?></label>
					<br>
					<input type="text" name="mail" id="mail">
					<br>
					<label for="mail"><?php echo $content["mail"]; ?></label>
					<br>
					<div class="error_msg"><?php echo $content["error_adresse"]; ?><div></div></div>
					<input type="text" name="address" id="autocomplete">
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
           			 <input name="files[]" id="file1" type="file" accept="image/*"/> 
           			 <label for="file1"><span class="arrow_up"></span></label>
           			 <input name="files[]" id="file2" type="file" accept="image/*"/> 
           			 <label for="file2"><span class="arrow_up"></span></label>
           			 <input name="files[]" id="file3" type="file" accept="image/*"/> 
           			 <label for="file3"><span class="arrow_up"></span></label>
				</div>

				<div class="clearfix">
					<a class ="btn_float_empty" href="user_pro_club.php"><?php echo $content["annuler"]; ?></a>
					<span class="btn_float inactive" id="previous"><?php echo $content["precedent"]; ?></span>
					<span class="btn_float" id="next"><?php echo $content["suivant"]; ?></span>
				</div>
			
				<div id="fin">
					<p id="error_msg"><?php echo $content["error_form"]; ?></p>
					<input type="hidden" name="id" value="<?php echo $_POST['id']?>">
					<input type="submit" name="submit" id="submit_new_event" value="<?php echo $content["envoyer"]; ?>">
					
				</div>
			</form>
			
	</section>
	<?php include("pages/footer.php"); ?>
</body>
</html>


