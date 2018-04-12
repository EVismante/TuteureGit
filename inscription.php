<?php
session_start();
require_once('_config.php');
include '_head.php';
include_once 'inc/langue.inc.php';
$page = "inscription";
?>
<script type="text/javascript" src="../js/inscription.js"></script>
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
                <input type="text" id="username" name="username">
                <br/>
                <label for="name"><?php echo $content['nom']; ?></label>
                <p id="msg_nom" class='msg'>Le nom doit avoir au moins 4 charactéres</p>
                <br>
                <input type="password" id="mdp" name="mdp">
                <br/>
                <label for="mdp"><?php echo $content['mdp']; ?></label>
                <p id="msg_mdp" class='msg'>Le mot de passe doit avoir au moins 6 charactéres</p>
                <br>
                <input type="password" id="mdp1" name="mdp1">
                <br/>
                <label for="mdp1"><?php echo $content['mdp_repeat']; ?></label>
                <p id="msg_mdp1" class='msg'>Les mots de passe ne sont pas identiques</p>
                <br/>
                <input type="text" id="mail" name="mail">
                <br/>
                <label for="name"><?php echo $content['mail']; ?></label>
                <p id="msg_mail" class='msg'><?php echo $content['mail_non_valide']; ?></p>
                <br>
                <input type="text" id="mail1" name="mail1">
                <br/>
                <label for="name"><?php echo $content['repetez_mail']; ?></label>
                <p id="msg_mail1" class='msg'>Les addresses mail ne sont pas identiques</p>
            </div>
            <div>
                <p><?php echo $content['type_compte']; ?></p>
                <input type="radio" name="type" id="normal" value="normal" checked>
                <label for="normal">
                    Normal
                    <img src="images/website/icons/normal.svg">
                </label>
                <input type="radio" name="type" value="pro" id="pro">
                 <label for="pro">
                    Pro
                    <img src="images/website/icons/pro.svg">
                </label>
                <div class="expand">
                    Si vous avez une préstation à offrir, optez pour pro.
                    Si vous voulez trouver un club ou poster un évènement, un compte normal est pour vous.
                </div>
            </div>
            <div>
                <input type="submit" value="Inscription" id="submit_inscription">
                <input type="button" value="<?php echo $content['annuler']; ?>">
            </div>
        </div>
        </form>

</section>
    <?php include("pages/footer.php"); ?>
</body>
</html>