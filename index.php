<meta charset="utf-8">
<?php
require 'vendor/autoload.php';
require "rb/rb.php";

R::setup("sqlite:db.db");
/*$newsPost = R::dispense("news");
$newsPost->title = "Tim åker till gotland 2";
$newsPost->subtext = "Men inte utan sin älskling!";
$newsPost->body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vel neque pellentesque, lobortis diam at, feugiat augue. Aenean suscipit sed sapien eget consequat. Ut et accumsan nisi, at semper mauris. Nulla facilisi. Mauris luctus euismod consequat. Vivamus quis lorem tempor, placerat libero a, facilisis ipsum. Maecenas lacinia a neque at faucibus. In gravida tincidunt iaculis. Etiam interdum elit turpis, mollis gravida neque sagittis eget. Duis vel semper sem. Nulla faucibus pharetra massa quis facilisis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Suspendisse mi nunc, vestibulum in ultrices et, auctor in magna. Proin id mattis eros. Mauris ut justo malesuada nulla iaculis vehicula eleifend eget lectus. Quisque congue suscipit ipsum, sit amet ullamcorper turpis fermentum vitae. Pellentesque erat nulla, lacinia eu ultrices quis, sollicitudin et ligula. Nullam vitae ante non sapien sodales ultrices. Morbi dictum leo odio, nec imperdiet massa vestibulum id. Praesent tincidunt, dui ut varius pretium, ante nunc commodo enim, vel pharetra nisi erat sit amet orci. Integer nec congue lorem, sit amet facilisis diam. Vivamus vestibulum in velit a lacinia. Vivamus sit amet velit nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vivamus rhoncus nulla eu lorem malesuada ornare. Quisque laoreet dolor et libero porta, sit amet laoreet eros viverra. Quisque dapibus sagittis metus, ultrices bibendum orci fermentum et. Fusce id mauris dictum, elementum magna non, imperdiet justo. Morbi a venenatis risus. Suspendisse vitae nulla et lectus egestas laoreet. Cras tincidunt felis id augue convallis tempor.";
$newsPost->date = "2013-05-07";
$newsPost->author = "Arthur Author";
$id = R::Store($newsPost);
*/
$app = new \Slim\Slim();
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader);

$amount = 5;
$root_uri = "http://".substr($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'], 0, -9);

$app->get('/', function() use ($twig,$amount, $root_uri) {
		$news	= R::findAll('news',' ORDER BY id DESC LIMIT :amount ', array('amount' => $amount));
		echo $twig->render('news-template.html', array('news' => $news, 'root_uri' => $root_uri, 'page_nbr' => 1));
    });
    
$app->get('/news/', function() use ($twig,$amount,$root_uri) {
		$news	= R::findAll('news',' ORDER BY id DESC LIMIT :amount ', array('amount' => $amount));
		echo $twig->render('news-template.html', array('news' => $news, 'root_uri' => $root_uri, 'page_nbr' => 1));
    });

$app->get('/news/page/:number',function($number) use($twig,$amount,$root_uri) {
      $nbr_of_posts = R::count("news");
      $max = $nbr_of_posts - ($number-1)*5;
      $min = $max-5;
      $news	= R::findAll('news',' WHERE id <= :max AND id > :min ORDER BY id DESC LIMIT :amount', array('max' => $max,'min' => $min, 'amount' => $amount ));
      echo $twig->render('news-template.html', array('news' => $news, 'root_uri' => $root_uri, 'page_nbr' => $number, 'end_page' => $nbr_of_posts/5));
    });

$app->get('/testDB', function() use ($app) {
      $app->render('../model/test_db_init.php');
    });
$app->run();

?>
