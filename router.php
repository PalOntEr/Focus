<?php

$routes = [
    [
        'method' => 'GET',
        'path' => '/test',
        'callback' => function() {
            require __DIR__.'/controllers/test.php';
        }
    ],
];

$isInRoutes = false;

foreach ($routes as $route) {
    if ($route['method'] === $_SERVER['REQUEST_METHOD'] && $route['path'] === $_SERVER['REQUEST_URI']) {
        call_user_func($route['callback']);
        $isInRoutes = true;
        break;
    }
}

if (!$isInRoutes) {
    $filePath = __DIR__ . $_SERVER['REQUEST_URI'];
    if (file_exists($filePath) && is_file($filePath)) {
        header('Content-Type: ' . mime_content_type($filePath));
        readfile($filePath);
    } else {
        http_response_code(404);
        echo "404 Not Found";
    }
}