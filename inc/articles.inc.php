<?php
Class article {

	public $data;

	public function __construct($pdo) {
		$this->data = self::get_data($pdo);
		$this->image = self::get_image(self::get_data($pdo));
		$this->titre = self::get_titre(self::get_data($pdo));
		$this->article = self::get_article(self::get_data($pdo));
	}

	public function get_data($pdo) {
		$query = "SELECT article.titre_FR, article.article_FR, images.url FROM article
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
		return $array[0]["titre_FR"];
	}

	public function get_article($array) {
		return $array[0]["article_FR"];
	}
}

?>