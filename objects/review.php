<?php

class Review{

    private $conn;
    private $table_name = "reviews";
     

    public $id;
    public $user_id;
    public $product_id;
    public $customer_id;
    public $rate;
    public $review_text;
    public $reply;
    public $created_at;

    
    public function __construct($db){
        $this->conn = $db;
    }

    function readAllReview() {
    $query = "SELECT *
              FROM " . $this->table_name . "
              WHERE product_id = :product_id";

    $stmt = $this->conn->prepare($query);

    $this->product_id = htmlspecialchars(strip_tags($this->product_id));

    $stmt->bindParam(":product_id", $this->product_id, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt;
}



}


?>