<?php
require "init_twig.php";
require_once('../_config.php');
session_start();

	$avatar = NULL;
	$session_active = false;
	$session_type = NULL;
	$username = NULL;
	$page = "utilisateurs";


/*voir si l'utilisateur est connecté. Au cas échéant il est rédirigé vers l'accueil*/
if (isset($_SESSION["type"])) {
	$session_active = true;
	$username = $_SESSION['name'];
	$avatar = "../images/avatars/".$_SESSION["avatar"];

	if ($_SESSION["type"] == "normal" OR $_SESSION["type"] == "pro") { header('Location: BackOffice/_nopermission.php');}}
if (!isset($_SESSION["name"])) { header('Location: BackOffice/_nopermission.php');}

$msg = "";

	if (isset($_GET["msg"])) {
		$msg =  $_GET["msg"];
	}
	
/*-------------------------------*/

$query = 'SELECT id, name, mail, type FROM users;';
$result = $pdo->prepare($query);
$result->execute();
$users = $result->fetchAll();



echo $twig->render('admin_utilisateurs.html.twig', array(

		'session_active' => $session_active, 
    	'session_type' => $session_type,
    	'avatar' => $avatar,
    	'username' => $username,
    	'page' => $page,
    	'users' => $users,
    	'msg' => $msg
    	

    ));



