<?php require 'db.php'; $articles = $db->query('SELECT * FROM articles ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC); ?>
<!DOCTYPE html><html><head><title>News Portal</title><link rel="stylesheet" href="style.css"></head><body>
<h1>Latest News</h1>
<?php foreach ($articles as $a): ?>
    <div class="card"><h2><a href="article.php?id=<?= $a['id'] ?>"><?= htmlspecialchars($a['title']) ?></a></h2><small><?= $a['created_at'] ?></small></div>
<?php endforeach; ?>
</body></html>
