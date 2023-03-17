<?php
require_once('./vendor/autoload.php');
require_once('./headers.php');

use controllers\UserController;
use router\Route;

Route::get('/server/users', [UserController::class, 'getUsers']);
Route::get('/server/user', [UserController::class, 'getUser']);