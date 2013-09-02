<?php
require './model/news_post.class.php';
class picture_post {
	function __construct($title, $subtext, $body, $date, $author, $image_uri) {
		parent::__construct($title, $subtext, $body, $date, $author, "\"<img src=\"".$image_uri."\" class=\"img-responsive\"/>");
		$this->image_uri = $image_uri;
		//$this->rendered_content = "\"<img src=\"".$image_uri."\" class=\"img-responsive\"/>";
	}
	
	function render_content(){
		echo $this->rendered_content;
	}

}
