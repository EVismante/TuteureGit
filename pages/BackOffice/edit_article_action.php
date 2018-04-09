<?php
require_once('../../_config.php');
require_once ('../../inc/images.inc.php');

$titre_FR = addslashes($_POST["titre_FR"]);
$titre_EN = addslashes($_POST["titre_EN"]);
$article_FR = addslashes($_POST["article_FR"]);
$article_EN = addslashes($_POST["article_EN"]);
$tag = $_POST["tag"];
$id = $_POST["id"];

$query = "UPDATE article SET 
titre_FR = '$titre_FR', 
titre_EN = '$titre_FR',
article_FR = '$article_FR',
article_EN = '$article_EN',
tag = '$tag[0]'
WHERE id = ".$id.";";

$result = $pdo->prepare($query);
$result->execute();
/*-------------------UPLOAD DES IMAGES-------------------------------- */
ini_set ('gd.jpeg_ignore_warning', 1);

if (isset($_FILES["files"])) {
    $image = new article;
    $path = $image->path;

       foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
        $temp = $_FILES["files"]["tmp_name"][$key];
        $name = $_FILES["files"]["name"][$key];
        $newfilename = $image->rename($name, $id);

        if(!empty($temp)) { 
            if ($image->is_Image($temp)) {

            if(move_uploaded_file($tmp_name, $path.$newfilename)) {
             $queryimg = 'INSERT INTO images (url, type, article_id) VALUES ("'.$newfilename.'", "article", '.$id.');';
             $result = $pdo->prepare($queryimg);
             $result->execute();
         
            }
        }
    }}
}



/*supprimer les images*/

if (isset($_POST["delete_img"])) {
    $delete_image = $_POST["delete_img"];
    foreach ($delete_image as $key => $id) {
        $image->delete($id, $pdo);
    }
};
/*-------------------REDIRECTION-------------------------------- */
header('Location: ../admin_articles.php?msg=success');

?>