<?php

require 'Routing.php';

$path = trim($_SERVER["REQUEST_URI"], "/");

Router::get('', 'DefaultController');
Router::get('login', 'DefaultController');
Router::get('dashboard', 'DefaultController');
Router::get('boarding', 'DefaultController');
Router::get('account', 'DefaultController');
Router::get('offer', 'DefaultController');
Router::get('signup', 'DefaultController');
Router::get('verified', 'DefaultController');


Router::run($path);
