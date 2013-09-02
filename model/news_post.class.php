<?php
class news_post {
	function __construct($title, $subtext, $body, $date, $author, $rendered_content) {	
		$this->title		= $title;
		$this->subtext		= $subtext;
		$this->body			= $body;
		$this->date 		= $date;
		$this->author		= $author;
		$this->rendered_content = $rendered_content;
	}
}
