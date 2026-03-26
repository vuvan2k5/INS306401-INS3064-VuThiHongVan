<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$id = $_GET['id'] ?? 0;

if (!$id) {
    header("Location: index.php");
    exit;
}

$course = $db->fetch("SELECT * FROM courses WHERE id = ?", [$id]);

if (!$course) {
    die("Không tìm thấy khóa học");
}

$errors = [];
$title = $course['title'];
$description = $course['description'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($title === '') {
        $errors['title'] = 'Vui lòng nhập tiêu đề';
    }

    if (empty($errors)) {
        try {
            $db->update('courses', [
                'title' => $title,
                'description' => $description
            ], "id = ?", [$id]);

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
    <title>Sửa khóa học</title>
</head>
<body>

<h1>Sửa khóa học</h1>

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
    <button type="submit">Cập nhật</button>
    <a href="index.php">Quay lại</a>

</form>

</body>
</html>