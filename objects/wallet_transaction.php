<?php

class walletTransaction{

    private $conn;
    private $table_name = "wallet_transactions";

    public $id;
    public $user_id;
    public $amount;
    public $currency;
    public $wallet_id;
    public $type;
    public $reference_number;
    public $status;
    public $description;
    public $paymongo_link;
    public $modified_at;
    public $created_at;
    public $paymongo_link_id;

    public function __construct($db){
        $this->conn = $db;
    }
    
    function createTransaction(){
        $query = "INSERT INTO " . $this->table_name . "
                SET 
                    wallet_id = :wallet_id,
                    type = :type,
                    description = :description,
                    reference_number = :reference_number,
                    paymongo_link_id = :paymongo_link_id,
                    paymongo_link = :paymongo_link,
                    amount = :amount,
                    status = 'unpaid',
                    created_at = :created_at";

        $stmt = $this->conn->prepare($query);

        $this->created_at = date("Y-m-d H:i:s");

        $stmt->bindParam(":wallet_id", $this->wallet_id);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":reference_number", $this->reference_number);
        $stmt->bindParam(":paymongo_link_id", $this->paymongo_link_id);
        $stmt->bindParam(":paymongo_link", $this->paymongo_link);
        $stmt->bindParam(":amount", $this->amount);
        $stmt->bindParam(":created_at", $this->created_at);

        if ($stmt->execute()) {
            return true;
        }

        return false;

    }

function getLatestReferenceNo(){

    $query = "SELECT
                reference_number,
                paymongo_link_id
              FROM " . $this->table_name . "
              WHERE wallet_id = :wallet_id 
              AND status = 'unpaid'
              LIMIT 0,1";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(":wallet_id", $this->wallet_id);

    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if($row){
        $this->reference_number = $row['reference_number'];
        $this->paymongo_link_id = $row['paymongo_link_id'];
    } else {
        $this->reference_number = "";
        $this->paymongo_link_id = "";
    }
}
}

?>

