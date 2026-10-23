<?php require 'db.php'; $id = (int)$_GET['id']; $stmt = $db->prepare('SELECT * FROM articles WHERE id = ?'); $stmt->execute([$id]); $a = $stmt->fetch(PDO::FETCH_ASSOC); if(!$a) die('Not found'); ?>
<!DOCTYPE html><html><head><title><?= htmlspecialchars($a['title']) ?></title><link rel="stylesheet" href="style.css"></head><body>
<a href="index.php">&larr; Back</a>
<h1><?= htmlspecialchars($a['title']) ?></h1>
<small><?= $a['created_at'] ?></small>
<article><?= nl2br(htmlspecialchars($a['content'])) ?></article>
</body></html>
