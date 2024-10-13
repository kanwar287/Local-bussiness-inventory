<?php
session_start();
require_once '../src/controllers/UserManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if username and password are filled
    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = "Please fill in both fields.";
        header('Location: signin.php');
        exit();
    }

    // Create an instance of UserManager
    $userManager = new UserManager();

    // Authenticate user
    $user = $userManager->login($username, $password);

    if ($user) {
        // Login successful, set session variables and redirect
        $_SESSION['user'] = $user['username'];  // Store username in session
        $_SESSION['role'] = $user['role'];      // Store user role (if applicable)
        $_SESSION['success_message'] = "Login successful!";
        header('Location: home.php');
    } else {
        // Login failed, redirect back to login with error message
        $_SESSION['error_message'] = "Invalid username or password.";
        header('Location: signin.php');
    }
} else {
    // If accessed directly, redirect to login page
    header('Location: signin.php');
}
exit();
