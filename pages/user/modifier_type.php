<?php
require_once('../../_config.php');

$id = trim($_POST['id']);
$type = $_POST['type'];
$retour = $_POST['retour'];

	$query = "UPDATE users
	SET type = '".$type."'WHERE id=".$id."; ";

	$result = $pdo->prepare($query);
	$result->execute();



	header("Location: ../admin_edit_user.php?id=".$id);

	

?>