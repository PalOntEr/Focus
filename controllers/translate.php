<?php

header('Content-Type: application/json');

try {
    $config = require __DIR__.'/../config/config.php';

    $url = 'https://api.cognitive.microsofttranslator.com/translate?api-version=3.0&to=en';

    if (empty($_POST['text'])) {
        http_response_code(400);
        echo json_encode([
            'status' => false,
            'payload' => [
                'error' => 'No text provided'
            ]
        ]);
        exit;
    }

    $data = [
        [
            'text' => $_POST['text']
        ]
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n" .
                         "Ocp-Apim-Subscription-Key: " . $config['translateAPI']['Ocp-Apim-Subscription-Key'] . "\r\n" .
                         "Ocp-Apim-Subscription-Region: " . $config['translateAPI']['Ocp-Apim-Subscription-Region'] . "\r\n" .
                         "X-ClientTraceId: " . $config['translateAPI']['X-ClientTraceId'] . "\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        throw new Exception('Error occurred');
    }

    $response = json_decode($result, true);
    $translatedText = $response[0]['translations'][0]['text'];

    echo json_encode([
        'status' => true,
        'payload' => [
            'translatedText' => $translatedText
        ]
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => false,
        'payload' => [
            'error' => $e->getMessage()
        ]
    ]);
}
?>