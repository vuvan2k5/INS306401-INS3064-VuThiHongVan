<?php
require_once __DIR__ . '/../classes/Database.php';

$errors = [];
$title = '';
$description = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($title === '') {
        $errors['title'] = 'Vui lòng nhập tiêu đề';
    }

    if (empty($errors)) {
        try {
            $db = Database::getInstance();

            $db->insert('courses', [
                'title' => $title,
                'description' => $description
            ]);

            header("Location: index.php");
            exit;

        } catch (Exception $e) {
            $errors['general'] = 'Có lỗi xảy ra';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thêm khóa học</title>
</head>
<body>

<h1>Thêm khóa học</h1>

<?php if (!empty($errors['general'])): ?>
    <p style="color:red"><?= $errors['general'] ?></p>
<?php endif; ?>

<form method="POST">

    <div>
        <label>Tiêu đề:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($title) ?>">
        <br>
        <span style="color:red"><?= $errors['title'] ?? '' ?></span>
    </div>

    <div>
        <label>Mô tả:</label><br>
        <textarea name="description"><?= htmlspecialchars($description) ?></textarea>
    </div>

    <br>
    <button type="submit">Lưu</button>
    <a href="index.php">Quay lại</a>

</form>

</body>
</html>