<?php
require 'db.php';
require 'auth.php';

if (isset($_GET['delete'])) {
    $stmt = $db->prepare('DELETE FROM articles WHERE id = ?');
    $stmt->execute([(int)$_GET['delete']]);
    header('Location: admin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare('INSERT INTO articles (title, content) VALUES (?, ?)');
    $stmt->execute([$_POST['title'], $_POST['content']]);
    header('Location: admin.php');
    exit;
}

$articles = $db->query('SELECT id, title FROM articles ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html><head><title>Admin</title><link rel="stylesheet" href="style.css"></head><body>
<h1>Publish News</h1>
<form method="POST">
    <input name="title" placeholder="Title" required style="width:100%;padding:10px;margin-bottom:10px;box-sizing:border-box;">
    <textarea name="content" placeholder="Content" required style="width:100%;height:200px;padding:10px;box-sizing:border-box;"></textarea>
    <button type="submit" style="padding:10px 20px;background:#000;color:#fff;border:none;">Publish</button>
</form>
<h2>Manage Articles</h2>
<?php foreach ($articles as $a): ?>
    <p><?= htmlspecialchars($a['title']) ?> <a href="?delete=<?= $a['id'] ?>" style="color:red;">[Delete]</a></p>
<?php endforeach; ?>
</body></html>
