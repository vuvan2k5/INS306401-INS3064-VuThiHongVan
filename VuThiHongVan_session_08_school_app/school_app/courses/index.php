<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$courses = $db->fetchAll("SELECT * FROM courses ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Danh sách khóa học</title>
</head>
<body>

<h1>Danh sách khóa học</h1>

<a href="create.php">+ Thêm khóa học</a>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Tiêu đề</th>
        <th>Mô tả</th>
        <th>Ngày tạo</th>
        <th>Hành động</th>
    </tr>

    <?php if (empty($courses)): ?>
        <tr>
            <td colspan="5">Chưa có khóa học</td>
        </tr>
    <?php else: ?>
        <?php foreach ($courses as $c): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['title']) ?></td>
                <td><?= htmlspecialchars($c['description']) ?></td>
                <td><?= $c['created_at'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $c['id'] ?>">Sửa</a>
                    <a href="delete.php?id=<?= $c['id'] ?>"
                       onclick="return confirm('Xóa khóa học này?')">
                       Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

</table>

</body>
</html>