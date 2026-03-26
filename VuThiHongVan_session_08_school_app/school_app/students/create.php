<?php
require_once __DIR__ . '/../classes/Database.php';

$errors = [];
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    // Validate
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
            $db = Database::getInstance();

            // Check trùng email
            $check = $db->fetch("SELECT id FROM students WHERE email = ?", [$email]);

            if ($check) {
                $errors['email'] = 'Email đã tồn tại';
            } else {
                $db->insert('students', [
                    'name' => $name,
                    'email' => $email
                ]);

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
    <title>Thêm sinh viên</title>
</head>
<body>

<h1>Thêm sinh viên</h1>

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
    <button type="submit">Lưu</button>
    <a href="index.php">Quay lại</a>

</form>

</body>
</html>