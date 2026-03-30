<?php
$distanceText = "";
$durationText = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $lat1 = $_POST['lat'];
    $lng1 = $_POST['lng'];
    $lat2 = $_POST['dest_lat'];
    $lng2 = $_POST['dest_lng'];

    $apiKey = "eyJvcmciOiI1YjNjZTM1OTc4NTExMTAwMDFjZjYyNDgiLCJpZCI6IjE1Mjc3ZmM2ZGM3ZDQ5M2M4NWMxNWExNmQ4MWMxMmNkIiwiaCI6Im11cm11cjY0In0=";

    $url = "https://api.openrouteservice.org/v2/directions/driving-car";

    $data = [
        "coordinates" => [
            [(float)$lng1, (float)$lat1],
            [(float)$lng2, (float)$lat2]
        ]
    ];

    $options = [
        "http" => [
            "header"  => "Content-type: application/json\r\n" .
                         "Authorization: $apiKey\r\n",
            "method"  => "POST",
            "content" => json_encode($data),
        ]
    ];

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result !== FALSE) {
        $response = json_decode($result, true);

        if (isset($response['routes'][0])) {
            $distance = $response['routes'][0]['summary']['distance'];
            $duration = $response['routes'][0]['summary']['duration'];

            $distanceText = round($distance / 1000, 2) . " km";
            $durationText = round($duration / 60, 2) . " minutes";
        } else {
            $distanceText = "Route not found.";
        }
    } else {
        $distanceText = "API request failed.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Road Distance Calculator</title>
</head>
<body>

<h2>OpenRouteService Distance Calculator</h2>

<button onclick="getLocation()">Use My Location</button>

<form method="POST">
    <br><br>

    <label>Origin:</label><br>
    <input type="text" id="lat" name="lat" placeholder="Latitude" required>
    <input type="text" id="lng" name="lng" placeholder="Longitude" required>

    <br><br>

    <label>Destination:</label><br>
    <input type="text" name="dest_lat" placeholder="Latitude" required>
    <input type="text" name="dest_lng" placeholder="Longitude" required>
    <a href="https://www.google.com/maps/dir/7,+121.94379039695583/13.468558099245698,+121.85662333926827/@13.3620682,121.7984755,12z/data=!3m1!4b1!4m10!4m9!1m3!2m2!1d121.9437904!2d13.2546352!1m3!2m2!1d121.8566233!2d13.4685581!3e0!5m1!1e1?entry=ttu&g_ep=EgoyMDI2MDMyMy4xIKXMDSoASAFQAw%3D%3D">Start Journey</a>
    <br><br>
    <button type="submit">Calculate Distance</button>
</form>

<?php if ($distanceText): ?>
    <h3>Distance: <?php echo $distanceText; ?></h3>
    <h4>Estimated Time: <?php echo $durationText; ?></h4>
<?php endif; ?>

<script>
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            document.getElementById("lat").value = pos.coords.latitude;
            document.getElementById("lng").value = pos.coords.longitude;
        }, function(err) {
            alert("Location error: " + err.message);
        });
    } else {
        alert("Geolocation not supported.");
    }
}
</script>

</body>
</html>