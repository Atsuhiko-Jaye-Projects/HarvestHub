<?php

if ($_POST) {
    
    include_once "../../../../config/core.php";
    include_once "../../../../config/database.php";
    include_once "../../../../objects/farm-resource.php";

    $database = new Database();
    $db = $database->getConnection();

    $farm_resource = new FarmResource($db);

    $farm_resource->id = $_POST['id'];

    if ($farm_resource->deleteResource()) {
        echo "Resource deleted.";
    }else{
        echo "Unable to delete.";
    }

}
?>