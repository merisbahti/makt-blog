<meta charset="utf-8">
<?php require 'vendor/autoload.php';
$app = new \Slim\Slim();

$app->get('/', function() {
    echo "Index requested!";
});

$app->get('/page/:number',function($number) {
      echo $number;
    });
$app->run();
?>
