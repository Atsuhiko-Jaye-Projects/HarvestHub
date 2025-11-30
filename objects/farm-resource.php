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
    public $modified_at;
    public $start_date_expense;
    public $today_expense;

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

    function readAllResource($from_record_num, $records_per_page) {
        $query = "SELECT *
                FROM " . $this->table_name . "
                WHERE user_id = :user_id AND date BETWEEN :start_date_expense AND :today_expense
                LIMIT
                {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->start_date_expense = htmlspecialchars(strip_tags($this->start_date_expense));
        $this->today_expense = htmlspecialchars(strip_tags($this->today_expense));

        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(":start_date_expense", $this->start_date_expense);
        $stmt->bindParam(":today_expense", $this->today_expense);

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
    public function search($search_term, $from_record_num, $records_per_page) {
        // select query with alias used
        $query = "SELECT
                    i.*
                FROM
                    " . $this->table_name . " i
                WHERE
                    i.item_name LIKE ?
                LIMIT ?, ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind variables
        $search_term = "%{$search_term}%";
        $stmt->bindParam(1, $search_term, PDO::PARAM_STR);
        $stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(3, $records_per_page, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    public function countAll_BySearch($search_term) {
        // select query
        $query = "SELECT
                    COUNT(*) as total_rows
                FROM
                    " . $this->table_name . " i
                WHERE
                    i.item_name LIKE ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind variable values
        $search_term = "%{$search_term}%";
        $stmt->bindParam(1, $search_term, PDO::PARAM_STR);

        // execute and fetch
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

    function updateFarmResource(){

        $query = "UPDATE 
                " . $this->table_name . "
                SET
                item_name=:item_name,
                cost=:cost,
                date=:date,
                type=:type,
                modified_at=:modified_at
                WHERE 
                id=:id";
        
        $stmt=$this->conn->prepare($query);

        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->item_name = htmlspecialchars(strip_tags($this->item_name));
        $this->cost = htmlspecialchars(strip_tags($this->cost));
        $this->date = htmlspecialchars(strip_tags($this->date));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->modified_at = date ("Y-m-d H:i:s");

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":item_name", $this->item_name);
        $stmt->bindParam(":cost", $this->cost);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":modified_at", $this->modified_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function farmStatsCurrentTotalCost() {
        $query = "SELECT SUM(cost) AS total_expense 
                  FROM " . $this->table_name . " 
                  WHERE 
                    date BETWEEN :start_date_expense AND :today_expense 
                  AND user_id = :user_id";

        $stmt = $this->conn->prepare($query);


        $this->user_id=htmlspecialchars(strip_tags($this->user_id));
        $this->start_date_expense=htmlspecialchars(strip_tags($this->start_date_expense));
        $this->today_expense=htmlspecialchars(strip_tags($this->today_expense));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":start_date_expense", $this->start_date_expense);
        $stmt->bindParam(":today_expense", $this->today_expense);


        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $row['total_expense'] !== null) {
            return $row['total_expense'];
        } else {
            return 0; // No expenses found
        }
    }

    function deleteResource(){

        $query = "DELETE FROM " . $this->table_name . " 
                    WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()){
            return true;
            print_r($stmt->errorInfo());
        }
        return false;
    }




}



?>