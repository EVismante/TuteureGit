<?php
require "init_twig.php";
require_once('../_config.php');
session_start();
$page ="users";
$user_id = $_POST["id"]; 

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


$query = 'SELECT id, mail, name, password FROM users WHERE id='.$user_id.';';
$result = $pdo->prepare($query);
$result->execute();
$user_data = $result->fetchAll();


/*
    if(isset($_GET["msg"])) {
        if ($_GET["msg"] == "fail1") {
            echo "L'image est trop grande / mauvais format";
        } else { echo " Une erreur est survenue";}

*/


echo $twig->render('admin_edit_user.html.twig', array(

        'session_active' => $session_active, 
        'avatar' => $avatar,
        'username' => $username,
        'user_id' => $user_id,
        'user_name' => $user_data[0]["name"],
        'user_mail' => $user_data[0]["mail"]
        
    ));
