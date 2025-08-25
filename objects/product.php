<?php

class Product{

    private $conn;
    private $table_name = "products";

    public $id;
    public $product_name;
    public $product_id;
    public $price_per_unit;
    public $category;
    public $user_id;
    public $total_stocks;
    public $lot_size;
    public $product_description;
    public $product_image;
    public $unit;
    public $created_at;
    public $modified;


    public function __construct($db){
        $this->conn = $db;
    }


    function postProduct(){

        $query = "INSERT INTO
                " . $this->table_name . "
                SET
                product_name=:product_name,
                product_id=:product_id,
                user_id=:user_id,
                unit=:unit,
                price_per_unit=:price_per_unit,
                category=:category,
                lot_size=:lot_size,
                product_image = :product_image,
                product_description=:product_description,
                created_at=:created_at";
        
        $stmt=$this->conn->prepare($query);

        $this->product_id=htmlspecialchars(strip_tags($this->product_id));
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->price_per_unit = htmlspecialchars(strip_tags($this->price_per_unit));
        $this->unit = htmlspecialchars(strip_tags($this->unit));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->lot_size = htmlspecialchars(strip_tags($this->lot_size));
        $this->product_image = htmlspecialchars(strip_tags($this->product_image));
        $this->created_at = date ("Y-m-d H:i:s");

        
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":price_per_unit", $this->price_per_unit);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":category", $this->category);
        $stmt->bindParam(":lot_size", $this->lot_size);
        $stmt->bindParam(":product_image", $this->product_image);
        $stmt->bindParam(":unit", $this->unit);
        $stmt->bindParam(":product_description", $this->product_description);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


}


?>