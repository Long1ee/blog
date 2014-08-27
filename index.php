<?php

require_once __DIR__."/vendor/autoload.php";

se Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'blog',
    'username'  => 'root',
    'password'  => 'Linux',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);




// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();




function render($view, $params = array())
{
	ob_start();

	extract($params);

	var_dump($foo);
	var_dump($lorem);

	$view= include "views/".$view".php";
	$view = ob_get_contents();
	ob_end_clean();
	return $view;
}




$app= new Silex\Application();

$app["debug"] = true;

$app->get('/', function() {
	return render("home", array(
		"foo"=> "bar",
		"loren"=>"ipsun"))

});

$app->get('/blog/view/{slug}', function($slug) {
	
	return "Hello";

});


$app->get('/blog/add', function() {
	
	$article = new Articles;
	$article->title = "title";
	$article->body = "body";
	$article->slug = "slug";
	$article->user = 1;
	$article->save;
	var_dump($article->save);
	die();
	// return render(add);

});

$app->get('/blog/edit/{id}', function($id) {
	return   ;

});

$app->get('/blog/remove/{id}', function($id) {
	return   ;

});