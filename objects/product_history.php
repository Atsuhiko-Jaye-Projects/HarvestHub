<?php
class ProductHistory{

    private $conn;
    private $table_name = "product_histories";

    public $id;
    public $product_id;
    public $new_price_per_unit;
    public $farmer_id;
    public $old_price_per_unit;
    public $created_at;
    public $modified;



    public function __construct($db){
        $this->conn = $db;
    }

    function LogPrice(){
        $query = "INSERT INTO 
                    " . $this->table_name . "
                 SET
                 farmer_id = :farmer_id,
                 product_id = :product_id,
                 new_price_per_unit = :new_price_per_unit,
                 old_price_per_unit = :old_price_per_unit,
                 recorded_at = :recorded_at";

        $stmt = $this->conn->prepare($query);

        $this->created_at = date("Y-m-d H:i:s");
        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":new_price_per_unit", $this->new_price_per_unit);
        $stmt->bindParam(":old_price_per_unit", $this->old_price_per_unit);
        $stmt->bindParam(":recorded_at", $this->created_at);

        if ($stmt->execute()) {
           return true;
        }
        return false;
    }
}
?>