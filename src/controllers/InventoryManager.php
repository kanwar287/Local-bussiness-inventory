<?php
require_once '../src/config.php';

class InventoryManager {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // List all inventory items
    public function listItems() {
        $query = "SELECT * FROM inventory";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new inventory item
    public function addItem($name, $quantity, $price) {
        $query = "INSERT INTO inventory (item_name, quantity, price) VALUES (:name, :quantity, :price)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    // Edit an existing inventory item
    public function editItem($id, $name, $quantity, $price) {
        $query = "UPDATE inventory SET item_name = :name, quantity = :quantity, price = :price WHERE item_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }

    // Delete an inventory item
    public function deleteItem($id) {
        $query = "DELETE FROM inventory WHERE item_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
