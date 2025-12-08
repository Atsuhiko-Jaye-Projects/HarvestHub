<?php

class Message{
    private $conn;
    private $table_name = "messages";

    public $id;
    public $farmer_id;
    public $conversation_id;
    public $message;
    public $user_id;
    public $timestamp;
    public $created_at;

    public function __construct($db){
        $this->conn = $db;
    }

    
    function sendMessage(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                    SET
                    farmer_id = :farmer_id,
                    user_id = :user_id,
                    message = :message,
                    conversation_id = :conversation_id,
                    timestamp = :timestamp";
        
        $stmt = $this->conn->prepare($query);

        $this->farmer_id = htmlspecialchars(strip_tags($this->farmer_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->message = htmlspecialchars(strip_tags($this->message));
        $this->conversation_id = htmlspecialchars(strip_tags($this->conversation_id));
        $this->timestamp = date("Y-m-d H:i:s");


        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":message", $this->message);
        $stmt->bindParam(":conversation_id", $this->conversation_id);
        $stmt->bindParam(":timestamp", $this->timestamp);   

        return $stmt->execute();
    }

    public function getMessagesByConversation($conversation_id) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE conversation_id = :conversation_id 
                  ORDER BY timestamp ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':conversation_id', $conversation_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>