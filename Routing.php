<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/DashboardController.php';
require_once 'src/controllers/OfferController.php';
class Router {

  public static $routes;

  public static function get($url, $view) {
    self::$routes[$url] = $view;
  }

  public static function post($url, $view) {
    self::$routes[$url] = $view;
  }

  public static function run ($url) {
      $action = explode("/", $url)[0];
      
      if (empty($action)) {
        $action = 'boarding';
        header('Location: /boarding');
      }
      if (!array_key_exists($action, self::$routes)) {

          die("Wrong url!");
      }

      $controller = self::$routes[$action];
      $object = new $controller;
      $action = $action ?: 'index';

      $object->$action();
  }
}