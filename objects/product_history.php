<?php
class ProductHistory{

    private $conn;
    private $table_name = "product_histories";

    public $id;
    public $farmer_id;
    public $product_id;
    public $price_per_unit;
    public $recorded_at;

    public function __construct($db){
        $this->conn = $db;
    }



    function recordPriceHistory(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                    SET
                        product_id = :product_id,
                        farmer_id = :farmer_id,
                        price_per_unit = :price_per_unit,
                        recorded_at = :recorded_at ";


        $stmt = $this->conn->prepare($query);

        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->farmer_id = htmlspecialchars(strip_tags($this->farmer_id));
        $this->price_per_unit = htmlspecialchars(strip_tags($this->price_per_unit));

        $this->recorded_at = date("Y-m-d H:m:s");

        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->bindParam(":price_per_unit", $this->price_per_unit);
        $stmt->bindParam(":recorded_at", $this->recorded_at);

        if ($stmt->execute()) {
            return true;
        }
        return false;   

        

    }

}



?>