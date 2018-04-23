<?php
session_start();
require_once('_config.php');
include_once 'inc/langue.inc.php';
include '_head.php';
$page = "inscription";
?>
</head>
<body>
    <?php include("header.php"); ?>
<section class="forme">
    <h1>Inscription</h1>

<?php
        if (isset($_GET["msg"])) {
            if ($_GET["msg"] == "failed1") { echo $content['msg_identifiant']."<br>"; }
            if ($_GET["msg"] == "failed2") { echo "L'identifiant choisi est déjà utilisé.<br>"; }
            if ($_GET["msg"] == "failed3") { echo "Veuillez verifier votre mail.<br>"; }
            if ($_GET["msg"] == "failed4") { echo "Veuillez verifier votre mot de passe.<br>"; }
            if ($_GET["msg"] == "failed5") { echo "Veuillez verifier vos données.<br>"; }
        }
?>

    <form class="edit_club" action="pages/inscription_action.php" method="POST">
        <div>
            <div>
              
                <div id="msg_nom1" class="error_msg"><?php echo $content['error_nom']; ?><div></div></div>
                <div id="msg_nom" class="error_msg"><?php echo $content['msg1']; ?><div></div></div>
                <input type="text" id="username" name="username">
                <br/>
                <label for="name"><?php echo $content['nom']; ?></label>
                <br>
                <div id="msg_mdp" class="error_msg"><?php echo $content['msg2']; ?><div></div></div>
                <input type="password" id="mdp" name="mdp">
                <br/>
                <label for="mdp"><?php echo $content['mdp']; ?></label>
                <br>
                <div id="msg_mdp1" class="error_msg"><?php echo $content['msg3']; ?><div></div></div>
                <input type="password" id="mdp1" name="mdp1">
                <br/>
                <label for="mdp1"><?php echo $content['mdp_repeat']; ?></label>
                <br/>
                <div id="msg_mail" class="error_msg"><?php echo $content['mail_non_valide']; ?><div></div></div>
                <input type="text" id="mail" name="mail">
                <br/>
                <label for="name"><?php echo $content['mail']; ?></label>
                <br>
                <div id="msg_mail1" class="error_msg"><?php echo $content['msg4']; ?><div></div></div>
                <input type="text" id="mail1" name="mail1">
                <br/>
                <label for="mail1"><?php echo $content['repetez_mail']; ?></label>
            </div>
            <div>
                <br>
                <br>
                <h3><?php echo $content['type_compte']; ?></h3>
                <div class="error_msg" id="savoir1">
                    <?php echo $content['savoir_plus1']; ?>
                </div>
                <span tabindex="0" id="savoir"><?php echo $content['savoir_plus']; ?></span>

                <div id="label_compte">
                    <input type="radio" name="type" id="normal" value="normal" checked>
                    <label tabindex="0" for="normal">
                        <img src="images/avatars/default.svg">
                        <span>Normal</span>
                    </label>

                    <input type="radio" name="type" value="pro" id="pro">
                     <label tabindex="0" for="pro">
                        <img src="images/avatars/default1.svg">
                        <span>Pro</span>
                    </label>
                </div>
            </div>
            <div>
                <div class="error_msg" id="msg_conditions"><div></div>
                    Veuillez accepter les conditions
                </div>
                <br>
                <input type="checkbox" id="conditions" name="conditions">
              
                    <span>J'accepte les <span tabindex="0" id="modal_conditions">conditions générales</span> d'utilisation de ce site</span>
                
                <!-- les conditions d'utilisation de site -->
                <div id="small_font">
                    <span tabindex="0" id="fermer">&#x2716;</span>
                    <div>

                    <?php include ("inc/conditions_generales.inc.php"); ?>
                    </div>
                </div>
                <br><br>
            </div>
            <div>
                <input type="submit" value="Inscription" id="submit_inscription">
                <a tabindex="0" class="btn-empty center" href="index.php"><?php echo $content['annuler']; ?></a>
            </div>
        </div>
        </form>

</section>
    <?php include("pages/footer.php"); ?>
</body>
</html>