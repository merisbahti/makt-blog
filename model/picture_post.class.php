<?php
require './model/news_post.class.php';
class picture_post extends news_post {
	function __construct($title, $subtext, $body, $date, $author, $image_uri) {
		parent::__construct($title, $subtext, $body, $date, $author);
		$this->image_uri = $image_uri;
	}
	
	function render_content(){
		echo "\"<img src=\"" + $this->image_uri + "\" class=\"img-responsive\"/>";
	}

}
