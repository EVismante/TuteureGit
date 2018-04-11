<?php
session_start();
require_once('_config.php');
include '_head.php';
include 'inc/articles.inc.php';
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

$query1="SELECT event.id, event.titre_FR, images.url FROM event
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
			<h1>Trouvez votre aventure</h1>
		
		<form action="map/map.php" method="GET">
			<input type="text" id="club" name="club" placeholder="Club, préstation, véterinaire...">
			<input type="submit" value="Cherchez">
		</form>
		</div>
	</header>


	<section class="row">
		<div class="col-3">
			<a href="index.php#clubs">
				<img src="images/website/1.svg">
				<span>Trouvez votre futur club préféré</span>
			</a>
		</div>
		<div class="col-3">
			<a href="index.php#events">
				<img src="images/website/1.svg">
				<span>Participez aux évènements de la région</span>
			</a>
		</div>
		<div class="col-3">
			<a href="index.php#inscrire">
				<img src="images/website/1.svg">
				<span>Affichez votre préstation</span>
			</a>
		</div>
	</section>

<section class="content clearfix" id="clubs">
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
<div><a href="clubs.php">Voir tous les clubs</a></div>


</section>

	<section class="colored clearfix">
<?php
	$article = new article($pdo);
	$data = $article->get_data($pdo);
?>
		<img src="images/articles/<?php echo $article->image; ?>">
		<div>
			<h2><?php echo $article->titre; ?></h2>
				<p><?php echo $article->short_article; ?></p>
				<a href="<?php echo $article->path_article; ?>"> <span class="etiquette">Découvrir plus</span></a>
		</div>
	</section>

	<section class="content clearfix" id="events">
		<h2>Sortir</h2>
<?php
	foreach ($events as $key => $value) {
?>	<a href="event.php?id=<?php echo $events[$key]['id']; ?>">
		<div class="club_item" style="background-image: url('images/events/<?php echo $events[$key]['url'];?>');">
			<div>
				<h4><?php echo $events[$key]['titre_FR']; ?></h4>
			</div>
		</div>
		</a>
<?php
	}
?>
		<div><a href="events.php">Voir tous les évènements</a></div>
	</section>

	<section class="colored" id="inscrire">
		<h3>Pourquoi s'incrire?</h3>
		Pour mettre aux favoris
		pour 
	</section>

<?php include("pages/footer.php"); ?>

</body>
</html>