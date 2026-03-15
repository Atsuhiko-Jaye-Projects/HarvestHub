<?php
// Your PayMongo secret key
$secretKey = 'sk_test_hQUf2iBTFeb76Zgb5J13oP8x';

// Payment details
// $amount = 150000; // Amount in centavos (₱1,500.00)
// $currency = 'PHP';
// $description = 'Consultation Fee';

// // Prepare data
// $data = [
//     'data' => [
//         'attributes' => [
//             'amount' => $amount,
//             'currency' => $currency,
//             'description' => $description
//         ]
//     ]
// ];

// // Initialize cURL
// $ch = curl_init('https://api.paymongo.com/v1/links');
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//     'Content-Type: application/json',
//     'Authorization: Basic ' . base64_encode($secretKey . ':')
// ]);
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// // Execute request
// $response = curl_exec($ch);
// curl_close($ch);

// // Decode response
// $result = json_decode($response, true);

// // Output checkout URL
// if (isset($result['data']['attributes']['checkout_url'])) {
//     print_r($result);
//     echo "Payment link created: " . $result['data']['attributes']['checkout_url'];
// } else {
//     echo "Error creating payment link: ";
//     print_r($result);
// }

// Get POSTed reference number
// $reference = "1pApdnr";

// if (!$reference) {
//     http_response_code(400);
//     echo json_encode(['error' => 'Reference number is required']);
//     exit;
// }

// // PayMongo API endpoint: search payments by reference number
// $ch = curl_init("https://api.paymongo.com/v1/payments?reference_number=" . urlencode($reference));
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, [
//     'Authorization: Basic ' . base64_encode($secretKey . ':')
// ]);

// $response = curl_exec($ch);
// $paymentData = json_decode($response, true);

// // Check if any payment is found
// if (!empty($paymentData['data'])) {
//     $payment = $paymentData['data'][0]['attributes'];
//     $status = $payment['status']; // paid / unpaid / failed

//     echo json_encode([
//         'reference_number' => $reference,
//         'status' => $status,
//         'amount' => $payment['amount'],
//         'currency' => $payment['currency']
//     ]);
// } else {
//     echo json_encode([
//         'reference_number' => $reference,
//         'status' => 'not_found'
//     ]);
// }

// The link ID you want to verify
$linkId = 'link_GiM5s9MaAUiuRoLnXMTgPVux';

// Initialize cURL
$ch = curl_init("https://api.paymongo.com/v1/links/$linkId");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Basic ' . base64_encode($secretKey . ':')
]);

$response = curl_exec($ch);
if ($response === false) {
    echo "cURL error: " . curl_error($ch);
    exit;
}

$linkData = json_decode($response, true);

if (isset($linkData['data']['attributes']['status'])) {
    $status = $linkData['data']['attributes']['status']; // "unpaid" or "paid"
    $reference = $linkData['data']['attributes']['reference_number'];
    $checkoutUrl = $linkData['data']['attributes']['checkout_url'];
    echo json_encode($linkData, JSON_PRETTY_PRINT);
} else {
    echo "Failed to verify link. Response:\n";
    print_r($linkData);
}
?>