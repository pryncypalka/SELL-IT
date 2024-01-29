<?php

require 'Routing.php';

$path = trim($_SERVER["REQUEST_URI"], "/");
$path = parse_url( $path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::post('login', 'SecurityController');
Router::get('dashboard', 'DashboardController');
Router::get('create', 'DashboardController');
Router::get('boarding', 'DefaultController');
Router::get('account', 'DashboardController');
Router::get('offer', 'OfferController');

Router::post('signup', 'SecurityController');
Router::post('changePassword', 'SecurityController');
Router::post('changeAvatar', 'DashboardController');
Router::post('logout', 'SessionController');
Router::post('addOffer', 'OfferController');
Router::post('deleteTemplate', 'DashboardController');
Router::post('deleteOffer', 'DashboardController');

Router::post('searchOffer', 'DashboardController');
Router::post('searchResult', 'DashboardController');

Router::run($path);
