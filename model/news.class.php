<?php

class news {

	public static function _getNews($pageNumber) {
		$amount = 5;
		$nbr_of_posts = R::count("news");
		$max = $nbr_of_posts - ($pageNumber - 1) * 5;
		$min = $max - 5;
		$news = R::findAll('news', ' WHERE id <= :max AND id > :min ORDER BY id DESC LIMIT :amount', array('max' => $max, 'min' => $min, 'amount' => $amount));		
		
		return $news;
	}

	public static function _storeNewsPost($post, $root_uri) {
		$newsPost = R::dispense("news");
		$newsPost -> title = "Tim åker till gotland";
		$newsPost -> subtext = "Men inte utan sin älskling!";
		$newsPost -> rendered_content= $post->rendered_content;
		//$newsPost -> rendered_content = $root_uri.'img/WP_20130620_007.jpg';
		//echo $newsPost->image_uri;
		$newsPost -> body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vel neque pellentesque, lobortis diam at, feugiat augue. Aenean suscipit sed sapien eget consequat. Ut et accumsan nisi, at semper mauris. Nulla facilisi. Mauris luctus euismod consequat. Vivamus quis lorem tempor, placerat libero a, facilisis ipsum. Maecenas lacinia a neque at faucibus. In gravida tincidunt iaculis. Etiam interdum elit turpis, mollis gravida neque sagittis eget. Duis vel semper sem. Nulla faucibus pharetra massa quis facilisis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Suspendisse mi nunc, vestibulum in ultrices et, auctor in magna. Proin id mattis eros. Mauris ut justo malesuada nulla iaculis vehicula eleifend eget lectus. Quisque congue suscipit ipsum, sit amet ullamcorper turpis fermentum vitae. Pellentesque erat nulla, lacinia eu ultrices quis, sollicitudin et ligula. Nullam vitae ante non sapien sodales ultrices. Morbi dictum leo odio, nec imperdiet massa vestibulum id. Praesent tincidunt, dui ut varius pretium, ante nunc commodo enim, vel pharetra nisi erat sit amet orci. Integer nec congue lorem, sit amet facilisis diam. Vivamus vestibulum in velit a lacinia. Vivamus sit amet velit nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vivamus rhoncus nulla eu lorem malesuada ornare. Quisque laoreet dolor et libero porta, sit amet laoreet eros viverra. Quisque dapibus sagittis metus, ultrices bibendum orci fermentum et. Fusce id mauris dictum, elementum magna non, imperdiet justo. Morbi a venenatis risus. Suspendisse vitae nulla et lectus egestas laoreet. Cras tincidunt felis id augue convallis tempor.";
		$newsPost -> date = "2013-05-07";
		$newsPost -> author = "Arthur Author";
		$id = R::store($newsPost);
	}

}
?>