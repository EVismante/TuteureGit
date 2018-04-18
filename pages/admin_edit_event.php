<?php
include 'template.php';
require "init_twig.php";
require_once('../_config.php');

$page ="evenements";
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

echo $twig->render('admin_edit_event.html.twig', array(

		'session_active' => $session_active, 
    	'avatar' => $avatar,
    	'username' => $username,
    	'user_id' => $_SESSION['id'],
    	'club_id' => $id,
    	'page' => $page,
    	'event_name' => $event[0]["titre_fr"],
        'event_name_EN' => $event[0]["titre_en"],
    	'msg' => $msg,
    	'fr' => $event[0]["description_fr"],
    	'en' => $event[0]['description_en'],
    	'website' => $event[0]["website"],
    	'mail' => $event[0]["mail"],
    	'date' => $event[0]["date"],
    	'address' => $event[0]["address"],
    	'imgs' => $imgs,
    	'count_img' => $count,
    	'count_freespace' => $count_freespace
    	

    ));