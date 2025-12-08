<?php

class Conversation{
    private $conn;
    private $table_name = "conversations";

    public $id;
    public $farmer_id;
    public $user_id;
    public $timestamp;
    public $created_at;

    public function __construct($db){
        $this->conn = $db;
    }

    // check if existing convo between

    public function getOrCreateConversation($user_id, $farmer_id) {
        // Check existing conversation
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE user_id = :user_id AND farmer_id = :farmer_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":farmer_id", $farmer_id);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['id']; // existing conversation
        }

        // Create new conversation
        $query = "INSERT INTO " . $this->table_name . " 
                  SET user_id = :user_id, farmer_id = :farmer_id, created_at = :created_at";
        $stmt = $this->conn->prepare($query);
        $created_at = date("Y-m-d H:i:s");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":farmer_id", $farmer_id);
        $stmt->bindParam(":created_at", $created_at);
        $stmt->execute();

        return $this->conn->lastInsertId();
    }


    public function getUserConversations($user_id){
        // Query all conversations where this user is either user or farmer
        $query = "
            SELECT 
                c.id AS conversation_id,
                u.firstname AS name,
                u.profile_pic,
                m.message AS last_message,
                m.timestamp
            FROM conversations c
            LEFT JOIN (
                SELECT m1.conversation_id, m1.message, m1.timestamp
                FROM messages m1
                INNER JOIN (
                    SELECT conversation_id, MAX(timestamp) AS last_time
                    FROM messages
                    GROUP BY conversation_id
                ) m2 ON m1.conversation_id = m2.conversation_id AND m1.timestamp = m2.last_time
            ) m ON m.conversation_id = c.id
            LEFT JOIN `users` u ON u.id = IF(c.user_id = :user_id, c.farmer_id, c.user_id)
            WHERE c.user_id = :user_id OR c.farmer_id = :user_id
            ORDER BY m.timestamp DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conversations = [];

        foreach($rows as $row){
            $conversations[] = [
                'conversation_id' => $row['conversation_id'],
                'name' => $row['name'],
                'last_message' => $row['last_message'],
                'timestamp' => $row['timestamp'],
                'profile_pic' => !empty($row['profile_pic']) 
                                    ? '/HarvestHub/user/uploads/profile_pictures/farmer/'.$row['profile_pic'] 
                                    : '/HarvestHub/user/uploads/logo.png' // fallback
            ];
        }
        return $conversations;
    }


}

?>