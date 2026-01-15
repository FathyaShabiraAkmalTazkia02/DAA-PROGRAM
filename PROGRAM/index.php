<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
} else {
    header("Location: dashboard.php");
    exit;
}
