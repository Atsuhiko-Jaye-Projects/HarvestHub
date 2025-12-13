<?php

class FarmResource{

    private $conn;
    private $table_name = "farm_resources";

    public $id;
    public $user_id;
    public $record_name;
    public $farm_resource_id;
    public $grand_total;
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
                record_name=:record_name,
                farm_resource_id = :farm_resource_id,
                grand_total=:grand_total,
                date=:date,
                created_at=:created_at";
        
        $stmt=$this->conn->prepare($query);

        $this->record_name = htmlspecialchars(strip_tags($this->record_name));
        $this->farm_resource_id = htmlspecialchars(strip_tags($this->farm_resource_id));
        $this->grand_total=htmlspecialchars(strip_tags($this->grand_total));
        $this->date=date ("Y-m-d");
        $this->created_at = date ("Y-m-d H:i:s");

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":record_name", $this->record_name);
        $stmt->bindParam(":farm_resource_id", $this->farm_resource_id);
        $stmt->bindParam(":grand_total", $this->grand_total);
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
                WHERE user_id = :user_id 
                AND date BETWEEN :start_date_expense AND :today_expense
                ORDER BY created_at DESC
                LIMIT {$from_record_num}, {$records_per_page}";

        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':start_date_expense', $this->start_date_expense);
        $stmt->bindParam(':today_expense', $this->today_expense);

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
                grand_total = :grand_total,
                modified_at=:modified_at
                WHERE 
                farm_resource_id=:farm_resource_id";
        
        $stmt=$this->conn->prepare($query);

        $this->modified_at = date ("Y-m-d H:i:s");

        $stmt->bindParam(":farm_resource_id", $this->farm_resource_id);
        $stmt->bindParam(":grand_total", $this->grand_total);
        $stmt->bindParam(":modified_at", $this->modified_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function farmStatsCurrentTotalCost() {
        $query = "SELECT grand_total
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

        if ($row && $row['grand_total'] !== null) {
            return $row['grand_total'];
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

    function getRecordExpense(){
        $query = "SELECT *,
                    (
                        land_prep_expense_cost +
                        nursery_seedling_prep_cost +
                        transplanting_cost +
                        crop_maintenance_cost +
                        input_seed_fertilizer_cost +
                        harvesting_cost +
                        post_harvest_transport_cost
                    ) AS total_expense
                FROM " . $this->table_name . "
                WHERE user_id = :user_id ";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id);

        $stmt->execute();

        return $stmt;
    }

    function getRecordTitle(){
        $query = "SELECT *
                  FROM
                  " . $this->table_name . "
                  WHERE 
                  farm_resource_id=:farm_resource_id";

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":farm_resource_id", $this->farm_resource_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->record_name = $row['record_name'];
        $this->date = $row['date'];

    }




}



?>