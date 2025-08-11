<?php

class Order{
    
    private $conn;
    private $table_name = "orders";

    public $id;
    public $user_id;
    public $customer_id;
    public $order_id;
    public $contact_number;
    public $address;
    public $total_price;
    public $mode_of_payment;
    public $lot_size;
    public $order_date;
    public $status;
    public $created_at;
    public $modified_at;

    public function __construct($db){
        $this->conn = $db;
    }

        function readAllOrder() {
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