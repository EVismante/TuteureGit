<?php
session_start();
require_once('../_config.php');
include_once '../inc/filtres.inc.php';
include_once '../inc/langue.inc.php';

$elem = new recherche;
$result_count = $elem->count();

if ($result_count == 0) { echo "<h3>Pas de résultats</h3>";}
else {
  ?>
  <div class="choix">
    <div id="liste1">
     <?php echo $content["prestataires"]; ?>
    </div>
    <div id="liste2">
      <?php echo $content["evenements"]; ?>
    </div>
  </div>


<?php



for ($i=0; $i < $result_count; $i++)  { 
        $liste = new liste($i, $pdo);

      /*----------------favoris----------*/
      if (isset($_SESSION["id"])) {

      $favquery = 'SELECT * FROM favoris
      WHERE user_id= '.$_SESSION["id"].'
      AND page_id= '.$liste->id.'
      AND page_type="'.$liste->type.'"
      ;';

      $result1 = $pdo->prepare($favquery);
      $result1->execute();
      $result1->fetchAll();
      $fav = $result1->rowCount();

    }
/*----------------------------------------*/

  if ($liste->type == "club") { ?>


    <div id="club_<?php echo $i; ?>" class="liste_clubs" data-markerid="<?php echo $i; ?>">
        <img class="club_icon" src="images/clubs/<?php echo $liste->image; ?>" alt="icon">
        <div>
<?php /*debut de checkbox favoris */
if (isset($_SESSION["id"])) { ?>
              <input type="checkbox" name="favori" value="favori" id="favori_club<?php echo $liste->id; ?>" <?php if($fav > 0) {echo "checked";} ?> onclick="addFavori(<?php echo $liste->id; ?>, 'club', false)">
              <label for="favori_club<?php echo $liste->id; ?>">
          <?php if($fav > 0) { ?>
              <img src="images/website/icons/heart-pleine.svg" class="heart_icon" alt="supprimer le favori">
<?php         } else { ?>
              <img src="images/website/icons/heart-vide.svg" class="heart_icon" alt="ajouter aux favoris">
<?php           }?>
          
           </label>

<?php } else { ?>
          <a class="heart_icon" href="login.php"><img src="images/website/icons/heart-vide.svg"></a>
<?php
  } /*fin de checkbox favoris*/
 ?>
          </div>
        <div>
          <h3><?php echo $liste->name; ?></h3>
          <span class="address"><?php echo $liste->addresse; ?></span>
          <br>
          <a href="club.php?id=<?php echo $liste->id; ?>&p=recherche">Consulter</a>
        </div>
      </div>


<?php } 

   if ($liste->type == "event") { ?>

    <div id="event_<?php echo $i; ?>" class="liste_events">
        <img class="club_icon" src="images/events/default.jpg" alt="icon">
        <div>
<?php /*debut de checkbox favoris */
if (isset($_SESSION["id"])) { ?>
              <input type="checkbox" name="favori" value="favori" id="favori_event<?php echo $liste->id; ?>" <?php if($fav > 0) {echo "checked";} ?> onclick="addFavori(<?php echo $liste->id; ?>, 'event', false)">
              <label for="favori_event<?php echo $liste->id; ?>">
          <?php if($fav > 0) { ?>
              <img src="images/website/icons/heart-pleine.svg" class="heart_icon" alt="supprimer le favori">
<?php         } else { ?>
              <img src="images/website/icons/heart-vide.svg" class="heart_icon" alt="ajouter aux favoris">
<?php           }?>
          
           </label>

<?php } else { ?>
          <a class="heart_icon" href="login.php"><img src="images/website/icons/heart-vide.svg"></a>
<?php
  } /*fin de checkbox favoris*/
 ?>
          </div>
        <div>
          <h3><?php echo $liste->name; ?></h3>
          <span class="address"><?php echo $liste->addresse; ?></span>
          <br>
          <a href="event.php?id=<?php echo $liste->id; ?>&p=recherche">Consulter</a>
        </div>
      </div>

<?php }
    }}