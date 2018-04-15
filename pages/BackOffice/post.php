<?php
session_start();
require_once('../../_config.php');

$nom = addslashes($_POST["name"]);
$mail = addslashes($_POST["mail"]);
$msg = addslashes($_POST["subject"]);

if (isset($_SESSION["id"])) {
    $user_id = $_SESSION["id"];
} else {
    $user_id= "NULL";
}


$query = "
INSERT INTO contact (name, mail, message, user_id, date)
VALUES ('$nom',
        '$mail',
        '$msg',
        '$user_id',
        now()
);";


$result = $pdo->prepare($query);
$result->execute();


/*-------------------REDIRECTION-------------------------------- */

header('Location: ../../contact.php?msg=success');


?>