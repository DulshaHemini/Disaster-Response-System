<?php

class Router {
    private $routes = [];

    public function route($path, $callback) {
        $this->routes[$path] = $callback;
    }

    public function dispatch() {
        $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base_path = '/Disaster-Response-System/public';
        $path = str_replace($base_path, '', $request_uri);
        $path = $path ?: '/';

        // Check if route exists
        if (isset($this->routes[$path])) {
            call_user_func($this->routes[$path]);
        } else {
            // Default to home
            $this->home();
        }
    }

    private function home() {
        require_once APP_PATH . '/controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
    }
}

// Create router instance
$router = new Router();

// Define routes
$router->route('/', function() {
    require_once APP_PATH . '/controllers/HomeController.php';
    $controller = new HomeController();
    $controller->index();
});

$router->route('/admin', function() {
    header("Location: " . BASE_PATH . "/app/controllers/admin.php");
    exit();
});

$router->route('/affected', function() {
    header("Location: " . BASE_PATH . "/app/controllers/affected.php");
    exit();
});

$router->route('/volunteer', function() {
    header("Location: " . BASE_PATH . "/app/controllers/volunteer.php");
    exit();
});

?>