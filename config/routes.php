<?php

/**
 * Disaster Response System - Optimized Custom Router
 * Defines and dispatches paths for MVC architecture
 */

class Router
{
    private $routes = [];

    /**
     * Register a route mapping
     */
    public function add($route, $controller, $action)
    {
        $this->routes[trim($route, '/')] = [
            'controller' => $controller,
            'action'     => $action
        ];
    }

    /**
     * Match current request URI and execute the controller action
     */
    public function dispatch()
    {
        // Extract URL path and strip subfolder prefix for absolute/relative routing
        $basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        if ($basePath !== '/' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        $cleanUri = trim($uri, '/');

        // Match and execute defined route
        if (isset($this->routes[$cleanUri])) {
            $route = $this->routes[$cleanUri];
            $controllerName = $route['controller'];
            $action = $route['action'];

            $controllerFile = APP_PATH . "/controllers/{$controllerName}.php";
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    if (method_exists($controller, $action)) {
                        $controller->$action();
                        return;
                    }
                }
            }
        }

        // Fallback to Home Controller index page
        $fallback = APP_PATH . "/controllers/HomeController.php";
        if (file_exists($fallback)) {
            require_once $fallback;
            if (class_exists('HomeController')) {
                $controller = new HomeController();
                $controller->index();
                return;
            }
        }

        // Catch-all generic 404 response
        header("HTTP/1.0 404 Not Found");
        echo "404 - Page not found";
    }
}

// Instantiate and configure the router
$router = new Router();

// Define home landing routes
$router->add('/', 'HomeController', 'index');
$router->add('index.php', 'HomeController', 'index');
$router->add('home', 'HomeController', 'index');

?>