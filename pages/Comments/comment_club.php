<?php
$c_query = "SELECT comment.id, comment.message, comment.rating_id, comment.date, comment.lang, comment.parent_id, users.name, images.url
FROM comment 
LEFT JOIN users ON comment.user_id=users.id
LEFT JOIN images ON users.id=images.user_id
WHERE comment.page_id=".$clubInfo[0]['id']."
AND comment.page_type='club'
;";

$c_result = $pdo->prepare($c_query);
$c_result->execute();
$comments = $c_result->fetchAll();


/*_________commentaire forme submission__________*/
if (isset($_SESSION["name"])) {

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
	}}
}
/*---------------------------------------------*/

?>		<div>
 		<form action="pages/comments/comment_post.php" method="POST">
			<img class="user_icon" alt="" src="images/avatars/<?php echo $_SESSION["avatar"]; ?>">
			<div>
				<span><?php echo $content["sub_comment"]; ?></span>
				<textarea rows="4" cols="50" name="comment" class="comment"></textarea>
<?php
if ($ratingscount) {
	?>			
				<div class="rating">
					<span><?php echo $content["evaluez"]." ".$clubInfo[0]['name']; ?></span>
					<br>
					<input type="radio" id="1star" name="rating" value="1">
					<label for="1star"><img class='star' alt='' src='images/website/icons/vide.svg'/></label>
					<input type="radio" id="2star" name="rating" value="2">
					<label for="2star"><img class='star' alt='' src='images/website/icons/vide.svg'/></label>
					<input type="radio" id="3star" name="rating" value="3">
					<label for="3star"><img class='star' alt='' src='images/website/icons/vide.svg'/></label>
					<input type="radio" id="4star" name="rating" value="4">
					<label for="4star"><img class='star' alt='' src='images/website/icons/vide.svg'/></label>
					<input type="radio" id="5star" name="rating" value="5">
					<label for="5star"><img class='star' alt='' src='images/website/icons/vide.svg'/></label>
				</div>
<?php
}
?>
		</div>
			<input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
			<input type="hidden" name="club_id" value="<?php echo $clubInfo[0]['id']; ?>">
			<input type="hidden" name="parent_id" value="NULL">
			<input type="hidden" name="page_type" value="club">
			<br>
			<input type="submit" class="submit" value="<?php echo $content["envoyer"]; ?>">
			<span class="error_msg">Votre commentaire est vide</span>
		</form>
		</div>
<?php
} else {
	echo "Only registered users can write comments. <a href='login.php' >Log in</a>";
};
/*_________-----------affichage des commentaires----------------__________*/

foreach ($comments as $key => $comment) {

	if ($comments[$key]['parent_id'] == NULL) { /*afficher les comments sans parents (originaux */
		/*determiner l'avatar*/
		if($comments[$key]['url'] == "") {$avatar = "default.svg";
		} else { $avatar = $comments[$key]['url']; }
?>
		<div class="parent">
			<img class="user_icon" alt ="" src="images/avatars/<?php echo $avatar;?>">
			<h3><?php echo $comments[$key]['name'];?></h3>
			<hr>
			<span class="date"><?php echo $comments[$key]['date'];?></span>
<?php //Afficher les évaluations avec les étoiles
if ($comments[$key]['rating_id'] !== NULL) {
	$niveau = $comments[$key]['rating_id'];

		for($i = 1; $i <= $niveau; $i++) {
			echo "<img class='star' alt='' src='images/website/icons/pleine.svg'/>";
		}
		for($j = $i; $j <= 5; $j++) {
			echo "<img class='star' alt='' src='images/website/icons/vide.svg'/>";
		}
}

?>
			<p><?php echo $comments[$key]['message'];?></p>
<?php
		if (isset($_SESSION["name"])) { /*repondre au commentaire*/
?>
			<button id="btn_repondre_<?php echo $comments[$key]['id']; ?>">Repondre</button> 
<?php
	};
?>	</div>
	<div id="repondre_<?php echo $comments[$key]['id']; ?>">
 		<form action="pages/comments/comment_post.php" method="POST">
			<img class="user_icon" alt ="" src="images/avatars/<?php echo $_SESSION["avatar"];?>">
			<textarea rows="4" cols="50" name="comment" class="comment"></textarea>
			<input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
			<input type="hidden" name="club_id" value="<?php echo $clubInfo[0]['id']; ?>">
			<input type="hidden" name="parent_id" value="<?php echo $comments[$key]['id'];?>">
			<input type="hidden" name="page_type" value="club">
			<span class="error_msg">Votre commentaire est vide</span>
			<br>
			<input type="submit" class="submit" value="<?php echo $content["envoyer"]; ?>">
		</form>
	</div>
<?php


foreach ($comments as $k => $v) {
		if ($comments[$k]['parent_id'] == $comments[$key]['id']) {
?>
		<div class="enfant">
			<div class="arrow_comment"></div>
			<img class="user_icon" src="images/avatars/<?php echo $comments[$k]['url'];?>" alt="user icon">
			<h3><?php echo $comments[$k]['name'];?></h3>
			<hr>
			<div><?php echo $comments[$k]['date'];?></div>
			<p><?php echo $comments[$k]['message'];?></p>
<?php
		if (isset($_SESSION["name"])) { /*repondre au commentaire*/
?>
			<button id="btn_repondre_<?php echo $comments[$k]['id']; ?>">Repondre</button> 
<?php
	};
		?></div>
		<div id="repondre_<?php echo $comments[$k]['id']; ?>">
 		<form action="pages/comments/comment_post.php" method="POST">
			<img class="user_icon" alt ="" src="images/avatars/<?php echo $_SESSION["avatar"];?>">
			<textarea rows="4" cols="50" name="comment" class="comment"></textarea>
			<input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
			<input type="hidden" name="club_id" value="<?php echo $clubInfo[0]['id']; ?>">
			<input type="hidden" name="parent_id" value="<?php echo $comments[$key]['id'];?>">
			<input type="hidden" name="page_type" value="club">
			<span class="error_msg">Votre commentaire est vide</span>
			<br>
			<button class="submit">Envoyer</button>
		</form>
	</div>

		<?php
	}
	}}
} //end of foreach principal

?>
		

