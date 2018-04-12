<?php

$langues = array('en','fr');
$lang="fr";

if (isset($_SESSION['lang']) && in_array($_SESSION['lang'], $langues)) { 
	$lang = $_SESSION['lang']; 
}

if (isset($_GET['lang']) && in_array($_GET['lang'], $langues)) { 
	$lang = $_GET['lang'];
}

$_SESSION['lang'] = $lang;


$cont = new content($lang, $pdo);
$content = $cont->content;


class content {

		public function __construct($lang, $pdo) {
			$this->content = self::get_content($lang, $pdo);

		}

		public function get_content($lang, $pdo) {
			$query = "SELECT name, ".$lang." FROM contenu;";
			$result = $pdo->prepare($query);
			$result->execute();
			$result = $result->fetchAll();

			$contenu = [];
			foreach ($result as $key => $value) {
				$contenu[$result[$key]['name']] = $result[$key][1];
			}

			return $contenu;
		}

}
?>
