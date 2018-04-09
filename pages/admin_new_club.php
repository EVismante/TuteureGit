<?php
require "init_twig.php";
require_once('../_config.php');
session_start();
$page ="clubs";

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


function filtre($pdo, $x)
  {
    $stmt = $pdo->prepare("SELECT id, name_FR FROM tag WHERE type = $x;");
    $stmt->execute();  
    $filtres = $stmt->fetchAll();
    return $filtres;
				};

echo $twig->render('admin_new_club.html.twig', array(

		'session_active' => $session_active, 
    	'avatar' => $avatar,
    	'username' => $username,
    	'user_id' => $_SESSION['id'],
    	'msg' => $msg,
    	'activites' => filtre($pdo, 1),
    	'types' => filtre($pdo, 2),
    	'autres' => filtre($pdo, 3)
    ));
