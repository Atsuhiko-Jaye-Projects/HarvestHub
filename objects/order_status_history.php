<?php
class OrderHistory{

    private $table_name = "order_status_history";
    private $conn;

    public $id;
    public $invoice_number;
    public $product_id;
    public $status;
    public $timestamp;


    public function __construct($db) {
		$this->conn = $db;
	}

    function recordStatus(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                    SET
                    invoice_number = :invoice_number,
                    product_id = :product_id,
                    status = :status,
                    timestamp = :timestamp";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":invoice_number", $this->invoice_number);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":timestamp", $this->timestamp);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function getOrderStatus(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE invoice_number = :invoice_number AND product_id = :product_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":invoice_number", $this->invoice_number);
        $stmt->bindParam(":product_id", $this->product_id);

        $stmt->execute();


        return $stmt;
    }

    function getOrderUpdate(){

        $query = "SELECT 
                    status, invoice_number
                  FROM 
                    " . $this->table_name ."
                  WHERE invoice_number = :invoice_number
                  ORDER BY timestamp DESC
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":invoice_number", $this->invoice_number);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

}


?>