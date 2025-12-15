<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Optional: role check
function checkRole($requiredRole) {
    if ($_SESSION['role'] !== $requiredRole) {
        header("Location: ../auth/login.php");
        exit;
    }
}
