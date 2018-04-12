<?php

require_once('_config.php');
$page = "clubs";
session_start();
include_once 'inc/langue.inc.php';
	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["user"]) ) {
		$header = "header.php";
	} else {
		$header = "user_header.php";
	}

/*-----------------------FETCHER LES ARTICLES------------------------------*/
$query="SELECT club.id, club.name, club.evaluation, images.url, comment.page_id,
(SELECT COUNT(*) FROM comment WHERE
page_type='club'
AND 
page_id=club.id) AS comments
FROM club
LEFT JOIN images ON images.club_id=club.id
LEFT JOIN comment ON club.id=comment.page_id
GROUP BY club.id
ORDER BY club.id DESC
;";
$result = $pdo->prepare($query);
$result->execute();
$articles = $result->fetchAll();

/*---------------------*/
include '_head.php';
$page="clubs";
?>

</head>
<body>
	<?php include($header); ?>

<section class="content clearfix">
	<h1><?php echo $content["dernier"]; ?></h1>
<?php
	foreach ($articles as $key => $value) {
	$id = $articles[$key]['id'];

?>	<a href="club.php?id=<?php echo $articles[$key]['id']; ?>&p=clubs">
		<div class="club_item" style="background-image: url('images/clubs/<?php echo $articles[$key]['url'];?>');">
				<div>
					<h3><?php echo $articles[$key]['name']; ?></h3>
					<span>
<?php include "inc/evaluation.inc.php"; /*évaluation de préstataire*/?>
					</span>
					<br>
					<span>Commentaires (<?php echo $articles[$key]['comments']; ?>)</span>
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