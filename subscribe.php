<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://myclearbudget.com');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$email = isset($input['email']) ? filter_var(trim($input['email']), FILTER_VALIDATE_EMAIL) : false;
$name  = isset($input['name'])  ? htmlspecialchars(trim($input['name']), ENT_QUOTES, 'UTF-8') : '';

if (!$email) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid email']);
    exit;
}

$api_key  = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiNjkwNTY3ZWNjNmE0NTc5Yzc2NWIzMzFmYmNkZjdhZjM4YTQ1MTkwNmFlMTBmNmY2OWZiOGVhMDVjOTk0MTI2ZTYwNjRkYzNkODM5NTE1YjYiLCJpYXQiOjE3ODEwMDI4MDIuMzUzMzI4LCJuYmYiOjE3ODEwMDI4MDIuMzUzMzMsImV4cCI6NDkzNjY3NjQwMi4zNDg2NzYsInN1YiI6IjI0MzIzNDUiLCJzY29wZXMiOltdfQ.Q3ZPNvlkZtYlcqyFzXhLoEYGNNyFDL4zpedpryVyHogCV3p3o8hndJ3YCihwPCvdzMyRkIs_BGarTFG21DYCm9o0Rfyt3IIpTKhHvspuDZFJyOoU2fUCfYAVEz-K6xqc1qtTgmzw6cj76RErFEYXstghfLaN16S_ICGI6ICkn4gywdYC1Gp2wX6q_BbrwBnuNvxS3B5mIChhqNCkNyBBC-XwckLsJ6SVvlwAE23K7ehEwSDG0Njvg0ovU9wnoLM97C0DDCpx7nBN6cVXYdh720obkj21GD0hnRNMOM1GW5YW7vG5os5zIXfmeADbnmBrJyGd9hnGnTjci7D3xVSkoFnac5uGVqsUSd6QIBBPHtpWrji0tg6hGjAZuVZOJPwvsZb9lYNYFqxzyc7wabzMI4-e4BMtYKkVirriPriTTvzrw5SgMCDkd2IVTo47WrW83VrSPd0EJ8PbYIFQMdAJV287bHGLwbfdjdCE5825mKAsSkxuI25eWFjkv3Oq_zCL9o8cu3ej0gGsgdQUDjRKfo8PtRvr_nckj08NEPpo3v4PZ0HFFDOOTRiHB0HwA8BeoqYT82B6JmGXypwe81JPGbvATYmRsuvXSt52R1n4XXKTB5K6OIdXkoLFV8c7fRPJMlb2Y_Y4vQeMlNDAUjI6QLP3A1ru-pSNU5bN3BxSpsA';
$group_id = '190553623419160153';

$payload = [
    'email'  => $email,
    'groups' => [$group_id],
];
if ($name !== '') {
    $payload['fields'] = ['name' => $name];
}

$ch = curl_init('https://connect.mailerlite.com/api/subscribers');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($payload),
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $api_key,
    ],
    CURLOPT_TIMEOUT        => 10,
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data = json_decode($response, true);

// 200 = updated existing, 201 = new subscriber — both are success
if ($http_code === 200 || $http_code === 201) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    $msg = isset($data['message']) ? $data['message'] : 'Subscription failed';
    echo json_encode(['error' => $msg]);
}
