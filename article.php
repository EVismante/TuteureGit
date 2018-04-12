<?php
require_once('_config.php');

session_start();

include_once 'inc/langue.inc.php';

include '_head.php';
$page = "decouvrir";
$id = $_GET["id"]; /*id de la page*/
$id_tag = $_GET["tag"];

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

/*Pour les suggestions des clubs*/
$clubQuery = "SELECT club.id, club.name, club.evaluation, images.url from club
LEFT JOIN club_tag ON club_tag.club_id=club.id
LEFT JOIN images ON images.club_id=club.id
WHERE club_tag.tag_id=".$id_tag." 
GROUP BY club.id
LIMIT 4
;";
$result = $pdo->prepare($clubQuery);
$result->execute();
$clubs = $result->fetchAll();
$count = $result->rowCount();
?>

</head>
<body>
<?php include("header.php"); ?>
<div class="head_img" style="background-image: url('images/articles/<?php echo $img[0]["url"]; ?>');">
</div>
<section class="content">
	<a class="revenir" href="decouvrir.php"><?php echo $content["revenir_activites"]; ?></a>
	<h1><?php echo $article[0]['titre_'.$lang]; ?></h1>
			<hr/>
		<div>
			<p><?php echo $article[0]['article_'.$lang]; ?></p>
		</div>
		<div class="clearfix">
<?php if ($count > 0) { ?>

		<h3><?php echo $content["pratique"]." ".$article[0]['titre_'.$lang];?> </h3>
	
	<?php }
	foreach ($clubs as $key => $value) {
?>		<a href="club.php?id=<?php echo $clubs[$key]['id']; ?>">
		<div class="club_item" style="background-image: url('images/clubs/<?php echo $clubs[$key]['url'];?>');">
				<div>
					<h3><?php echo $clubs[$key]['name']; ?></h3>
				</div>
			</div>
	</a>
<?php
	}
?>
		</div>
</section>
	<?php include("pages/footer.php"); ?>
</body>
</html>