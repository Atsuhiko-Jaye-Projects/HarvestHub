<?php

class Order{
    
    private $conn;
    private $table_name = "orders";

    public $id;
    public $product_id;
    public $invoice_number;
    public $customer_id;
    public $mode_of_payment;
    public $quantity;
    public $status;
    public $created_at;
    public $modified_at;

    public function __construct($db){
        $this->conn = $db;
    }

    function readAllOrder($from_record_num, $records_per_page) {
        $query = "SELECT *
                FROM " . $this->table_name . "
                WHERE customer_id = :customer_id
                ORDER BY id DESC
                LIMIT {$from_record_num}, {$records_per_page}";


        $stmt = $this->conn->prepare($query);

        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));

        $stmt->bindParam(":customer_id", $this->customer_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    public function countAll(){

        $query = "SELECT customer_id FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }

    function placeOrder(){
        $query = "INSERT INTO
                ". $this->table_name ."
                SET
                product_id = :product_id,
                invoice_number = :invoice_number,
                customer_id = :customer_id,
                mode_of_payment = :mode_of_payment,
                quantity = :quantity,
                status = :status,
                created_at =:created_at";

        $stmt = $this->conn->prepare($query);

        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->invoice_number= htmlspecialchars(strip_tags($this->invoice_number));
        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
        $this->mode_of_payment=htmlspecialchars(strip_tags($this->mode_of_payment));
        $this->quantity=htmlspecialchars(strip_tags($this->quantity));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->created_at=htmlspecialchars(strip_tags($this->created_at));

        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":invoice_number", $this->invoice_number);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":mode_of_payment", $this->mode_of_payment);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created_at", $this->created_at);
        
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function readOrderDetails(){
        $query = "SELECT 
                product_id, invoice_number, customer_id, mode_of_payment, quantity, created_at
                FROM " . $this->table_name . "
                where id = :id
                LIMIT
                0,1";
        $stmt=$this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->product_id = $row['product_id'];
        $this->invoice_number = $row['invoice_number'];
        $this->mode_of_payment = $row['mode_of_payment'];
        $this->quantity = $row['quantity'];
        $this->created_at = $row['created_at'];
        $this->customer_id = $row['customer_id'];
        
    }

    


}





?>