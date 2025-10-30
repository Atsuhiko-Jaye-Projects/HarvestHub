<?php

class Crop{

    private $conn;
    private $table_name = "crops";

    public $id;
    public $user_id;
    public $crop_name;
    public $date_planted;
    public $estimated_harvest_date;
    public $yield;
    public $suggested_price;
    public $created_at;
    public $modified_at;

    public function __construct($db) {
	    $this->conn = $db;
	}

    function createCrop(){

        $query = "INSERT INTO
                " . $this->table_name . "
                SET
                user_id=:user_id,
                crop_name=:crop_name,
                yield=:yield,
                cultivated_area=:cultivated_area,
                date_planted=:date_planted,
                estimated_harvest_date=:estimated_harvest_date,
                suggested_price=:suggested_price,
                created_at=:created_at";

        $stmt=$this->conn->prepare($query);


        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->crop_name = htmlspecialchars(strip_tags($this->crop_name));
        $this->yield = htmlspecialchars(strip_tags($this->yield));
        $this->cultivated_area = htmlspecialchars(strip_tags($this->cultivated_area));
        $this->date_planted = htmlspecialchars(strip_tags($this->date_planted));
        $this->estimated_harvest_date = htmlspecialchars(strip_tags($this->estimated_harvest_date));
        $this->suggested_price = htmlspecialchars(strip_tags($this->suggested_price));
        $this->created_at = date ("Y-m-d H:i:s");


        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":crop_name", $this->crop_name);
        $stmt->bindParam(":yield", $this->yield);
        $stmt->bindParam(":cultivated_area", $this->cultivated_area);
        $stmt->bindParam(":date_planted", $this->date_planted);
        $stmt->bindParam(":estimated_harvest_date", $this->estimated_harvest_date);
        $stmt->bindParam(":suggested_price", $this->suggested_price);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function readAllCrop($from_record_num, $records_per_page) {
        $query = "SELECT * FROM " . $this->table_name . "
                  WHERE user_id = :user_id
                  ORDER BY id DESC
                  LIMIT :from_record_num, :records_per_page";

        $stmt = $this->conn->prepare($query);

        // IMPORTANT: Use bindValue() instead of bindParam() for LIMIT (avoids reference issues)
        $stmt->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
        $stmt->bindValue(":from_record_num", (int)$from_record_num, PDO::PARAM_INT);
        $stmt->bindValue(":records_per_page", (int)$records_per_page, PDO::PARAM_INT);

        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Count total rows for pagination
        $count_query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " WHERE user_id = :user_id";
        $count_stmt = $this->conn->prepare($count_query);
        $count_stmt->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
        $count_stmt->execute();

        $count_row = $count_stmt->fetch(PDO::FETCH_ASSOC);
        $total_rows = $count_row['total_rows'];

        return [
            "records" => $products,
            "total_rows" => $total_rows
        ];
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
