<?php

class SellerReview{

    private $conn;
    private $table_name = "seller_reviews";
     

    public $id;
    public $farmer_id;
    public $product_id;
    public $customer_id;
    public $message_rating;
    public $rating;
    public $review_text;
    public $review_tag;
    public $order_id;
    public $created_at;

    
    public function __construct($db){
        $this->conn = $db;
    }

    function createSellerReview(){

        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    farmer_id = :farmer_id,
                    product_id = :product_id,
                    customer_id = :customer_id,
                    message_rating = :message_rating,
                    rating = :rating,
                    review_text = :review_text,
                    review_tags = :review_tags,
                    order_id = :order_id,
                    created_at = :created";

        $stmt = $this->conn->prepare($query);

        // Sanitize
        $this->farmer_id      = htmlspecialchars(strip_tags($this->farmer_id));
        $this->product_id     = htmlspecialchars(strip_tags($this->product_id));
        $this->customer_id    = htmlspecialchars(strip_tags($this->customer_id));
        $this->message_rating = htmlspecialchars(strip_tags($this->message_rating));
        $this->rating         = htmlspecialchars(strip_tags($this->rating));
        $this->review_text    = htmlspecialchars(strip_tags($this->review_text));
        $this->review_tag     = htmlspecialchars(strip_tags($this->review_tag));
        $this->order_id       = htmlspecialchars(strip_tags($this->order_id));
        $created_at           = date('Y-m-d H:i:s');

        // Bind
        $stmt->bindParam(':farmer_id', $this->farmer_id);
        $stmt->bindParam(':product_id', $this->product_id);
        $stmt->bindParam(':customer_id', $this->customer_id);
        $stmt->bindParam(':message_rating', $this->message_rating);
        $stmt->bindParam(':rating', $this->rating);
        $stmt->bindParam(':review_text', $this->review_text);
        $stmt->bindParam(':review_tags', $this->review_tags);
        $stmt->bindParam(':order_id', $this->order_id);
        $stmt->bindParam(':created', $created_at);

        // Execute
        if($stmt->execute()){
            return true;
        }

        return false;
    }


}
?>