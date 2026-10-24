<?php
session_start();
$pass = 'news2024';

if (isset($_POST['password']) && $_POST['password'] === $pass) {
    $_SESSION['auth'] = true;
    header('Location: admin.php');
    exit;
}

if (!isset($_SESSION['auth'])) {
    echo '<!DOCTYPE html><html><head><link rel="stylesheet" href="style.css"></head><body>
    <form method="POST" style="max-width:300px;margin:50px auto;text-align:center;">
        <h2>Admin Access</h2>
        <input type="password" name="password" placeholder="Password" required style="width:100%;padding:10px;margin-bottom:10px;box-sizing:border-box;">
        <button type="submit" style="padding:10px 20px;background:#000;color:#fff;border:none;">Login</button>
    </form></body></html>';
    exit;
}
