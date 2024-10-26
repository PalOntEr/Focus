<?php

session_start();

$routes = [
    [
        'method' => 'GET',
        'path' => '/',
        'callback' => function() {
            require __DIR__.'/controllers/login.php';
        }
    ],
    [
        'method' => 'POST',
        'path' => '/',
        'callback' => function() {
            require __DIR__.'/controllers/login.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/test',
        'callback' => function() {
            require __DIR__.'/controllers/test.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/cart',
        'callback' => function() {
            require __DIR__.'/controllers/cart.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/checkout',
        'callback' => function() {
            require __DIR__.'/controllers/checkout.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/sales',
        'callback' => function() {
            require __DIR__.'/controllers/sales.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/kardex',
        'callback' => function() {
            require __DIR__.'/controllers/kardex.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/sales',
        'callback' => function() {
            require __DIR__.'/controllers/sales.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/users',
        'callback' => function() {
            require __DIR__.'/controllers/users.php';
        }
    ],
    [
        'method' => 'POST',
        'path' => '/users',
        'callback' => function() {
            require __DIR__.'/controllers/users.php';
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
        'path' => '/login',
        'callback' => function() {
            require __DIR__.'/controllers/login.php';
        }
    ],
    [
        'method' => 'POST',
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
    ],
    [
        'method' => 'GET',
        'path' => '/level',
        'callback' => function() {
            require __DIR__.'/controllers/level.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/createCourse',
        'callback' => function() {
            require __DIR__.'/controllers/createCourse.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/reporte',
        'callback' => function() {
            require __DIR__.'/controllers/reports.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/advSearch',
        'callback' => function() {
            require __DIR__.'/controllers/advSearch.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/diploma',
        'callback' => function() {
            header('Content-Type: image/png');
            readfile(__DIR__.'/public/images/diploma.png');
            exit();
        }
    ],
    [
        'method' => 'GET',
        'path' => '/profile',
        'callback' => function() {
            require __DIR__.'/controllers/profile.php';
        },
        'middleware' => function() {
            if (!isset($_SESSION['user'])) {
                header('Location: /login');
                exit();
            }
        }
    ]
];

foreach ($routes as $route) {
    if ($route['method'] === $_SERVER['REQUEST_METHOD'] && $route['path'] === strtok($_SERVER['REQUEST_URI'], '?')) {
        call_user_func($route['callback']);
        return;
    }
}

$filePath = __DIR__ . $_SERVER['REQUEST_URI'];
if (file_exists($filePath) && is_file($filePath)) {
    header('Content-Type: ' . mime_content_type($filePath));
    readfile($filePath);
} else {
    http_response_code(404);
    echo "404 Not Found";
}