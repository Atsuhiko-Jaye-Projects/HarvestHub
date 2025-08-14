<?php

class FarmProduct{

    private $conn;
    private $table_name = "farm_products";

    public $id;
    public $user_id;
    public $product_name;
    public $date_planted;
    public $estimated_harvest_date;
    public $yield;
    public $suggested_price;
    public $created_at;
    public $modified_at;

    public function __construct($db) {
	    $this->conn = $db;
	}

    function createFarmProduct(){

        $query = "INSERT INTO 
                " . $this->table_name . "
                SET
                user_id=:user_id,
                product_name=:product_name,
                date_planted=:date_planted,
                estimated_harvest_date=:estimated_harvest_date,
                yield=:yield,
                suggested_price=:suggested_price,
                created_at=:created_at";
        
        $stmt=$this->conn->prepare($query);

        
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->date_planted = htmlspecialchars(strip_tags($this->date_planted));
        $this->estimated_harvest_date = htmlspecialchars(strip_tags($this->estimated_harvest_date));
        $this->yield = htmlspecialchars(strip_tags($this->yield));
        $this->suggested_price = htmlspecialchars(strip_tags($this->suggested_price));
        $this->created_at = date ("Y-m-d H:i:s");


        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":date_planted", $this->date_planted);
        $stmt->bindParam(":estimated_harvest_date", $this->estimated_harvest_date);
        $stmt->bindParam(":yield", $this->yield);
        $stmt->bindParam(":suggested_price", $this->suggested_price);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function readAllProduct($from_record_num, $records_per_page) {
        $query = "SELECT *
                FROM " . $this->table_name . "
                WHERE user_id = :user_id
                LIMIT
                {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    public function countAll(){

        $query = "SELECT id FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }

        function updateFarmProduct(){

        $query = "UPDATE 
                " . $this->table_name . "
                SET
                product_name=:product_name,
                date_planted=:date_planted,
                estimated_harvest_date=:estimated_harvest_date,
                yield=:yield,
                suggested_price=:suggested_price,
                modified_at=:modified_at
                WHERE id=:id";
        
        $stmt=$this->conn->prepare($query);

        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->product_name = htmlspecialchars(strip_tags($this->product_name));
        $this->date_planted = htmlspecialchars(strip_tags($this->date_planted));
        $this->estimated_harvest_date = htmlspecialchars(strip_tags($this->estimated_harvest_date));
        $this->yield = htmlspecialchars(strip_tags($this->yield));
        $this->suggested_price = htmlspecialchars(strip_tags($this->suggested_price));
        $this->modified_at = date ("Y-m-d H:i:s");

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":product_name", $this->product_name);
        $stmt->bindParam(":date_planted", $this->date_planted);
        $stmt->bindParam(":estimated_harvest_date", $this->estimated_harvest_date);
        $stmt->bindParam(":yield", $this->yield);
        $stmt->bindParam(":suggested_price", $this->suggested_price);
        $stmt->bindParam(":modified_at", $this->modified_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }



}



?>