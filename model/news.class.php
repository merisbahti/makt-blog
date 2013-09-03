<?php

class news {
	private static $amount = 5;
	
	public static function _getNbrOfPages(){
		return R::count("news")/self::$amount;
	}

	public static function _getNews($pageNumber) {
		$nbr_of_posts = R::count("news");
		$max = $nbr_of_posts - ($pageNumber - 1) * 5;
		$min = $max - 5;
		$news = R::findAll('news', ' WHERE id <= :max AND id > :min ORDER BY id DESC LIMIT :amount', array('max' => $max, 'min' => $min, 'amount' => self::$amount));		
		
		return $news;
	}

	public static function _storeNewsPost($post, $root_uri) {
		$newsPost = R::dispense("news");
		$newsPost -> title = $post->title;
		$newsPost -> sub_text = $post->sub_text;
		$newsPost -> rendered_content= $post->rendered_content;
		$newsPost -> body = $post->body;
		$newsPost -> date = $post->date;
		$newsPost -> author = $post->author;
		$id = R::store($newsPost);
	}

}
?>