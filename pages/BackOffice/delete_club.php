<?php
require_once('../../_config.php');

$id = $_POST["id"];
$retour = $_POST["retour"];

$images = "SELECT url FROM images WHERE club_id=".$id.";";
$result = $pdo->prepare($images);
$result->execute();
$imgs = $result->fetchAll();


foreach ($imgs as $key => $value) {
	$file = "../../images/clubs/".$value[0];
	unlink($file);

}


$query1 = ' DELETE FROM images WHERE club_id='.$id.'; 
			DELETE FROM club_tag WHERE club_id='.$id.';
			DELETE FROM club WHERE id='.$id.';
			DELETE FROM club_belongs WHERE club_id='.$id.';
			DELETE FROM favoris WHERE page_id='.$id.' AND page_type="club";'
			;

$del = $pdo->prepare($query1);
$del->execute();
$count = $del->rowCount();



/*--------retour----------*/
if ($retour == "user") {
		if($count > 0) {
		header('Location: ../../user_pro_club.php?msg=success');
	} else {
		header('Location: ../../user_pro_club.php?msg=failure');
	}

} else {
	  if($count > 0) {
		header('Location: ../admin_clubs.php?msg=success');
	} else {
		header('Location: ../admin_clubs.php?msg=failure');
	}
}


   

?>

