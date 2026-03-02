<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Submission</title>
</head>
<body>

<?php
$fullname = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$message = $_POST['message'] ?? '';

if (empty($fullname) || empty($email) || empty($phone) || empty($message)) {
    echo "<h3>Missing Data</h3>";
} else {
    echo "<h2>Received Data</h2>";
    echo "<ul>";
    echo "<li>Full Name: $fullname</li>";
    echo "<li>Email: $email</li>";
    echo "<li>Phone Number: $phone</li>";
    echo "<li>Message: $message</li>";
    echo "</ul>";
}
?>

</body>
</html>
