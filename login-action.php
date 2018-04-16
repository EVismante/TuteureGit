<?php
session_start();
require_once('_config.php');
include 'inc/login.inc.php';


$connect = new connect();
$login = $connect->users_array($pdo); /* retourne le tableau de tous les utilisateurs*/
$verify = $connect->verifyLogin($login, $pdo); /* verifie si le login est bon et defini les variables de session */


if ($verify) {

	$first = $connect->first_time($pdo); /*verifie si l'utilisateur se connecte pour la première fois! */
	if ($first == "1") {
		header("Location: welcome.php");
	} else {
		header("Location: index.php");
	}

} else {
	
	header("Location: login.php?msg=failed");
}





?>