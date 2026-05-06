<?php

$router->get('/api/users', 'UserApiController@index');
$router->get('/api/users/{id}', 'UserApiController@show');
$router->post('/api/users', 'UserApiController@store');
$router->put('/api/users/{id}', 'UserApiController@update');
$router->patch('/api/users/{id}', 'UserApiController@update');
$router->delete('/api/users/{id}', 'UserApiController@destroy');

$router->get('/api/accounts', 'AccountApiController@index');
$router->get('/api/accounts/{id}', 'AccountApiController@show');
$router->post('/api/accounts', 'AccountApiController@store');
$router->put('/api/accounts/{id}', 'AccountApiController@update');
$router->patch('/api/accounts/{id}', 'AccountApiController@update');
$router->delete('/api/accounts/{id}', 'AccountApiController@destroy');

$router->get('/api/transactions', 'TransactionApiController@index');
$router->get('/api/transactions/{id}', 'TransactionApiController@show');
$router->post('/api/transactions', 'TransactionApiController@store');
$router->delete('/api/transactions/{id}', 'TransactionApiController@destroy');

$router->get('/api/categories', 'CategoryApiController@index');
$router->get('/api/products', 'ProductApiController@index');
$router->post('/api/orders', 'OrderApiController@store');
