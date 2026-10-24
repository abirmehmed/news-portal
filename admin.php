<?php
require "auth.php";
require 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare('INSERT INTO articles (title, content) VALUES (?, ?)');
    $stmt->execute([$_POST['title'], $_POST['content']]);
    header('Location: index.php'); exit;
}
?>
<!DOCTYPE html><html><head><title>Admin</title><link rel="stylesheet" href="style.css"></head><body>
<h1>Publish News</h1>
<form method="POST">
    <input name="title" placeholder="Title" required style="width:100%;padding:10px;margin-bottom:10px;">
    <textarea name="content" placeholder="Content" required style="width:100%;height:200px;padding:10px;"></textarea>
    <button type="submit" style="padding:10px 20px;background:#000;color:#fff;border:none;">Publish</button>
</form>
</body></html>
