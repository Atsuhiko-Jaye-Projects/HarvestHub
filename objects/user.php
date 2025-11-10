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
    public $profile_pic;
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

    function getFarmerProfileById(){
        $query = "SELECT
                firstname,
                lastname,
                address,
                barangay,
                email_address,
                contact_number,
                municipality,
                province FROM " . $this->table_name . "
                WHERE 
                id=:id LIMIT 0, 1";
        
        $stmt = $this->conn->prepare($query);

        $this->id = (int) $this->id;
        
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        $stmt->execute();

        $row =  $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->address = $row['address'];
            $this->email_address = $row['email_address'];
            $this->contact_number = $row['contact_number'];
            $this->barangay = $row['barangay'];
            $this->municipality = $row['municipality'];
            $this->province = $row['province'];
            return true;
        }
        return false;

    }

    function updateFarmerProfile(){
        $query = "UPDATE " . $this->table_name . "
                    SET
                    firstname=:firstname,
                    lastname=:lastname,
                    profile_pic = :profile_pic,
                    address=:address,
                    municipality=:municipality,
                    barangay=:barangay,
                    province=:province,
                    modified=:modified
                    WHERE id=:id";

        $stmt=$this->conn->prepare($query);
        
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->profile_pic=htmlspecialchars(strip_tags($this->profile_pic));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->municipality=htmlspecialchars(strip_tags($this->municipality));
        $this->barangay=htmlspecialchars(strip_tags($this->barangay));
        $this->province=htmlspecialchars(strip_tags($this->province));
        $this->modified=date('Y-m-d H:i:s');
        
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":profile_pic", $this->profile_pic);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":municipality", $this->municipality);
        $stmt->bindParam(":barangay", $this->barangay);
        $stmt->bindParam(":province", $this->province);
        $stmt->bindParam(":modified", $this->modified);

        if ($stmt->execute()) {
            return true;
        }else{
            return false;
        }

    }

    function uploadPhoto() {
        $result_message = "";

        $check = getimagesize($_FILES["product_image"]["tmp_name"]);
        if($check!==false){
            // submitted file is an image
        }else{
            $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
        }

        if ($this->product_image) {
            $user_id = $this->user_id; // Assuming this is set from the session or earlier
            $target_directory = "../../uploads/{$user_id}/products/";
            $file_name = basename($this->product_image);
            $target_file = $target_directory . $file_name;
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

            $file_upload_error_messages = "";

            // Validate image file
            $check = getimagesize($_FILES["product_image"]["tmp_name"]);
            if ($check === false) {
                $file_upload_error_messages .= "<div>Submitted file is not an image.</div>";
            }

            // Allowed file types
            $allowed_file_types = array("jpg", "jpeg", "png", "gif");
            if (!in_array(strtolower($file_type), $allowed_file_types)) {
                $file_upload_error_messages .= "<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
            }

            // File exists check
            if (file_exists($target_file)) {
                $file_upload_error_messages .= "<div>Image already exists. Try to change file name.</div>";
            }

            // File size check (max 1MB)
            if ($_FILES['product_image']['size'] > 1024000) {
                $file_upload_error_messages .= "<div>Image must be less than 1 MB in size.</div>";
            }

            // Ensure the upload folder exists
            if (!is_dir($target_directory)) {
                mkdir($target_directory, 0777, true);
            }

            // If no errors, attempt to move file
            if (empty($file_upload_error_messages)) {
                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
                } else {
                    $result_message = "<div>Unable to upload image.</div>";
                }
            } else {
                $result_message = "<div class='alert alert-danger'>{$file_upload_error_messages}</div>";
            }
        }
    }





}

?>
