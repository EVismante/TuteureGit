<?php
require "init_twig.php";
require_once('../_config.php');
session_start();
$page ="clubs";
$id = $_GET["id"]; //club id

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

$query = 'SELECT * FROM club WHERE id='.$id.';';
$result = $pdo->prepare($query);
$result->execute();
$club = $result->fetchAll();



/*________filtres_______________*/

$query1 = 'SELECT DISTINCT tag.id FROM tag 
LEFT JOIN club_tag ON tag.id=club_tag.tag_id
WHERE club_tag.club_id='.$id.';';

	$result = $pdo->prepare($query1);
	$result->execute();
	$checked = $result->fetchAll();

	$checked_array = []; /*resultats de tous les tags sélectionnés*/
	foreach ($checked as $key => $value) {
		array_push($checked_array, $value["id"]);
	};


function filtre($pdo, $x, $checked)
  {
    $stmt = $pdo->prepare("SELECT id, name_FR FROM tag WHERE type = $x;");
    $stmt->execute();  
    $filtres = $stmt->fetchAll();
    return $filtres;
				};

$query = "SELECT id, url FROM images WHERE club_id =".$id.";";
$r = $pdo->prepare($query);
$r->execute();
$imgs = $r->fetchAll();
$count = $r->rowCount();
$count_freespace = 3 - $count;

echo $twig->render('admin_edit_club.html.twig', array(

		'session_active' => $session_active, 
    	'avatar' => $avatar,
    	'username' => $username,
    	'user_id' => $_SESSION['id'],
    	'club_id' => $id,
    	'page' => $page,
    	'club_name' => $club[0]["name"],
    	'msg' => $msg,
    	'fr' => $club[0]["description_fr"],
    	'en' => $club[0]['description_en'],
    	'website' => $club[0]["website"],
    	'mail' => $club[0]["mail"],
    	'telephone' => $club[0]["telephone"],
    	'address' => $club[0]["address"],
    	'activites' => filtre($pdo, 1, $checked_array),
    	'types' => filtre($pdo, 2, $checked_array),
    	'autres' => filtre($pdo, 3, $checked_array),
    	'checked_array' => $checked_array,
    	'imgs' => $imgs,
    	'count_img' => $count,
    	'count_freespace' => $count_freespace
    	

    ));

