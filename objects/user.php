<?php

class User{

    private $table_name = "users";
    private $conn;

    public $id;
    public $lastname;
    public $firstname;
    public $baranggay;
    public $user_type;
    public $email_address;
    public $contact_number;
    public $password;
    public $rating;
    public $first_time_logged_in;
    public $farm_details_exists;
    public $created;
    public $modified;

    public function __construct($db) {
		$this->conn = $db;
	}

    function create(){

        $query= "INSERT INTO
                    " . $this->table_name . "
                
                SET
                    firstname = :firstname,
                    lastname=:lastname,
                    password = :password,
                    email_address = :email_address,
                    contact_number=:contact_number,
                    farm_details_exists=:farm_details_exists,
                    user_type = :user_type,
                    created = :created";
        
        $stmt=$this->conn->prepare($query);

        //sanitize
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->contact_number=htmlspecialchars(strip_tags($this->contact_number));
        $this->email_address=htmlspecialchars(strip_tags($this->email_address));
        $this->farm_details_exists=htmlspecialchars(strip_tags($this->farm_details_exists));
        $this->user_type=htmlspecialchars(strip_tags($this->user_type));

        $this->created=date('Y-m-d H:i:s');
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":password", $password_hash);
        $stmt->bindParam(":contact_number", $this->contact_number);
        $stmt->bindParam(":email_address", $this->email_address);
        $stmt->bindParam(":farm_details_exists", $this->farm_details_exists);
        $stmt->bindParam(":user_type", $this->user_type);
        $stmt->bindParam(":created", $this->created);

        if ($stmt->execute()) {
            return true;
            var_dump($stmt);
        }else{
            $this->showError($stmt);
            return false;
            var_dump($stmt);
        }
    }

    public function showError($stmt){
        echo "<pre>";
            print_r($stmt->errorInfo());
        echo "</pre>";
    }

    function credentialExists(){

        $query = "SELECT id, firstname, baranggay, address, user_type, password, first_time_logged_in, farm_details_exists, contact_number, lastname
                FROM " . $this->table_name . "
                WHERE email_address=:email_address
                LIMIT 0, 1";
        
        $stmt = $this->conn->prepare($query);

        $this->email_address=htmlspecialchars(strip_tags($this->email_address));

        $stmt->bindParam(":email_address", $this->email_address);

        $stmt->execute();
        
        $num = $stmt->rowCount();

        if ($num>0) {
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->baranggay = $row['baranggay'];
            $this->address = $row['address'];
            $this->user_type = $row['user_type'];
            $this->password = $row['password'];
            $this->first_time_logged_in = $row['first_time_logged_in'];
            $this->farm_details_exists = $row['farm_details_exists'];

            return true;
        }
        return false;
    }

    function markFarmAsExists(){

        $query = "UPDATE
                " . $this->table_name . "
                SET
                farm_details_exists = :farm_details_exists
                WHERE id = :id";
        
        $stmt=$this->conn->prepare($query);

        $stmt->bindParam(":farm_details_exists", $this->farm_details_exists);
        $stmt->bindParam(":id", $this->user_id);

        $stmt->execute();
    }

    function emailExists(){
        $query = "SELECT id FROM
                ". $this->table_name ."
                WHERE email_address = ?  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);

        $this->email_address = htmlspecialchars(strip_tags($this->email_address));


        $stmt->BindParam(1, $this->email_address);


        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }

    function contactExists(){
        $query = "SELECT id FROM
                ". $this->table_name ."
                WHERE contact_number = ? LIMIT 1";
        
        $stmt = $this->conn->prepare($query);

        $this->contact_number = htmlspecialchars(strip_tags($this->contact_number));

        $stmt->BindParam(1, $this->contact_number);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }
        return false;
    }



}

?>
