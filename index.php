<?php

require 'Routing.php';

$path = trim($_SERVER["REQUEST_URI"], "/");
$path = parse_url( $path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::post('login', 'SecurityController');
Router::get('dashboard', 'DefaultController');
Router::get('boarding', 'DefaultController');
Router::get('account', 'DefaultController');
Router::get('offer', 'DefaultController');
Router::get('signup', 'DefaultController');
Router::get('verified', 'DefaultController');
Router::post('addImage', 'ImageController');


Router::run($path);
