<?php

require_once __DIR__.'/func.php';
require __DIR__.'/controllers/middleware/CheckMalware.php';

session_start();

// dd($_SESSION);

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
        'method' => 'POST',
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
        'method' => 'POST',
        'path' => '/createCourse',
        'callback' => function() {
            require __DIR__.'/controllers/createCourse.php';
        },
        'middleware' => function() {
            CheckMalware();
        }
    ],
    [
        'method' => 'POST',
        'path' => '/verifyFiles',
        'callback' => function() {
            require __DIR__.'/controllers/createCourse.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/categories',
        'callback' => function() {
            require __DIR__.'/controllers/categories.php';
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
        'method' => 'POST',
        'path' => '/categories',
        'callback' => function() {
            require __DIR__.'/controllers/categories.php';
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
    ],
    [
        'method' => 'GET',
        'path' => '/messages',
        'callback' => function() {
            require __DIR__.'/controllers/messages.php';
        }
    ],
    [
        'method' => 'POST',
        'path' => '/messages',
        'callback' => function() {
            require __DIR__.'/controllers/messages.php';
        }
    ],
    [
        'method' => 'POST',
        'path' => '/translate',
        'callback' => function() {
            require __DIR__.'/controllers/translate.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/courses/get',
        'callback' => function() {
            require __DIR__.'/controllers/getCourses.php';
        }
    ],
    [
        'method' => 'POST',
        'path' => '/courses/patch',
        'callback' => function() {
            require __DIR__.'/controllers/updateCourses.php';
        }
    ],
    [
        'method' => 'POST',
        'path' => '/levels/patch',
        'callback' => function() {
            require __DIR__.'/controllers/updateLevels.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/Content/get',
        'callback' => function() {
            require __DIR__.'/controllers/getContent.php';
        }
    ],
    [
        'method' => 'POST',
        'path' => '/Content/patch',
        'callback' => function() {
            require __DIR__.'/controllers/updateContent.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/comments',
        'callback' => function() {
            require __DIR__.'/controllers/comments.php';
        }
    ],
    [
        'method' => 'POST',
        'path' => '/comments',
        'callback' => function() {
            require __DIR__.'/controllers/comments.php';
        }
    ],
    [
        'method' => 'POST',
        'path' => '/purchase',
        'callback' => function() {
            require __DIR__.'/controllers/purchase.php';    
        }
    ],
    [
        'method' => 'GET',
        'path' => '/levels',
        'callback' => function() {
            require __DIR__.'/controllers/levels.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/purchasedLevels/get',
        'callback' => function() {
            require __DIR__.'/controllers/getPurchasedLevels.php';
        }
    ],
    [
        'method' => 'POST',
        'path' => '/purchasedLevels/put',
        'callback' => function() {
            require __DIR__.'/controllers/updatePurchasedLevels.php';
        }
    ],
    [
        'method' => 'POST',
        'path' => '/deletedComments/Post',
        'callback' => function() {
            require __DIR__.'/controllers/deletedComments.php';
        }
    ],
    [
        'method' => 'GET',
        'path' => '/deletedComments/Get',
        'callback' => function() {
            require __DIR__.'/controllers/deletedComments.php';
        }
    ]
];

foreach ($routes as $route) {
    if ($route['method'] === $_SERVER['REQUEST_METHOD'] && $route['path'] === strtok($_SERVER['REQUEST_URI'], '?')) {
        if (isset($route['middleware'])) {
            call_user_func($route['middleware']);
        }
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
    echo json_encode([
        'status' => false,
        'payload' => [
            'error' => 'Not found'
        ]
    ]);
}