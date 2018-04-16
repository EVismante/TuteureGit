<?php
include 'inc/filtres.inc.php';

function filtre($pdo, $x)
  {
    $stmt = $pdo->prepare("SELECT name_FR FROM tag WHERE type = $x;");
    $stmt->execute();  
    $filtres = $stmt->fetchAll();

				foreach ($filtres as $key => $value) {?>

<input type="checkbox" name="filtre[]" value="<?php echo $value["name_FR"]; ?>">
<label for="filtre[]"><?php echo $value["name_FR"]; ?></label>
<?php echo "<br>";
				}};
?>


		<div id="make_smaller" class="clicked"><div>
	</div>
</div>
<div class="result_paneau">

		
			<input type="text" name="club" placeholder="<?php echo $content["placeholder_search"]; ?>" id="searchbox">
			<input type="checkbox" name="clubs_choix" id="prestations" checked>
			<label for="prestations">Préstataires</label>
			<input type="checkbox" name="events" id="events" checked>
			<label for="events">Evènements</label>

		<div id="filtres">
			<span tabindex="0">Activité
				<span class="arrow_show"></span>
			</span>
			<div>
				<?php filtre($pdo, 1); ?>
			</div>
			<span tabindex="0">Type
				<span class="arrow_show"></span>
			</span>
			<div>
				<?php filtre($pdo, 2); ?>
			</div>
			<span tabindex="0">Autres filtres
				<span class="arrow_show"></span>
			</span>
			<div>
				<?php filtre($pdo, 3); ?>
			</div>
		</div>
		<div>
			<input type="button" value="<?php echo $content["cherchez"]; ?>" id="search_btn1">
		</div>
			<hr/>
		<div id="liste"></div>

</div>




