<?php
session_start();

require_once('_config.php');
include 'inc/login.inc.php';
include_once 'inc/langue.inc.php';
include '_head.php';
$page = "login";
 
?>
</head>
<body>
	<?php include("header.php"); ?>
<section class="forme">
<?php
if (isset($_GET['msg']) && $_GET["msg"] == 'inscription' ) {
    echo "<div id='msg_success'><div>".$content['msg_inscription']."</div></div>";
}
?>
	<h1><?php echo $content['menu6']; ?></h1>
    <img class ="in_middle" src="images/website/1.svg" alt="">
    	<form class="edit_club" action="login-action.php" method="POST">
            <div>
                <div>
                    <div class='msg2 error_msg'>
                        <?php echo $content['msg_identifiant']; ?>
                        <div></div>
                    </div>
            		<input type="text" id="name" name="name">
                    <br/>
            		<label for="name"><?php echo $content['nom']; ?></label>
                    <br/>
                    <div class='msg3 error_msg'>
                        <?php echo $content['error_mdp']; ?>
                        <div></div>
                    </div>
            		<input type="password" id="mdp" name="mdp">
                    <br/>
            		<label for="mdp"><?php echo $content['mdp']; ?></label>
            		<br/>
                </div>
                <div class='msg1'>
                    <?php echo $content['msg_login']; ?>
                    <div></div>
                </div>
  <?php 
            if (isset($_GET["msg"]) && $_GET["msg"] == 'failed') {
                echo "<div class='msg'>".$content['msg_login']." </div>";}; ?>
                
            		<input type="submit" value="LOGIN" id="submit_login">
            		<a class="btn-empty center" href="index.php"><?php echo $content['annuler']; ?></a>

 
        		 
            </div>         
                <a class="btn_blue" href="inscription.php"><?php echo $content['not_member']; ?></a>
    	</form>

</section>
	<?php include("pages/footer.php"); ?>
</body>
</html>