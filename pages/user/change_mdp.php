<?php
require_once('../../_config.php');

$id = trim($_POST['id']);
$mdp_old = $_POST['mdp_old'];
$mdp0 = trim($_POST['mdp']);
$mdp = password_hash($mdp0, PASSWORD_DEFAULT);
$retour = $_POST['retour'];

if ($retour == "user") {
	$url="../../user_compte.php";
} else {
	$url="../admin_utilisateurs.php";
}

$mdp_query = "SELECT password FROM users WHERE id=".$id.";";
$result = $pdo->prepare($mdp_query);
$result->execute();
$bdd_mdp = $result->fetchAll();

$bdd_mdp = $bdd_mdp[0]["password"];

$verify = password_verify($mdp_old, $bdd_mdp);

if ($verify) {
	$query = "UPDATE users
	SET password = '".$mdp."'
	WHERE id=".$id."; ";
	$result = $pdo->prepare($query);
	$result->execute();

	header("Location: ".$url."?msg=success");
} else {
	header("Location: ".$url."?msg=failure");
}
?>