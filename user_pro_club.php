<?php
require_once('_config.php');
require "init_twig.php";

session_start();
if ( !isset($_SESSION["type"]) ) {
		header("Location: login.php");
	};

	$page="monclub";
	$avatar = NULL;
	$session_active = false;
	$session_type = NULL;
	$username = NULL;

	if ( isset($_SESSION["id"])) {
		$session_active = true;
		$username = $_SESSION['name'];
		$avatar = "images/avatars/".$_SESSION["avatar"];

		if ($_SESSION["type"] == "normal") { $session_type = "normal"; }
		if ($_SESSION["type"] == "admin") { $session_type = "admin"; }
		if ($_SESSION["type"] == "pro") { $session_type = "pro"; }

	} 


//VERIFIER SI UTILISATEUR EST CONNECTE//

	$query = "SELECT * FROM club WHERE user_id=".$_SESSION['id'].";";
	$result = $pdo->prepare($query);
	$result->execute();
	$monclub = $result->fetchAll();
	$count = $result->rowCount();
	




echo $twig->render('user_pro_club.html.twig', array(

		'session_active' => $session_active, 
    	'session_type' => $session_type,
    	'avatar' => $avatar,
    	'username' => $username,
    	'page' => $page,
    	'club' => $monclub,
    	'count' => $count
    	

    ));

?>

	<section>
		<h1>Votre club</h1>

		{% if count == 0 %}
		Vous n'avez pas de club défini. <br>
		<a href=""> Créez votre préstation</a>
			<br>
		Un club vous appartient? <br>
		Contactez nous.
		{% else %}
		Votre club
		{% endif %}
	</section>
