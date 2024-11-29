<?php

require_once __DIR__.'/func.php';

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
        }
    //     'middleware' => function() {
    //         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //                 // Check if the file was uploaded without errors
    //                 if (isset($_FILES['levelData']) && is_array($_FILES['levelData']['name'])) {
    //                     if (isset($_FILES['levelData']) && is_array($_FILES['levelData']['name'])) {
    //                         foreach ($_FILES['levelData']['name'] as $index => $fileTypes) {
    //                             foreach ($fileTypes as $type => $fileName) {
    //                                 // Get file properties
    //                                 $tmpFilePath = $_FILES['levelData']['tmp_name'][$index][$type];
    //                                 $fileError = $_FILES['levelData']['error'][$index][$type];
    //                                 $fileSize = $_FILES['levelData']['size'][$index][$type];
                        
    //                                 if ($fileError === UPLOAD_ERR_OK) {
    //                                     // Define the destination path
    //                                     $destinationPath = "unverifiedFiles/" . basename($fileName);
                        
    //                                     // File extension validation
    //                                     $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    //                                     $allowedExtensions = ($type === 'levelVideo')
    //                                         ? ['mp4', 'avi', 'mov', 'flv', 'wmv', '3gp', 'mkv'] // Allowed video formats
    //                                         : ['pdf', 'docx', 'txt', 'xlsx', 'zip', 'pptx'];             // Allowed file formats
                        
    //                                     // Validate file type
    //                                     if (in_array($fileExtension, $allowedExtensions)) {
    //                                         // Move the uploaded file to the target directory
    //                                         if (move_uploaded_file($tmpFilePath, $destinationPath)) {                        
    //                                             // Perform virus scanning for each file (assuming `scanFileWithVirusTotal` is defined)
    //                                             $scanResult = scanFileWithVirusTotal($destinationPath);
                                                
    //                                             if($scanResult['malicious'] > 0){
    //                                             echo json_encode([
    //                                                 'status' => false,
    //                                                 'payload' => [
    //                                                     'error' => "File $fileName has been detected with virus"
    //                                                 ]
    //                                             ]);
    //                                             exit();
    //                                             }
    //                                         } else {
    //                                             echo json_encode([
    //                                                 'status' => false,
    //                                                 'payload' => [
    //                                                     'error' => "Failed to move the uploaded $type: $fileName<br>"
    //                                                 ]
    //                                             ]);
    //                                             exit();
    //                                         }
    //                                     } else {
    //                                         echo json_encode([
    //                                             'status' => false,
    //                                             'payload' => [
    //                                                 'error' => "Invalid file type for $type: $fileName<br>"
    //                                             ]
    //                                         ]);
    //                                         exit();
    //                                     }
    //                                 } else {
    //                                     echo json_encode([
    //                                         'status' => false,
    //                                         'payload' => [
    //                                             'error' => "Error uploading the $type: $fileName<br>"
    //                                         ]
    //                                     ]);
    //                                     exit();
    //                                 }
    //                             }
    //                         }
    //                     } else {
    //                         echo json_encode([
    //                             'status' => false,
    //                             'payload' => [
    //                                 'error' => "No files were uploaded."
    //                             ]
    //                         ]);
    //                         exit();
    //                     }        
    //                 }
    //             }
    // }
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

function scanFileWithVirusTotal($filePath) {
    $apiKey = 'eb30ba05ec314abe78e312b676d2f928f88ef21f149ff2f7e957d9affeef02ed';
    $file = new CURLFile($filePath);
    
$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://www.virustotal.com/api/v3/files",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "content-type: multipart/form-data",
    "x-apikey: $apiKey"
  ],
  CURLOPT_POSTFIELDS => [
    'file' => $file
  ]
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$curl = curl_init();

$responseData = json_decode($response,true);
$id = $responseData['data']['id'];

curl_setopt_array($curl, [
  CURLOPT_URL => "https://www.virustotal.com/api/v3/analyses/$id",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "x-apikey: $apiKey"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);
$responseData = json_decode($response,true);

curl_close($curl);

if ($err) {
} else {
 return $responseData['data']['attributes']['stats'];
}
}
