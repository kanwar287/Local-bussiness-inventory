<?php
session_start();

// Check if the user confirmed the sign out
if (isset($_POST['confirm_signout'])) {
    // Destroy the session and redirect to login page
    session_destroy();
    header('Location: signin.php');
    exit();
}

// If the user cancels, redirect back to the dashboard
if (isset($_POST['cancel_signout'])) {
    header('Location: home.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Out - Event Management System</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .confirmation-box {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .confirmation-box h2 {
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-confirm {
            background-color: #2e3b55;
            color: white;
        }

        .btn-confirm:hover {
            background-color: #ffc107;
        }

        .btn-cancel {
            background-color: #dc3545;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #ff6f61;
        }
    </style>
</head>
<body>

    <div class="confirmation-box">
        <h2>Are you sure you want to sign out?</h2>

        <form method="POST" action="signout.php">
            <button type="submit" name="confirm_signout" class="btn btn-confirm">Yes, Sign Out</button>
            <button type="submit" name="cancel_signout" class="btn btn-cancel">No, Stay</button>
        </form>
    </div>

</body>
</html>
