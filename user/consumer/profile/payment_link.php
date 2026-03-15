<?php

include_once "../../../config/core.php";
include_once "../../../config/database.php";
include_once "../../../objects/user.php";
include_once "../../../objects/wallet.php";
include_once "../../../objects/wallet_transaction.php";

// db connection
$database = new Database();
$db = $database->getConnection();

// classes
$user = new User($db);
$wallet = new Wallet($db);
$WT = new walletTransaction($db); // I assume WalletTransaction uses same DB connection

$user_id = $_SESSION['user_id'];
$wallet->user_id = $user_id;
$wallet->getWalletBalance(); // populates $wallet->wallet_id

// Get amount from form
$amount = $_POST['amount'];
$amount_centavos = $amount * 100;
$wallet_id = $_POST['wallet_id'];

// Generate reference number
// $reference = "TOPUP-" . strtoupper(bin2hex(random_bytes(4)));

// Prepare PayMongo link payload
$data = [
    "data" => [
        "attributes" => [
            "amount" => $amount_centavos,
            "description" => "Wallet Top Up",
            "currency" => "PHP"
        ]
    ]
];

$payload = json_encode($data);

// Send request to PayMongo
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => "https://api.paymongo.com/v1/links",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload,
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Basic " . base64_encode("sk_test_hQUf2iBTFeb76Zgb5J13oP8x:")
    ]
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

// Grab link info
$link_id = $result['data']['id'];
$checkout_url = $result['data']['attributes']['checkout_url'];
$reference = $result['data']['attributes']['reference_number'];


// bind the values to properties
$WT->wallet_id = $_POST['wallet_id'];
$WT->type = "credit";
$WT->paymongo_link_id = $result['data']['id'];
$WT->paymongo_link = $result['data']['attributes']['checkout_url'];
$WT->reference_number = $result['data']['attributes']['reference_number'];
$WT->amount = $_POST['amount'];
$WT->description = "Top Up Balance";

echo json_encode($result, JSON_PRETTY_PRINT);

if ($WT->createTransaction()) {
    header("Location: " . $checkout_url);
    exit;
}

?>