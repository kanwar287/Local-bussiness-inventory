<?php
session_start();
require_once '../src/controllers/InventoryManager.php';

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: signin.php');
    exit();
}

// Create an instance of the InventoryManager
$inventoryManager = new InventoryManager();

// Fetch all inventory items
$items = $inventoryManager->listItems();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'addItem') {
            $inventoryManager->addItem($_POST['name'], $_POST['quantity'], $_POST['price']);
            $_SESSION['message'] = "Item added successfully!";
            header('Location: inventoryControl.php');
            exit();
        } elseif ($_POST['action'] == 'editItem') {
            $inventoryManager->editItem($_POST['id'], $_POST['name'], $_POST['quantity'], $_POST['price']);
            $_SESSION['message'] = "Item updated successfully!";
            header('Location: inventoryControl.php');
            exit();
        } elseif ($_POST['action'] == 'deleteItem') {
            $inventoryManager->deleteItem($_POST['id']);
            $_SESSION['message'] = "Item deleted successfully!";
            header('Location: inventoryControl.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory - Local Inventory System</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Inline CSS for Modern Design -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #1f1f1f;
            color: white;
            margin: 0;
            padding: 0;
        }

        /* Vertical Navigation Bar */
        .nav-bar {
            height: 100vh;
            width: 220px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #272727;
            padding-top: 20px;
        }

        .nav-bar a {
            padding: 12px 24px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .nav-bar a:hover {
            background-color: #03a9f4;
        }

        .content {
            margin-left: 240px;
            padding: 20px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #03a9f4;
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0288d1;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #03a9f4;
            padding: 12px;
        }

        th {
            background-color: #03a9f4;
            color: white;
        }

        td {
            color: white;
        }

        .alert {
            background-color: #4caf50;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-error {
            background-color: #f44336;
        }
    </style>
</head>
<body>

    <!-- Vertical Navigation -->
    <div class="nav-bar">
        <a href="index.php">Dashboard</a>
        <a href="inventoryControl.php" class="active">Manage Inventory</a>
        <a href="reports.php">Reports</a>
        <a href="signout.php">Logout</a>
    </div>

    <div class="content">
        <h1>Manage Inventory</h1>

        <!-- Display Action Messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert">
                <?= $_SESSION['message'] ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <!-- Add New Inventory Form -->
        <h3>Add New Item</h3>
        <form action="inventoryControl.php" method="POST">
            <input type="hidden" name="action" value="addItem">
            <div class="mb-3">
                <label for="name">Item Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="quantity">Quantity</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="price">Price</label>
                <input type="text" name="price" class="form-control" required>
            </div>
            <button type="submit" class="btn">Add Item</button>
        </form>

        <!-- Inventory List -->
        <h3>Inventory List</h3>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($items)): ?>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= $item['item_name'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>$<?= $item['price'] ?></td>
                            <td>
                                <form action="inventoryControl.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="deleteItem">
                                    <input type="hidden" name="id" value="<?= $item['item_id'] ?>">
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                                <button class="btn btn-warning" onclick="editItem('<?= $item['item_id'] ?>', '<?= $item['item_name'] ?>', '<?= $item['quantity'] ?>', '<?= $item['price'] ?>')">Edit</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No items found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Edit Item Form (Hidden by Default) -->
        <div id="editForm" style="display:none;">
            <h3>Edit Item</h3>
            <form action="inventoryControl.php" method="POST">
                <input type="hidden" name="action" value="editItem">
                <input type="hidden" name="id" id="editItemId">
                <div class="mb-3">
                    <label for="name">Item Name</label>
                    <input type="text" id="editItemName" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="editItemQuantity" name="quantity" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="price">Price</label>
                    <input type="text" id="editItemPrice" name="price" class="form-control" required>
                </div>
                <button type="submit" class="btn">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Inline JavaScript for Edit Functionality -->
    <script>
        function editItem(id, name, quantity, price) {
            document.getElementById('editForm').style.display = 'block';
            document.getElementById('editItemId').value = id;
            document.getElementById('editItemName').value = name;
            document.getElementById('editItemQuantity').value = quantity;
            document.getElementById('editItemPrice').value = price;
        }
    </script>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
