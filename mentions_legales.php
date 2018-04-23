<?php

require_once('_config.php');
$page = "clubs";
session_start();
include_once 'inc/langue.inc.php';
	//VERIFIER SI UTILISATEUR EST CONNECTE//
	if ( !isset($_SESSION["user"]) ) {
		$header = "header.php";
	} else {
		$header = "user_header.php";
	}



/*---------------------*/
include '_head.php';
$page="mentions";
?>

</head>
<body>
	<?php include($header); ?>

<section class="content clearfix">
	<h3>Mentions légales</h3>
	<h3>réalisation et maintenance du site internet</h3>
	<p>
		Eglé Vismanté<br>
		egle.vismante@gmail.com<br>
		18 av Ménard, 06000 NICE<br>
		07.50.32.29.10<br>
	</p>
	<h3>Coordonées du hébergeur</h3>
    <p>
    	Ce site internet est hébergé par : 
    	-
    </p>
    <p>
    <h3>Droits de proprieté intellectuelle</h3>
     Le contenu du site Equo Vadis (notamment données, informations, illustrations, logos, marques, etc.) est protégé au titre du droit d'auteur et autres droits de propriété intellectuelle. Toute copie, reproduction, représentation, adaptation, diffusion, intégrale ou partielle, du contenu du site internet du Equo Vadis, par quelque procédé que ce soit, est illicite à l'exception d'une unique copie, sur un seul ordinateur et réservée à l'usage exclusivement privé du copiste. Les éléments présentés dans ce site sont susceptibles de modification sans préavis et sont mis à disposition sans aucune garantie d'aucune sorte, expresse ou tacite, d'aucune sorte et ne peuvent donner lieu à un quelconque droit à dédommagement.</p>

     <p>Les icônes utilisées sur ce site ont été réalisées par Gregor Cresnar sur FLATICON et Eglé Vismanté</p>

</section>

	<?php 
	include("pages/footer.php"); 

	?>
</body>
</html>