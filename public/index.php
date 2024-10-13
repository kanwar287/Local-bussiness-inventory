<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: signin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Local Inventory Management</title>

    <!-- Google Fonts and Bootstrap CDN -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            display: flex;
        }

        .sidebar {
            background-color: #343a40;
            width: 250px;
            min-height: 100vh;
            padding-top: 20px;
            position: fixed;
        }

        .sidebar a {
            color: white;
            padding: 15px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .sidebar a:hover {
            background-color: #ffc107;
            color: white;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
        }

        .card {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- Vertical Sidebar -->
<div class="sidebar">
    <a href="home.php">Dashboard</a>
    <a href="inventoryControl.php">Inventory</a>
    <a href="reports.php">Reports</a>
    <a href="signout.php">Logout</a>
</div>

<!-- Content -->
<div class="content">
    <h2>Welcome to the Local Inventory Management System</h2>
    <p>Manage your local business inventory, generate reports, and track items efficiently.</p>

    <!-- Cards for Navigation -->
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Manage Inventory</h5>
                    <a href="inventoryControl.php" class="btn btn-primary">View Inventory</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Reports</h5>
                    <a href="reports.php" class="btn btn-primary">View Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
