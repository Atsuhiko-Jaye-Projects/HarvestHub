<?php
// payment_status.php

$payment_link_id = "link_oqtmZYGeFNTZ6XvqnUqQm3An"; // PayMongo link ID
$secret_key = 'sk_test_hQUf2iBTFeb76Zgb5J13oP8x';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/links/{$payment_link_id}");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Basic " . base64_encode($secret_key . ":"),
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if(isset($data['data']['attributes']['status'])){
    // Combine status with full response
    echo json_encode([
        'status' => $data['data']['attributes']['status'],
        'amount'   => $data['data']['attributes']['amount'],
        'reference_number' => $data['data']['attributes']['reference_number']
    ], JSON_PRETTY_PRINT);
} else {
    echo json_encode([
        'status'=>'error',
        'message'=>'Invalid response'
    ]);
}
?>