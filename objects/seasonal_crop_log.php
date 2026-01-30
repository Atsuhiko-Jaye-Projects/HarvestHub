<?php

class SeasonalCropLog{

    private $conn;
    private $table_name = "seasonal_crops";

    public $id;
    public $crop_name;
    public $best_season;
    public $avg_precip;
    public $current_season;
    public $created;
    public $modified;

    public function __construct($db){
        $this->conn = $db;
    }

    function saveSeasonalCrop(){

        $query = "INSERT INTO
                  " . $this->table_name . "
                  SET
                    crop_name = :crop_name,
                    best_season =:best_season,
                    avg_precip =:avg_precip,
                    created = :created";

        $stmt = $this->conn->prepare($query);

        $this->created = date("Y-m-d H:i:s");
        
        $stmt->bindParam(":crop_name", $this->crop_name);
        $stmt->bindParam(":best_season", $this->best_season);
        $stmt->bindParam(":avg_precip", $this->avg_precip);
        $stmt->bindParam(":created", $this->created);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function getSeasonalCrops(){
        $query = "SELECT *
                FROM ". $this->table_name ."
                WHERE best_season = :current_season
                GROUP BY crop_name
                ORDER BY avg_precip DESC LIMIT 5";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':current_season', $this->current_season);
        $stmt->execute();

        return $stmt;

    }
}