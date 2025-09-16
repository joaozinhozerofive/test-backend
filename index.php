<?php
require_once 'vendor/autoload.php';

use Web\Routes;
use Web\App;
use Mvc\Controllers\HomeController;
use Mvc\Controllers\PersonController;
use Mvc\Controllers\ContactsController;

Routes::get('/', [HomeController::class, 'index']);

Routes::get('/persons', [PersonController::class, 'index']);
Routes::get('/persons/create', [PersonController::class, 'create']);
Routes::post('/persons/create', [PersonController::class, 'store']);
Routes::get('/persons/view/{id}', [PersonController::class, 'view']);
Routes::get('/persons/edit/{id}', [PersonController::class, 'edit']);
Routes::put('/persons/edit/{id}', [PersonController::class, 'update']);
Routes::get('/persons/delete/{id}', [PersonController::class, 'delete']);
Routes::delete('/persons/delete/{id}', [PersonController::class, 'destroy']);

Routes::get('/contacts', [ContactsController::class, 'index']);
Routes::get('/contacts/create', [ContactsController::class, 'create']);
Routes::post('/contacts/create', [ContactsController::class, 'store']);
Routes::get('/contacts/view/{id}', [ContactsController::class, 'view']);
Routes::get('/contacts/edit/{id}', [ContactsController::class, 'edit']);
Routes::put('/contacts/edit/{id}', [ContactsController::class, 'update']);
Routes::get('/contacts/delete/{id}', [ContactsController::class, 'delete']);
Routes::delete('/contacts/delete/{id}', [ContactsController::class, 'destroy']);


$app = new App();	
$app->run();

