<?php
class news_post {
	function __construct($title, $sub_text, $body, $date, $author, $rendered_content) {	
		$this->title		= $title;
		$this->sub_text		= $sub_text;
		$this->body			= $body;
		$this->date 		= $date;
		$this->author		= $author;
		$this->rendered_content = $rendered_content;
	}
}
