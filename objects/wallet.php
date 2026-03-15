<?php

class Wallet{

    private $conn;
    private $table_name = "wallets";

    public $id;
    public $user_id;
    public $balance;
    public $wallet_id;
    public $currency;
    public $modified_at;
    public $created_at;

    public function __construct($db){
        $this->conn = $db;
    }

    function generateWalletID($length = 8){
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $wallet_address = '';

        for ($i = 0; $i < $length; $i++) {
            $wallet_address .= $characters[rand(0, strlen($characters) - 1)];
        }

        return "WLT-" . $wallet_address;
    }

    function createWallet(){

        $wallet_address = $this->generateWalletID();

        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    wallet_id = :wallet_id,
                    user_id = :user_id,
                    balance = :balance";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":wallet_id", $wallet_address);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":balance", $this->balance);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }



    function VerifyWallet() {

        $query = "SELECT COUNT(id) AS total
                FROM " . $this->table_name . " 
                WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row['total'] > 0){
            return true;
        }else{
            return false;
        }
    }

    function getWalletBalance(){
        $query = "SELECT 
                id, balance, wallet_id
                FROM " . $this->table_name . " 
                WHERE user_id = :user_id
                LIMIT 1";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameter
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->balance = $row['balance'];
        $this->wallet_id = $row['wallet_id'];

    }



}


?>