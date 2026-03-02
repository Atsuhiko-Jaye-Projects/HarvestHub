<?php

class CropProductionDetails{

    private $conn;
    private $table_name = "vegetable_production";

    public $id;
    public $crop_name;
    public $distance_of_planting;
    public $plant_population_per_hill;
    public $plant_population_per_hectare;
    public $production_per_hill;
    public $production_per_hill_unit;
    public $production_per_hectare;
    public $production_per_hectare_unit;
    public $fruit_peak;


    public function __construct($db) {
	    $this->conn = $db;
	}

    function getAverageYield(){

        $query = " SELECT 
                        production_per_hectare,
                        plant_population_per_hectare,
                        (production_per_hectare / plant_population_per_hectare) 
                            AS yield_per_plant
                    FROM " . $this->table_name . "
                    WHERE crop_name = :crop_name
                    LIMIT 1";

        $stmt = $this->conn->prepare($query);

        $this->crop_name=htmlspecialchars(strip_tags($this->crop_name));

        $stmt->bindParam(":crop_name", $this->crop_name);

        $stmt->execute();
        return $stmt;

    }
}
?>