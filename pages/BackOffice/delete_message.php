<?php
require_once('../../_config.php');

$id = $_POST["id"];



$query1 = ' DELETE FROM contact WHERE id='.$id.'; '
			;

$del = $pdo->prepare($query1);
$del->execute();
$count = $del->rowCount();


if($count > 0) {
	header('Location: ../admin_messages.php?msg=success');
} else {
	header('Location: ../admin_messages.php?msg=failure');
}
   

?>