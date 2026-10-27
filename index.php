<?php
require 'db.php';
$q = $_GET['q'] ?? '';
$sql = 'SELECT * FROM articles';
$params = [];
if ($q) {
    $sql .= ' WHERE title LIKE ? OR content LIKE ?';
    $params = ["%$q%", "%$q%"];
}
$sql .= ' ORDER BY id DESC';
$stmt = $db->prepare($sql);
$stmt->execute($params);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html><head><title>News Portal</title><link rel="stylesheet" href="style.css"></head><body>
<h1>Latest News</h1>
<form method="GET" style="margin-bottom:20px;">
    <input name="q" placeholder="Search..." value="<?= htmlspecialchars($q) ?>" style="padding:10px;width:70%;box-sizing:border-box;">
    <button type="submit" style="padding:10px 20px;background:#000;color:#fff;border:none;">Search</button>
</form>
<?php foreach ($articles as $a): ?>
    <div class="card"><h2><a href="article.php?id=<?= $a['id'] ?>"><?= htmlspecialchars($a['title']) ?></a></h2><small><?= $a['created_at'] ?></small></div>
<?php endforeach; ?>
</body></html>
