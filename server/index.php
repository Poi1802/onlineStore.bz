<?php
require_once('./vendor/autoload.php');
require_once('./headers.php');

use controllers\UserController;
use router\Route;

// echo $_SERVER['REDIRECT_URL'] . ' ';

Route::get('/server/users', [UserController::class, 'getUsers']);
Route::get('/server/user', [UserController::class, 'getUser']);

Route::post('/server/user/create', [UserController::class, 'createUser']);
Route::patch('/server/user/update', [UserController::class, 'updateUser']);

Route::delete('/server/user/delete', [UserController::class, 'deleteUser']);