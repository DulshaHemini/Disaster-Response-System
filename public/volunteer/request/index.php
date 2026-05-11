<?php
// Define paths for tracker
define('BASE_PATH', dirname(__DIR__, 4));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');


$view = APP_PATH . "/views/request/request.php";
// echo $view;



require_once $view;