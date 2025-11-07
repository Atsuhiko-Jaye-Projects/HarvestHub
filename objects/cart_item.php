<?php

class CartItem{

    private $conn;
    private $table_name = "cart_items";

    public $id;
    public $user_id;
    public $product_id;
    public $quantity;
    public $amount;
    public $status;
    public $created;
    public $modified;

    public function __construct($db){
        $this->conn = $db;
    }

    function addItem(){
        $query = "INSERT INTO 
                    ". $this->table_name . "
                    SET
                    product_id = :product_id,
                    user_id = :user_id,
                    quantity = :quantity,
                    amount = :amount,
                    status = :status,
                    created = :created";
        
        $stmt=$this->conn->prepare($query);

        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->amount = htmlspecialchars(strip_tags($this->amount));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->created = date ("Y-m-d H:i:s");

        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":created", $this->created);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function itemExist(){
        
        $query = "SELECT COUNT(*) FROM
                    " . $this->table_name . "
                    WHERE
                    product_id = :product_id AND user_id=:user_id";

        $stmt=$this->conn->prepare($query);

        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":user_id", $this->user_id);

        $stmt->execute();

        $row = $stmt->fetchColumn();

        return $row > 0;
    }

    function countItem(){
        $query = "SELECT COUNT(*) 
                    FROM
                    " . $this->table_name . "
                    WHERE
                    user_id=:user_id AND status = 'Pending' ";

        $stmt=$this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $stmt->bindParam(":user_id", $this->user_id);

        $stmt->execute();

        $count = $stmt->fetchColumn();

        return $count;
    }

    function cartItems(){
        
        $query = "SELECT product_id, quantity, amount
                    FROM " . $this->table_name . "
                    WHERE 
                    SET 
                    user_id = :user_id";
        
        $stmt=$this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(":user_id", $this->user_id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row > 0) {
            $this->product_id = $row['product_id'];
            $this->quantity = $row['quantity'];
        }else{
            return false;
        }
    }

    function countCartItem(){
        $query = "SELECT * FROM " . $this->table_name . "
            WHERE 
                user_id = :user_id AND status = 'Pending' ";

        $stmt = $this->conn->prepare($query);

        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

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

    function markCartItemsAsOrdered(){

        $query = "UPDATE ". $this->table_name . "
                SET
                    status = :status,
                    modified = :modified
                WHERE 
                    product_id = :product_id";
        
        $stmt=$this->conn->prepare($query);

        $this->status = htmlspecialchars(strip_tags($this->status));
         $this->modified = date("Y-m-d H:i:s");
        $this->product_id = htmlspecialchars(strip_tags($this->product_id));

        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":modified", $this->modified);
        $stmt->bindParam(":product_id", $this->product_id);


        if ($stmt->execute()) {
           return true;
        }
        return false;
    }



}


?>