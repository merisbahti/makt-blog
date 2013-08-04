<?php
require './model/news_post.class.php';
class picture_post extends news_post {
	function __construct($title, $subtext, $body, $date, $author, $image_uri) {
		parent::_construct($title, $subtext, $body, $date, $author);
		$this->image_uri = $image_uri;
	}

}
