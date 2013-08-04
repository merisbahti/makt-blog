<?php
abstract class news_post {
	function __construct($title, $subtext, $body, $date, $author) {	
		$this->title		= $title;
		$this->subtext	= $subtext;
		$this->body			= $body;
		$this->date 		= $date;
		$this->author		= $author;
	}
}
