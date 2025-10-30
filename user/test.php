<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>








<?php

$apiKey = "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";

$weather = [
  "temperature" => "28.94",
  "rainfall" => "Heavy Rain",
  "humidity" => "70",
  "location" => "Mogpog, Marinduque"
];

$prompt = "Based on this weather data: " . json_encode($weather) .
          ", suggest the best crop to plant in Marinduque, Philippines, considering tropical climate. Reply only with the crop name.";

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
  ],
  CURLOPT_POSTFIELDS => json_encode([
    "model" => "gpt-4o-mini",
    "messages" => [["role" => "user", "content" => $prompt]]
  ])
]);
$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
$crop = $result['choices'][0]['message']['content'] ?? "No result";

echo "Best crop to plant: $crop";


include_once 'farmer/layout/layout_foot.php';?>

<div class="alert alert-success mt-3">
  🌱 Recommended Crop: <strong><?php echo $crop; ?></strong>
</div>
