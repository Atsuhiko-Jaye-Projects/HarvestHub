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
        $query = "SELECT * 
                  FROM 
                    " . $this->table_name . " 
                    WHERE invoice_number = :invoice_number AND product_id = :product_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":invoice_number", $this->invoice_number);
        $stmt->bindParam(":product_id", $this->product_id);

        $stmt->execute();
        return $stmt;
    }

    function getOrderUpdate(){

        $query = "SELECT 
                    status, invoice_number, notif_viewed, id
                  FROM 
                    " . $this->table_name ."
                  WHERE invoice_number = :invoice_number AND notif_viewed = 0
                  ORDER BY timestamp DESC
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":invoice_number", $this->invoice_number);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    function markNotifcation(){
        $query = "UPDATE 
                    " . $this->table_name . "
                    SET
                        notif_viewed = 1,
                        timestamp = :timestamp
                    WHERE
                        invoice_number = :invoice_number 
                        AND id = :id";

        $stmt = $this->conn->prepare($query);
        
        $this->timestamp = date('Y-m-d H:i:s');
        $stmt->bindParam(":invoice_number", $this->invoice_number);
        $stmt->bindParam(":id", $this->id);
        
        $stmt->bindParam(":timestamp", $this->timestamp);
        $stmt->execute();
    }

    function getLatestUnseenCount() {

        $query = "
            SELECT COUNT(*) AS unseen_count
            FROM " . $this->table_name . " o
            WHERE o.timestamp = (
                SELECT MAX(timestamp)
                FROM " . $this->table_name . " t
                WHERE t.invoice_number = o.invoice_number AND t.notif_viewed = 0
            )
            AND o.notif_viewed = 0
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['unseen_count'];
    }



}


?>