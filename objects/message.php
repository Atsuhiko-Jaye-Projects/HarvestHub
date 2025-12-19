<?php

class Message{
    private $conn;
    private $table_name = "messages";

    public $id;
    public $sender_id;
    public $conversation_id;
    public $message;
    public $receiver_id;
    public $timestamp;
    public $created_at;

    public function __construct($db){
        $this->conn = $db;
    }

    
    function sendMessage(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                    SET
                    receiver_id = :receiver_id,
                    sender_id = :sender_id,
                    message = :message,
                    conversation_id = :conversation_id,
                    timestamp = :timestamp";
        
        $stmt = $this->conn->prepare($query);

        $this->receiver_id = htmlspecialchars(strip_tags($this->receiver_id));
        $this->sender_id = htmlspecialchars(strip_tags($this->sender_id));
        $this->message = htmlspecialchars(strip_tags($this->message));
        $this->conversation_id = htmlspecialchars(strip_tags($this->conversation_id));
        $this->timestamp = date("Y-m-d H:i:s");

        $stmt->bindParam(":receiver_id", $this->receiver_id);
        $stmt->bindParam(":sender_id", $this->sender_id);
        $stmt->bindParam(":message", $this->message);
        $stmt->bindParam(":conversation_id", $this->conversation_id);
        $stmt->bindParam(":timestamp", $this->timestamp);   

        return $stmt->execute();
    }

    public function getMessagesByConversation() {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE conversation_id = :conversation_id 
                  ORDER BY timestamp ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':conversation_id', $this->conversation_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>