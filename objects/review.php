<?php

class Review{

    private $conn;
    private $table_name = "reviews";
     

    public $id;
    public $user_id;
    public $farmer_id;
    public $product_id;
    public $customer_id;
    public $rating;
    public $review_text;
    public $reply;
    public $created_at;

    
    public function __construct($db){
        $this->conn = $db;
    }

    function readAllReview($from_record_num, $records_per_page) {
        $query = "SELECT r.*, CONCAT(u.firstname, ' ' , u.lastname) AS customer_name
                FROM " . $this->table_name . " r
                LEFT JOIN users u ON r.customer_id = u.id
                WHERE r.product_id = :product_id
                LIMIT
                $from_record_num, $records_per_page";

        $stmt = $this->conn->prepare($query);

        $this->product_id = htmlspecialchars(strip_tags($this->product_id));

        $stmt->bindParam(":product_id", $this->product_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    function countAllReviews() {
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " WHERE product_id = :product_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $this->product_id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    }

    function createReview(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                    SET
                    review_text = :review_text,
                    rating = :rating,
                    product_id = :product_id,
                    user_id = :user_id,
                    customer_id = :customer_id,
                    created_at = :created_at";
        
        $stmt = $this->conn->prepare($query);

        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->rating = htmlspecialchars(strip_tags($this->rating));
        $this->review_text = htmlspecialchars(strip_tags($this->review_text));
        $this->created_at = date("Y-m-d H:i:s");
        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id)); 
        
        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":rating", $this->rating);
        $stmt->bindParam(":review_text", $this->review_text);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
           return true;
        }
        return false;
    }



}


?>