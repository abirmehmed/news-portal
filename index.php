<?php
require 'db.php';
$page = max(1, (int)($_GET['p'] ?? 1));
$per_page = 5;
$offset = ($page - 1) * $per_page;
$cat = $_GET['cat'] ?? '';
$q = $_GET['q'] ?? '';

$where = []; $params = [];
if ($cat) { $where[] = 'category = ?'; $params[] = $cat; }
if ($q) { $where[] = '(title LIKE ? OR content LIKE ?)'; $params[] = "%$q%"; $params[] = "%$q%"; }
$where_sql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

$count_stmt = $db->prepare("SELECT COUNT(*) FROM articles $where_sql");
$count_stmt->execute($params);
$total_pages = ceil($count_stmt->fetchColumn() / $per_page);

$stmt = $db->prepare("SELECT * FROM articles $where_sql ORDER BY id DESC LIMIT $per_page OFFSET $offset");
$stmt->execute($params);
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html><head><title>News</title><link rel="stylesheet" href="style.css"></head><body>
<h1>News Portal</h1>
<form method="GET" style="margin-bottom:20px;">
    <select name="cat" style="padding:10px;"><option value="">All</option><option value="Politics" <?= $cat=='Politics'?'selected':'' ?>>Politics</option><option value="Tech" <?= $cat=='Tech'?'selected':'' ?>>Tech</option><option value="General" <?= $cat=='General'?'selected':'' ?>>General</option></select>
    <input name="q" placeholder="Search..." value="<?= htmlspecialchars($q) ?>" style="padding:10px;">
    <button type="submit" style="padding:10px 20px;background:#000;color:#fff;border:none;">Go</button>
</form>
<?php foreach ($articles as $a): ?>
    <div class="card"><small style="color:#666;"><?= htmlspecialchars($a['category']) ?></small><h2><a href="article.php?id=<?= $a['id'] ?>"><?= htmlspecialchars($a['title']) ?></a></h2><small><?= $a['created_at'] ?></small></div>
<?php endforeach; ?>
<div style="margin-top:20px;">
    <?php if ($page > 1): ?><a href="?p=<?= $page-1 ?>&cat=<?= $cat ?>&q=<?= $q ?>">Prev</a> <?php endif; ?>
    Page <?= $page ?> of <?= max(1, $total_pages) ?>
    <?php if ($page < $total_pages): ?><a href="?p=<?= $page+1 ?>&cat=<?= $cat ?>&q=<?= $q ?>">Next</a> <?php endif; ?>
</div>
</body></html>
