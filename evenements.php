<?php
require_once('_config.php');
session_start();
include_once 'inc/langue.inc.php';

include '_head.php';
$page="evenements";

$query = "SELECT event.id, event.titre_".$lang.", event.date, images.url FROM event
LEFT JOIN 
images
ON event.id=images.event_id
GROUP BY event.id
;
";
$stmt = $pdo->prepare($query);
    $stmt->execute();  
    $events = $stmt->fetchAll();

?>
</head>
<body>
	<?php include("header.php"); ?>
<section class="content clearfix">
	<h1><?php echo $content["evenements"]; ?></h1>
<?php
	foreach ($events as $key => $value) {
?>	<a href="event.php?id=<?php echo $events[$key]['id']; ?>&p=events">
	<div class="club_item" style="background-image: url('images/events/<?php echo $events[$key]['url'];?>');">
		<div>
			<h3><?php echo $events[$key]['titre_'.$lang]; ?></h3>
			<h4><?php echo $events[$key]['date']; ?></h4>
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