<?php
require "init_twig.php";
require_once('../_config.php');
session_start();
$page ="clubs";
$id = $_POST["id"]; //club id

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
$id = $_POST["id"];


$query = 'SELECT * FROM event WHERE id='.$id.';';
$result = $pdo->prepare($query);
$result->execute();
$event = $result->fetchAll();

/* start of HTML _________*/


$query = "SELECT id, url FROM images WHERE event_id =".$id.";";
$r = $pdo->prepare($query);
$r->execute();
$imgs = $r->fetchAll();
$count = $r->rowCount();
$count_freespace = 3 - $count;

echo $count;
echo $count_freespace;
echo $twig->render('admin_edit_event.html.twig', array(

		'session_active' => $session_active, 
    	'avatar' => $avatar,
    	'username' => $username,
    	'user_id' => $_SESSION['id'],
    	'club_id' => $id,
    	'page' => $page,
    	'event_name' => $event[0]["name"],
    	'msg' => $msg,
    	'fr' => $event[0]["description_FR"],
    	'en' => $event[0]['description_EN'],
    	'website' => $event[0]["website"],
    	'mail' => $event[0]["mail"],
    	'date' => $event[0]["date"],
    	'address' => $event[0]["address"],
    	'imgs' => $imgs,
    	'count_img' => $count,
    	'count_freespace' => $count_freespace
    	

    ));