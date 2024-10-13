<?php
session_start();
require_once '../src/controllers/UserManager.php';

// Check if the request method is POST (Form Submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        $_SESSION['error_message'] = "Passwords do not match!";
        header('Location: register.php');
        exit();
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Create an instance of UserManager
    $userManager = new UserManager();

    // Check if the user exists
    if ($userManager->userExists($username, $email)) {
        $_SESSION['error_message'] = "Username or Email already exists!";
        header('Location: register.php');
        exit();
    }

    // Add the user
    $registrationSuccess = $userManager->registerUser($username, $email, $hashedPassword);

    // Check if registration was successful
    if ($registrationSuccess) {
        $_SESSION['success_message'] = "Registration successful! You can now log in.";
        header('Location: signin.php');
    } else {
        $_SESSION['error_message'] = "Error in registration. Please try again.";
        header('Location: signup.php');
    }
}
