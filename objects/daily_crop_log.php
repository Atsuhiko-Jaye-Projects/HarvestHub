<?php

class FarmCropLog{

    private $conn;
    private $table_name = "daily_crop_logs";

    public $daily_log_id;
    public $crop_id;
    public $user_id;
    public $log_date;
    public $health_status;
    public $activities;
    public $photo_path;
    public $temperature;
    public $humidity;
    public $weather_conditions;
    public $location;
    public $remarks;
    public $precipitation;
    public $precipitation_prob;


    public function __construct($db) {
	    $this->conn = $db;
	}

    public function uploadPhoto($file, $user_id, $crop_id) {

        if (empty($file['name']) || empty($file['tmp_name'])) {
            return null;
        }

        // ✅ CORRECT BASE DIRECTORY
        $uploadDir = __DIR__ . "/../user/uploads/daily_logs/{$user_id}/{$crop_id}/";

        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                error_log("FAILED TO CREATE DIR: $uploadDir");
                return null;
            }
        }

        if (!is_writable($uploadDir)) {
            error_log("DIR NOT WRITABLE: $uploadDir");
            return null;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $fileName = time() . "_crop_" . $crop_id . "." . $ext;
        $targetPath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            error_log("MOVE FAILED: {$file['tmp_name']} → {$targetPath}");
            return null;
        }

        return $fileName;
    }



    function save() {

        $query = "INSERT INTO " . $this->table_name . "
            SET
                user_id = :user_id,
                crop_id = :crop_id,
                log_date = :log_date,
                health_status = :health_status,
                activities = :activities,
                temperature = :temperature,
                humidity = :humidity,
                remarks = :remarks,
                weather_conditions = :weather_conditions,
                precipitation = :precipitation,
                precip_prob = :precip_prob,
                location = :location,
                photo = :photo";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(":crop_id", $this->crop_id, PDO::PARAM_INT);
        $stmt->bindParam(":log_date", $this->log_date);
        $stmt->bindParam(":health_status", $this->health_status);
        $stmt->bindParam(":activities", $this->activities);
        $stmt->bindParam(":temperature", $this->temperature);
        $stmt->bindParam(":remarks", $this->remarks);
        $stmt->bindParam(":humidity", $this->humidity);
        $stmt->bindParam(":weather_conditions", $this->weather_conditions);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":photo", $this->photo_path);
        $stmt->bindParam(":precip_prob", $this->precipitation_prob);
        $stmt->bindParam(":precipitation", $this->precipitation);

        return $stmt->execute();
    }

    function cropLoggedToday() {
        $query = "SELECT 1
                FROM ".$this->table_name ."
                WHERE user_id = :user_id
                    AND crop_id = :crop_id
                    AND log_date = :log_date
                LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(':crop_id', $this->crop_id, PDO::PARAM_INT);
        $stmt->bindParam(':log_date', $this->log_date);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    function allCropLogged(){
        $query = "SELECT COUNT(crop_id) AS total
                FROM " . $this->table_name . "
                WHERE user_id = :user_id
                    AND log_date = :log_date
                    AND remarks = 'Logged'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $this->user_id, PDO::PARAM_INT);
        $stmt->bindParam(":log_date", $this->log_date);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    function getCropHealthScore(){
        $query = "
            SELECT ROUND(
                AVG(
                    CASE health_status
                        WHEN 'Healthy' THEN 5
                        WHEN 'Stressed' THEN 3
                        WHEN 'Diseased' THEN 1
                    END
                ), 1
            ) AS health_score
            FROM daily_crop_log
            WHERE user_id = :user_id
            AND log_date = :log_date
            AND remarks = 'Logged'
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':log_date', $this->log_date);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $healthScore = $row['health_score'] ?? 0;
    }


    function getCropLogWithSeason() {
        // 1️⃣ Fetch all logs for this crop
        $query = "SELECT * 
                FROM " . $this->table_name . "
                WHERE crop_id = :crop_id
                ORDER BY log_date ASC"; // get all logs, not just 1

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":crop_id", $this->crop_id, PDO::PARAM_INT);
        $stmt->execute();

        $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$logs) return null; // No logs found

        // 2️⃣ Compute rainy days and averages
        $rainyDays = 0;
        $totalDays = count($logs);
        $totalPrecip = 0;
        $totalProb = 0;

        foreach ($logs as $log) {
            $totalPrecip += $log['precipitation'];
            $totalProb += $log['precip_prob'];

            // Count rainy day
            $isRainy = ($log['precipitation'] >= 0.5 || $log['precip_prob'] >= 50
                        || preg_match('/rain|showers|thunderstorm/i', $log['weather_conditions']));
            if ($isRainy) $rainyDays++;
        }

        $avgPrecip = $totalPrecip / $totalDays;
        $avgProb = $totalProb / $totalDays;
        $rainyRatio = $rainyDays / $totalDays;

        // 3️⃣ Determine best season
        if ($rainyRatio >= 0.4) { // 40% or more rainy days
            $season = "Rainy Season";
        } else {
            $season = "Dry Season";
        }

        // 4️⃣ Return logs + computed season
        return [
            'logs' => $logs,
            'total_days' => $totalDays,
            'rainy_days' => $rainyDays,
            'avg_precip' => round($avgPrecip, 2),
            'avg_prob' => round($avgProb, 2),
            'rainy_ratio' => round($rainyRatio, 2),
            'best_season' => $season
        ];

        
    }





}