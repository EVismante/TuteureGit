<?php
$page_type="event";
$c_query = "SELECT users.id, comment.id, comment.message, comment.date, comment.lang, comment.parent_id, users.name, images.url
FROM comment 
LEFT JOIN users ON comment.user_id=users.id
LEFT JOIN images ON users.id=images.user_id
WHERE comment.page_id=".$clubInfo[0]['id']."
AND comment.page_type='event'
;";

$c_result = $pdo->prepare($c_query);
$c_result->execute();
$comments = $c_result->fetchAll();
/*_________commentaire forme submission__________*/
if (isset($_SESSION["name"])) {


?>		<div>
 		<form action="pages/comments/comment_post.php" method="POST">
			<img class="user_icon" alt="" src="images/avatars/<?php echo $_SESSION["avatar"]; ?>">
			<div>
				<span><?php echo $content["sub_comment"]; ?></span>
				<textarea rows="4" cols="50" name="comment" class="comment"></textarea>
				<span class="error_msg_comment">Votre commentaire est vide</span>
		</div>
			
			<input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
			<input type="hidden" name="club_id" value="<?php echo $clubInfo[0]['id']; ?>">
			<input type="hidden" name="parent_id" value="NULL">
			<input type="hidden" name="page_type" value="<?php echo $page_type; ?>">
			<br>
			<input type="submit" class="submit" value="<?php echo $content["envoyer"]; ?>">
			
		</form>
		</div>
<?php
} else {
	echo "Seulement les utilisateurs connectés peuvent poster les commentaires. <a href='login.php' >Connectez-vous.</a>";
};
/*_________-----------affichage des commentaires----------------__________*/

foreach ($comments as $key => $comment) {

	if ($comments[$key]['parent_id'] == NULL) { /*afficher les comments sans parents (originaux */
		/*determiner l'avatar*/
		if($comments[$key]['url'] == "") {$avatar = "default.svg";
		} else { $avatar = $comments[$key]['url']; }
?>
		<div class="parent">
			<img class="user_icon" alt ="" src="images/avatars/<?php echo $avatar; ?>">
			<h3><?php echo $comments[$key]['name'];?></h3>
			<hr>
			<span class="date"><?php echo $comments[$key]['date'];?></span>
			<p><?php echo $comments[$key]['message'];?></p>
<?php
		if (isset($_SESSION["name"])) { /*repondre au commentaire*/
?>
			<button class="btn" id="btn_repondre_<?php echo $comments[$key]['id']; ?>"><?php  echo $content["repondre"]; ?></button> 
<?php
/*----------------------------------------*/
if (isset($_SESSION["name"])) {
	$loop = $comments[$key];
	include ("edit_comment.inc.php");
}
/*----------------------------------------*/
	};
?>	</div>
<?php
/*----------------------------------------*/
if (isset($_SESSION["name"])) {
	$loop = $comments[$key];
	include ("repondre_comment.inc.php");
}
/*----------------------------------------*/

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
			<button class="btn" id="btn_repondre_<?php echo $comments[$k]['id']; ?>"><?php  echo $content["repondre"]; ?></button> 

<?php
/*----------------------------------------*/
if (isset($_SESSION["name"])) {
	$loop = $comments[$k];
	include ("edit_comment.inc.php");
}
/*----------------------------------------*/
	};
		?></div>
		<?php
/*----------------------------------------*/
if (isset($_SESSION["name"])) {
	$loop = $comments[$k];
	include ("repondre_comment.inc.php");
}
/*----------------------------------------*/
	}
	}}
} //end of foreach principal

?>