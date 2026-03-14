<?php
include_once "../../../config/core.php";
include_once "../../../config/database.php";
//$secret_key = "sk_test_hQUf2iBTFeb76Zgb5J13oP8x"; // your test key

$data = [
    "data" => [
        "attributes" => [
            "amount" => 10000, // ₱5
            "currency" => "PHP",
            "description" => "HarvestHub Test Payment",
            "farmer_id" => $_SESSION['user_id'],
            "payment_method_allowed" => ["qrph","card"], // allow QRPH + card
            "redirect" => [
                "success" => "https://example.com/success",
                "failed" => "https://example.com/failed"
            ]
        ]
    ]
];

$ch = curl_init("https://api.paymongo.com/v1/links");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    //"Authorization: Basic " . base64_encode("sk_test_hQUf2iBTFeb76Zgb5J13oP8x:")
]);

$response = curl_exec($ch);
curl_close($ch);

$linkData = json_decode($response, true);

if (isset($linkData['data']['attributes']['url'])) {
    echo "Payment Link: <a href='" . $linkData['data']['attributes']['url'] . "' target='_blank'>" . $linkData['data']['attributes']['url'] . "</a>";
} else {
    echo "Failed to create payment link:<br>";
    echo "<pre>";
    print_r($linkData);
    echo "</pre>";
}
?>