<?php
require "init_twig.php";
require_once('../_config.php');
session_start();


	$avatar = NULL;
	$session_active = false;
	$session_type = NULL;
	$username = NULL;
	$page = "articles";


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

$query = 'SELECT *  FROM article;';
$result = $pdo->prepare($query);
$result->execute();
$articles = $result->fetchAll();


echo $twig->render('admin_articles.html.twig', array(

		'session_active' => $session_active, 
    	'session_type' => $session_type,
    	'avatar' => $avatar,
    	'username' => $username,
    	'page' => $page,
    	'articles' => $articles,
    	'msg' => $msg
    	

    ));

?>
	