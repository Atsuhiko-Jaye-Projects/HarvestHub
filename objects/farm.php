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
                    farm_ownership=:farm_ownership,
                    created_at=:created_at";
        
        $stmt=$this->conn->prepare($query);

        
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->municipality = htmlspecialchars(strip_tags($this->municipality));
        $this->baranggay = htmlspecialchars(strip_tags($this->baranggay));
        $this->purok = htmlspecialchars(strip_tags($this->purok));
        $this->farm_ownership = htmlspecialchars(strip_tags($this->farm_ownership));
        $this->created_at = date('Y-m-d H:i:s');

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":municipality", $this->municipality);
        $stmt->bindParam(":baranggay", $this->baranggay);
        $stmt->bindParam(":purok", $this->purok);
        $stmt->bindParam(":farm_ownership", $this->farm_ownership);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }else{
            return false;
        }
        
    }


}

?>