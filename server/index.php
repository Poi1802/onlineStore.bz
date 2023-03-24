<?php
require_once('./vendor/autoload.php');
require_once('./headers.php');

use controllers\{BrandController, UserController, CategoryController, ColorController, OrderController, TypeController, DeviceController, CartController};
use router\Route;

// echo $_SERVER['REDIRECT_URL'] . ' ';

$contr = explode('/', $_SERVER['REDIRECT_URL']);

/**
 * Users CRUD
 */
if ($contr[2] === 'user' || $contr[2] === 'users') {
  Route::get('/server/users', [UserController::class, 'getUsers']);
  Route::get('/server/user', [UserController::class, 'getUser']);

  Route::post('/server/user/create', [UserController::class, 'createUser']);

  Route::patch('/server/user/update', [UserController::class, 'updateUser']);

  Route::delete('/server/user/delete', [UserController::class, 'deleteUser']);
}

/**
 * Brands CRUD
 */
if ($contr[2] === 'brand' || $contr[2] === 'brands') {
  Route::get('/server/brands', [BrandController::class, 'getBrands']);
  Route::get('/server/brand', [BrandController::class, 'getBrand']);

  Route::post('/server/brand/create', [BrandController::class, 'createBrand']);

  Route::patch('/server/brand/update', [BrandController::class, 'updateBrand']);

  Route::delete('/server/brand/delete', [BrandController::class, 'deleteBrand']);
}

/**
 * Categories CRUD
 */
if ($contr[2] === 'category' || $contr[2] === 'categories') {
  Route::get('/server/categories', [CategoryController::class, 'getCategories']);
  Route::get('/server/category', [CategoryController::class, 'getCategory']);

  Route::post('/server/category/create', [CategoryController::class, 'createCategory']);

  Route::patch('/server/category/update', [CategoryController::class, 'updateCategory']);

  Route::delete('/server/category/delete', [CategoryController::class, 'deleteCategory']);
}

/**
 * Colors CRUD
 */
if ($contr[2] === 'color' || $contr[2] === 'colors') {
  Route::get('/server/colors', [ColorController::class, 'getColors']);
  Route::get('/server/color', [ColorController::class, 'getColor']);

  Route::post('/server/color/create', [ColorController::class, 'createColor']);

  Route::patch('/server/color/update', [ColorController::class, 'updateColor']);

  Route::delete('/server/color/delete', [ColorController::class, 'deleteColor']);
}

/**
 * Devices CRUD
 */
if ($contr[2] === 'device' || $contr[2] === 'devices') {
  Route::get('/server/devices', [DeviceController::class, 'getDevices']);
  Route::get('/server/device', [DeviceController::class, 'getDevice']);

  Route::post('/server/device/create', [DeviceController::class, 'createDevice']);
  Route::post('/server/device/addImgToDevice', [DeviceController::class, 'addImgToDevice']);

  Route::patch('/server/device/update', [DeviceController::class, 'updateDevice']);

  Route::delete('/server/device/delete', [DeviceController::class, 'deleteDevice']);
}

/**
 * Orders CRUD
 */
if ($contr[2] === 'order' || $contr[2] === 'orders') {
  Route::get('/server/orders', [OrderController::class, 'getOrders']);
  Route::get('/server/order', [OrderController::class, 'getOrder']);

  Route::post('/server/order/create', [OrderController::class, 'createOrder']);

  Route::patch('/server/order/update', [OrderController::class, 'updateOrder']);

  Route::delete('/server/order/delete', [OrderController::class, 'deleteOrder']);
}

/**
 * Types CRUD
 */
if ($contr[2] === 'type' || $contr[2] === 'types') {
  Route::get('/server/types', [TypeController::class, 'getTypes']);
  Route::get('/server/type', [TypeController::class, 'getType']);

  Route::post('/server/type/create', [TypeController::class, 'createType']);

  Route::patch('/server/type/update', [TypeController::class, 'updateType']);

  Route::delete('/server/type/delete', [TypeController::class, 'deleteType']);
}

/**
 * Carts CRUD
 */
if ($contr[2] === 'cart' || $contr[2] === 'carts') {
  Route::get('/server/carts', [CartController::class, 'getCarts']);
  Route::get('/server/cart', [CartController::class, 'getCart']);

  Route::post('/server/cart/create', [CartController::class, 'createCart']);

  Route::patch('/server/cart/update', [CartController::class, 'updateCart']);

  Route::delete('/server/cart/delete', [CartController::class, 'deleteCart']);
}