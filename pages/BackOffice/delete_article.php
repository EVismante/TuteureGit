<?php
require_once('../../_config.php');

$id = $_POST["id"];

$images = "SELECT url FROM images WHERE article_id=".$id.";";
$result = $pdo->prepare($images);
$result->execute();
$imgs = $result->fetchAll();

foreach ($imgs as $key => $value) {
	$file = "../../images/articles/".$value[0];
	unlink($file);

}


$query1 = ' DELETE FROM images WHERE article_id='.$id.'; 
			DELETE FROM article WHERE id='.$id.';'
			;

$del = $pdo->prepare($query1);
$del->execute();
$count = $del->rowCount();


if($count > 0) {
	header('Location: ../admin_articles.php?msg=success');
} else {
	header('Location: ../admin_articles.php?msg=failure');
}
   

?>

