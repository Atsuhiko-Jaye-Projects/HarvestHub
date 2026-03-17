<?php

class Town{

    private $conn;
    private $table_name = "towns";
     

    public $id;
    public $town_name;
    public $latitude;
    public $longitude;
    public $created_at;

    
    public function __construct($db){
        $this->conn = $db;
    }

    function getLocation(){

        
    }


}