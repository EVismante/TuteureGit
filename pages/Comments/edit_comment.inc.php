<?php

/*----------------------------------------*/

/* determiner l'auteur de commentaire pour lui donner la possibilité de l'éditer*/
if ($loop[0] == $_SESSION['id']) { ?>

 	<span class="clearfix" id="btn_edit_<?php echo $comments[$key]['id']; ?>"><?php  echo $content["changer"]; ?></span>

 	<div id="edit_<?php echo $comments[$key]['id']; ?>">
 		<form action="pages/comments/comment_edit.php" method="POST">

			<textarea rows="4" cols="50" name="comment" class="comment"><?php echo $loop['message']; ?></textarea>
			<input type="hidden" name="user_id" value="<?php echo $_SESSION['id']; ?>">
			<input type="hidden" name="comment_id" value="<?php echo $loop['id']; ?>">
			<input type="hidden" name="club_id" value="<?php echo $clubInfo[0]['id']; ?>">
			<input type="hidden" name="page_type" value="<?php echo $page_type; ?>">
			<span class="error_msg_comment">Votre commentaire est vide</span>
			<br>
			<input type="submit" class="submit btn" value="<?php echo $content["envoyer"]; ?>">
		</form>
	</div>
<?php
}
?>