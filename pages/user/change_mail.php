<?php
require_once('../../_config.php');

$id = trim($_POST['id']);
$mail = $_POST['mail'];
$retour = $_POST['retour'];

	$query = "UPDATE users
	SET mail = '".$mail."'WHERE id=".$id."; ";

	$result = $pdo->prepare($query);
	$result->execute();


if ($retour =="admin") {
	header("Location: ../admin_utilisateurs.php?msg=success");
} else {
	header("Location: ../../user_compte.php?msg=success");
}
	

?>