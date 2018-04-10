<?php
require_once('../../_config.php');

$name_EN = $_POST["name_EN"];
$name_FR = $_POST["name_FR"];

$fr = $_POST["description_FR"];
$en = $_POST["description_EN"];

$website = $_POST["site_web"];
$mail = $_POST["mail"];
$date = $_POST["date"];
$address = $_POST["address"];
$user_id = $_POST["user_id"];
$id = $_POST["id"];
$retour = $_POST["retour"];

/*-------------------Function geocode-------------------------------- */
include '../../inc/geocode.inc.php';
$geo_data = geocode($address);
$longt = $geo_data['long'];
$lat = $geo_data['lat'];


$queryEvent = "UPDATE event SET 
titre_FR = '$name_FR', 
titre_EN = '$name_EN',
address = '$address',
website = '$website',
date = '$date',
mail = '$mail',
longt = '$longt',
lat = '$lat',
description_FR = '$fr',
description_EN = '$en',
user_id = '$user_id'
WHERE id = ".$id.";";


$result = $pdo->prepare($queryEvent);
$result->execute();

/*-------------------UPLOAD DES IMAGES-------------------------------- */
include '../../inc/images.inc.php';
ini_set ('gd.jpeg_ignore_warning', 1);


    $image = new event;
    $path = $image->path;

if (isset($_FILES["files"])) {
       foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
        $temp = $_FILES["files"]["tmp_name"][$key];
        $name = $_FILES["files"]["name"][$key];
        $newfilename = $image->rename($name, $id);
         
        if(!empty($temp)) { 
            if ($image->is_Image($temp)) {

            if(move_uploaded_file($tmp_name, $path.$newfilename)) {
             $queryimg = 'INSERT INTO images (url, type, event_id) VALUES ("'.$newfilename.'", "event", '.$id.');';
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
    header('Location: ../../user_events.php?msg=success');
} else {
    header('Location: ../admin_events.php?msg=success');
}


?>