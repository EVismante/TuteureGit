<?php
require_once('../../_config.php');

$id = $_POST["id"];



$query1 = ' DELETE FROM comment WHERE id='.$id.';' ;

$del = $pdo->prepare($query1);
$del->execute();
$count = $del->rowCount();


if($count > 0) {
	header('Location: ../admin_comments.php?msg=success');
} else {
	header('Location: ../admin_comments.php?msg=failure');
}
   

?>

