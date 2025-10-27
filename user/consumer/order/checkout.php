<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get posted arrays safely
    $product_ids = $_POST['product_ids'] ?? [];
    $quantities  = $_POST['quantities'] ?? [];
    $prices      = $_POST['prices'] ?? [];

    echo "<h3>🧾 Checkout Summary (Posted Data)</h3>";

    if (!empty($product_ids)) {
        echo "<table border='1' cellpadding='8' cellspacing='0'>";
        echo "<tr>
                <th>#</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Price</th>
              </tr>";

        // Loop through items
        foreach ($product_ids as $index => $id) {
            $qty   = htmlspecialchars($quantities[$index] ?? 0);
            $price = htmlspecialchars($prices[$index] ?? 0);

            echo "<tr>
                    <td>" . ($index + 1) . "</td>
                    <td>{$id}</td>
                    <td>{$qty}</td>
                    <td>₱" . number_format($price, 2) . "</td>
                  </tr>";
        }
        echo "</table>";

        // Optional: Calculate total
        $total = array_sum($prices);
        echo "<h4>Total Amount: ₱" . number_format($total, 2) . "</h4>";
    } else {
        echo "<p>No items were selected.</p>";
    }
} else {
    echo "<p>No form data received.</p>";
}
?>
