<?php
require_once('../../_config.php');
require_once ('../../inc/images.inc.php');

$name = $_POST["name"];
$name_en = $_POST["name_en"];

$fr = addslashes($_POST["description_FR"]);
$en = addslashes($_POST["description_EN"]);

$website = addslashes($_POST["site_web"]);
$mail = addslashes($_POST["mail"]);
$phone = $_POST["telephone"];
$address = $_POST["address"];
$user_id = $_POST["user_id"];
$retour = $_POST["retour"];
/*-------------------Function geocode-------------------------------- */
include '../../inc/geocode.inc.php';
$geo_data = geocode($address);
$long = $geo_data["long"];
$lat = $geo_data["lat"];


$queryClub = "
INSERT INTO club (name, name_en, address, website, telephone, mail, longt, lat, description_FR, description_EN, user_id)
VALUES ('$name',
        '$name_en',
        '$address',
        '$website',
        '$phone',
        '$mail',
        '$long',
        '$lat',
        '$fr',
        '$en',
        '$user_id'
);";


$result = $pdo->prepare($queryClub);
$result->execute();

/*-------------------INSERTION DES TAGS-------------------------------- */

/*trouve le dernier ID du club */
$maxId = "SELECT MAX(id) FROM club";
$r = $pdo->prepare($maxId);
$r->execute();
$maxId = $r->fetch();

$maxId=$maxId["MAX(id)"];

/*-------club belongs table -----*/
$queryBelongs = "
INSERT INTO club_belongs (user_id, club_id)
VALUES ('$user_id', '$maxId');
";
$result1 = $pdo->prepare($queryBelongs);
$result1->execute();

/*----*/

/*une fonction qui construit la réquete des tags du club*/

function tags($maxId) {
  if (isset($_POST['filtre'])) {

  $tags = "INSERT INTO club_tag (club_id, tag_id) VALUES";

  foreach($_POST['filtre'] as $order => $selected){

  	if($order == 0) {$tags .= "($maxId, $selected) ";}
  		else {$tags .= ", ($maxId, $selected)";} 
}

$tags .=";";
return $tags;
}};

/*insere les tags dans la base de données*/
$tags = tags($maxId);

if(!is_null($tags)) {
	$resultTag = $pdo->prepare($tags);
	$resultTag->execute();
};

/*-------------------UPLOAD DES IMAGES-------------------------------- */
ini_set ('gd.jpeg_ignore_warning', 1);

if (isset($_FILES["files"])) {
    $image = new club;
    $path = $image->path;

       foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
        $temp = $_FILES["files"]["tmp_name"][$key];
        $name = $_FILES["files"]["name"][$key];
        $newfilename = $image->rename($name, $maxId);
        //$resize = $image->resize(1200px, $height, $newfilename, $path)
         
        if(!empty($temp)) { 
            if ($image->is_Image($temp)) {

            if(move_uploaded_file($tmp_name, $path.$newfilename)) {
             $queryimg = 'INSERT INTO images (url, type, club_id) VALUES ("'.$newfilename.'", "club", '.$maxId.');';
             $result = $pdo->prepare($queryimg);
             $result->execute();
            }
        }
    }}
}



/*-------------------REDIRECTION-------------------------------- */
if ($retour == "user") {
 header('Location: ../../user_pro_club.php?msg=success');
} else {
  header('Location: ../admin_clubs.php?msg=success');
}


?>