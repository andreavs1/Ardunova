<?php

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido.']);
    exit;
}

$config = __DIR__ . '/config/openai.php';

if (!file_exists($config)) {
    http_response_code(500);
    echo json_encode(['error' => 'Falta configurar el chatbot.']);
    exit;
}

require $config;

if (
    !defined('OPENAI_API_KEY') ||
    OPENAI_API_KEY === '' ||
    OPENAI_API_KEY === 'PON_TU_CLAVE_AQUI'
) {
    http_response_code(500);
    echo json_encode([
        'error' => 'El chatbot todavía no tiene configurada la clave.'
    ]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$message = trim($input['message'] ?? '');

if ($message === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Escribí una pregunta.']);
    exit;
}

if (mb_strlen($message) > 1000) {
    http_response_code(400);
    echo json_encode(['error' => 'La pregunta es demasiado larga.']);
    exit;
}

$payload = [
    'model' => OPENAI_MODEL,
    'messages' => [
        [
            'role' => 'system',
            'content' => 'Sos el asistente educativo de ARDUNOVA. Ayudás a aprender Arduino, electrónica y robótica de forma clara, sencilla y amigable para personas de distintas edades. Respondé en español rioplatense, con explicaciones paso a paso y ejemplos simples. Si una pregunta no tiene relación con Arduino, electrónica, robótica, programación educativa o el uso de ARDUNOVA, indicá amablemente que podés ayudar principalmente con esos temas.'
        ],
        [
            'role' => 'user',
            'content' => $message
        ]
    ],
    'max_tokens' => 500
];

$ch = curl_init('https://openrouter.ai/api/v1/chat/completions');

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,

    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . OPENAI_API_KEY,
        'HTTP-Referer: http://localhost/ardunova/',
        'X-Title: ARDUNOVA'
    ],

    CURLOPT_POSTFIELDS => json_encode($payload),
    CURLOPT_TIMEOUT => 45
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);

curl_close($ch);

if ($response === false || $curlError) {
    http_response_code(502);

    echo json_encode([
        'error' => 'No se pudo conectar con OpenRouter.'
    ]);

    exit;
}

$data = json_decode($response, true);

if ($httpCode < 200 || $httpCode >= 300) {

    $detalle = $data['error']['message'] ?? 'Error desconocido';

    http_response_code(502);

    echo json_encode([
        'error' => 'OpenRouter respondió con un error: ' . $detalle
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

$reply = $data['choices'][0]['message']['content'] ?? '';

if ($reply === '') {
    http_response_code(502);

    echo json_encode([
        'error' => 'La IA no devolvió una respuesta.'
    ]);

    exit;
}

echo json_encode([
    'reply' => trim($reply)
], JSON_UNESCAPED_UNICODE);
