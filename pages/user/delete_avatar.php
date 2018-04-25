<?php
require_once('../../_config.php');
include '../../inc/images.inc.php';

session_start();

$id = $_GET["id"];
$retour = $_GET["retour"];
$avatar = new avatar;

$delete = $avatar->doesExist($id, $pdo);

$count = 0;

if($delete) {

	$query1 = 'DELETE FROM images WHERE user_id='.$id.';'; 
	$del = $pdo->prepare($query1);
	$del->execute();
	$count = $del->rowCount();
	$_SESSION["avatar"] = "default.svg";

}


if ($count > 0) {
	if ($retour == "admin") {
			header("Location: ../admin_edit_user.php?id=".$id);
	} else {
			header("Location: ../../user_compte.php?msg=success");
	}
} else {
	if ($retour == "admin") {
			header("Location: ../pages/admin_edit_user.php?id=".$id);
	} else {
			header("Location: ../../user_compte.php?msg=failure_img");
	}
}

?>