<div id="repondre_<?php echo $loop['id']; ?>">
 		<form action="pages/comments/comment_post.php" method="POST">
 			<div class="arrow_comment"></div>
			<img class="user_icon" alt ="" src="images/avatars/<?php echo $_SESSION["avatar"];?>">
			<span class="error_msg_comment">Votre commentaire est vide</span>
			<textarea rows="4" cols="50" name="comment" class="comment"></textarea>
			<input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
			<input type="hidden" name="club_id" value="<?php echo $clubInfo[0]['id']; ?>">
			<input type="hidden" name="parent_id" value="<?php echo $comments[$key]['id'];?>">
			<input type="hidden" name="page_type" value="<?php echo $page_type; ?>">
			<br>
			<button class="submit btn">Envoyer</button>
		</form>
	</div>