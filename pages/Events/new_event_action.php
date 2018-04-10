<?php
require_once('../../_config.php');
require_once ('../../inc/images.inc.php');

$name_FR = addslashes($_POST["name_FR"]);
$name_EN = addslashes($_POST["name_EN"]);

$fr = addslashes($_POST["description_FR"]);
$en = addslashes($_POST["description_EN"]);

$website = addslashes($_POST["site_web"]);
$mail = addslashes($_POST["mail"]);
$date = $_POST["date"];
$address = $_POST["address"];
$user_id = $_POST["user_id"];
$retour = $_POST["retour"];
/*-------------------Function geocode-------------------------------- */
include '../../inc/geocode.inc.php';
$geo_data = geocode($address);
$long = $geo_data["long"];
$lat = $geo_data["lat"];



$queryEvent = "
INSERT INTO event (titre_FR, titre_EN, address, website, date, mail, longt, lat, description_FR, description_EN, user_id)
VALUES ('$name_FR',
        '$name_EN',
        '$address',
        '$website',
        '$date',
        '$mail',
        '$long',
        '$lat',
        '$fr',
        '$en',
        '$user_id'
);";

var_dump($queryEvent);
$result = $pdo->prepare($queryEvent);
$result->execute();


/*-------------------UPLOAD DES IMAGES-------------------------------- */

/*trouve le dernier ID du club */
$maxId = "SELECT MAX(id) FROM event";
$r = $pdo->prepare($maxId);
$r->execute();
$maxId = $r->fetch();

$maxId=$maxId["MAX(id)"];


ini_set ('gd.jpeg_ignore_warning', 1);

if (isset($_FILES["files"])) {
    $image = new event;
    $path = $image->path;
       foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
        $temp = $_FILES["files"]["tmp_name"][$key];
        $name = $_FILES["files"]["name"][$key];
        $newfilename = $image->rename($name, $maxId);
         
        if(!empty($temp)) { 
            if ($image->is_Image($temp)) {

            if(move_uploaded_file($tmp_name, $path.$newfilename)) {
             $queryimg = 'INSERT INTO images (url, type, event_id) VALUES ("'.$newfilename.'", "event", '.$maxId.');';
             $result = $pdo->prepare($queryimg);
             $result->execute();
            }
        }
    }  }
}



/*-------------------REDIRECTION-------------------------------- */
if ($retour == "user") {
    header('Location: ../../user_events.php?msg=success');
} else {
    header('Location: ../admin_events.php?msg=success');
}


?>