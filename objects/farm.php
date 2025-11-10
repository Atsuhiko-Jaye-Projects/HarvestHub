<?php

class Farm{

    private $conn;
    private $table_name = "farm_details";

    public $id;
    public $user_id;
    public $municipality;
    public $baranggay;
    public $purok;
    public $farm_ownership;
    public $lot_size;
    public $farm_type;
    public $used_lot_size;
    public $created_at;
    public $modified;


    public function __construct($db) {
	    $this->conn = $db;
	}

    function createFarmInfo(){

        $query = "INSERT INTO
                    " . $this->table_name . "
                    SET
                    user_id=:user_id,
                    municipality=:municipality,
                    baranggay=:baranggay,
                    purok=:purok,
                    lot_size=:lot_size,
                    farm_ownership=:farm_ownership,
                    created_at=:created_at";
        
        $stmt=$this->conn->prepare($query);

        
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->municipality = htmlspecialchars(strip_tags($this->municipality));
        $this->baranggay = htmlspecialchars(strip_tags($this->baranggay));
        $this->purok = htmlspecialchars(strip_tags($this->purok));
        $this->lot_size = htmlspecialchars(strip_tags($this->lot_size));
        $this->farm_ownership = htmlspecialchars(strip_tags($this->farm_ownership));
        $this->created_at = date('Y-m-d H:i:s');

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":municipality", $this->municipality);
        $stmt->bindParam(":baranggay", $this->baranggay);
        $stmt->bindParam(":purok", $this->purok);
        $stmt->bindParam(":lot_size", $this->lot_size);
        $stmt->bindParam(":farm_ownership", $this->farm_ownership);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }else{
            return false;
        }
        
    }

    function getFarmLot(){
        $query = "SELECT lot_size FROM 
                " . $this->table_name . "
                WHERE user_id = ? LIMIT 1";
        
        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(1, $this->user_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
           return $row['lot_size'];
        }else{
            return false;
        }
    }

    function getFarmerDetailsById(){
        $query = "SELECT
                farm_name,
                farm_ownership,
                lot_size,
                used_lot_size,
                farm_type,
                municipality
                FROM " . $this->table_name . "
                WHERE 
                user_id=:user_id LIMIT 0, 1";
        
        $stmt = $this->conn->prepare($query);

        $this->user_id = (int) $this->user_id;
        
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

        $stmt->execute();

        $row =  $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->farm_name = $row['farm_name'];
            $this->farm_ownership = $row['farm_ownership'];
            $this->lot_size = $row['lot_size'];
            $this->used_lot_size = $row['used_lot_size'];
            $this->municipality = $row['municipality'];
            $this->farm_type = $row['farm_type'];
            return true;
        }
        return false;

    }

}

?>