<?php

require_once('_config.php');

session_start();
	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["user"]) ) {
		$header = "header.php";
	} else {
		$header = "user_header.php";
	}

/*-----------------------FETCHER LES ARTICLES------------------------------*/
$query="SELECT article.id, article.titre_FR, images.url, article.tag FROM article
LEFT JOIN images ON images.article_id=article.id;";
$result = $pdo->prepare($query);
$result->execute();
$articles = $result->fetchAll();
include '_head.php';
$page="decouvrir";
?>

</head>
<body>
	<?php include($header); ?>

<section>
	<h1>Découvrir</h1>
<?php
	foreach ($articles as $key => $value) {
?>	<a href="article.php?id=<?php echo $articles[$key]['id']; ?>&tag=<?php echo $articles[$key]['tag']; ?>">
		<div class="club_item" style="background-image: url('images/articles/<?php echo $articles[$key]['url'];?>');">
				<div>
					<h3><?php echo $articles[$key]['titre_FR']; ?></h3>
				</div>
			</div>
	</a>

<?php
	}

?>
</section>

	<?php 
	include("pages/footer.php"); 

	?>
</body>
</html>