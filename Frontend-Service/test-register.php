<?php
// Test Member Service registration API directly

$ch = curl_init('http://127.0.0.1:8001/api/register');

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        'email' => 'testuser' . time() . '@test.com',
        'password' => 'password123',
        'name' => 'Test User',
        'username' => 'testuser',
        'id_role' => 2,
        'telephone_number' => '08123456789',
        'address' => 'Test Address',
    ]),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json',
    ],
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response:\n";
echo $response ? $response : "(empty response)\n";
