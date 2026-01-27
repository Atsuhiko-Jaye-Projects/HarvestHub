<?php

class Crop{

    private $conn;
    private $table_name = "crops";

    public $id;
    public $user_id;
    public $crop_name;
    public $date_planted;
    public $estimated_harvest_date;
    public $farm_resource_id;
    public $yield;
    public $suggested_price;
    public $plant_count;
    public $created_at;
    public $stocks;
    public $modified_at;
    public $is_posted;
    public $province;
    public $municipality;
    public $crop_status;
    public $baranggay;

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
                farm_resource_id=:farm_resource_id,
                created_at=:created_at,
                stocks=:stocks,
                plant_count = :plant_count,
                province = :province,
                municipality = :municipality,
                baranggay = :baranggay";

        $stmt=$this->conn->prepare($query);


        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->crop_name = htmlspecialchars(strip_tags($this->crop_name));
        $this->yield = htmlspecialchars(strip_tags($this->yield));
        $this->cultivated_area = htmlspecialchars(strip_tags($this->cultivated_area));
        $this->date_planted = htmlspecialchars(strip_tags($this->date_planted));
        $this->farm_resource_id = htmlspecialchars(strip_tags($this->farm_resource_id));
        $this->estimated_harvest_date = htmlspecialchars(strip_tags($this->estimated_harvest_date));
        $this->suggested_price = htmlspecialchars(strip_tags($this->suggested_price));
        $this->stocks = htmlspecialchars(strip_tags($this->stocks));
        $this->plant_count = htmlspecialchars(strip_tags($this->plant_count));
        $this->province = htmlspecialchars(strip_tags($this->province));
        $this->municipality = htmlspecialchars(strip_tags($this->municipality));
        $this->baranggay = htmlspecialchars(strip_tags($this->baranggay));
        $this->created_at = date ("Y-m-d H:i:s");


        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":crop_name", $this->crop_name);
        $stmt->bindParam(":yield", $this->yield);
        $stmt->bindParam(":cultivated_area", $this->cultivated_area);
        $stmt->bindParam(":date_planted", $this->date_planted);
        $stmt->bindParam(":estimated_harvest_date", $this->estimated_harvest_date);
        $stmt->bindParam(":suggested_price", $this->suggested_price);
        $stmt->bindParam(":stocks", $this->stocks);
        $stmt->bindParam(":farm_resource_id", $this->farm_resource_id);
        $stmt->bindParam(":plant_count", $this->plant_count);
        $stmt->bindParam(":province", $this->province);
        $stmt->bindParam(":municipality", $this->municipality);
        $stmt->bindParam(":baranggay", $this->baranggay);
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
                  LIMIT $from_record_num, $records_per_page";

        $stmt = $this->conn->prepare($query);

        // IMPORTANT: Use bindValue() instead of bindParam() for LIMIT (avoids reference issues)
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();

        return $stmt;

        // // Count total rows for pagination
        // $count_query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " WHERE user_id = :user_id";
        // $count_stmt = $this->conn->prepare($count_query);
        // $count_stmt->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
        // $count_stmt->execute();

        // $count_row = $count_stmt->fetch(PDO::FETCH_ASSOC);
        // $total_rows = $count_row['total_rows'];

        // return [
        //     "records" => $products,
        //     "total_rows" => $total_rows
        // ];
    }

    function updateFarmProduct() {
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    user_id = :user_id,
                    crop_name = :crop_name,
                    yield = :yield,
                    cultivated_area = :cultivated_area,
                    date_planted = :date_planted,
                    estimated_harvest_date = :estimated_harvest_date,
                    suggested_price = :suggested_price,
                    plant_count = :plant_count,
                    stocks = :stocks,
                    crop_status = :crop_status,
                    status = :status,
                    modified_at = :modified_at
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->crop_name = htmlspecialchars(strip_tags($this->crop_name));
        $this->yield = htmlspecialchars(strip_tags($this->yield));
        $this->cultivated_area = htmlspecialchars(strip_tags($this->cultivated_area));
        $this->date_planted = htmlspecialchars(strip_tags($this->date_planted));
        $this->plant_count = htmlspecialchars(strip_tags($this->plant_count));
        $this->stocks = htmlspecialchars(strip_tags($this->stocks));
        $this->estimated_harvest_date = htmlspecialchars(strip_tags($this->estimated_harvest_date));
        $this->suggested_price = htmlspecialchars(strip_tags($this->suggested_price));
        $this->modified_at = date("Y-m-d H:i:s");
        $this->crop_status = htmlspecialchars(strip_tags($this->crop_status));;

        // Bind parameters
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":crop_name", $this->crop_name);
        $stmt->bindParam(":yield", $this->yield);
        $stmt->bindParam(":cultivated_area", $this->cultivated_area);
        $stmt->bindParam(":date_planted", $this->date_planted);
        $stmt->bindParam(":plant_count", $this->plant_count);
        $stmt->bindParam(":stocks", $this->stocks);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":estimated_harvest_date", $this->estimated_harvest_date);
        $stmt->bindParam(":suggested_price", $this->suggested_price);
        $stmt->bindParam(":modified_at", $this->modified_at);
        $stmt->bindParam(":crop_status", $this->crop_status);

        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (PDOException $e) {
            echo "Error updating product: " . $e->getMessage();
        }

        return false;
    }

    function getMostPlanted() {
            $query = "
                SELECT 
                    crop_name,
                    SUM(plant_count) AS total_planted
                FROM " . $this->table_name . "
                WHERE user_id = :user_id
                GROUP BY crop_name
                ORDER BY total_planted DESC
                LIMIT 5
            ";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->execute(); // ⬅️ REQUIRED

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function topCropInArea(){
        $query = "SELECT 
                    LOWER(crop_name) AS crop_name, 
                    SUM(plant_count) AS total_planted
                  FROM 
                    " . $this->table_name . " 
                  WHERE 
                    baranggay =:baranggay 
                  GROUP BY 
                    crop_name 
                  ORDER BY 
                    total_planted DESC
                  LIMIT
                    5";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":baranggay", $this->baranggay);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function MarkCropAsPlanted(){
        $query = "UPDATE 
                    " . $this->table_name . "
                    SET
                    crop_status = :crop_status,
                    modified_at = :modified_at
                    WHERE
                    farm_resource_id = :farm_resource_id";
        
        $stmt = $this->conn->prepare($query);

        $this->modified_at = date("Y-m-d H-i-s");

        $stmt->bindParam(":crop_status", $this->crop_status);
        $stmt->bindParam(":modified_at", $this->modified_at);
        $stmt->bindParam(":farm_resource_id", $this->farm_resource_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;   
    }

    function countAll(){
        $query = "SELECT id FROM " . $this->table_name . "";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $num = $stmt->rowCount();

        return $num;
    }

    function getFarmStats(){
        $query = "SELECT COUNT(id) AS crop_plant_count,
                  AVG(yield) AS avg_yield,
                  SUM(stocks) AS plant_stocks,
                  SUM(plant_count) AS planted_crops
                  FROM
                  " . $this->table_name . "
                  WHERE
                  user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return  $row;
    }

    function getHarvestedCrops(){

        $query = "SELECT *
                  FROM
                    " . $this->table_name . "
                  WHERE 
                    user_id = :user_id AND crop_status = 'harvested'";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);

        $stmt->execute();

        return $stmt;
    }

    function cropPosted(){


        $query = "UPDATE 
                    " . $this->table_name . "
                    SET
                        status = :status
                WHERE
                    id = :id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id" , $this->id);

        $stmt->execute();
    }

    public function deleteCrop() {

        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    function readAllPlantedCrop($from_record_num, $records_per_page) {
        $query = "SELECT * FROM " . $this->table_name . "
                  WHERE user_id = :user_id AND crop_status = 'crop planted'
                  ORDER BY id DESC
                  LIMIT $from_record_num, $records_per_page";

        $stmt = $this->conn->prepare($query);

        // IMPORTANT: Use bindValue() instead of bindParam() for LIMIT (avoids reference issues)
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();

        return $stmt;

        // // Count total rows for pagination
        // $count_query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " WHERE user_id = :user_id";
        // $count_stmt = $this->conn->prepare($count_query);
        // $count_stmt->bindValue(":user_id", $this->user_id, PDO::PARAM_INT);
        // $count_stmt->execute();

        // $count_row = $count_stmt->fetch(PDO::FETCH_ASSOC);
        // $total_rows = $count_row['total_rows'];

        // return [
        //     "records" => $products,
        //     "total_rows" => $total_rows
        // ];
    }

}



?>
