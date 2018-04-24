<?php
require_once('../../_config.php');
session_start();
include '../../inc/images.inc.php';
include '../../inc/login.inc.php'; /*pour redèfinir l'avatar*/
ini_set ('gd.jpeg_ignore_warning', 1);
$session_id = $_SESSION['id'];
/*-----------------verifier si upload est une image------------*/
/*Si on choisit pas une image pour upload*/
if (empty($_FILES['files']['tmp_name'])) {
	header("Location: ../../user_compte.php?msg=fail-missing");
} else {
	$temp = $_FILES['files']['tmp_name'][0];

}


function file_upload($temp, $session_id, $pdo) {

    foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
	    $temp = $_FILES["files"]["tmp_name"][$key];
	    $name = $_FILES["files"]["name"][$key];
	    $type = $_FILES['files']['type'][$key];

		$image = new avatar;
		$newfilename = $image->rename($name, $session_id);
		$path = $image->path;
	

	if ($image->is_Image($temp)) {

			$resize = $image->resize(150, 150, $newfilename, $path, $temp, $type);

		if($image->doesExist($session_id, $pdo) ) {
			$query = 'UPDATE images SET url = "'.$newfilename.'" WHERE user_id='.$session_id.';';
			$header = "../../user_compte.php";

		} else { 
			$query = 'INSERT INTO images (url, type, user_id) VALUES ("'.$newfilename.'", "avatar", '.$session_id.');';
			$header = "../../user_compte.php"; 
		};

			$result = $pdo->prepare($query);
			$done = $result->execute();


				if ($done) {
					/*redefini le variable d'avatar pour la session */
					$connect = new connect;
					$avatar = $connect->avatar($pdo, $session_id);
					$_SESSION["avatar"] = $avatar;

					header('Location: '.$header);
				}


			} else {
				throw new Exception();}
}}




	try { file_upload($temp, $session_id, $pdo);  }
	catch (Exception $e) { 
		header("Location: ../../user_compte.php?msg=fail1");

	 }













/*function file_upload($temp, $session_id, $pdo) {

	$image = new avatar;
	$newfilename = $image->rename($_FILES["userfile"]["name"], $session_id);
	$path = $image->path;
	$resize = $image->resize(150, 150, $newfilename, $path);

	if ($image->is_Image($temp)) {

		if($image->doesExist($session_id, $pdo) ) {
			$query = 'UPDATE images SET url = "'.$newfilename.'" WHERE user_id='.$session_id.';';
			$header = "../../user_compte.php";

		} else {
			throw new Exception("image n'existe pas encore");
		}

	} else {
		throw new Exception("C'est pas une image/image non definie");}
}

	try {  echo file_upload($temp, $session_id, $pdo);  }
	catch (Exception $e) { echo "<p>Exception reçue : ".$e->getMessage()."</p>\n"; }
echo "<p>Test d'erreur terminé</p>";*/


/*--------------------------------*/
/*





	$temp=$_FILES['userfile']['tmp_name'];

	$image = new avatar;
	$newfilename = $image->rename($_FILES["userfile"]["name"], $session_id);
	$path = $image->path;
	$resize = $image->resize(150, 150, $newfilename, $path);

	if(isset($_POST['envoi']) && $image->is_Image($temp)) { 

		if($image->doesExist($session_id, $pdo) ) {
			$query = 'UPDATE images SET url = "'.$newfilename.'" WHERE user_id='.$session_id.';';
			$header = "../../user_compte.php";
		} else {
			$query = 'INSERT INTO images (url, type, user_id) VALUES ("'.$newfilename.'", "avatar", '.$session_id.');';
			$header = "../../user_compte.php";
		}

	$result = $pdo->prepare($query);
	$done = $result->execute();

	if ($done) {
		header('Location: '.$header);
	}


}; 


*/

?>



