<?php
<<<<<<< HEAD
if (isset($_SESSION["id"])) {
	if ($_SESSION["type"] == "admin") {
=======
if (isset($_SESSION["type"])) {
	if($_SESSION["type"] == "admin") {
>>>>>>> 9343fa04f3b87953357b2c44c1b998b0f22ad4b8
	$url = "pages/admin_edit_".$page.".php?id=".$id
?>
	<div id="barre_admin">
		<a href="<?php echo $url; ?>">Editer page</a><br>
	</div>

<?php	
<<<<<<< HEAD
}
}

=======
}}
>>>>>>> 9343fa04f3b87953357b2c44c1b998b0f22ad4b8
?>

