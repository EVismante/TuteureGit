<?php
require_once('../_config.php');
session_start();
$page ="articles";

if (isset($_SESSION["type"])) {
	if ($_SESSION["type"] == "normal") { header('Location: BackOffice/_nopermission.php');}}
if (!isset($_SESSION["name"])) { header('Location: BackOffice/_nopermission.php');}


/*-------------------------------*/
$id = $_POST["id"];


$query = 'SELECT * FROM article WHERE id='.$id.';';
$result = $pdo->prepare($query);
$result->execute();
$article = $result->fetchAll();

/*________Tags d'article_______________*/

function filtre($pdo, $article)
  {

    $stmt = $pdo->prepare("SELECT id, name_FR FROM tag WHERE type = 1;");
    $stmt->execute();  
    $filtres = $stmt->fetchAll();

				foreach ($filtres as $key => $value) {?>

<input type="radio" name="tag[]" value="<?php echo $value["id"]; ?>"
<?php 
		if ($value["id"] == $article[0]["tag"]) {
    			echo "checked";
			}
?>
>
<label for="tag[]"><?php echo $value["name_FR"]; ?></label>
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

		<h1>Éditer <?php echo $article[0]["titre_FR"]; ?></h1>
			<form class="edit_club" action="BackOffice/edit_article_action.php" method="POST" enctype="multipart/form-data">
				<div>
					<input type="text" name="titre_FR" id="titre_FR"  value="<?php echo $article[0]["titre_FR"]; ?>">
					<br>
					<label for="titre_FR">Titre en français * </label>
					<br>
					<input type="text" name="titre_EN" id="titre_EN" value="<?php echo $article[0]["titre_EN"]; ?>">
					<br>
					<label for="titre_EN">Title in English * </label>
				</div>
				<span class="arrow"></span>
				<div>
					<textarea rows="4" cols="50" id="article_FR" name="article_FR"><?php echo $article[0]["article_FR"]; ?></textarea>
					<br>
					<label for="article_FR">* Article en français</label>
					<br><br><br>
					<textarea name="article_EN" id="article_EN"><?php echo $article[0]["article_EN"]; ?></textarea>
					<br>
					<label for="article_EN" id="EN">Article in English</label>
					<br><br>
				</div>
				<span class="arrow"></span>

					<div>
						<h4>ACTIVITE</h4>
						<?php filtre($pdo, $article); ?>
					</div>
					<span class="arrow"></span>
				<div id="clearfix">
					<h4>Image</h4>
					<input type="hidden" name="MAX_FILE_SIZE" value="300000000" /> 
<?php
$query = "SELECT id, url FROM images WHERE article_id =".$id.";";
$r = $pdo->prepare($query);
$r->execute();
$imgs = $r->fetchAll();
$count = $r->rowCount();

if ($count > 0) {

?>
			<div class="input_images">
				<input name="files[]" id="file1" type="file" accept="image/*"/> 
				<input class = "image_checkbox" type="checkbox" name="delete_img[]" value="">
	           	<label for="file1" class="on_delete"  style="background-image: url('../images/articles/<?php echo $imgs[0]['url']; ?>'); ">
	           	<span>
	           	</span>
	           	</label>
           	</div>

<?php
} else {
?>
				<input name="files[]" id="file1" type="file" accept="image/*" />
				<label for="file1">
					<span class="arrow_up"></span>
				</label>
<?php
}
?>
				</div>
				<span class="arrow"></span>
				<div id="edit_btn">
					<!--message d'erreur-->
					<p id="error_msg">Veuillez bien remplir le formulaire</p>
					<input type="hidden" name="id" id="id" value="<?php echo $article[0]["id"]; ?>">
					<input type="submit" name="submit" id="submit_new_club" value="Envoyer">
					<input type="button" name="Annuler" value="Annuler">
				</div>
			</form>
	</section>
</body>
</html>