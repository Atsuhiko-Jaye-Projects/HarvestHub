<?php

class FarmResource{

    private $conn;
    private $table_name = "farm_resources";

    public $id;
    public $user_id;
    public $item_name;
    public $cost;
    public $date;
    public $created_at;

    public function __construct($db) {
	    $this->conn = $db;
	}

    function createFarmResource(){

        $query = "INSERT INTO 
                " . $this->table_name . "
                SET
                user_id=:user_id,
                item_name=:item_name,
                cost=:cost,
                date=:date,
                type=:type,
                created_at=:created_at";
        
        $stmt=$this->conn->prepare($query);

        $this->item_name = htmlspecialchars(strip_tags($this->item_name));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->cost = htmlspecialchars(strip_tags($this->cost));
        $this->date = htmlspecialchars(strip_tags($this->date));

        $this->created_at = date ("Y-m-d H:i:s");

        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":item_name", $this->item_name);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":cost", $this->cost);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function readAllResource() {
        $query = "SELECT *
                FROM " . $this->table_name . "
                WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }



}



?>