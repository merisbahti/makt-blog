<meta charset="utf-8">
<?php
require 'vendor/autoload.php';
require 'rb/rb.php';
require 'model/picture_post.class.php';

R::setup("sqlite:db.db");

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
