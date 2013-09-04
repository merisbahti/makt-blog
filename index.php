<meta charset="utf-8">
<?php
require 'vendor/autoload.php';
require 'rb/rb.php';
require 'model/news.class.php';
require 'model/news_post.class.php';
require 'model/login_handler.class.php';

#$toDatabse = base64_encode(serialize($data));  // Save to database
#$fromDatabase = unserialize(base64_decode($data)); //Getting Save Format 


R::setup("sqlite:db.db");

$root_uri = "http://".substr($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'], 0, -9);

$post = new news_post('Tim åker till gotland!',
									 'Men inte utan sin älskling!',
									 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vel neque pellentesque, lobortis diam at, feugiat augue. Aenean suscipit sed sapien eget consequat. Ut et accumsan nisi, at semper mauris. Nulla facilisi. Mauris luctus euismod consequat. Vivamus quis lorem tempor, placerat libero a, facilisis ipsum. Maecenas lacinia a neque at faucibus. In gravida tincidunt iaculis. Etiam interdum elit turpis, mollis gravida neque sagittis eget. Duis vel semper sem. Nulla faucibus pharetra massa quis facilisis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Suspendisse mi nunc, vestibulum in ultrices et, auctor in magna. Proin id mattis eros. Mauris ut justo malesuada nulla iaculis vehicula eleifend eget lectus. Quisque congue suscipit ipsum, sit amet ullamcorper turpis fermentum vitae. Pellentesque erat nulla, lacinia eu ultrices quis, sollicitudin et ligula. Nullam vitae ante non sapien sodales ultrices. Morbi dictum leo odio, nec imperdiet massa vestibulum id. Praesent tincidunt, dui ut varius pretium, ante nunc commodo enim, vel pharetra nisi erat sit amet orci. Integer nec congue lorem, sit amet facilisis diam. Vivamus vestibulum in velit a lacinia. Vivamus sit amet velit nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vivamus rhoncus nulla eu lorem malesuada ornare. Quisque laoreet dolor et libero porta, sit amet laoreet eros viverra. Quisque dapibus sagittis metus, ultrices bibendum orci fermentum et. Fusce id mauris dictum, elementum magna non, imperdiet justo. Morbi a venenatis risus. Suspendisse vitae nulla et lectus egestas laoreet. Cras tincidunt felis id augue convallis tempor.',
									 '2013-05-07',
									 'Arthur Author',
									 '<img src="'.$root_uri.'img/WP_20130620_007.jpg" class="img-responsive"/>');

news::_storeNewsPost($post, $root_uri);

session_start();
$app = new \Slim\Slim();
$loader = new Twig_Loader_Filesystem('./templates');
$twig = new Twig_Environment($loader);

$nbrOfPages = news::_getNbrOfPages();

$app->get('/', function() use ($twig, $root_uri, $nbrOfPages) {
		$news = news::_getNews(1);
		echo $twig->render('news-template.html', array('news' => $news, 'root_uri' => $root_uri, 'page_nbr' => 1, 'nbr_of_pages' => $nbrOfPages));
    });
    
$app->get('/news/', function() use ($twig,$root_uri, $nbrOfPages) {
		$news = news::_getNews(1);
		echo $twig->render('news-template.html', array('news' => $news, 'root_uri' => $root_uri, 'page_nbr' => 1, 'nbr_of_pages' => $nbrOfPages));
    });

$app->get('/news/:number',function($number) use($twig, $root_uri, $nbrOfPages) {
		$news = news::_getNews($number);
		echo $twig->render('news-template.html', array('news' => $news, 'root_uri' => $root_uri, 'page_nbr' => $number, 'nbr_of_pages' => $nbrOfPages));
    });

$app->get('/admin', function () use ($twig, $root_uri) {
		echo $twig->render('login-template.html', array('root_uri' => $root_uri));
});


$app->post('/login', function () {
	$username = $_POST['username'];
	$pass     = $_POST['password'];
	echo login_handler::login($username, $pass) . "<br>";
	echo login_handler::verify();
	echo "<a href='../makt'>Back!</a>";
});

$app->get('/logout', function() {
	echo login_handler::verify();
	login_handler::logout();
	echo login_handler::verify();
	echo "utloggad!!!";
	echo "<a href='../makt'>Back!</a>";
});
/* 
** Tas bort. Testfunktioner till login.
**
*/

$app->get('/populateUsers', function() {
	R::wipe('user');
	$user = R::dispense('user');
	$user->username = "alpha";
	$user->pass = hash('sha512', "hej");
	R::store($user);
	$user = R::dispense('user');
	$user->username = "beta";
	$user->pass = hash('sha512',"hello");
	R::store($user);
});


$app->get('/sessions', function() {
	$beans = R::findAll('session');
		echo "Your session: " . session_id() . "<br>";
	foreach ($beans as $session) {
		foreach ($session as $value) {
			echo $value . " ";
		}
		echo "<br>";
	}
});

$app->get('/users', function() {
	$beans = R::findAll('user');
	foreach ($beans as $session) {
		foreach ($session as $value) {
			echo $value . " ";
		}
		echo "<br>";
	}
});
$app->get('/testDB', function() use ($app) {
      $app->render('../model/test_db_init.php');
    });
$app->run();

?>
