<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$id = $_GET['id'] ?? 0;

if (!$id) {
    header("Location: index.php");
    exit;
}

$errors = [];

// Lấy dữ liệu cũ
$student = $db->fetch("SELECT * FROM students WHERE id = ?", [$id]);

if (!$student) {
    die("Không tìm thấy sinh viên");
}

$name = $student['name'];
$email = $student['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name === '') {
        $errors['name'] = 'Vui lòng nhập tên';
    }

    if ($email === '') {
        $errors['email'] = 'Vui lòng nhập email';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ';
    }

    if (empty($errors)) {
        try {
            // Check trùng email (trừ chính nó)
            $check = $db->fetch(
                "SELECT id FROM students WHERE email = ? AND id != ?",
                [$email, $id]
            );

            if ($check) {
                $errors['email'] = 'Email đã tồn tại';
            } else {
                $db->update('students', [
                    'name' => $name,
                    'email' => $email
                ], "id = ?", [$id]);

                header("Location: index.php");
                exit;
            }

        } catch (Exception $e) {
            $errors['general'] = 'Có lỗi xảy ra';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sửa sinh viên</title>
</head>
<body>

<h1>Sửa sinh viên</h1>

<?php if (!empty($errors['general'])): ?>
    <p style="color:red"><?= $errors['general'] ?></p>
<?php endif; ?>

<form method="POST">

    <div>
        <label>Tên:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>">
        <br>
        <span style="color:red"><?= $errors['name'] ?? '' ?></span>
    </div>

    <div>
        <label>Email:</label><br>
        <input type="text" name="email" value="<?= htmlspecialchars($email) ?>">
        <br>
        <span style="color:red"><?= $errors['email'] ?? '' ?></span>
    </div>

    <br>
    <button type="submit">Cập nhật</button>
    <a href="index.php">Quay lại</a>

</form>

</body>
</html>