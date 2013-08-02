<meta charset="utf-8">
<?php require 'vendor/autoload.php';
$app = new \Slim\Slim();

include("rb/rb.php");

R::setup("sqlite:db.db");

$app->get('/', function() use ($app) {
      $news = R::findAll('news',' ORDER BY id LIMIT 10 ');
      $view = $app->view();
      $view->setData("foo", "bar");
      $view->setData("app", $app);
      $view->setData("news", $news);
      $view->setData("view", $view);
      $app->render('index-template.html');
    });

$app->get('/page/:number',function($number) {
      echo $number;
    });

$app->get('/testDB', function() use ($app) {
      $app->render('../model/test_db_init.php');
    });
$app->run();
?>
