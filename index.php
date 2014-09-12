<?php
session_start();
require_once __DIR__."/vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as Capsule;

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
//$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

function render($view, $params = array())
{
	ob_start();
	extract($params);
	include "views/".$view.".php";
	$view = ob_get_contents();
	ob_end_clean();
	return $view;
}

function slug($str, $delimiter='-') 
{
    $cyrylicFrom = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
    $cyrylicTo   = array('A', 'B', 'W', 'G', 'D', 'Ie', 'Io', 'Z', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'Ch', 'C', 'Tch', 'Sh', 'Shtch', '', 'Y', '', 'E', 'Iu', 'Ia', 'a', 'b', 'w', 'g', 'd', 'ie', 'io', 'z', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'ch', 'c', 'tch', 'sh', 'shtch', '', 'y', '', 'e', 'iu', 'ia'); 

    $clean = str_replace($cyrylicFrom, $cyrylicTo, $str); 
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower($clean);
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

    return trim($clean, '-');
}

$app = new Silex\Application();
$app['debug'] = true;

$app->get('/', function()
 {
 	$articles = Articles::all();
 	return render("home", array(
 		"articles" =>$articles
		));
});

$app->get('/blog/add', function () use($app) {
	if (!Auth::instance()->isAuth()) {
		$app->abort(404,"Вы не авторизированы");
	}
    return render("add");
});

$app->post('/blog/add', function() use ($app) 
{
	if (!Auth::instance()->isAuth()) {
		$app->abort(404,"Вы не авторизированы");
	}
	$articles = new Articles;
	$articles ->title=$_POST["title"];
	$articles ->body=$_POST["body"];
	$articles ->slug=slug($_POST["title"]);
	$articles ->user_id = Auth::instance()->id();
	$articles ->save();
	var_dump($articles ->save());
	return $app->redirect("/");

});

$app->get('/blog/view/{slug}', function ($slug) {
    $article = Articles::where("slug", "=", $slug)->first();
    return render("view", array(
        'article' => $article
    ));
});

$app->get('/blog/remove/{id}', function($id) use ($app) {
	

	$articles = Articles::find($id);
	$articles->delete();
	var_dump($articles ->delete());
	return render("home", array());
});

$app->post('/blog/add-comment/{articl_id}', function($articl_id) use ($app) {
	$comments = new Comments;

	$comments ->comments=$_POST["body"];
	$comments ->subject=$_POST["subject"];
	$comments ->article_id=$articl_id;
	$comments ->save();
	var_dump($comments ->save());
	return $app->redirect("/index.php/blog/show_article/".$articl_id);
});



$app->get('/blog/edit/{id}', function($id) use ($app) {
	if (!Auth::instance()->isAuth()) {
        return $app->abort(404, "Это не ваша статья.");
    }

    $article = Articles::find($id);

    if (!Auth::instance()->isOwner($article)) {
        return $app->abort(404, "Это не ваша статья.");
    }

    return render("edit", array(
        "article" => $article
    ));
});

$app->post('/blog/edit/{id}', function($id) use ($app) {
	
	if (!Auth::instance()->isAuth()) {
		$app->abort(404,"Это не ваша статья");
	}

	$articles = Articles::find($id);
	
	if (!Auth::instance()->isOwner($article)) {
		$app->abort(404,"Это не ваша статья");
	}

	$articles ->title=$_POST["title"];
	$articles ->body=$_POST["body"];
	$articles ->slug=slug($_POST["title"]);
	$articles ->save();
	var_dump($articles ->save());
	return $app->redirect('/index.php/blog/edit/'.$id);
});

$app->get('/example', function () use ($app) {
    return render("example");
});

$app->get("/ajax",function () use ($app) {
	return "succes";
});

$user = include "user.php";

$app->mount('/user', $user);



$app->run();