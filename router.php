<?php

$routes = [
    [
        'method' => 'GET',
        'path' => '/',
        'callback' => function() {
            require __DIR__.'/views/index.php';
        }
    ]
];

foreach ($routes as $route) {
    if ($route['method'] === $_SERVER['REQUEST_METHOD'] && $route['path'] === $_SERVER['REQUEST_URI']) {
        call_user_func($route['callback']);
        return;
    }
}
// If no route is matched
http_response_code(404);
echo "404 Not Found";