<?php
require_once('_config.php');
include '_head.php';
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
            if ($_GET["msg"] == "failed1") { echo "Veuillez verifier votre identifiant.<br>"; }
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
                <label for="name">Nom</label>
                <p id="msg_nom" class='msg'>Le nom doit avoir au moins 4 charactéres</p>
                <p class="result"></p>
                <br>
                <input type="password" id="mdp" name="mdp">
                <br/>
                <label for="mdp">Mot de passe</label>
                <p id="msg_mdp" class='msg'>Le mot de passe doit avoir au moins 6 charactéres</p>
                <br>
                <input type="password" id="mdp1" name="mdp1">
                <br/>
                <label for="mdp1">Répetez votre mot de passe</label>
                <p id="msg_mdp1" class='msg'>Les mots de passe ne sont pas identiques</p>
                <br/>
                <input type="text" id="mail" name="mail">
                <br/>
                <label for="name">Mail</label>
                <p id="msg_mail" class='msg'>L'addresse mail n'est pas valide</p>
                <br>
                <input type="text" id="mail1" name="mail1">
                <br/>
                <label for="name">Répetez votre mail</label>
                <p id="msg_mail1" class='msg'>Les addresses mail ne sont pas identiques</p>
            </div>
            <div>
                <h4> Mon compte: </h4>
                <input type="radio" name="type" value="normal" checked>Normal
                <input type="radio" name="type" value="pro"> Professionnel
            </div>
            <div>
                <input type="submit" value="Inscription" id="submit_inscription">
                <input type="button" value="ANNULER">
            </div>
        </div>
        </form>

</section>
    <?php include("pages/footer.php"); ?>
</body>
</html>