<?php
session_start();
require_once '../db.php';
require_once '../core/auth.php';
require_once '../helper.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header('Location: index.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$ip       = $_SERVER['REMOTE_ADDR'];

if (empty($username) || empty($password)) {
    $_SESSION['login_error']    = 'กรุณากรอก Username และ Password';
    $_SESSION['login_username'] = $username;
    header('Location: index.php');
    exit;
}

$auth = new Auth($db);

if ($auth->login($username, $password)) {
    logs("Login successful for username: $username from IP: $ip");
    header('Location: ../index.php');
    exit;
}

$error = 'Username หรือ Password ไม่ถูกต้อง';
errorHandling("Login failed for username: $username from IP: $ip Error: $error");
$_SESSION['login_error']    = $error;
$_SESSION['login_username'] = $username;
header('Location: index.php');
exit;