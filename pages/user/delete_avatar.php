<?php
require_once('../../_config.php');
include '../../inc/images.inc.php';

session_start();

$id = $_POST["id"];
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
	header("Location: ../../user_compte.php?msg=success");
} else {
	header("Location: ../../user_compte.php?msg=failure_img");
}

?>