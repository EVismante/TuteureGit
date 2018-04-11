<?php
Class article {

	public $data;

	public function __construct($pdo) {
		$this->data = self::get_data($pdo);
		$this->image = self::get_image($this->data);
		$this->path = self::get_image($this->data);
		$this->path_article = self::path_article($this->data);
		$this->titre = self::get_titre($this->data);
		$this->article = self::get_article($this->data);
		$this->short_article = self::get_short_article($this->data);
		$this->tag = self::get_tag($this->data);

	}

	public function get_data($pdo) {
		$query = "SELECT article.id, article.titre_FR, article.article_FR, article.tag, images.url FROM article
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

	public function get_short_article($array) {
		$article =  $array[0]["article_FR"];
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

?>