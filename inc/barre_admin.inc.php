<?php
if (isset($_SESSION["id"])) {
	if ($_SESSION["type"] == "admin") {
	$url = "pages/admin_edit_".$page.".php?id=".$id
?>
	<div class="barre_admin">
		<a href="<?php echo $url; ?>">Editer page</a><br>
	</div>

<?php	
}
}

?>

