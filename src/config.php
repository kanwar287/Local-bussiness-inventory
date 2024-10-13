<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'local_inventory';
    private $username = 'root';  // Change as needed
    private $password = '';      // Change as needed
    public $conn;

    // Database connection
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
