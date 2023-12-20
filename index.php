<?php

require 'Routing.php';

$path = trim($_SERVER["REQUEST_URI"], "/");

Router::get('', 'DefaultController');
Router::get('index', 'DefaultController');
Router::get('dashboard', 'DefaultController');

Router::run($path);
