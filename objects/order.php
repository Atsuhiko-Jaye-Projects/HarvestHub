<?php

class Order{
    
    private $conn;
    private $table_name = "orders";

    public $id;
    public $product_id;
    public $invoice_number;
    public $customer_id;
    public $farmer_id;
    public $mode_of_payment;
    public $quantity;
    public $status;
    public $review_status;
    public $farmer_rated;
    public $created_at;
    public $reason;
    public $modified_at;

    public function __construct($db){
        $this->conn = $db;
    }

    function readAllOrder($from_record_num, $records_per_page) {
        $query = "SELECT *
                FROM " . $this->table_name . "
                WHERE customer_id=:customer_id
                ORDER BY id DESC
                LIMIT {$from_record_num}, {$records_per_page}";


        $stmt = $this->conn->prepare($query);

        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));

        $stmt->bindParam(":customer_id", $this->customer_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    // display orders to farmers order Page
    function readOrders($from_record_num, $records_per_page) {
        $query = "SELECT *
                FROM " . $this->table_name . "
                WHERE farmer_id =:farmer_id
                ORDER BY id DESC
                LIMIT {$from_record_num}, {$records_per_page}";


        $stmt = $this->conn->prepare($query);

        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));

        $stmt->bindParam(":farmer_id", $this->farmer_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    public function countAll(){

        $query = "SELECT customer_id FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }

    function placeOrder(){
        $query = "INSERT INTO
                ". $this->table_name ."
                SET
                product_id = :product_id,
                invoice_number = :invoice_number,
                customer_id = :customer_id,
                mode_of_payment = :mode_of_payment,
                quantity = :quantity,
                status = :status,
                farmer_id = :farmer_id,
                product_type=:product_type,
                created_at =:created_at";

        $stmt = $this->conn->prepare($query);

        $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        $this->invoice_number= htmlspecialchars(strip_tags($this->invoice_number));
        $this->customer_id = htmlspecialchars(strip_tags($this->customer_id));
        $this->mode_of_payment=htmlspecialchars(strip_tags($this->mode_of_payment));
        $this->quantity=htmlspecialchars(strip_tags($this->quantity));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->farmer_id=htmlspecialchars(strip_tags($this->farmer_id));
        $this->product_type=htmlspecialchars(strip_tags($this->product_type));
        $this->created_at=htmlspecialchars(strip_tags($this->created_at));

        $stmt->bindParam(":product_id", $this->product_id);
        $stmt->bindParam(":invoice_number", $this->invoice_number);
        $stmt->bindParam(":customer_id", $this->customer_id);
        $stmt->bindParam(":mode_of_payment", $this->mode_of_payment);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->bindParam(":product_type", $this->product_type);
        $stmt->bindParam(":created_at", $this->created_at);
        
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function readOrderDetails(){
        $query = "SELECT 
                id,
                product_id,
                invoice_number,
                mode_of_payment,
                quantity,
                created_at,
                customer_id,
                status,
                reason
                FROM " . $this->table_name . "
                where id = :id
                LIMIT
                0,1";
        $stmt=$this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":id", $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->product_id = $row['product_id'];
        $this->invoice_number = $row['invoice_number'];
        $this->mode_of_payment = $row['mode_of_payment'];
        $this->quantity = $row['quantity'];
        $this->created_at = $row['created_at'];
        $this->customer_id = $row['customer_id']; 
        $this->status = $row['status'];  
        $this->reason = $row['reason'];


    }

    function readOneOrder(){
        
        $query = "SELECT
                    product_id,
                    invoice_number,
                    customer_id,
                    mode_of_payment,
                    status,
                    quantity,
                    created_at,
                    farmer_id
                FROM
                    " . $this->table_name . "
                WHERE id = :id
                LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->product_id = $row['product_id'];
        $this->invoice_number = $row['invoice_number'];
        $this->mode_of_payment = $row['mode_of_payment'];
        $this->customer_id = $row['customer_id'];
        $this->status = $row['status'];
        $this->quantity = $row['quantity'];
        $this->created_at = $row['created_at'];
        $this->farmer_id = $row['farmer_id'];
    }

    function processOrder(){

        $query = "UPDATE " . $this->table_name . "
                SET status = :status
                WHERE id = :id";


        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function completeOrder(){
        $query = "UPDATE " . $this->table_name . "
                SET 
                    available_stocks = available_stocks - :quantity,
                    sold_count = sold_count + :quantity
                WHERE 
                    product_id = :product_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":quantity", $this->available_stocks);
        $stmt->bindParam(":sold_count", $this->sold_count);
        $stmt->bindParam(":product_id", $this->product_id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function countPendingOrder(){
        $query = "SELECT COUNT(*) as pending_order
                  FROM " . $this->table_name . "
                  WHERE farmer_id = :farmer_id AND status='order placed'";
        
        $stmt=$this->conn->prepare($query);

        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['pending_order'] ?? 0;
    }

    function countCompletedOrder(){
        $query = "SELECT COUNT(*) as completed_order
                FROM " . $this->table_name . "
                WHERE farmer_id = :farmer_id 
                AND (status = 'order confirmed' OR status = 'complete')";

        
        $stmt=$this->conn->prepare($query);

        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['completed_order'] ?? 0;
    }

    // get the completed order to display the sales
    function totalSales() {
        $query = "SELECT SUM(o.quantity * p.price_per_unit) AS total_sales, o.modified_at AS date_sales
                FROM " . $this->table_name . " o
                JOIN products p ON o.product_id = p.product_id
                WHERE o.farmer_id = :farmer_id
                AND o.status = 'complete'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_sales'] ?? 0;
    }

    public function totalGraphSales() {

        $query = "
            SELECT DATE(modified_at) AS date_sales, SUM(o.quantity * p.price_per_unit) AS total_sales
            FROM orders o
            JOIN products p ON o.product_id = p.product_id
            WHERE o.farmer_id = :farmer_id
            AND o.status = 'complete'
            AND modified_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) -- last 7 days
            GROUP BY DATE(modified_at)
            ORDER BY DATE(modified_at)
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->execute();

        // Fetch all rows as array
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Ensure we return an array of rows, each with total_sales and date_sales
        return $rows;
    }

    public function totalGraphSalesMonthly() {
        $query = "
            SELECT 
                DATE_FORMAT(modified_at, '%Y-%m') AS month_sales, 
                SUM(o.quantity * p.price_per_unit) AS total_sales
            FROM orders o
            JOIN products p ON o.product_id = p.product_id
            WHERE o.farmer_id = :farmer_id
            AND o.status = 'complete'
            AND modified_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) -- last 6 months
            GROUP BY DATE_FORMAT(modified_at, '%Y-%m')
            ORDER BY DATE_FORMAT(modified_at, '%Y-%m')
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }

    public function totalGraphSalesAnnually() {
        $query = "
            SELECT 
                DATE_FORMAT(modified_at, '%Y-01-01') AS date_sales, 
                SUM(o.quantity * p.price_per_unit) AS total_sales
            FROM orders o
            JOIN products p ON o.product_id = p.product_id
            WHERE o.farmer_id = :farmer_id
            AND o.status = 'complete'
            AND modified_at >= DATE_SUB(CURDATE(), INTERVAL 5 YEAR) -- last 5 years
            GROUP BY YEAR(modified_at)
            ORDER BY YEAR(modified_at)
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows;
    }





    function getOrderNotification() {

        $query = "SELECT 
                    o.customer_id,
                    o.product_id,
                    o.quantity,
                    o.status,
                    o.created_at,
                    o.invoice_number,

                    c.lastname, c.firstname AS customer_name,
                    c.contact_number AS customer_contact,

                    p.product_name,
                    p.available_stocks,
                    p.price_per_unit

                FROM " . $this->table_name . " o

                LEFT JOIN users c 
                ON o.customer_id = c.id

                LEFT JOIN products p 
                ON o.product_id = p.product_id

                WHERE 
                    o.farmer_id = :farmer_id AND o.status='order placed' OR  o.status='order cancelled'
                    GROUP BY o.id ASC
                    ORDER BY o.id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function orderReviewStatus() {
        $query = "SELECT *
                    FROM " . $this->table_name . "
                    WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->review_status = $row['review_status'];
        $this->product_id = $row['product_id'];
        $this->farmer_id = $row['farmer_id'];
        $this->farmer_rated = $row['farmer_rated'];
        //$this->customer_id = $row['customer_id'];
    }

    function markReviewStatus(){
        $query = "UPDATE
                " . $this->table_name . "
                SET
                review_status = :review_status
                WHERE 
                id = :id";
        $stmt=$this->conn->prepare($query);

        $this->review_status=htmlspecialchars(strip_tags($this->review_status));

        $stmt->bindParam(":review_status", $this->review_status);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    function markFarmReviewStatus(){
        $query = "UPDATE
                " . $this->table_name . "
                SET
                farmer_rated = :farmer_rated
                WHERE 
                id = :id";
        $stmt=$this->conn->prepare($query);

        $this->review_status=htmlspecialchars(strip_tags($this->review_status));

        $stmt->bindParam(":farmer_rated", $this->farmer_rated);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }
    
    function cancelOrder(){
        
        $query = "UPDATE 
                " . $this->table_name . "
                SET
                reason = :reason,
                status = :status
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":reason", $this->reason);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    function confirmOrder(){
        
        $query = "UPDATE 
                " . $this->table_name . "
                SET
                status = :status,
                modified_at =:modified_at
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":modified_at", $this->modified_at);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    function recievedPreOrder(){
        
        $query = "UPDATE 
                " . $this->table_name . "
                SET
                status = :status,
                modified_at = :modified_at
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":modified_at", $this->modified_at);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    function acceptOrder(){
        
        $query = "UPDATE
                  " . $this->table_name . "
                  set
                    status = 'accept'
                  WHERE
                    status = 'order placed'
                  AND
                    created_at <= NOW() - interval 30 MINUTE";
        
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function getPendingOrder(){

        $query = "SELECT *
                  FROM
                    " . $this->table_name . "
                   WHERE
                    status = 'order placed' AND created_at <= NOW() - INTERVAL 30 MINUTE";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function getPendingCancelOrder(){

        $query = "SELECT *
                  FROM
                    " . $this->table_name . "
                   WHERE
                    status = 'cancel pending' AND created_at <= NOW() - INTERVAL 5 MINUTE";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function updateCancelledOrder(){
        
        $query = "UPDATE
                  " . $this->table_name . "
                  set
                    status = 'cancelled'
                  WHERE
                    status = 'cancel pending'
                  AND
                    created_at <= NOW() - interval 5 MINUTE";
        
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
    
    function getOrder(){

        $query = "SELECT *
                  FROM
                    " . $this->table_name . "
                   WHERE
                    customer_id = :customer_id AND status != 'cancelled' ";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":customer_id" , $this->customer_id);
        $stmt->execute();

        return $stmt;
    }

    function getTopSoldCropDaily(){

        $query = "SELECT 
                    p.product_name,
                    SUM(o.quantity) AS total_sold,
                    SUM(o.quantity * p.price_per_unit) AS price_sold,
                    DATE_FORMAT(CURDATE(), '%d %b %Y') AS sale_date  -- Display today nicely
                FROM 
                    ". $this->table_name . " o
                JOIN 
                    products p ON o.product_id = p.product_id
                WHERE
                    o.status = 'complete' 
                    AND farmer_id = :farmer_id 
                    AND DATE(o.created_at) = CURDATE()
                GROUP BY 
                    p.product_name
                ORDER BY 
                    total_sold DESC
                LIMIT 10;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->execute();

        return $stmt;
    }


    function getTopSoldCropMonthly(){

        $query = "SELECT 
                    p.product_name,
                    DATE_FORMAT(o.created_at, '%d %b %Y') AS sale_day,  -- Day view
                    SUM(o.quantity) AS total_sold,
                    SUM(o.quantity * p.price_per_unit) AS price_sold
                FROM 
                    ". $this->table_name . " o
                JOIN 
                    products p ON o.product_id = p.product_id
                WHERE
                    o.status = 'complete' 
                    AND farmer_id = :farmer_id 
                    AND MONTH(o.created_at) = MONTH(CURDATE()) 
                    AND YEAR(o.created_at) = YEAR(CURDATE())   
                GROUP BY 
                    p.product_name, DAY(o.created_at)
                ORDER BY 
                    DAY(o.created_at) DESC, total_sold DESC
                LIMIT 10;";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":farmer_id", $this->farmer_id);
        $stmt->execute();

        return $stmt;
    }


    
    function getTopSoldCropAnnually(){

        $query = "SELECT 
                    p.product_name,
                    CONCAT(MONTHNAME(o.created_at), ' ', YEAR(o.created_at)) AS sale_month,
                    SUM(o.quantity) AS total_sold,
                    SUM(o.quantity * p.price_per_unit) AS price_sold
                FROM 
                    ". $this->table_name . " o
                JOIN 
                    products p ON o.product_id = p.product_id
                WHERE
                    o.status = 'complete' 
                    AND farmer_id = :farmer_id 
                    AND o.created_at >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
                GROUP BY 
                    p.product_name, sale_month
                ORDER BY 
                    o.created_at DESC, total_sold DESC
                LIMIT 10;";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":farmer_id", $this->farmer_id);
        
        $stmt->execute();

        return $stmt;
    }







}
?>