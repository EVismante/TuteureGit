<?php
require "init_twig.php";
require_once('../_config.php');
session_start();
$page ="users";
$user_id = $_GET["id"]; 

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


$query = 'SELECT users.id, users.mail, users.name, users.password, users.type, images.url FROM users 
LEFT JOIN images ON images.user_id=users.id
WHERE users.id='.$user_id.';';
$result = $pdo->prepare($query);
$result->execute();
$user_data = $result->fetchAll();
$type = $user_data[0]["type"];

/*
    if(isset($_GET["msg"])) {
        if ($_GET["msg"] == "fail1") {
            echo "L'image est trop grande / mauvais format";
        } else { echo " Une erreur est survenue";}

*/
include ('../inc/images.inc.php');
$image1 = new avatar;
$url = $user_data[0]["url"];
$url = $image1->getUrl($user_data[0]["url"], $type);
     


echo $twig->render('admin_edit_user.html.twig', array(

        'session_active' => $session_active, 
        'avatar' => $avatar,
        'username' => $username,
        'user_id' => $user_id,
        'user_name' => $user_data[0]["name"],
        'user_mail' => $user_data[0]["mail"],
        'user_type' => $user_data[0]["type"],
        'user_avatar' => $url

        
    ));
