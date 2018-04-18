<?php

class comment {

	public function __construct() {

	}


	public function ratingsCount($pdo, $id) {

		/*voire si l'utilisateur a déjà évalué le préstataire*/
		$ratingquery = "SELECT club_id FROM ratings
		WHERE user_id=".$_SESSION['id']."
		;";
		$res2 = $pdo->prepare($ratingquery);
		$res2->execute();
		$ratings = $res2->fetchAll();

		$ratingscount = true;

		if (($res2->rowCount()) > 0 ) {
			foreach ($ratings as $key => $value) {
				if ($value['club_id'] == $id) {
					$ratingscount = false;
			}}}
		return $ratingscount;
	}


	public function showStars($niveau) {
		if ($niveau !== NULL) {


			for($i = 1; $i <= $niveau; $i++) {
				echo "<img class='star' alt='' src='images/website/icons/pleine.svg'/>";
			}
			for($j = $i; $j <= 5; $j++) {
				echo "<img class='star' alt='' src='images/website/icons/vide.svg'/>";
			}
		}}



}

?>