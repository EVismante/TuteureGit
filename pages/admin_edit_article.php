<?php
require "init_twig.php";
require_once('../_config.php');
session_start();
$page ="articles";
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

$query = 'SELECT * FROM article WHERE id='.$id.';';
$result = $pdo->prepare($query);
$result->execute();
$article = $result->fetchAll();

/*________Tags d'article_______________*/

function filtre($pdo)
  {
    $stmt = $pdo->prepare("SELECT id, name_FR FROM tag WHERE type = 1;");
    $stmt->execute();  
    $filtres = $stmt->fetchAll();
    return $filtres;
				};



/* start of HTML _________*/

$query = "SELECT id, url FROM images WHERE article_id =".$id.";";
$r = $pdo->prepare($query);
$r->execute();
$imgs = $r->fetchAll();
$count = $r->rowCount();

if ($count > 0) {
    $url = $imgs[0]['url'];
    $img_id = $imgs[0]['id'];
} else {
    $url = "default.jpg";
    $img_id = null;
}

echo $twig->render('admin_edit_article.html.twig', array(

		'session_active' => $session_active, 
    	'avatar' => $avatar,
    	'username' => $username,
    	'user_id' => $_SESSION['id'],
    	'article_id' => $id,
    	'page' => $page,
    	'titre_fr' => $article[0]["titre_FR"],
    	'titre_en' => $article[0]["titre_EN"],
    	'msg' => $msg,
    	'fr' => $article[0]["article_FR"],
    	'en' => $article[0]['article_EN'],
    	'activites' => filtre($pdo),
    	'img_url' => $url,
        'img_id' => $img_id,
    	'count_img' => $count,
    	'article_tag' => $article[0]["tag"]
    	
    ));