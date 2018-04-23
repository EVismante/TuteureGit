<?php
session_start();
require_once('_config.php');
include_once 'inc/langue.inc.php';
$page = "404";
include '_head.php';
?>
</head>
<body>
<section class="forme">
    <div>
        <div>
	       <h1>404</h1>
            <p class="msg">
            	Désolé !<br>
            	La page que vous cherchez n'existe pas.<br>
            	<a href="index.php">Revenir à la page d'accueil</a>
            </p>
        </div>
    </div>
    	

</section>
</body>
</html>