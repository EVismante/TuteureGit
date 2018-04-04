<?php
require_once('../../_config.php');
require_once ('../../inc/images.inc.php');

$titre_FR = addslashes($_POST["titre_FR"]);
$titre_EN = addslashes($_POST["titre_EN"]);
$article_FR = addslashes($_POST["article_FR"]);
$article_EN = addslashes($_POST["article_EN"]);
$tag = $_POST["tag"];


$query = "
INSERT INTO article (titre_FR, titre_EN, article_FR, article_EN, date, tag)
VALUES ('$titre_FR',
        '$titre_EN',
        '$article_FR',
        '$article_EN',
        now(),
        $tag
);";


$result = $pdo->prepare($query);
$result->execute();

/*trouve le dernier ID du club */
$maxId = "SELECT MAX(id) FROM article";
$r = $pdo->prepare($maxId);
$r->execute();
$maxId = $r->fetch();

$maxId=$maxId["MAX(id)"];


/*-------------------UPLOAD DES IMAGES-------------------------------- */
ini_set ('gd.jpeg_ignore_warning', 1);

if (isset($_FILES["files"])) {
    $image = new article;
    $path = $image->path;
       foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
        $temp = $_FILES["files"]["tmp_name"][$key];
        $name = $_FILES["files"]["name"][$key];
        $newfilename = $image->rename($name, $tag);
         
        if(!empty($temp)) { 
            if ($image->is_Image($temp)) {

            if(move_uploaded_file($tmp_name, $path.$newfilename)) {
             $queryimg = 'INSERT INTO images (url, type, article_id) VALUES ("'.$newfilename.'", "article", '.$maxId.');';
             $result = $pdo->prepare($queryimg);
             $result->execute();
            }
        }
    }}
}



/*-------------------REDIRECTION-------------------------------- */

header('Location: ../admin_articles.php?msg=success');


?>