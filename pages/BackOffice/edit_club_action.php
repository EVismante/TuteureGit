<?php
require_once('../../_config.php');

$name = $_POST["name"];
$name_en = $_POST["name_en"];
$retour = $_POST["retour"];

$fr = addslashes($_POST["description_FR"]);
$en = addslashes($_POST["description_EN"]);

$website = htmlentities($_POST["site_web"]);
$mail = htmlentities($_POST["mail"]);
$phone = htmlentities($_POST["telephone"]);
$address = htmlentities($_POST["address"]);
$user_id = $_POST["user_id"];
$id = $_POST["id"];

/*-------------------Function geocode-------------------------------- */
include '../../inc/geocode.inc.php';
$geo_data = geocode($address);
$longt = $geo_data['long'];
$lat = $geo_data['lat'];


$queryClub = "UPDATE club SET 
name = '$name', 
name_en = '$name_en', 
address = '$address',
website = '$website',
telephone = '$phone',
mail = '$mail',
longt = '$longt',
lat = '$lat',
description_FR = '$fr',
description_EN = '$en',
user_id = '$user_id'
WHERE id = ".$id.";";

$result = $pdo->prepare($queryClub);
$result->execute();
/*-------------------INSERTION DES TAGS-------------------------------- */

/*supprime les vieux tags*/
$deleteTags = "DELETE from club_tag WHERE club_id = ".$id.";";
$delete = $pdo->prepare($deleteTags);
$delete->execute();

/*une fonction qui construit la réquete des tags du club*/

function tags($Id) {
  if (isset($_POST['filtre'])) {

  $tags = "INSERT INTO club_tag (club_id, tag_id) VALUES";

  foreach($_POST['filtre'] as $order => $selected){

  	if($order == 0) {$tags .= "($Id, $selected) ";}
  		else {$tags .= ", ($Id, $selected)";} 
}

$tags .=";";
return $tags;
}};

/*insere les tags dans la base de données*/
$tags = tags($id);

if(!is_null($tags)) {
	$resultTag = $pdo->prepare($tags);
	$resultTag->execute();
};

/*-------------------UPLOAD DES IMAGES-------------------------------- */
include '../../inc/images.inc.php';
ini_set ('gd.jpeg_ignore_warning', 1);


    $image = new club;
    $path = $image->path;

if (isset($_FILES["files"])) {
       foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
        $temp = $_FILES["files"]["tmp_name"][$key];
        $name = $_FILES["files"]["name"][$key];
        $newfilename = $image->rename($name, $id);
         
        if(!empty($temp)) { 
            if ($image->is_Image($temp)) {

            if(move_uploaded_file($tmp_name, $path.$newfilename)) {
             $queryimg = 'INSERT INTO images (url, type, club_id) VALUES ("'.$newfilename.'", "club", '.$id.');';
             $result = $pdo->prepare($queryimg);
             $result->execute();
            }
        }
    }  }
}


/*supprimer les images*/
if (isset($_POST["delete_img"])) {
    $delete_image = $_POST["delete_img"];
    foreach ($delete_image as $key => $id) {
        $image->delete($id, $pdo);
    }
};

/*-------------------REDIRECTION-------------------------------- */

if ($retour == "user") {
 header('Location: ../../user_pro_club.php?msg=success');
} else {
  header('Location: ../admin_clubs.php?msg=success');
}


?>