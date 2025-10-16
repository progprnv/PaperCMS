<?php
require_once __DIR__ . '/config/config.php';

// Redirect to appropriate dashboard if logged in
if (is_logged_in()) {
    if ($_SESSION['role'] === 'author') {
        header('Location: author/dashboard.php');
    } elseif ($_SESSION['role'] === 'reviewer' || $_SESSION['role'] === 'admin') {
        header('Location: reviewer/dashboard.php');
    }
    exit();
}

// Redirect to login page
header('Location: auth/login.php');
exit();
?>
