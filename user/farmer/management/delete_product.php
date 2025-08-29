<?php

if ($_POST) {
    
    include_once "../../../config/core.php";
    include_once "../../../config/database.php";
    include_once "../../../objects/product.php";

    $database = new Database($db);
    $db = $database->getConnection();

    $product = new Product($db);

    $product->id = $_POST['object_id'];
    $product->status = "Deleted";

    if ($product->deleteProduct()) {
        echo "Product deleted.";
    }else{
        echo "Unable to delete.";
    }

}
?>