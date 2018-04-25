<?php
if (isset($_SESSION["type"])) {
	if($_SESSION["type"] == "admin") {
	$url = "pages/admin_edit_".$page.".php?id=".$id
?>
	<div id="barre_admin">
		<a href="<?php echo $url; ?>">Editer page</a><br>
	</div>

<?php	
}}
?>

