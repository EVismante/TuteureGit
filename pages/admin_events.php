<?php
require "init_twig.php";
require_once('../_config.php');
session_start();


	$avatar = NULL;
	$session_active = false;
	$session_type = NULL;
	$username = NULL;
	$page = "evenements";


/*voir si l'utilisateur est connecté. Au cas échéant il est rédirigé vers l'accueil*/
if (isset($_SESSION["type"])) {
	$session_active = true;
	$username = $_SESSION['name'];
	$avatar = "../images/avatars/".$_SESSION["avatar"];

	if ($_SESSION["type"] == "normal" OR $_SESSION["type"] == "pro") { header('Location: BackOffice/_nopermission.php');}}
if (!isset($_SESSION["name"])) { header('Location: BackOffice/_nopermission.php');}

/*feedback message*/
	if (isset($_GET["msg"])) {
		$msg =  $_GET["msg"];
	} else {
		$msg = "";
	}

/*-------------------------------*/

$query = 'SELECT event.titre_FR, event.date, users.name, event.id  FROM event LEFT JOIN users ON event.user_id=users.id;';
$result = $pdo->prepare($query);
$result->execute();
$events = $result->fetchAll();

echo $twig->render('admin_events.html.twig', array(

		'session_active' => $session_active, 
    	'session_type' => $session_type,
    	'avatar' => $avatar,
    	'username' => $username,
    	'page' => $page,
    	'events' => $events,
    	'msg' => $msg
    	

    ));


