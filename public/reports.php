<?php
session_start();
require_once '../src/controllers/InventoryManager.php';

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: signin.php');
    exit();
}

$inventoryManager = new InventoryManager();
$items = $inventoryManager->listItems();

// Calculate total value of inventory and total items in stock
$totalValue = 0;
$totalItems = 0;

foreach ($items as $item) {
    $totalValue += $item['quantity'] * $item['price'];
    $totalItems += $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Inventory Report - Local Business Inventory System">
    <title>Inventory Report</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
        }

        .container {
            margin-top: 20px;
        }

        .report-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        .report-section {
            margin-bottom: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2e3b55;
            color: #fff;
        }

        td {
            background-color: #fff;
        }

        .summary {
            font-size: 18px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="report-title">Inventory Report</h1>

        <!-- Summary Section -->
        <div class="report-section">
            <h3>Summary</h3>
            <p class="summary">Total Items in Stock: <strong><?= $totalItems ?></strong></p>
            <p class="summary">Total Value of Inventory: <strong>$<?= number_format($totalValue, 2) ?></strong></p>
        </div>

        <!-- Detailed Report Table -->
        <div class="report-section">
            <h3>Detailed Inventory Report</h3>
            <table>
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price per Unit ($)</th>
                        <th>Total Value ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= $item['item_name'] ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td><?= number_format($item['price'], 2) ?></td>
                                <td><?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No inventory items found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
