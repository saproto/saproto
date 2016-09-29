<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$routesdir = __DIR__ . '/Routes';

// Routes for our minisites.
require $routesdir . '/minisites.php';

// Routes for our primary site.
require $routesdir . '/primary.php';

