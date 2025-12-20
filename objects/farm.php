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
    public $province;
    public $lot_size;
    public $farm_type;
    public $used_lot_size;
    public $farm_name;
    public $follower_count;
    public $following_count;
    public $farm_image;
    public $created_at;
    public $modified;
    public $additional_used_size;


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
                    province=:province,
                    lot_size=:lot_size,
                    farm_ownership=:farm_ownership,
                    created_at=:created_at";
        
        $stmt=$this->conn->prepare($query);

        
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->municipality = htmlspecialchars(strip_tags($this->municipality));
        $this->baranggay = htmlspecialchars(strip_tags($this->baranggay));
        $this->purok = htmlspecialchars(strip_tags($this->purok));
        $this->province = htmlspecialchars(strip_tags($this->province));
        $this->lot_size = htmlspecialchars(strip_tags($this->lot_size));
        $this->farm_ownership = htmlspecialchars(strip_tags($this->farm_ownership));
        $this->created_at = date('Y-m-d H:i:s');

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":municipality", $this->municipality);
        $stmt->bindParam(":baranggay", $this->baranggay);
        $stmt->bindParam(":purok", $this->purok);
        $stmt->bindParam(":province", $this->province);
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
    
    function getFarmerLocation(){
        $query = "SELECT * 
                  FROM 
                    " . $this->table_name . " 
                  WHERE 
                    user_id = :user_id";
        
        $stmt=$this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->province = $row['province'];
        $this->municipality = $row['municipality'];
        $this->baranggay = $row['baranggay'];
    }
    function getFarmInfo(){
        $query = "SELECT * 
                  FROM 
                    " . $this->table_name . " 
                  WHERE 
                    user_id = :user_id";
        
        $stmt=$this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $this->follower_count = $row['follower_count'];
        $this->following_count = $row['following_count'];
        $this->user_id = $row['user_id'];
        $this->farm_image = $row['farm_image'] ?? 'logo.png';
        $this->farm_name = isset($row['farm_name']) ? $row['farm_name'] : 'Harvest Hub';
        $this->created_at = $row['created_at'];
    }

    function updateFarmDetail(){
        
        $query = "UPDATE
                  " . $this->table_name . "
                  SET
                    lot_size = :lot_size,
                    farm_type = :farm_type,
                    farm_name = :farm_name,
                    province = :province,
                    municipality = :municipality,
                    baranggay = :baranggay,
                    purok = :purok
                  WHERE
                    user_id =:user_id";
        
        $stmt=$this->conn->prepare($query);

        $this->lot_size=htmlspecialchars(strip_tags($this->lot_size));
        $this->farm_type=htmlspecialchars(strip_tags($this->farm_type));
        $this->farm_name=htmlspecialchars(strip_tags($this->farm_name));
        $this->province=htmlspecialchars(strip_tags($this->province));
        $this->municipality=htmlspecialchars(strip_tags($this->municipality));
        $this->baranggay=htmlspecialchars(strip_tags($this->baranggay));
        $this->purok=htmlspecialchars(strip_tags($this->purok));

        $stmt->bindParam(":lot_size", $this->lot_size);
        $stmt->bindParam(":farm_type", $this->farm_type);
        $stmt->bindParam(":farm_name", $this->farm_name);
        $stmt->bindParam(":province", $this->province);
        $stmt->bindParam(":municipality", $this->municipality);
        $stmt->bindParam(":baranggay", $this->baranggay);
        $stmt->bindParam(":purok", $this->purok);
        $stmt->bindParam(":user_id", $this->user_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function getfarmerProfile(){
        $query = "SELECT farm_name
                  FROM
                  " . $this->table_name . "
                  WHERE
                  user_id = :user_id";

        $stmt=$this->conn->prepare($query);
        
        $stmt->bindParam(":user_id", $this->user_id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['farm_name'] ?? null;
    }

    function addUsedLotSize() {
        $query = "UPDATE 
                    " . $this->table_name . "
                SET 
                    used_lot_size = used_lot_size + :additional_used_size
                WHERE 
                    user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":additional_used_size", $this->additional_used_size);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->execute();
    }

    function getLotSizeInfo(){

        $query = "SELECT 
                    lot_size,
                    used_lot_size
                  FROM
                    " . $this->table_name . "
                  WHERE 
                    user_id = :user_id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);
        
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

}



?>