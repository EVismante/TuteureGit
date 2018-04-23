<?php
session_start();
require_once('_config.php');
include 'inc/articles.inc.php';
include_once 'inc/langue.inc.php';
include '_head.php';

$page = "index";

$query="SELECT club.id, club.name, images.url FROM club
LEFT JOIN images ON images.club_id=club.id
GROUP BY club.id
ORDER BY club.evaluation DESC
LIMIT 6
;";
$result = $pdo->prepare($query);
$result->execute();
$clubs = $result->fetchAll();

$query1="SELECT event.id, event.titre_".$lang.", images.url FROM event
LEFT JOIN images ON images.event_id=event.id
GROUP BY event.id
LIMIT 3
;";
$result = $pdo->prepare($query1);
$result->execute();
$events = $result->fetchAll();

?>
<script>
	/* header scroll */

	$(window).on("scroll", function() {
	    if ($(window).scrollTop()>100) {
	      $(".nav").removeClass("nav-scroll");
	    }
	    if ($(window).scrollTop()<100) {
	      $(".nav").addClass("nav-scroll");
	    }
	});
</script>

</head>
<body>

	<?php include("header.php"); ?> <!-- pas dans le header à cause d'un bug de scroll-->

	<header>
		<div id="filter">
			<h1><?php echo $content["indexheader"]; ?></h1>
		
		<form action="map/map.php" method="GET">
			<input type="text" id="club" name="club" placeholder="<?php echo $content["placeholder_search"]; ?>">
			<input type="submit" value="<?php echo $content["cherchez"]; ?>">
		</form>
		<img src="images/website/icons/mouse.svg" alt="scrollez">
		</div>
	</header>


	<section class="row">
		<div class="col-3">
			<a href="index.php#clubs">
				<img src="images/website/2.svg" alt="">
				<span><?php echo $content["row1"]; ?></span>
			</a>
		</div>
		<div class="col-3">
			<a href="index.php#events0">
				<img src="images/website/1.svg" alt="">
				<span><?php echo $content["row2"]; ?></span>
			</a>
		</div>
		<div class="col-3">
			<a href="inscription.php">
				<img src="images/website/3.svg" alt="">
				<span><?php echo $content["row3"]; ?></span>
			</a>
		</div>
	</section>

<section class="colored clearfix" id="clubs">
	<div class="content">
	<h2>Top clubs</h2>
<?php
	foreach ($clubs as $key => $value) {
?>	<a href="club.php?id=<?php echo $clubs[$key]['id']; ?>">
		<div class="club_item" style="background-image: url('images/clubs/<?php echo $clubs[$key]['url'];?>');">
			<div>
				<h4><?php echo $clubs[$key]['name']; ?></h4>
			</div>
		</div>
	</a>
<?php
	}
?>	
	</div>	
	<div class="choix">
		<a class="btn-empty" href="clubs.php"><?php echo $content["voir_clubs"]; ?></a>
	</div>
</section>





	<section class="decouvrir clearfix">
<?php
	$article = new article($pdo, $lang);
	$data = $article->get_data($pdo, $lang);
?>
		<img src="images/articles/<?php echo $article->image; ?>" alt="illustration <?php echo $article->titre; ?>">
		<div class="lower">
			<h2><?php echo $article->titre; ?></h2>
				<p class="bigger"><?php echo $article->short_article; ?></p>
				<a class="btn" href="<?php echo $article->path_article; ?>"> 
					<?php echo $content['decouvrir_plus']; ?>
				</a>
		</div>
	</section>
<!-- section coup de coeur-->
	<section class="coeur clearfix">
<?php
		$random = new random_club($pdo, $lang);
		$club_coeur = $random->get_data($pdo, $lang);
?>		<div class="club_item">
			<img id ="h" src="images/website/icons/heart-pleine.svg" alt="">
			<h2><?php echo $content["coup_de_coeur"]; ?></h2>
			
			<a href="club.php?id=<?php echo $random->id; ?>">
				<img src="images/clubs/<?php echo $random->image;?>" alt="">
				</a>
				<h4><?php echo $random->name; ?></h4>
		</div>
			
	</section>
<!-- fin section coup de coeur-->
	<section class="colored clearfix" id="events0">
		<div class="content">
		<h2><?php echo $content['sortir']; ?></h2>
<?php
	foreach ($events as $key => $value) {
?>	<a href="event.php?id=<?php echo $events[$key]['id']; ?>">
		<div class="club_item" style="background-image: url('images/events/<?php echo $events[$key]['url'];?>');">
			<div>
				<h4><?php echo $events[$key]['titre_'.$lang]; ?></h4>
			</div>
		</div>
		</a>
<?php
	}
?>
	</div>
		<div class="choix">
		<a class="btn-empty" href="evenements.php"><?php echo $content["voir_evenements"]; ?></a>
		</div>

	</section>
<?php include("pages/footer.php"); ?>

</body>
</html>