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
        
        $this->created=date('Y-m-d H:i:s');

        $query= "INSERT INTO
                    " . $this->table_name . "
                
                SET
                    contact_number = :contact_number,
                    firstname = :firstname,
                    lastname = :lastname,
                    baranggay = :baranggay,
                    user_type = :user_type,
                    created = :created";
        
        $stmt=$this->conn->prepare($query);

        //sanitize
        $this->contact_number=htmlspecialchars(strip_tags($this->contact_number));
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->baranggay=htmlspecialchars(strip_tags($this->baranggay));
        $this->user_type=htmlspecialchars(strip_tags($this->user_type));

        $stmt->bindParam(":contact_number", $this->contact_number);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":baranggay", $this->baranggay);
        $stmt->bindParam(":user_type", $this->user_type);
        $stmt->bindParam(":created", $this->created);

        if ($stmt->execute()) {
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }
    }

    public function showError($stmt){
        echo "<pre>";
            print_r($stmt->errorInfo());
        echo "</pre>";
    }

    function credentialExists(){

        $query = "SELECT id, firstname, baranggay, address, user_type, email_address, password, first_time_logged_in, farm_details_exists
                FROM " . $this->table_name . "
                WHERE contact_number = ? AND lastname = ?
                LIMIT 0, 1";
        
        $stmt = $this->conn->prepare($query);

        $this->contact_number=htmlspecialchars(strip_tags($this->contact_number));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));

        $stmt->bindParam(1, $this->contact_number);
        $stmt->bindParam(2, $this->lastname);

        $stmt->execute();
        
        $num = $stmt->rowCount();

        if ($num>0) {
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->firstname = $row['firstname'];
            $this->baranggay = $row['baranggay'];
            $this->address = $row['address'];
            $this->user_type = $row['user_type'];
            $this->email_address = $row['email_address'];
            $this->password = $row['password'];
            $this->first_time_logged_in = $row['first_time_logged_in'];
            $this->farm_details_exists = $row['farm_details_exists'];

            return true;
        }
        return false;
    }

}

?>
