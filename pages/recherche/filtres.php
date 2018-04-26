<?php
include_once 'inc/langue.inc.php';
include 'inc/filtres.inc.php';
function filtre($pdo, $x, $lang)
  {
    $stmt = $pdo->prepare("SELECT name_".$lang." FROM tag WHERE type = $x;");
    $stmt->execute();  
    $filtres = $stmt->fetchAll();

				foreach ($filtres as $key => $value) {?>

<input type="checkbox" name="filtre[]" id="<?php echo $x.$key; ?>" value="<?php echo $value["name_".$lang]; ?>">
<label for="<?php echo $x.$key;; ?>"><?php echo $value["name_".$lang]; ?></label>
<?php echo "<br>";
				}};
?>


		<div id="make_smaller" class="clicked"><div>
	</div>
</div>
<div class="result_paneau">

		
			<input type="text" name="club" placeholder="<?php echo $content["placeholder_search"]; ?>" id="searchbox">
			<div>
				<input type="checkbox" name="clubs_choix" id="prestations" checked>
				<label for="prestations"><?php echo $content["prestataires"]; ?></label>
			</div>
			<div>
				<input type="checkbox" name="events" id="events" checked>
				<label for="events"><?php echo $content["evenements"]; ?></label>
			</div>

		<div id="filtres">
			<span tabindex="0"><?php echo $content["activite"]; ?>
				<span class="arrow_show"></span>
			</span>
			<div>
				<?php filtre($pdo, 1, $lang); ?>
			</div>
			<span tabindex="0"><?php echo $content["type"]; ?>
				<span class="arrow_show"></span>
			</span>
			<div>
				<?php filtre($pdo, 2, $lang); ?>
			</div>
			<span tabindex="0"><?php echo $content["autre"]; ?>
				<span class="arrow_show"></span>
			</span>
			<div>
				<?php filtre($pdo, 3, $lang); ?>
			</div>
		</div>
		<div>
			<input type="button" value="<?php echo $content["cherchez"]; ?>" id="search_btn1">
		</div>
			<hr/>
		<div id="liste"></div>

</div>




