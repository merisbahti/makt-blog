<meta charset="utf-8">
<?php require 'vendor/autoload.php';
$app = new \Slim\Slim();

$app->get('/', function() use ($app) {
      $view = $app->view();
      $view->setData("foo", "bar");
      $app->render('index-template.html');
    });

$app->get('/page/:number',function($number) {
      echo $number;
    });
$app->run();
?>
