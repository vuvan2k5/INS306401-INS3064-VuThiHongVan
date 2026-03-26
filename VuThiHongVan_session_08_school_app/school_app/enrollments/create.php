<?php
require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

$students = $db->fetchAll("SELECT * FROM students");
$courses = $db->fetchAll("SELECT * FROM courses");

$errors = [];
$student_id = '';
$course_id = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'] ?? '';
    $course_id = $_POST['course_id'] ?? '';

    if (!$student_id) {
        $errors['student'] = 'Chọn sinh viên';
    }

    if (!$course_id) {
        $errors['course'] = 'Chọn khóa học';
    }

    if (empty($errors)) {
        try {
            // Check trùng
            $check = $db->fetch(
                "SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?",
                [$student_id, $course_id]
            );

            if ($check) {
                $errors['general'] = 'Đã đăng ký rồi';
            } else {
                $db->insert('enrollments', [
                    'student_id' => $student_id,
                    'course_id' => $course_id
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
    <title>Đăng ký học</title>
</head>
<body>

<h1>Đăng ký học</h1>

<?php if (!empty($errors['general'])): ?>
    <p style="color:red"><?= $errors['general'] ?></p>
<?php endif; ?>

<form method="POST">

    <div>
        <label>Sinh viên:</label><br>
        <select name="student_id">
            <option value="">-- Chọn --</option>
            <?php foreach ($students as $s): ?>
                <option value="<?= $s['id'] ?>"
                    <?= $student_id == $s['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($s['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <span style="color:red"><?= $errors['student'] ?? '' ?></span>
    </div>

    <div>
        <label>Khóa học:</label><br>
        <select name="course_id">
            <option value="">-- Chọn --</option>
            <?php foreach ($courses as $c): ?>
                <option value="<?= $c['id'] ?>"
                    <?= $course_id == $c['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <span style="color:red"><?= $errors['course'] ?? '' ?></span>
    </div>

    <br>
    <button type="submit">Đăng ký</button>
    <a href="index.php">Quay lại</a>

</form>

</body>
</html>