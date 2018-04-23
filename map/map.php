<?php

require_once('../_config.php');
include_once '../inc/langue.inc.php';

$recherche = trim($_GET['club']);
$recherche = addslashes($recherche);
$mots_cles = explode( " ", $recherche);


/*
Inspiration: 
https://www.owasp.org/index.php/SQL_Injection_Prevention_Cheat_Sheet
*/
/*-----*/
//Si il y plusieurs cles de la recherche
$clefs = "";

foreach ($mots_cles as $cle => $value) {

    if ($cle > 0) {
      $clefs .= " AND ";
    }

  $clefs .= "( club.name LIKE '%$value%'
              OR
              club.address LIKE '%$value%'
              OR
              tag.name_FR LIKE '%$value%' ) ";
};


$query = "
SELECT DISTINCT club.id, club.name, club.address, club.longt, club.lat, tag.name_FR FROM club 
LEFT JOIN club_tag ON club_tag.club_id=club.id
LEFT JOIN tag ON club_tag.tag_id=tag.id
WHERE ".$clefs.tags('tag.name_'.$lang).";";

$result = $pdo->prepare($query);
/*
foreach ($mots_cles as $cle => $value) {
  $result->bindValue(':value['.$cle.']', $value[$cle], PDO::PARAM_STR);

}
*/

$result->execute();
$item = $result->fetchAll();
$etat = $result->rowCount();


/*____XML__________________________*/
include '../inc/filtres.inc.php';
$makeXML = new recherche;



/*-----------------------------------------------------------------------------*/
/*-----*/
//Si il y plusieurs cles de la recherche
$clefs = "";

foreach ($mots_cles as $cle => $value) {

    if ($cle > 0) {
      $clefs .= " AND ";
    }

  $clefs .= "( titre_fr LIKE '%$value%'
              OR
              titre_en LIKE '%$value%'
              OR
              address LIKE '%$value%'
              OR
              tags LIKE :recherche
               ) ";
};


$query_event = "
SELECT id, titre_fr, titre_en, address, longt, lat  FROM event
WHERE ".$clefs.tags('tags').";";


$result1 = $pdo->prepare($query_event);
$result1->bindValue(':recherche', $recherche, PDO::PARAM_STR);
$result1->execute();
$item1 = $result1->fetchAll();


$etat1 = $result1->rowCount();

  /*____XML__________________________*/

if (!isset($_GET['event'])) {

  $makeXML->writeXML($item, $item1);
  header('Location: ../recherche.php');

} else {

    //utilisateur a choisi que les prestataires
    if ($_GET['event'] == "false") { 
        $makeXML->writeXML($item, FALSE); 
    } 

    // utilisateur a choisi que les evenements
    if ($_GET['prestation'] == "false") { 
        $makeXML->writeXML(FALSE, $item1); 
    }

    // utilisateur ne veut aucun résultat, :(
    if ($_GET['prestation'] == "false" && $_GET['event'] == "false") {
      $makeXML->writeXML(FALSE, FALSE);
    } 

    // utilisateur a choisi les prestations et les evenements
    if ($_GET['prestation'] == "true" && $_GET['event'] == "true") {
      $makeXML->writeXML($item, $item1);
    } 
    /*affichage de liste----*/
    include 'liste.inc.php';
}

/*----------------------------------------*/

/*----------------------------------------*/

function tags($elt) {
  $tags = "";

  if (isset($_GET['filtre'])) {
  foreach($_GET['filtre'] as $order => $selected){
    if($order == 0) { $tags .= ' AND ( '.$elt.' LIKE "%'.$selected.'%"'; 
      } else { $tags .= ' OR '.$elt.' LIKE "%'.$selected.'%"'; }
}
    $tags .= ")";
}
return $tags;
}

function tags_event() {
  $tags = "";

  if (isset($_GET['filtre'])) {
  foreach($_GET['filtre'] as $order => $selected){
    if($order == 0) { $tags .= ' AND ( tags LIKE "%'.$selected.'%"'; 
      } else { $tags .= ' OR tags LIKE "%'.$selected.'%"'; }
}
    $tags .= ")";
}
return $tags;
}

?>



