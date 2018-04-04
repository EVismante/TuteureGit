<?php
require_once('../_config.php');
session_start();
$page = "articles";

if (isset($_SESSION["type"])) {
	if ($_SESSION["type"] == "normal" OR $_SESSION["type"] == "pro") { header('Location: BackOffice/_nopermission.php');}}
if (!isset($_SESSION["name"])) { header('Location: BackOffice/_nopermission.php');}


/*-------------------------------*/

$query = 'SELECT *  FROM article;';
$result = $pdo->prepare($query);
$result->execute();
$articles = $result->fetchAll();



/* start of HTML _________*/
include ('_head_office.php');
?>
</head>
<body>

<?php include("_header_office.php"); ?>

	<section class="office">
		<h1>Gestion des Articles</h1>
		<br><br>
		<a class = "btn" href="admin_new_article.php">Nouveau article</a>
		<input type="text" id="myInput" onkeyup="search()" placeholder="Cherchez..">
		<table id="myTable">
			<tr>
				<th>Titre en français</th>
				<th>Titre en anglais</th>
				<th>Date</th>
			</tr>
<?php
	foreach ($articles as $key => $value) {
?>
			<tr>
				<td><a href="../article.php?id=<?php echo $value["id"]; ?>"><?php echo $value['titre_FR']; ?></a></td>
				<td><?php echo $value["titre_EN"]; ?></td>
				<td><?php echo $value["date"]; ?></td>
				<td>
				<form action="admin_edit_article.php" method="POST">
					<input type="hidden" name="id" value="<?php echo $value['id']?>">
					<input type="submit" class="btn-empty" value="Changer">
				</form>
				<td>
					<form action="BackOffice/delete_article.php" method="POST">
						<input type="hidden" name="id" value="<?php echo $value['id']?>">
						<input type="submit" class="delete" value="Supprimer">
					</form>
				</td>
			</tr>
<?php
	}
?>
		</table>
	
	</section>
<?php
	if (isset($_GET["msg"])) {
		echo "<div id='msg'>";
		echo $_GET["msg"];
		echo "</div>";
	}
?>

</body>
</html>