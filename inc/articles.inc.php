<?php
Class article {

	public $data;

	public function __construct($pdo, $lang) {
		$this->data = self::get_data($pdo, $lang);
		$this->image = self::get_image($this->data);
		$this->path = self::get_image($this->data);
		$this->path_article = self::path_article($this->data);
		$this->titre = self::get_titre($this->data);
		$this->article = self::get_article($this->data);
		$this->short_article = self::get_short_article($this->data);
		$this->tag = self::get_tag($this->data);

	}

	public function get_data($pdo, $lang) {
		$query = "SELECT article.id, article.titre_".$lang.", article.article_".$lang.", article.tag, images.url FROM article
			INNER JOIN images ON article.id=images.article_id
			ORDER BY RAND()
			LIMIT 1
			;";
			$result = $pdo->prepare($query);
			$result->execute();
			$data = $result->fetchAll();

			return $data;
	}

	public function get_image($array) {
		return $array[0]["url"];
	}

	public function get_titre($array) {
		return $array[0][1];
	}

	public function get_article($array) {
		return $array[0][2];
	}

	public function get_short_article($array) {
		$article =  $array[0][2];
		$short = substr($article, 0, 300)."...";
		return $short;
	}

	public function path_article($array) {
		$path = "article.php?id=".$array[0]["id"]."&tag=".$array[0]["tag"];
		return $path;
	}

	public function get_tag($array) {
		return $array[0]["tag"];
	}
}

Class random_club {

	public function __construct($pdo, $lang) {
		$this->data = self::get_data($pdo, $lang);
		$this->image = self::get_image($this->data);
		$this->id = self::get_id($this->data);
		$this->name = self::get_name($this->data);
	}

	public function get_data($pdo) {
		$querycoeur="SELECT club.id, club.name, images.url FROM club
		LEFT JOIN images ON images.club_id=club.id
		ORDER BY RAND()
		LIMIT 1
		;";

		$result_coeur = $pdo->prepare($querycoeur);
		$result_coeur->execute();
		$coeur = $result_coeur->fetchAll();

		return $coeur;
			}

			public function get_image($array) {
				return $array[0]["url"];
			}

			public function get_id($array) {
				return $array[0]["id"];
			}

			public function get_name($array) {
				return $array[0]["name"];
			}
}
?>