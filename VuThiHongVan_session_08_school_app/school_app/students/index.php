<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

// Lấy dữ liệu từ DB
$students = $db->fetchAll("SELECT * FROM students ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sinh viên</title>
    <style>
        body { font-family: Arial; }

        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background: #4CAF50; color: white; }

        .btn-add {
            display: inline-block;
            margin-bottom: 10px;
            padding: 6px 10px;
            background: green;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn-edit {
            color: blue;
            text-decoration: none;
            margin-right: 5px;
        }

        .btn-delete {
            color: red;
            text-decoration: none;
        }
    </style>
</head>
<body>

<h1>Danh sách sinh viên</h1>

<a href="create.php" class="btn-add">+ Thêm sinh viên</a>

<table>
    <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Email</th>
        <th>Ngày tạo</th>
        <th>Hành động</th>
    </tr>

    <?php if (empty($students)): ?>
        <tr>
            <td colspan="5">Chưa có sinh viên</td>
        </tr>
    <?php else: ?>
        <?php foreach ($students as $s): ?>
            <tr>
                <td><?= $s['id'] ?></td>
                <td><?= htmlspecialchars($s['name']) ?></td>
                <td><?= htmlspecialchars($s['email']) ?></td>
                <td><?= $s['created_at'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $s['id'] ?>" class="btn-edit">Sửa</a>
                    <a href="delete.php?id=<?= $s['id'] ?>"
                       class="btn-delete"
                       onclick="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?')">
                        Xóa
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>

</table>

</body>
</html>