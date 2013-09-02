<?php
abstract class news_post {
	function __construct($title, $subtext, $body, $date, $author) {	
		$this->title		= $title;
		$this->subtext		= $subtext;
		$this->body			= $body;
		$this->date 		= $date;
		$this->author		= $author;
	}
	/*
	* Returns a HTML Blob with relevant media content.
	*/
	abstract function render_content(); 
}
