<?php
require 'db.php'; require 'auth.php';
if (isset($_GET['delete'])) { $db->prepare('DELETE FROM articles WHERE id = ?')->execute([(int)$_GET['delete']]); header('Location: admin.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['id'])) { $db->prepare('UPDATE articles SET title=?, content=?, category=? WHERE id=?')->execute([$_POST['title'], $_POST['content'], $_POST['category'], (int)$_POST['id']]); }
    else { $db->prepare('INSERT INTO articles (title, content, category) VALUES (?, ?, ?)')->execute([$_POST['title'], $_POST['content'], $_POST['category']]); }
    header('Location: admin.php'); exit;
}
$articles = $db->query('SELECT * FROM articles ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
$edit_article = null;
if (isset($_GET['edit'])) { $stmt = $db->prepare('SELECT * FROM articles WHERE id = ?'); $stmt->execute([(int)$_GET['edit']]); $edit_article = $stmt->fetch(PDO::FETCH_ASSOC); }
?>
<!DOCTYPE html><html><head><title>Admin</title><link rel="stylesheet" href="style.css"></head><body>
<h1><?= $edit_article ? 'Edit' : 'Publish' ?></h1>
<form method="POST">
    <?php if ($edit_article): ?><input type="hidden" name="id" value="<?= $edit_article['id'] ?>"><?php endif; ?>
    <input name="title" placeholder="Title" required value="<?= htmlspecialchars($edit_article['title'] ?? '') ?>" style="width:100%;padding:10px;margin-bottom:10px;box-sizing:border-box;">
    <select name="category" style="width:100%;padding:10px;margin-bottom:10px;box-sizing:border-box;">
        <option value="Politics" <?= ($edit_article['category'] ?? '') == 'Politics' ? 'selected' : '' ?>>Politics</option>
        <option value="Tech" <?= ($edit_article['category'] ?? '') == 'Tech' ? 'selected' : '' ?>>Tech</option>
        <option value="General" <?= ($edit_article['category'] ?? '') == 'General' ? 'selected' : '' ?>>General</option>
    </select>
    <textarea name="content" placeholder="Content" required style="width:100%;height:200px;padding:10px;box-sizing:border-box;"><?= htmlspecialchars($edit_article['content'] ?? '') ?></textarea>
    <button type="submit" style="padding:10px 20px;background:#000;color:#fff;border:none;"><?= $edit_article ? 'Update' : 'Publish' ?></button>
    <?php if ($edit_article): ?> <a href="admin.php">Cancel</a> <?php endif; ?>
</form>
<h2>Manage</h2>
<?php foreach ($articles as $a): ?>
    <p>[<?= htmlspecialchars($a['category']) ?>] <?= htmlspecialchars($a['title']) ?> <a href="?edit=<?= $a['id'] ?>">[Edit]</a> <a href="?delete=<?= $a['id'] ?>" style="color:red;">[Delete]</a></p>
<?php endforeach; ?>
</body></html>
