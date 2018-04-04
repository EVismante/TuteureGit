<?php
require_once('../_config.php');
session_start();
$page = "articles";

if (isset($_SESSION["type"])) {
	if ($_SESSION["type"] == "normal") { header('Location: BackOffice/_nopermission.php');}}
if (!isset($_SESSION["name"])) { header('Location: BackOffice/_nopermission.php');}


/*-------------------------------*/


function filtre($pdo, $x)
  {
    $stmt = $pdo->prepare("SELECT id, name_FR FROM tag WHERE type = $x;");
    $stmt->execute();  
    $filtres = $stmt->fetchAll();

				foreach ($filtres as $key => $value) {?>

<input type="radio" name="tag" id="tag[<?php echo $value["id"]; ?>]" value="<?php echo $value["id"]; ?>">
<label for="tag[<?php echo $value["id"]; ?>]"><?php echo $value["name_FR"]; ?></label>
<?php echo "<br>";
				}};


/* start of HTML _________*/

include ('_head_office.php');
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDd9slKoG41gF1xM8xr_LoEGCxnWrZejoY&libraries=places&callback=initAutocomplete"
        async defer></script>
 <script src="BackOffice/autocomplete.js"></script>


</head>
<body>

<?php include("_header_office.php"); ?>

	<section class="forme">
		<h1 id="changejs">Nouveau article</h1>
			<form class="edit_club" action="BackOffice/new_article_action.php" method="POST" enctype="multipart/form-data">
				<div>
					<input type="text" name="titre_FR" id="titre_FR">
					<br>
					<label for="titre_FR">Titre en français * </label>
					<br>
					<input type="text" name="titre_EN" id="titre_EN">
					<br>
					<label for="titre_EN">Title in English * </label>
				</div>
				<span class="arrow"></span>
				<div>
					<textarea rows="4" cols="50" id="article_FR" name="article_FR"></textarea>
					<br>
					<label for="article_FR">* Article en français</label>
					<br><br><br>
					<textarea name="article_EN" id="article_EN"></textarea>
					<br>
					<label for="article_EN" id="EN">Article in English</label>
					<br><br>
				</div>
				<span class="arrow"></span>
				
					<div>
						<h4>ACTIVITE</h4>
						<?php filtre($pdo, 1); ?>
					</div>
					<span class="arrow"></span>

				<div id="input_images">
					<h4>Images</h4>
					<input type="hidden" name="MAX_FILE_SIZE" value="300000000" /> 
           			 <input name="files[]" id="file1" type="file" accept="image/*"/> 
           			 <label for="file1"><span class="arrow_up"></span></label>
				</div>

				<!--message d'erreur-->
					<p id="error_msg">Veuillez bien remplir le formulaire</p>
					<input type="submit" name="submit" id="submit_new_club" value="Envoyer">
					<input type="button" name="Annuler" value="Annuler">
			</form>
	</section>
</body>
</html>