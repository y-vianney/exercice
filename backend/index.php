<?php
    // Connection to database
    require_once 'db.php';

    // Start session
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    // Check if user is an admin
    if (!isset($_SESSION['admin'])) {
        header('Location: login.php');
        exit();
    }

    // Redirect to dashboard
    header('Location: dashboard.php');
?>