<?php
require_once('_config.php');

session_start();

include '_head.php';
$page = "decouvrir";
$id = $_GET["id"]; /*id de la page*/

$clubQuery = 'SELECT * FROM article WHERE id = '.$id.';';
$result = $pdo->prepare($clubQuery);
$result->execute();
$article = $result->fetchAll();

/*IMAGES*/
$imgQuery = 'SELECT url FROM images 
			WHERE article_id='.$id.';';

$result = $pdo->prepare($imgQuery);
$result->execute();
$img = $result->fetchAll();

/*Pour les siggestions des clubs*/
$clubQuery = "SELECT club.id, club.name, club.evaluation, images.url from club
LEFT JOIN club_tag ON club_tag.club_id=club.id
LEFT JOIN images ON images.club_id=club.id
WHERE club_tag.tag_id=".$id." 
GROUP BY club.id
LIMIT 4
;";
$result = $pdo->prepare($clubQuery);
$result->execute();
$clubs = $result->fetchAll();
?>

</head>
<body>
<?php include("header.php"); ?>
	<section class="top1">
	
		<a class="revenir" href="decouvrir.php">Revenir aux activités</a>
			<h1><?php echo $article[0]['titre_FR']; ?></h1>
	</section>
	<section class="left">
			<hr/>
		<div>
			<p><?php echo $article[0]['article_FR']; ?></p>
		</div>
	</section>

	<section class="right">

<?php
foreach ($img as $key => $value) {
?>
		<img src="images/articles/<?php echo $value["url"]; ?>" alt="<?php echo $article[0]['titre_FR']; ?>">
<?php
}
/*Liste de suggestions des clubs*/
?>		

	</section>
	<?php
	foreach ($clubs as $key => $value) {
?>	<a href="club.php?id=<?php echo $clubs[$key]['id']; ?>">
		<div class="club_item" style="background-image: url('images/clubs/<?php echo $clubs[$key]['url'];?>');">
				<div>
					<h3><?php echo $clubs[$key]['name']; ?></h3>
				</div>
			</div>
	</a>

<?php
	}

?>

	<?php include("pages/footer.php"); ?>
</body>
</html>