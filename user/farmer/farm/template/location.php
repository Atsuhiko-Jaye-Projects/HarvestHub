<?php

$psgcData = [];

// Fetch function
function fetchData($url) {
    $json = file_get_contents($url);
    return json_decode($json, true);
}

$psgcData['regions'] = fetchData("https://psgc.cloud/api/v2/regions");
$psgcData['provinces'] = fetchData("https://psgc.cloud/api/v2/provinces");
$psgcData['municipalities'] = fetchData("https://psgc.cloud/api/v2/cities-municipalities");
$psgcData['barangays'] = fetchData("https://psgc.cloud/api/v2/barangays");

// Save to JSON file
file_put_contents("psgc.json", json_encode($psgcData, JSON_PRETTY_PRINT));

echo "PSGC data saved to psgc.json!";
?>