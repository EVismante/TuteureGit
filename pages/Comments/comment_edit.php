<?php
require_once('../../_config.php');

$user = $_POST["user_id"];
$comment_id = $_POST["comment_id"];
$comment = htmlentities($_POST["comment"]);
$page_type=$_POST["page_type"];
$rating = "NULL";
$club = $_POST["club_id"];

/*
if (isset($_POST["rating"])) {
	$rating = $_POST["rating"];

	$query = " INSERT INTO ratings 
	(club_id, rating, user_id)
	VALUES
	($club, $rating, $user)
;";
$result = $pdo->prepare($query);
$result->execute();

$rating_club =  getRating($pdo, $club);

$update = "UPDATE club
SET evaluation = '$rating_club'
WHERE id=".$club.";";
$result = $pdo->prepare($update);
$result->execute();

};

		function getRating($pdo, $club) {
			$query_rating = "SELECT ROUND(AVG(rating),0) AS rating FROM ratings
		 WHERE
		club_id=".$club.";";

		$result_rating = $pdo->prepare($query_rating);
		$result_rating->execute();
		$rating1 = $result_rating->fetchAll();
		$niveau = $rating1[0]['rating'];

		return $niveau;
		}

*/

$comment_query = " UPDATE comment
SET message = '$comment', date = now()
WHERE id=".$comment_id."
;";



$result_comment = $pdo->prepare($comment_query);
$result_comment->execute();


if ($page_type == "club") {
	header('Location: ../../club.php?id='.$club);
}
if ($page_type == "event") {
	header('Location: ../../event.php?id='.$club);
}

?>