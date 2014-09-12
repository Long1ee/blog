<?php

$user = $app['controllers_factory'];

$user->get('/registration', function () use ($app) {
    return render('registration');
});

$user->post('/registration', function () use ($app) {
    $user = new Users();
    $user->name = $_POST["name"];
    $user->email = $_POST["email"];
    $user->password = md5($_POST["password"]);
    $user->save();
    return $app->redirect('/index.php/user/login');
});

$user->get('/login', function () {
    return render('login');
});

$user->post('/login', function () use ($app) {
    $user = Users::where("email", "=", $_POST["email"])
        ->where("password", "=", md5($_POST["password"]))
        ->first();

    if($user) {
        Auth::instance()->login($user);
        return $app->redirect('/');
    } else {
        return $app->redirect('/index.php/user/login');
    }
});

$user->get('/user/logout', function () use ($app) {
    Auth::instance()->logout($user);
    return $app->redirect('/');
});
return $user;