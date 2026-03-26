<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$enrollments = $db->fetchAll("
    SELECT e.id, s.name, s.email, c.title, e.enrolled_at
    FROM enrollments e
    JOIN students s ON e.student_id = s.id
    JOIN courses c ON e.course_id = c.id
    ORDER BY e.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Danh sách đăng ký</title>
</head>
<body>

<h1>Danh sách đăng ký</h1>

<a href="create.php">+ Đăng ký học</a>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Sinh viên</th>
        <th>Email</th>
        <th>Khóa học</th>
        <th>Ngày đăng ký</th>
        <th>Hành động</th>
    </tr>

    <?php if (empty($enrollments)): ?>
        <tr>
            <td colspan="6">Chưa có đăng ký</td>
        </tr>
    <?php else: ?>
        <?php foreach ($enrollments as $e): ?>
            <tr>
                <td><?= $e['id'] ?></td>
                <td><?= htmlspecialchars($e['name']) ?></td>
                <td><?= htmlspecialchars($e['email']) ?></td>
                <td><?= htmlspecialchars($e['title']) ?></td>
                <td><?= $e['enrolled_at'] ?></td>
                <td>
                    <a href="delete.php?id=<?= $e['id'] ?>"
                       onclick="return confirm('Xóa đăng ký này?')">
                       Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

</table>

</body>
</html>