<?php

use App\Controllers\ApiController;
use App\Controllers\HomeController;
use App\Controllers\UserController;


// List all routes or address that can be visited in your application
return [
    '/' => [HomeController::class, 'index'], //[Controller class, Controller method]
    '/login' => [UserController::class,'login'],
    '/users' => [UserController::class,'users'],
    '/register' => [UserController::class,'register'],
    '/logout' => [UserController::class,'logout'],
    '/changePicture' =>[UserController::class, 'changePicture'],
    '/sample-api-request' =>[HomeController::class, 'sampleApiRequest'],

    //Api routes
    '/api/users' => [ApiController::class,'users'],
    '/api/login' => [ApiController::class,'login'],
];