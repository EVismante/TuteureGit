<?php
require_once('../../_config.php');
session_start();

$id = $_POST["id"];
$retour = $_POST["retour"];

$images = "SELECT url FROM images WHERE user_id=".$id.";";
$result = $pdo->prepare($images);
$result->execute();
$imgs = $result->fetchAll();

foreach ($imgs as $key => $value) {
	$file = "../../images/avatars/".$value[0];
	unlink($file);

}


$query1 = ' DELETE FROM images WHERE user_id='.$id.'; 
			DELETE FROM users WHERE id='.$id.';'
			;

$del = $pdo->prepare($query1);
$del->execute();
$count = $del->rowCount();


	if ($retour =="admin") {
		header("Location: ../admin_utilisateurs.php?msg=success");
} else {
	unset($_SESSION['type']);
	session_destroy();
	header('Location: ../../index.php');
}

   

?>