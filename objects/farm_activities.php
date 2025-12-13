<?php

class FarmActivity{

    private $conn;
    private $table_name = "farm_activities";

    public $id;
    public $farm_resource_id;
    public $activity_name;
    public $activity_cost;
    public $farm_activity_type;
    public $activity_date;
    public $additional_info;
    public $created_at;
    public $modified_at;
    public $farmer_id;

    public function __construct($db){
        $this->conn = $db;
    }

    function createFarmActivity(){
        
        $query="INSERT INTO
                " . $this->table_name . "
                SET
                activity_name=      :activity_name,
                farm_resource_id=   :farm_resource_id,
                activity_cost=      :activity_cost,
                farm_activity_type= :farm_activity_type,
                activity_date=      :activity_date,
                additional_info=    :additional_info,
                created_at =        :created_at";

        $stmt = $this->conn->prepare($query);

        $this->activity_name=htmlspecialchars(strip_tags($this->activity_name));
        $this->activity_cost=htmlspecialchars(strip_tags($this->activity_cost));
        $this->farm_activity_type=htmlspecialchars(strip_tags($this->farm_activity_type));
        $this->activity_date=htmlspecialchars(strip_tags($this->activity_date));
        $this->farm_resource_id=htmlspecialchars(strip_tags($this->farm_resource_id));
        $this->additional_info=htmlspecialchars(strip_tags($this->additional_info));
        $this->created_at = date("Y-m-d H:i:s");

        $stmt->bindParam(":activity_name", $this->activity_name);
        $stmt->bindParam(":activity_cost", $this->activity_cost);
        $stmt->bindParam(":farm_activity_type", $this->farm_activity_type);
        $stmt->bindParam(":activity_date", $this->activity_date);
        $stmt->bindParam(":farm_resource_id", $this->farm_resource_id);
        $stmt->bindParam(":additional_info", $this->additional_info);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function readActivity(){

        $query = "SELECT *
                  FROM
                  " . $this->table_name . "
                  WHERE 
                  farm_resource_id = :farm_resource_id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":farm_resource_id", $this->farm_resource_id);
        
        $stmt->execute();

        return $stmt;
    }

    function updateFarmActivity() {
    $query = "UPDATE " . $this->table_name . "
              SET
                  activity_name = :activity_name,
                  farm_activity_type = :farm_activity_type,
                  activity_cost = :activity_cost,
                  activity_date = :activity_date,
                  additional_info = :additional_info
              WHERE
                  farm_resource_id = :farm_resource_id";

    $stmt = $this->conn->prepare($query);

    $this->activity_name = htmlspecialchars(strip_tags($this->activity_name));
    $this->activity_cost = htmlspecialchars(strip_tags($this->activity_cost));
    $this->farm_activity_type = htmlspecialchars(strip_tags($this->farm_activity_type));
    $this->activity_date = htmlspecialchars(strip_tags($this->activity_date));
    $this->additional_info = htmlspecialchars(strip_tags($this->additional_info));
    $this->farm_resource_id = htmlspecialchars(strip_tags($this->farm_resource_id));

    $stmt->bindParam(":activity_name", $this->activity_name);
    $stmt->bindParam(":farm_activity_type", $this->farm_activity_type);
    $stmt->bindParam(":activity_cost", $this->activity_cost);
    $stmt->bindParam(":activity_date", $this->activity_date);
    $stmt->bindParam(":additional_info", $this->additional_info);
    $stmt->bindParam(":farm_resource_id", $this->farm_resource_id);

    return $stmt->execute();
}


   
}

?>