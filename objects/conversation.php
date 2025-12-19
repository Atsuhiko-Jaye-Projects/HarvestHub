<?php

class Conversation{
    private $conn;
    private $table_name = "conversations";

    public $id;
    public $property_sender_id;
    public $property_receiver_id;
    public $timestamp;
    public $created_at;

    public function __construct($db){
        $this->conn = $db;
    }

    // check if existing convo between

    public function getOrCreateConversation() {
        // Check existing conversation (in both directions)
        $query = "SELECT id FROM " . $this->table_name . " 
                WHERE 
                (sender_id = :sender_id AND receiver_id = :receiver_id)
                OR
                (sender_id = :receiver_id AND receiver_id = :sender_id)
                LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":sender_id", $this->property_sender_id);
        $stmt->bindParam(":receiver_id", $this->property_receiver_id);
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['id']; // existing conversation
        }

        // Create new conversation
        $query = "INSERT INTO " . $this->table_name . " 
                SET 
                sender_id = :sender_id, 
                receiver_id = :receiver_id, 
                created_at = :created_at";

        $stmt = $this->conn->prepare($query);
        $created_at = date("Y-m-d H:i:s");
        $stmt->bindParam(":sender_id", $this->property_sender_id);
        $stmt->bindParam(":receiver_id", $this->property_receiver_id);
        $stmt->bindParam(":created_at", $created_at);
        $stmt->execute();

        return $this->conn->lastInsertId();
    }



    public function getUserConversations() {

        $query = "
            SELECT 
                c.id AS conversation_id,
                c.receiver_id AS receiver_id,
                c.sender_id AS sender_id,
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
                ) m2 
                ON m1.conversation_id = m2.conversation_id 
                AND m1.timestamp = m2.last_time
            ) m ON m.conversation_id = c.id

            LEFT JOIN users u 
                ON u.id = IF(c.sender_id = :user_id, c.receiver_id, c.sender_id)

            WHERE c.sender_id = :user_id OR c.receiver_id = :user_id
            ORDER BY m.timestamp DESC
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->property_sender_id);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $conversations = [];

        foreach ($rows as $row) {
            $conversations[] = [
                'conversation_id' => $row['conversation_id'],
                'name' => $row['name'],
                'last_message' => $row['last_message'],
                'timestamp' => $row['timestamp'],
                'receiver_id' => $row['receiver_id'],
                'sender_id' => $row['sender_id'],
                'profile_pic' => !empty($row['profile_pic'])
                    ? '/HarvestHub/user/uploads/profile_pictures/farmer/'.$row['profile_pic']
                    : '/HarvestHub/user/uploads/logo.png'
            ];
        }

        return $conversations;
    }



}

?>