<?php

$routes = [
    [
        'method' => 'GET',
        'path' => '/test',
        'callback' => function() {
            require __DIR__.'/controllers/test.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/user',
        'callback' => function() {
            require __DIR__.'/controllers/user.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/home?',
        'callback' => function() {
            require __DIR__.'/controllers/home.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/register',
        'callback' => function() {
            require __DIR__.'/controllers/register.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/login?',
        'callback' => function() {
            require __DIR__.'/controllers/login.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/login',
        'callback' => function() {
            require __DIR__.'/controllers/login.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/home',
        'callback' => function() {
            require __DIR__.'/controllers/home.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/chats',
        'callback' => function() {
            require __DIR__.'/controllers/chats.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/course',
        'callback' => function() {
            require __DIR__.'/controllers/course.php';
        }
    ]
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