<?php

require 'Routing.php';

$path = trim($_SERVER["REQUEST_URI"], "/");
$path = parse_url( $path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::post('login', 'SecurityController');
Router::get('dashboard', 'DashboardController');
Router::get('create', 'DefaultController');
Router::get('boarding', 'DefaultController');
Router::get('account', 'DefaultController');
Router::get('offer', 'DefaultController');
Router::post('signup', 'SecurityController');



Router::run($path);
