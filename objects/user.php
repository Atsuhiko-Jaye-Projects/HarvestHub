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

}

?>
