<?php

class PasswordReset{

    private $conn;
    private $table_name = "password_resets";

    public $id;
    public $email_address;
    public $token;
    public $expires_at;

    public function __construct($db){
        $this->conn = $db;
    }

    function generateToken() {
        $query = "INSERT INTO " . $this->table_name . "
                SET
                    email_address = :email_address,
                    token = :token,
                    expires_at = :expires_at";

        $stmt = $this->conn->prepare($query);

        $this->email_address = htmlspecialchars(strip_tags($this->email_address));
        $this->token = htmlspecialchars(strip_tags($this->token));
        $this->expires_at = htmlspecialchars(strip_tags($this->expires_at));

        $stmt->bindParam(":email_address", $this->email_address);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":expires_at", $this->expires_at);

        return $stmt->execute();
    }

    function verifyToken(){
        
        $query = "SELECT 
                    email_address, expires_at 
                  FROM 
                    " . $this->table_name . " 
                  WHERE 
                    token = :token LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $this->token = htmlspecialchars(strip_tags($this->token));

        $stmt->bindParam(":token", $this->token);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row;
        }
        
    }

}

?>
