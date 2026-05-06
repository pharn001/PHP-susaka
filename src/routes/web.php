<?php

$router = new Router();

$router->middleware('auth', static function (): void {
    if (!AuthService::check()) {
        header('Location: /login');
        exit;
    }
});

$router->middleware('guest', static function (): void {
    if (AuthService::check()) {
        header('Location: /');
        exit;
    }
});

$router->middleware('admin', static function (): void {
    if (!AuthService::check()) {
        header('Location: /login');
        exit;
    }

    if (!AuthService::isAdmin()) {
        header('Location: /');
        exit;
    }
});

$router->get('/', 'DashboardController@index', ['auth']);
$router->get('/login', 'AuthController@showLogin', ['guest']);
$router->post('/login', 'AuthController@login', ['guest']);
$router->get('/logout', 'AuthController@logout', ['auth']);
$router->get('/register', 'AuthController@showRegister', ['admin']);
$router->post('/register', 'AuthController@register', ['admin']);
$router->get('/reset-admin', 'AuthController@showResetAdmin');
$router->post('/reset-admin', 'AuthController@resetAdmin');
$router->get('/pos', 'PosController@index');
$router->get('/accounts', 'AccountController@index', ['admin']);
$router->post('/accounts', 'AccountController@store', ['admin']);
$router->post('/accounts/update', 'AccountController@update', ['admin']);
$router->post('/accounts/delete', 'AccountController@destroy', ['admin']);
