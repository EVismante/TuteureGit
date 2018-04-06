<?php
require "init_twig.php";
require_once('../_config.php');
session_start();

	$avatar = NULL;
	$session_active = false;
	$session_type = NULL;
	$username = NULL;
	$page="office";

	if ( isset($_SESSION["id"])) {
		$session_active = true;
		$username = $_SESSION['name'];
		$avatar = "../images/avatars/".$_SESSION["avatar"];

		if ($_SESSION["type"] == "normal") { $session_type = "normal"; }
		if ($_SESSION["type"] == "admin") { $session_type = "admin"; }
		if ($_SESSION["type"] == "pro") { $session_type = "pro"; }

	} 


if (isset($_SESSION["type"])) {
	if ($_SESSION["type"] == "normal" OR $_SESSION["type"] == "pro") { header('Location: BackOffice/_nopermission.php');}}
if (!isset($_SESSION["name"])) { header('Location: BackOffice/_nopermission.php');}


echo $twig->render('admin_office.html.twig', array(

		'session_active' => $session_active, 
    	'session_type' => $session_type,
    	'avatar' => $avatar,
    	'username' => $username,
    	'page' => $page,
    	

    ));


?>

